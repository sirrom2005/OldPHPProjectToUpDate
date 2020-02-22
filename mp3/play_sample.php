<?php include_once("config/config.php"); ?>
<h4 align="center"><?php echo base64_decode($_GET['title']);?></h4>
<p align="center">
<object type="application/x-shockwave-flash" data="player/player_mp3_maxi.swf" width="250" height="20">
    <param name="movie" value="player/player_mp3_maxi.swf" />
    <param name="bgcolor" value="#ffffff" />
    <param name="FlashVars" value="mp3=<?php echo MP3LOCATION."sample_{$_GET['id']}.mp3";?>&amp;showstop=1&amp;showinfo=0&amp;showvolume=1&amp;showloading=always&amp;autoplay=1" />
</object>
</p>