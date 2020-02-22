<?
	include_once("../classes/news.class.php");
	include_once("../classes/image_resize.php");
	include_once("../js/FCKeditor/fckeditor.php" );
	
	$newsObj = new news();
	
	$id 			= $_GET['id'];
	$filePath 	    = NEWS_IMG_PATH;
	$btnTxt 		= (empty($id))? "Add" : "Save";
	$titleTxt 		= (empty($id))? "Add" : "Edit";
	
	if($_POST)
	{
		$rs 			= $_POST;
		$title 			= trim($_POST['title']);
		$intro_text		= trim($_POST['intro_text']);
		$detail			= trim($_POST['detail']);
		
		if($_FILES)
		{
			$tmpPath  = $_FILES['news_image']['tmp_name'];
			$filename = $_FILES['news_image']['name'];
		
			$uploadImage = $comObj->uploadFile( $filename, $tmpPath, $filePath, array('jpeg', 'jpg', 'gif') );
			
			if(!empty($uploadImage))
			{
				$img['image'] = $uploadImage;
				@$tn1 = new thumbNail( $img, $filePath, $filePath, 104 );
				@$tn2 = new thumbNail( $img, $filePath, $filePath, 200 );
				@unlink($filePath.$uploadImage);
			}
			$_POST['news_image'] = $uploadImage;
		}
		
		$error = "";
		if(empty($title))
		{
			$error .= "Title is required.<br>";
			unset($_POST);
		}
		if(empty($intro_text))
		{
			$error .= "Intro text is required.<br>";
			unset($_POST);
		}
		if(empty($detail))
		{
			$error .= "News detail is required.<br>";
			unset($_POST);
		}		
		echo "<div class='error'>$error</div>";
	}
	
	if($_POST)
	{		
		if(empty($id))
		{
			//add
			$newsObj->addNews( $_POST );
		}
		else
		{
			//edit
			$newsObj->updateNews( $_POST, $id );
		}
		echo "<script> location='index.php?action=list_news'; </script>";
		echo "<meta http-equiv='refresh' content='0;index.php?action=list_news' />";
	}
	
	if(isset($id))
	{
		$rs = $newsObj->getNewsById($id);
	}
?>

<form name="f" action="" method="post" enctype="multipart/form-data" >
<table>
  <tr><th colspan="2" class="header"><?=$titleTxt?> News</th></tr>
  <tr>
    <th>Tile<font class="required">*</font></th>
    <td><input type="text" name="title" value="<?=cleanString($rs['title'])?>" class="controlClass1" /></td>
  </tr>
  <tr>
    <th>Publish Date</th>
    <td>
    <input type="text" name="date" value="<?=$rs['date']?>" size="8" />
    <a href="javascript:showCal('date')"><img src="images/calendar.jpg"  border="0"/></a><b>[yyyy-mm-dd]</b>    </td>
  </tr>
  <tr>
    <th>&nbsp;</th>
    <td>
    	<input type="radio" value="1" name="article_type" id="article_type1" checked="checked"/><label for="article_type1">News Article</label>
        <input type="radio" value="2" name="article_type" id="article_type2" <?=($rs['article_type']==2)? "checked" : "" ?> /><label for="article_type2">Event Review</label>
    </td>
  </tr>
  <tr>
  	<th>&nbsp;</th>
  	<td><input type="checkbox" value="1" name="enable" id="enable" <?=($rs['enable']==1)? "checked" : "" ?> /><label for="enable">Enable</label></td>
  </tr>
  <tr>
    <th valign="top">Intro Text<font class="required">*</font></th>
    <td><textarea name="intro_text" cols="80" rows="4"><?=cleanString($rs['intro_text'])?></textarea></td>
  </tr>
  <tr>
    <th valign="top">
    	Detail<font class="required">*</font><br />    </th>
    <td>
    <?php
	$sBasePath = "../js/FCKeditor/";
	$oFCKeditor = new FCKeditor('detail') ;
	$oFCKeditor->BasePath	= $sBasePath ;
	$oFCKeditor->PluginTest = 'Default';
	$oFCKeditor->ToolbarSet = 'Default';
	$oFCKeditor->Width 	    = '100%';
	$oFCKeditor->Height 	= '400';
	$oFCKeditor->Value		= cleanString($rs['detail']);
	$oFCKeditor->Create() ;
	?>    </td>
  </tr>
  <tr>
    <th valign="top">Image</th>
    <td>
    	<? if( fileExists($filePath."200_".$rs['news_image']) ){  ?> 
        	<img src="../classes/thumbnail.class.php?image=<?=NEWS_THUM_FOLDER."200_".$rs['news_image']?>&w=200" /><br />
            [<a href="javascript:removeImg('<?=base64_encode($rs['news_image'])?>');">Remove</a>]
            <input type="hidden" name="news_image" value="<?=$rs['news_image']?>" />
        <? }else{ ?>
    		<input type="file" name="news_image" />
        <? } ?>    </td>
  </tr>
  <tr>
    <td colspan="2" class="btnCell"><input type="submit" value="<?=$btnTxt?>..." /></td>
  </tr>
</table>
</form>

<script>
function removeImg(file)
{
	if(confirm("Are you sure you want to delete this file?"))
	{
		window.location = "includes/delete_news_img.php?file=" + file + "&id=<?=$id?>";
	}	
}
</script>