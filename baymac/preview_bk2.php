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

          <h2><span>APG</span>Health Care Plan</h2>
          <p class="infopost"></p>
          <div class="clr"></div>
          <div class="img"><img src="images/img1.jpg" width="177" height="213" alt="" class="fl" /></div>
          <div class="post_content">
            <p>Baymac in collaboration with  ihi Bupa and APG provides customers with the APG Health Care Plan which puts your health first by offering insurance plans specially designed for pilots and their families requiring international health coverage and advice on health and wellbeing.
<br /><br />


Ihi Bupa has built up a global network of business partners and well-respected medical consultants. We are authorized
and regulated by the Financial Services Authority (the UK insurance authority). ihi Bupa is a part of the worldwide health insurance.
<br /><br />


The APG Plan, being truly international, provides you with the ability to freely choose consultation and treatment any where in the world, including coverage for hospitalization, outpatient treatment, medicine, and medical evacuation.
<br /><br />


Bupa International has over 35 years' expertise in caring  for the healthcare needs of customers around the
globe, covering almost 800,000 people in 190 countries.
<br /><br />


Bupa International is the world's largest international health insurer for expatriates, providing quality
individual and group medical coverage to people living in their home country or abroad. 
</p>
            <p class="spec"><a href="apply_now.php" class="rm">Apply Now &raquo;</a> <a href="apply_now.php" class="com"><span></span></a></p>
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
