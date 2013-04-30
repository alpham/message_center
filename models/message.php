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
        $this -> setID($id);
        // require 'controllers/error.php';
    }

    /*
     * prepareQuery($place,$messageID)
     *  ** return query that retrieve a table of complete information about the $messageID in $place
     * wrote to simplify messages view in $place
     * */

    private function prepareQuery($place, $messageID) {
        $place = $this -> quote($place);
        $userID = $this -> quote(USER_ID);
        $msgID = $this -> quote($messageID);
        $page = isset($_GET['page']) ? $_GET['page'] - 1 : 0;
        $pre = $page * MESSAGES_PER_PAGE;
        $next = MESSAGES_PER_PAGE;
        $message_conditon = $messageID > 0 ? "AND messages.id = " . $this -> quote($messageID) : "";
        $sSQL = 'SET CHARACTER utf8';
        $this -> exec($sSQL);
        $query = "SELECT DISTINCT messages.* , users.username AS sender_name FROM messages JOIN users JOIN receivers_users ON ((users.id = " . $userID . "  AND receivers_users.list_id = messages.receiver AND receivers_users.user_id = users.id AND receivers_users.message_place=" . $place . " " . $message_conditon . ") OR (users.id = " . $userID . " AND messages.sender_place = " . $place . " AND messages.sender = users.id " . $message_conditon . ")) ORDER BY messages.time DESC LIMIT " . $pre . " , " . $next . "; ";
        return $query;
    }

    /*
     * prepareQueryGlobal($messageID)
     *  ** prepare query for retrieving messages joint to users table and receivers users table
     * without constraints on the place the user put the messages in.
     */

    private function prepareQueryGlobal($messageID) {
        $userID = $this -> quote(USER_ID);
        $msgID = $messageID;
        $page = isset($_GET['page']) ? $_GET['page'] - 1 : 0;
        $pre = $page * MESSAGES_PER_PAGE;
        $next = MESSAGES_PER_PAGE;
        $message_conditon = $messageID > 0 ? "AND messages.id = " . $messageID : "";
        $this -> exec("SET CHARACTER SET utf8");
        $query = "SELECT DISTINCT messages.* , users.username AS sender_name FROM messages JOIN users JOIN receivers_users ON ((users.id = " . $userID . " AND receivers_users.user_id = users.id  AND receivers_users.list_id = messages.receiver " . $message_conditon . ") OR (users.id = " . $userID . " AND messages.sender = users.id " . $message_conditon . ")) ORDER BY messages.time DESC LIMIT " . $pre . " , " . $next . "; ";
        return $query;
    }

    /*
     * count(place)
     *  ** return number of the messages in $place
     * basically  wrote for the pagination.
     */
    public function count($place) {
        $place = $this -> quote($place);
        $userID = $this -> quote(USER_ID);
        $query = "SELECT COUNT(DISTINCT messages.id) FROM messages JOIN users JOIN receivers_users ON ((users.id = " . $userID . "  AND receivers_users.user_id = users.id AND receivers_users.list_id = messages.receiver AND receivers_users.message_place=" . $place . ") OR (users.id = " . $userID . " AND messages.sender_place = " . $place . " AND messages.sender = users.id )); ";
        $sSQL = 'SET CHARACTER utf8';
        $this -> exec($sSQL);
        $result = $this -> query($query);
        return $result -> fetchColumn();
    }


    /*
     * getInbox($messageID = 0)
     *  **  return the user's inbox table (2D array) in the case that $messageID = 0
     * or return the inbox message with the ID = $messageID if ($messageID > 0)
     * 
     * */

    public function getInbox($messageID = 0) {
        $query = $this -> prepareQuery("inbox", $messageID);
        return $this -> getResult($query);
    }

    /*
     * getSentbox($messageID = 0)
     *  **  return the user's sentbox table (2D array) in the case that $messageID = 0
     * or return the sentbox message with the ID = $messageID if ($messageID > 0)
     *
     * */

    public function getSentbox($messageID = 0) {
        $query = $this -> prepareQuery("sentbox", $messageID);
        return $this -> getResult($query);
    }

    /*
     * getTrash($messageID = 0)
     *  **  return the user's trash table (2D array) in the case that $messageID = 0
     * or return the message in trash with the ID = $messageID if ($messageID > 0)
     *
     * */

    public function getTrash($messageID = 0) {
        $query = $this -> prepareQuery("trash", $messageID);
        return $this -> getResult($query);
    }

    /*
     * err($errNo,$details = '')
     *  **  generate an Error instance of id = $errNo and detailed with $details
     *
     * */

    public function err($errNo, $details = '') {
        require_once 'controllers/error.php';
        $err = new Error($errNo, $details);
    }

    /*
     * send($message)
     *  **  sends the $message where $message is an array of message details
     * first prepare $message['to'] into an array of receives users
     * then make sure that all users in the array are registered else generate an error and return false
     * second insert a new receivers_list with the ID's of users in the receivers array ($to)
     * get the ID of the last inserted list
     *      >> insert a new message with sender = USER_ID (const of the current active user).
     *                                   receivers = last inserted receivers_list.id
     *                                   time = CURRENT_TIMESTAMP
     *                                   receivers_list = $message['to']
     *                                   subject = $message['subject']
     *                                   body = $message['body']
     *                                   sencer_place = "sentbox" by default
     *
     * */

    public function send($message) {
        /*
         convert $to string into valid array
         */
        $to = $message['to'];
        $to = rtrim($to, ",");
        $to = ltrim($to, ",");
        $to = trim($to);

        $to = strpos($to, ",") !== FALSE ? explode(",", $to) : $to = array($to);

        //check existance of all users who will receive the message
        foreach ($to as $key => $value) {
            $sSQL = 'SET CHARACTER utf8';
            $this -> exec($sSQL);
            $stm = $this -> query("select count(*) from users where `username` = " . $this -> quote($value));
            if (!$stm -> fetchColumn() == 1) {
                $this -> err(3, "no user '" . $value . "' is registered in the system.");
                return FALSE;
            }
        }

        $from = $this -> quote($message['from']);
        $subject = $this -> quote($message['subject']);
        $body = $this -> quote($message['body']);

        /*
         * insert new receivers list
         * add receiving user/s to the new list
         * insert message from (sender) to (receivers list)
         * */
        $sSQL = 'SET CHARACTER utf8';
        $this -> exec($sSQL);
        $insertIntoreceiverList = $this -> exec("INSERT INTO `receivers_list`(`sender_id`) VALUES (" . $from . ")");
        if ($insertIntoreceiverList == 0) {
            $this -> err(5, " Erorr while inserting the receivers_list.");
            return FALSE;
        }

        $listID = $this -> lastInsertId();

        $sum = $this -> setReceiversUsers($to, $listID);

        $sSQL = 'SET CHARACTER utf8';
        $this -> exec($sSQL);
        $insertIntoMessages = $this -> exec("INSERT INTO `messages`( `subject`, `body`, `sender`, `receiver`, `receivers_list`)" . " VALUES (" . $subject . "," . $body . "," . $from . "," . $listID . "," . $this -> quote($message['to']) . ")");
        if ($insertIntoMessages == 1) {
            $this -> setID($this -> lastInsertId());
            return TRUE;
        } else {
            $this -> err(5, " Error while sending the message.");
            return FALSE;
        }
    }

    /*
     * delete($userID)
     * *if the user received the message (i.e. the messages(place) = inbox )
     *  then delete user_id from received_list_users table
     *  **if the list is empty (i.e. no users in it)
     *    Delete the list_id from receivers_list
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
        if (isset($this -> msgID)) {
            /*
             * if_condition(1)
             *  ** if the user requested to delete the message is the sender.
             * */
            if ($userId == $this -> senderOf($this -> msgID)) {
                $sSQL = 'SET CHARACTER utf8';
                $this -> exec($sSQL);
                $count = $this -> exec("UPDATE `messages` SET `sender_place`= 'deleted' WHERE `id` = " . $this -> quote($this -> msgID));
                if (!empty($count) && $count >= 0) {
                    // return TRUE;
                } else {
                    // require 'controllers/error.php';
                    $this -> err(5, " in class Message::delete() if_condition(1)");
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
                        $count = $this -> exec("DELETE FROM `receivers_users` WHERE `user_id` = " . $this -> quote($userId));
                        if (!empty($count) && $count >= 0) {
                            // return TRUE;
                        } else {
                            // require 'controllers/error.php';
                            $this -> err(5, " in class Message::delete() if_condition(2)");
                            return FALSE;
                        }
                    }

                }
                /*
                 *  if the receivers list is empty
                 *      then delete the list :)
                 */

                if ($this -> receiverIsEmpty($this -> msgID)) {
                    $sSQL = 'SET CHARACTER utf8';
                    $this -> exec($sSQL);
                    $receivers_list = $this -> query("SELECT receiver FROM messages WHERE id = " . $this -> quote("$this->msgID"));
                    $receivers_list = $receivers_list -> fetchColumn();
                    $this -> exec("SET foreign_key_checks = 0 ;");
                    $stm = $this -> exec("DELETE FROM receivers_list WHERE id = " . $this -> quote($receivers_list));
                    $this -> exec("SET foreign_key_checks = 1 ;");
                    if ($stm == 0) {
                        $this -> err(5, "error while deleting the `receivers_list` of the message of id = " . $this -> msgID . ".");
                        return FALSE;
                    }
                    $this -> exec("SET foreign_key_checks = 0 ;");
                    $setListNULL = $this -> exec("UPDATE messages SET receiver = NULL WHERE id = " . $this -> quote($this -> msgID));
                    $this -> exec("SET foreign_key_checks = 1 ;");
                    if ($setListNULL == 0) {
                        $this -> err(5, "Error while setting receive_list_id in MESSEAGES to null.");
                        return FALSE;
                    }
                    // return TRUE;
                }
            }
            /*
             * if the message is deleted by all users (receivers and sender)
             *      delete the message from the table.
             */
            if ($this -> isDeletedByAll()) {
                $stm = $this -> exec("DELETE FROM messages WHERE id = " . $this -> quote($this -> msgID));
                if ($stm == 0) {
                    $this -> err(5, "cannot delete a message which is deleted by all.");
                    return FALSE;
                }

            }
            // if all is done with no errors : then
            return TRUE;
        } else {
            $this -> err(7, "DELETE");
        }
    }

    public function senderOf($messageId) {
        $msgId = $this -> quote($messageId);
        $result = $this -> query("SELECT sender FROM messages WHERE id = " . $msgId);
        $sender = $result -> fetchColumn();
        return $sender;
    }

    public function senderNameOf($messageID) {
        $userID = $this -> senderOf($messageID);
        $userID = $this -> quote($userID);
        $result = $this -> query("SELECT username FROM users WHERE id = " . $userID);
        $senderName = $result -> fetchColumn();
        return $senderName;
    }

    public function receiversOf($messageId) {
        $list_id = $this -> query("SELECT receiver FROM messages WHERE id = " . $this -> quote($messageId));
        $list_id = $list_id -> fetchColumn();
        // echo $list_id . "<p>";
        $result = $this -> query("SELECT user_id FROM receivers_users WHERE list_id = " . $this -> quote($list_id));
        $result = $result -> fetchAll();
        return $result;
        // 2D array .. a table :)
    }

    public function getID() {
        if (isset($this -> msgID)) {
            return $this -> msgID;
        } else {
            return 0;
        }

    }

    public function setID($id) {
        if ($id > 0) {
            $this -> msgID = $id;
        }

    }

    public function receiverIsEmpty($messageId) {
        $stm = $this -> query("SELECT receiver FROM messages WHERE id = " . $this -> quote($messageId));
        $list_ID = $stm -> fetchColumn();
        $stm = $this -> query("SELECT COUNT(*) FROM receivers_users WHERE list_id = " . $this -> quote($list_ID));
        $result = $stm -> fetchColumn();
        if ($result == 0) {
            return TRUE;
        } else {
            return FALSE;
        }

    }

    /*
     * isDeletedByAll()
     *  **  return true if the message place for ALL receivers and the sender is 'deleted'
     *
     * */
    public function isDeletedByAll() {
        if ($this -> receiverIsEmpty($this -> msgID)) {
            // check if the message is deleted by the sender
            return $this -> isDeletedBysender();

        }

    }

    /*
     * isDeletedBysender()
     *  **  return true if the messages.sender_place column of the message = 'deleted'
     * else return flase
     *
     * */

    public function isDeletedBysender() {
        $stm = $this -> query("SELECT sender_place FROM messages WHERE id = " . $this -> quote($this -> msgID));
        $result = $stm -> fetchColumn();
        if ($result == 'deleted') {
            return TRUE;
        } else {
            return FALSE;

        }

    }

    /*
     * setReceiversUsers($users,$list)
     *  **
     *
     * */

    private function setReceiversUsers($users, $list) {
        $sum = 0;
        foreach ($users as $key => $value) {
            $id = $this -> query("SELECT id FROM users WHERE username = " . $this -> quote($value));
            $id = $id -> fetchColumn();
            $sSQL = 'SET CHARACTER utf8';
            $this -> exec($sSQL);
            $sum += $this -> exec("INSERT INTO `receivers_users` (`list_id`, `user_id`) VALUES (" . $this -> quote($list) . "," . $this -> quote($id) . ")");
        }
        return $sum;
    }

    public function getMessageById($id = 0) {
        if (!$id > 0) {
            $id = $this -> quote($this -> msgID);
        } else {
            $id = $this -> quote($id);
        }
        $query = $this -> prepareQueryGlobal($id);
        $result = $this -> query($query);
        return $result -> fetchAll();

    }

    public function search() {
        $q = isset($_GET['q']) ? $_GET['q'] : NULL;
        $q = $this -> quote("%" . $q . "%");
        $userID = $this -> quote(USER_ID);
        $page = isset($_GET['page']) ? $_GET['page'] - 1 : 0;
        $pre = $page * MESSAGES_PER_PAGE;
        $next = MESSAGES_PER_PAGE;
        $message_conditon = (isset($q) && !empty($q)) ? "AND messages.subject LIKE " . $q . " OR messages.body LIKE " . $q : "";
        $query = "SELECT DISTINCT messages.* ,receivers_users.message_place  FROM messages JOIN users JOIN receivers_users ON ((users.id = " . $userID . " AND receivers_users.user_id = users.id AND receivers_users.list_id = messages.receiver " . $message_conditon . ") OR (users.id = " . $userID . " AND messages.sender = users.id " . $message_conditon . ")) ORDER BY messages.time DESC LIMIT " . $pre . " , " . $next . "; ";
        // echo $query;
        $sSQL = 'SET CHARACTER utf8';
        $this -> exec($sSQL);
        $result = $this -> query($query);
        return $result -> fetchAll();
    }

    public function countSearch() {
        $q = isset($_GET['q']) ? $_GET['q'] : NULL;
        $q = $this -> quote("%" . $q . "%");
        $userID = $this -> quote(USER_ID);
        $page = isset($_GET['page']) ? $_GET['page'] - 1 : 0;
        $pre = $page * MESSAGES_PER_PAGE;
        $next = MESSAGES_PER_PAGE;
        $message_conditon = (isset($q) && !empty($q)) ? "AND messages.subject LIKE " . $q . " OR messages.body LIKE " . $q : "";
        $query = "SELECT COUNT(DISTINCT messages.id) FROM messages JOIN users JOIN receivers_users ON ((users.id = " . $userID . " AND receivers_users.user_id = users.id AND receivers_users.list_id = messages.receiver " . $message_conditon . ") OR (users.id = " . $userID . " AND messages.sender = users.id " . $message_conditon . ")) ORDER BY messages.time DESC ; ";
        $result = $this -> query($query);
        return $result -> fetchColumn();

    }

}
?>