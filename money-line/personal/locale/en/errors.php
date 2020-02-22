<?php
/**
 * Error Locale
 */

$email = Raxan::config('site.email');

$locale['back-to-home'] = 'Back to Home';
$locale['signin'] = 'Sign In';

$locale['error-while-saving'] = 'Error while saving record. Please contact the System Administrator';
$locale['error-while-deleting'] = 'Error while deleting record. Please contact the System Administrator';

// nossl
$locale['NOSSL'] = '<h4>We are sorry, but a Secured SSL connection was not detected.</h4>
In order to use Moneyline your browser must support SSL v2.0/3.0 or higher.
If you feel none of the above reasons are justified please contact our Moneyline Administrator at <a href="mailto:'.$email.'">'.$email.'</a> explaining the problem.
';

// locked
$locale['LOCKED']='<h4>The Moneyline Security Administrator has locked your Client Number and your PIN.</h4>
This occurred because of repeated unsuccessful attempts to login.
Please contact to our Moneyline Security Administrator at <a href="mailto:'.$email.'">'.$email.'</a> to reactivate your account access.';

// wrong password, pin or  invalid login
$locale['WRONGPASSWORD']= $locale['WRONGPIN']= $locale['INVALIDLOGIN']= '<h3>Invalid Login.</h3>
If the problem persists please contact our Moneyline Administrator at <a href="mailto:'.$email.'">'.$email.'</a>
';


//Invalid security verification code

$locale['INVALIDSECURITYCODE']= '<h3>Invalid Security Code.</h3>
If the problem persists please contact our Moneyline Administrator at <a href="mailto:'.$email.'">'.$email.'</a>
';

//Email Security key not sent

$locale['EMAILSECUIRTYKEY']= '<h3>Email Verification is not sent to your email.</h3>
If the problem persists please contact our Moneyline Administrator at <a href="mailto:'.$email.'">'.$email.'</a>
';

$locale['EMAILSECUIRTYKEYUP']= '<h3>Email Verification is not sent to your email.</h3>
You can not save your user preferences.<br>If the problem persists please contact our Moneyline Administrator at <a href="mailto:'.$email.'">'.$email.'</a>
';

// Password not changed

$locale['PASSWORDNOTCHANGED']= '<h3>Password Not Changed.</h3>
If the problem persists please contact our Moneyline Administrator at <a href="mailto:'.$email.'">'.$email.'</a>
';

// PIN not changed

$locale['PINNOTCHANGED']= '<h3>PIN Not Changed.</h3>
If the problem persists please contact our Moneyline Administrator at <a href="mailto:'.$email.'">'.$email.'</a>
';


// Security questions not changed

$locale['SQNOTCHANGED']= '<h3>Security Questions Not Changed.</h3>
If the problem persists please contact our Moneyline Administrator at <a href="mailto:'.$email.'">'.$email.'</a>
';


// User Name not changed

$locale['UNNOTCHANGED']= '<h3>User Name Not Changed.</h3>
If the problem persists please contact our Moneyline Administrator at <a href="mailto:'.$email.'">'.$email.'</a>
';

// duplicate login
$locale['DUPLOGON']='<h4>We are sorry, but our system indicates that you are already logged on.</h4>
Please logout of your previous Moneyline session before attempting to logon again.
If you were not currently logged in please send a message immediately to our Moneyline Security Administrator at <a href="mailto:'.$email.'">'.$email.'</a> explaining the problem.
';

// db error
$locale['DBERROR']='<h3>Database Exception Error</h3>
The Moneyline system has encountered an error in processing your request. A report has been sent to the Moneyline Administrator. You may retry your request in 60 seconds. 
If the problem persists, please contact our Moneyline Administrator at <a href="mailto:'.$email.'">'.$email.'</a> explaining where you encountered this error.
';

// no authentication
$locale['NOAUTHENTICATION']='<h4>You are not authorized to view this web page.</h4>';

// network down
$locale['NETWORKDOWN']='<h4>The server is unavailable or busy at this time.</h4>
Please try to conduct your transaction again. If this problem persists please contact the Moneyline Administrator at <a href="mailto:moneyline@jmmb.com">moneyline@jmmb.com</a> or contact or Client Care Center. We apologise for any inconvenience that you may experience. <br /><br />
<strong>Call us toll free at: 1-888-937-5662 (Local) | 1-877-533-5662 (North America & Canada) | 0-800-917-6040 (England).</strong>
';

