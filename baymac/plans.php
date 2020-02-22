<?php
    include_once 'init.php';
    $_SESSION['page'] = 'plans';
    
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Baymac - Plans</title>
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
          <h2>Baymac Plans</h2>
          <p class="infopost"><!--Posted <span class="date">on 11 sep 2018</span> by <a href="#">Admin</a> &nbsp;&nbsp;|&nbsp;&nbsp; Filed under <a href="#">templates</a>, <a href="#">internet</a>--></p>
          <div class="clr"></div>
          <div class="article">
            <ul style="margin-top:40px;">
           
                
                 <?php foreach($plans as $plan) { ?>
           
             <li><strong><?php echo htmlentities($plan['title']); ?></strong> - <a href="<?php echo htmlentities($plan['link']); ?>">Download</a></li>
            <?php } ?>
            </ul>
          </div>
          <div class="clr"></div>
        </div>
        <div class="article">
         <h3>Atlas Travel Insurance<br /><span>Short-term travel health insurance for individuals traveling outside their home country.</span></h3>
         
         <div class="article_img">
         	<a href="https://www.hccmis.com/atlastravel/?referid=995770022A&language=en-US "><img src="images/plan_img1.jpg" width="157" height="99" /></a>
         </div>


<p>Whether you are traveling for business or pleasure, Atlas Travel insurance may be just what you're looking for. Plans are available from a minimum of 5 days or more. In addition to medical benefits for injuries and illnesses, Atlas Travel Insurance includes benefits for emergency medical evacuation, terrorism, political evacuation, and adventure sports.</p>
 <div class="clr"></div>
 
 <a href="https://www.hccmis.com/atlastravel/?referid=995770022A&language=en-US" class="bott_btn" ><img src="images/banner_bott_btn2.png" style="margin:10px 0 0 0;"/></a>
 <div class="clr"></div>
 
  <h3>Atlas Group Travel Insurance
<span>Short-term international health insurance for 5 or more traveling abroad</span></h3>

		 <div class="article_img">
         	<a href="https://www.hccmis.com/atlasgroup/?referid=995770022A&language=en-US "><img src="images/plan_img2.jpg" width="153"   /></a>
         </div>

<p>Atlas Group travel insurance is tailored for groups of 5 or more U.S. and non-U.S. Citizens traveling outside their home country for 5 days or more. This plan is appropriate for missionaries, students and business executives. It features medical coverage, emergency medical evacuation, and repartriation of remains.</p>

 <div class="clr"></div>
 
 <a href="https://www.hccmis.com/atlasgroup/?referid=995770022A&language=en-US" class="bott_btn" ><img src="images/banner_bott_btn2.png" style="margin:10px 0 0 0;"/></a>
 <div class="clr"></div>

<h3>Atlas Professional<span>
International health coverage for business travel professionals taking multiple trips throughout the year</span></h3>

<div class="article_img">
         	<a href="https://www.hccmis.com/atlaspro/?referid=995770022A&language=en-US "><img src="images/plan_img5.jpg" width="153" /></a>
         </div>

<p>Atlas Professional is available to executives and their families who require annual medical insurance with coverage for multiple trips of 30 days duration or less. If you maintain medical coverage in your home country, Atlas Professional is designed to take some of the risk out of your international business travel.</p>

 <div class="clr"></div>
 
  <a href="https://www.hccmis.com/atlaspro/?referid=995770022A&language=en-US" class="bott_btn" ><img src="images/banner_bott_btn2.png" style="margin:10px 0 0 0;"/></a>

 <div class="clr"></div>
 

 <h3>CitizenSecure<br /><span>International medical insurance for individuals and families.</span></h3>
     

    
         <div class="article_img">
         	<a href="https://www.worldtrips.com/quotes/ic/default.asp?referID=995770022A "><img src="images/plan_img4.jpg" width="157" height="99" /></a>
         </div>

