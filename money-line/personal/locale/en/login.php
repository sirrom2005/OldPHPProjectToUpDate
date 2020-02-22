<?php

// used by security tips
$locale['announcement'] = 'Announcement';

// validation messages
$locale['username-missing']         = 'Please enter a user name';
$locale['password-missing']         = 'Please enter a password';
$locale['old-password-missing']     = 'Please enter old password';
$locale['old-pin-missing']          = 'Please enter old PIN';
$locale['retype-password-missing']  = 'Please confirm password';
$locale['retype-pin-missing']       = 'Please confirm new PIN';
$locale['password-mismatched']        = 'Password mismatched.';
$locale['pin-mismatched']           = 'PIN mismatched.';
$locale['email-missing']            = 'Please enter an email';
$locale['pin-missing']              = 'Please enter a valid Pin';
$locale['securityans-missing']      = 'Please answer the security question';
$locale['securitycode-missing']      = 'Please enter the security code';
$locale['min-password-length']      = 'The minimum password length is eight(8) characters.';
$locale['min-pin-length']           ="The minimum PIN length is four(4) numbers.";
$locale['select-security-question'] = 'Please select a security question';
$locale['missing-security-question-answer'] ='Please answer the security question';
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

//security questions
$locale['securityans-incorrect']    = 'Your security answer is incorrect';
$locale['security.questions.lookup.msg'] = 'Answer security questions';
$locale['security.questions.title'] = 'Security Questions';
$locale['login.button']             = '&nbsp;Login&nbsp;';
$locale['back.to.login']            = '&nbsp;Back to login';
$locale['remember.pc']              = 'Remember this PC';

//New or Update Security Questions
$locale['security.questions.new.lookup.msg']='Give an answer to all security questions';
$locale['security.questions.new.title']     = 'Security Questions';
$locale['security.questions.new.label.answer']  ='Answer:';
$locale['security.questions.submit.button']   = '&nbsp;Submit&nbsp;';
$locale["security.questions.new.label.confirm.answer"]="&nbsp;&nbsp;Confirm:";
$locale["security.confirm.answer-missing"]="Please confirm your security answer.";
$locale["security.confirm.answer-mismatch"]="Your security answer and confirmation answer do not match.";


$locale['login.msg']                = 'Enter your Username, Password and Security Answers to sign in';

$locale['user.name']                = 'User Name:';
$locale['pwd']                      = 'Password:';
// forget password
$locale['pwd.usr.lookup']           = 'Forget Password';
$locale['user.pin']                 = 'PIN:';
$locale['pwd.lookup.msg']           = 'Fill out this form to be reminded of your Password.';
$locale['invalidate.user']          = 'Your user name or PIN is incorrect.';
$locale['pwd.usr.lookup']           = 'Forget Password';
$locale['pwd.usr.lookup']           = 'Forget Password';


// verify PIN
$locale['user.pin']                 = 'PIN:';
$locale['verify.pin.lookup.msg']    = 'You are required to submit your PIN for verification before processing.';
$locale['invalidate.user']          = 'Your user name or PIN is incorrect.';
$locale['verify.pin.usr.lookup']    = 'Verify PIN';
$locale['verfiy.pin.submit.button'] = '&nbsp;Submit&nbsp;';

//Secuirty Verification Code

$locale['security.code']                = 'Security Code:';
$locale['securityCode.msg']             = 'A security code has been sent to your Email. Enter security to change password.';
$locale['securityCode.title']           = 'Security Verification Code';
$locale['securityCode.submit.button']   = '&nbsp;Submit&nbsp;';

//Change Password
$locale['change.pwd.retype']            = 'Confirm New Password:';
$locale['change.pwd.name']              = 'New Password:';
$locale['change.pwd.lookup']            = 'Change Password';
$locale['change.pwd.msg']               = 'Enter new password.';
$locale['change.pwd.submit.button']     = '&nbsp;Submit&nbsp;';
$locale['change.pwd.old.name']          = 'Old Password:';
$locale["password.strength"]            =  "Password Strength:";


//Password Confirmation
$locale['change.pwd.retype']           = 'Confirm New Password:';

// Password Changed
$locale['pwd.changed.button']           = '&nbsp;Continue&nbsp;';


// Change PIN
$locale['change.pin.lookup']            ='Change PIN';
$locale['change.pin.msg']               ='Enter new PIN';
$locale['change.pin.old.name']          ='Old PIN:';
$locale['change.pin.name']              ='New PIN:';
$locale['change.pin.retype']            ='Confirm New PIN:';


//*****  Display messages  ****

$locale["passwordDaysToExpiryMessage"]="Your password will expire in {daysToExpiry} day(s). Do you want to change it now?";

