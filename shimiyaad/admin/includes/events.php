<?php
$rs = $comObj->getData('event',NULL,'event_date',"DESC" );
if(empty($rs)){ echo "no events found..."; return;}
?>

<h2>Event listing</h2>
<ol>
<?php 
$alt = true;
foreach($rs as $row){
$altStyle = ($alt)? '' : 'even'; 
$alt 	  = ($alt)? false: true;
?>
	<li class="<?php echo $altStyle; ?>">
    	<a href="javascript:delPost(<?php echo $row['id']; ?>,'<?php echo base64_encode($row['image_name']); ?>');" class="remove" title="remove this"></a>
    	<a href="index.php?action=add-event&id=<?php echo $row['id']; ?>" class="edit" title="edit this event"></a>
		<?php echo cleanString($row['title']);?>
        <small><?php echo date('l, F d Y.', strtotime($row['event_date']));?></small>
    </li>
<?php } ?>
</ol>
<script>
function delPost(id,f)
{
	if(confirm("You are about to delete this event")){
		window.location = "index.php?action=del-events&id=" + id + "&f=" + f;
	}
}
</script>