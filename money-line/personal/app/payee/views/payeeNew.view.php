<?php defined('RAXANPDI') || die(); ?>

<div class="new-payee-setup round bold-border-outline">
    <div id="newpayeesetup" class="">
        <h3  class="ui-section-heading bold" name="payeesetuptitle" id="payeesetuptitle" langid="new.payee.setup">New Payee Setup</h3>
        <strong><p langid="new.payee.setup.msg">Payee Information</p></strong>
        <form class="" name="webnewpayeesetup" id="webnewpayeesetup" action="" method="post">
            <div>
                <input type="hidden" name ="hidpayeeid" id="hidpayeeid" />
             <ul>
                <li><input id="rdPayeeInfo" name="rdPayeeInfo" type="radio" value="0"/><label langid="new.payee.setup.payee.name">Payee Name (for Wires, Encashment and Internal transfer):</label><br>
                    <input type="textbox" name="payeename" id="payeename" class="ltm15 " /><br/>
                    <label langid="new.payee.setup.payee.description" class="ltm15 ttm">Payee Description</label><br/>
                    <input type="textbox" name="payeedescription" id="payeedescription"  class="ltm15 " /><br/>
                </li>
            </ul>
             </div>
            <hr class="clear ttm" />
            <div><span langid="new.payee.setup.payment.details.title"  class="bold redcolor ">Additional Payee Details</span></div>
            <div  class="highlight-bg  ttm clear round" >
                <div class="ttm bmm">
                    <ul>                        
                        <li class="ttm"><span class="ltm15" id=""><input id="rdAddNewAcInfo" name="rdAddNewAcInfo" type="radio" value="chequeEncashment"/> <label langid="new.payee.setup.new.account.info"> Cheque Encashment Delivery Details</label></span></li>
                        <li class="ttm"><span class="ltm15" id="" ><input id="rdAddNewAcInfo" name="rdAddNewAcInfo" type="radio" value="otherjmmbaccount"/> <label langid="new.payee.setup.new.account.info"> Setup details to send funds to JMMB Account (Other than mine)</label></span></li>
                        <li class="ttm"><span class="ltm15 accvalidate" id="" name="localbankaccount"><input id="rdAddNewAcInfo" name="rdAddNewAcInfo" type="radio" value="localbankaccount"/> <label langid="new.payee.setup.new.account.info"> Setup details to Local Bank Account</label></span></li>
                        <li class="ttm"><span class="ltm15 accvalidate" id="" name="internationalAccount"><input id="rdAddNewAcInfo" name="rdAddNewAcInfo" type="radio" value="internationalAccount"/> <label langid="new.payee.setup.new.account.info"> Setup details to an International Bank Account</label></span></li>
                    </ul>
                </div>
            </div>
            <hr class="clear ttm" />
            <div class="buttonbar" style="height:40px;" >
                <button class="ctrl button left tpm btm rtm returnToOverview c6" type="submit" name="newpayeesetupCancelbtn" id="newpayeesetupCancelbtn" langid="new.payee.setup.button.cancel" >Cancel</button>

                <button class="button default right tpm btm rtm process c6" type="submit" name="newpayeesetupSavebtn" id="newpayeesetupSavebtn" xt-bind="#click, saveNewPayeeSetup">
                    <img src="views/images/loader.gif" alt="." class="hide" style="margin-right:5px;"/><span langid="new.payee.setup.button.next" style="vertical-align:middle">&nbsp;Next&nbsp;</span>
                </button>
            </div>
        </form>
    </div>
    <div id="flashmsg"></div>
</div>