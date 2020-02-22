<?php if(empty($_SESSION['ADMIN_USER'])){?>
<span class="err">Your  must <a href="<?php echo DOMAIN;?>vci/">login</a> in first to view your favorites videos...</span>
<?php return; } ?>
<?php
	$favorites = $obj->getFavorites($_SESSION['ADMIN_USER']['id']);
	
	if(!empty($favorites))
	{
		echo "<h1>My Favorites</h1>";
		mediumVideoList($favorites);
	}
	else
	{
		echo "<span class='msg'>You have no favorite video...</span>";
	}
?>

