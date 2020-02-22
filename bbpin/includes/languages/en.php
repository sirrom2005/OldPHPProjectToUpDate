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
$locale['menu.home'] 		= 'Home';
$locale['menu.find.people'] = 'Find Blackberry Pins';
$locale['menu.find.groups'] = 'Find Blackberry Groups';
$locale['menu.messages'] 	= 'My Messages';
$locale['menu.pin.request'] = 'My Pin Request';
$locale['menu.my.profile'] 	= 'My Profile';
$locale['hello'] 			= 'Hello';
$locale['change.password'] 	= 'Change Password';
$locale['logout'] 			= 'Logout';
$locale['login'] 			= 'Login';
$locale['goto.home']		= 'go to '.SITE_NAME.' home page';
$locale['btn.find.user'] 	= 'Find users';
$locale['btn.find.groups'] 	= 'Find groups';
$locale['btn.save'] 		= 'Save';
$locale['btn.del.group'] 	= 'Delete Group';
$locale['warn.mes']			= 'Warning!!!';
$locale['signin']			= 'Sign-in';

$locale['any']				= 'Any';
$locale['my.pin.requ']  	= 'My BBM-Pins Request';
$locale['pin.requ.sent']  	= 'Pin request sent to user, user will be notified of your request.';
$locale['pin.requ.resent']  = 'Pin request already sent to this user.';
$locale['pin.requ.error']  	= 'Error in sending request, please try again later';
$locale['find.pins'] 		= 'Find Blackberry Messenger Pins';
$locale['find.group'] 		= 'Find Blackberry Messenger Groups';
$locale['newest.groups']	= 'Latest Blackberry Messenger Chat Groups';
$locale['pro.incomplete'] 	= '<b>Incomplete profile information</b>You profile information is incomplete.<br />You will not be able to search for other member until you have updated your profile.<br />
							   Click <a href="edit-profile.html">here</a> to complete your profile.';
$locale['pro.missing.photo']= '<b>Missing profile photo</b>To view members with photo you must first upload a photo of your self.<br>click <a href="edit-my-gallery.html">here</a> a add a photo.';
							   
$locale['pin.verified']		= "#bbm pin verified";
$locale['pin.not.verified'] = "#bbm pin not verified";
$locale['male.gender'] 		= 'Male';
$locale['female.gender'] 	= 'Female';
$locale['male.gender.edit']	= 'Man';
$locale['female.gender.edit']= 'Woman';
$locale['status.single'] 	= 'Single';
$locale['status.in a relationship'] = 'In a relationship';
$locale['status.separated'] = 'Separated';
$locale['status.married'] 	= 'Married';
$locale['status.divorce'] 	= 'Divorce';
$locale['status.'."&nbsp;"] = '';
$locale['latest.members']   = 'Blackberry Messenger Users';

//PROFILE
$locale['gender'] 			= 'I am a';
$locale['fname'] 			= 'First Name';
$locale['lname'] 			= 'Last Name';
$locale['age'] 				= 'Age';
$locale['edit.profile'] 	= 'Edit Your Profile';
$locale['edit.gallery'] 	= 'Edit Your Photo Gallery';
$locale['gallery'] 			= 'Photo Gallery';
$locale['add.bbm.group'] 	= 'Add Your BBM Group';
$locale['send.message'] 	= 'Send Message';
$locale['request.bbm.pin'] 	= 'Request BBM-Pin';
$locale['pro.update'] 		= 'Update Profile';
$locale['pro.status'] 		= 'Marital Status';
$locale['pro.gender.pre'] 	= 'Gender Prefrence';
$locale['pro.looking'] 		= 'Looking For';
$locale['pro.country'] 		= 'Country';
$locale['pro.education'] 	= 'Education Level';
$locale['pro.employment'] 	= 'Employment Field';
$locale['pro.about'] 		= 'About Me';
$locale['pro.interest'] 	= 'My Interest';
$locale['pro.dob'] 			= 'Date of Birth';
$locale['leave.comment']	= 'Leave a comment';
$locale['leave.img.comment']= 'Leave a photo comment';
$locale['btn.add.comment'] 	= 'Add comment...';
$locale['btn.add.group'] 	= 'Add Your BBM Group';
$locale['gallery.notice'] 	= 'Please upload at least one image for the other member\'s viewing pleasure.';
$locale['hidden.by.user'] 	= 'Hidden by user';
//GROUP
$locale['group.photo'] 			= 'Group Photo';
$locale['group.add.new'] 		= 'Add New BBM Group';
$locale['group.name'] 			= 'Group Name';
$locale['group.country'] 		= 'Country of Origin';
$locale['group.about'] 			= 'Group Description';
$locale['group.edit'] 			= 'Edit Your Group';
$locale['group.edit.gallery'] 	= 'Edit Group Photo Gallery';
$locale['group.request'] 		= 'Send Group Request';
$locale['group.notice'] 		= 'Depending on some BBM Groups you may not get instant access due to the amount of member\'s request<br />and the limit amount of people that can be in any blackberry group.';
$locale['group.category'] 		= 'Group Category';
$locale['edit.group.photo']		= "Edit Group Photo";
//FOOTER
$locale['about']	= 'About Us';
$locale['faqs'] 	= 'FAQs';
$locale['privacy']	= 'Privacy Policy';
$locale['terms']	= 'Terms & Conditions';
$locale['feedback']	= 'User Feedback';
$locale['contact']	= 'Contact Us';
$locale['fb.follow']= 'Like our Facebook page';
$locale['tw.follow']= 'Follow @jusbbmpins';
function profileLinkTitle($str){ echo 'view '.strtolower($str) .' profile and get blackberry messenger pin';}
function requestPinTitle($str ){ return 'request blackberry pin form '.strtolower($str);}
function myPinRequest($userId,$email,$fullname){ return 'click <a href="'.DOMAIN.'index.php?action=request-pin&id='.$userId.'&ed='.base64_encode(base64_encode($email)).'" title="'.requestPinTitle($fullname).'" >here</a> to request bbm-pin';}
function sendGroupRequest($groupId,$email){ return 'click <a href="index.php?action=group-request&groupid='.$groupId.'&ge='.base64_encode(base64_encode($email)).'">here</a> to send group request.';}
?>