// too many days
$locale['TOOMANYDAYS']='
<h4>The Moneyline Security Administrator has locked your Client Number and your PIN.</h4>
This occurred because of logging on <strong>after too many days</strong>. 
Please contact to our Moneyline Security Administrator at <a href="mailto:'.$email.'">'.$email.'</a> to reactivate your account access.
';

// system error and no access
$locale['SYSERR']= $locale['NOACCESS'] = '
<div><h4>We are sorry, but your Moneyline Session has been terminated for one of the following reasons: </h4>
<ul>
    <li>You have been idle in JMMB Moneyline for an extended period of time.</li>
    <li>You have attempted to access Moneyline without logging in.</li>
    <li>You have attempted to perform a function for which you are not authorized.</li>
</ul>
If you feel none of the above descriptions apply to you please contact our Moneyline Administrator at <a href="mailto:'.$email.'">'.$email.'</a> explaining the problem.
</div>';


// no security questions exist NOSECURITYQUESTIONS
$locale['NOSECURITYQUESTIONS']=  '<h3>No Security Questions Setup</h3>
<p>You are unable to login. You have not setup your security questions and answers.</p>
Please contact our Moneyline Administrator at <a href="mailto:'.$email.'">'.$email.'</a> to assist you in setting up your security questions and answers.
';

$locale['INCORRECTSECURITYANSWERS']=  '<h3>Security Questions</h3>
<p>You are unable to login. Your answer(s) to the security questions are incorrect.</p>
Please contact our Moneyline Administrator at <a href="mailto:'.$email.'">'.$email.'</a> to assist you in setting up your security questions and answers.
';


$locale['USERPREFERENCESNOTSAVED']=  '<h3>User Profile - Not Saved</h3>
<p>Your user preferences are not saved. You can try again.</p>
If the problem persists, please contact our Moneyline Administrator at <a href="mailto:'.$email.'">'.$email.'</a> to assist you.
';

$locale['USERPREFERENCESVFAILED'] = '<h3>Security Verification Failed</h3>'.
                    '<p>Your user preferences are not saved. <br/>'.
                    'You have to correctly answer all of following security verifications:' .
                    '<ul><li>Security PIN,</li>'.
                    '<li>Email verification code, and</li>'.
                    '<li>Two security questions.</li>'.
                    '</ul></p>';

$locale["INVALIDPIN"] = '<h3>PIN INVALID</h3><p>You PIN number is incorrect!</p>Please contact our Moneyline Administrator at <a href="mailto:'.$email.'">'.$email.'</a> to assist you.';

$locale['WSAUTHERR'] = $locale['SYSERR']; //security token invaild
$locale["VALERR"]    = "Validation Error";
$locale['REMEMBERPC']= "<h4>Warning!</h4>
    It appears that your Network or Web Browser configuration has been changed since you've last logged in to this PC. You will be required to enter Two(2) security questions before you can continue.
";


$locale['ERR010']="Incorrect number of responses has been supplied";
$locale['ERR011']="Responses do not correspond to expected answers";
$locale['ERR012'] = 'Incorrect password. ';
$locale['ERR013'] = 'Incorrect PIN. ';
$locale['ERR014'] = 'Invalid # of security questions sent';
$locale['ERR015'] = 'Same question cannot be used multiple times.';
$locale['ERR016'] = 'Current password and New password are same.';
$locale['ERR017'] = '<h2  class="header bottom" langid="">Password Not Changed</h2>'.
                    '<p>New Password does not meet the minimum requirements.<br/>'.
                    'The password should meet the following:' .
                    '<ul><li>Be at least eight (8) characters in length</li>'.
                    '<li>Should not have been used in the last 5 password changes on your account</li>'.
                    '<li>Must contain any three of the following:' .
                    '<ul><li>At least one lower case character (a-z)</li>'.
                    '<li>At least one upper case character (A-Z)</li>'.
                    '<li>At least one numeric character (0-9)</li>'.
                    '<li>At least one special character</li>'.
                    '</ul></li>'.
                    '</ul></p>';
