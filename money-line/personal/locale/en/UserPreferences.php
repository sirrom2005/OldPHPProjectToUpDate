<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$locale["invalid.policy.type"] = "You do not have the right privileges to change to that transaction policy type. However, you can select custom policy type to customize the transaction policy levels.";
//
$locale["lock.user.preference"] = "Lock/Unlock User preference option";
$locale["lock.tooltip"]         = 'Lock/Unlock Item';
//Transaction Policy Description

$locale['transaction.policy.description.custom.title']         = 'Custom';
$locale['transaction.policy.description.custom']         = 'Use this screen to customize your transaction policy options.';
$locale['transaction.policy.description.basic.title']         = 'Basic';
$locale['transaction.policy.description.basic']         = 'Disable security verification when updating records and preferences. Allow user to dynamically create payees without verification.';
$locale['transaction.policy.description.moderate.title']         = 'Moderate';
$locale['transaction.policy.description.moderate']         = 'Enable security verification when adding/updating wire transfer payees and user preferences. Allow user to create payees.';
$locale['transaction.policy.description.high.title']         = 'High';
$locale['transaction.policy.description.high']         = 'Managed payee white-list. White-list payees can only be modified via customer care. Policy level can only be upgraded by user or change via customer care.';
$locale['transaction.policy.description.internal.transfer.title']         = 'Internal Transfer';
$locale['transaction.policy.description.internal.transfer']         = 'Only internal transfers to manage white-list payees are allowed. White-list payees can only be modified via JMMB customer care. Policy level can only be upgraded by user or changed via customer care.';
$locale['transaction.policy.description.no.transaction.title']         = 'No transaction';
$locale['transaction.policy.description.no.transaction']         = 'Disable all transactions. Policy level can only be changed via JMMB customer care.';


// Slider labels
$locale['transaction.policy.slider.label.custom']                           = 'Customize';
$locale['transaction.policy.description.slider.label.basic']         = 'Basic';
$locale['transaction.policy.description.slider.label.moderate']         = 'Moderate';
$locale['transaction.policy.description.slider.label.high']         = 'High';
$locale['transaction.policy.description.slider.label.internal.transfer']         = 'Internal Transfer';
$locale['transaction.policy.description.slider.label.no.transaction']         = 'No Transaction';

// Customized Transaction Policy Level
$locale['transaction.policy.allow.cheque.encashment']         = 'Allow Cheque Encashment';
$locale['transaction.policy.allow.internal.transfer']         = 'Allow Internal Transfer';
$locale['transaction.policy.allow.local.wires']         = 'Allow Local Wires';
$locale['transaction.policy.allow.international.wires']         = 'Allow International Wires';
$locale['transaction.policy.allow.cambio.transactions']         = 'Alllow Cambio Transations';
$locale['transaction.policy.allow.standing.orders']         = 'Allow Standing Orders';
$locale['transaction.policy.allow.equity.trades']         = 'Allow Equity Trades';

// Transaction Policy Section Titles
$locale['transaction.policy.section.title.transactions']         = 'Transactions';
$locale['transaction.policy.section.title.user.managed.payees']         = 'User Managed Payees';
$locale['transaction.policy.section.title.security.verification']         = 'Security Verification';
$locale['transaction.policy.section.title.other']         = 'Other';


// Transaction policy Security Verification Section

$locale['transaction.policy.verify.user.preference.modifications']         = 'User Preference Modifications';
$locale['transaction.policy.verify.payee.for.wire.transfer']         = 'Verify payee for Wire Transfer';
$locale['transaction.policy.verify.payee.for.cheque.encashment']         = 'Verify payee for Cheque Encashment';
$locale['transaction.policy.verify.payee.for.internal.transfers']         = 'Verify payee for Internal Transfers';

// Transaction policy Other Section

$locale['transaction.policy.allow.daily.limit.change']         = 'Allow Daily Limit Change';

// Transaction policy User Managed Payee Section

