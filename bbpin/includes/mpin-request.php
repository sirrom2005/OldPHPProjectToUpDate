<?php 
$userId = $_SESSION['BBPINWORLD']['id'];
$rs = $obj->getUserPinRequest($userId);
?>
<h2>My BBM-Pins Request</h2>
<ul class="listing">
<?php 
if($rs){
    $alt = true;
    foreach($rs as $row){
        $altStyle = ($alt)? '' : 'even';
        $alt = ($alt)? false : true;
?>
    <li class="<?php echo $altStyle;?>"><span class="right" style="padding-left:10px;"><?php echo strtoupper($row['bbmpin']);?></span><a href="profile_<?php echo $row['id']?>.html"><?php echo $row['fullname']?></a> <?php echo $row['str1']?></li>
<?php }
}else{ echo "<span class='error'>No request!!!</span>";}
?>
</ul>
 