<?php
$page = (isset($_GET['action']) && is_file(dirname(__FILE__).'/includes/'.$_GET['action']).'.php'   )? $_GET['action'] : 'home';
$lang = (isset($_GET['lang'])   && is_file(dirname(__FILE__).'/includes/lang/'.$_GET['lang'].'.php'))? $_GET['lang']   : 'en';
include_once('includes/lang/'.$lang.'.php');
define('DOMAIN','http://'.$_SERVER['SERVER_NAME'].'/datadriven/');
function _t($s){
	global $locale;
	echo utf8_encode($locale[$s]);
}
?>
<!DOCTYPE html>
<html dir="<?php _t('lang.dir');?>" lang="<?php _t('php.locale');?>">
<head>
<meta name="language" content="<?php _t('php.locale');?>" />
<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;"/>
<meta name="title" content="<?php _t('site.title');?>">
<meta name="description" content="web developer/programmer, mysql php xhtml css andriod java javascript mssql">
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<link rel="icon" type="image/png" href="" />
<title><?php _t('site.title');?></title>
<style type="text/css">
@import url("css/styles.css");
</style>
</head>

<body>
    <div id="menu">
        <a class="new" href="<?php echo DOMAIN;?>">Home</a>
        <a class="new" href="?action=new-survey">New Survey</a>
        <a class="my" href="?action=my-survey">My Surveys</a>
        <a class="profile" href="?action=profile">Manage Profile</a>
    </div>
    <div id="container">
    	<?php include_once(dirname(__FILE__).'/includes/'.$page.'.php'); ?>
    </div>
</body>
</html>