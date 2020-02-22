<?php
    include_once 'init.php';
    $_SESSION['page'] = '';

    require_once("inc/core.php");

    $objCore = new Core();

    $objCore->initSessionInfo();
   
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Baymac - Registration</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="css/autosuggest/autosuggest_inquisitor.css" type="text/css" media="screen" charset="utf-8" />
<link rel="stylesheet" type="text/css" href="css/coin-slider.css" />
<script type="text/javascript" src="js/cufon-yui.js"></script>
<script type="text/javascript" src="js/droid_sans_400-droid_sans_700.font.js"></script>
<!--<script type="text/javascript" src="js/cufon-titillium-900.js"></script>-->
<script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="js/script.js"></script>
<script type="text/javascript" src="js/coin-slider.min.js"></script>
<script type="text/javascript" language="javascript" src="js/autosuggest/bsn.AutoSuggest_2.1.3.js" charset="utf-8"></script>
<script type="text/javascript" language="javascript" src="js/register/register.js"></script>
<script type="text/javascript">
    $(function() {
		var options_country = {
			script:"inc/suggestion.php?json=true&limit=10&field=country&",
			varname:"input",
			json:true,
			shownoresults:false,
			maxresults:10,
			callback: function (obj) { $('#country_code').val(obj.id); }
		};
		var as_json_country = new bsn.AutoSuggest('country', options_country);

		$("#form_register").submit(function(){
			$('#imageField').hide();	
			$('#ajaxld').show();
			var url = 'inc/corecontroller.php?ts='+new Date().getTime();
			$.post(url, $('#form_register').serialize(), function(data, textStatus) {
			    if(textStatus == "success"){
					    if(data.result == "1"){
						    //register sucessful
						    $('#ajaxld').hide();
						    var htmlstr = "";
						    htmlstr += "<p>You are just one step away from completing your registration.<br><br> A link has been sent to your email account for you to confirm your registration.</p>";
						    $('#reg').html(htmlstr);
					    }
					    else if(data.result == "-2"){
						    $('#ajaxld').hide();
						    $('#reg').html("<p>An error occured during registration. Please try again later.</p>");
					    }
					    else{//errors with form -1
						    for(var i=0; i < data.errors.length; i++ ){
							    if(data.errors[i].value!="")
								    $("#"+data.errors[i].name+'_error').html("<div class='errorimg'>"+data.errors[i].value+"</div>");
						    }
						    $('#ajaxld').hide();
						    $('#imageField').show();
						    //reload the captcha
						    //eval('javascript:Recaptcha.reload()');
					    }
				    //}				
			    }
			    else if(textStatus == "error")
			    {
					    $('#ajaxld').hide();
					    $('#reg').innerHTML = "<span>An error occurred during registration. Please try again later.</span>";
			    }
			
			}, "json");
			return false;

		});
		$('.inplaceError').each(
			function(i) {
				var $this = $(this)
				$this.focus(function(e){
					$("#"+ $this.attr('id') +"_error").html('');
				});
			}
		);
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
           <h2><span>Registration</span></h2>
            <p class="infopost">
          <div class="clr"></div>
        </div>
        <div class="article">
          <div class="clr"></div>
        <?
        /**
        * The user is already logged in, not allowed to register.
        */
        if($objCore->getSessionInfo()->isLoggedIn()) {
            echo "<p>You are already registered and logged in.</p>";
        } else {
        ?>
          <div id="reg">
          <p>Registration is required to access some areas of this site. Please complete the following form to register.</p>
          <form action="" method="post" id="form_register">
            <input type="hidden" name="registeractionx" value="1"/>
            <ol>
              <li>
                <label for="title">Title</label>
                <select id="title" name="title">
                    <option value="Mr">Mr</option>
                    <option value="Mr">Mrs</option>
                    <option value="Mr">Ms</option>
                    <option value="Mr">Miss</option>
                    <option value="Mr">Dr</option>
                </select>
              </li>
              <li>
                <label for="flname">Full Name<sup style="color:red;">*</sup> (required)</label>
                <input class="text inplaceError" id="flname" name="flname" maxlength="100" value="" />
                <div class="error" id="flname_error"></div>
              </li>
              <li>
                <label for="email">Email Address<sup style="color:red;">*</sup> (required)</label>
                <input id="email" name="email" class="text inplaceError" />
                <div class="error" id="email_error"></div>
              </li>
            <?php 
        	if(REPEAT_EMAIL){
        	?>
              <li>
                <label for="confemail">Confirm Email Address<sup style="color:red;">*</sup> (required)</label>
                <input id="confemail" name="confemail" class="text inplaceError" value="" "/>
                <div class="error" id="confemail_error"></div>
              </li>
            <?php 
        	}
            ?>
              <li>
                <label for="address">Address<sup style="color:red;">*</sup> (required)</label>
                <textarea id="address" name="address" rows="5" cols="50" class="inplaceError"></textarea>
                <div class="error" id="address_error"></div>
              </li>
              <li>
                <label for="city">City<sup style="color:red;">*</sup> (required)</label>
                <input id="city" name="city" class="text inplaceError" />
                <div class="error" id="city_error"></div>
              </li>
              <li>
                <label for="country">Country<sup style="color:red;">*</sup> (required)</label>
                <input class="text inplaceError" type="text" id="country" name="country" value=""/>
				<input type="hidden" name="country_code" id="country_code" value="-1"/>
                <div class="error" id="country_error"></div>
              </li>
              <li>
                <label for="phone">Telephone - including country & area code<sup style="color:red;">*</sup> (required)</label>
                <input id="phone" name="phone" class="text inplaceError" />
                <div class="error" id="phone_error"></div>
              </li>
              <li>
                <label for="airline">Airline<sup style="color:red;">*</sup> (required)</label>
                <input id="airline" name="airline" class="text inplaceError" />
                <div class="error" id="airline_error"></div>
              </li>
              <li>
                <label for="pass">Password<sup style="color:red;">*</sup> (required)</label>
                <input type="password" id="pass" name="pass" class="text inplaceError" maxlength="20" value=""/>
                <div class="error" id="pass_error"></div>
              </li>
        	<?php 
        	if(REPEAT_PASSWORD){
        	?>
              <li>
                <label for="confpass">Repeat Password<sup style="color:red;">*</sup> (required)</label>
                <input type="password" id="confpass" name="confpass" class="text inplaceError" maxlength="20" value=""/>
                <div class="error" id="confpass_error"></div>
              </li>
            <?php 
        	}
            ?>
              <li>
                <input type="image" name="imageField" id="imageField" src="images/submit.gif" class="send" />
                <img class="ajaxload" style="display:none;margin:16px 0 0 20px;" id="ajaxld" src="images/ajax-loader.gif"/>
                <div class="clr"></div>
              </li>
            </ol>
          </form>
          </div>
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
