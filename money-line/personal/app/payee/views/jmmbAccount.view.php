<?php defined('RAXANPDI') || die(); ?>

<div class="payee-setup-jmmb-account round bold-border-outline">
    <div id="payeesetupjmmbaccount" class="">
        <h2  class="ui-section-heading bold" langid="payee.setup.jmmb.account.title">Payee Setup - JMMB Account</h2>

        <form class="" name="webpayeesetupjmmbac" id="webpayeesetupjmmbac" action="" method="post">
            <div>
                 <ul>
                     <li><label langid="payee.name">Payee Name:</label><span id="jmmbpayeeName" name="jmmbpayeeName">Mary P. Jane</span><br>
                        <label langid="payee.setup.jmmb.account.account.alias">Account Alias:</label><input type="textbox" name="jmmbaccountAlias" id="jmmbaccountAlias" class=" " /><br/>
                    </li>
                </ul>
             </div>
            <hr class="clear ttm" />
            <div><span langid="payee.setup.jmmb.account.details.title"  class="bold redcolor " >JMMB Account Details</span></div>
            <div  class="  ttm clear " >
                <ul>
                    <li><label langid="payee.setup.jmmb.account">JMMB Account</label><label  class="pmrequired">*</label><input id="jmmbaccount" name="jmmbaccount" type="textbox"/><select id="seljmmbacCurrency" name="seljmmbacCurrency"><option value="{0}">{0} ({1}:1)</option></select></li>
                </ul>
            </div>
            <hr class="clear ttm" />
            <div class="buttonbar clear" style="height:40px;" >
                <button class="button default right tpm btm rtm" type="submit" name="payeesetupjmmbacNextbtn" id="payeesetupjmmbacNextbtn" xt-bind="#click,savePayeeDetail,#webpayeesetupjmmbac, #webpayeesetupjmmbac .ctrl" >
                    <img src="views/images/loader.gif" alt="." class="hide" style="margin-right:5px;"/><span langid="new.payee.setup.button.next" style="vertical-align:middle">&nbsp;Next&nbsp;</span>
                </button>
                <button class="button default right tpm btm rtm" type="submit" name="payeesetupjmmbacFinishbtn" id="payeesetupjmmbacFinishbtn" xt-bind="#click,savePayeeDetail,#webpayeesetupjmmbac, #webpayeesetupjmmbac .ctrl" >
                    <img src="views/images/loader.gif" alt="." class="hide" style="margin-right:5px;"/><span langid="new.payee.setup.button.finish" style="vertical-align:middle">&nbsp;Finish&nbsp;</span>
                </button>
                <button class="button default right tpm btm rtm" type="submit" name="payeesetupjmmbacPreviousbtn" id="payeesetupjmmbacPreviousbtn" xt-bind="#click,savePayeeDetail,#webpayeesetupjmmbac, #webpayeesetupjmmbac .ctrl" >
                    <img src="views/images/loader.gif" alt="." class="hide" style="margin-right:5px;"/><span langid="new.payee.setup.button.previous" style="vertical-align:middle">&nbsp;Previous&nbsp;</span>
                </button>
                <button  class="ctrl button  left tpm btm rtm" type="submit" name="payeesetupjmmbacCancelbtn" id="payeesetupjmmbacCancelbtn" xt-bind="#click" langid="new.payee.setup.button.cancel" >&nbsp;Cancel&nbsp;</button>
            </div>
        </form>
    </div>

</div>
