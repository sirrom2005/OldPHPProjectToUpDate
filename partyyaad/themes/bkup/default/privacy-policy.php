<?php
// force UTF-8 Ø
if (!defined('WEBPATH')) die(); $themeResult = getTheme($zenCSS, $themeColor, 'light');
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <?php zp_apply_filter('theme_head'); ?>
    <meta name="description" content="jamaican party photo gallery, party calendar" >
    <meta name="keywords" content="privacy,policy" > 
    <meta name="author" content="rohan (iceman) morris" >
    <title><?php echo getBareGalleryTitle(); ?> :: Privacy policy</title>
    <meta http-equiv="content-type" content="text/html; charset=<?php echo LOCAL_CHARSET; ?>" />
    <link rel="stylesheet" href="<?php echo pathurlencode($zenCSS); ?>" type="text/css" />
</head>
<body>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<?php include_once('includes/header.php'); ?>
<?php zp_apply_filter('theme_body_open'); ?>
<div id="main">
    <div id="gallerytitle">
        <h2 id="privacypolicypage">Partyaad.com Privacy Policy</h2>
    </div>
    <div id="padbox">

 <strong>What information do we collect?</strong> <br>
    <br>
  We   collect information from you when you register on our site, place an   order, subscribe to our newsletter, respond to a survey or fill out a   form. <br>
  <br>
  When ordering or registering on our site, as appropriate,   you may be asked to enter your: name, e-mail address, mailing address   or phone number. You may, however, visit our site anonymously.<br>
  <br>
  Google,   as a third party vendor, uses cookies to serve ads on your site.  Google's use of the DART cookie enables it to serve ads to your users   based on their visit to your sites and other sites on the Internet.  Users may opt out of the use of the DART cookie by visiting the Google   ad and content network privacy policy..<br>
  <br>
  <strong>What do we use your information for?</strong> <br>
  <br>
  Any of the information we collect from you may be used in one of the following ways: <br>
  <br>
  ; To personalize your experience<br>
  (your information helps us to better respond to your individual needs)<br>
  <br>
  ; To improve our website<br>
  (we continually strive to improve our website offerings based on the information and feedback we receive from you)<br>
  <br>
  ; To improve customer service<br>
  (your information helps us to more effectively respond to your customer service requests and support needs)<br>
  <br>
  <br>
  ; To send periodic emails<br>
  <blockquote>The   email address you provide for order processing, may be used to send you   information and updates pertaining to your order, in addition to   receiving occasional company news, updates, related product or service   information, etc.</blockquote>
  <br>
  <br>
  <strong>Do we use cookies?</strong> <br>
  <br>
  Yes   (Cookies are small files that a site or its service provider transfers   to your computers hard drive through your Web browser (if you allow)   that enables the sites or service providers systems to recognize your   browser and capture and remember certain information.<br>
  <br>
  <strong>Do we disclose any information to outside parties?</strong> <br>
  <br>
  We   do not sell, trade, or otherwise transfer to outside parties your   personally identifiable information. This does not include trusted third   parties who assist us in operating our website, conducting our   business, or servicing you, so long as those parties agree to keep this   information confidential. We may also release your information when we   believe release is appropriate to comply with the law, enforce our site   policies, or protect ours or others rights, property, or safety.   However, non-personally identifiable visitor information may be provided   to other parties for marketing, advertising, or other uses.<br>
  <br>
  <strong>Third party links</strong> <br>
  <br>
  Occasionally, at our discretion, we may include or offer third party   products or services on our website. These third party sites have   separate and independent privacy policies. We therefore have no   responsibility or liability for the content and activities of these   linked sites. Nonetheless, we seek to protect the integrity of our site   and welcome any feedback about these sites.<br>
  <br>
  <strong>California Online Privacy Protection Act Compliance</strong><br>
  <br>
  Because   we value your privacy we have taken the necessary precautions to be in   compliance with the California Online Privacy Protection Act. We   therefore will not distribute your personal information to outside   parties without your consent.<br>
  <br>
  <strong>Online Privacy Policy Only</strong> <br>
  <br>
  This online privacy policy applies only to information collected through our website and not to information collected offline.<br>
  <br>
  <strong>Your Consent</strong> <br>
  <br>
  By using our site, you consent to our privacy policy.<br>
  <br>
  <strong>Changes to our Privacy Policy</strong> <br>
  <br>
  If   we decide to change our privacy policy, we will post those changes on   this page, and/or update the Privacy Policy modification date below. <br>
  <br>
  <small><b>This policy was last modified on: <i>Saturday, February 18, 2012</i></b></small>
    
    <hr />
    <div class="fb-like" data-send="true" data-layout="button_count" data-width="450" data-show-faces="true" data-font="arial"></div> 
    </div>
</div>
<?php include_once('includes/footer.php'); ?>
</body>
</html>