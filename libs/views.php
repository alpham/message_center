<?php

/**
 * View
 *  * letr's controle some views
 */
class View {

    function __construct() {
        $theme = $this->getTheme() ? "views/" . $this->getTheme() . "/" : NULL;
        if (!defined("THEME_FOLDER")) {
            define("THEME_FOLDER", $theme);
        }
    }

    /*
      public function render($page) {
      $file = 'views/' . $page . '.php';
      if (file_exists($file)) {
      require $file;
      } else {
      $error = new Error(2);
      }
      } */

    private function prepareEmotions($messageBody) {
        //      (y) O:) 3:) :'( =D :P :o ;) :) >:( :/ 
        if (THEME_FOLDER) {
            if (!defined("EMOTIONS")) {
                define("EMOTIONS", ABSOLUTE_PATH . "public/emotions/");
            }
            $file = THEME_FOLDER . "mail/components/emotions.php";
            $file = file_get_contents($file);
            $emo = str_replace("%emotion_icon%", EMOTIONS . "smile.png", $file);
            $mod_message = str_replace(" :) ", " " . $emo . " ", " " . $messageBody . " ");
            $emo = str_replace("%emotion_icon%", EMOTIONS . "happy.png", $file);
            $mod_message = str_replace(" =D ", " " . $emo . " ", $mod_message);
            $mod_message = str_replace(" :D ", " " . $emo . " ", $mod_message);
            $emo = str_replace("%emotion_icon%", EMOTIONS . "unhappy.png", $file);
            $mod_message = str_replace(" :( ", " " . $emo . " ", $mod_message);
            $emo = str_replace("%emotion_icon%", EMOTIONS . "too_sad.png", $file);
            $mod_message = str_replace(" :'( ", " " . $emo . " ", $mod_message);
            $emo = str_replace("%emotion_icon%", EMOTIONS . "wink.png", $file);
            $mod_message = str_replace(" ;) ", " " . $emo . " ", $mod_message);
            $emo = str_replace("%emotion_icon%", EMOTIONS . "tongue.png", $file);
            $mod_message = str_replace(" :P ", " " . $emo . " ", $mod_message);
            $mod_message = str_replace(" :p ", " " . $emo . " ", $mod_message);
            $emo = str_replace("%emotion_icon%", EMOTIONS . "suprised.png", $file);
            $mod_message = str_replace(" :O ", " " . $emo . " ", $mod_message);
            $mod_message = str_replace(" :o ", " " . $emo . " ", $mod_message);
            $emo = str_replace("%emotion_icon%", EMOTIONS . "angel.png", $file);
            $mod_message = str_replace(" O:) ", " " . $emo . " ", $mod_message);
            $mod_message = str_replace(" o:) ", " " . $emo . " ", $mod_message);
            $emo = str_replace("%emotion_icon%", EMOTIONS . "devil.png", $file);
            $mod_message = str_replace(" 3:) ", " " . $emo . " ", $mod_message);


            return $mod_message;
        }
    }

    public function renderHeader() {
        if (THEME_FOLDER) {
            $file = THEME_FOLDER . 'header.php';
            if (file_exists($file)) {
                require $file;
            } else {
                $err = new Error(2);
            }
        }
    }

    public function renderSidebar() {
        if (THEME_FOLDER) {
            $file = THEME_FOLDER . 'sidebar.php';
            if (file_exists($file)) {
                require $file;
            } else {
                $err = new Error(2);
            }
        }
    }

    public function renderFooter() {
        if (THEME_FOLDER) {
            $file = THEME_FOLDER . 'footer.php';
            if (file_exists($file)) {
                require $file;
            } else {
                $err = new Error(2);
            }
        }
    }

    public function renderPage($name, $noInclude = False) {
        if (THEME_FOLDER) {
            if ($noInclude == FALSE) {
                $file = THEME_FOLDER . $name . '.php';
                if (file_exists($file)) {
                    $this->renderHeader();
                    $this->renderSidebar();
                    require $file;
                    $this->renderFooter();
                } else {
                    $err = new Error(2, "file '" . $file . "' not found!");
                    return FALSE;
                }
            } else {
                $file = THEME_FOLDER . $name . '.php';
                if (file_exists($file)) {
                    // $this->renderHeader();
                    require $file;
                    // $this->renderFooter();
                } else {
                    $err = new Error(2, "file '" . $file . "' not found!");
                }
            }
        }
    }

