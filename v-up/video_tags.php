<?php
include_once('_nova_core_/loader.php');

class videoTags extends Core
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
        $this->displayVideoTags(isset($_GET['tag'])? $_GET['tag'] : NULL);
    }

    protected function displayVideoTags($tag=NULL)
    {
        if($tag)
        {
            $tag = $this->URLToString($tag);
            $sql = "SELECT v.id as video_id, v.title, v.foldername, v.url_title, v.explicit, v.date_added, v.viewed, c.title as category, cat_url, a.username FROM videos v
            INNER JOIN video_tag vt ON v.id = vt.video_id
            INNER JOIN tags t ON vt.tag_id = t.id
            INNER JOIN categories c ON v.category_id = c.id
            INNER JOIN accounts a ON v.user_id = a.id
            WHERE t.tag = '$tag'";

            $rs  = $this->sqliteQuery($sql);
            $str = "<h1><a href='".DOMAIN."video-tags/'>Video tags</a> - $tag</h1>";
            $str .= $this->mediumVideoList($rs);
            $this->buffer = str_replace("{CONTENTHERE}", $str, $this->buffer);
            return;
        }

        $sql = "SELECT t.tag, count(t.tag) as cnt FROM tags t
                INNER JOIN video_tag vt ON t.id = vt.tag_id GROUP BY t.tag ORDER BY Random()";

        $rs  = $this->sqliteQuery($sql);
        $str = "<h1>Video tags</h1>";
        foreach($rs as $row)
        {
            if($row['cnt']<=2){$tagStyle = "tag1";}
            if($row['cnt']>=2){$tagStyle = "tag2";}

            $str .= "<a class='tag $tagStyle' href='".DOMAIN."video-tags/".$this->stringToURL($row['tag']).".html'>{$row['tag']}</a>";
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

$obj = new videoTags();
?>