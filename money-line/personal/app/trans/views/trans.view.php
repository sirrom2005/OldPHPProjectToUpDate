<?php defined('RAXANPDI')||die(); ?>

<div id="screenTop">
    <br>
    <h3 id="txnTitle" langid="txn.title">Transaction</h3>
    
</div>

<div class=" transBox" id="type" >
    <form class="frmTrans" method="post" >
        <div class="topSection" >
            <br>
        </div>
        <div class="transSectionHeader" id="typeSectionHeader" >
            <label class="naviTitle regular" langid="txn.type">Type of Transaction</label>
        </div>
        <div class="transSection" id="typeSection">
            <br>
            <label class="regular" langid="txn.type.desc">Select the type of transaction you would like to execute</label>
            <br>
            <br>
            <div class="typeOption" id="typeOptionChequeSection" >
                <div class="left">
                    <input  type ="radio" id="transType1" name ="transType" value ="CHEQUE">
                </div>
                <div class="left">
                    <b>
                    <label class="regular" langid="txn.type.CHEQUE.title" for ="transType1">
                        Cheque Encashment
                    </label>
                    </b>
                    <br>
                    <label class="regular" langid="txn.type.CHEQUE.desc" for ="transType1">
                        Select this option if you would like to request a cheque encashment from your account.
                    </label>
                </div>
            </div>
            <br>
            <br>
            <div class="typeOption" id="typeOptionTransferSection" >
                <div class="left">
                    <input type ="radio" id="transType2" name ="transType" value ="TRANSFER">
                </div>
                <div class="left">
                    <b>
                    <label class="regular" langid="txn.type.TRANSFER.title" for ="transType2">
                        Transfer Money Between Account
                    </label>
                    </b>
                    <br>
                    <label class="regular" langid="txn.type.TRANSFER.desc" for ="transType2" >
                        Select this option if you would like to transfer money between you internal account or another JMMB account.
                    </label>
                </div>
            </div>
            <br>
            <br>
            <div class ="typeOption" id="typeOptionWireSection">
                <div class="left">
                    <input type ="radio" id="transType3" name ="transType" value ="WIRE">
                </div>
                <div class="left">
                    <b>
                    <label class="regular" langid="txn.type.WIRE.title" for ="transType3">
                        Wire Money To Another Account
                    </label>
                    </b>
                    <br>
                    <label class="regular" langid="txn.type.WIRE.desc" for ="transType3" >
                        Select this option if you would like to wire money to an external account.
                    </label>
                </div>
            </div>
            <br>
            <br>
            <br>
        </div>
        <div class="naviSection">
            <br>
            <div class="left naviLeft">
                <button class="button naviBtn " type="submit" name="cancelBtn" id="cancelBtn" xt-bind="#click,eventCancel">
                    <img src="views/images/loader.gif" alt="." class="hide" /> <img src="views/images/cancel.png">&nbsp;<span langid="txn.btn.cancel" >Cancel</span>
                </button>
            </div>
            <div class="left naviRight">
                &nbsp;&nbsp;&nbsp;
                <button class="button naviBtn  " type="submit" name="expertBtn" id="expertBtn" xt-bind="#click,processExpert">
                    <img src="views/images/loader.gif" alt="." class="hide" /> <img src="views/images/application_lightning.png">&nbsp;  <span langid="txn.btn.expert" >Expert</span>
                </button>
                &nbsp;&nbsp;&nbsp;
                <button class="button naviBtn  " type="submit" name="nextBtn" id="nextBtn" xt-bind="#click,processType">
                    <img src="views/images/loader.gif" alt="." class="hide" /><span langid="txn.btn.next" >Next</span> <img src="views\images\arrow_right.png">
                </button>
                
            </div>
        </div>
    <br>
    <br>
    </form>
</div>
<div class="left" id="expertDiv" >

    <div class="transBox" id="expertType" >
        <form class="frmTrans" method="post" >
