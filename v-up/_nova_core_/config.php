<?php
session_start();
define('THEME', 'default');
define('THEMEFOLDER', '/doc_root/www/themes/');
define('DOMAIN', 'http://127.0.0.1/v-up/');
define("VERSION", '1.0.1');
define("SITENAME", 'videouploader.net');
define("TAGLINE", 'the online video server');

/*define('CONSUMER_KEY', '2thGmJ6tk1HSJiFyH7w3A');
define('CONSUMER_SECRET', 'AI1FAQs0czjXVcriCi510BFO7Wqruym3ho15j6i1g');
define('OAUTH_CALLBACK', 'http://www.videouploader.net/page.php?action=callback');*/
####################### DATABASE ####################
/*define("DBDATABASE", "rohanmor_vserver", true);
define("DBUSERNAME", "rohanmor_rohanmo", true);
define("DBPASSWORD", "45BGYHsXYo", true);
define("DBHOST", "localhost", true);*/
###################### SETTINGS #####################

define("SERVER_ROOT", $_SERVER['DOCUMENT_ROOT']."/", true);
define("SERVER_PATH", $_SERVER['DOCUMENT_ROOT']."v-up/", true);
/*define("VIDEO_TMP_FOLDER",  SERVER_ROOT."vci/the_tmp_store/", true);
define("VIDEO_DEST_FOLDER", SERVER_ROOT."videos/", true);
define("VIDEO_SCRIPT_PATH", "/usr/local/bin/", true);
define("VIDEO_PATH_URL", DOMAIN."videos/", true);*/
?>