<?php
/*
* English File
*/
// Top Menu
$locale['php.locale']       = 'en_EN';
$locale['lang.dir']         = 'ltr';
$locale['lang']         	= 'english';
$locale['content.type']    	= 'utf-8';
$locale['date.long'] 		= 'l, F d Y. h:i A';
$locale['site.name']    	= 'Jamaicasales.com';

//FOOTER
$locale['about']	= 'About';
$locale['faqs'] 	= 'FAQs';
$locale['privacy']	= 'Privacy Policy';
$locale['terms']	= 'Terms & Conditions';
$locale['feedback']	= 'Feedback/Suggestion';
$locale['contact']	= 'Contact Us';
$locale['credit']	= 'Credit';
$locale['fb.follow']= 'Like our Facebook page';
$locale['tw.follow']= 'Follow @jusbbmpins';
function profileLinkTitle($str){ echo 'view '.strtolower($str) .' profile and get blackberry messenger pin';}
function requestPinTitle($str ){ return 'request blackberry pin form '.strtolower($str);}
function myPinRequest($userId,$email,$fullname){ return 'click <a href="'.DOMAIN.'index.php?action=request-pin&id='.$userId.'&ed='.base64_encode(base64_encode($email)).'" title="'.requestPinTitle($fullname).'" >here</a> to request bbm-pin';}
?>