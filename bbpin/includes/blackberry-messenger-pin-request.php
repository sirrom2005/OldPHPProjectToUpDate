<?php 
$userId = $_SESSION['BBPINWORLD']['id'];
$rs = $obj->getUserPinRequest($userId);
?>
<div class="boxStyle1">
    <h2><?php echo $locale['my.pin.requ'];?></h2>
    <ul class="listing">
    <?php 
    if($rs){
        $alt = true;
        foreach($rs as $row){
            $altStyle = ($alt)? '' : 'even';
            $alt = ($alt)? false : true;
    ?>
        <li class="<?php echo $altStyle;?>">
            <span class="right"><?php echo strtoupper($row['bbmpin']);?></span>
            <a href="profile_<?php echo $row['id']?>.html"><?php echo $row['fullname'];?></a> <?php echo $row['str1'];?>
            <hr />
            <p><small style="text-align:right; display:block;"><?php echo date($locale['date.long'], strtotime($row['date_added']));?></small></p>
        </li>
    <?php }
    }else{ echo "<span class='error'>No request!!!</span>";}
    ?>
    </ul>
</div>    