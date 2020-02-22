<?php
//	Required plugins:
require_once(SERVERPATH.'/'.ZENFOLDER.'/'.PLUGIN_FOLDER.'/image_album_statistics.php');
require_once(SERVERPATH.'/'.ZENFOLDER.'/'.PLUGIN_FOLDER.'/print_album_menu.php');

/**
 * Prints the scripts needed for the header
 */
function jqm_loadScripts() {
global $_zp_themeroot;
	?>
	<link rel="stylesheet" href="<?php echo $_zp_themeroot; ?>/jquerymobile/jquery.mobile-1.2.0.min.css" />
	<!--script type="text/javascript" src="<?php echo $_zp_themeroot; ?>/jquerymobile/jquery.mobile-1.2.0.min.js"></script-->
	<?php
	printZDSearchToggleJS();
}

/**
 * Prints the rss links for use in the sidebar/bottom nav
 */
function jqm_printRSSlinks() {
	global $_zp_gallery_page, $_zp_themeroot;
	?>
		<h3><?php echo gettext('RSS'); ?></h3>
		<ul>
	<?php // these links must change to ones with rel="external" so they are actually loaded via jquerymobile!
		if(getOption('zp_plugin_zenpage')) {
			?>
			<li class="rsslink"><a href="<?php echo html_encode(getZenpageRSSLink('News')); ?>" rel="external" data-ajax="false"><?php echo gettext('News'); ?></a></li>
			<li class="rsslink"><a href="<?php echo html_encode(getZenpageRSSLink('NewsWithImages')); ?>" rel="external" data-ajax="false"><?php echo gettext('News and Gallery'); ?></a></li>
			<?php
		}
		 ?>
			<li class="rsslink"><a href="<?php echo html_encode(getRSSLink('Gallery')); ?>" rel="external" data-ajax="false"><?php echo gettext('Gallery'); ?></a></li>
		 <?php
		 if($_zp_gallery_page == 'album.php') {
		 ?>
		 <li class="rsslink"><a href="<?php echo html_encode(getRSSLink('Album')); ?>" rel="external" data-ajax="false"><?php echo gettext('Album'); ?></a></li>
			<?php
			}
		?>
		</ul>
<?php
}
/**
 * Prints the image/subalbum count for the album loop
 */
function jqm_printMainHeaderNav() {
	global $_zp_gallery_page, $_zp_zenpage, $_zp_current_album, $_zp_themeroot;
	?>
<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-5576813-13']);
  _gaq.push(['_trackPageview']);
  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>
	<div class="header" data-position="inline" data-theme="a">
		<h1><?php //printGalleryTitle(); ?></h1>
        <hr />
		<a href="<?php echo WEBPATH; ?>/index.php" class="home" data-iconpos="notext"><?php echo gettext('Home'); ?></a>
		<?php if (getOption('Allow_search')) { ?>
			<a href="<?php echo getCustomPageURL('search'); ?>" class="search" data-iconpos="notext"><?php echo gettext('Find'); ?></a>
		<?php } ?>
        <hr />
		<div class="navbar">
			<ul>
                <li class="c1"><a href="<?php echo WEBPATH;?>/2013/"><?php echo gettext('2013 Gallery'); ?></a></li>
                <li class="c2"><a href="<?php echo WEBPATH;?>/2012/"><?php echo gettext('2012 Gallery'); ?></a></li>
                <li class="c1"><a href="<?php echo WEBPATH;?>/2011/"><?php echo gettext('2011 Gallery'); ?></a></li>
                <!--li class="c2"><a href="<?php echo WEBPATH;?>/events/"><?php echo gettext('Upcoming Events'); ?></a></li-->
			</ul>
		</div><!-- /navbar -->
	</div><!-- /header -->
	<?php
}
/**
 * Prints the footer
 */
function jqm_printFooterNav() {
	global $_zp_gallery_page, $_zp_current_album;
	?>
	<div id="footer">
        <ul>
            <li><?php echo gettext('Powered by'); ?> <a href="http://www.zenphoto.org">Zenphoto</a></li>
            <li><?php @call_user_func('mobileTheme::controlLink'); ?></li>
            <li>Credits <a href="http://www.twitter.com/rohanmorris" title="thanks to iceman follow on twitter @rohanmorris" target="_blank" class="credits">follow @rohanmorris</a></li>
        </ul>
		<!-- /navbar -->
	</div><!-- footer -->
	<?php
}

/**
 * Prints the categories of current article as a unordered html list WITHOUT links
 *
 * @param string $separator A separator to be shown between the category names if you choose to style the list inline
 */
function jqm_printNewsCategories($separator='',$class='') {
	$categories = getNewsCategories();
	$catcount = count($categories);
	if($catcount != 0) {
		if(is_NewsType("news")) {
			echo  "<ul class=\"$class\">\n";
			$count = 0;
			foreach($categories as $cat) {
				$count++;
				$catobj = new ZenpageCategory($cat['titlelink']);
				if($count >= $catcount) {
					$separator = "";
				}
				echo "<li>".$catobj->getTitle()."</li>\n";
			}
			echo "</ul>\n";
		}
	}
}

/**
 * Prints the foldout (sidebar/bottom) menu links
 */
function jqm_printMenusLinks() {
	?>
	<div>
		<script type="text/javascript"><!--
        google_ad_client = "ca-pub-9222115009045453";
        /* 336x280_aads */
        google_ad_slot = "1466614550";
        google_ad_width = 336;
        google_ad_height = 280;
        //-->
        </script>
        <script type="text/javascript"
        src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
        </script>
	</div>
<?php
}