    public function renderError() {
        if (THEME_FOLDER) {
            $this->renderHeader();
            $this->renderSidebar();
            $this->renderPage("mail/inbox", TRUE);
            $this->renderPage("error/error", TRUE);
            $this->renderFooter();
        }
    }

    public function setActive($page) {
        if (isset($this->page)) {
            if ($this->page == $page) {
                echo "active";
            }
        }
    }

    public function renderView($name, $noInclude = False) {
        $file = "views/" . $name . '.php';
        if ($noInclude == FALSE) {
            if (file_exists($file)) {
                $this->renderHeader();
                $this->renderSidebar();
                require $file;
                $this->renderFooter();
            } else {
                $err = new Error(2, "file '" . $file . "' not found!");
                return FALSE;
            }
        } else {

            if (file_exists($file)) {
                // $this->renderHeader();
                require $file;
                // $this->renderFooter();
            } else {
                $err = new Error(2, "file '" . $file . "' not found!");
            }
        }
    }

    public function getTheme() {
        $db = new Database();
        $userID = defined("USER_ID") ? USER_ID : 0;
        $query = "SELECT theme FROM settings WHERE user_id = " . $userID;
        $result = $db->query($query);
        return !empty($result) ? $result->fetchColumn() : NULL;
    }

    public function getMessagesOf($cat) {
        if (THEME_FOLDER) {
            require_once 'models/message.php';
            $message = new Message();
            $url = prepareURL($_GET);
            $count = $message->count($cat);
            $place_alt = $count != 0 ? "" : file_get_contents(ABSOLUTE_PATH . "config/" . $cat . "_alt.php");
            $messageID = isset($url['2']) ? $url['2'] : 0;
            if (!$messageID > 0) {
                $style = file_get_contents(THEME_FOLDER . "mail/components/table-cells.php");
                $table = file_get_contents(THEME_FOLDER . "mail/components/table.php");
                $msg = $message->{"get" . $cat}();
                $message_table = $table;
                foreach ($msg as $key => $value) {
                    $message_view = "";
                    $modified_table = $message_table;
                    foreach ($value as $key1 => $val) {
                        $msg[$key]['sender_name'] = $message->senderNameOf($msg[$key]['id']);
                        $message_view = str_replace("%body%", substr($msg[$key]['body'], 0, 200) . "...", $style);
                        $message_view = str_replace("%time%", $msg[$key]['time'], $message_view);
                        $message_view = str_replace("%subject%", $msg[$key]['subject'], $message_view);
                        $message_view = str_replace("%sender%", $msg[$key]['sender_name'], $message_view);
                        $message_view = str_replace("%receives_list%", $msg[$key]['receivers_list'], $message_view);
                        $message_view = str_replace("%view_message_url%", ABSOLUTE_PATH . "mail/" . $cat . "/" . $msg[$key]['id'], $message_view);
                    }

                    $message_table = str_replace("%message_cells%", $message_view . " %message_cells% ", $modified_table);
                }
                $message_table = str_replace(" %message_cells% ", "", $message_table);
                $message_table = $count != 0 ? str_replace(" %message_cells% ", "", $message_table) : str_replace("%message_cells%", $place_alt, $message_table);
                echo $message_table;
            } else {
                $style = file_get_contents(THEME_FOLDER . "mail/components/message.php");
                $msg = $message->{"get" . $cat}($messageID);
                foreach ($msg as $key => $value) {
                    $message_view = "";
                    foreach ($value as $key1 => $val) {
                        $message_view = str_replace("%body%", $this->prepareEmotions($this->prepareEmotions($msg[$key]['body'])), $style);
                        $message_view = str_replace("%time%", $msg[$key]['time'], $message_view);
                        $message_view = str_replace("%subject%", $msg[$key]['subject'], $message_view);
                        $message_view = str_replace("%sender%", $msg[$key]['sender_name'], $message_view);
                        $message_view = str_replace("%view_message_url%", ABSOLUTE_PATH . "mail/" . $cat . "/" . $msg[$key]['id'], $message_view);
                    }
                    echo $message_view;
                }
            }
        }
    }

