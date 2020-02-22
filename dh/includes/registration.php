<div id="products" class="contenPage">
    <div class="bg">
        <h2>Registration</h2>
		<fieldset><legend>Registration</legend>
			<?php echo $mess2;?>
			<form name="reg" method="post" action="">
			<ul class="table">
				<li class="title">Full name</li><li><input type="text" name="full_name" value="<?php echo $full_name;?>" /><?php echo $errName;?></li>
				<li class="title">Username</li><li><input type="text" name="user_name" value="<?php echo $user_name;?>" /><?php echo $errUser;?></li> 
				<li class="title">Email</li><li><input type="text" name="email"  value="<?php echo $email;?>" /><?php echo $errEmail;?></li>
                <li class="title">&nbsp;</li><li>Are you software pubsliher/developer?<br /><input type="radio" name="developer" checked="checked" value="0" />No<input type="radio" name="developer" value="1" />Yes </li>
                <li class="title">&nbsp;</li><li><small>Password will be emailed to you.</small></li>
				<li class="title">&nbsp;</li><li><input type="submit" name="registration" value="Submit" /></li>
			</ul>
			</form>
		</fieldset>
		<a name="rempass"></a>
		<fieldset><legend>Forget password</legend>
			<?php echo $mess;?>
			<form name="reg" method="post" action="">
			<ul class="table">
				<li class="title">Enter Your Email</li><li><input type="text" name="email_reminder" value="<?php echo $e_mail;?>" /><?php echo $errEmail2;?></li>
				<li class="title">&nbsp;</li><li><input type="submit" name="forget_pass" value="Submit" /></li>
			</ul>
			</form>
		</fieldset>
		<div class="clear"></div>
    </div>
</div>