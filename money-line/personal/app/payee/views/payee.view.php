<?php defined('RAXANPDI') || die(); ?>

<div class="user-payee-maintenance round bold-border-outline" id="payeelisting">
    <h3 langid="payee.heading">Payee Listing</h3>
    <hr>
    <div>
        <div id="errorList"></div>
        <div style="margin-bottom: 15px" align="right">
            <input langid="payee.listing.add" type="submit" name="addpayee" id="addpayee"  class="button process" xt-bind="#click, addNewPayee" value="Add Payee"/>
            &nbsp;
            <input langid="payee.listing.addcompany" type="submit" name="addcompany" id="addcompany" class="button" value="Add Approved Company" xt-bind="#click, addApprovedCompany"/>
            &nbsp;
        </div>
        
        <div id="payeeList">
           <h3 class="lightgray pad"><a href="#">{name}</a></h3>
            <div class="clear">
                <div class="policy-col left" style="width:500px;">
                    <p>{description}</p>
                    <input type="hidden" name="{id}" value="{id}"/>
               </div>
               <div class="policy-col right" style="width:90px; text-align: right;" id="modifyoptions">
                   <a data-event-value ="{id}" class="editpayee redcolor bold" >Edit</a> |
                   <a data-event-value ="{id}" class="removepayee bluecolor bold" >Remove</a>
               </div>
                <hr>
                
            </div>
        </div>
        <hr>

    </div>
</div>
