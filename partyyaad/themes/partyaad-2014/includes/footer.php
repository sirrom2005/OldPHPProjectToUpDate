        <div class="footer_banner">
            <script type="text/javascript"><!--
            google_ad_client = "ca-pub-9222115009045453";
            /* 468x60banner */
            google_ad_slot = "8060140279";
            google_ad_width = 468;
            google_ad_height = 60;
            //-->
            </script>
            <script type="text/javascript"
            src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
            </script>
        </div>
    </div>
</div>
<div id="footer">
	<div>
        <ul>
            <li class="c1">
                <h4>About Partyaad.com</h4>
                <?php //printGalleryDesc(); ?>
                The premiere website for event photos.<br>
                We cover all types of events such as birthday parties, weddings, graduations, funerals, and other outdoor activities.
            </li>
            <li class="c2">
                <h4>Site Links</h4>
                <a href="/2014/" title="2014 Gallery">2014 Photo Galleries</a>
                <br><a href="/2013/" title="2013 Gallery">2013 Photo Galleries</a>
                <br><a href="/index.php?p=events" title="2013 Gallery">Upcoming Events</a>
                <br><?php printCustomPageURL(gettext("Partyaad Photo Gallery Archive"), "archive"); ?>
                <br><a href="/index.php?p=privacy-policy" title="view partyaad.com privacy policy">Privacy Policy</a>
                <br><?php if (class_exists('RSS')) printRSSLink('Gallery', '', 'RSS', ''); ?>
            </li>
            <li class="c3">
                <h4>Contact Us</h4>
                <p><label>skype:</label>drlucius2</p>
                <p><label>phone:</label>1-(876)-853-3345 or 1-(876)-770-6966</p> 
                <p><label>e-mail:</label><a href="mailto:partyaad@gmail.com">partyaad@gmail.com</a></p>
                <p><label>BBPin:</label>324CF926</p>
            </li>
            <li class="c4">
                <h4>Copyright</h4>
                All content Copyright 2014 partyaad.com. All Rights Reserved.<br>
                Text, images and all other content on this site may not be copied or republished in any way without formal permission. 
            </li>
        </ul>
        <br clear="all">
    </div>
    <span class="credits">
        <a href="http://www.twitter.com/rohanmorris" title="thanks to the web developer follow on twitter @rohanmorris" target="_blank">made with all natural ingredients</a>
    </span>
</div>
<span id="name">Partyaad.com</span>
</div>
<?php
zp_apply_filter('theme_body_close');
?>