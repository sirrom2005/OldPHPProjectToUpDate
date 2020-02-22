<form action="" method="post" name="regform" id="regform">
    <input autocomplete="off" class="textbox" type="text" placeholder="enter your first name" name="firstname" required />
    <input autocomplete="off" class="textbox" type="text" placeholder="enter your last name" name="lastname" required />
    <input autocomplete="off" class="textbox" type="email" placeholder="enter your email address" name="email" required />
    <input autocomplete="off" class="textbox" type="password" placeholder="enter your password" name="pass" required />
    <input autocomplete="off" class="textbox" type="password" placeholder="confirm your password" name="pass2" required />
    <input type="submit" value="<?php _t('submit');?>" class="btn" /><input type="reset" value="<?php _t('reset');?>" class="btn" />
</form>


<form action="" method="post" name="signinform" id="signinform">
    <input autocomplete="off" class="textbox" type="email" placeholder="enter your email address" name="email" required />
    <input autocomplete="off" class="textbox" type="password" placeholder="enter your password" name="pass" required />
    <input type="submit" value="<?php _t('login');?>" class="btn" />
</form>