<p>CitizenSecure is available to individuals in locations around the world. This renewable plan offers comprehensive medical coverage worldwide. The option to exclude coverage within the US and Canada is available. Dental coverage and sports benefits are also available as an optional upgrade.  CitizenSecure is ideal for professionals in all industries and is particularly favoured by pilots, aircraft engineers and air traffic controllers within the aviation industry.</p>
 <div class="clr"></div>
  <a href="https://www.worldtrips.com/quotes/ic/default.asp?referID=995770022A"><b>Click here for more information</b></a>
 <div class="clr"></div>
	
    
    <h3>CitizenSecure Economy<br /><span>
	Affordable international medical for individuals and families.</span></h3>

		<div class="article_img">
         	<a href="https://www.worldtrips.com/quotes/ice/default.asp?referID=995770022A"><img src="images/plan_img9.jpg" width="157" height="99" /></a>
         </div><p>CitizenSecure Economy is a schedule benefit insurance plan available to individuals in locations around the world. This plan is appropriate for those who need 		comprehensive coverage at a price to fit their budget's needs. Dental coverage and sports benefits are also available as an optional upgrade. CitizenSecure Economy is ideal for individuals in all industries and is favoured by Cabin Crew within the aviation industry.</p>
 <div class="clr"></div>
  <a href="https://www.worldtrips.com/quotes/ice/default.asp?referID=995770022A"><b>Click here for more information</b></a>
 <div class="clr"></div>


 <h3>StudentSecure
<span>Worldwide health coverage for students pursuing their education abroad.</span></h3>

 		<div class="article_img">
         	<a href="https://www.hccmis.
com/studentsecure/?
referid=995770022A&lang
uage=en-US"><img src="images/plan_img3.jpg" width="157" height="99" /></a>
         </div>

<p>StudentSecure is designed to meet the insurance needs of international students traveling inside or outside of the United States. Whether you are looking for individual coverage or coverage for the entire family, our Select, Budget and Smart options have the features you need. Each plan includes coverage for emergency medical evacuation, sports, mental health, maternity and more!</p>

  <div class="clr"></div>
  <a href="https://www.hccmis.
com/studentsecure/?
referid=995770022A&lang
uage=en-US"><b>Click here for more information</b></a>
 <div class="clr"></div>
 
 
 
<h3>Bupa Complete Care</h3>
<div class="article_img">
         	<a href="pdf/Bupa%20Complete%20Care-2.pdf"><img src="images/plan_img6.jpg" /></a>
         </div>
<p>Bupa Complete Care is one of the most comprehensive product in the insurance market, offering extensive coverage for both in-patient and out-patient treatment, congenital conditions, and maternity coverage.</p>


<p>With Bupa Complete Care, you may choose any medical provider Worldwide or in Latin America Only, there are additional benefits for members that use a hospital within the Bupa provider network, such as direct payments and no additional out-of-pocket expenses aside from deductibles. Regardless of your choice of coverage, you and your family will have access to a substantial range of options in the best hospitals and medical facilities.</p>
<a href="quote.php" class="bott_btn"><img src="images/banner_bott_btn2.png" /></a>
    
    <div class="clr"></div>

<h3>Bupa Diamond Care</h3>
<div class="article_img">
         	<a href="pdf/Bupa Diamond Care-1.pdf"><img src="images/plan_img7.jpg" /></a>
         </div>
<p>Bupa Diamond Care is the most comprehensive product in Bupa Care suite, specifically designed for unlimited coverage with access to the very best hospitals and doctors anywhere in the world.  You and your family will have guaranteed access to comprehensive services, top benefits and worldwide coverage including transplant procedures and congenital conditions.</p> 



<p>You can choose any hospital for your treatment and there are additional benefits for members who use a hospital within the Bupa provider network.  Such as direct payment and no additional expenses aside from the deductible.</p>
<a href="quote.php" class="bott_btn"><img src="images/banner_bott_btn2.png" /></a>
    
    <div class="clr"></div>
<h3>Bupa Superior</h3>
<div class="article_img">
         	<a href="pdf/Bupa Superior.pdf"><img src="images/plan_img8.jpg" /></a>
         </div>
<p>Superior's coverage is truly unique.  Most international health insurance plans limit the services you are covered for - with superior you will find that the sky is the limit.  Superior's unrivalled services offer you the ultimate degree of convenience. Superior is aimed at those who never settle for anything but the ultimate solution  - it is the insurance plan our prominent clients have requested.</p>
  <div class="clr"></div>
<a href="quote.php" class="bott_btn" ><img src="images/banner_bott_btn2.png" style="margin:10px 0 0 0;"/></a>
    
    <div class="clr"></div>



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
