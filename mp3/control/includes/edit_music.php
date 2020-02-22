<?php
	$id			= $_GET['id'];
	$err		= "";
	$rs 		= NULL;	
	if($_POST)
	{ 
		$rs 			= $_POST; 
		$title			= trim($rs['title']); 
		$riddim_id		= $rs['riddim_id'];	
		$credit_amount	= trim($rs['credit_amount']); 
		
		$_POST['title'] = addslashes(trim($rs['title']));	
		$_POST['detail']= addslashes(trim($rs['detail']));
		$_POST['label'] = addslashes(trim($rs['label']));		
		 
		
		if(empty($title)         ){$err  .= "Title is required.<br>"; unset($_POST);}
		if(empty($riddim_id)     ){$err  .= "Riddim is required.<br>"; unset($_POST);}
		if(!isset($rs['artiste'])){$err  .= "Artiste(s) required.<br>"; unset($_POST);}
		if(empty($credit_amount) ){$err  .= "Credit amount required.<br>"; unset($_POST);}
		if(!empty($err)          ){echo "<span class='err'>$err</span>";}
	}

	if(isset($_POST) && $_POST)
	{
		if($siteObj->updateMusicRecord($_POST,$id))
		{ 
			if(!file_exists(UPLOADDIR."sample_{$id}.mp3"))
			{
				header("location: includes/ffmpeg.php?id=$id");
			}
			else
			{
				header("location: index.php?action=list_music");
			}
		}
	}
	
	$artiste = $siteObj->getArtiste();
	
	if(!isset($rs))
	{
		if(!empty($id))
		{
			$rs = $comObj->getDataById("odb_mp3",$id);
			$mp3Artiste = $siteObj->getArtisteByMusic($id);
		}
	}

	$btnTitle 	= (empty($id))? "Add" : "Update";
	$frmTitle	= (empty($id))? "Add" : "Edit";
		
	$riddim = $comObj->getHtmlListControlData("odb_riddims","name","id","name","ASC");
	/*delete user from selecting list*/
	if(!empty($mp3Artiste)){foreach($mp3Artiste as $key => $value){unset($artiste[$key]);}}
?>
<script type="text/javascript" src="../js/jquery-ui-1.8.1.custom.min.js"></script>
<div id="artistelist">
	<h1>Artiste list</h1>
    <ul id="gallery" class="gallery">
    <?php 
		if(!empty($artiste)){
			foreach($artiste as $key => $value)
			{
	?>
        <li class="ui-widget-content ui-corner-tr">
            <?php echo cleanString($value);?><input type="hidden" name="artiste[]" value="<?php echo $key;?>" />
            <a href="link/to/trash/script/when/we/have/js/off" title="add artiste to this song" class="ui-icon ui-icon-trash"></a>
        </li>
    <?php 
			} 
		}
	?>
    </ul>
</div>
<form name="f" action="" method="post" enctype="multipart/form-data" >
<h1><?php echo $frmTitle;?> music info</h1>
<p><label for="title">Title<font class="required">*</font></label><input type="text" name="title" id="title" value="<?php echo textBoxFix($rs['title']);?>" /></p>
<p>
	<label for="riddim_id">Riddim<font class="required">*</font></label>
    <select name="riddim_id" id="riddim_id">
    <option value="">Select riddim</option>
    <?php 
		if(!empty($riddim))
		{
			foreach($riddim as $key => $value){ 
	?>
    	<option value="<?php echo $key;?>" <?php echo ($key == $rs['riddim_id'])?"selected":"";?> ><?php echo cleanString($value);?></option>
    <?php 
			}
		}
	?>
    </select>
</p>
<p><label for="label">Label</label><input type="text" name="label" id="label" value="<?php echo textBoxFix($rs['label']);?>" /></p>
<p id="trash" >
	<?php 
		if(!empty($mp3Artiste)){
			echo '<ul class="gallery ui-helper-reset">';
			foreach($mp3Artiste as $key => $value){
	?>
    
        <li class="ui-widget-content ui-corner-tr">
            <?php echo cleanString($value);?><input type="hidden" name="artiste[]" value="<?php echo $key;?>" />
            <a href="link/to/recycle/script/when/we/have/js/off" title="Recycle this image" class="ui-icon ui-icon-refresh"></a>
        </li>
    <?php 
			} 
			echo '</ul>';
		}
	?>
