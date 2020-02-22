<?php	
	$rs = $comObj->getDataById("odb_mp3",$_GET['id']);

	$title = "Song information";
	echo "<h3>{$rs['title']}</h3>";
?>
<!-- AddThis Button BEGIN -->
    <div class="addthis_toolbox addthis_default_style addthis_32x32_style" style="float:right;width:200px;height:32px;">
    <a class="rs" href="<?php echo DOMAIN;?>rss.xml" title="videouploader.net video feed" target="_blank"></a>
    <a class="em" href="<?php echo DOMAIN;?>contact_us.html" title="contact us"></a>
    <a class="addthis_button_preferred_1"></a>
    <a class="addthis_button_preferred_2"></a>
    <a class="addthis_button_preferred_3"></a>
    <a class="addthis_button_preferred_4"></a>
    <a class="addthis_button_compact"></a>
    </div>
    <script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#username=xa-4d327e9464e5632c"></script>
<!-- AddThis Button END -->
<p>
<object type="application/x-shockwave-flash" data="player/player_mp3_maxi.swf" width="200" height="20">
    <param name="movie" value="player/player_mp3_maxi.swf" />
    <param name="bgcolor" value="#ffffff" />
    <param name="FlashVars" value="mp3=<?php echo MP3LOCATION."sample_{$_GET['id']}.mp3";?>&amp;showstop=1&amp;showinfo=0&amp;showvolume=1&amp;showloading=always&amp;autoplay=0" />
</object>
<br /><small>Play sample</small>
</p>

<?php
	echo "{$rs['detail']}";
?>