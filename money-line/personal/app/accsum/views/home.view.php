<?php defined('RAXANPDI')||die(); ?>

<style type="text/css">
    table {
        margin:0;
        padding:0;
    }

    #totalUncleared, #totalLiens { color:red; }
    #totalCurrentBalance, #totalUncleared, #totalLiens, #totalAvailableBalance, #accountBalance {
        text-align: right
    }

    #reminders .delete {
        z-index:1000;
    }

    #reminders .High {
        color: #cc0000;
        font-weight: bold;
    }

    #reminders .Medium {
        color: #000048;
        font-weight: bold;
    }

    #reminders .Low {
        color: #004000;
        font-weight: bold;
    }

    #reminders .reminderDetails label {
        display:block;
    }

    /* Express Encashment */
    #fmrExpressEncash .ctrl {
        height: 25px;
    }
    #fmrExpressEncash label {
        float: left;
        display: block;
        width: 120px;
    }
    #fmrExpressEncash select {
        width:153px;
        margin-bottom:5px;
    }
    #fmrExpressEncash input {
        width:145px;
        margin-bottom:5px;
    }
    #sidepanel {
        margin-top:5px;
    }

</style>
<script type="text/javascript">

    Raxan.ready(function(){

        // setup reminder textbox limits
        limitTextbox('#summary',150);
        limitTextbox('#details',500);

        // automatically format textbox numbers
        //autoFormat('#expAccAmount',2);

        // validate express encashment amount
        $('#expAccAmount').change(function() {
            var ctrl = $(this);
            if (!validateAmount(ctrl.val())) {
                ctrl.focus();
            }
        })


        // setup reminder datepicker
        $('#actiondate').datepicker({
            dateFormat:'yy-mm-dd',
            changeMonth: true,
            changeYear: true
        });
        $('.datepicker-image').click(function(){
            $('#actiondate').datepicker('show');
        })
        // show/hide reminder
        $('#newReminderBtn').click(function(e){
            $('.new-reminder').slideDown('fast',function(){
                $(window).scrollTo('.new-reminder',{
                    duration:400,
                    margin:true,
                    offset:{top:-50},
                    onAfter: function(){
                        $('.new-reminder')[0].focus();
                    }
                });
            });
            $('#frmReminder')[0].reset();
            $('.buttonbar').hide();
            e.preventDefault();
            return false;
        })
        $('#cancelReminderBtn').click(function(e){
            $('.new-reminder').slideUp('fast',function(){
                var nbtn = $('#newReminderBtn'); // scroll new reminder button into view
                if(nbtn.offset().top < $(window).scrollTop()) {
                    $(window).scrollTo('#newReminderBtn',{
                        duration:400,
                        margin:true,
                        offset:{top:-20}
                    });
                }
            });
            $('.new-reminder form')[0].reset();
            $('.buttonbar').show();
            e.preventDefault();
            return false;
        })

        // show/hide reminder details
        $('#reminders .reminderDetails .close').live('click',function(e){
            $(this).parents('.reminderDetails').slideUp('fast');
            e.preventDefault();
            return;
        });

        // express functions / validation
        $('#expAccount').change(function(){
            var opt = $(this);
            var bal = opt.find('option[value="'+opt.val()+'"]').attr('title');
            var values = bal.split(/ /);
            $('#expAccBalance').text(bal);

            $('#expAccCurrency').text(values[0]); // set currency value

        });

        $('#expAccAmt').change(function(){
            var val = $(this).val();
            if (!IsNumeric(val)) {
                alert(Raxan.getVar('amount-missing'));
            }
        });

        // validate express form before sending to server
        $('#expEncashBtn').bind('togglecontent', function(e, mode) {

            if (mode=='off') {
                $('#expEncashBtn img').hide();
                return;
            }
            else {
               var msg, form = document.forms['fmrExpressEncash'];
               var amount = val(form.expAccAmt.value.split(',').join(''));
               var currency,balance = $(form.expAccount).find('option[value="'+form.expAccount.value+'"]').attr('title');
               balance = balance.split(/ /);
               currency = balance[0];
               balance = balance[1];

               if (form.expAccount.options.length==0) {
                   showMessage(Raxan.getVar('no-encash-rights'));
                   form.expAccount.focus();
                   return false;
               }

               if (form.expBranch.value=='') {
                   showMessage(Raxan.getVar('branch-missing'));
                   form.expBranch.focus();
                   return false;
               }

               if (form.expAccName.value=='') {
                   showMessage(Raxan.getVar('payee-missing'));
                   form.expAccName.focus();
                   return false;
               }

               if ((amount > balance) || (amount <= 0) || isNaN(form.expAccAmt.value)){
                   showMessage(Raxan.getVar('amount-missing'));
                   form.expAccAmt.focus();
                   return false; 
               }

               if (form.expPin.value == '') {
                    showMessage(Raxan.getVar('pin-missing'));
                    form.expPin.focus();
                    return false;
               }
               else
                if (IsNumeric(form.expPin.value) == false) {
                    showMessage(Raxan.getVar('invalid-pin'));
                    form.expPin.value = '';
                    form.expPin.focus();
                    return false;
                }


               if (form.holiday.value == 1){
                   msg = Raxan.getVar('not-business-day');
                   msg = msg.replace(/\.date\./,Raxan.getVar('_nextBusinessDay'));
                   showMessage(msg);
                   //return false;
               }
               else if (form.cutofftime.value == 1){
                   msg = Raxan.getVar('cut-off-time-pass');
                   msg = msg.replace(/\.time\./,Raxan.getVar('_cutOffTimeDesc'));
                   showMessage(msg);
                   //form.expAccount.focus();
                   //return false;
               }
               
               _branch = form.expBranch;
               _branchName = trim(_branch.options[_branch.options.selectedIndex].text);

               msg = Raxan.getVar('encash-message');
               msg = msg.replace(/\.date\./,Raxan.getVar('_nextBusinessDay'));
               msg = msg.replace(/\.currency\./,currency);
               msg = msg.replace(/\.amount\./,form.expAccAmt.value);
               msg = msg.replace(/\.account\./,form.expAccount.value);
               msg = msg.replace(/\.payee\./,form.expAccName.value);
               msg = msg.replace(/\.branch\./,_branchName);

               cmdBtn = confirm(msg);

               if (cmdBtn == true) {
                    $('#expEncashBtn').blur();
                    $('#expEncashBtn img').show();
               }
               return cmdBtn;
            }
        });

        // display preloader for "view all reminders"
        $('#viewAllReminders').bind('togglecontent',function(event,mode){
            var icon = $(event.currentTarget).find('img');
            if (mode=='on') icon.show();
            else {
                icon.hide();
                var box = $('#reminders'); // scroll "new reminder" button into view
                if(box.offset().top < $(window).scrollTop()) {
                    $(window).scrollTo('#reminders',{
                        duration:400,
                        margin:true,
                        offset:{top:-20}
                    });
                }
            }
        });

        // display "busy preloader" for reminder items
        $('#remindercontent').delegate('.view, .delete','togglecontent',function(event,mode){
            var icon, elm = event.currentTarget;
            icon = $(elm).parents('.reminder-row').find('.reminder-icon');
            if (mode=='on') {
                elm = $(elm);
                if (!elm.hasClass('delete')) {
                    elm = elm.parents('.reminder-row').find('.reminderDetails');
                    if (elm.css('display')=='block') {  // hide content
                        elm.slideUp('fast');
                        return false;
                    }
                }
                else {
                    // confirm delete operation
                    if (!confirm(Raxan.getVar('confirm-delete'))) {
                        event.preventDefault();
                        return false;
                    }
                }
                // show busy icon
                icon.attr('src','views/images/loader.gif');
            }
            else {
                elm = $(elm)
                icon.attr('src','views/images/bell.png'); // remove busy icon
                if (elm.hasClass('delete')) // remove row
                    elm.parents('.reminder-row').slideUp('fast',function(){
                        $(this).remove();
                    });
            }
        })

        // register reminder form validation / auto-toggle
        $('#savereminderbtn').bind('togglecontent', function(event, mode){
            var dt, msg, now;

            if (mode=='on') {
                // validate form
                now = new Date();
                now = now.getFullYear() + '/'+ (now.getMonth() + 1) + '/' + now.getDate();
                now = new Date(now); // remove time
                dt = new Date($('#actiondate').val());
                if (dt <= now) {
                    $('#actiondate').focus();
                    msg = Raxan.getVar('actiondate-incorrect');
                }
                else if ($('#summary').val()=='') {
                    $('#summary').focus();
                    msg = Raxan.getVar('summary-missing');
                }
                else if ($('#details').val()=='') {
                    $('#details').focus();
                    msg = Raxan.getVar('details-missing');
                }

                if (msg) {
                    alert(msg);
                    event.preventDefault();
                    return false;
                }
                else {
                    $('#savereminderbtn img').show();
                    $('#savereminderbtn').blur();
                }
            }
            else {
                $('#savereminderbtn img').hide();
            }

        })

        // disable "new reminder form" before updating server
        $('#savereminderbtn').bind('disablecontent', function(event, mode){
            var sel = '#frmReminder input, #frmReminder textarea,' +
                      '#frmReminder select, #frmReminder button';
             $(sel).attr('disabled',(mode=='on' ? 'disabled' : ''));
             $('#frmReminder .datepicker-image')
                .css('visibility',(mode=='on' ? 'hidden' : 'visible'));
        })


    })


    // show/hide account details
    function showHideDetail(i) {
        var on = 'views/images/plus.gif';
        var off = 'views/images/minus.gif';
        var img, d = $('#detail_'+i);
        d.toggle();
        img = (d.css('display')=='none') ?  on : off;
        $('#show_hide_'+i).attr('src',img);
    }

    function toggleTotals() {
        var cur = $('#selCurrency').val();
        var total = Raxan.getVar('currencyTotals')[cur];
        $('#totalCurrentBalance').text(total['currentBalance']);
        $('#totalLiens').text(total['liens']);
        $('#totalUncleared').text(total['uncleared']);
        $('#totalAvailableBalance').html(total['availableBalance']);
    }
    
