<?php
include_once('_nova_core_/loader.php');
class index extends Core
{
    public $db = NULL;

    protected function _init() {
        parent::_init();
    }

    protected function _config() {
        parent::_config();
        $this->DBconnect();
        $this->setTemplate = 'home.html';
        $this->setThemeFolder = THEME;
    }

    protected function  _load() {
        parent::_load();
        $this->loadCategory();
        $this->getVideoTags();
        $this->getMyVideoPicks();
        $this->getFeaturedVideo();
        $this->getLatestVideo();
        $this->getMoreRandomVideo();
    }
    
    protected function getMyVideoPicks()
    {
        /* 10 randdom video will deside what to do later */
        $sql = "SELECT v.title, v.foldername, v.url_title, c.title as category, c.cat_url FROM videos v
		INNER JOIN categories c ON v.category_id = c.id
		WHERE v.enabled = '1' AND v.explicit = '0' LIMIT 10";

        $rs = $this->sqliteQuery($sql);
        $str='';

        foreach($rs as $row)
        {
            $str .= "<li>
                        <h1><a href='".$this->stringToURL($row['cat_url']).'/'.$this->stringToURL($row['url_title']).'.html'."' title='". $this->cleanString($row['title']) ."' >". $this->cleanString($row['title']) ."</a></h1>
                        <a href='".$this->stringToURL($row['cat_url']).'/'.$this->stringToURL($row['url_title']).'.html'."' title='' ><img src='videos/{$row['foldername']}/thumbnail1med.jpg' alt='". $this->cleanString($row['title']) ."'></a>
                    </li>";
        }

        $this->buffer = str_replace("{VIDEOPICKS}", $str, $this->buffer);
    }

    protected function getFeaturedVideo()
    {
        /* 10 randdom video will deside what to do later */
        $sql = "SELECT v.title, v.foldername, v.url_title, v.explicit, c.title as category, c.cat_url FROM videos v
                LEFT JOIN categories c ON v.category_id = c.id
                LEFT JOIN accounts a ON v.user_id = a.id WHERE v.feature = 1 AND v.enabled = '1' ORDER BY v.date_added DESC LIMIT 3";

        $rs = $this->sqliteQuery($sql);
        
        $str = $this->largeVideoList($rs);
        $this->buffer = str_replace("{FEATUREDVIDEO}", $str, $this->buffer);
    }

    protected function getLatestVideo()
    {
        $sql = "SELECT v.id as video_id, v.title, v.foldername, v.url_title, v.explicit, v.date_added, v.viewed, a.username, c.title as category, c.cat_url FROM videos v
                INNER JOIN categories c ON v.category_id = c.id
                INNER JOIN accounts a ON v.user_id = a.id
                WHERE v.enabled = '1' ORDER BY v.date_added DESC LIMIT 25";

        $rs = $this->sqliteQuery($sql);

        $str = $this->mediumVideoList($rs);
        $this->buffer = str_replace("{LATESTVIDEO}", $str, $this->buffer);
    }

    protected function getMoreRandomVideo()
    {
        $sql = "SELECT v.id as video_id, v.title, v.foldername, v.url_title, v.explicit, v.date_added, v.viewed, a.username, c.title as category, c.cat_url FROM videos v
                INNER JOIN categories c ON v.category_id = c.id
                INNER JOIN accounts a ON v.user_id = a.id WHERE v.enabled = '1' ORDER BY RANDOM() LIMIT 3";

        $rs = $this->sqliteQuery($sql);

        $str = $this->mediumVideoList($rs);
        $this->buffer = str_replace("{MOREVIDEOS}", $str, $this->buffer);
    }

    public function __construct() {
        //parent::__construct();
        $this->_init();
        $this->_config();
        $this->_load();
        $this->_render();
    }
}

$obj = new index();
?>