function jqm_printBacktoTopLink() {
	return ''; // disabled for now as the jquerymobile cache somehow always link this to the previous page...
	?>
	<a href="#mainpage" data-ajax="false" rel="external" data-role="button" data-icon="arrow-u" data-iconpos="left" data-mini="true" data-inline="true"><?php echo gettext('Back to top'); ?></a>
	<?php
}

/**
 * Prints the link to an news entry with combinews support
 */
function jqm_getNewsLink() {
	global $_zp_current_zenpage_news;
	$newstype = getNewsType();
	switch($newstype) {
		case "image":
		case "video":
			$link = $_zp_current_zenpage_news->getImageLink();
			break;
		case "album":
			$link = $_zp_current_zenpage_news->getAlbumLink();
			break;
		default:
			$link = getNewsURL(getNewsTitleLink());
			break;
	}
	return $link;
}

/**
 * Prints the thumbnail for news in Combinews mode
 */
function jqm_printCombiNewsThumb() {
	global $_zp_current_zenpage_news;
	$newstype = getNewsType();
	switch($newstype) {
		case "image":
		case "video":
			$thumb = '<img src="'.pathurlencode($_zp_current_zenpage_news->getCustomImage(NULL, 80, 80, 80,80, NULL, NULL,true,NULL)).'" alt="'.html_encode($_zp_current_zenpage_news->getTitle()).'" />';
			break;
		case "album":
			$obj = $_zp_current_zenpage_news->getAlbumThumbImage();
			$thumb = '<img src="'.pathurlencode($obj->getCustomImage(NULL, 80, 80, 80,80, NULL, NULL,true,NULL)).'" alt="'.html_encode($_zp_current_zenpage_news->getTitle()).'" />';
		default:
			$thumb = '';
			break;
	}
	echo $thumb;
}

/**
 * Prints the image/subalbum count for the album loop
 */
function jqm_printImageAlbumCount() {
	$numalb = getNumAlbums();
	$numimg = getNumImages();
	if($numalb != 0) {
		printf(ngettext ("%d album", "%d albums", $numalb), $numalb);
	}
	if($numalb != 0 && $numimg != 0) echo ' / ';
	if($numimg != 0) {
		printf(ngettext ("%d image", "%d images", $numimg), $numimg);
	}
}

/**
 * Prints jQuery JS to enable the toggling of search results of Zenpage  items
 *
 */
function printZDSearchToggleJS() { ?>
	<script type="text/javascript">
		// <!-- <![CDATA[
		function toggleExtraElements(category, show) {
			if (show) {
				jQuery('.'+category+'_showless').show();
				jQuery('.'+category+'_showmore').hide();
				jQuery('.'+category+'_extrashow').show();
			} else {
				jQuery('.'+category+'_showless').hide();
				jQuery('.'+category+'_showmore').show();
				jQuery('.'+category+'_extrashow').hide();
			}
		}
		// ]]> -->
	</script>
<?php
}

/**
 * Prints the "Show more results link" for search results for Zenpage items
 *
 * @param string $option "news" or "pages"
 * @param int $number_to_show how many search results should be shown initially
 */
function printZDSearchShowMoreLink($option,$number_to_show) {
	$option = strtolower(sanitize($option));
	$number_to_show = sanitize_numeric($number_to_show);
	switch($option) {
		case "news":
			$num = getNumNews();
			break;
		case "pages":
			$num = getNumPages();
			break;
	}
	if ($num > $number_to_show) {
		?>
<a class="<?php echo $option; ?>_showmore"href="javascript:toggleExtraElements('<?php echo $option;?>',true);"><?php echo gettext('Show more results');?></a>
<a class="<?php echo $option; ?>_showless" style="display: none;"	href="javascript:toggleExtraElements('<?php echo $option;?>',false);"><?php echo gettext('Show fewer results');?></a>
		<?php
	}
}


/**
 * Adds the css class necessary for toggling of Zenpage items search results
 *
 * @param string $option "news" or "pages"
 * @param string $c After which result item the toggling should begin. Here to be passed from the results loop.
 */
function printZDToggleClass($option,$c,$number_to_show) {
	$option = strtolower(sanitize($option));
	$c = sanitize_numeric($c);
	$number_to_show = sanitize_numeric($number_to_show);
	if ($c > $number_to_show) {
		echo ' class="'.$option.'_extrashow" style="display:none;"';
	}
}

function getUpcomingEventForNoticeBoard()
{
    $rs = query_full_array("SELECT i.filename, i.title, i.desc, i.publishdate, i.expiredate, a.folder, a.title AS albumTitle FROM ".prefix("images")." i
                            INNER JOIN ".prefix("albums")." a ON i.albumid = a.id
                            WHERE a.folder = 'events' AND DATE_FORMAT(i.expiredate,'%Y-%m-%d') >= DATE_FORMAT(NOW(),'%Y-%m-%d')
                            ORDER BY expiredate LIMIT 100");
    return $rs;
}

function getBillBoardAds()
{
    $rs = query_full_array("SELECT i.filename, i.title, i.desc, i.publishdate, i.expiredate, a.folder, a.title AS albumTitle FROM ".prefix("images")." i
                            INNER JOIN ".prefix("albums")." a ON i.albumid = a.id
                            WHERE a.folder = 'banner_ads' AND i.custom_data LIKE '%bill-board%' 
                            ORDER BY expiredate LIMIT 100");
    return $rs;
}
?>