<?php

// include common errors
include_once COMMON_PATH.'locale/'.$lang.'/errors.php';

// Errors and Exceptions
$locale['ERR010'] = 'Invalid Username Or Password.<br/>You have %s attempt(s) left.';
$locale['ERR011'] = 'Account is locked';
$locale['ERR012'] = 'Account is inactive';
$locale['ERR013'] = 'Invalid Corporate ID, Username Or Password.';

$locale['ERR020'] = 'Failed to update password!';
$locale['ERR021'] = 'Invalid session';
$locale['ERR022'] = 'Could not find user record';
$locale['ERR023'] = 'Old password specified is invalid';
$locale['ERR024'] = 'Password does not meet the minimum requirements.' .
                    '<br/>The password should meet the following:<br/>' .
                    '<ul><li>Be at least eight (8) characters in length</li>'.
                    '<li>Should not have been used in the last 5 password changes on your account</li>'.
                    '<li>Must contain any three of the following<ul>' .
                    '<li>At least one lower case character (a-z)</li>'.
                    '<li>At least one upper case character (A-Z)</li>'.
                    '<li>At least one numeric character (0-9)</li>'.
                    '<li>At least one special character</li>'.
                    '</ul></li>'.
                    '</ul>';
$locale['ERR025'] = 'Password has recently been used';
$locale['ERR026'] = 'Email address is invalid';
$locale['ERR027'] = 'Email address is already in use';

$locale['ERR030'] = 'Unable to create user record!';
$locale['ERR031'] = 'User already exists';

$locale['ERR040'] = 'Unable to create session entry.';
$locale['ERR050'] = 'Failed to validate Single Sign On session!';
$locale['ERR051'] = 'Record has been updated by another user!';

$locale['ERR060'] = 'Incorrect number of responses have been supplied';
$locale['ERR061'] = 'Responses do not correspond to expected answers';
$locale['ERR062'] = 'Same question cannot be used multiple times';

$locale['ERR404'] = 'Resource not found';

$locale['ERR@P02'] = 'Pension Member number is required when user is given access to pension query';

$locale['SYSERR'] = 'The system had encounter an error while processing your request. Please contact the <a href="mailto:webmaster@jmmb.com" title="Contact Admin">Administrator</a>.';

$locale['E-ACCESSDENIED'] = 'You are not authorized to view this page';

?>