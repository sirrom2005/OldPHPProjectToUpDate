<link rel="stylesheet" href="css/bannerstyle.css" media="all" type="text/css" />
<script src="js/core.min.js" type="text/javascript"></script>
<script>

$(document).ready(function() {

	
	// Here be the homepage carousel code!	
	$('.transition').cycle({ 
		fx:     'fade', 
		timeout: 0,
		pager:  '.banner_btns ul',
	    pagerAnchorBuilder: function(idx, slide) {
	        // return selection string for existing anchor
	        return 'banner_btns ul li:eq(' + (idx) + ') a';
		},
		pause:	true
	});
	
	function onBefore() { 
		var pos = $(".activeSlide").next().offset().top; //get position of the element *after* .activeSlide
		$("#marker").animate({top: pos}); //move marker to this position
	};
	
	$('.banner_btns ul li:eq(0)').live('mouseenter', function(){
		$('.transition').cycle(0); 
		return false; 
		
	});
	
	$('.banner_btns ul li:eq(1)').live('mouseenter', function(){
		$('.transition').cycle(1); 
		return false; 
		
	});
	
	$('.banner_btns ul li:eq(2)').live('mouseenter', function(){
		$('.transition').cycle(2); 
		return false; 
		
	});
	
	$('.banner_btns ul li:eq(3)').live('mouseenter', function(){
		$('.transition').cycle(3); 
		return false; 
		
	});
	
	$('.banner_btns ul li:eq(4)').live('mouseenter', function(){
		$('.transition').cycle(4); 
		return false; 
		
	});
	
	
	$('.banner_btns ul li:eq(5)').live('mouseenter', function(){
		$('.transition').cycle(5); 
		return false; 
		
	});
	
	
});
</script>  
   
    <div class="header_resize">
     
      <div class="logo">
        <a href="index.php"><span><img src="images/logo.png" border="0" /></span></a></div>
      <div class="clr"></div>
      <div class="menu_nav">
        <ul>
          <li<?php if($_SESSION['page']=='home') echo ' class="active"'; ?>><a href="index.php"><span>Home Page</span></a></li>
          <li<?php if($_SESSION['page']=='plans') echo ' class="active"'; ?>><a href="plans.php"><span>Plans</span></a></li>
          <li<?php if($_SESSION['page']=='about') echo ' class="active"'; ?>><a href="about.php"><span>About Us</span></a></li>
          <li<?php if($_SESSION['page']=='faq') echo ' class="active"'; ?>><a href="faq.php"><span>FAQ</span></a></li>
          <li<?php if($_SESSION['page']=='contact') echo ' class="active"'; ?>><a href="contact.php"><span>Contact Us</span></a></li>
         
        </ul>
      </div>
      <div class="clr"></div>
      <div class="banner_wrap">
		<div class="banner">
    	<div id="carousel-slides">
    	<div class="transition">
        <img src="images/banner6.jpg" />
        <img src="images/banner3.jpg" />
    	<img src="images/banner4.jpg" />
        <img src="images/banner1.jpg" />
        <img src="images/banner2.jpg" />
        <img src="images/banner5.jpg" />
        </div>
        </div>
        
        <div class="banner_btns">
       
       <ul>
       
       <li>
         <a href="https://www.worldtrips.com/quotes/ic/default.asp?referID=995770022A "> <div class="banner_btn_1 ">
        
        </div></a>
       
       </li>
       
         <li>  <a href="https://www.worldtrips.com/quotes/ice/default.asp?referID=995770022A">
        <div class="banner_btn_2">  
        
         </div> </a>
       </li>
       
         <li> <a href="https://www.hccmis.com/atlastravel/?referid=995770022A&language=en-US">
         <div class="banner_btn_3"> 
         
         </div></a>
       </li>
       
         <li>
         <a href="https://www.worldtrips.com/quotes/ic/default.asp?referID=995770022A "> <div class="banner_btn_4">
        
         </div> </a>
       </li>
       
         <li><a href="https://www.worldtrips.com/quotes/ic/default.asp?referID=995770022A ">
        <div class="banner_btn_5"> 
         
         </div></a>
       </li>
       
         <li> <a href="https://www.hccmis.com/studentsecure/?referid=995770022A&language=en-US">
         <div class="banner_btn_6"> 
         
         </div> </a>
       </li>
       
       </ul>
       </div>
        
    </div>
    
    <a href="brochures.php" class="bott_btn"><img src="images/banner_bott_btn1.png" /></a>
    <a href="plans.php" class="bott_btn"><img src="images/banner_bott_btn2.png" /></a>
    <font>* Conditions Apply</font>
    
    <div class="clear"></div>
</div>
      <div class="clr"></div>
    </div>

