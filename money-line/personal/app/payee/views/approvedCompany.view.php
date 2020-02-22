<?php defined('RAXANPDI') || die(); ?>

<div class="payee-setup-company-account round bold-border-outline ">
    <div id="newpayeesetup" class="">
        <h2  class="ui-section-heading bold red" langid="">New Approved Company</h2>
        
        <form class="" name="webnewapprovedcompany" id="webnewapprovedcompany" action="" method="post">
            <div>
                 <ul>
                     <li><label langid="">Select Company Category</label><br>
                        <select id="selCompanyCategory" name="selCompanyCategory" class="ltm15 ttm"><option value="{AppCategoryNo}">{AppCategoryName}</option></select>
                    </li>
                </ul>
             </div>
            <hr class="clear ttm" />
            <div>
                <ul>
                     <li><label langid="">Select a Pre-defined Company</label><br>
                        <select id="selNewPreDefinedCompany" name="selNewPreDefinedCompany" class="ltm15 ttm"><option value="{AppCompanyNo}">{AppCompanyName}</option></select>
                    </li>
                </ul>
            </div>
            <hr class="clear ttm" />
            <div>
                <h2  class="ui-section-heading bold" langid="">Company Account Details</h2>
                <div class="round bold-border-outline silver" id="companyaccountdetails">
                    <ul>
                        <li>
                            <label langid="" class="ltm15 ttm bold">Account Alias</label><br/>
                            <input type="textbox" name="accountalias" id="accountalias" class="ltm15 c30" /><br/>
                        </li>
                    </ul>
                    <ul>
                        <div class="column">
                            <label langid="" class="ltm15 ttm">Company Short Name</label><label class="red">*</label><br/>
                            <input type="textbox" name="companyshortname" id="companyshortname"  class="ltm15" /><br/>
                        </div>    
                        <div class="column">
                            <label langid="" class="ltm15 ttm">Account Reference Number</label><label class="red">*</label><br/>
                            <input type="textbox" name="accountreferencenumber" id="accountreferencenumber"  class="ltm15 c10" /><br/>
                        </div>
                        <div class="column">
                            <label langid="" class="ltm15 ttm">Cheque Description</label><br/>
                            &nbsp;&nbsp;&nbsp;&nbsp;<label langid="" class="bold" id="chequeDescription" name="chequeDescription"></label><br/>
                        </div>
                    </ul>
                    <div class="clear ttm pad">
                        &nbsp;&nbsp;Enter a short name for the company to be printed on the cheque.  This can be the company's abbreviation, etc.<br>
                        &nbsp;&nbsp;Enter the reference or account number.
                    </div>
                </div>
            </div>
            <hr class="clear ttm" />
            <div style="margin-bottom: 15px" align="right">
                <input langid="" type="submit" name="payeelistinghome" id="payeelistinghome" class="button left c6 returnToOverview" value="Cancel"/>
                &nbsp;
                <input langid="" type="submit" name="savecompany" id="savecompany" class="button process c6" value="Next" xt-bind="#click, payeeSetupVerfication"/>
                &nbsp;
            </div>
        </form>
    </div>

</div>
