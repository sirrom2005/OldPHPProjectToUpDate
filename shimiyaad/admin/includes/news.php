<?php
$rs = $comObj->getData('news_articles',NULL,'date_added',"DESC" );
if(empty($rs)){ echo "<span class='error'>no news found...</span>"; return;}
?>
<h2>News listing</h2>
<ol>
<?php 
$alt = true;
foreach($rs as $row){
$altStyle = ($alt)? '' : 'even'; 
$alt 	  = ($alt)? false: true;
?>
	<li class="<?php echo $altStyle; ?>">
    	<a href="javascript:delPost(<?php echo $row['id']; ?>);" class="remove" title="remove this"></a>
		<a href="index.php?action=add-news&id=<?php echo $row['id'];?>" ><?php echo cleanString($row['title']);?></a>
        <small><?php echo date('l, F d Y.', strtotime($row['news_date']));?></small>
    </li>
<?php } ?>
</ol>
<script>
function delPost(id)
{
	if(confirm("You are about to delete this news post")){
		window.location = "index.php?action=del-news&id=" + id;
	}
}
</script>