    public function loadPagination($page = 0) {
        if (THEME_FOLDER) {
            require_once 'models/message.php';
            $msg = new Message();
            $url = prepareURL($_GET);
            $count = isset($url['1']) ? $msg->count($url['1']) : 0;
            $count = $count % MESSAGES_PER_PAGE != 0 ? ($count / MESSAGES_PER_PAGE) + 1 : ($count / MESSAGES_PER_PAGE);
            if (!isset($url['2'])) {
                if ($count > 1) {
                    $elements = file_get_contents(THEME_FOLDER . "mail/components/pagination-elements.php");
                    $pagination = file_get_contents(THEME_FOLDER . "mail/components/pagination.php");
                    $pagination_next = file_get_contents(THEME_FOLDER . "mail/components/pagination-next.php");
                    $pagination_prev = file_get_contents(THEME_FOLDER . "mail/components/pagination-prev.php");
                    $start = 0;
                    $end = 0;
                    if ($page < 5) {
                        $end = 9 <= $count ? 9 : $count;
                        $start = 1;
                    } else {
                        $end = ($page + 4) <= $count ? ($page + 4) : $count;
                        $start = $page - 4;
                    }
                    $pagination_style = $pagination;
                    $i = $start;
                    $pagination_style = ($page - 1) >= $start ? str_replace("%page_index%", str_replace("%prev_page%", "?page=" . ($page - 1), $pagination_prev) . " %page_index% ", $pagination_style) : $pagination_style;
                    while ($i <= $end) {
                        $pagination_view = "";
                        $modified_view = $pagination_style;
                        $pagination_view = str_replace("%page_number%", $i, $elements);
                        $pagination_view = str_replace("%page_url%", "?page=" . $i, $pagination_view);
                        $pagination_style = str_replace("%page_index%", $pagination_view . " %page_index% ", $modified_view);
                        $i++;
                    }

                    $pagination_style = ($page + 1) <= $end ? str_replace("%page_index%", str_replace("%next_page%", "?page=" . ($page + 1), $pagination_next), $pagination_style) : $pagination_style;
                    $pagination_style = str_replace(" %page_index% ", "", $pagination_style);
                    echo $pagination_style;
                }
            }
        }
    }

