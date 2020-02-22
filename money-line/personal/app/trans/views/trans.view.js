Raxan.ready(function(){

    // setup the display items
    displayDeliveryAddress();
    displaySourceAccountInfo();
    displayAmountEnteredInfo();
    displayCurrencyInfo();
    getAmountEnteredCurrencyList();

    var sourceAccountSectionAutoToggle = true;
    var amountEnteredCurrencyAutoToggle = true;


    // handles display of  rate information for multi currency
    function displayCurrencyInfo(){

        var transTypeSelected = Raxan.getVar('transTypeSelected');
        var baseCurrency = Raxan.getVar('baseCurrency');

        // get the currency of the amount entered
        var amountCurrency = $('#amountCurrency').val();
        if (amountCurrency) {
            // update the display of the amount currency and show the flag
            $('.amountCurrencyDisplay').text(amountCurrency);
            $('#amountCurrencyImage').html('<img src="views/images/flags/jmmbCurrencies/' + amountCurrency + '.png" > ' );

            if (amountCurrency != baseCurrency && transTypeSelected == "CHEQUE"){
                $("#internationalChequeDisplay").show();
            }
            else{
                $("#internationalChequeDisplay").hide();
            }


        }
        else {
            $('.amountCurrencyDisplay').text("");
            $('#amountCurrencyImage').html("" );
        }

        // get the currency of the source account
        var accInfo = $('#sourceAccount').find('option[value="'+$('#sourceAccount').val()+'"]').attr('data-AccInfo');
        if (accInfo) {
            var values = accInfo.split("|");
            var accountCurrency = values[3];
            // if the amount currency is different show excange rate information
            if ( accountCurrency != amountCurrency  ) {
                $('#excnahgeRateSection').show();
            }
            else {
                $('#excnahgeRateSection').hide();
            }
        }

    }

    // display the dollar amount in words
    function displayAmountEnteredInfo(){
        var dollarAmount = $('#amountEntered');
        var amountCurrency = $('#amountCurrency');
        var dollarsInWords = money_to_words2(dollarAmount.val(), amountCurrency.val());
        
        if (dollarsInWords) {
            $('#amountInWords').html(
                 dollarsInWords
            );
        }
        else {
            $('#amountInWords').html("");
        }

    }

    // function used to handle the showing of the address based on the option selected
    function displayDeliveryAddress(){
        var opt =$('#addressList') ;
        // if the handle is not valid exit
        if(!$(opt)) return ;

        // format and display the address section
        if (opt.val() == "" ){
            $('.address').hide();
        }
        else if (opt.val()=="CUSTOM") {
            $('.address').addClass("addressBorder").show();
        }
        else {
            // get addresses
            var addressInfo = opt.find('option[value="'+opt.val()+'"]').attr('data-address');

            // if the object is not found exit
            if (!addressInfo) return;

            var address = addressInfo.split("|");

            // remove the edit formating
            $('.address').removeClass("addressBorder").hide();
            // clear the address
            $('.address').val("");
            $('.addressLbl').show();

            // update the addess boxes
            if (address[0]) {
                $('#addressLine1').val(address[0]);
                $('.addressL1').show();
            }
            if (address[1]) {
                $('#addressLine2').val(address[1]);
                $('.addressL2').show();
            }
            if (address[2]) {
                $('#addressLine3').val(address[2]);
                $('.addressL3').show();
            }
            if (address[3]) {
                $('#addressCountryCode').val(address[3]);
                $('.addressCc').show();
            }
        }
    }

    // handle the display of account information
    function displaySourceAccountInfo(){

        var opt = $('#sourceAccount');
        if(!$(opt)) return ;

        // format and display the address section
        if (opt.val() == "" ){
            $('#sourceAccountNoValue').val("");
            $('#sourceAccountType').text("" );
            $('#sourceSigningInstructiions').text("");
            $('.sourceCurrencyDisplay').text("");
            $('#sourceAvailableBalance').text("");
        }
        else {
            var accInfo = opt.find('option[value="'+opt.val()+'"]').attr('data-AccInfo');
            if(!accInfo) return;

            var values = accInfo.split("|");
            $('#sourceAccountNoValue').val(values[0]);
            $('#sourceAccountCurrency').val(values[3]);
            $('#sourceAccountType').text(jQuery.trim(values[1]) + " / " + values[5] );
            $('#sourceSigningInstructiions').text(values[2]);
            $('.sourceCurrencyDisplay').text(values[3]);
            if (values[5].toUpperCase() == "INVESTOR" && $("#sourceMaturity").val()=="")
                $('#sourceAvailableBalance').text("Select Maturity");
            else
                $('#sourceAvailableBalance').html(
                    '<img src="views/images/flags/jmmbCurrencies/' + values[3] + '.png" > '  + values[3] + ' ' + values[4]
                );

        }
    }

    // handle the cycle period
    function cyclePeriodDaysDisplay(){
        if($("#cyclePeriod").val()=="NUMDAYS"){
            $("#cyclePeriodDaysSection").show();
        }
        else{
            $("#cyclePeriodDaysSection").hide();
        }
    }

    // used to enable the amount section
    function enableAmountSection(){
        $("#amountEntered").removeAttr('disabled');
        $("#amountCurrency").removeAttr('disabled');
        $("#amountEnteredMsg").text('');
    }

    // populate the amount currency
    function getAmountEnteredCurrencyList(){

        var payeeDetailCurrency = Raxan.getVar('payeeDetailCurrency');
        var transTypeSelected   = Raxan.getVar('transTypeSelected');
        //var allowCambio         = Raxan.getVar('allowCambio');

        //alert(transTypeSelected + ' xxxx');

        // this function is to be run only for transfer and wires
        if (transTypeSelected == "CHEQUE") {
            enableAmountSection();
            return;

        } 

        $("#amountCurrency").find('option').remove();
        $('#amountCurrency').attr('disabled', 'disabled');
        $('#amountEntered').attr('disabled', 'disabled');
        $('#amountEnteredMsg').text("Select account first.");
        //$("#amountCurrency").append("<option value=''>txn("ency . , >"))

        
        // get the currency of the source acount
        var accInfo = $('#sourceAccount').find('option[value="'+$('#sourceAccount').val()+'"]').attr('data-AccInfo');
        if (accInfo) {
            var values = accInfo.split("|");
            var accountCurrency = values[3];
            $("#amountCurrency").append('<option  value="' + accountCurrency + '">' + accountCurrency + '</option>')
            enableAmountSection();

        }
        // use the value from the session if it is set
        if (payeeDetailCurrency) {
            if ( accountCurrency != payeeDetailCurrency ) {
                $("#amountCurrency").append('<option  value="' + payeeDetailCurrency + '">' + payeeDetailCurrency + '</option>');
                    enableAmountSection();
            }
        }
        else {

            // get the currency of the transfer payee
            var accInfo = $('#transferAccountList').find('option[value="'+$('#transferAccountList').val()+'"]').attr('data-AccInfo');
            if (accInfo) {
                var values = accInfo.split("|");
                var transferCurrency = values[0];
                if ( accountCurrency != transferCurrency ){
                    $("#amountCurrency").append('<option  value="' + transferCurrency + '">' + transferCurrency + '</option>')
                    enableAmountSection();
                }
            }
            else {
                // get the currency of the wire payee
                var accInfo = $('#wireAccountList').find('option[value="'+$('#wireAccountList').val()+'"]').attr('data-AccInfo');
                if (accInfo) {
                    var values = accInfo.split("|");
                    var wireCurrency = values[0];
                    if ( accountCurrency != wireCurrency ){
                        $("#amountCurrency").append('<option  value="' + wireCurrency + '">' + wireCurrency + '</option>');
                        enableAmountSection();
                    }
                }

            }


        }
        
        displayCurrencyInfo();
        

    }



    $('#wireAccountList').change(function(){
        getAmountEnteredCurrencyList();
    })
    $('#transferAccountList').change(function(){
        getAmountEnteredCurrencyList();
    })

    $('.dtPicker').datepicker({
        dateFormat:'yy-mm-dd',
        changeMonth: true,
        changeYear: true
    });

    $('#txnDateImg').click(function(){
        $("#transactionDate").datepicker('show');
    });

    $('#cyclePeriodSartDate').click(function(){
        $("#cyclePeriodSartDate").datepicker('show');
    });

    $('#cyclePeriodEndDate').click(function(){
        $("#cyclePeriodEndDate").datepicker('show');
    });
    $("#cyclePeriod").change(function(){
        cyclePeriodDaysDisplay();
    })

    $('#deliveryMethod').change(function(){
        if ($(this).val()=="PICKUP") {
            $('#branchListSection').show();
            $('#addressListSection').hide();
        }
        else if ($(this).val()=="DELIVER") {
            $('#branchListSection').hide();
            $('#addressListSection').show();
        }
    })


    // clear the address details
    $('#payeeList').change(function(){
        $('.address').val("");
        $('.address').removeClass("addressBorder").hide();

        var row = document.getElementById("payeeList").selectedIndex >=0 ? document.getElementById("payeeList").options[document.getElementById("payeeList").selectedIndex].value : null;
        var payeeType = $('#payeeList option[value="'+row+'"]').attr("data-payeeType");
        // if the payee is a company disable the delivery controls
        if (payeeType == "C" ){
            $('.deliveryClass').attr("disabled", "disabled");}
        else {
            $('.deliveryClass').removeAttr("disabled");}

    })


    // handles the address manipulation 
    $('#addressList').change(function(){
        
        // handle the address display
        displayDeliveryAddress();

    })

    // handles the click on the show hide txn details 
    $('.toggleTxnDetails').click(function(){
      
      // get the current row
      var txnRowId = $(this).attr("data-txnRowId") ;
      
      // toggle the visibility
      $('#txnDetails'+ txnRowId).toggle();

    })


    // show the source account balance
    $('#sourceAccount').bind('togglecontent',function(e, mode){

        if (mode=='on') { //
            var currentAmountCurrency = $('#amountCurrency').val();

            //alert( $('#amountCurrency').val());

            // setup the source account info
            displaySourceAccountInfo();

            // clear the hearder info
            $('#sourceSectionInfo').text('');

            // set the source section auto toggle variable
            sourceAccountSectionAutoToggle = true;

            // re-populate the amount entered currency
            getAmountEnteredCurrencyList();


            // set the currency on the change
            if (amountEnteredCurrencyAutoToggle){
                $('#amountCurrency').val($('#sourceAccountCurrency').val()); // set currency for the amount
            }
            else {
                $('#amountCurrency').val(currentAmountCurrency); // set currency for the amount
            }

            // show any currency updated needed
            displayCurrencyInfo();
        }
        else {
            return ;
        }


    });

    // handle the change of the amount currency 
    $('#amountCurrency').change(function(){

        // execute function to handle currency info
        displayCurrencyInfo();

        // turn off auto toggle
        amountEnteredCurrencyAutoToggle = false ;

        displayAmountEnteredInfo();

    });


    //show amount in words
    $('#amountEntered').keyup(function(){
        displayAmountEnteredInfo();

        // turn off auto toggle
        amountEnteredCurrencyAutoToggle = false ;

    })

    // toggle transaction sections
    $('#typeSectionHeader').click(function(){
        $('#typeSection').toggle();
    })
    $('#payeeSectionHeader').click(function(){
        $('#payeeSection').toggle();
    })
    $('#noteSectionHeader').click(function(){
        $('#noteSection').toggle();
    })

    $('#sourceSectionHeader').click(function(){
        $('#sourceSection').toggle();
        sourceAccountSectionAutoToggle = false;
    })
    /*
    $('#amountEntered').keypress(function(){
        if($('#sourceAccount').val()!= "" && sourceAccountSectionAutoToggle){

            $('#sourceSection').hide();
            $('#sourceSectionInfo').text(
                $('#sourceAccountNoValue').val() + " | " 
                + jQuery.trim($('#sourceAccountType').text()) + " | "
                + jQuery.trim($('#sourceSigningInstructiions').text()) + " | "
                + $('#sourceAvailableBalance').text()
                );
        }
    });
    */
    $('#amountSectionHeader').click(function(){
        $('#amountSection').toggle();
    })
    $('#scheduleSectionHeader').click(function(){
        $('#scheduleSection').toggle();
    })

    $('#accInfoToggle').click(function() {
        $('#accInfo').toggle();
    })
    $('#amountInfoToggle').click(function() {
        $('#amountInfo').toggle();
    })
    $('#chargesInfoToggle').click(function() {
        $('#chargesInfo').toggle();
    })


    $('#transFrequencyOption1').click(function() {
        $('#multipleFrequency').hide();
        $('#oneTimeFrequency').show();
    })
    $('#transFrequencyOption2').click(function() {
        $('#multipleFrequency').show();
        $('#oneTimeFrequency').hide();
    })

});

