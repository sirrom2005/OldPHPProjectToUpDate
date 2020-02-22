<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


// Change PIN
$locale['change.pin.lookup']            ='Change PIN';
$locale['change.pin.msg']               ='Enter new PIN';
$locale['change.pin.old.name']          ='Old PIN:';
$locale['change.pin.name']              ='New PIN:';
$locale['change.pin.retype']            ='Confirm New PIN:';

$locale['old-pin-missing']          = 'Please enter old PIN';
$locale['retype-pin-missing']       = 'Please confirm new PIN';
$locale['pin-mismatched']           = 'PIN mismatched.';
$locale['pin-missing']              = 'Please enter a valid Pin';
$locale['min-pin-length']           ="The minimum PIN length is four(4) numbers.";
$locale['pin-not-numeric']          ='The PIN number has to be only numbers.';
$locale['pin-start-zero']           ='PIN should not begin with a zero (0) digit.';
$locale['pin-in-special-sequence']  ='<h2  class="" langid="">PIN Cannot Changed</h2>'.
                                    '<p>New PIN does not meet the minimum requirements.<br/>'.
                                    'The PIN should meet the following:' .
                                    '<ul><li>Should be four (4) digits in length</li>'.
                                    '<li>Should not be like (1111, 1234, 2222 etc).</li>'.
                                    '<li>Digits should not be repeated more than 2 two times</li>' .
                                    '<li>Should not begin with a zero (0) digit</li>'.
                                    '</ul></p>';

'Clients should not be able to create PINS like (1111, 1234, 2222 etc).
                                        Digits should not be repeated more than 2 two times';


$locale["user.profile.button.reset"]                    ="&nbsp;&nbsp;Reset&nbsp;&nbsp;";
$locale["user.profile.button.save"]                    ="&nbsp;&nbsp;Save&nbsp;&nbsp;";



$locale["pinNotChangedMessage"]='<div id="pinNotChangedMessage" class=" external">
                <h2  class="header bottom" langid="">PIN Not Changed</h2>
                <p class="left" style="text-align:left;" langid="">Your PIN has not changed.{SYSMESSAGE}<br/><br></p>

            </div>';

//User Profile - Security Verification
$locale["user.profile.security.verification.title"]     ="User Profile - Security Verification";
$locale["security.questions.lookup.msg"]     ="An email verification was sent to your email account. Please enter the verification code below";
$locale["user.profile.verification.msg"]     ="User Profile Verification";
$locale["user.profile.security.pin"]     ="Security PIN";
$locale["user.profile.email.verification.code"]     ="Email verification Code";
$locale["user.profile.security.question.1"]     ="Security Question #1: ";
$locale["user.profile.security.question.2"]     ="Security Question #2: ";
$locale["ser.profile.resend.email"]     ="Resend Email";
$locale["user.profile.security.verification.save.button"]     ="&nbsp;Save&nbsp;";
$locale["user.profile.security.verification.cancel.button"]     ="&nbsp;Cancel&nbsp;";



$locale["UserPreferencesSavedMessage"]='<div id="UPSavedMessage" class=" clear">
                <h3>User Profile</h3>
                <p class="left" style="text-align:left;" langid="">Your user preferences have successfully saved.<br/><br></p>

            </div>';

$locale['EMAILSECUIRTYKEY']= '<div id="UPSavedMessage" class=" clear">
                <h3>User Profile</h3>
                <p class="left" style="text-align:left;" langid="">An email verification code has been sent to your email.<br/><br></p>

            </div>';


$locale["pinChangedMessage"]='<div id="pinChangedMessage" class=" external">
                <h3  class="" langid="">PIN Changed</h3>
                <p class="left" style="text-align:left;" langid="">Your PIN has successfully changed.<br/><br><br></p>

            </div>';
$locale["pinNotChangedMessage"]='<div id="pinNotChangedMessage" class=" external">
                <h3  class="" langid="">PIN Not Changed</h3>
                <p class="left" style="text-align:left;" langid="">Your PIN has not changed.{SYSMESSAGE}<br/><br><br></p>

            </div>';

?>
