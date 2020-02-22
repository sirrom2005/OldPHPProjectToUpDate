<?php
    include_once 'init.php';
    $_SESSION['page'] = '';

    $objCore->initFormController();
    
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Baymac - Login</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="css/coin-slider.css" />
<script type="text/javascript" src="js/cufon-yui.js"></script>
<script type="text/javascript" src="js/droid_sans_400-droid_sans_700.font.js"></script>
<!--<script type="text/javascript" src="js/cufon-titillium-900.js"></script>-->
<script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="js/script.js"></script>
<script type="text/javascript" src="js/coin-slider.min.js"></script>
<script type="text/javascript">
$(function() {
    $('#form_passwprocess').submit(function() {
		$('#imageField').hide();
		$('#ajaxld').show();
		var url = 'inc/corecontroller.php?ts='+new Date().getTime();
		$.post(url, $('#form_passwprocess').serialize(), function(data, textStatus){
		    if(textStatus == "success"){
			    if(data.result == "1"){
				    //register sucessful
				    $('#ajaxld').hide();
				    var htmlstr = "";
				    htmlstr += "<p>Soon you will receive an email at "+$('#email').val()+" with a link to reset your password.</p>";
				    $('#pagecontent').html(htmlstr);
			    }
			    else if(data.result == "-1"){
				    for(var i=0; i < data.errors.length; i++ ){
					    if(data.errors[i].value!="")
						    $("#"+data.errors[i].name+'_error').html("<div class='errorimg'>"+data.errors[i].value+"</div>");
				    }
				    $('#ajaxld').hide();
				    $('#imageField').show();
			    }
			    else{
				    $('#ajaxld').hide();
				    $('#imageField').show();
				    $('#pagecontent').html("<p>An error occured while processing your request. Please try again later.</p>");
			    }
		    }
		    else if(textStatus == "error")//TODO - it can be of more types!
		    {
				    $('#ajaxld').hide();
				    $('#imageField').show();
				    $('#pagecontent').html("<p>An error occured while processing your request. Please try again later.</p>");
		    }
		},"json");
		return false;
    });
    
    $('#form_resetprocess').submit(function() {
		$('#imageField').hide();
		$('#ajaxld').show();
		var url = 'inc/corecontroller.php?ts='+new Date().getTime();
		$.post(url, $('#form_resetprocess').serialize(), function(data, textStatus){
		    if(textStatus == "success"){
			    if(data.result == "1"){
				    //register sucessful
				    $('#ajaxld').hide();
				    var htmlstr = "";
				    htmlstr += "<p>Password successfully reset. <a href='login.php'>Log in</a></p>";
				    $('#pagecontent').html(htmlstr);
			    }
			    else if(data.result == "-1"){
				    for(var i=0; i < data.errors.length; i++ ){
					    if(data.errors[i].value!="")
						    $("#"+data.errors[i].name+'_error').html("<div class='errorimg'>"+data.errors[i].value+"</div>");
				    }
				    $('#ajaxld').hide();
				    $('#imageField').show();
			    }
			    else{
				    $('#ajaxld').hide();
				    $('#imageField').show();
				    $('#pagecontent').html("<p>An error occured while processing your request. Please try again later.</p>");
			    }
		    }
		    else if(textStatus == "error")//TODO - it can be of more types!
		    {
				    alert("error ajax");
				    $('#ajaxld').hide();
				    $('#_imageField').show();
				    $('#pagecontent').html("<p>An error occured while processing your request. Please try again later.</p>");
		    }
		},"json");
        return false;    
    });

});
</script>
</head>
<body>
<div class="main">
  <div class="header">
    <?php include('header.php'); ?>
  </div>
  <div class="content">
    <div class="content_resize">
      <div class="mainbar">
        <div class="article">
          <?php
          if(isset($_GET['forget'])) {
          ?>        
           <h2><span>Password Reset</span></h2>
          <?php
          } elseif(isset($_GET['reset'])) {
          ?>
           <h2><span>Password Reset</span></h2>
          <?php
          } else {
          ?>
           <h2><span>Login</span></h2>
          <?php
          }
          ?>
            <p class="infopost">
          <div class="clr"></div>
        </div>
        <div class="article">
          <div class="clr"></div>

          <?php
          if(isset($_GET['forget'])) {
          ?>
          <div id="pagecontent">
          <p>Enter your email address to receive information on how to reset your password:</p>
                <form action="" method="" name="form_passwprocess" id="form_passwprocess">
                <ol>
                  <li>

                    <label for="email">Email<sup style="color:red;">*</sup> (required)</label>
                    <input id="email" name="email" class="text"  maxlength="120" value="<?php echo $objCore->getFormController()->value("email"); ?>" />
                    <div style="clear:both;"></div>
					<div id="email_error" class="error">
                    </div>

                  </li>
                  <li>
                    <input type="image" name="imageField" id="imageField" src="images/submit.gif" class="send" />
                    <img class="ajaxload" style="display:none;margin:16px 0 0 20px;" id="ajaxld" src="images/ajax-loader.gif"/>
                    <div class="clr"></div>
                  </li>
                </ol>
                    <input type="hidden" name="forgetpasswordaction" value="1"/>
                </form>
           </div>
          <?php
          } elseif(isset($_GET['reset']))  {
          ?>
          <div id="pagecontent">
            <p>Please choose a new password for your account:</p>
            <form name="form_resetprocess" id="form_resetprocess" action="" method="" class="login">
              <ol>
              <li>
                <label for="pass">Password<sup style="color:red;">*</sup> (required)</label>
                <input type="password" "id="password" name="password" class="text inplaceError" maxlength="20" value="" />
              </li>
              <li>
                <label for="pass">Repeat Password<sup style="color:red;">*</sup> (required)</label>
                <input type="password" "id="password2" name="password2" class="text inplaceError" maxlength="20" value="" />
              </li>
                  <li>
                    <input type="image" name="imageField" id="imageField" src="images/submit.gif" class="send" />
                    <img class="ajaxload" style="display:none;margin:16px 0 0 20px;" id="ajaxld" src="images/ajax-loader.gif"/>
                    <div class="clr"></div>
                  </li>
              </ol>
                <input type="hidden" name="resetpasswordaction" value="1"/>
                <div id="password_error" class="error">
                </div>

            </form>
            <br />
                <p>Remembered your old password? <a href="login.php">Back to login</a></p>
          </div>
          <?php } else { ?>
          <p>You must log in to access certain areas of this site. If you do not yet have an account then click <a href="register.php">here</a> to register.</p>
            <form name="login" id="form_login" action="inc/corecontroller.php" method="POST" class="login">
            <ol>

              <li>

                <label for="email">Email<sup style="color:red;">*</sup> (required)</label>
                <input id="email" name="email" class="text"  maxlength="120" value="<?php echo $objCore->getFormController()->value("email"); ?>" />
              </li>
              <li>
                <label for="pass">Password<sup style="color:red;">*</sup> (required)</label>
                <input type="password" "id="pass" name="pass" class="text" maxlength="20" value="<?php echo $objCore->getFormController()->value("pass"); ?>" />
              </li>
              <li>
                <?php echo $objCore->getFormController()->error("email"); ?>
                <?php echo $objCore->getFormController()->error("pass"); ?>

                <input type="hidden" name="loginaction" value="1"/>
                <input type="hidden" name="redirect" value="<?php echo $_GET['redirect']; ?>">
                <input type="image" name="imageField" id="imageField" src="images/submit.gif" class="send" />
                <img class="ajaxload" style="display:none;margin:16px 0 0 20px;" id="ajaxld" src="images/ajax-loader.gif"/>
                <div class="clr"></div>
              </li>


            </ol>
          </form>
            <p>Did you forget your password? Click <a href="login.php?forget=1">here</a><br /></p>
          <?php } ?>
        </div>
      </div>
          
      <div class="sidebar">
          <?php include('sidebar.php'); ?>
      </div>
      <div class="clr"></div>
    </div>
  </div>
  <div class="fbg">
    <?php include('bottom.php'); ?>
  </div>
  <div class="footer">
    <?php include('footer.php'); ?>
  </div>
</div>
</body>

</html>
