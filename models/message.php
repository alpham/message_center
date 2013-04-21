<?php

/**
 * Message class
 *  * aims to describe the message as an sub-object (component) of the system
 *
 */
class Message extends Model {

    private $messageTable = "messages";

    function __construct($id = 0) {
        parent::__construct();
        if ($id > 0) {
            $this -> msgID = $id;
        }

    }

    public function getInbox() {
        $this -> setTable($this -> messageTable);
        $this -> setCondition("place = 'inbox'");
        return $this -> getResult();
    }

    public function getSentbox() {
        $this -> setTable($this -> messageTable);
        $this -> setCondition("place = 'sentbox'");
        return $this -> getResult();
    }

    public function getTrash() {
        $this -> setTable($this -> messageTable);
        $this -> setCondition("place = 'trash'");
        return $this -> getResult();
    }

    public function send($message) {
        /*
         convert $to string into valid array
         */
        $to = $message['to'];
        $to = rtrim($to, ",");
        $to = trim($to);
        $to = explode(",", $to);
        //check existance of all users who will recieve the messaage
        foreach ($to as $key => $value) {
            $stm = $this -> query("select count(*) from users where `username` = " . $this -> quote($value));
            if (!$stm -> fetchColumn() == 1) {
                $err = new Error(3);
                return FALSE;
            }
        }
        $db = new Database();

        $from = $db -> quote($message['from']);
        $to = $db -> quote($message['to']);
        $subject = $db -> quote($message['subject']);
        $body = $db -> quote($message['body']);
        // $time = $db->quote($message['time']);

        /*
         * insert new receivers list
         * add receiving user/s to the new list
         * insert message from (sender) to (receivers list)
         * */
        $insertIntoRecieverList = $db -> exec("INSERT INTO `recievers_list`(`sender_id`) VALUES (" . $from . ")");
        //        $insertIntoRecieverList->execute();
        $listID = $db -> lastInsertId();
        $listID = $db -> quote($listID);

        foreach ($to as $key => $value) {
            $insertIntoRecieverUsers = $db -> exec("INSERT INTO `recievers_list_users`(`list_id`, `user_id`) VALUES (" . $listID . ",'" . $value . "')");
        }

        $insertIntoMessages = $db -> exec("INSERT INTO `messages`( `subject`, `body`, `sender`, `receiver`, `recievers_list`)" . " VALUES (" . $subject . "," . $body . "," . $from . "," . $listID . "," . $message['to'] . ")");
    }

    /*
     * delete function
     * *if the user received the message (i.e. the messages(place) = inbox )
     *  then delete user_id from received_list_users table
     *  **if the list is empty (i.e. no users in it)
     *    Delete the list_id from recievers_list
     *    AND set list_id column in messages table to NULL
     *
     * *if the user sent the messages requests to delete it
     *  then set sender_place column in the messages table to deleted
     *
     * *if (in messages table) sender_place == "deleted" && receiver == NULL
     *  then delete the message from the table
     *
     * */

    public function delete($userId /*requested from user_id*/) {

        /*
         * if_condition(1)
         *  ** if the user requested to delete the message is the sender.
         * */
        if ($userId == $this -> senderOf($this -> msgID)) {
            $count = $this -> exec("UPDATE `messages` SET `sender_place`= 'deleted' WHERE `id` = " . $this -> quote($this -> msgID));
            if (!empty($count) && $count >= 0) {
                return TRUE;
            } else {
                require 'controllers/error.php';
                $err = new Error(5, " in class Message::delete() if_condition(1)");
                return FALSE;
            }
        } else {
            /*
             * if_condition(2)
             *  ** if the user requested to delete the message is the one of the receivers.
             * */

            $result = $this -> receiversOf($this -> msgID);
            foreach ($result as $key => $subArray) {
                if (in_array($userId, $subArray)) {
                    $count = $this -> exec("DELETE FROM `recievers_list_users` WHERE `user_id` = " . $this -> quote($userId));
                    if (!empty($count) && $count >= 0) {
                        return TRUE;
                    } else {
                        require 'controllers/error.php';
                        $err = new Error(5, " in class Message::delete() if_condition(2)");
                        return FALSE;
                    }
                }

            }
            if($this->receiverIsEmpty($this->msgID)){
                
            }
        }
    }

    public function senderOf($messageId) {
        $messageId = isset($this -> msgID -> messageId) ? $this -> msgID -> messageId : self::$$messageId;
        $msgId = $this -> quote($messageId);
        $result = $this -> query("SELECT sender FROM messages WHERE id = " . $msgId);
        $sender = $result -> fetchColumn();
        return $sender;
    }

    public function receiversOf($messageId) {
        $list_id = $db -> query("SELECT receiver FROM messages WHERE id = " . $db -> quote($messageId));
        $list_id = $list_id -> fetchColumn();
        // echo $list_id . "<p>";
        $result = $db -> query("SELECT user_id FROM recievers_list_users WHERE list_id = " . $db -> quote($list_id));
        $result = $result -> fetchAll();
        return $result;
    }

    public function getID() {
        return $this -> msgID;

    }

    public function setID($id) {
        $this -> msgID = $id;

    }

    public function receiverIsEmpty($messageId) {
        $stm = $db -> query("SELECT receiver FROM messages WHERE id = " . $db -> quote($messageId));
        $list_ID = $stm -> fetchColumn();
        $stm = $db -> query("SELECT COUNT(*) FROM recievers_list_users WHERE list_id = " . $db -> quote($list_ID));
        $result = $stm -> fetchColumn();
        if ($result == 0) {
            return TRUE;
        } else {
            return FALSE;
        }

    }

}
?>