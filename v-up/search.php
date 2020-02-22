<?php
include_once('_nova_core_/loader.php');

class searchPage extends Core
{
    public $db = NULL;

    protected function _init() {
        parent::_init();
    }

    protected function _config() {
        parent::_config();
        $this->DBconnect();
        $this->setTemplate = 'page.html';
        $this->setThemeFolder = THEME;
    }

    protected function  _load() {
        parent::_load();
        $this->loadCategory();
        $this->getVideoTags();
        $this->searchVideo();
    }

    protected function searchVideo()
    {
        $s = isset($_POST['s'])? $_POST['s'] : NULL;
        $user = isset($_GET['user'])? $_GET['user'] : NULL;
        $str = "<h1>Search results</h1>";
        if($s)
        {
            $sql = "SELECT v.id as video_id, v.title,v.url_title,v.viewed,v.foldername,v.date_added,a.username, c.title as category, cat_url, 0 as tags FROM videos v
            INNER JOIN categories c ON v.category_id = c.id
            INNER JOIN accounts a ON v.user_id = a.id
            WHERE v.title LIKE '%$s%' or V.DESCRIPTION LIKE '%$s%'";

            $rs = $this->sqliteQuery($sql);
            $rs = $this->mediumVideoList($rs);         
            $str .= (!$rs)? "<center>No results found.</center>" : $rs;
        }
        elseif($user)
        {
            $sql = "SELECT v.id as video_id, v.title,v.url_title,v.viewed,v.foldername,v.date_added,a.username, c.title as category, cat_url, 0 as tags FROM videos v
            INNER JOIN categories c ON v.category_id = c.id
            INNER JOIN accounts a ON v.user_id = a.id
            WHERE a.username  = '$user'";

            $rs = $this->sqliteQuery($sql);
            $rs = $this->mediumVideoList($rs);
            $str .= (!$rs)? "<center>No results found.</center>" : $rs;
        }
        else
        {
            $str .= "<center>No results found.</center>";
        }
        $this->buffer = str_replace("{CONTENTHERE}", $str, $this->buffer);
    }

    public function __construct() {
        //parent::__construct();
        $this->_init();
        $this->_config();
        $this->_load();
        $this->_render();
    }
}

$obj = new searchPage();
?>