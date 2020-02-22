<?php defined('RAXANPDI') || die(); ?>

  <style type="text/css">



    .bold                               {font-weight: bold;}
    .ltm                                {margin-left: 10px;}
    .ltm15                                {margin-left: 15px;}
    .rtm                                {margin-right:10px;}
    .ttm                                {margin-top: 10px;}
    .btm                                {margin-bottom: 10px;}
    .hide                               {display: none;}
    .right                              {float:right;position: relative;}
    .left                               {float:left;position: relative;}
    .right-align                        {text-align: right;}
    .clear                              {clear:both;}
    .highlight-bg                       {background-color: #DFDFDF;border: 1px solid grey;padding-left: 5px;}
    .border-outline                     {border: 1px solid #ddd;}
    .bold-border-outline                {border: 1px solid #404040;;padding: 15px;}
    .show-on                            {color:#91A92E;padding-left:5px;}
    .show-off                           {color:#A60C13;padding-left:5px;}
    label                               {padding-left: 3px;}
    form label                          {display:inline-block;}
    form .textbox                       {width:auto;}
    .pmrequired                           {color:red; font-weight: bold;}
    .redcolor                           {color:red!important;}
    .yellowbg                           {background-color: #FFF6BF;}
    .dotted-border-bottom                   {border-bottom: 1px dotted grey;margin-bottom:30px;}
    .edit {}
    .disabledColor                           {color:grey;}


     .policy-row                        {height:170px;}
     .left-border                       {border-left: 1px solid #B8D152;}
     .policy-col                        {width:250px; padding-left: 5px; position: relative; vertical-align: top; display:inline-block;}

     .policy-col .policy-widget         { left:  5px;position: relative;}
     .new-payee-setup li ,
     .payee-setup-company-account li ,
     .payee-setup-jmmb-account li ,
     .payee-setup-cheque-encashment li ,
     .payee-setup-local-wire li , .payee-setup-international-wire li ,
     .payee-setup-select-account li { list-style-type: none;}
     .new-payee-setup ul ,
     .payee-setup-company-account ul ,
     .payee-setup-jmmb-account ul ,
     .payee-setup-cheque-encashment ul ,
     .payee-setup-local-wire ul , .payee-setup-international-wire ul,
     .payee-setup-select-account ul {margin: 0px; padding: 0px;}
     .new-payee-setup input[type="textbox"]     {width:500px;}
     .new-payee-setup form label, .payee-setup-company-account form label ,
     .payee-setup-jmmb-account form label , .payee-setup-cheque-encashment form label,
     .payee-setup-local-wire form label , .payee-setup-international-wire form label,
     .payee-setup-select-account form label {display:inline-block;float:none;width:auto}

    .user-notice{width: 200px;}
    .ui-section-heading{font-size: 120%;border-bottom: 1px solid #404040;width:100%;margin-bottom: 10px;color:#404040;}
    .rax-box.info {background-color: lightgrey;color:auto;}
    button{cursor: pointer;}
    .user-profile-preferences       { padding:10px;}


    .payee-setup-select-account li {margin-left: 50px; margin-top: 10px;}

    .payee-setup-company-account #shortName     {margin-left:58px;}
    .payee-setup-company-account #referenceNo   {margin-left:3px;}
    .payee-setup-company-account #caaccountAlias  {width:500px;margin-left:5px;}
    .payee-setup-company-account #capayeeName   {margin-left:5px;font-size:150%;}

    .payee-setup-jmmb-account #jmmbaccountAlias     {width:530px;margin-left:5px;}
    .payee-setup-jmmb-account #jmmbaccount      {width:400px;margin-left:5px;}
    .payee-setup-jmmb-account #jmmbpayeeName        {margin-left:5px;font-size:150%;}

    .payee-setup-cheque-encashment #chqencpayeeName   {margin-left:5px;font-size:150%;}
    .payee-setup-cheque-encashment #chqencaccountAlias {width:530px;margin-left:5px;}
    .payee-setup-cheque-encashment #chqencAddress1   {width:500px;margin-left:5px;}
    .payee-setup-cheque-encashment #chqencAddress2   {width:500px;margin-left:65px; margin-top: 10px;}
    .payee-setup-cheque-encashment #chqencAddress3   {margin-left:65px; margin-top: 10px;}
    .payee-setup-cheque-encashment #chqencCountry   {margin-left:200px}

    .payee-setup-local-wire #lwaccountAlias           {width:530px;margin-left:5px;}
    .payee-setup-local-wire #lwpayeeName               {margin-left:5px;font-size:150%;}
    .payee-setup-local-wire #lwaccountNo             {margin-left:2px;}
    .payee-setup-local-wire #selbankName             {margin-left:20px;}


    .payee-setup-international-wire  input[type=textbox] {margin-top: 5px;}
    .payee-setup-international-wire  #inwpayeeName      {margin-left:5px;font-size:150%;}
    .payee-setup-international-wire  #inwaccountAlias   {width:530px;margin-left:4px;}
    .payee-setup-international-wire  #selinwCurrency {width:100px;margin-left: 38px;}
    .payee-setup-international-wire  #inwPaymentDetails1 {width:515px;margin-left: 5px;}
    .payee-setup-international-wire  #inwPaymentDetails2 ,
    .payee-setup-international-wire  #inwPaymentDetails3 ,
    .payee-setup-international-wire  #inwPaymentDetails4 {width:515px;margin-left: 101px;}
    .payee-setup-international-wire  #inwAccountNo  {width:300px;margin-left: 32px;}
    .payee-setup-international-wire  #inwbdAddress1 {width:515px;margin-left: 40px;}
    .payee-setup-international-wire  #inwbdAddress2 {width:515px;margin-left: 100px;}
    .payee-setup-international-wire  #inwbdAddress3 {margin-left: 100px;}
     
    .payee-setup-international-wire  #selinwbbdRouting {margin-left: 40px; margin-right: 5px;}
    .payee-setup-international-wire  #inwbbdName {margin-left: 48px; width:518px;}
    .payee-setup-international-wire  #inwbbdAddress1  {margin-left: 36px; width:518px;}
    .payee-setup-international-wire  #inwbbdAddress2 {width:520px;margin-left: 95px;}
    .payee-setup-international-wire  #inwbbdAddress3 {margin-left: 95px;}
    .payee-setup-international-wire  #inwbbdAddress4 {margin-left: 95px;width:142px}
    .payee-setup-international-wire  #selinwidRouting  {margin-left: 45px; margin-right: 5px;}
    .payee-setup-international-wire  #inwibName {margin-left: 54px;width:520px}
    .payee-setup-international-wire  #inwibaddress1 {margin-left: 42px;width:520px}
    .payee-setup-international-wire  #inwibaddress2 {width:520px;margin-left: 95px;}
    .payee-setup-international-wire  #inwibaddress3 {margin-left: 95px;}
    .payee-setup-international-wire  #ibCountry        {margin-left: 240px;}
     
    
    .payee-setup-international-wire  #bbdRoutingMethod ,
    .payee-setup-international-wire  #ibRoutingMethod  {margin-left: 92px;}
    .payee-setup-international-wire  #bbdRoutingNumber ,
    .payee-setup-international-wire  #ibRoutingNumber  {margin-left: 160px;}
    .payee-setup-international-wire  #bbdCountry        {margin-left: 240px;}


    form#webupsecurityVerification label {width:auto;}

  </style>

  <!--[if ! IE]><!-->
<style type="text/css">


    .right-panel{margin: 0px;}
    .user-profile-security-verification, .user-payee-maintenance, .new-payee-setup,
    .payee-setup-company-account, .payee-setup-jmmb-account,
    .payee-setup-cheque-encashment, .payee-setup-local-wire,
    .payee-setup-international-wire, .payee-setup-select-account   {width: 663px; position: relative;}



</style>

<script type="text/javascript">
        var icons = {
			header: "ui-icon-circle-plus",
			headerSelected: "ui-icon-circle-minus"
		};
        function showOverview()
       {
            window.location.href = "app/payee/index.php";
       }

    Raxan.ready(function() {

                        
		$( "#payeeList" ).accordion({
                    icons: icons
                });
                
                $("#shortName, #referenceNo").bind("keyup",function(){
                    setChqDes();
                });

                $("#selPayeeCompany").change(function(){
                    if( $("input[name='rdPayeeInfo']:checked").val() != "1" )
                        $("input[name='rdPayeeInfo'][value='1']").attr("checked","checked");
                    $("#capayeeName").each(function(index){
                        $(this).html($("#selPayeeCompany option:selected").text());
                        
                    });

                    $(".aclisting").addClass("hide");
                     //alert($("input[name='rdPayeeInfo']:checked").val());
                });

                $("#rdPayeeInfo").bind("click", function(){
                    //alert($(this).val());
                    if($(this).val() == "0")
                        {
                            $(".aclisting").removeClass("hide");
                            $("#selPayeeCompany").val("-1");
                           
                        }else
                            {
                              $(".aclisting").addClass(" hide ");
                            }
                });

                $("#newpayeesetupSavebtn").bind("togglecontent", function(event,mode){
                    if(mode == "on")
                        {
                            var msg;
                            //alert($("input[name=rdPayeeInfo]:radio").val());
                            if(parseInt($("input[name=rdPayeeInfo]:radio:checked").val()) == 0)
                            {
                                //alert("dfsdf");
                                if($("#payeename").val() == "")
                                    {
                                        msg = "Payee name is missing.";
                                        $("#payeename").focus();

                                    }else
                               if($("#payeedescription").val() == "")
                                    {
                                        msg = "Payee description is missing.";
                                        $("#payeedescription").focus();

                                    }
                            }else
                            {
                                if($("#selPayeeCompany").val() == "-1")
                                    {
                                        msg = "Select an approved company";
                                        $("#selPayeeCompany").focus();

                                    }

                            }

                            if(! $("#chkPaymentDetails").attr("checked"))
                                {
                                    msg = "You are require to select add or modify payee information before saving";
                                    $("#selPayeeCompany").focus();

                                }

                                if($("input[name=rdAddNewAcInfo]:radio:checked").val() !="0" &&
                                            $("#hidpayeeid").val()=="")
                                    {
                                        msg="You are required to select add account information";
                                        $("input[name=rdAddNewAcInfo]:radio").focus();
                                    }

                                if (!msg) {
                                $('#newpayeesetupSavebtn').blur();
                                $('#newpayeesetupSavebtn img').show();

                                }
                                else {
                                    showErrorMessage(msg);
                                    event.preventDefault();
                                    event.stopImmediatePropagation();
                                    return false;
                                }
//                            event.preventDefault();
//                            event.stopImmediatePropagation();
//                            return false;

                        }else
                            {

                                $('#newpayeesetupSavebtn').show();
                                $('#newpayeesetupSavebtn img').hide();

                            }

                })

                $("#selbankName").bind("togglecontent", function(e,mode){
                    if(mode=="on")
                        {

                        }else
                        {
                         
                           $("#selbankBranch").html(e.serverResult);
                           //alert(e.serverResult);
                        }

                });

                $("#selbankName").change(function(){

                     Raxan.dispatchEvent("show-bank-branches",$(this).val(), function(result, success){

                            if(!success) return false;

                            $("#selbankBranch").html(result);

                        })
                })


        $('#payeesetupcmpacFinishbtn, #payeesetupcmpacNextbtn').bind('togglecontent', function(event,mode)
        {
            if (mode=='on') {
                var  msg, refno = $('#referenceNo');

                if ($.trim(refno.val())=="")	{
                    msg = "The company account/reference number is missing.";//Raxan.getVar('missing-reference-no');
                    refno.focus();
                }

                if (!msg) {
                    $('#payeesetupcmpacFinishbtn, #payeesetupcmpacNextbtn').blur();
                    $('#payeesetupcmpacFinishbtn img, #payeesetupcmpacNextbtn img').show();

                }
                else {
                    showErrorMessage(msg);
                    event.preventDefault();
                    event.stopImmediatePropagation();
                    return false;
                }


            }else
            {
                $('#payeesetupcmpacFinishbtn, #payeesetupcmpacNextbtn').show();
                $('#payeesetupcmpacFinishbtn img, #payeesetupcmpacNextbtn img').hide();
               
                clearValues();


            }

        })/// company account





            $('#payeesetupjmmbacFinishbtn, #payeesetupjmmbacNextbtn').bind('togglecontent', function(event,mode)
            {
                if (mode=='on') {
                    var  msg, accno = $('#jmmbaccount'), currency=$("#seljmmbacCurrency");

                    if ($.trim(accno.val())=="")	{
                        msg = "The JMMB account number is missing.";//Raxan.getVar('missing-reference-no');
                        accno.focus();
                    }else
                    if ($.trim(currency.val())=="")	{
                        msg = "The JMMB account currency is missing.";//Raxan.getVar('missing-reference-no');
                        accno.focus();
                    }

                    if (!msg) {
                        $('#payeesetupjmmbacFinishbtn, #payeesetupjmmbacNextbtn').blur();
                        $('#payeesetupjmmbacNextbtn img, #payeesetupjmmbacNextbtn img').show();

                    }
                    else {
                        showErrorMessage(msg);
                        event.preventDefault();
                        event.stopImmediatePropagation();
                        return false;
                    }


                }else
                {
                    $('#payeesetupjmmbacFinishbtn, #payeesetupjmmbacNextbtn').show();
                    $('#payeesetupjmmbacFinishbtn img, #payeesetupjmmbacNextbtn img').hide();

                    clearValues();


                }

            })/// JMMB Account



            $('#payeesetupchqencFinishbtn, #payeesetupchqencNextbtn').bind('togglecontent', function(event,mode)
            {
                if (mode=='on') {
                    var  msg, address = $('#chqencAddress1');

                    if ($.trim(address.val())=="")	{
                        msg = "The delivery address is missing.";//Raxan.getVar('missing-reference-no');
                        address.focus();
                    }

                    if (!msg) {
                        $('#payeesetupchqencFinishbtn, #payeesetupchqencNextbtn').blur();
                        $('#payeesetupchqencNextbtn img, #payeesetupchqencNextbtn img').show();

                    }
                    else {
                        showErrorMessage(msg);
                        event.preventDefault();
                        event.stopImmediatePropagation();
                        return false;
                    }


                }else
                {
                    $('#payeesetupchqencFinishbtn, #payeesetupchqencNextbtn').show();
                    $('#payeesetupchqencFinishbtn img, #payeesetupchqencNextbtn img').hide();

                    clearValues();


                }

            })/// Cheque Encashment Delivery Details



            $('#payeesetuplwFinishbtn, #payeesetuplwNextbtn').bind('togglecontent', function(event,mode)
            {
                if (mode=='on') {
                    var  msg, bankname = $('#selbankName'), bankbranch = $("#selbankBranch"),
                    accountno = $("#lwaccountNo"), currency = $("#sellwCurrency"),
                    accounttype = $("#sellwAccountType");

                    if ($.trim(bankname.val())=="")	{
                        msg = "Select a bank for the account details information.";//Raxan.getVar('missing-reference-no');
                        bankname.focus();
                    }else
                    if ($.trim(bankbranch.val())=="")	{
                        msg = "Select a bank branch";//Raxan.getVar('missing-reference-no');
                        bankbranch.focus();
                    }else
                    if ($.trim(accountno.val())=="")	{
                        msg = "Account number is missing.";//Raxan.getVar('missing-reference-no');
                        accountno.focus();
                    }else
                    if ($.trim(currency.val())=="")	{
                        msg = "Select the account currency.";//Raxan.getVar('missing-reference-no');
                        currency.focus();
                    }else
                    if ($.trim(accounttype.val())=="")	{
                        msg = "Select the type of account.";//Raxan.getVar('missing-reference-no');
                        accounttype.focus();
                    }

                    if (!msg) {
                        $('#payeesetuplwFinishbtn, #payeesetuplwNextbtn').blur();
                        $('#payeesetuplwNextbtn img, #payeesetuplwNextbtn img').show();

                    }
                    else {
                        showErrorMessage(msg);
                        event.preventDefault();
                        event.stopImmediatePropagation();
                        return false;
                    }


                }else
                {
                    $('#payeesetuplwFinishbtn, #payeesetuplwNextbtn').show();
                    $('#payeesetuplwFinishbtn img, #payeesetuplwNextbtn img').hide();

                    clearValues();


                }

            })/// Local Wire


            $('#payeesetupinwFinishbtn, #payeesetupinwNextbtn').bind('togglecontent', function(event,mode)
            {
                if (mode=='on') {
                    var  msg, address = $('#inwbdAddress1'), routingmethod = $("#selinwbbdRouting"),
                    accountno = $("#inwAccountNo"), currency = $("#selinwCurrency"),
                    routingno = $("#nwRouting"), benname = $("#inwbbdName"),
                    benaddress = $("#inwbbdAddress1");

                    if ($.trim(currency.val())=="")	{
                        msg = "Select the payment currency.";//Raxan.getVar('missing-reference-no');
                        currency.focus();
                    }else
                    if ($.trim(accountno.val())=="")	{
                        msg = "Beneficiary account number is missing.";//Raxan.getVar('missing-reference-no');
                        accountno.focus();
                    }else
                    if ($.trim(address.val())=="")	{
                        msg = "The beneficiary address is missing.";//Raxan.getVar('missing-reference-no');
                        address.focus();
                    }else
                    
                    if ($.trim(routingmethod.val())=="")	{
                        msg = "Select the beneficiary bank routing method";//Raxan.getVar('missing-reference-no');
                        routingmethod.focus();
                    }else
                    if ($.trim(routingno.val())=="")	{
                        msg = "The beneficiary bank routing number is missing.";//Raxan.getVar('missing-reference-no');
                        routingno.focus();
                    }else
                    if ($.trim(benname.val())=="")	{
                        msg = "The benficiary bank name is missing .";//Raxan.getVar('missing-reference-no');
                        benname.focus();
                    }else
                    if ($.trim(benaddress.val())=="")	{
                        msg = "The beneficiary bank address is missing.";//Raxan.getVar('missing-reference-no');
                        routingno.focus();
                    }
                    

                    if (!msg) {
                        $('#payeesetupinwFinishbtn, #payeesetupinwNextbtn').blur();
                        $('#payeesetupinwNextbtn img, #payeesetupinwNextbtn img').show();

                    }
                    else {
                        showErrorMessage(msg);
                        event.preventDefault();
                        event.stopImmediatePropagation();
                        return false;
                    }


                }else
                {
                    $('#payeesetupinwFinishbtn, #payeesetupinwNextbtn').show();
                    $('#payeesetuplnwFinishbtn img, #payeesetupinwNextbtn img').hide();

                    clearValues();


                }

            });/// International  Wire


           $("a.editpayee").bind("click",function(){
                Raxan.dispatchEvent("edit-payee",$(this).attr("data-event-value"), function(result, success){
                    if(!success) return false;
                    //showPayeeDetails(result);
                    if(result)
                    {
                        clearValues();
                        $("#payeesetuptitle").html("Payee Setup");
                        $("#hidpayeeid").val(result.id);
                        if(!result.approvedCompanyNo)
                            {
                                $("#payeename").val(result.name);
                                $("#payeedescription").val(result.description);
                                $("input[name=rdPayeeInfo][value=0]").attr("checked","checked");
                                $(".aclisting").removeClass("hide");
                                Raxan.dispatchEvent("show-payee-details",result.id, function(result, success){
                                    if(!success) return false;

                                    $("#selAccountInfo").html(result);

                                })
                            }else
                                {
                                  $("#selPayeeCompany").val(result.approvedCompanyNo);
                                  $("input[name=rdPayeeInfo][value=1]").attr("checked","checked");
                                  $(".aclisting").addClass("hide");
                                }

                          showSection("new-payee-setup",true);
                    }
                })

           });

           $(".chkpayee").bind("click", function(){
              var pid = $(this).attr("data-event-value"),
              ischecked = $(this).attr("checked");
              $("input[type=checkbox]").each(function(index){
               if($(this).attr("data-event-value"))
               {
                   var keys = $(this).attr("data-event-value").split("_");
                   if(keys.length == 2 && keys[0]== pid)
                   {
                       $(this).attr("checked", ischecked);
                   }

               }
              });
           });



       $(".chkpayeedetails").bind("click", function(){
            var keys = $(this).attr("data-event-value").split("_");
               if(keys.length == 2 )
               {
                    $(".chkpayee").each(function(index){
                        
                        if(keys[0] == $(this).attr("data-event-value")&&
                            $(this).attr("checked") == true
                            )
                        {
                            $(this).attr("checked","");
                            return;

                        }
                    })

               }

            });


            $("#deletepayee").bind('click', function(){

                    var deleteItems = "";

                    $(":checkbox:checked").each( function(index){
                        if($(this).attr("data-event-value"))
                            deleteItems +=$(this).attr("data-event-value")+"|";
                    });

                   if(deleteItems != "")
                   {
                       Raxan.dispatchEvent("delete-payee",deleteItems, function(result, success){
                            if(!success) return false;
                            //showPayeeDetails(result);
                        });
                   }

            });


            $("#payeesetupselacNextbtn").bind("click", function(){
                //alert($("input[name=rdpaydetails]:radio:checked").val());
            })



        })

        function setChqDes()
        {
            if($.trim($("#referenceNo").val())=="")
                desc = $("#shortName").val();
            else
                desc = $("#shortName").val()+" #"+$("#referenceNo").val();
            $("#chequedes").html(desc);
        }

    // Show Section
    function showSection(id,forward) {
        var lastId,elm,ani


        lastId = this.uplastId ? this.uplastId : 'user-payee-maintenance';
        elm = $('.'+lastId);

        forward = forward ? true: false;
        ani = (!forward) ? {'left':'-400px'} : {'left':'+400px'};
        elm.animate(ani,{
        duration:'slow',
        complete: function(){
            var tar = $('.'+id);
            elm.hide();
            if (tar.css('left')!='0')
                tar.css({'left':'0'});
            tar.fadeIn();

        }
        });


        this.uplastId = id;

    }


    function clearValues()
    {

            $("#chqencpayeeName").html("");
            $("#chqencaccountAlias").val("");
            $("#chqencAddress1").val("");
            $("#chqencAddress2").val("");
            $("#chqencAddress3").val("");
            $("#selchqencCountry").val("");
            $("#capayeeName").html("");
            $("#caaccountAlias").val("");
            $("#shortName").val("");
            $("#referenceNo").val("");
            $("#chequedes").html(  "" );

            $("#jmmbpayeeName").html("");
            $("#jmmbaccountAlias").val("");
            $("#jmmbaccount").val("");
            $("#seljmmbacCurrency").val("");


            $("#lwpayeeName").html("");
            $("#lwaccountAlias").val("");
            $("#selbankName").val("");
            $("#selbankBranch").html("");
            $("#selbankBranch").val("");

            $("#lwaccountNo").val("");
            $("#sellwCurrency").val("");
            $("#sellwAccountType").val("");


            $("#inwpayeeName").html("");
            $("#inwaccountAlias").val("");
            $("#selinwCurrency").val("");
            $("#inwPaymentDetails1").val("");
            $("#inwPaymentDetails2").val("");
            $("#inwPaymentDetails3").val("");
            $("#inwPaymentDetails4").val("");

            $("#inwAccountNo").val("");
            $("#inwbdAddress1").val("");
            $("#inwbdAddress2").val("");
            $("#inwbdAddress3").val("");
            $("#selinwbdCountry").val("");

            $("#selinwidRouting").val("");
            $("#inwibRouting").val("");
            $("#inwibName").val("");
            $("#inwbbdAddress1").val("");
            $("#inwbbdAddress2").val("");
            $("#inwbbdAddress3").val("");
            $("#selinwbbdCountry").val("");

            $("#selinwidRouting").val("");
            $("#inwibRouting").val("");
            $("#inwibName").val("");
            $("#inwibaddress1").val("");
            $("#inwibaddress2").val("");
            $("#inwibaddress3").val("");
            $("#selinwbbdCountry").val("");

            $("#payeename").val("");
            $("#payeedescription").val("");
            $("#selPayeeCompany").val("-1");
            $("#payeeInfo").val("");
            $("#chkPaymentDetails").attr("checked","");



    }

    function buildPayeeDetailsList(payeeid, detailsList)
    {
        var payeename = "#payee"+payeeid;
        $(payeename).html(detailsList);
        $("a.edit").click(function(){
            Raxan.dispatchEvent("edit-payee-details",$(this).attr("data-event-value"), function(result, success){
                if(!success) return false;
                showPayeeDetails(result);
            })
        })

       

    }


    function showPayeeDetails(payeeDetail)
    {
        switch(payeeDetail.tranTypeCode)
        {
            case "ENC":
                showENCPayeeDetails(payeeDetail);

                break;
            case "INT":
                showINTPayeeDetails(payeeDetail);
                showSection("payee-setup-jmmb-account",true);
                break;
            case "LWR":
                showLWRPayeeDetails(payeeDetail);
                showSection("payee-setup-local-wire",true);
                break;
            case "IWR":
                showIWRPayeeDetails(payeeDetail);
                showSection("payee-setup-international-wire",true);
                break;

        }

    }



    function showENCPayeeDetails(payeeDetail)
    {
        try
        {
            if(! payeeDetail.approvedCompany)
            {
                $("#chqencpayeeName").html(payeeDetail.payeeName);
                $("#chqencaccountAlias").val(payeeDetail.alias);
                $("#chqencAddress1").val(payeeDetail.accountDetails.address.line1);
                $("#chqencAddress2").val(payeeDetail.accountDetails.address.line2);
                $("#chqencAddress3").val(payeeDetail.accountDetails.address.line3);
                $("#selchqencCountry").val(payeeDetail.accountDetails.address.countryCode);
                showSection("payee-setup-cheque-encashment",true);
            }else{
                $("#capayeeName").html(payeeDetail.payeeName);
                $("#caaccountAlias").val(payeeDetail.alias);
                $("#shortName").val(payeeDetail.accountDetails.shortName);
                $("#referenceNo").val(payeeDetail.accountDetails.accountRef.value);
                $("#chequedes").html(payeeDetail.accountDetails.shortName+" #"+payeeDetail.accountDetails.accountRef.value);
                showSection("payee-setup-company-account",true);
            }
        }catch(e)
        {
            alert(e);
        }


    }


    function showINTPayeeDetails(payeeDetail)
    {
        try
        {
            $("#jmmbpayeeName").html(payeeDetail.payeeName);
            $("#jmmbaccountAlias").val(payeeDetail.alias);
            $("#jmmbaccount").val(payeeDetail.accountDetails.accountRef.value);
            $("#seljmmbacCurrency").val(payeeDetail.accountDetails.accountRef.currency);
        }catch(e)
        {
            alert(e);
        }


    }

    function showLWRPayeeDetails(payeeDetail)
    {
        try
        {
            $("#lwpayeeName").html(payeeDetail.payeeName);
            $("#lwaccountAlias").val(payeeDetail.alias);
            $("#selbankName").val(payeeDetail.bankCode);
           
           var bankBranchCode = payeeDetail.accountDetails.benBank.vrouting.code+"_"+payeeDetail.accountDetails.benBank.vrouting.number;

             Raxan.dispatchEvent("show-bank-branches",payeeDetail.bankCode, function(result, success){

                    if(!success) return false;
                    $("#selbankBranch").html(result);
                    $("#selbankBranch").val(bankBranchCode);
                    
                })
            $("#lwaccountNo").val(payeeDetail.accountDetails.accountRef.value);
            $("#sellwCurrency").val(payeeDetail.accountDetails.accountRef.currency);
            $("#sellwAccountType").val(payeeDetail.accountDetails.accountRef.type);
            
        }catch( e)
        {
                alert(e);
        }
    }



    function showIWRPayeeDetails(payeeDetail)
    {
        try {

            $("#inwpayeeName").html(payeeDetail.payeeName);
            $("#inwaccountAlias").val(payeeDetail.alias);
            $("#selinwCurrency").val(payeeDetail.accountDetails.accountRef.currency);
            $("#inwPaymentDetails1").val(payeeDetail.accountDetails.details.line1);
            $("#inwPaymentDetails2").val(payeeDetail.accountDetails.details.line2);
            $("#inwPaymentDetails3").val(payeeDetail.accountDetails.details.line3);
            $("#inwPaymentDetails4").val(payeeDetail.accountDetails.details.line4);

            $("#inwAccountNo").val(payeeDetail.accountDetails.accountRef.value);
            $("#inwbdAddress1").val(payeeDetail.accountDetails.address.line1);
            $("#inwbdAddress2").val(payeeDetail.accountDetails.address.line2);
            $("#inwbdAddress3").val(payeeDetail.accountDetails.address.line3);
            $("#selinwbdCountry").val(payeeDetail.accountDetails.address.countryCode);

            $("#selinwidRouting").val(payeeDetail.accountDetails.benBank.vrouting.code);
            $("#inwibRouting").val(payeeDetail.accountDetails.benBank.vrouting.number);
            $("#inwibName").val(payeeDetail.accountDetails.benBank.name);
            $("#inwbbdAddress1").val(payeeDetail.accountDetails.benBank.address.line1);
            $("#inwbbdAddress2").val(payeeDetail.accountDetails.benBank.address.line2);
            $("#inwbbdAddress3").val(payeeDetail.accountDetails.benBank.address.line3);
            $("#selinwbbdCountry").val(payeeDetail.accountDetails.benBank.address.countryCode);

            if(payeeDetail.interBank)
            {
                $("#selinwidRouting").val(payeeDetail.accountDetails.interBank.vrouting.code);
                $("#inwibRouting").val(payeeDetail.accountDetails.interBank.vrouting.number);
                $("#inwibName").val(payeeDetail.accountDetails.interBank.name);
                $("#inwibaddress1").val(payeeDetail.accountDetails.interBank.address.line1);
                $("#inwibaddress2").val(payeeDetail.accountDetails.interBank.address.line2);
                $("#inwibaddress3").val(payeeDetail.accountDetails.interBank.address.line3);
                $("#selinwbbdCountry").val(payeeDetail.accountDetails.interBank.address.countryCode);

            }
        }catch(e)
        {
            alert(e);
        }



    }



 </script>
<!--<![endif]-->

<h3 langid="payee.heading">Payee Maintenance</h3><hr>
<div class="user-payee-maintenance round bold-border-outline" id="payeelisting">
<h2  class="ui-section-heading bold" langid="payee.listing.title">Payee Listing</h2>
    <div>
        <div id="errorList"></div>
         
        <div id="payeeList">
           <h3 class=""><a href="#">{name}</a></h3>
            <div class="clear">
                <div class="policy-col left" style="width:500px;">
                    <p>{description}</p>
                    <input type="hidden" name="{id}" value="{id}"/>
               </div>
               <div class="policy-col right" style="width:80px; text-align: right;">
                   <a data-event-value ="{id}" class="editpayee redcolor bold" >edit</a> <input type="checkbox" data-event-value ="{id}" class="chkpayee">
               </div>
                <hr>
                <div class="clear ttm "  name="payee{id}" >

                   
                    <p>
                    Mauris mauris ante, blandit et, ultrices a, suscipit eget, quam. Integer
                    ut neque. Vivamus nisi metus, molestie vel, gravida in, condimentum sit
                    amet, nunc. Nam a nibh. Donec suscipit eros. Nam mi. Proin viverra leo ut
                    odio. Curabitur malesuada. Vestibulum a velit eu ante scelerisque vulputate.
                    </p>
                </div>
            </div>
        </div>
        <hr>

        <div style="margin-top:5px; margin-right: 10px" align="right">
            <input langid="payee.listing.add"type="submit" name="addpayee" id="addpayee"  class="button process" xt-bind="#click, addNewPayee" value="Add Payee"/>
            &nbsp;
            <input langid="payee.listing.delete" type="submit" name="deletepayee" id="deletepayee" class="button" value="Delete Selected Payees" xt-bind="#click, deletePayee"/>
            &nbsp;
        </div>
    </div>
</div>

<div class="new-payee-setup round bold-border-outline hide ">
    <div id="newpayeesetup" class="">
        <h2  class="ui-section-heading bold" name="payeesetuptitle" id="payeesetuptitle" langid="new.payee.setup">New Payee Setup</h2>
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
                <li class="ttm"><input id="rdPayeeInfo" name="rdPayeeInfo" type="radio" value="1"/><label langid="new.payee.setup.payee.companies">Select Payee from pre-define list of Companies:</label><br>
                    <select id="selPayeeCompany" name="selPayeeCompany" class="ltm15 ttm"><option value="{AppCompanyNo}">{AppCompanyName}</option></select>
                </li>

            </ul>
             </div>
            <hr class="clear ttm" />
            <div><span langid="new.payee.setup.payment.details.title"  class="bold redcolor " >Add/Modify Payment Details</span></div>
            <div  class="highlight-bg  ttm clear round" >
                <div class="ttm bmm">
                    <ul>
                        <li><input id="chkPaymentDetails" name="chkPaymentDetails" type="checkbox"/><label langid="new.payee.setup.payee.account">I would like to Add or Modify Payee Account Information</label></li>
                        <li class="ttm"><span class="ltm15" id="" name=""><input id="rdAddNewAcInfo" name="rdAddNewAcInfo" type="radio" value="0"/><label langid="new.payee.setup.new.account.info">Add New Account Information</label></span></li>
                        <li class="ttm aclisting"><span class="ltm15" id="" name=""><input id="rdAddNewAcInfo" name="rdAddNewAcInfo" type="radio" value="1"/><label langid="new.payee.setup.new.account.info">Modify Existing Account Information</label><select id="selAccountInfo" name="selAccountInfo"><option value=""></option></select></span></li>
                    </ul>

                </div>
            </div>
            <hr class="clear ttm" />
            <div class="buttonbar" style="height:40px;" >
                <button class="button default right tpm btm rtm" type="submit" name="newpayeesetupSavebtn" id="newpayeesetupSavebtn" xt-bind="#click,saveNewPayeeSetup,#webnewpayeesetup, #webnewpayeesetup .ctrl" >
                    <img src="views/images/loader.gif" alt="." class="hide" style="margin-right:5px;"/><span langid="new.payee.setup.button.next" style="vertical-align:middle">&nbsp;Next&nbsp;</span>
                </button>
                <button  class="ctrl button  left tpm btm rtm" type="submit" name="newpayeesetupCancelbtn" id="newpayeesetupCancelbtn" xt-bind="#click" langid="new.payee.setup.button.cancel" >Cancel</button>
            </div>
        </form>
    </div>

</div>





<div class="payee-setup-company-account round bold-border-outline hide ">
    <div id="newpayeesetup" class="">
        <h2  class="ui-section-heading bold" langid="payee.setup.company.account.title">Payee Setup - Company Account</h2>
        
        <form class="" name="webpayeesetupcmpac" id="webpayeesetupcmpac" action="" method="post">
            <div>
                 <ul>
                     <li><label langid="payee.name">Payee Name:</label><span id="capayeeName" name="capayeeName">Jamaica Public Service Ltd.</span><br>
                        <label langid="payee.setup.comapny.account.account.alias">Account Alias:</label><input type="textbox" name="caaccountAlias" id="caaccountAlias" class=" " /><br/>
                    </li>
                </ul>
             </div>
            <hr class="clear ttm" />
            <div><span langid="payee.setup.company.account.details.title"  class="bold redcolor " >Company Account Details</span></div>
            <div  class="  ttm clear " >
                <div class="policy-col left ttm bmm" style="width:300px;">
                    <ul>
                        <li><label langid="payee.setup.company.account.short.name">Short Name:</label><input id="shortName" name="shortName" type="textbox"/></li>
                        <li class="ttm"><label langid="payee.setup.company.account.account.reference">Account/Reference #:</label><label  class="pmrequired">*</label><input class="" id="referenceNo" name="referenceNo" type="textbox"/></li>
                        <li class="ttm"><label langid="payee.setup.company.account.cheque.description">Cheque Description:</label><span id="chequedes" name="chequedes" class="bold ltm "></span></li>
                    </ul>

                </div>
                <div class="policy-col right" style="width:300px;">
                    <div  class="highlight-bg   round" >
                        <span langid="payee.setup.company.account.description">
                           Enter a short name for the company to be printed on the cheque. This can be the company's abrreviation, etc.<br>
                        Enter the reference or account number
                        </span>
                    </div>
                </div>
            </div>
            <hr class="clear ttm" />
            <div class="buttonbar clear" style="height:40px;" >
                <button class="button default right tpm btm rtm" type="submit" name="payeesetupcmpacNextbtn" id="payeesetupcmpacNextbtn" xt-bind="#click,savePayeeDetail,#webpayeesetupcmpac, #webpayeesetupcmpac .ctrl" >
                    <img src="views/images/loader.gif" alt="." class="hide" style="margin-right:5px;"/><span langid="new.payee.setup.button.next" style="vertical-align:middle">&nbsp;Next&nbsp;</span>
                </button>
                <button class="button default right tpm btm rtm" type="submit" name="payeesetupcmpacFinishbtn" id="payeesetupcmpacFinishbtn" xt-bind="#click,savePayeeDetail,#webpayeesetupcmpac, #webpayeesetupcmpac .ctrl" >
                    <img src="views/images/loader.gif" alt="." class="hide" style="margin-right:5px;"/><span langid="new.payee.setup.button.finish" style="vertical-align:middle">&nbsp;Finish&nbsp;</span>
                </button>
                <button class="button default right tpm btm rtm" type="submit" name="payeesetupcmpacPreviousbtn" id="payeesetupcmpacPreviousbtn" xt-bind="#click,savePayeeDetail,#webpayeesetupcmpac, #webpayeesetupcmpac .ctrl" >
                    <img src="views/images/loader.gif" alt="." class="hide" style="margin-right:5px;"/><span langid="new.payee.setup.button.previous" style="vertical-align:middle">&nbsp;Previous&nbsp;</span>
                </button>
                <button  class="ctrl button  left tpm btm rtm" type="submit" name="payeesetupcmpacCancelbtn" id="payeesetupcmpacCancelbtn" xt-bind="#click" langid="new.payee.setup.button.cancel" >&nbsp;Cancel&nbsp;</button>
            </div>
        </form>
    </div>

</div>




<div class="payee-setup-jmmb-account round bold-border-outline hide">
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




<div class="payee-setup-select-account round bold-border-outline hide ">
    <div id="payeesetupselaccount" class="">
        <h2  class="ui-section-heading bold" langid="payee.setup.jmmb.account.title">Payee Setup - Payment Details</h2>

        <form class="" name="webpayeesetupselac" id="webpayeesetupselac" action="" method="post">
            <div>
                 <ul>
                     <li><label langid="payee.name">Payee Name:</label><span id="" name="">The name of the payee being setup</span><br>
                        
                    </li>

                    <li><input type="radio" id="rdpaydetails"  name="rdpaydetails" value="0"/><label>Cheque Encashment Delivery Details</label></li>
                    <li><input type="radio" id="rdpaydetails"  name="rdpaydetails" value="1"/><label>Set up details  to send funds to a JMMB Account (other than mine)</label></li>
                    <li><input type="radio" id="rdpaydetails"  name="rdpaydetails" value="2"/><label  id="lbllwt" name="lbllwt">Set up details to send funds to a Local Bank Account</label></li>
                    <li><input type="radio" id="rdpaydetails"  name="rdpaydetails" value="3"/><label id="lbliwt" name="lbliwt">Set up details to send funds to an International Bank Account</label></li>
                </ul>
             </div>

            <hr class="clear ttm" />
            <div class="buttonbar clear" style="height:40px;" >
                <button class="button default right tpm btm rtm" type="submit" name="payeesetupselacNextbtn" id="payeesetupselacNextbtn" xt-bind="#click " >
                    <img src="views/images/loader.gif" alt="." class="hide" style="margin-right:5px;"/><span langid="new.payee.setup.button.next" style="vertical-align:middle">&nbsp;Next&nbsp;</span>
                </button>
                <button class="button default right tpm btm rtm hide" type="submit" name="payeesetupselacFinishbtn" id="payeesetupselacFinishbtn" xt-bind="#click,savePayeeDetail,#webpayeesetupjmmbac, #webpayeesetupjmmbac .ctrl" >
                    <img src="views/images/loader.gif" alt="." class="hide" style="margin-right:5px;"/><span langid="new.payee.setup.button.finish" style="vertical-align:middle">&nbsp;Finish&nbsp;</span>
                </button>
                <button class="button default right tpm btm rtm" type="submit" name="payeesetupselacPreviousbtn" id="payeesetupselacPreviousbtn" xt-bind="#click" >
                    <img src="views/images/loader.gif" alt="." class="hide" style="margin-right:5px;"/><span langid="new.payee.setup.button.previous" style="vertical-align:middle">&nbsp;Previous&nbsp;</span>
                </button>
                <button  class="ctrl button  left tpm btm rtm" type="submit" name="payeesetupselacCancelbtn" id="payeesetupselacCancelbtn" xt-bind="#click" langid="new.payee.setup.button.cancel" >&nbsp;Cancel&nbsp;</button>
            </div>
        </form>
    </div>

</div>






<div class="payee-setup-cheque-encashment round bold-border-outline hide ">
    <div id="payeesetupchqencashment" class="">
        <h2  class="ui-section-heading bold" langid="payee.setup.cheque.encashment.title">Payee Setup - Cheque Encashment Delivery Details</h2>

        <form class="" name="webpayeesetupchqencashment" id="webpayeesetupchqencashment" action="" method="post">
            <div>
                 <ul>
                     <li><label langid="payee.name">Payee Name:</label><span id="chqencpayeeName" name="chqencpayeeName">Mary P. Jane</span><br>
                        <label langid="payee.setup.jmmb.cheque.encashment.alias">Account Alias:</label><input type="textbox" name="chqencaccountAlias" id="chqencaccountAlias" class=" " /><br/>
                    </li>
                </ul>
             </div>
            <hr class="clear ttm" />
            <div><span langid="payee.setup.cheque.encashment.details.title"  class="bold" style="color:red;">Delivery Address</span></div>
            <div  class="  ttm clear " >
                <ul>
                    <li><label langid="payee.setup.cheque.encashment.address">Address:</label><label  class="pmrequired">*</label><input id="chqencAddress1" name="chqencAddress1" type="textbox"/><br>
                        <input id="chqencAddress2" name="chqencAddress2" type="textbox"/><br>
                        <input id="chqencAddress3" name="chqencAddress3" type="textbox"/><select id="selchqencCountry" name="selchqencCountry"><option value="{code}">{name}</option></select></li>
                        <label langid="payee.setup.international.chqenc.country" id="chqencCountry" name="chqencCountry">Country</label>
                </ul>
            </div>
            <hr class="clear ttm" />
            <div class="buttonbar clear" style="height:40px;" >
                <button class="button default right tpm btm rtm" type="submit" name="payeesetupchqencNextbtn" id="payeesetupchqencNextbtn" xt-bind="#click,savePayeeDetail,#webpayeesetupchqencashment, #webpayeesetupchqencashment .ctrl" >
                    <img src="views/images/loader.gif" alt="." class="hide" style="margin-right:5px;"/><span langid="new.payee.setup.button.next" style="vertical-align:middle">&nbsp;Next&nbsp;</span>
                </button>
                <button class="button default right tpm btm rtm" type="submit" name="payeesetupchqencFinishbtn" id="payeesetupchqencFinishbtn" xt-bind="#click,savePayeeDetail,#webpayeesetupchqencashment, #webpayeesetupchqencashment .ctrl" >
                    <img src="views/images/loader.gif" alt="." class="hide" style="margin-right:5px;"/><span langid="new.payee.setup.button.finish" style="vertical-align:middle">&nbsp;Finish&nbsp;</span>
                </button>
                <button class="button default right tpm btm rtm" type="submit" name="payeesetupchqencPreviousbtn" id="payeesetupchqencPreviousbtn" xt-bind="#click,savePayeeDetail,#webpayeesetupchqencashment, #webpayeesetupchqencashment .ctrl" >
                    <img src="views/images/loader.gif" alt="." class="hide" style="margin-right:5px;"/><span langid="new.payee.setup.button.previous" style="vertical-align:middle">&nbsp;Previous&nbsp;</span>
                </button>
                <button  class="ctrl button  left tpm btm rtm" type="submit" name="payeesetupchqencCancelbtn" id="payeesetupchqencCancelbtn" xt-bind="#click" langid="new.payee.setup.button.cancel" >&nbsp;Cancel&nbsp;</button>
            </div>
        </form>
    </div>

</div>






<div class="payee-setup-local-wire round bold-border-outline hide ">
    <div id="payeesetuplocalwire" class="">
        <h2  class="ui-section-heading bold" langid="payee.setup.local.wire.title">Payee Setup - Local Wire</h2>

        <form class="" name="webpayeesetuplocalwire" id="webpayeesetuplocalwire" action="" method="post">
            <div>
                 <ul>
                     <li><label langid="payee.name">Payee Name:</label><span id="lwpayeeName" name="lwpayeeName">Mary P. Jane</span><br>
                        <label langid="payee.setup.local.wire.account.alias">Account Alias:</label><input type="textbox" name="lwaccountAlias" id="lwaccountAlias" class=" " /><br/>
                    </li>
                </ul>
             </div>
            <hr class="clear ttm" />
            <div><span langid="payee.setup.local.wire.details.title"  class="bold redcolor " >Account Details</span></div>
            <div  class="  ttm clear " >
                <ul>
                    <li><label langid="payee.setup.local.wire.bank">Bank:</label><label style="position:relative;left:18px;" class="pmrequired">*</label><select id="selbankName" name="selbankName" xt-bind="#change,showBankBranches"><option value="{code}">{description}</option></select><select id="selbankBranch" name="selbankBranch"><option value="{routingMethodCode}_{routingNumber}">{bankBranch}</option></select></li>

                    <li><label langid="payee.setup.local.wire.account.no">Account:</label><label style="position:relative;left:3px;" class="pmrequired">*</label>    <input id="lwaccountNo" name="lwaccountNo" type="textbox"/><select id="sellwCurrency" name="sellwCurrency"><option value="{0}">{0} ({1}:1)</option></select><select id="sellwAccountType" name="sellwAccountType"><option value="{code}">{description}</option></select></li>
                </ul>
            </div>
            <hr class="clear ttm" />
            <div class="buttonbar clear" style="height:40px;" >
                <button class="button default right tpm btm rtm" type="submit" name="payeesetuplwNextbtn" id="payeesetuplwNextbtn" xt-bind="#click,savePayeeDetail,#webpayeesetuplocalwire, #webpayeesetuplocalwire .ctrl" >
                    <img src="views/images/loader.gif" alt="." class="hide" style="margin-right:5px;"/><span langid="new.payee.setup.button.next" style="vertical-align:middle">&nbsp;Next&nbsp;</span>
                </button>
                <button class="button default right tpm btm rtm" type="submit" name="payeesetuplwFinishbtn" id="payeesetuplwFinishbtn" xt-bind="#click,savePayeeDetail,#webpayeesetuplocalwire, #webpayeesetuplocalwire .ctrl" >
                    <img src="views/images/loader.gif" alt="." class="hide" style="margin-right:5px;"/><span langid="new.payee.setup.button.finish" style="vertical-align:middle">&nbsp;Finish&nbsp;</span>
                </button>
                <button class="button default right tpm btm rtm" type="submit" name="payeesetuplwPreviousbtn" id="payeesetuplwPreviousbtn" xt-bind="#click,savePayeeDetail,#webpayeesetuplocalwire, #webpayeesetuplocalwire .ctrl" >
                    <img src="views/images/loader.gif" alt="." class="hide" style="margin-right:5px;"/><span langid="new.payee.setup.button.previous" style="vertical-align:middle">&nbsp;Previous&nbsp;</span>
                </button>
                <button  class="ctrl button  left tpm btm rtm" type="submit" name="payeesetuplwCancelbtn" id="payeesetuplwCancelbtn" xt-bind="#click" langid="new.payee.setup.button.cancel" >&nbsp;Cancel&nbsp;</button>
            </div>
        </form>
    </div>

</div>





<div class="payee-setup-international-wire round bold-border-outline hide">
    <div id="payeesetuplocalwire" class="">
        <h2  class="ui-section-heading bold" langid="payee.setup.international.wire.title">Payee Setup - International Wire</h2>

        <form class="" name="webpayeesetupinternationalwire" id="webpayeesetupinternationalwire" action="" method="post">
            <div>
                 <ul>
                     <li><label langid="payee.name">Payee Name:</label><span id="inwpayeeName" name="inwpayeeName">Mary P. Jane</span><br>
                        <label langid="payee.setup.international.wire.account.alias">Account Alias:</label><input type="textbox" name="inwaccountAlias" id="inwaccountAlias" class=" " /><br/>
                    </li>
                </ul>
             </div>
            <hr class="clear ttm" />
            <div><span langid="payee.setup.international.wire.payment.information"  class="bold redcolor ">Payment Information</span></div>
            <div  class="  ttm clear " >
                <ul>
                    <li><label langid="payee.setup.international.currency">Currency:</label><label style="position:relative;left:35px;" class="pmrequired">*</label><select id="selinwCurrency" name="selinwCurrency" ><option value="{0}">{0}</option></select></li>

                    <li><label langid="payee.setup.international.payment.details">Payment Details:</label><input  name="inwPaymentDetails1" id="inwPaymentDetails1" type="textbox"/><br>
                        <input  name="inwPaymentDetails2" id="inwPaymentDetails2" type="textbox"/><br><input  name="inwPaymentDetails3" id="inwPaymentDetails3" type="textbox"/><br>
                        <input  name="inwPaymentDetails4" id="inwPaymentDetails4" type="textbox"/><br>
                    </li>
                </ul>
            </div>
           <div class="  ttm" ><span langid="payee.setup.international.wire.beneficiary.details"  class="bold redcolor ">Beneficiary Details</span></div>
            <div  class="  ttm clear " >
                <ul>
                    <li><label langid="payee.setup.international.accountno">Account #:</label><label style="position:relative;left:30px;" class="pmrequired">*</label><input id="inwAccountNo" name="inwAccountNo" type="textbox"/></li>

                    <li><label langid="payee.setup.international.bd.address">Address:</label><label  style="position:relative;left:37px;" class="pmrequired">*</label><input  name="inwbdAddress1" id="inwbdAddress1" type="textbox"/><br>
                        <input  name="inwbdAddress2" id="inwbdAddress2" type="textbox"/><br>
                        <input  name="inwbdAddress3" id="inwbdAddress3" type="textbox"/><select id="selinwbdCountry" name="selinwbdCountry"><option value="{code}">{name}</option></select><br>
                        <label langid="payee.setup.international.bbd.country" id="bdCountry" name="bdCountry">Country</label>
                    </li>
                </ul>
            </div>
            <div class="  ttm" ><span langid="payee.setup.international.wire.beneficiary.bank.details"  class="bold redcolor ">Beneficiary Bank Details</span></div>
            <div  class="  ttm clear " >
                <ul>
                    <li><label langid="payee.setup.international.routing">Routing:</label><label style="position:relative;left:38px;" class="pmrequired">*</label><select id="selinwbbdRouting" name="selinwbbdRouting" ><option value="{code}">{description}</option></select><input  name="inwRouting" id="inwRouting" type="textbox"/><br>
                    <label langid="payee.setup.international.bbd.routing.method" id="bbdRoutingMethod" name="bbdRoutingMethod">Routing Method</label><label langid="payee.setup.international.bbd.routing.number" id="bbdRoutingNumber" name="bbdRoutingNumber">Routing #</label>
                    </li>

                    <li><label langid="payee.setup.international.bbd.name">Name:</label><label style="position:relative;left:45px;"  class="pmrequired">*</label><input  name="inwbbdName" id="inwbbdName" type="textbox"/></li>
                    <li><label langid="payee.setup.international.bbd.address">Address:</label><label style="position:relative;left:33px;" class="pmrequired">*</label><input  name="inwbbdAddress1" id="inwbbdAddress1" type="textbox"/><br>
                        <input  name="inwbbdAddress2" id="inwbbdAddress2" type="textbox"/><br>
                        <input  name="inwbbdAddress3" id="inwbbdAddress3" type="textbox"/><select id="selinwbbdCountry" name="selinwbbdCountry"><option value="{code}">{name}</option></select><br>
                        <label langid="payee.setup.international.bbd.country" id="bbdCountry" name="bbdCountry">Country</label>
                    </li>
                </ul>
            </div>

         <div class="ttm" ><span langid="payee.setup.international.wire.intermediary.bank"  class="bold redcolor ">Intermediary Bank</span></div>
            <div  class="  ttm clear " >
                <ul>
                    <li><label langid="payee.setup.international.ib.routing">Routing:</label><select id="selinwidRouting" name="selinwidRouting" ><option value="{code}">{description}</option></select><input  name="inwibRouting" id="inwibRouting" type="textbox"/><br>
                        <label langid="payee.setup.international.ib.routing.method" id="ibRoutingMethod" name="ibRoutingMethod">Routing Method</label><label langid="payee.setup.international.ib.routing.number" id="ibRoutingNumber" name="ibRoutingNumber">Routing #</label>
                    </li>

                    <li><label langid="payee.setup.international.ib.name">Name:</label><input  name="inwibName" id="inwibName" type="textbox"/></li>
                    <li><label langid="payee.setup.international.ib.address">Address:</label><input  name="inwibaddress1" id="inwibaddress1" type="textbox"/><br>
                        <input  name="inwibaddress2" id="inwibaddress2" type="textbox"/><br>
                        <input  name="inwibaddress3" id="inwibaddress3" type="textbox"/><select id="selinwibCountry" name="selinwibCountry"><option value="{code}">{name}</option></select><br>
                        <label langid="payee.setup.international.bbd.country" id="ibCountry" name="ibCountry">Country</label>
                    </li>
                </ul>
            </div>

            <hr class="clear ttm" />
            <div class="buttonbar clear" style="height:40px;" >
                <button class="button default right tpm btm rtm" type="submit" name="payeesetupinwNextbtn" id="payeesetupinwNextbtn" xt-bind="#click,savePayeeDetail,#webpayeesetupinternationalwire, #webpayeesetupinternationalwire .ctrl" >
                    <img src="views/images/loader.gif" alt="." class="hide" style="margin-right:5px;"/><span langid="new.payee.setup.button.next" style="vertical-align:middle">&nbsp;Next&nbsp;</span>
                </button>
                <button class="button default right tpm btm rtm" type="submit" name="payeesetupinwFinishbtn" id="payeesetupinwFinishbtn" xt-bind="#click,savePayeeDetail,#webpayeesetupinternationalwire, #webpayeesetupinternationalwire .ctrl" >
                    <img src="views/images/loader.gif" alt="." class="hide" style="margin-right:5px;"/><span langid="new.payee.setup.button.finish" style="vertical-align:middle">&nbsp;Finish&nbsp;</span>
                </button>
                <button class="button default right tpm btm rtm" type="submit" name="payeesetupinwPreviousbtn" id="payeesetupinwPreviousbtn" xt-bind="#click,savePayeeDetail,#webpayeesetupinternationalwire, #webpayeesetupinternationalwire .ctrl" >
                    <img src="views/images/loader.gif" alt="." class="hide" style="margin-right:5px;"/><span langid="new.payee.setup.button.previous" style="vertical-align:middle">&nbsp;Previous&nbsp;</span>
                </button>
                <button  class="ctrl button  left tpm btm rtm" type="submit" name="payeesetupinwCancelbtn" id="payeesetupinwCancelbtn" xt-bind="#click" langid="new.payee.setup.button.cancel" >&nbsp;Cancel&nbsp;</button>
            </div>
        </form>
    </div>

</div>