</p> 
<p><label for="keywords">Keywords</label><input type="text" name="keywords" id="keywords" value="<?php echo cleanString($rs['keywords']);?>" /></p>
<p><label for="detail">Detail</label><textarea name="detail" id="detail"><?php echo cleanString($rs['detail']);?></textarea></p>
<p><label for="credit_amount">Credit amount<font class="required">*</font></label><input type="text" name="credit_amount" id="credit_amount" size="5" maxlength="5" onkeypress="return numbersOnly(event, false)" value="<?php echo cleanString($rs['credit_amount']);?>" /></p>
<p><input type="submit" value="<?php echo $btnTitle;?>..." /> </p>
</form>
<script type="text/javascript">
	$(function() {
		// there's the gallery and the trash
		var $gallery = $('#gallery'), $trash = $('#trash');

		// let the gallery items be draggable
		$('li',$gallery).draggable({
			cancel: 'a.ui-icon',// clicking an icon won't initiate dragging
			revert: 'invalid', // when not dropped, the item will revert back to its initial position
			containment: $('#demo-frame').length ? '#demo-frame' : 'document', // stick to demo-frame if present
			helper: 'clone',
			cursor: 'move'
		});

		// let the trash be droppable, accepting the gallery items
		$trash.droppable({
			accept: '#gallery > li',
			activeClass: 'ui-state-highlight',
			drop: function(ev, ui) {
				deleteImage(ui.draggable);
			}
		});

		// let the gallery be droppable as well, accepting items from the trash
		$gallery.droppable({
			accept: '#trash li',
			activeClass: 'custom-state-active',
			drop: function(ev, ui) {
				recycleImage(ui.draggable);
			}
		});

		// image deletion function
		var recycle_icon = '<a href="link/to/recycle/script/when/we/have/js/off" title="Recycle this image" class="ui-icon ui-icon-refresh"></a>';
		function deleteImage($item) {
			$item.fadeOut(function() {
				var $list = $('ul',$trash).length ? $('ul',$trash) : $('<ul class="gallery ui-helper-reset"/>').appendTo($trash);

				$item.find('a.ui-icon-trash').remove();
				$item.append(recycle_icon).appendTo($list).fadeIn(function() {
					$item.animate({ width: '48px' }).find('img').animate({ height: '36px' });
				});
			});
		}

		// image recycle function
		var trash_icon = '<a href="link/to/trash/script/when/we/have/js/off" title="Delete this image" class="ui-icon ui-icon-trash"></a>';
		function recycleImage($item) {
			$item.fadeOut(function() {
				$item.find('a.ui-icon-refresh').remove();
				$item.css('width','96px').append(trash_icon).find('img').css('height','72px').end().appendTo($gallery).fadeIn();
			});
		}

		// image preview function, demonstrating the ui.dialog used as a modal window
		function viewLargerImage($link) {
			var src = $link.attr('href');
			var title = $link.siblings('img').attr('alt');
			var $modal = $('img[src$="'+src+'"]');

			if ($modal.length) {
				$modal.dialog('open')
			} else {
				var img = $('<img alt="'+title+'" width="384" height="288" style="display:none;padding: 8px;" />')
					.attr('src',src).appendTo('body');
				setTimeout(function() {
					img.dialog({
							title: title,
							width: 400,
							modal: true
						});
				}, 1);
			}
		}

		// resolve the icons behavior with event delegation
		$('ul.gallery > li').click(function(ev) {
			var $item = $(this);
			var $target = $(ev.target);

			if ($target.is('a.ui-icon-trash')) {
				deleteImage($item);
			} else if ($target.is('a.ui-icon-zoomin')) {
				viewLargerImage($target);
			} else if ($target.is('a.ui-icon-refresh')) {
				recycleImage($item);
			}

			return false;
		});
	});
</script>