</script>

<div class="container e100 last">

    <!-- side panel -->
    <div id="sidepanel" class="c15 right">
        <div class="round">
            <div id="welcomemsg" class="border pad bmm round"></div>

            <!--div xt-ui="MoneylineAdNote" class="bmm"></div-->

            <div id="notices" class="rax-box notice bmm clear">
                <span class="box-title" langid="notices">Notices</span>
                <div class="content">
                    <div class="hlf-pad bmb">
                        <img src="views/images/yellow_bullet.gif" alt="." />
                        {notice}
                    </div>
                </div>
            </div>

            <div id="reminders" class="rax-box alert bmm clear round">
                <span class="box-title">
                    <img id="reminderBusy" class="hide" src="views/images/loader.gif" alt="." align="right" />
                    <span id="reminderTitle" langid="upcoming-reminders">Upcoming Reminders (Top 5)</span>
                </span>
                <div id="remindercontent" class="content bmm" xt-delegate=".view #click,viewReminderDetails,true,true; .delete #click,deleteReminder,true,true;">
                    <div class="clear reminder-row">
                        <div class="right">
                            <a href="#{ReminderId}" class="delete" langid="delete">Delete</a>
                        </div>
                        <img class="reminder-icon" src="views/images/bell.png" alt="." align="left" />&nbsp;
                        <span><a href="#{ReminderId}" class="view">{Summary}</a></span>
                        <div id="reminderDetails{ReminderId}" class="reminderDetails hide"></div>
                    </div>
                </div>
                <div class="new-reminder lightgray hide tpb bmb hlf-pad">
                    <form id="frmReminder" name="frmReminder" action="" method="post">
                        <div class="bold clear bmm" langid="new-reminder">New Reminder</div>
                        <div class="left">
                            <label class="bold" langid="action-date">Action Date:</label><br />
                            <input type="text" name="actiondate" id="actiondate" class="textbox click-cursor" readonly="readonly" style="width:150px" />
                            <img class="datepicker-image click-cursor" src="views/images/calendar_month.png" alt="."  />
                        </div>

                        <div class="left c4 ltm bmm">
                            <label class="bold" langid="priority">Priority:</label><br />
                            <select name="priority">
                                <option value="H" langid="high">High</option>
                                <option value="M" langid="medium">Medium</option>
                                <option value="L" langid="low">Low</option>
                            </select>
                        </div>

                        <br class="clear"/>

                        <label class="bold" langid="summary">Summary:</label><br />
                        <textarea id="summary" name="summary" cols="40" rows="3" class="textbox" style="width:260px;height:50px"></textarea><br />

                        <label class="bold" langid="details">Details:</label><br />
                        <textarea id="details" name="details" cols="40" rows="3" class="textbox" style="width:260px;height:80px"></textarea><br />

                        <div class="container hlf-pad">
                            <button id="cancelReminderBtn" class="right button" type="button">Cancel</button>
                            <button id="savereminderbtn" class="button right ok rtm" type="submit" name="savereminderbtn" xt-bind="#click,addReminder,#frmReminder">
                                <img class="hide" src="views/images/loader.gif" alt="." />
                                <span langid="save">Save</span>
                            </button>
                        </div>
                    </form>



                </div>
                <div class="buttonbar hlf-pad tpb">
                    <div class="right">
                        <img src="views/images/add.png" alt="." style="vertical-align: middle" />
                        <a id="newReminderBtn" href="#" langid="new-reminder">New Reminder</a>
                    </div>
                    <div>
                        <a href="#" id="viewAllReminders" langid="view-all-reminder" xt-bind="#click,viewAllReminders,true,true">
                            <img src="views/images/loader.gif" alt="." class="hide" style="vertical-align: middle" />
                            View All Reminders
                        </a>
                    </div>
                </div>
            </div>

            <div class="rax-box success bmm round">
                <span class="box-title" langid="express-checkout">Express Checkout</span>
                <div class="content">
                    <form id="fmrExpressEncash" name="fmrExpressEncash" action="" method="post">
                        <input type="hidden" name="cutofftime" id="cutofftime" value="0" />
                        <input type="hidden" name="holiday" id="holiday" value="0" />
                        <div class="ctrl clear">
                            <label langid="account">Account:</label>
                            <select name="expAccount" id="expAccount">
                                <option value="{AccountNo}" title="{Currency} {AvailableBalance}">{AccountNo}</option>
                            </select>
                        </div>

                        <div class="ctrl clear">
                            <label langid="avail-balance">Available Balance:</label>
                            <span id="expAccBalance"></span>
                        </div>

                        <div class="ctrl clear">
                            <label langid="pickup-branch">Pickup Branch:</label>
                            <select name="expBranch" id="expBranch">
                                <option value="{branchCode}">{branchName}</option>
                            </select>
                        </div>

                        <div class="ctrl clear">
                            <label langid="payee">Payee:</label>
                            <input class="textbox" type="text" name="expAccName" id="expAccName" value="" />
                        </div>

                        <div class="ctrl clear">
                            <label><span langid="amount">Amount:</span>&nbsp;<span id="expAccCurrency"></span></label>
                            <input class="textbox" type="text" name="expAccAmt" id="expAccAmt" value="" />
                        </div>

                        <div class="ctrl clear">
                            <label langid="pin">PIN:</label>
                            <input class="textbox" type="password" name="expPin" id="expPin" value="" />
                        </div>

                        <div class="ctrl clear" align="right" style="margin-right:8px;">
                            <button class="button ok" type="button" name="expEncashBtn" id="expEncashBtn" xt-bind="click,expressEncashment,#fmrExpressEncash,true">
                                <img class="hide" src="views/images/loader.gif" alt="." style="margin-right:5px;"/>
                                <span langid="">Encash</span>
                            </button>
                        </div>&nbsp;&nbsp;
                    </form>
                </div>
            </div>

        </div>



    </div>

    <!-- account info -->
    <div class="elastic append1 scrollable">

        <!-- start navbar -->
        <div class="moneylinenavbar_bg container clip">
            <ul id="navbar" xt-ui="MoneylineNavbar">
                <li>
                    <div class="item r3 clip rtb">
                        <div class="shadow"></div>
                        <div class="c12">
                            <img class="column" src="views/images/mail_receive.png" alt="Inbox" />
                            <div class="left c9">
                                <h2 class="bottom" langid="inbox">Chat</h2>
                                <span>4 messages |</span>
                                <a href="#">New</a>
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="item r3 clip rtb">
                        <div class="shadow"></div>
                        <div class="c12">
                            <img class="column" src="views/images/dollar_currency_sign.png" alt="Money" />
                            <div class="left c9">
                                <h2 class="bottom">Transactions</h2>
                                <span><span id="requestPending">0</span> Pending | </span>
                                <a href="app/trans/trans.php">New</a>
                            </div>
                        </div>
                    </div>
                </li>                
                <li>
                    <div class="item r3 clip rtb">
                        <div class="shadow"></div>
                        <div class="c12">
                            <img class="column" src="views/images/attachment.png" alt="Money" />
                            <div class="left c9">
                            	
                                <h2 class="bottom">Statements</h2> 
                                <span>Print Statements | </span>
                                <a href="app/info/statement.php">New</a>
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="item r3 clip">
                        <div class="shadow"></div>
                        <div class="c12">
                            <img class="column" src="views/images/users.png" alt="Money" />
                            <div class="left c9">
                                <h2 class="bottom">Profile</h2> 
                                <span>Account Profile | </span>
                                <a href="#">View</a>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
        <!-- end navbar -->

        <hr class="space" />
        <h3 class="bmm">Account Summary</h3>
        <div id="accSum">
            <form id="frmAccounts" name="frmAccounts" action="" method="post">
                <a href="#" class="right" xt-bind="click,refreshAccountBalance,frmAccounts">Check for new Balances</a>
                <label class="c8">Select an account type:</label>
                <select name="accountTypes" id ="accountTypes" xt-bind="change,changeAccType">
                    <option value="{priorityCode}">{displayDescription} ({count})</option>
                </select>
                <hr />
                <a href="app/info/accountinfo.php" class="right">View Details for All Accounts</a>
                <hr class="clear space" />

                <div id="accSumTotal" class="container">
                    <table class="bmm" width="100%"  style="border:1px solid #71B6A3" cellpadding="0" cellspacing="0">
                        <tr bgcolor="#FCF6AE">
                            <td colspan="2">
                                <div class="bold left">Total</div>
                                <div align="right">Choose your display currency:
                                    <select id="selCurrency" name="selCurrency" onchange="toggleTotals()">
                                        <option value="{0}">{0} ({1}:1)</option>
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr bgcolor="#F0F6FA">
                            <td width="30%" height="20">&nbsp;Net Position:</td>
                            <td id="totalCurrentBalance"></td>
                        </tr>
                        <tr bgcolor="#FCF6AE">
                            <td width="30%" height="20">&nbsp;Uncleared Funds:</td>
                            <td id="totalUncleared"></td>
                        </tr>
                        <tr bgcolor="#F0F6FA">
                            <td width="30%" height="20">&nbsp;Liens on Accounts:</td>
                            <td id="totalLiens"></td>
                        </tr>
                        <tr bgcolor="#D8EBFA">
                            <td height="20" bgcolor="#FCF6AE">&nbsp;Available
                                Balance: </td>
                            <td bgcolor="#FCF6AE" id="totalAvailableBalance"></td>
                        </tr>
                    </table>
                </div>
            </form>

            <div id="accSumInfo" class="container">
            <div id="AccNo{AccNo}">
            	<table style="border:1px solid #71B6A3; width:100%" cellpadding="0" cellspacing="0">
					<tr bgcolor="#FCF6AE">
						<td style="width:65%">
							<div nowrap="nowrap">
								<img src="views/images/yellow_bullet.gif"> 
								Account No : <b><a href="app/info/accountdetails.php?AccNo={AccNo}&AccType={AccType}" title="Click here to view account details and transactions">{AccountNo}</a> - <span title="{AccountName}">{displayAccountName}</span></b>
							</div>
						</td>
						<td style="text-align:right; width: 30%;" colspan="2">
							<div nowrap="nowrap">
								<b><a href="app/info/investmentinfo.php?FundNo={FundNo}&AccountBalance={AccountBalance}&AccountNo={AccountNo}" title="Click here to view investment breakdown.">{AccountDescription}</a></b>
								&nbsp;<a href="javascript:;"><img src="views/images/plus.gif" style="display:{showList}" hspace="3" border="0" id="show_hide_{AccNo}" style="cursor:hand" onClick="showHideDetail({AccNo})"></a>
							</div>
						</td>
						<td style="text-align:right; width: 5%;">
							<img src="views/images/application_form_add.png" title="Transaction Wizard">&nbsp;
						</td>
						</tr>
						<tr bgcolor="#F0F6FA">
							<td style="text-align:left" width="30%" colspan="2">
							&nbsp;Current Balance:</td>
							<td colspan="2" id="accountBalance">
							{Currency} {CurrentBalance}</td>
						</tr>
						<tr bgcolor="#D8EBFA">
							<td style="text-align:left" width="30%" colspan="2">
							&nbsp;Available Balance:</td>
							<td colspan="2" id="accountBalance">
							{Currency} {AvailableBalance}</td>
						</tr>
						</table>
						<div class="container">
						<div id="detail_{AccNo}" style="display:none">
						<table cellpadding="0" cellspacing="0" style="width: 100%" id="">
							<tr>
								<td><div id="AssetList">{AssetList}</div></td>
							</tr>
						</table>
						</div>
						&nbsp;
						</div>
            </div>
			</div>

        </div>

    </div>

</div>
