<?php
include_once("../classes/site.class.php");
$obj = new site();
$rs = $obj->getClassifiedListing();
if(empty($rs)){ echo "<span class='error'>no listing found...</span>"; return;}
?>

<h2>Classified listing</h2>
<ol>
<?php 
$alt = true;
foreach($rs as $row){
$altStyle = ($alt)? '' : 'even'; 
$alt 	  = ($alt)? false: true;
?>
	<li class="<?php echo $altStyle; ?>">
    	<a href="javascript:delPost(<?php echo $row['id']; ?>);" class="remove" title="remove this"></a>
		<?php echo cleanString($row['title']);?>
        <small><?php echo $row['category'];?></small>
        <small><?php echo date('l, F d Y.', strtotime($row['date_added']));?></small>
    </li>
<?php } ?>
</ol>
<script>
function delPost(id)
{
	if(confirm("You are about to delete this post")){
		window.location = "index.php?action=del-classified&id=" + id;
	}
}
</script>