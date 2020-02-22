<?php defined('RAXANPDI') || die(); ?>

<div class="payee-setup-company-account round bold-border-outline ">
    <div id="newpayeesetup" class="">
        <h2  class="ui-section-heading bold red" langid="">Payee Setup - Security Verification</h2>

        <div class="pad">
            An email verification was sent to your email. please enter the verification code below.
        </div>

        <form class="" name="webpayeeverification" id="webpayeeverification" action="" method="post">
            <h2  class="ui-section-heading bold" langid="">Payee Verification</h2>
            <div class="column">
                <label langid="" class="ltm15 ttm">Company Short Name</label><label class="red">*</label><br/>
                <input type="textbox" name="companyshortname" id="companyshortname"  class="ltm15" /><br/>
            </div>
            <div class="column">
                <label langid="" class="ltm15 ttm">Account Reference Number</label><label class="red">*</label><br/>
                <input type="textbox" name="accountreferencenumber" id="accountreferencenumber"  class="ltm15 c10" /><br/>
            </div>

            <hr class="clear ttm" />
            <div style="margin-bottom: 15px" align="right">
                <input langid="" type="submit" name="payeeverificationcanel" id="payeeverificationcanel" class="button left c6 returnToOverview" value="Cancel"/>
                &nbsp;
                <input langid="" type="submit" name="cancelverificationsave" id="cancelverificationsave" class="button process c6 softgreen" value="Previous" xt-bind="#click, addApprovedCompany"/>
                &nbsp;
                <input langid="" type="submit" name="savecompany" id="savecompany" class="button process c6" value="Next" xt-bind="#click, paySetupVerfication"/>
                &nbsp;
            </div>
        </form>
    </div>

</div>
