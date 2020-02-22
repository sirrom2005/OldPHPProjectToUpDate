<?php
/**
 * @package WordPress
 * @subpackage Default_Theme
 */
?>
<div id="sidebar" role="complementary">
	<ul>
		<li>
			<!-- Include the Google Friend Connect javascript library. -->
			<script type="text/javascript" src="http://www.google.com/friendconnect/script/friendconnect.js"></script>
			<!-- Define the div tag where the gadget will be inserted. -->
			<div id="div-2366197625849440319" style="width:250px;border:1px solid #cc0000;"></div>
			<!-- Render the gadget into a div. -->
			<script type="text/javascript">
			var skin = {};
			skin['BORDER_COLOR'] = '#cc0000';
			skin['ENDCAP_BG_COLOR'] = '#cc0000';
			skin['ENDCAP_TEXT_COLOR'] = '#ffffff';
			skin['ENDCAP_LINK_COLOR'] = '#000066';
			skin['ALTERNATE_BG_COLOR'] = '#ffffff';
			skin['CONTENT_BG_COLOR'] = '#ffffff';
			skin['CONTENT_LINK_COLOR'] = '#0000cc';
			skin['CONTENT_TEXT_COLOR'] = '#333333';
			skin['CONTENT_SECONDARY_LINK_COLOR'] = '#7777cc';
			skin['CONTENT_SECONDARY_TEXT_COLOR'] = '#666666';
			skin['CONTENT_HEADLINE_COLOR'] = '#333333';
			skin['NUMBER_ROWS'] = '4';
			google.friendconnect.container.setParentUrl('/' /* location of rpc_relay.html and canvas.html */);
			google.friendconnect.container.renderMembersGadget(
			{ id: 'div-2366197625849440319',
			site: '07788010716203665169' },
			skin);
			</script>
		</li>
		<li>
			<!-- Include the Google Friend Connect javascript library. -->
			<script type="text/javascript" src="http://www.google.com/friendconnect/script/friendconnect.js"></script>
			<!-- Define the div tag where the gadget will be inserted. -->
			<div id="div-6002340785846368699" style="width:250px;border:1px solid #cc0000;"></div>
			<!-- Render the gadget into a div. -->
			<script type="text/javascript">
			var skin = {};
			skin['BORDER_COLOR'] = '#cc0000';
			skin['ENDCAP_BG_COLOR'] = '#cc0000';
			skin['ENDCAP_TEXT_COLOR'] = '#ffffff';
			skin['ENDCAP_LINK_COLOR'] = '#ffffff';
			skin['ALTERNATE_BG_COLOR'] = '#ffffff';
			skin['CONTENT_BG_COLOR'] = '#ffffff';
			skin['CONTENT_LINK_COLOR'] = '#0000cc';
			skin['CONTENT_TEXT_COLOR'] = '#333333';
			skin['CONTENT_SECONDARY_LINK_COLOR'] = '#7777cc';
			skin['CONTENT_SECONDARY_TEXT_COLOR'] = '#666666';
			skin['CONTENT_HEADLINE_COLOR'] = '#000000';
			skin['DEFAULT_COMMENT_TEXT'] = '- add your comment here -';
			skin['HEADER_TEXT'] = 'Comments';
			skin['POSTS_PER_PAGE'] = '4';
			google.friendconnect.container.setParentUrl('/' /* location of rpc_relay.html and canvas.html */);
			google.friendconnect.container.renderWallGadget(
			 { id: 'div-6002340785846368699',
			   site: '07788010716203665169',
			   'view-params':{"disableMinMax":"false","scope":"SITE","allowAnonymousPost":"true","features":"video,comment","startMaximized":"true"}
			 },
			  skin);
			</script>
		</li>
		<?php 	/* Widgetized sidebar, if you have the plugin installed. */
				if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar() ) : ?>
		<li><h2>Author</h2>
		<p>A little something about you, the author. Nothing lengthy, just an overview.</p>
		</li>
		<?php if ( is_404() || is_category() || is_day() || is_month() ||
					is_year() || is_search() || is_paged() ) {
		?> 
		<li>
		<?php /* If this is a 404 page */ if (is_404()) { ?>
		<?php /* If this is a category archive */ } elseif (is_category()) { ?>
		<p>You are currently browsing the archives for the <?php single_cat_title(''); ?> category.</p>

		<?php /* If this is a yearly archive */ } elseif (is_day()) { ?>
		<p>You are currently browsing the <a href="<?php bloginfo('url'); ?>/"><?php echo bloginfo('name'); ?></a> blog archives
		for the day <?php the_time('l, F jS, Y'); ?>.</p>

		<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
		<p>You are currently browsing the <a href="<?php bloginfo('url'); ?>/"><?php echo bloginfo('name'); ?></a> blog archives
		for <?php the_time('F, Y'); ?>.</p>

		<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
		<p>You are currently browsing the <a href="<?php bloginfo('url'); ?>/"><?php echo bloginfo('name'); ?></a> blog archives
		for the year <?php the_time('Y'); ?>.</p>

		<?php /* If this is a monthly archive */ } elseif (is_search()) { ?>
		<p>You have searched the <a href="<?php echo bloginfo('url'); ?>/"><?php echo bloginfo('name'); ?></a> blog archives
		for <strong>'<?php the_search_query(); ?>'</strong>. If you are unable to find anything in these search results, you can try one of these links.</p>

		<?php /* If this is a monthly archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
		<p>You are currently browsing the <a href="<?php echo bloginfo('url'); ?>/"><?php echo bloginfo('name'); ?></a> blog archives.</p>

		<?php } ?>

		</li>
	<?php }?>
	</ul>
	<ul role="navigation">
		<li><h2>Archives</h2>
			<ul>
			<?php wp_get_archives('type=monthly'); ?>
			</ul>
		</li>
		<?php wp_list_categories('show_count=1&title_li=<h2>Categories</h2>'); ?>
	</ul>
	<ul>
		<?php endif; ?>
	</ul>
</div>