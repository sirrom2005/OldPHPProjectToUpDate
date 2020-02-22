<?php
    include_once 'init.php';
    $_SESSION['page'] = 'quote';
    $quotePosted = false;
    if(isset($_POST['name'])) {
    
        require_once('./PHPMailer/class.phpmailer.php');
        $mail = new PHPMailer();

        // Set email sender/recipients
        $mail->SetFrom($mail_from, 'Baymac Website');
        $mail->AddAddress($quote_email_recipient);

        /* Set Email Body and text alternative for non-html email clients */
        $mail->Subject    = "Baymac Website Quote Request";
        $body =  "Quote Request Details:<br /><br />Title: ".htmlentities($_POST['title'])."<br />";
        $body .= "Name: ".htmlentities($_POST['name'])."<br />";
        $body .= "Email: ".htmlentities($_POST['email'])."<br />";
        $body .= "Address -<br />".nl2br(htmlentities($_POST['address']))."<br />";
        $body .= "Airline: ".htmlentities($_POST['airline'])."<br />";
        $body .= "City: ".htmlentities($_POST['city'])."<br />";
        $body .= "Country: ".$countries[$_POST['country']]."<br />";
        $mail->MsgHTML($body);
        $mail->AltBody    = "To view the message, please use an HTML compatible email viewer.";
        $mail->Send();
    
        $quotePosted = true;
    }
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Baymac - Get a Quote</title>
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
        $('#quoteform').submit(function() {
            if($('#name').val().length) {
                if(validateEmail($('#email').val()) ) {
                    if($('#airline').val().length) {
                        return true;
                    } else {
                        alert('Airline or Company is required.');
                        $('#airline').focus();
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
          <h2>Get A Quote</h2>
          <p class="infopost"><!--Posted <span class="date">on 11 sep 2018</span> by <a href="#">Admin</a> &nbsp;&nbsp;|&nbsp;&nbsp; Filed under <a href="#">templates</a>, <a href="#">internet</a>--></p>
          <div class="clr"></div>
          <div class="article">
          <?php if($quotePosted) { ?>
            <div style="margin-top:40px;">Your quote request has been submitted.</div>
          <?php  } else { ?>
          <form action="quote.php" method="post" id="quoteform">
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
                <label for="name">Full Name<sup style="color:red;">*</sup> (required)</label>
                <input id="name" name="name" class="text" />
              </li>
              <li>
                <label for="email">Email Address<sup style="color:red;">*</sup> (required)</label>
                <input id="email" name="email" class="text" />
              </li>
              <li>
                <label for="address">Address</label>
                <textarea id="address" name="address" rows="5" cols="50"></textarea>
              </li>
              <li>
                <label for="airline">Airline or Company<sup style="color:red;">*</sup> (required)</label>
                <input id="airline" name="airline" class="text" />
              </li>
              <li>
                <label for="city">City</label>
                <input id="city" name="city" class="text" />
              </li>
              <li>
                <label for="country">Country</label>
                <select id="country" name="country">
                <option value=" " selected>(please select a country)</option>
                <?php 
                asort($countries);
                foreach($countries as $id => $country) {
                    echo '<option value="'.$id.'">'.$country.'</option>';
                }
                ?>
                </select>
              </li>
              <li>
                <input type="image" name="imageField" id="imageField" src="images/submit.gif" class="send" />
                <div class="clr"></div>
              </li>
            </ol>
          </form>
          <?php }?>
          </div>
          <div class="clr"></div>
        </div>
        <div class="article">
          <!--<h2><span>Worldwide</span> Coverage</h2>-->
          <p class="infopost"><!--Posted <span class="date">on 29 aug 2016</span> by <a href="#">Admin</a> &nbsp;&nbsp;|&nbsp;&nbsp; Filed under <a href="#">templates</a>, <a href="#">internet</a>--></p>
          <div class="clr"></div>
          <!--<div class="img"><img src="images/img2.jpg" width="177" height="213" alt="" class="fl" /></div>-->
          <div class="post_content">
           <!-- <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec libero. Suspendisse bibendum. Cras id urna. <a href="#">Morbi tincidunt, orci ac convallis aliquam, lectus turpis varius lorem, eu posuere nunc justo tempus leo.</a> Donec mattis, purus nec placerat bibendum, dui pede condimentum odio, ac blandit ante orci ut diam. Cras fringilla magna. Phasellus suscipit, leo a pharetra condimentum, lorem tellus eleifend magna, eget fringilla velit magna id neque. Curabitur vel urna. In tristique orci porttitor ipsum. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec libero. Suspendisse bibendum. Cras id urna. Morbi tincidunt, orci ac convallis aliquam.</p>
            <p><strong>Aenean consequat porttitor adipiscing. Nam pellentesque justo ut tortor congue lobortis. Donec venenatis sagittis fringilla.</strong> Etiam nec libero magna, et dictum velit. Proin mauris mauris, mattis eu elementum eget, commodo in nulla. Mauris posuere venenatis pretium. Maecenas a dui sed lorem aliquam dictum. Nunc urna leo, imperdiet eu bibendum ac, pretium ac massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nulla facilisi. Quisque condimentum luctus ullamcorper.</p>
            <p class="spec"><a href="#" class="rm">Read more &raquo;</a> <a href="#" class="com"><span></span></a></p>-->
          </div>
          <div class="clr"></div>
        </div>
        <!--<p class="pages"><small>Page 1 of 2</small> <span>1</span> <a href="#">2</a> <a href="#">&raquo;</a></p>-->
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
