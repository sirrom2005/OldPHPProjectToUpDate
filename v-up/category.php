<?php
include_once('_nova_core_/loader.php');

class videoCategory extends Core
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
        $this->displayVideoCategory(isset($_GET['cat'])? $_GET['cat'] : NULL);
    }

    protected function displayVideoCategory($cat=NULL)
    {
        if($cat)
        {
            $cat = $this->URLToString($cat);
            $sql = "SELECT v.id as video_id, v.title, v.foldername, v.url_title, v.explicit, v.date_added, v.viewed, c.title as category, cat_url, a.username FROM videos v
            INNER JOIN categories c ON v.category_id = c.id
            INNER JOIN accounts a ON v.user_id = a.id
            WHERE c.cat_url = '$cat'";
        
            $rs  = $this->sqliteQuery($sql);
            $str = "<h1>$cat</h1>";
            $str .= $this->mediumVideoList($rs);
            $this->buffer = str_replace("{CONTENTHERE}", $str, $this->buffer);
        }
    }

    public function __construct() {
        //parent::__construct();
        $this->_init();
        $this->_config();
        $this->_load();
        $this->_render();
    }
}

$obj = new videoCategory();
?>