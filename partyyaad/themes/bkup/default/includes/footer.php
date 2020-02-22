<?php
if (function_exists('printLanguageSelector')) {
	printLanguageSelector();
}
?>
<?php include_once('right_banner.php'); ?>
<?php if(!empty($footerAds)){ ?>
<div id="banner_468"><a <?php echo (empty($footerAds[0]['location']))? '' : 'href="'.$footerAds[0]['location'].'" target="_blank"' ;?> ><img src="<?php echo albums.'/'.$footerAds[0]['folder'].'/'.$footerAds[0]['filename']; ?>" title="<?php echo strip_tags($footerAds[0]['title']);?>" alt="<?php echo strip_tags($footerAds[0]['title']);?>" style="width:468px;height:60px;" /></a></div>
<?php } ?>
<div id="footer">
    <div id="credit">
        Powered by <a title="A simpler web album" href="http://www.zenphoto.org" target="_blank"><span id="zen-part">zen</span><span id="photo-part">PHOTO</span></a> |
        <?php
        if (function_exists('printUserLogin_out')) {
            printUserLogin_out('', ' | ');
        }
        ?>
        <?php printRSSLink('Gallery', '', 'RSS', ' | '); ?>
        <?php printCustomPageURL(gettext("Archive View"), "archive"); ?> |
        <?php
        if (getOption('zp_plugin_contact_form')) {
            printCustomPageURL(gettext('Contact us'), 'contact', '', '', ' | ');
        }
        ?>
        <a href="/index.php?p=privacy-policy" title="view partyaad.com privacy policy">Privacy policy</a> | 
        <?php
        if (!zp_loggedin() && function_exists('printRegistrationForm')) {
            printCustomPageURL(gettext('Register for this site'), 'register', '', '', ' | ');
        }    
        ?>
        <a href="http://www.twitter.com/rohanmorris" title="credit thanks to iceman" target="_blank" >Credits</a>
    </div>
    Copyright &copy; <?php echo date('Y');?> <a href="http://www.partyaad.com" title="www.partyaad.com">partyaad.com</a> 
</div>
<?php
printAdminToolbox();
zp_apply_filter('theme_body_close');
?>
</div>
<script language="javascript">
	$("#banner a[title]").tooltip({ position: "bottom center", opacity: 1.0});
</script>