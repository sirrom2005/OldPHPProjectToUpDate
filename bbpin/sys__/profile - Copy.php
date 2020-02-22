<?php 
include_once("../config/config.php");
include_once("../classes/mySQlDB__.class.php");
include_once("../classes/site.class.php");
$obj = new site();

$list = $obj->getUserList();
$pageCount = 0;
$xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
$xml = '<urlset
		  xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
		  xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
		  xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
				http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">				
		<url>
		  <loc>http://www.jusbbmpin.com/</loc>
		  <changefreq>daily</changefreq>
		  <priority>1.00</priority>
		</url>
		<url>
		  <loc>http://www.jusbbmpin.com/find-bbm-contact.html</loc>
		  <changefreq>daily</changefreq>
		  <priority>0.50</priority>
		</url>
		<url>
		  <loc>http://www.jusbbmpin.com/find-bbm-groups.html</loc>
		  <changefreq>daily</changefreq>
		  <priority>0.50</priority>
		</url> 
		<url>
		  <loc>http://www.jusbbmpin.com/bbm-chat-groups.html</loc>
		  <changefreq>daily</changefreq>
		  <priority>0.70</priority>
		</url>
		<url>
		  <loc>http://www.jusbbmpin.com/messages.html</loc>
		  <changefreq>daily</changefreq>
		  <priority>0.90</priority>
		</url>
		<url>
		  <loc>http://www.jusbbmpin.com/pin-request.html</loc>
		  <changefreq>daily</changefreq>
		  <priority>0.90</priority>
		</url>
		<url>
		  <loc>http://www.jusbbmpin.com/profile.html</loc>
		  <changefreq>daily</changefreq>
		  <priority>0.50</priority>
		</url>
		
		<url>
		  <loc>http://www.jusbbmpin.com/about-us.htm</loc>
		  <changefreq>daily</changefreq>
		  <priority>1.00</priority>
		</url>
		<url>
		  <loc>http://www.jusbbmpin.com/faqs.htm</loc>
		  <changefreq>daily</changefreq>
		  <priority>0.50</priority>
		</url>
		<url>
		  <loc>http://www.jusbbmpin.com/privacy-policy.htm</loc>
		  <changefreq>daily</changefreq>
		  <priority>0.50</priority>
		</url>
		<url>
		  <loc>http://www.jusbbmpin.com/feedback.htm</loc>
		  <changefreq>daily</changefreq>
		  <priority>0.50</priority>
		</url>
		<url>
		  <loc>http://www.jusbbmpin.com/terms.htm</loc>
		  <changefreq>daily</changefreq>
		  <priority>0.70</priority>
		</url>
		<url>
		  <loc>http://www.jusbbmpin.com/contact-us.htm</loc>
		  <changefreq>daily</changefreq>
		  <priority>0.50</priority>
		</url>';	
ob_start();
foreach($list as $row){
	$xml .= "<url>
			  <loc>http://www.jusbbmpin.com/profile_{$_GET['id']}.html</loc>
			  <changefreq>daily</changefreq>
			  <priority>0.75</priority>
			</url>";
}
$xml .= "</urlset>";

	$_GET['id'] = $row['id'];
	include('../profile.php');
	$pageCount++;

$s = ob_get_contents();
ob_get_clean();
echo $pageCount.' pages';

$fxml=fopen(DOCROOT."sitemap.xml",'w'); 
fwrite($fxml,$xml,strlen($xml));
fclose($fxml);
chmod(DOCROOT."sitemap.xml",0755);
?>