<?php
    include_once 'init.php';
    $_SESSION['page'] = 'home';  
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Baymac - Home</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="css/coin-slider.css" />
<link rel="stylesheet" href="css/bannerstyle.css" media="all" type="text/css" />
<script type="text/javascript" src="js/cufon-yui.js"></script>
<script type="text/javascript" src="js/droid_sans_400-droid_sans_700.font.js"></script>
<!--<script type="text/javascript" src="js/cufon-titillium-900.js"></script>-->
<script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="js/script.js"></script>
<script type="text/javascript" src="js/coin-slider.min.js"></script>
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
        <?php if(isset($_GET['action']) && $_GET['action']=='confirm'){ ?>
          <p class="infopost" style="margin-bottom:30px;"></p>
          <p>You have now completed the registration process.</p>
          <p> <a href="login.php">Login</a> to have access to all content on this site.</p>        
        
        <?php } else { ?>

          <h2><span>Baymac</span> Global Partnerships - Securing your health and future</h2>
          <p class="infopost"></p>
          <div class="clr"></div>
          <div class="img"><img src="images/img1.jpg" width="177" height="213" alt="" class="fl" />
          
           <img src="images/logo_bupa.jpg" style="margin:10px 0 0 0;" />
          <img src="images/logo_hcc.jpg" style="margin:10px 0 0 0;" />
          <img src="images/logo_star.jpg" style="margin:10px 0 0 0;" />
          </div>
          <div class="post_content">
            <p>Baymac Management Services Ltd (Baymac), provides management consultancy
services to our corporate and individual clients in the areas of business start up,
Human Resource and Human Asset management solutions, staff allocation, and the
development of procedures and policies to manage challenges in the initial start up
phases of a company, as well as during significant growth phases of an organization.<br /><br />

Over the years Baymac has proven itself as a reliable service provider to its clients
continuously providing workable solutions in the area of business development
and management while sourcing better products and overall value for its clients.
This has driven Baymac to establish strategic alliances which allow us to refer
our corporate and individual clients to providers of global insurance and wealth
management services. Baymac has created strategic partnerships with these
providers offering consultancy services to our partner companies on various
industry human resource benefit requirements while being certain that our partner
companies will provide the requisite services to our clients at the highest standards.<br /><br />

For the protection of our clients Baymac has only established relationships with
companies and organizations that are highly regulated and which operate within a
regulatory regime that ensures transparency and fair trade.<br /><br />

Baymac is proud to provide turn key solutions for business start up operations,
to assist in developing Human Resource and Human Asset Management expertise
and to provide you with the contact, information and referral solutions for your
corporate and personal health and wealth requirements.<br /><br />

</p>
            <p class="spec"><!--<a href="apply_now.php" class="rm">Apply Now &raquo;</a> <a href="apply_now.php" class="com"><span></span></a>--></p>
          </div>
          <?php } ?>
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
