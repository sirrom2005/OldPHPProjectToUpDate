/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


    var icons =
    {
        header: "ui-icon-circle-plus",
        headerSelected: "ui-icon-circle-minus"
    };

    function showOverview()
    {
        window.location = "app/payee/index.php";
    }
    
    Raxan.ready(function()
    {
        $( "#payeeList" ).accordion(
        {
                    icons: icons
        });
                
        $(".returnToOverview").bind("click", function(e){
            if(e)
                e.preventDefault();
            
            showOverview();
            return false;
        });

        //begin approvedCompany view
        $("#companyshortname, #accountreferencenumber").keyup(function(){
            var desc ="";
            if($.trim($("#accountreferencenumber").val())=="")
                desc = $("#companyshortname").val();
            else
                desc = $("#companyshortname").val()+" #"+$("#accountreferencenumber").val();
            $("#chequeDescription").html(desc);
         });
        
        //end approvedCompany view

        //begin payeeVerfication
        
        //end payeeVerfication view

    })

    function buildPayeeDetailsList(payeeid, detailsList)
    {
        var payeename = "#payee"+payeeid;

        $(payeename).html(detailsList);

        $("a.edit").click(function()
        {
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


/*
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
        alert(detailsList);
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
    */