$locale['ERR018'] = 'Current PIN and New PIN are same.';
$locale['ERR019'] = 'Password recently used';
$locale['ERR020'] = 'No email recipients found for user';
$locale['ERR021'] = 'Email template not found';
$locale["ERR022"] = "Username already exists";
$locale["ERR023"] = "Username contains invalid character";

$locale["ERR030"] = "Transaction would result in daily limit being exceeded.";
$locale["ERR031"] = "Payment method for wire could not be determined.";
$locale["ERR032"] = "Invalid Transaction Type";
$locale["ERR033"] = "Invalid routing information for wire";
$locale["ERR034"] = "Insufficient funds";
$locale["ERR035"] = "Beneficiary Account or ID number contains an invalid character";
$locale["ERR036"] = "Beneficiary Bank account or ID number contains an invalid character";
$locale["ERR037"] = "Beneficiary Bank routing number contains an invalid character";
$locale["ERR038"] = "Beneficiary Bank name contains an invalid character";
$locale["ERR039"] = "Intermediary bank routing number contains an invalid character";
$locale["ERR040"] = "First line of payment details contains an invalid character";
$locale["ERR041"] = "Second line of payment details contains an invalid character";
$locale["ERR042"] = "Third line of payment details contains an invalid character";
$locale["ERR043"] = "Fourth line of payment details contains an invalid character";
$locale["ERR044"] = "Beneficiary name contains an invalid character";
$locale["ERR045"] = "First line of beneficiary address contains an invalid character";
$locale["ERR046"] = "Second line of beneficiary address contains an invalid character";
$locale["ERR047"] = "Third line of beneficiary address contains an invalid character";
$locale["ERR048"] = "First line of beneficiary bank address contains an invalid character";
$locale["ERR049"] = "Second line of beneficiary bank address contains an invalid character";
$locale["ERR050"] = "Third line of beneficiary bank address contains an invalid character";
$locale["ERR051"] = "Intermediary bank name contains an invalid character";
$locale["ERR052"] = "First line of intermediary bank address contains an invalid character";
$locale["ERR053"] = "Second line of intermediary bank address contains an invalid character";
$locale["ERR054"] = "Third line of intermediary bank address contains an invalid character";
$locale["ERR055"] = "Beneficiary Account or ID number is required";
$locale["ERR056"] = "Beneficiary ID number cannot exceed 29 characters";
$locale["ERR057"] = "Beneficiary bank routing information is required";
$locale["ERR058"] = "Beneficiary bank ID type is required";
$locale["ERR059"] = "Beneficiary bank name is required";
$locale["ERR060"] = "First Intermediary bank routing information is required";
$locale["ERR061"] = "Beneficiary bank routing information should not be specified";
$locale["ERR062"] = "Beneficiary ID type is not valid for bank";
$locale["ERR063"] = "SWIFT code for Beneficiary Bank Routing must be either 8 or 11 characters";
$locale["ERR064"] = "SWIFT code for Intermediary Bank Routing must be either 8 or 11 characters";
$locale["ERR065"] = "ABA number used for Beneficiary Bank Routing is not valid";
$locale["ERR066"] = "ABA number used for Intermediary Bank Routing is not valid";
$locale["ERR067"] = "CHIPS ID used for Beneficiary Bank Routing should consist of exactly four digits";
$locale["ERR068"] = "CHIPS ID used for Intermediary Bank Routing should consist of exactly four digits";
$locale["ERR069"] = "CHIPS UID used for Beneficiary Bank ID should consist of exactly six digits";
$locale["ERR070"] = "Only account numbers can be used in transfers to NCB";
$locale["ERR071"] = "NCB Account number must be normal nine digits or 16 digit credit card number";
$locale["ERR072"] = "Beneficiary account number must be numeric";
$locale["ERR073"] = "Transfer of foreign currency to NCB credit cards are not allowed ";
$locale["ERR074"] = "Routing method must be a Financial Institution ID";
$locale["ERR075"] = "The Financial Institution ID should be numeric";
$locale["ERR076"] = "The Financial Institution ID is expected to have eight digits";
$locale["ERR077"] = "Beneficiary Account ID is expected to be numeric";
$locale["ERR078"] = "Credit card payments are not allowed for the selected Financial Institution";
$locale["ERR079"] = "Please limit payment details to 50 characters";
$locale["ERR080"] = "Payment details should contain only alphabetic, numeric or space characters";


?>