$locale["noSQMessage"]='<div id="noSQMessage" class=" external">
                <h2  class="header bottom" langid="">Security Questions</h2>
                <p class="left" style="text-align:left;" langid="">Your security questions are not setup!<br/>It is required that all JMMB customers have their security questions setup.<br><br>Click continue to verify your PIN and setup security questions.</p>

            </div>';

$locale["SQChangedMessage"]='<div id="SQChangedMessage" class=" external">
                <h2  class="header bottom" langid="">Security Questions</h2>
                <p class="left" style="text-align:left;" langid="">Your security questions have successfully setup.<br/><br><br>Click continue to login.</p>

            </div>';


$locale["SQNotChangedMessage"]='<div id="SQNotChangedMessage" class=" external">
                <h2  class="header bottom" langid="">Security Questions</h2>
                <p class="left" style="text-align:left;" langid="">Your security questions have failed to setup.<br/><br><br></p>

            </div>';

$locale["passwordExpireMessage"]='<div id="passwordExpireMessage" class=" external">
                <h2  class="header bottom" langid="">Password Expired</h2>
                <p class="left" style="text-align:left;" langid="">Your password has expired. You must change your password before login.<br/><br>Click continue to change password.<br></p>

            </div>';

$locale["newuserChangePasswordMessage"]='<div id="newuserChangePasswordMessage" class=" external">
                <h2  class="header bottom" langid="">Change Password</h2>
                <p class="left" style="text-align:left;" langid="">You must change your password before login.<br/><br>Click continue to change password.<br></p>

            </div>';


$locale["forcePasswordChangeMessage"]='<div id="forcePasswordChangeMessage" class=" external">
                <h2  class="header bottom" langid="">Change Password</h2>
                <p class="left" style="text-align:left;" langid="">You must change your password before login.<br/><br>Click continue to change password<br></p>

            </div>';


$locale["forcePINChangeMessage"]='<div id="forcePINChangeMessage" class=" external">
                <h2  class="header bottom" langid="">Change PIN</h2>
                <p class="left" style="text-align:left;" langid="">You must change your PIN before login.<br/><br>Click continue to change your PIN.<br></p>

            </div>';

$locale["passwordChangedMessage"]='<div id="passwordChangedMessage" class=" external">
                <h2  class="header bottom" langid="">Password Changed</h2>
                <p class="left" style="text-align:left;" langid="">Your password has successfully changed.<br/><br></p>
            </div>';

$locale["pinChangedMessage"]='<div id="pinChangedMessage" class=" external">
                <h2  class="header bottom" langid="">PIN Changed</h2>
                <p class="left" style="text-align:left;" langid="">Your PIN has successfully changed.<br/><br></p>

            </div>';
$locale["pinNotChangedMessage"]='<div id="pinNotChangedMessage" class=" external">
                <h2  class="header bottom" langid="">PIN Not Changed</h2>
                <p class="left" style="text-align:left;" langid="">Your PIN has not changed.{SYSMESSAGE}<br/><br></p>

            </div>';

$locale["passwordNotChangedMessage"]='<div id="passwordNotChangedMessage" class=" external">
                <!--<h2  class="header bottom" langid="">Password Not Changed</h2>-->
                <p>{SYSMESSAGE}<br/><br></p>

            </div>';

$locale["signupProcessCompleteMessage"]='<div id="signupProcessCompleteMessage" class="complete-process-tick external">
                <h2  class="header bottom" langid="">Signup Process Complete</h2>
                <p>You have successfully completed your sign up process.<br/>
                    <ul>
                        <li>Your password has successfully changed,</li>
                        <li>Your PIN has successfully changed, and</li>
                        <li>Your security questions has successfully setup.</li>
                     </ul>

                    <br></p>

            </div>';

$locale["unregisterPCMessage"]='<div id="unregisterPCMessage" class=" external">
                <h2  class="header bottom" langid="">Remember Computer</h2>
                <p class="left" style="text-align:left;" langid="">Your computer is not registered. As a result, you are required to answer two(2) security questions next time you login.<br/><br>Click ok to continue.<br></p>

            </div>';

$locale["PCnotunregisterMessage"]='<div id="PCnotunregisterMessage" class=" external">
                <h2  class="header bottom" langid="">Remember Computer</h2>
                <p class="left" style="text-align:left;" langid="">Your computer is still registered. As a result, you are not required to answer two(2) security questions next time you login.<br/><br></p>

            </div>';

