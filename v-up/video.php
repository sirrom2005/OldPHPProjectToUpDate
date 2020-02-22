<?php
include_once('_nova_core_/loader.php');

class videoPage extends Core
{
    public $db = NULL;

    protected function _init() {
        parent::_init();
    }

    protected function _config() {
        parent::_config();
        $this->DBconnect();
        $this->setTemplate = 'video.html';
        $this->setThemeFolder = THEME;
    }

    protected function  _load() {
        parent::_load();
        $this->loadCategory();
        $this->getVideoTags();

        $cat = $_GET['cat'];
        $url = $_GET['url'];

        $sql = "SELECT v.id as video_id, v.*, c.title as category, cat_url, a.username FROM videos v
            INNER JOIN video_tag vt ON v.id = vt.video_id
            INNER JOIN tags t ON vt.tag_id = t.id
            INNER JOIN categories c ON v.category_id = c.id
            INNER JOIN accounts a ON v.user_id = a.id
            WHERE c.cat_url = '$cat' AND v.url_title = '$url' LIMIT 1";

       $rs  = $this->sqliteQuery($sql);
       $rs  = $rs->fetchAll();
       $rs  = $rs[0];
       $tags = $this->getTagsForVideo($rs['id']);

       $this->buffer = str_replace("{VIDEOID}", $rs['id'], $this->buffer);
       $this->buffer = str_replace("{TITLE}", $rs['title'], $this->buffer);
       $this->buffer = str_replace("{CATEGORY}", $rs['category'], $this->buffer);
       $this->buffer = str_replace("{URL_CATEGORY}", $rs['cat_url'], $this->buffer);
       $this->buffer = str_replace("{DATEADDED}", date('M-d-Y', strtotime($rs['date_added'])), $this->buffer);
       $this->buffer = str_replace("{VIDEO}", $rs['foldername'], $this->buffer);
       $this->buffer = str_replace("{DESCRIPTION}", $rs['description'], $this->buffer);
       $this->buffer = str_replace("{DESC}", $rs['description'], $this->buffer);
       $this->buffer = str_replace("{USERNAME}", $rs['username'], $this->buffer);
       $this->buffer = str_replace("{TAGS}", $tags, $this->buffer);
       
    }

    public function __construct() {
        //parent::__construct();
        $this->_init();
        $this->_config();
        $this->_load();
        $this->_render();
    }
}

$obj = new videoPage();

/*include_once("config/config.php");
include_once("classes/mySqlDB__.class.php");
include_once("classes/site.class.php");

$obj 		= new site();
$cat 		= (isset($_GET['cat']))? $_GET['cat'] : NULL;
$url 		= (isset($_GET['url']))? $_GET['url'] : NULL;
$result   	= $obj->getVideoRecord($url,true,false,$cat);
$id			= $result['video'];
if($result['explicit']==1){header("location:".DOMAIN."restricted/{$id}/index.html");}

$category 	= $obj->getCategory();
$videoTags 	= $obj->getVideoTags();
$userList 	= $obj->getUserVideoList($result['user_id'],6,$id);
$cat 		= urlFix($result['category']);

$taglists 	= "";
$tags 		= "";
$keywords 	= $result['tags'];
$description= (!empty($result['meta_desc']))? $result['meta_desc'] : cleanString($result['description']);

if(!empty($videoTags))
{
	foreach($videoTags as $row)
	{
		$taglists .= $row['tags'].",";
	}
	$taglists = explode(",", $taglists);  
	$taglist  = array_unique($taglists);
	foreach($taglist as $key => $value)
	{
		$tags .= $value.",";
	}
}

ob_start(); 
	include_once("templates/video.html");
	$content = ob_get_contents();
ob_end_clean();
echo $content;*/
?>