$locale['transaction.policy.user.managed.payees.wire.transfer']         = 'Wire Transfer';
$locale['transaction.policy.user.managed.payees.cheque.encashment']         = 'Cheque Encashment';
$locale['transaction.policy.user.managed.payees.internal.transfer']         = 'Internal Transfer';

$locale["transaction.policy.daily.transaction.limit"]               ="Daily Transaction Limit";
$locale["transaction.policy.email.transaction.receipts"]               ="Email Transaction Receipts";
$locale["transaction.policy.current.usage"]                         ="Current Usage:";


// Section Heading
$locale["section.heading.transaction.policy"]               ="Transaction Policy";
$locale["section.heading.home.page.setup"]                  ="Home Page Setup";
$locale["section.heading.account.setup"]                  ="Account Setup";
$locale["section.heading.user.profile"]                     ="User Profile";


// Home Page Setup
$locale["home.page.setup.show.account.summary"]                     ="Show Account Summary";
$locale["home.page.setup.show.messages"]                            ="Show Messages";
$locale["home.page.setup.show.print.statements"]                    ="Show Print Statements";
$locale["home.page.setup.show.express.requests"]                    ="Show Express Requests";
$locale["home.page.setup.account.summary.details"]                  ="Account Summary Details:";
$locale["home.page.setup.account.summary.details.hide"]             ="Hide";
$locale["home.page.setup.account.summary.details.show"]             ="Show";
$locale["home.page.setup.account.summary.view"]                     ="Account Summary View:";
$locale["home.page.setup.account.summary.view.grid"]                ="Grid";
$locale["home.page.setup.account.summary.view.chart"]               ="Chart";
$locale["home.page.setup.default.no.transactions"]                  ="Default No. Transactions:";
$locale["home.page.setup.display.current.totals"]                   ="Display current for totals:";


//Account Setup
$locale["account.setup.use.transaction.wizard"]                     ="Use Transaction Wizard";
$locale["account.setup.enable.browse.registration"]                 ="Enable Browse Registration";
$locale["account.setup.default.branch"]                 ="Default Branch";
$locale["account.setup.default.account.type"]                 ="Default Account Type";
$locale["account.setup.cell.phone.no"]                 ="Cell Phone #";
$locale["account.setup.pension.view"]                 ="Pension View:";
$locale["account.setup.pension.view.details"]                 ="Details";
$locale["account.setup.pension.view.summary"]                 ="Summary";
$locale["account.setup.mask.account.number"]                 ="Mask Account Number";
$locale["account.setup.default.trade.terms"]                 ="Default Trade Terms";
$locale["account.setup.default.account"]                 ="Default Account";
$locale["account.setup.cell.phone.provider"]                 ="Cell Phone Provider";


$locale["user.profile.button.reset"]                    ="&nbsp;&nbsp;Reset&nbsp;&nbsp;";
$locale["user.profile.button.save"]                    ="&nbsp;&nbsp;Save&nbsp;&nbsp;";
$locale["user.profile.button.continue"]                    ="&nbsp;&nbsp;Continue&nbsp;&nbsp;";
// User Profile
$locale["user.profile.user.name"]     ="Client Name: ";
$locale["user.profile.last.login"]      ="Last Login IP Address: ";
$locale["user.profile.view.history"]    ="View History";
$locale["user.profile.view.history.date"] = " Date ";
$locale["user.profile.view.history.ip.address"] ="IP Address";
$locale["user.profile.view.history.msg"]="Last Successful login(s)";
$locale["user.profile.change.name"]     ="Change User Name";
$locale["user.profile.change.password"] ="Change Password";
$locale["user.profile.change.pin"]      ="Change PIN";
$locale["user.profile.change.questions"]="Change Security Questions";

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
                <p class="left" style="text-align:left;" langid="">Your user preferences have successfully saved.<br/><br><br>Click continue to proceed.</p>

            </div>';

$locale['EMAILSECUIRTYKEY']= '<div id="UPSavedMessage" class=" clear">
                <h3>User Profile</h3>
                <p class="left" style="text-align:left;" langid="">An email verification code has been sent to your email.<br/><br><br>Click continue to proceed.</p>

            </div>';
?>