$locale["welcomeMessage"]='<div id="welcomeMessage" class=" external">
    <h2  class="header bottom" langid="">New Online Customer</h2>
    <p>Welcome to JMMB Moneyline online Banking. As a new online customer, you are required to do the following:</p>
     <ul><li>Change your temporary password,</li>
        <li>Change your temporary PIN, and</li>
        <li>Setup your security questions and answers.</li>
</ul>
<p>These changes will take few minutes to complete. We hope you will have a great online banking experience with JMMB Moneyline.<br/><br></p></div>';


$locale["changePasswordnPinMessage"]='<div id="changePasswordnPinMessage" class=" external">
    <h2  class="header bottom" langid="">Change Password and PIN</h2>
    <p>You are required to do the following before login:</p>
     <ul><li>Change your password, and</li>
        <li>Change your PIN</li>
</ul>
<p>These changes will take few minutes to complete. We hope you will have a great online banking experience with JMMB Moneyline.<br/><br>Click continue to proceed.<br></p></div>';



$locale["changePasswordnSQMessage"]='<div id="changePasswordnSQMessage" class=" external">
    <h2  class="header bottom" langid="">Change Password and Set Security Questions</h2>
    <p>You are required to do the following before login:</p>
     <ul><li>Change your password, and</li>
        <li>Setup your security questions and answers.</li>
</ul>
<p>These changes will take few minutes to complete. We hope you will have a great online banking experience with JMMB Moneyline.<br/><br></p></div>';

$locale["changePINnSQMessage"]='<div id="changePINnSQMessage" class=" external">
    <h2  class="header bottom" langid="">Change PIN and Set Security Questions</h2>
    <p>You are required to do the following before login:</p>
     <ul><li>Change your PIN, and</li>
        <li>Setup your security questions and answers.</li>
</ul>
<p>These changes will take few minutes to complete. We hope you will have a great online banking experience with JMMB Moneyline.<br/><br></p></div>';

$locale["changePasswordPINnSQMessage"]='<div id="changePasswordPINnSQMessage" class=" external">
    <h2  class="header bottom" langid="">Change Password,PIN and Set Security Questions</h2>
    <p>You are required to do the following before login:</p>
     <ul><li>Change your password,</li>
        <li>Change your PIN, and</li>
        <li>Setup your security questions and answers.</li>
</ul>
<p>These changes will take few minutes to complete. We hope you will have a great online banking experience with JMMB Moneyline.<br/><br></p></div>';

$locale["changePasswordPinnSQMessage"]='<div id="changePasswordnPinMessage" class=" external">
    <h2  class="header bottom" langid="">Change Password, PIN & Setup Security Questions</h2>
    <p>You are required to do the following before login:</p>
     <ul><li>Change your password,</li>
        <li>Change your PIN, and</li>
        <li>Setup your security questions and answers.</li>
</ul>
<p>These changes will take few minutes to complete. We hope you will have a great online banking experience with JMMB Moneyline.<br/><br></p></div>';


$locale["changePasswordnPinCompleteMessage"]='<div id="changePasswordnPinCompleteMessage" class="complete-process-tick external">
                <h2  class="header bottom" langid="">Setup Process Complete</h2>
                <p>You have successfully complete the required setup process.<br/>
                    <ul>
                        <li>Your password has successfully changed, and</li>
                        <li>Your PIN has successfully changed.</li>
                     </ul>

                    <br></p>

            </div>';
$locale["changePasswordnSQCompleteMessage"]='<div id="changePasswordnSQCompleteMessage" class="complete-process-tick external">
                <h2  class="header bottom" langid="">Setup Process Complete</h2>
                <p>You have successfully completed your required setup process.<br/>
                    <ul>
                        <li>Your password has successfully changed, and</li>
                        <li>Your security questions has successfully setup.</li>
                     </ul>

                    <br></p>

            </div>';
$locale["changePINnSQCompleteMessage"]='<div id="changePINnSQCompleteMessage" class="complete-process-tick external">
                <h2  class="header bottom" langid="">Setup Process Complete</h2>
                <p>You have successfully completed your required setup process.<br/>
                    <ul>
                        <li>Your PIN has successfully changed, and</li>
                        <li>Your security questions has successfully setup.</li>
                     </ul>

                    <br></p>

            </div>';
$locale["changePasswordPinnSQCompleteMessage"]='<div  id="changePasswordPinnSQCompleteMessage" class="complete-process-tick external">
                <h2  class="header bottom" langid="">Setup Process Complete</h2>
                <p>You have successfully completed your required up process.<br/>
                    <ul>
                        <li>Your password has successfully changed,</li>
                        <li>Your PIN has successfully changed, and</li>
                        <li>Your security questions has successfully setup.</li>
                     </ul>

                    <br></p>

            </div>';

?>