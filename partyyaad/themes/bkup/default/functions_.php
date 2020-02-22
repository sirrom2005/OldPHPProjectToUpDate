<?php
session_start();
function getUpcomingEvent()
{
	/*```FOR HOME PAGE```*/
    $rs = query_full_array("SELECT i.filename, i.title, i.desc, i.publishdate, i.expiredate, a.folder, a.title AS albumTitle FROM partyyaad_images i
                            INNER JOIN partyyaad_albums a ON i.albumid = a.id 
                            WHERE a.folder = 'events' AND DATE_FORMAT(i.expiredate,'%Y-%m-%d') >= DATE_FORMAT(NOW(),'%Y-%m-%d')
                            ORDER BY expiredate LIMIT 6");
    return $rs;
}

function getUpcomingEventForEventsPage()
{
    $rs = query_full_array("SELECT i.filename, i.title, i.desc, i.publishdate, i.expiredate, a.folder, a.title AS albumTitle FROM partyyaad_images i
                            INNER JOIN partyyaad_albums a ON i.albumid = a.id
                            WHERE a.folder = 'events' AND DATE_FORMAT(i.expiredate,'%Y-%m-%d') >= DATE_FORMAT(NOW(),'%Y-%m-%d')
                            ORDER BY expiredate LIMIT 100");
    return $rs;
}

function getUpcomingEventForNoticeBoard()
{
    $rs = query_full_array("SELECT i.filename, i.title, i.desc, i.publishdate, i.expiredate, a.folder, a.title AS albumTitle FROM partyyaad_images i
                            INNER JOIN partyyaad_albums a ON i.albumid = a.id
                            WHERE a.folder = 'events' AND DATE_FORMAT(i.expiredate,'%Y-%m-%d') >= DATE_FORMAT(NOW(),'%Y-%m-%d')
                            ORDER BY expiredate LIMIT 100");
    return $rs;
}

function getLatestMedia()
{
    $rs = query_full_array("SELECT i.filename, i.title, i.desc, i.publishdate, i.expiredate, a.folder, a.title AS albumTitle FROM partyyaad_images i
							INNER JOIN partyyaad_albums a ON i.albumid = a.id
							WHERE a.folder = 'videos' ORDER BY RAND() LIMIT 1");
    return $rs;
}

function getMedia()
{
    $rs = query_full_array("SELECT i.filename, i.title, i.desc, i.publishdate, i.expiredate, a.folder, a.title AS albumTitle FROM partyyaad_images i
							INNER JOIN partyyaad_albums a ON i.albumid = a.id
							WHERE a.folder = 'videos' ORDER BY i.publishdate DESC LIMIT 200");
    return $rs;
}

function getBillBoardAds()
{
    $rs = query_full_array("SELECT i.filename, i.title, i.desc, i.publishdate, i.expiredate, a.folder, a.title AS albumTitle FROM partyyaad_images i
                            INNER JOIN partyyaad_albums a ON i.albumid = a.id
                            WHERE a.folder = 'banner_ads' AND i.custom_data LIKE '%bill-board%' 
                            ORDER BY expiredate LIMIT 100");
    return $rs;
}

function getPromotionalImages()
{
    $rs = query_full_array("SELECT i.filename, i.title, i.desc, i.publishdate, i.expiredate, a.folder, a.title AS albumTitle FROM partyyaad_images i
							INNER JOIN partyyaad_albums a ON i.albumid = a.id
							WHERE a.parentid IN (SELECT id FROM partyyaad_albums WHERE folder = 'promotions') GROUP BY a.title ORDER BY a.date DESC LIMIT 3");
    return $rs;
}

function getSplashScreenImage()
{
    $rs = query_full_array("SELECT i.filename, i.title, i.desc, i.publishdate, i.expiredate, a.folder, a.title AS albumTitle FROM partyyaad_images i
                            INNER JOIN partyyaad_albums a ON i.albumid = a.id
                            WHERE a.folder = 'events' AND i.custom_data = 'home' ORDER BY RAND() LIMIT 1");
    return $rs;
}

function disPlayHeaderBanner()
{
    $rs = query_full_array("SELECT i.filename, i.title, i.desc, a.folder, a.title AS albumTitle FROM partyyaad_images i
                            INNER JOIN partyyaad_albums a ON i.albumid = a.id
                            WHERE a.folder = 'banner_ads' AND i.custom_data LIKE '%header%' ORDER BY RAND() LIMIT 1");
    return $rs;
}
function disPlayFooterBanner()
{
    $rs = query_full_array("SELECT i.filename, i.title, i.desc, a.folder, a.title AS albumTitle FROM partyyaad_images i
                            INNER JOIN partyyaad_albums a ON i.albumid = a.id
                            WHERE a.folder = 'banner_ads' AND i.custom_data LIKE '%footer%' ORDER BY RAND() LIMIT 1");
    return $rs;
}
function disPlayLeftBanner()
{
    $rs = query_full_array("SELECT i.filename, i.title, i.desc, a.folder, a.title AS albumTitle FROM partyyaad_images i
                            INNER JOIN partyyaad_albums a ON i.albumid = a.id
                            WHERE a.folder = 'banner_ads' AND i.custom_data LIKE '%left%' ORDER BY RAND() LIMIT 1");
    return $rs;
}

function disPlayRightBanner()
{
    $rs = query_full_array("SELECT i.filename, i.title, i.desc, a.folder, a.title AS albumTitle FROM partyyaad_images i
                            INNER JOIN partyyaad_albums a ON i.albumid = a.id
                            WHERE a.folder = 'banner_ads' AND i.custom_data LIKE '%right%' ORDER BY RAND() LIMIT 1");
    return $rs;
}

function printRotatingBannerList()
{
    $rs = query_full_array("SELECT i.filename, i.title, i.desc, a.folder, a.title AS albumTitle FROM partyyaad_images i
                            INNER JOIN partyyaad_albums a ON i.albumid = a.id
                            WHERE a.folder = 'banner_ads' AND i.custom_data LIKE '%rotating%' ORDER BY RAND() LIMIT 10");
    return $rs;
}

function getGalleryMenu()
{
	if(empty($_SESSION['_MENU_']) || !isset($_SESSION['_MENU_']))
	{
		$rs = query_full_array("SELECT YEAR(a.publishdate) as _year,MONTH(a.publishdate) as _month,DAY(a.publishdate) as _day, a.title, a.publishdate,a.folder FROM partyyaad_albums a 
								WHERE a.publishdate IS NOT NULL AND a.show = '1'  
								ORDER BY _year,_month,_day");
		$_SESSION['_MENU_'] = $rs;
	}
	else
	{
		$rs = $_SESSION['_MENU_'];	
	}
	
	$data = array();
	if(!empty($rs))
	{
		foreach($rs as $key => $value)
		{
			$data[$value['_year']][$value['_month']][$value['_day']][$key]['title']  = strtolower($value['title']);
			$data[$value['_year']][$value['_month']][$value['_day']][$key]['folder'] = $value['folder'];
		}

		$str = "<ul class='myear'>";
		foreach($data as $key => $value)
		{ 	
			$str1 = "<ul class='mmonth'>";
			foreach($value as $m => $mvalue)
			{ 
				$str2 = "<div class='mday'>";
				$str2 .= "<h2>Photo gallery for ".date('F. Y', mktime(0,0,0,$m+1,0,$key))."</h2>";
				foreach($mvalue as $d => $pvalue)
				{ 	
					$i=0;
					foreach($mvalue[$d] as $dd => $ptitle)
					{
						$str2 .= "<a href='index.php?album=".urlencode($ptitle['folder'])."' title='photo galler :: ".$ptitle['title']."' >". substr($ptitle['title'],0,25).'<small>Held: '.date('M/d/Y', mktime(0,0,0,$m,$d,$key))."</small></a>";
					}
					$i++;
				}
				$str2 .= '</div>';
				$str1 .= "<li>". date('F', mktime(0,0,0,$m+1,0,0)).$str2."</li>";
			}
			$str1 .= '</ul>';
			$str .= '<li>'.$key.' GALLERY'.$str1.'</li>';
		}
		$str .= "</ul>";
	}
	echo "$str";
}
?>