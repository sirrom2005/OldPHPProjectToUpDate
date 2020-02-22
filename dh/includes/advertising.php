<div id="products" class="contenPage">
    <div class="bg">
        <h2><?php echo $contentPage['title']; ?></h2>		
		<?php echo cleanHtml($contentPage['body']); ?>
		<p>&nbsp;</p>
		<form name="ads" method="get" action="<?php echo DOMAIN;?>advertising_order.html">
			<input type="submit" value="Order Now!!" />
		</form>
    </div>
</div>