<!--           <div class="topSectionExpert" >
                <br>
            </div>-->

            <div class="transSectionHeader" id="typeSectionHeader" >
                <label class="naviTitle regular" langid="txn.type">Type of Transaction</label>
            </div>
            <div class="transSection" id="typeSection">
                <br>
                <select id="transExpertType"name="transType" xt-bind="#change, processType , , #payee" >
                    <option value="" langid="txn.type" >Select Transaction Type ...</option>
                    <option value="CHEQUE" langid="txn.type.CHEQUE.title" >Cheque Encashment</option>
                    <option value="TRANSFER" langid="txn.type.TRANSFER.title">Transfer Money Between Account</option>
                    <option value="WIRE" langid="txn.type.WIRE.title">Wire Money To Another Account</option>
                </select>
                <br>
                <br>
            </div>
        </form>
    <br>
    </div>
    <div class="transBox" id="payee" >
        <form class="frmTrans" method="post" >
            <div class="topSection" >
                <br>
            </div>
            <div class="transSectionHeader" id="payeeSectionHeader" >
                <label class="naviTitle regular" id="payeeScreenSubtitle" langid="txn.payee">Select payee</label>
            </div>
            <div class="transSection" id="payeeSection">
                <br>
                <div class="entryItem " id ="payeeListSection" >
                    <div class="hide">
                        <input class="textbox" type ="input" id ="payeeSearch" name="payeeSearch">
                        <button class="button " type="submit" name="searchBtn" id="searchBtn" xt-bind="#click,payeeSearch">
                           <img src="views/images/loader.gif" alt="." class="hide" /><span langid="txn.btn.search" >Search</span>
                        </button>
                        <button class="button " type="submit" name="payeeAddBtn" id="payeeAddBtn" xt-bind="#click,processAddPayee">
                           <img src="views/images/loader.gif" alt="." class="hide" /><span langid="txn.btn.payeeAdd" >Add Payee</span>
                        </button>
                    </div>
                    <select class ="selectList" id ="payeeList" name ="payeeList" size="3" xt-bind="#change, eventPayeeSelect, ,.payeeDetails " >
                        <option data-payeeType="{payeeType}" value ="{ROWCOUNT}">{name}{payeeName} ({description}{payeeDescription})</option>
                    </select>
                    <br>
                </div>
                <div class="hide full  " id ="deliverySection" >
                    <br>
                    <div class="left entryItem payeeDetails" id ="deliveryOptionsSection" >
                        <label class="deliveryClass" for ="deliveryMethod" langid="txn.payee.deliveryMethod">Delivery Method :</label>
                        <br>
                        <select class="deliveryClass" id ="deliveryMethod" name ="deliveryMethod"  >
                            <option value ='PICKUP' langid="txn.payee.deliveryMethod.PICKUP">Pickup >></option>
                        </select>
                    </div>

                    <div class="hide left entryItem payeeDetails " id ="branchListSection" >
                        <label class="deliveryClass"  for ="branchList" langid="txn.payee.branch" >Pick up Branch :</label>
                        <br>
                        <select class="deliveryClass" id ="branchList" name ="branch" >
                            <option value ="{branchCode}">{branchName}</option>
                        </select>
                    </div>
                    <div class="hide left entryItem payeeDetails" id ="addressListSection" >
                        <label class="deliveryClass" for ="addressList" langid="txn.payee.address" >Delivery Address :</label>
                        <br>
                        <select class="deliveryClass" id ="addressList" name ="addressList"  >
                            <option data-address ="{addressLine1}|{addressLine2}|{addressLine3}|{addressCountryCode}" value="{ROWCOUNT}">{alias}</option>
                        </select>
                        <br class="addressLb address hide">
                        <br class="addressL1 address hide">
                        <label class =" addressLb address hide  " for ="address" langid="txn.payee.address.details" >Delivery Address Details :</label>
                        <br class="addressL1 address hide">
                        <input class="addressL1 address hide" name ="addressLine1" id="addressLine1">
                        <br class="addressL2 address hide">
                        <input class="addressL2 address hide" name ="addressLine2" id="addressLine2">
                        <br class="addressL3 address hide">
                        <input class="addressL3 address hide" name ="addressLine3" id="addressLine3">
                        <br class="addressCc address hide">
                        <select class="addressCc address hide" name ="addressCountryCode" id="addressCountryCode" >
                            <option value ="{code}">{name}</option>
                        </select>
                        <br>
                    </div>
                    <br>
                </div>
                <div class="hide payeeDetails " id ="transferSection" >
                    <br>
                   <div class="entryItem">
                       <label langid="txn.payee.jmmbAccounts" >JMMB Accounts</label><br>
                       <select id ="transferAccountList" name ="transferAccountList" size="3" xt-bind="#change, eventTransferAccountList, , #transferAccountTradeSection "   >
                            <option data-AccInfo="{accRefCurrency}|" value ="{ROWCOUNT}">{jmmbAccountNo} {alias}</option>
                       </select>
                   </div>
                    <div class ="hide" id="transferAccountTradeSection">
                        <br>
                        <div class="left entryItem">

                            <label for ="transferAccountTradeList"  langid="txn.payee.tradeTerms"  >Trade Terms : </label>
                            <br>
                            <select id ="transferAccountTradeTerms"  name="transferAccountTradeTerms"   >
                                <option value ="{Code}">{CodeDesc}</option>
                            </select>
                        </div>
                        <div class="left entryItem">

                            <label for ="transferAccountTradeList" langid="txn.payee.maturities" >Maturities : </label>
                            <br>
                            <select id ="transferAccountTradeList" name="transferAccountTradeList"   >
                                <option value ="{ROWCOUNT}">{maturityDate}  {currency} {maturityValue}</option>
                            </select>
                        </div>
                        <br>
                    </div>
                </div>
                <div class="hide entryItem payeeDetails" id ="wireSection" >
                    <br>
                   <label langid="txn.payee.wireAccounts">Bank Accounts</label><br>
                   <select id ="wireAccountList" name ="wireAccountList" size="5" >
                        <option data-AccInfo="{accRefCurrency}|" value ="{ROWCOUNT}">{alias}</option>
                    </select>
                </div>
                <br>
            </div>
            <div class="transSectionHeader" id="noteSectionHeader" >
                <label class="naviTitle regular"  langid="txn.payee.note">Notes </label>
            </div>
            <div class="transSection" id="noteSection">
                <div class="hide" id ="specialInstructionSection">
                    <br>
                    <div class=" entryItem"  >
                        <label langid="txn.payee.instruction">Special Instruction : </label><br>
                        <textarea id ="specialInstruction" name="specialInstruction"></textarea>
                    </div>
                </div>
                <div id ="personalNoteSection">
                    <br>
                    <div class="entryItem"  >
                        <label langid="txn.payee.personalNote" >Personal Note : </label><br>
                        <textarea id ="personalNote" name="personalNote"></textarea>
                    </div>
                </div>
                <br>
            </div>
            <div class="naviSection">
                <br>
                <div class="left naviLeft">
                    <button class="button naviBtn" type="submit" name="cancelBtn" id="cancelBtn" xt-bind="#click,eventCancel">
                        <img src="views/images/loader.gif" alt="." class="hide" /><img src="views/images/cancel.png">&nbsp;<span langid="txn.btn.cancel" >Cancel</span>
                    </button>
                </div>
                <div class="left naviRight">
                    &nbsp;&nbsp;&nbsp;
                    <a  id="backButton" class="button naviBtn" href="app/trans/trans.php"><img src="views/images/arrow_left.png">&nbsp;<span langid="txn.btn.startOver"  >Start Over</span></a>
                    &nbsp;&nbsp;&nbsp;
                    <button class="button naviBtn" type="submit" name="nextBtn" id="nextBtn" xt-bind="#click,processPayee">
                       <img src="views/images/loader.gif" alt="." class="hide" /><span langid="txn.btn.next" >Next</span> <img src="views/images/arrow_right.png">
                    </button>
                </div>
                <br>
            </div>
        </form>
        <br>
    </div>
    <div class="transBox" id="source" >
        <form class="frmTrans" method="post" >
            <div class="topSection" >
                <br>
            </div>
            <div class="transSectionHeader" id="sourceSectionHeader" >
                <label class=" naviTitle regular" langid="txn.source">Source Account</label>
                <div class="transSectionHeaderInfo" id="sourceSectionInfo"></div>
            </div>
            <div class="transSection" id="sourceSection">
                <br>
                <div class ="left entryItem" id ="ownAccountList"  >
                    <label class="regular" for ="sourceAccount" langid="txn.source" >Source Account : </label>
                    <br>
                    <select class="sources" id ="sourceAccount" name="sourceAccount" xt-bind="#change, eventSourceAccount, , .conversionRate " >
                        <option value ="{ROWCOUNT}" data-AccInfo="{AccountNo}|{AccountType}|{SigningInstructiions}|{Currency}|{AvailableBalance}|{ProductType}" title="{Currency} {AvailableBalance}" >{AccountNo} - {AccountName}</option>
                    </select>
                    <input id="sourceAccountNoValue" name="sourceAccountNoValue" type="hidden">
                    <input id="sourceAccountCurrency" name="sourceAccountCurrency" type="hidden">
                    <br>
                </div>
                <br>
                <div class =" left hide entryItem" id="accountMaturities">
                    <br>
                    <label class="regular" for ="sourceMaturity" langid="txn.source.maturities" >Account Maturities : </label>
                    <br>
                    <select class="sources" id ="sourceMaturity" name="sourceMaturity" xt-bind="#change, eventSourceMaturity " >
                        <option value ="{ROWCOUNT}">{maturityDate}  {currency} {maturityValue}</option>
                    </select>
                    <br>
                </div>
                <br>
                <br>
                <div class="left" id="accInfoToggle" >+&nbsp;</div>
                <div class="left full" id="accInfo" >
                    <div class="left infoItem">
                        <label class="regular" langid="txn.source.accountType" >Account Type: </label><br>
                        <div id="sourceAccountType"><br></div>
                    </div>
                    <div class="left infoItem">
                        <label class="regular" langid="txn.source.signing" >Signing Instructions: </label><br>
                        <div id="sourceSigningInstructiions"><br></div>
                    </div>
                    <div class="left infoItem">
                        <label class="regular" langid="txn.source.balance" >Available Balance: </label><br>
                        <div id="sourceAvailableBalance"><br></div>
                    </div>
                    <br>
                </div>
                <br>
            </div>
            <div class="transSectionHeader" id="amountSectionHeader" >
                <label class="naviTitle regular"  langid="txn.source.amount">Payment Amount</label>
            </div>
            <div class="transSection" id="amountSection" >
                <br>
                <div class="left entryItem" id ="" >
                    <label class="regular " for="amountEntered"langid="txn.source.amountCurrency" >Amount / Currency :</label><span class="entryItemMsg" id="amountEnteredMsg"></span>
                    <br>
                    <input class="textbox regular"id ="amountEntered" name ="amountEntered" placeholder="Enter amount" >
                    &nbsp;
                    <select id ="amountCurrency" name="amountCurrency" xt-bind="#change, eventAmountCurrency, , .conversionRate  "   >
                        <option value ="{0}">{0}</option>
                    </select>
                </div>
                <div class =" entryItem left  " >
                    <label class="regular " for="amountEntered" ></label>
                    <br>

                </div>
                <div class=" left hide leftMargin" id="internationalChequeDisplay">
                    <br>
                    <input type="checkbox" id="internationalCheque" name="internationalCheque">
                    <label class="regular" for="internationalCheque" langid="txn.source.internationalCheque" > Request an International Cheque</label>
                </div>
                <br>
                <br>
                <div class="left" id="amountInfoToggle" >+&nbsp;</div>
                <div class="left full" id="amountInfo">

                    <div class="left infoItemFull"  >
                        <label class="regular" ><span langid="txn.source.amountInWords"  >Amount in Words</span> <span class="amountCurrencyDisplay"></span> : </label><br>
                        <div class="left" id="amountCurrencyImage"></div><div class="left" id="amountInWords" ><br>&nbsp;</div>
                    </div>
                    <br>
                    <div class="hide" id="excnahgeRateSection">
                        <br>
                        <div class="left infoItem " >
                            <label ><span langid="txn.source.amountIn" >Amount in</span> <b><span class="sourceCurrencyDisplay"></span></b>&nbsp;: </label>
                            <div class="conversionRate" id="amountInSourceCurrency"><br></div>
                        </div>
                        <div class="left infoItem" >
                            <label><b><span class="sourceCurrencyDisplay"></span>&nbsp;to&nbsp;<span class="amountCurrencyDisplay"></span></b>&nbsp;<span langid="txn.source.exchangeRate" >Exchange Rate : </span></label>
                            <div class="conversionRate" id="exchangeRate"><br></div>
                        </div>
                        <div class="left infoItem" >
                            <label langid="txn.source.rateDate">Rate as at Date : </label>
                            <div class="conversionRate" id="rateDate"><br></div>
                        </div>
                    </div>
                    <br>
                </div>
                <br>
                <br>
            </div>
            <div class="naviSection">
                <br>
                <div class="left naviLeft" >
                    <button class="button naviBtn" type="submit" name="cancelBtn" id="cancelBtn" xt-bind="#click,eventCancel">
                        <img src="views/images/loader.gif" alt="." class="hide" /><img src="views/images/cancel.png">&nbsp;<span langid="txn.btn.cancel" >Cancel</span>
                    </button>
                </div>
                <div class="left naviRight" >

                    &nbsp;&nbsp;&nbsp;
                    <a  id="backButton" class="button naviBtn" href="app/trans/trans.php"><img src="views/images/arrow_left.png">&nbsp;<span langid="txn.btn.back" >Back</span></a>
                    &nbsp;&nbsp;&nbsp;
                    <button class="button naviBtn" type="submit" name="nextBtn" id="nextBtn" xt-bind="#click,processSource">
                       <img src="views/images/loader.gif" alt="." class="hide" /><span langid="txn.btn.next" >Next</span> <img src="views/images/arrow_right.png">
                    </button>
                </div>
                <br>
            </div>
        </form>
        <br>

    </div>
    <div class="transBox " id="schedule" >
        <div id="txnSummary2"></div>
        <form class="frmTrans" method="post" >
            <div class="topSection">
                <br>
            </div>
            <div class="transSectionHeader" id="scheduleSectionHeader" >
                <label class="naviTitle regular" langid="txn.schedule">Enter Transaction schedule</label>
            </div>
            <div class="transSection" id="scheduleSection" >
                <br>
                <div class="tabOption" id="frequencyOptionOnce">
                    <input type ="radio" id="transFrequencyOption1" name ="transFrequencyOption" value ="ONCE" checked xt-bind="#click,eventFequency ,  ,#chargesInfo " >
                    <label class="regular" for ="transFrequencyOption1" langid="txn.schedule.ONCE">One Time Payment</label>
                </div>
                <div class="tabOption" id="frequencyOptionMultiple">
                    <input type ="radio" id="transFrequencyOption2" name ="transFrequencyOption" value ="MULTIPLE" xt-bind="#click,eventFequency, , #chargesInfo " >
                    <label class="regular" for ="transFrequencyOption2" langid="txn.schedule.MULTIPLE">Recurring Payment</label>
                </div>
                <br>
                <div class="tabSection" id ="oneTimeFrequency" >
                    <br>
                    <div class="left entryItem" id ="" >
                        <label langid="txn.schedule.effectiveDate">Effective Date :</label><br>
                        <input type="text" id="transactionDate" name="transactionDate" class="dtPicker" />
                        <img id="txnDateImg" class="datepicker-image click-cursor" src="views/images/calendar_month.png" alt="."  />
                    </div>
                    <br>
                    <br>
                </div>
                <div class="tabSection" id ="multipleFrequency" >
                    <br>
                    <div class="left entryItem" id ="" >
                        <label class="regular" for ="cyclePeriod" langid="txn.schedule.cycle">Select payment frequency :</label><br>
                        <select id ="cyclePeriod" name ="cyclePeriod"  >
                            <option value ="{cyclePeriodCode}">{cyclePeriodDesc}</option>
                         </select>
                    </div>
                    <div class="left entryItem hide" id="cyclePeriodDaysSection">
                        <label langid="txnDate" langid="tx.schedule.cycleDays">Number of Days :</label><br>
                        <input type="text" id="cyclePeriodDays" name="cyclePeriodDays" />
                    </div>
                    <br>
                    <br>
                    <div class="left entryItem">
                        <label langid="txn.schedule.startDate">Start Date :</label><br>
                        <input type="text" id="cyclePeriodStartDate" name="cyclePeriodStartDate" class="dtPicker" />
                        <img id="txnDateImg" class="datepicker-image click-cursor" src="views/images/calendar_month.png" alt="."  />
                    </div>
                    <div class="left entryItem">
                        <label langid="txn.schedule.endDate">End Date :</label><br>
                        <input type="text" id="cyclePeriodEndDate" name="cyclePeriodEndDate" class="dtPicker" />
                        <img id="txnDateImg" class="datepicker-image click-cursor" src="views/images/calendar_month.png" alt="."  />
                    </div>
                    <br>
                    <br>
                    <div >
                        <label  class="regular" langid="txn.schedule.businessDay" >If holiday or weekend, execute transaction on the:</label>
                        <br>
                        <br>
                        
                        <input type ="radio" id="businessDayOption1" name ="businessDayOption" value ="PREVIOUS" checked >
                        <label class="regular" for ="businessDayOption1" langid="txn.schedule.businessDay.PREVIOUS">Previous Business Day</label>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type ="radio" id="businessDayOption2" name ="businessDayOption" value ="NEXT" >
                        <label class="regular" for ="businessDayOption2" langid="txn.schedule.businessDay.NEXT" >Next Business Day</label>
                        
                    </div>
                </div>
                <br>
                <div class="left full horiOption" id="chargesInfo" >
                    <b><div langid="txn.schedule.charges.title">Service Charges</div></b>
                    
                    <div class="left infoItem">
                        <label class="regular" langid="txn.schedule.charges" >Charges : </label><br>
                        <div class ="charges" id="chargesAmount"><br></div>
                    </div>
                    <div class="left infoItem">
                        <label class="regular" langid="txn.schedule.chargesTax" >Tax : </label><br>
                        <div class ="charges" id="chargesTax"><br></div>
                    </div>
                    <div class="left infoItem">
                        <label class="regular" langid="txn.schedule.chargesTotal">Total Charges : </label><br>
                        <div class ="charges" id="chargesTotal"><br></div>
                    </div>
                    <br>
                </div>
                <br>
            </div>
            <div class="naviSectionFinish">
                <br>
                <div class="left naviLeft" >
                    <button class="button naviBtn" type="submit" name="cancelBtn" id="cancelBtn" xt-bind="#click,eventCancel">
                        <img src="views/images/loader.gif" alt="." class="hide" /><img src="views/images/cancel.png">&nbsp;<span langid="txn.btn.cancel" >Cancel</span>
                    </button>
                    &nbsp;&nbsp;&nbsp;
                </div>
                <div class="left naviRight" >
                    <a  id="backButton" class="button naviBtn"href="app/trans/trans.php"><img src="views/images/arrow_left.png">&nbsp; <span langid="txn.btn.back" >Back</span></a>
                    &nbsp;
                    <button class="button " type="submit" name="addMoreBtn" id="addMoreBtn" xt-bind="#click, saveAndEnterNew ">
                       <img src="views/images/loader.gif" alt="." class="hide" /><span langid="txn.btn.saveAdd" >Save & Add </span> <img src="views/images/application_add.png">
                    </button>
                    &nbsp;
                    <button class="button naviBtn  " type="submit" name="expertBtn" id="expertBtn" xt-bind="#click,processWizard">
                        <img src="views/images/loader.gif" alt="." class="hide" /> <img src="views/images/application_cascade.png">&nbsp;  <span langid="txn.btn.wizard" >Wizard</span>
                    </button>
                    &nbsp;
                    <button class="button " type="submit" name="nextBtn" id="nextBtn" xt-bind="#click, saveAndContinue">
                       <img src="views/images/loader.gif" alt="." class="hide" /><span langid="txn.btn.saveContinue" >Continue</span> <img src="views/images/arrow_right.png">
                    </button>
                </div>
            </div>
            <br>
            <br>
        </form>

    </div>
