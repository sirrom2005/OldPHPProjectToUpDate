<?php include_once("header.php"); ?>
<div id="left_ads">
    <!-- Include the Google Friend Connect javascript library. -->
    <script type="text/javascript" src="http://www.google.com/friendconnect/script/friendconnect.js"></script>
    <!-- Define the div tag where the gadget will be inserted. -->
    <div id="div-5563679128382146782" style="width:160px;"></div>
    <!-- Render the gadget into a div. -->
    <script type="text/javascript">
    google.friendconnect.container.setParentUrl('/' /* location of rpc_relay.html and canvas.html */);
    google.friendconnect.container.renderAdsGadget(
     { id: 'div-5563679128382146782',
       height: 600,
       site: '07788010716203665169',
       'prefs':{"google_ad_client":"ca-pub-7769573252573851","google_ad_host":"pub-6518359383560662","google_ad_slot":"4420278418","google_ad_format":"160x600"}
     });
    </script>
</div>
	<div id="content" class="narrowcolumn" role="main">
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div class="post" id="post-<?php the_ID(); ?>">
		<h2><?php the_title(); ?></h2>
			<div class="entry">
				<?php the_content('<p class="serif">Read the rest of this page &raquo;</p>'); ?>
				<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
			</div>
		</div>
		<?php endwhile; endif; ?>
	<?php edit_post_link('Edit this entry.', '<p>', '</p>'); ?>
	</div>
<?php get_sidebar(); ?>
<?php include_once("footer.php");  ?>