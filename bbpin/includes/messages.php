<?php 
$userId = $_SESSION['BBPINWORLD']['id'];
$rs = $obj->getMessages($userId);
unset($_SESSION['BBPINWORLD']['newMessage']);
?>
<div class="boxStyle1">
    <h2><?php echo $locale['menu.messages'];?></h2>
    <ul class="listing">
    <?php 
    if($rs){
        $alt = true;
        foreach($rs as $row){
            $altStyle = ($alt)? '' : 'even';
            $alt = ($alt)? false : true;
    ?>
        <li class="<?php echo $altStyle;?> ">
            <a href="index.php?action=message&id=<?php echo $row['id']?>" class="title read<?php echo $row['is_read'];?>"><?php echo $row['subject'];?></a>
            <hr />
            <p>
                <small class="right" style="padding-top:4px;"><?php echo date($locale['date.long'], strtotime($row['date_added']));?></small>
                <small><b><?php echo ($row['mtype']=='send')? 'Sent to' : 'From';?>:</b> <a href="profile_<?php echo $row['account_id']?>.html" class="mesAccount"><?php echo $row['fullname']?></a></small>
        	</p>
        </li>
    <?php }
    }else{ echo "<span class='error'>No messages!!!</span>";}
    ?>
    </ul>
</div>    