    public function loadSearch() {
        if (THEME_FOLDER) {
            require_once 'models/message.php';
            $message = new Message();
            $url = prepareURL($_GET);
            $messageID = isset($url['2']) ? $url['2'] : 0;
            $count = $message->countSearch();
            $info = file_get_contents(THEME_FOLDER . "mail/components/count.php");
            $info = str_replace("%count_info%", $count . " results found ", $info);
            echo $info;
            $search_alt = $count != 0 ? "" : file_get_contents(ABSOLUTE_PATH . "config/serarch_alt.php");
            if (!$messageID > 0) {
                $msg = $message->search();
                $style = file_get_contents(THEME_FOLDER . "mail/components/table-cells.php");
                $table = file_get_contents(THEME_FOLDER . "mail/components/table.php");
                $message_table = $table;
                /*
                  echo "hi there <br />";
                  echo "<pre>";print_r($msg);echo "</pre>"; */

                foreach ($msg as $key => $value) {
                    $message_view = "";
                    $modified_table = $message_table;
                    foreach ($value as $key1 => $val) {
                        $msg[$key]['sender_name'] = $message->senderNameOf($msg[$key]['id']);
                        $message_place = (USER_ID == $msg[$key]['sender']) ? $msg[$key]['sender_place'] : $msg[$key]['message_place'];
                        $message_view = str_replace("%body%", substr($msg[$key]['body'], 0, 200) . "...", $style);
                        $message_view = str_replace("%time%", $msg[$key]['time'], $message_view);
                        $message_view = str_replace("%subject%", $msg[$key]['subject'], $message_view);
                        $message_view = str_replace("%sender%", $msg[$key]['sender_name'], $message_view);
                        $message_view = str_replace("%receives_list%", $msg[$key]['receivers_list'], $message_view);
                        $message_view = str_replace("%view_message_url%", ABSOLUTE_PATH . "mail/" . $message_place . "/" . $msg[$key]['id'], $message_view);
                    }

                    $message_table = str_replace("%message_cells%", $message_view . " %message_cells% ", $modified_table);
                }
                $message_table = $count != 0 ? str_replace(" %message_cells% ", "", $message_table) : str_replace("%message_cells%", $search_alt, $message_table);
                echo $message_table;
            } else {
                $style = file_get_contents(THEME_FOLDER . "mail/components/message.php");
                $msg = $message->getMessageById($messageID);
                foreach ($msg as $key => $value) {
                    $message_view = "";
                    foreach ($value as $key1 => $val) {
                        $message_place = (USER_ID == $msg[$key]['sender']) ? $msg[$key]['sender_place'] : $msg[$key]['message_place'];
                        $message_view = str_replace("%body%", substr($msg[$key]['body'], 0, 200) . "...", $style);
                        $message_view = str_replace("%time%", $msg[$key]['time'], $message_view);
                        $message_view = str_replace("%subject%", $msg[$key]['subject'], $message_view);
                        $message_view = str_replace("%sender%", $msg[$key]['sender_name'], $message_view);
                        $message_view = str_replace("%view_message_url%", ABSOLUTE_PATH . "mail/" . $message_place . "/" . $msg[$key]['id'], $message_view);
                    }
                    echo $message_view;
                }
            }
        }
    }

    public function loadPaginationSearch($page = 0) {
        if (THEME_FOLDER) {
            require_once 'models/message.php';
            $msg = new Message();
            $q = isset($_GET['q']) ? $_GET['q'] : NULL;
            $url = prepareURL($_GET);
            $count = $msg->countSearch();
            $count = $count % MESSAGES_PER_PAGE != 0 ? ($count / MESSAGES_PER_PAGE) + 1 : ($count / MESSAGES_PER_PAGE);
            if (!isset($url['2'])) {
                if ($count > 1) {
                    $elements = file_get_contents(THEME_FOLDER . "mail/components/pagination-elements.php");
                    $pagination = file_get_contents(THEME_FOLDER . "mail/components/pagination.php");
                    $pagination_next = file_get_contents(THEME_FOLDER . "mail/components/pagination-next.php");
                    $pagination_prev = file_get_contents(THEME_FOLDER . "mail/components/pagination-prev.php");
                    $start = 0;
                    $end = 0;
                    if ($page < 5) {
                        $end = 9 <= $count ? 9 : $count;
                        $start = 1;
                    } else {
                        $end = ($page + 4) <= $count ? ($page + 4) : $count;
                        $start = $page - 4;
                    }
                    $pagination_style = $pagination;
                    $i = $start;
                    $pagination_style = ($page - 1) >= $start ? str_replace("%page_index%", str_replace("%prev_page%", "?page=" . ($page - 1) . "&q=" . $q, $pagination_prev) . " %page_index% ", $pagination_style) : $pagination_style;
                    while ($i <= $end) {
                        $pagination_view = "";
                        $modified_view = $pagination_style;
                        $pagination_view = str_replace("%page_url%", "?page=" . $i . "&q=" . $q, $elements);
                        $pagination_view = str_replace("%page_number%", $i, $pagination_view);
                        $pagination_style = str_replace("%page_index%", $pagination_view . " %page_index% ", $modified_view);
                        $i++;
                    }

                    $pagination_style = ($page + 1) <= $end ? str_replace("%page_index%", str_replace("%next_page%", "?page=" . ($page + 1) . "&q=" . $q, $pagination_next), $pagination_style) : $pagination_style;
                    $pagination_style = str_replace(" %page_index% ", "", $pagination_style);
                    echo $pagination_style;
                }
            }
        }
    }

}

?>