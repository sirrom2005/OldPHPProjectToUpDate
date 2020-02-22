<?php
    include_once 'init.php';
    $_SESSION['page'] = 'contact';
    
    $contactPosted = false;
    if(isset($_POST['name'])) {
    
        require_once('./PHPMailer/class.phpmailer.php');
        $mail = new PHPMailer();

        // Set email sender/recipients
        $mail->SetFrom($mail_from, 'Baymac Website');
        $mail->AddAddress($quote_email_recipient);

        /* Set Email Body and text alternative for non-html email clients */
        $mail->Subject    = "Baymac Website Contact Submission";
        $body = "Name: ".htmlentities($_POST['name'])."<br />";
        $body .= "Email: ".htmlentities($_POST['email'])."<br />";
        $body .= "Company: ".htmlentities($_POST['company'])."<br />";
        $body .= "Phone: ".htmlentities($_POST['phone'])."<br />";
        $body .= "Query -<br />".nl2br(htmlentities($_POST['message']))."<br />";
        $mail->MsgHTML($body);
        $mail->AltBody    = "To view the message, please use an HTML compatible email viewer.";
        $mail->Send();
    
        $contactPosted = true;
    }
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Baymac - Contact Us</title>
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
    function validateEmail(email) { 
        var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email);
    } 
    $(function() {
        $('#sendemail').submit(function() {
            if($('#name').val().length) {
                if(validateEmail($('#email').val()) ) {
                    if($('#email').val() == $('#confirm').val()) {
                        if($('#message').val().length) {                    
                            return true;
                        } else {
                            alert('A query is required.');
                            $('#message').focus();
                        }
                    } else {
                        alert('Email addresses do not match.');
                        $('#confirm').focus();
                    }
                } else {
                    alert('A valid email is required.');
                    $('#email').focus();
                }
            } else {
                alert('Name is required.');
                $('#name').focus();
            }
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
           <h2><span>Contact Us</span></h2>
            <p class="infopost"><!--Posted <span class="date">on 11 sep 2018</span> by <a href="#">Admin</a> &nbsp;&nbsp;|&nbsp;&nbsp; Filed under <a href="#">templates</a>, <a href="#">internet</a>--></p>
          <div class="clr"></div>
          <?php if($contactPosted) { ?>
            <p></p>
          <?php } else { ?>
              <p></p>
          <?php } ?>
        </div>
        <div class="article">
          <?php if(!$contactPosted) { ?>
          <h2><span>Send us</span> mail</h2>
          <div class="clr"></div>
          <form action="contact.php" method="post" id="sendemail">
            <ol>
              <li>
                <label for="name">Name<sup style="color:red;">*</sup> (required)</label>
                <input id="name" name="name" class="text" />
              </li>
              <li>
                <label for="email">Email Address<sup style="color:red;">*</sup> (required)</label>
                <input id="email" name="email" class="text" />
              </li>
              <li>
                <label for="confirm">Confirm Email<sup style="color:red;">*</sup> (required)</label>
                <input id="confirm" name="confirm" class="text" />
              </li>
              <li>
                <label for="company">Company</label>
                <input id="company" name="company" class="text" />
              </li>
              <li>
                <label for="phone">Telephone</label>
                <input id="phone" name="phone" class="text" />
              </li>
              <li>
                <label for="message">Query<sup style="color:red;">*</sup> (required)</label>
                <textarea id="message" name="message" rows="8" cols="50"></textarea>
              </li>
              <li>
                <input type="image" name="imageField" id="imageField" src="images/submit.gif" class="send" />
                <div class="clr"></div>
              </li>
            </ol>
          </form>
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
