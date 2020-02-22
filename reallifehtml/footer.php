        <div id="tr">
        	<h2 class="toprate" title="top rated">&nbsp;</h2>
            <div class="blkbox">fgfg</div>
            <p>&nbsp;</p>
            <h2 class="popular" title="popular beats">&nbsp;</h2>
            <div class="blkbox">fgfg</div>
            <p>&nbsp;</p>
            <h2 class="followus" title="follow us">&nbsp;</h2>
            <div class="blkbox socail_net">
            	<ul>
                	<li class="sn1"><a href="#"></a></li>
                    <li class="sn2"><a href="#"></a></li>
                    <li class="sn3"><a href="#"></a></li>
                    <li class="sn4"><a href="#"></a></li>
                </ul>
            </div>
        </div>
        <br />
        </div>
    </div>
    <div id="footer">
    	<div id="fl"><h2>Latest Design</h2></div>
        <div id="fc">
        	<h2>New Release</h2>
        	<div id="slider-wrapper">
                <div id="slider" class="nivoSlider">
                    <img width="100" src="<?php bloginfo( 'template_url' ); ?>/images/toystory.jpg" alt="" />
                    <img width="100" src="<?php bloginfo( 'template_url' ); ?>/images/up.jpg"       alt="" title="This is an example of a caption" />
                    <img width="100" src="<?php bloginfo( 'template_url' ); ?>/images/walle.jpg" alt="" />
                    <img width="100" src="<?php bloginfo( 'template_url' ); ?>/images/nemo.jpg"  alt="" title="#htmlcaption" />
                </div>
                <div id="htmlcaption" class="nivo-html-caption">
                    <strong>This</strong> is an example of a <em>HTML</em> caption with <a href="#">a link</a>.
                </div>
            </div>
        </div>
        <div id="fr">
        	<h2 class="search" title="search for tee shirts">&nbsp;</h2>
            <div class="blkbox">fgfg</div>
        </div>
    </div>
    <div id="footer_links">
    	<a href="#" id="poweredby"></a>
    	 <?php wp_nav_menu( array( 'container_class' => 'menu-footer', 'theme_location' => 'primary' ) ); ?>
    </div>
</div>
<?php
	/* Always have wp_footer() just before the closing </body>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to reference JavaScript files.
	 */

	wp_footer();
?>
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'template_url' ); ?>/css/nivo-slider.css" />
<script type="text/javascript" src="<?php bloginfo( 'template_url' ); ?>/js/jquery-1.6.1.min.js"></script>
<script type="text/javascript" src="<?php bloginfo( 'template_url' ); ?>/js/jquery.nivo.slider.pack.js"></script>
<script type="text/javascript">
$(window).load(function() {
	$('#slider').nivoSlider();
});
</script>
</body>
</html>