</div>

<div class="transBoxReview full" id="review" >
    <form name="frmTrans"method="post">
        <div class="transSectionReview" id="reviewSection" >
            <br>
            <h3 id="txnTitle" langid="txn.review.title">Pending Transaction(s)</h3>

            <table class="reviewTbl" cellspacing="0" >
                <thead  class="reviewTblHeader" >
                    <tr   >
                        <th langid="txn.review.actions">Actions</th>
                        <th langid="txn.review.account" colspan="2">Account</th>
                        <th langid="txn.review.type">Trans Type</th>
                        <th langid="txn.review.schedule">Schedule</th>
                        <th langid="txn.review.payee">Payee</th>
                        <th langid="txn.review.details">Details</th>
                        <th langid="txn.review.amount" colspan="2" >Amount</th>
                    </tr>
                </thead>
                <tbody  id="txnReviewList" xt-delegate=".deleteLink #click, eventDeleteTxn ; .editLink #click, eventEditTxn"  >
                    <tr class="reviewTblData " id="txnReviewSummary{ROWCOUNT}">
                        <td class="toggleTxnDetailsTd toggleTxnStatusTd">
                            <a  class="editLink" id="editButton" href="#{ROWCOUNT}"><span langid="txn.review.lnk.edit" >Edit</span></a> |
                            <a  class="deleteLink" id="deleteButton" href="#{ROWCOUNT}" ><span langid="txn.review.lnk.remove" >Remove</span></a> |
                            <a data-txnRowId="{ROWCOUNT}" class="toggleTxnDetails"  ><span langid="txn.review.lnk.details" >Details</span></a>
                        </td>

                        <td>{sourceAccount}</td>
                        <td><img src="views/images/flags/jmmbCurrencies/{sourceCurrency}.png" title="{sourceCurrency}" alt="{sourceCurrency}"></td>
                        <td><label class="regular" langid="txn.type.{transTypeSelected}">{transTypeSelected}</label></td>
                        <td>{txnSchedule}</td>
                        <td>{payeeName}{payeeType}</td>
                        <td>{txnDetails}</td>
                        <td ><div class="right"><b>{amountEntered}</b></div></td>
                        <td ><img src="views/images/flags/jmmbCurrencies/{amountCurrency}.png" title="{amountCurrency}" alt="{amountCurrency}"></td>
                    </tr>
                    <tr class="hide reviewTblDetails" id="txnDetails{ROWCOUNT}" >
                       
                        <td  class="detailsPre"  >
                            >
                        </td>
                        <td  class="details"  colspan="8">
                                    {txnMoreDetails}
                                    <br>
                        </td>

                    </tr>
                </tbody>
            </table>

        </div>
        <div class="naviSectionListings">
            <div class="left naviLeft" >
                <div class="left entryItem">
                    <label >&nbsp;</label><br>
                    <button class="button " type="submit" name="newtBtn" id="newtBtn" xt-bind="#click,eventAddNew">
                        <img src="views/images/loader.gif" alt="." class="hide" /><span langid="txn.btn.new" >Add Transaction</span>
                    </button>
                </div>
            </div>
            <div class="left naviRight" >
                <div class="left entryItem">
                    <label langid="txn.review.enterPin" >Enter Pin :</label><br>
                    <input class ="textbox left "id="userPin" type ="password" name="userPin">
                    <button class="button left" type="submit" name="processBtn" id="processBtn" xt-bind="#click, processTrans">
                       <img src="views/images/loader.gif" alt="." class="hide" /><span langid="txn.btn.processAll" >Process All Transactions</span>
                    </button>
                </div>
                
            </div>
        </div>
    <br>
    <br>
    </form>
