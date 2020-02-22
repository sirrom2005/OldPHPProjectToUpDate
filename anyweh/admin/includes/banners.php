<h1 class="header">Banners</h1>

<table width="100%" border="0">
  <tr>
    <td width="250" valign="top">
        <ul>
        <li><a href="index.php?action=add_banner&type=premium_banner">Premium page</a></li>
        <li><a href="index.php?action=banners&page=home">Home Page</a></li>
        <li><a href="index.php?action=banners&page=video">Videos Page</a></li>
        <li><a href="index.php?action=banners&page=gallery">Party Picture Page</a></li>
        <li><a href="index.php?action=banners&page=event">Events Page</a></li>
        </ul>
	</td>
    <td>
    	<? if($_GET['page']=="home"){ ?>
    	<h4>Select the location where you want to add the banner.</h4>
        <img src="images/home_page.jpg" border="0" usemap="#home" id="adsMap" width="300" />
        <map name="home" id="home"><area shape="rect" title="Top banner" coords="99,15,284,50" href="index.php?action=add_banner&type=home_banner_top" />
        <area shape="rect" coords="189,51,233,84" title="Left small banner" href="index.php?action=add_banner&type=home_banner_smll_left" />
        <area shape="rect" coords="236,51,279,84" title="Small right banner" href="index.php?action=add_banner&type=home_banner_smll_right" />
        <area shape="rect" coords="186,89,280,194" title="Big banner" href="index.php?action=add_banner&type=home_banner_big_banner" />
        <area shape="rect" coords="17,319,280,348" title="Bottom banner" href="index.php?action=add_banner&type=home_banner_bot" />
		</map>
        <? } ?>
        <? if($_GET['page']=="video"){ ?>
    	<h4>Select the location where you want to add the banner.</h4>
      <img src="images/video_page.jpg" border="0" usemap="#video" id="adsMap" width="300" />
        <map name="video" id="video">
          <area shape="rect" title="Top banner" coords="100,2,297,39" href="index.php?action=add_banner&type=video_banner_top" />
        <area shape="rect" coords="199,51,294,223" title="Left small banner" href="index.php?action=add_banner&type=video_banner_right" />
        <area shape="rect" coords="6,338,297,369" title="Small right banner" href="index.php?action=add_banner&type=video_banner_bottom" />
        <area shape="rect" coords="65,233,183,306" title="Big banner" href="index.php?action=add_banner&type=video_banner_middle" />
	  </map>
      <? } ?>
      
     <? if($_GET['page']=="gallery"){ ?>
    	<h4>Select the location where you want to add the banner.</h4>
      <img src="images/gallery_page.jpg" border="0" usemap="#gallery" id="adsMap" width="300" />
        <map name="gallery" id="gallery">
          <area shape="rect" title="Top banner" coords="102,2,299,39" href="index.php?action=add_banner&type=gallery_banner_top" />
        <area shape="rect" coords="201,51,296,223" title="Left small banner" href="index.php?action=add_banner&type=gallery_banner_right" />
        <area shape="rect" coords="6,338,297,369" title="Small right banner" href="index.php?action=add_banner&type=gallery_banner_bottom" />
	  </map>
      <? } ?>
      <? if($_GET['page']=="event"){ ?>
    	<h4>Select the location where you want to add the banner.</h4>
      <img src="images/event_page.jpg" border="0" usemap="#event" id="adsMap" width="300" />
        <map name="event" id="event">
          <area shape="rect" title="Top banner" coords="102,5,299,42" href="index.php?action=add_banner&type=event_banner_top" />
        <area shape="rect" coords="202,56,297,228" title="Left small banner" href="index.php?action=add_banner&type=event_banner_right" />
        <area shape="rect" coords="5,346,298,378" title="Small right banner" href="index.php?action=add_banner&type=event_banner_bottom" />
	  </map>
      <? } ?>
    </td>
  </tr>
</table>

