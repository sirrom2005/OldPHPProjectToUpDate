<?
	include_once("connection.php");
	include_once("classes/site.class.php");
	
	$siteObj = new site($db);
	
	$result = $imageList = $siteObj->getImageByProject( $_GET['id'] );
	
	$imageList = "'".$result[0]['image']."'";
	for( $i=1; $i<count($result); $i++ )
	{
		$imageList = $imageList.", '".$result[$i]['image']."'";
	}

	//echo $imageList ; exit;
?>

<LINK REL='stylesheet' HREF="css/default.css" type="text/css">
<style>
	body{
		background:#e7e3e7
	}
</style>

<table align="center">
	<tr>
		<td>
		<img id="main_pic" />
		</td>
	</tr>
	
	<tr>
		<td>	
		<table align="center" width="100" border=0>
			<tr>
				<td><a href="javascript:last_pic();">Back</a></td>
				<td align="right"><a href="javascript:next_pic();">Next</a></td>
			</tr>
			<tr>
				<td align="center" colspan=2><A href="javascript:close();">Close</a></td>
			</tr>
		</table>
		</td>
	</tr>
</table>

<script src="{path}/scripts/script_vars.php" language="javascript"></script>
<script language="javascript">
	var pics = [<?=$imageList?>];
	var gallery_name = "images/gallery/";
	var current_pic = 0;
	var image_array = new Array(pics.length);
	
	document.body.onload = page_loaded;
	preloader();
	
	function page_loaded(){
		load_pic();
	}
	
	function last_pic(){
		if(current_pic <= 0){
			return;
		}
		
		current_pic -=1;
		load_pic();
	}
	
	function next_pic(){
		if(current_pic >= (pics.length-1)){
			return;
		}
	
		current_pic +=1;
		load_pic();
	}
	
	function load_pic(){
		//document.getElementById("main_pic").src = gen_pic_path(pics[current_pic]);
		document.getElementById("main_pic").src = image_array[current_pic].src;
	}
	
	function preloader(){
		for(x=0; x<pics.length; x++){
			i = new Image();
			i.src = gen_pic_path(pics[x]);
			image_array[x] = i;
		}
	}
	
	function gen_pic_path(pic){
		return  gallery_name + "/" + pic;
	}
</script>