</div>

<div class="transBoxReview full" id="results" >
    <form name="frmTrans"method="post">
        <div class="transSectionReview" id="reviewSection" >
            <br>
            <h3 id="txnTitle" langid="txn.results.title">Transaction Results</h3>
            <table class="reviewTbl" cellspacing="0" >
                <thead  class="reviewTblHeader" >
                    <tr   >
                        <th langid="txn.review.status">Status</th>
                        <th langid="txn.review.account" colspan="2">Account</th>
                        <th langid="txn.review.type">Trans Type</th>
                        <th langid="txn.review.schedule">Schedule</th>
                        <th langid="txn.review.payee">Payee</th>
                        <th langid="txn.review.details">Details</th>
                        <th langid="txn.review.amount" colspan="2" >Amount</th>
                    </tr>
                </thead>
                <tbody  id="txnReviewList" xt-delegate=".deleteLink #click, txnDeleteEvent ; .editLink #click, txnEditEvent"  >
                    <tr class="reviewTblData {txnErrorDisplayClass}">
                        <td class="toggleTxnStatusTd " >
                            
                                                        <a data-txnRowId="{ROWCOUNT}" class="toggleTxnDetails"  >Details Results</a>
{txnProcessRequestId}

                        </td>

                        <td>{sourceAccount}</td>
                        <td><img src="views/images/flags/jmmbCurrencies/{sourceCurrency}.png" title="{sourceCurrency}" alt="{sourceCurrency}"></td>
                        <td><label class="regular" langid="txn.type.{transTypeSelected}">{transTypeSelected}</label></td>
                        <td>{txnSchedule}</td>
                        <td>{payeeName}</td>
                        <td>{txnDetails}</td>
                        <td ><div class="right"><b>{amountEntered}</b></div></td>
                        <td ><img src="views/images/flags/jmmbCurrencies/{amountCurrency}.png" title="{amountCurrency}" alt="{amountCurrency}"></td>
                    </tr>
                    <tr class="hide reviewTblDetails " id="txnDetails{ROWCOUNT}" >

                        <td class="detailsPre"  >
                            >
                        </td>
                        <td  class="details"  colspan="8">
                            <div class="message">
                                {txnProcessMessage}
                            </div>
                            <div class="">
                                {txnMoreDetails}
                                <br>
                            </div>
                        </td>

                    </tr>
                </tbody>
            </table>

        </div>
        <div class="naviSectionFinish">
            <div class="left naviLeft" >
                <div class="left entryItem">
                    <label > </label><br>
                    <button class="button " type="submit" name="newtBtn" id="newtBtn" xt-bind="#click, editFailedTrans">
                        <img src="views/images/loader.gif" alt="." class="hide" /><span langid="txn.new" >Edit Failed Transactions</span>
                    </button>
                </div>
            </div>
        </div>
    <br>
    <br>
    </form>
</div>

<div class="rightSide" id="txnSummaryBox">
    <div class="transSectionHeader"  >
        <label class="naviTitle regular" langid="txn.summary.title">Transaction Summary</label>
    </div>
    <div id="txnSummary" class="content"></div>
    <br>

</div>

<div id="noAccess">
    <span langid="txn.noAccess">You do not have access to this page</span>
</div>
