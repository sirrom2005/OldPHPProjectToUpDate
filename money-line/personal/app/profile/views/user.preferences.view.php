<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

?>

  <style type="text/css">

    #slider                             { margin-left: 10px; margin-top: 20px;  height:200px;}
    #slider .ui-slider-range            { background: #ef2929;}
    #slider .ui-slider-handle           { border-color: #ef2929; }
    .ui-index-slider                    {width:20px;height:5px; cursor: pointer; background-image: url(raxan/ui/css/ui-lightness/images/thick-minus.png); background-repeat: repeat-x}
    .ui-slider-indicator                {left:20px; position: relative; cursor:pointer;}
    .ui-slider-container                {font-size: 70%;width:130px;height:230px;overflow:hidden;}

    .ui-slider-color-custom             {color:#ef2929;}
    .ui-slider-color-unrestricted       {color:#c1c93d;}
    .ui-slider-color-moderate           {color:#3db4c9;}
    .ui-slider-color-high               {color:#729fcf;}
    .ui-slider-color-strict             {color:#3dc999;}
    .ui-slider-color-lockout            {color:#8ae234;}

    .bold                               {font-weight: bold;}
    .ltm                                {margin-left: 10px;}
    .rtm                                {margin-right:10px;}
    .ttm                                {margin-top: 10px;}
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
    form label                          {float:none;display:inline;}
    form .textbox                       {width:auto;}

    .transaction-policy-container       {width:519px;position:relative;}
     .policy-row                        {height:170px;}
     .left-border                       {border-left: 1px solid #B8D152;}
     .policy-col {
                 width:250px;
                padding-left: 5px;
                position: relative;
                vertical-align: top;
                display:inline-block;}
    .transaction-policy-container .header .policy-col label { margin-left: 5px;}
     .policy-col .policy-widget{ left:  5px;position: relative;}
     .policy-col li{ list-style-type: none;}
     .policy-col ul {margin: 0px; padding: 0px;}
    .transaction-policy-container .policy-title { font-size: 110%; margin-bottom: 10px; margin-top: 10px;}

    .transaction-policy-container .policy-types {position: relative;top: -10px;}
    .user-notice{width: 200px;}
    .policy-descriptions{ width:510px ;position:relative;padding-left:10px;  background-image:url("images/transSectionBg.jpg");}
    .policy-descriptions .title{font-size: 110%;}
    

    .ui-section-heading{font-size: 120%;border-bottom: 1px solid #404040;width:100%;margin-bottom: 10px;color:#404040;}
    .ui-slider-label {position:relative;  left:25px; top:-10px;font-size:120%;cursor: pointer;}

    #custom-indicator       {top:-5px;}
    #unrestricted-indicator {top:-62px;}
    #moderate-indicator     {top:-122px;}
    #high-indicator         {top:-182px;}
    #strict-indicator       {top:-243px;}
    #lockout-indicator      {top:-300px;}


     #viewHistory span{display:inline-block;position:relative;}
     #viewHistory h3{margin-left:30px;}
     #viewHistory ul{list-style-type: decimal;}
     #viewHistory {width:440px;}

     #upViewHistory{ color:#0055AA; text-decoration: underline; cursor: pointer;}
     input[type=radio]{margin-left: 5px;}

     .acl {
                border:solid 1px transparent;
                padding-right: 20px;
                position: relative;
                display:inline-block;
            }
    .acl.aclDisabled {
        color:#bbb;
    }
    .acl.aclHover {
        border-color:#eee;
    }
    .acl-lock {
        position:absolute;
        background-color:#eee;
        top: -1000px;
        padding: 0px 1px;
        cursor:pointer;
        height:100%;
    }
    .acl-lock:hover {
        background-color: #ffcc00;
    }
    .rax-box.info {background-color: lightgrey;color:auto;}

    button{cursor: pointer;}
    .user-profile-preferences       { padding:10px;}
    #upChangeQuestions {width:180px;}
  </style>

<!--[if ! IE]><!-->
<style type="text/css">
    
    .dlyTransLimit          {height:70px;top:10px;position: relative;width:663px;}
    .right-panel{margin: 0px;}
    .user-preferences-transaction-policy , .user-preferences-home-page-setup,
    .user-preferences-account-setup , .user-preferences-user-profile,
    .user-profile-security-verification,.user-profile-preferences {width: 663px; position: relative;}

    
</style>
<script type="text/javascript">


   function showOverview()
   {
        window.location.href = "app/profile/index.php";
   }
    function showChangeSQ()
    {
        window.location.href = "app/profile/Changequestions.php";
    }


    function showChangeUserName()
    {
        window.location.href = "app/profile/Changeusername.php";
    }



    function showChangePIN()
    {
        window.location.href = "app/profile/Changepin.php";
    }


    function showChangePWD()
    {
        window.location.href = "app/profile/Changepwd.php";
    }

</script>
<!--<![endif]-->

<!--[if IE]>
<style type="text/css">
    
    .dlyTransLimit          {height:70px;position: relative;width:663px; top:10px;}
    .right-panel{margin: 0px;}
    .user-preferences-transaction-policy ,  .user-preferences-home-page-setup,
    .user-preferences-account-setup, .user-preferences-user-profile,
    .user-profile-security-verification , .user-profile-preferences {width: 663px; position: relative;}

    
</style>

<script type="text/javascript">


   function showOverview()
   {
        window.location.href = "app/profile/index.php";
   }
    function showChangeSQ()
    {
        window.location.href = "Changequestions.php";
    }


    function showChangeUserName()
    {
        window.location.href = "Changeusername.php";
    }



    function showChangePIN()
    {
        window.location.href = "Changepin.php";
    }


    function showChangePWD()
    {
        window.location.href = "Changepwd.php";
    }
</script>
<![endif]-->

  <script type="text/javascript">

    var lastSliderValue =-1,
    lastAuthorizedSliderValue=-1,
    initialLevelIndex = -1;

    var indicators ={
       CUSTOM_INDICATOR             : 0,
       BASIC_INDICATOR              : 20,
       MODERATE_INDICATOR           :40,
       HIGH_INDICATOR               :60,
       INTERNAL_TRANSFER_INDICATOR    :80,
       NO_TRANSACTION_INDICATOR   :100
    };

    var transPolicyLevels={

        ALLOW_CHEQUES               :1,
        ALLOW_INTERNAL_TRANSFERS    :2,
        ALLOW_LOCAL_WIRES           :4,
        ALLOW_INTERNATIONAL_WIRES   :8,
        ALLOW_CAMBIO                :16,
        ALLOW_STANDING_ORDERS       :32,
        ALLOW_EQUITY                :64,
        ALLOW_ONLY_ENCASH_PICKUP    :128,
        USER_WIRE_PAYEE             :256,
        USER_ENCASH_PAYEE           :512,
        USER_INTERNAL_PAYEE         :1024,
        USER_DAILY_LIMIT_CHANGE     :2048,
        USER_PREF_VERIFICATION      :4096,
        WIRE_PAYEE_VERIFICATION     :8192,
        ENCASH_PAYEE_VERIFICATION   :16384,
        INTERNAL_PAYEE_VERIFICATION :32768
    };

    var transLevels={
        BASIC               :3967,
        MODERATE            :16255,
        HIGH                :63615,
        INTERNAL_TRANSFER   :63490,
        NO_TRANSACTION      :61440
    };

    var sliderIntervals={
        CUSTOM              :0,
        BASIC               :20,
        MODERATE            :40,
        HIGH                :60,
        INTERNAL_TRANSFER   :80,
        NO_TRANSACTION      :100
    }
  Raxan.ready(function() {
    $("#slider").slider({
        animate:true,
        value:Raxan.getVar("slider-init-value"),
        step:20,
        max:100,
        min:0,
        orientation: 'vertical',
        slide:function (event, ui)
          {
              return canChangeSlider(ui.value);
               // slideSlider(ui.value);
               //alert(ui.value);
          },
        change:function (event, ui)
          {
              //alert(ui.value);

                return slideSlider(ui.value);
          },
          start:function(event, ui)
          {
                changeSliderColor(Raxan.getVar("slider-init-value"));
          }
          ,

        range:"min"
        });

//        var initValue =  policyLevel2sliderIndicator(calculatePolicyLevel());//$("#slider").slider("option","value");
//        $("#slider").slider("option","value",initValue);
//        slideSlider(initValue);

        var invalidPolicySelectionError = Raxan.getVar("invalid-policy-type");
        $("#upViewHistory").click(function(e){
            showMessage($("#viewHistoryContainer").html());
        });
        $("#custom-indicator , #custom-indicator .ui-slider-label").click(function(e)
        {
            if(canChangeSlider(indicators.CUSTOM_INDICATOR))
                $("#slider").slider("option","value",indicators.CUSTOM_INDICATOR);
            else
                showErrorMessage(invalidPolicySelectionError);
        } );
        $("#unrestricted-indicator , #unrestricted-indicator .ui-slider-label").click(function(e)
        {
            if(canChangeSlider(indicators.BASIC_INDICATOR))

                    $("#slider").slider("option","value",indicators.BASIC_INDICATOR);
            else
                showErrorMessage(invalidPolicySelectionError);
        } );
        $("#high-indicator , #high-indicator .ui-slider-label").click(function(e)
        {
            if(canChangeSlider(indicators.HIGH_INDICATOR))
                $("#slider").slider("option","value",indicators.HIGH_INDICATOR);
            else
                showErrorMessage(invalidPolicySelectionError);
        } );
        $("#moderate-indicator , #moderate-indicator .ui-slider-label").click(function(e)
        {
            if(canChangeSlider(indicators.MODERATE_INDICATOR))
                $("#slider").slider("option","value",indicators.MODERATE_INDICATOR);
            else
                showErrorMessage(invalidPolicySelectionError);
        } );
        $("#strict-indicator , #strict-indicator .ui-slider-label").click(function(e)
        {
            if(canChangeSlider(indicators.INTERNAL_TRANSFER_INDICATOR))
                $("#slider").slider("option","value",indicators.INTERNAL_TRANSFER_INDICATOR);
            else
                showErrorMessage(invalidPolicySelectionError);
        } );
        $("#lockout-indicator , #lockout-indicator .ui-slider-label").click(function(e)
        {
            if(canChangeSlider(indicators.NO_TRANSACTION_INDICATOR))
                $("#slider").slider("option","value",indicators.NO_TRANSACTION_INDICATOR);
            else
                showErrorMessage(invalidPolicySelectionError);
        } );

        $("#aclCheques , #aclIntTransfers, #aclWires, #aclWires,#aclIntrWires, #aclStandOrder, #aclCambio,\n\
                #aclEquity,#umpWireTransfer, #umpChequeEncashment, #umpInternalTransfer, #aclDailyLimitChange,\n\
                #verUserPrefModification, #verPayeeWireTrans, #verPayeeChequeEncashment, #verPayeeInternalTransfers        ").click(function(e)
        {

            
            var indicatorValue = policyLevel2sliderIndicator(calculatePolicyLevel());
            //alert(indicatorValue);
            if(canChangeSlider(indicatorValue))
                $("#slider").slider("option","value",indicatorValue);
            else
                {

                    if(indicatorValue > 0)
                    {
                        if($(this).attr("checked"))
                            $(this).attr("checked","");
                        else
                            $(this).attr("checked","checked");
                        e.preventDefault();
                        e.stopImmediatePropagation();
                        showErrorMessage(invalidPolicySelectionError);
                        return false;
                   }
                }
        } );

  });


  function policyLevel2sliderIndicator(policyLevel)
  {
      //alert(policyLevel);

      try
      {
          switch(policyLevel)
          {
              case transLevels.BASIC:
                   return sliderIntervals.BASIC;
                   break;
              case transLevels.MODERATE:
                   return sliderIntervals.MODERATE;
                   break;
              case transLevels.HIGH:
                   return sliderIntervals.HIGH;
                   break;
              case transLevels.INTERNAL_TRANSFER:
                   return sliderIntervals.INTERNAL_TRANSFER;
                   break;
              case transLevels.NO_TRANSACTION:
                   return  sliderIntervals.NO_TRANSACTION;
                   break;
              default:
                   return sliderIntervals.CUSTOM;
                   break;

          }

      }catch(e)
      {
       // alert(e.message+" line#:"+e.number);
      }
  }

  function slideSlider( value)
  {

     // if( value == lastSliderValue) return false;
      changeSliderColor(value);
      showPolicyLevelDescription(value);
      setPolicyLevel(value);
      toggleSliderLabel(lastSliderValue);
      showPolicyLevelDescription(lastSliderValue);
      if(indicators.CUSTOM_INDICATOR == value)
      {
          $("#cutomizedbtncnt").removeClass("hide").fadeIn();

      }else
          {
              if(!$("#cutomizedbtncnt").hasClass("hide"))
                $("#cutomizedbtncnt").addClass("hide");
            lastAuthorizedSliderValue = value;
          }
      lastSliderValue= value;
      $("#hid_transPolicy").val(value/20);
      return true;

  }

  function setSlider()
  {

      try
      {
          switch(calculatePolicyLevel())
          {
              case transLevels.BASIC:
                   $("#slider").slider("option","value",sliderIntervals.BASIC);
                   break;
              case transLevels.MODERATE:
                   $("#slider").slider("option","value",sliderIntervals.MODERATE);
                   break;
              case transLevels.HIGH:
                   $("#slider").slider("option","value",sliderIntervals.HIGH);
                   break;
              case transLevels.INTERNAL_TRANSFER:
                   $("#slider").slider("option","value",sliderIntervals.INTERNAL_TRANSFER);
                   break;
              case transLevels.NO_TRANSACTION:
                   $("#slider").slider("option","value",sliderIntervals.NO_TRANSACTION);
                   break;
              default:
                   $("#slider").slider("option","value",sliderIntervals.CUSTOM);
                   break;

          }

      }catch(e)
      {
        alert(e.message+" line#:"+e.number);
      }
  }

  function toggleSliderLabel(value)
  {

      switch(value)
      {
          case indicators.CUSTOM_INDICATOR:
              $("#custom-indicator .ui-slider-label").toggleClass("bold  ui-slider-color-custom");
              break;
          case indicators.BASIC_INDICATOR:
              $("#unrestricted-indicator .ui-slider-label").toggleClass("bold ui-slider-color-unrestricted");
              break;
          case indicators.MODERATE_INDICATOR:
              $("#moderate-indicator .ui-slider-label").toggleClass("bold ui-slider-color-moderate");
              break;
          case indicators.HIGH_INDICATOR:
              $("#high-indicator .ui-slider-label").toggleClass("bold ui-slider-color-high");
              break;
          case indicators.INTERNAL_TRANSFER_INDICATOR:
              $("#strict-indicator .ui-slider-label").toggleClass("bold ui-slider-color-strict");
              break;
         case indicators.NO_TRANSACTION_INDICATOR:
              $("#lockout-indicator .ui-slider-label").toggleClass("bold ui-slider-color-lockout");
             break;
      }
  }


   function setPolicyLevel(value)
  {

      switch(value)
      {
          case indicators.CUSTOM_INDICATOR:
              //$("#custom-description").toggleClass("hide");

              break;
          case indicators.BASIC_INDICATOR:
              $("input[name='aclCheques']").attr('checked','checked');
              $("input[name='aclIntTransfers']").attr('checked','checked');
              $("input[name='aclWires']").attr('checked','checked');
              $("input[name='aclIntrWires']").attr('checked','checked');
              $("input[name='aclStandOrder']").attr('checked','checked');
              $("input[name='aclCambio']").attr('checked','checked');
              $("input[name='aclEquity']").attr('checked','checked');
              $("input[name='umpWireTransfer']").attr('checked','checked');
              $("input[name='umpChequeEncashment']").attr('checked','checked');
              $("input[name='umpInternalTransfer']").attr('checked','checked');
              $("input[name='aclDailyLimitChange']").attr('checked','checked');
              $("input[name='verUserPrefModification']").attr('checked','');
              $("input[name='verPayeeWireTrans']").attr('checked','');
              $("input[name='verPayeeChequeEncashment']").attr('checked','');
              $("input[name='verPayeeInternalTransfers']").attr('checked','');
              break;
          case indicators.MODERATE_INDICATOR:
              $("input[name='aclCheques']").attr('checked','checked');
              $("input[name='aclIntTransfers']").attr('checked','checked');
              $("input[name='aclWires']").attr('checked','checked');
              $("input[name='aclIntrWires']").attr('checked','checked');
              $("input[name='aclStandOrder']").attr('checked','checked');
              $("input[name='aclCambio']").attr('checked','checked');
              $("input[name='aclEquity']").attr('checked','checked');
              $("input[name='umpWireTransfer']").attr('checked','checked');
              $("input[name='umpChequeEncashment']").attr('checked','checked');
              $("input[name='umpInternalTransfer']").attr('checked','checked');
              $("input[name='aclDailyLimitChange']").attr('checked','checked');
              $("input[name='verUserPrefModification']").attr('checked','checked');
              $("input[name='verPayeeWireTrans']").attr('checked','checked');
              $("input[name='verPayeeChequeEncashment']").attr('checked','');
              $("input[name='verPayeeInternalTransfers']").attr('checked','');
              break;
          case indicators.HIGH_INDICATOR:
              $("input[name='aclCheques']").attr('checked','checked');
              $("input[name='aclIntTransfers']").attr('checked','checked');
              $("input[name='aclWires']").attr('checked','checked');
              $("input[name='aclIntrWires']").attr('checked','checked');
              $("input[name='aclStandOrder']").attr('checked','checked');
              $("input[name='aclCambio']").attr('checked','checked');
              $("input[name='aclEquity']").attr('checked','checked');
              $("input[name='umpWireTransfer']").attr('checked','');
              $("input[name='umpChequeEncashment']").attr('checked','');
              $("input[name='umpInternalTransfer']").attr('checked','');
              $("input[name='aclDailyLimitChange']").attr('checked','checked');
              $("input[name='verUserPrefModification']").attr('checked','checked');
              $("input[name='verPayeeWireTrans']").attr('checked','checked');
              $("input[name='verPayeeChequeEncashment']").attr('checked','checked');
              $("input[name='verPayeeInternalTransfers']").attr('checked','checked');
              break;
          case indicators.INTERNAL_TRANSFER_INDICATOR:
              $("input[name='aclCheques']").attr('checked','');
              $("input[name='aclIntTransfers']").attr('checked','checked');
              $("input[name='aclWires']").attr('checked','');
              $("input[name='aclIntrWires']").attr('checked','');
              $("input[name='aclStandOrder']").attr('checked','');
              $("input[name='aclCambio']").attr('checked','');
              $("input[name='aclEquity']").attr('checked','');
              $("input[name='umpWireTransfer']").attr('checked','');
              $("input[name='umpChequeEncashment']").attr('checked','');
              $("input[name='umpInternalTransfer']").attr('checked','');
              $("input[name='aclDailyLimitChange']").attr('checked','checked');
              $("input[name='verUserPrefModification']").attr('checked','checked');
              $("input[name='verPayeeWireTrans']").attr('checked','checked');
              $("input[name='verPayeeChequeEncashment']").attr('checked','checked');
              $("input[name='verPayeeInternalTransfers']").attr('checked','checked');
              break;
         case indicators.NO_TRANSACTION_INDICATOR:
              $("input[name='aclCheques']").attr('checked','');
              $("input[name='aclIntTransfers']").attr('checked','');
              $("input[name='aclWires']").attr('checked','');
              $("input[name='aclIntrWires']").attr('checked','');
              $("input[name='aclStandOrder']").attr('checked','');
              $("input[name='aclCambio']").attr('checked','');
              $("input[name='aclEquity']").attr('checked','');
              $("input[name='umpWireTransfer']").attr('checked','');
              $("input[name='umpChequeEncashment']").attr('checked','');
              $("input[name='umpInternalTransfer']").attr('checked','');
              $("input[name='aclDailyLimitChange']").attr('checked','');
              $("input[name='verUserPrefModification']").attr('checked','checked');
              $("input[name='verPayeeWireTrans']").attr('checked','checked');
              $("input[name='verPayeeChequeEncashment']").attr('checked','checked');
              $("input[name='verPayeeInternalTransfers']").attr('checked','checked');
             break;
      }
  }

   function showPolicyLevelDescription(value)
  {


        
      switch(value)
      {
          case indicators.CUSTOM_INDICATOR:
              $("#custom-description").toggleClass("hide");
              break;
          case indicators.BASIC_INDICATOR:
              $("#unrestricted-description").toggleClass("hide");
              break;
          case indicators.MODERATE_INDICATOR:
              $("#moderate-description").toggleClass("hide");
              break;
          case indicators.HIGH_INDICATOR:
              $("#high-description").toggleClass("hide");
              break;
          case indicators.INTERNAL_TRANSFER_INDICATOR:
              $("#strict-description").toggleClass("hide");
              break;
         case indicators.NO_TRANSACTION_INDICATOR:
              $("#lockout-description").toggleClass("hide");
             break;
      }
      
  }

  function changeSliderColor(value)
  {
            

              switch(parseInt(value))
              {
                  case indicators.CUSTOM_INDICATOR:
                      $("#slider .ui-slider-range").css("background","#ef2929");
                      $("#slider .ui-slider-handle").css("border-color","#ef2929");
                      break;
                  case indicators.BASIC_INDICATOR:
                    $("#slider .ui-slider-range").css("background","#c1c93d");
                    $("#slider .ui-slider-handle").css("border-color","#c1c93d");
                    break;
                  case indicators.MODERATE_INDICATOR:
                    $("#slider .ui-slider-range").css("background","#3db4c9");
                    $("#slider .ui-slider-handle").css("border-color","#3db4c9");                     
                      break;
                  case indicators.HIGH_INDICATOR:
                    $("#slider .ui-slider-range").css("background","#729fcf");
                    $("#slider .ui-slider-handle").css("border-color","#729fcf");                     
                      break;
                  case indicators.INTERNAL_TRANSFER_INDICATOR:
                    $("#slider .ui-slider-range").css("background","#3dc999");
                    $("#slider .ui-slider-handle").css("border-color","#3dc999");
                    
                      break;
                  case indicators.NO_TRANSACTION_INDICATOR:
                    $("#slider .ui-slider-range").css("background","#8ae234");
                    $("#slider .ui-slider-handle").css("border-color","#8ae234");                     
                      break;

              }
              toggleSliderLabel(value);
  }

  function calculatePolicyLevel()
  {

      try
      {
          var cntpolicyLevel = 0;

          cntpolicyLevel += ($("input[name='aclCheques']").attr("checked")?transPolicyLevels.ALLOW_CHEQUES:0);
          cntpolicyLevel += ($("input[name='aclIntTransfers']").attr("checked")?transPolicyLevels.ALLOW_INTERNAL_TRANSFERS:0);
          cntpolicyLevel += ($("input[name='aclWires']").attr("checked")?transPolicyLevels.ALLOW_LOCAL_WIRES:0);
          cntpolicyLevel += ($("input[name='aclIntrWires']").attr("checked")?transPolicyLevels.ALLOW_INTERNATIONAL_WIRES:0);
          cntpolicyLevel += ($("input[name='aclStandOrder']").attr("checked")?transPolicyLevels.ALLOW_STANDING_ORDERS:0);
          cntpolicyLevel += ($("input[name='aclCambio']").attr("checked")?transPolicyLevels.ALLOW_CAMBIO:0);
          cntpolicyLevel += ($("input[name='aclEquity']").attr("checked")?transPolicyLevels.ALLOW_EQUITY:0);
          cntpolicyLevel += ($("input[name='umpWireTransfer']").attr("checked")?transPolicyLevels.USER_WIRE_PAYEE:0);
          cntpolicyLevel += ($("input[name='umpChequeEncashment']").attr("checked")?transPolicyLevels.USER_ENCASH_PAYEE:0);
          cntpolicyLevel += ($("input[name='umpInternalTransfer']").attr("checked")?transPolicyLevels.USER_INTERNAL_PAYEE:0);
          cntpolicyLevel += ($("input[name='aclDailyLimitChange']").attr("checked")?transPolicyLevels.USER_DAILY_LIMIT_CHANGE:0);
          cntpolicyLevel += ($("input[name='verUserPrefModification']").attr("checked")?transPolicyLevels.USER_PREF_VERIFICATION:0);
          cntpolicyLevel += ($("input[name='verPayeeWireTrans']").attr("checked")?transPolicyLevels.WIRE_PAYEE_VERIFICATION:0);
          cntpolicyLevel += ($("input[name='verPayeeChequeEncashment']").attr("checked")?transPolicyLevels.ENCASH_PAYEE_VERIFICATION:0);
          cntpolicyLevel += ($("input[name='verPayeeInternalTransfers']").attr("checked")?transPolicyLevels.INTERNAL_PAYEE_VERIFICATION:0);

          return cntpolicyLevel;
      }catch(e)
      {

        alert(e.message);
      }
      return -1;
  }

   function showPolicyDescriptions()
   {
       showSection("policy-descriptions",true);
       $("#slider-container").removeClass("hide");
   }

   function showTransactionPolicyLevel()
   {
       showSection("transaction-policy-container",true);
       $("#slider-container").addClass("hide");
   }
      // Show Section
    function showSection(id,forward) {
        var lastId,elm,ani

          
        lastId = this.lastId ? this.lastId : 'policy-descriptions';
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


        this.lastId = id;

    }

    // Show Section
    function showUPSection(id,forward) {
        var lastId,elm,ani


        lastId = this.uplastId ? this.uplastId : 'upPreferences';
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

    function canChangeSlider(policyLevel)
    {
        
        try
        {
            
            if(initialLevelIndex == -1 || initialLevelIndex == policyLevel)
                return true;
            if(sliderIntervals.CUSTOM == initialLevelIndex )
                return true;
           // var isCROWhiteListSet = $("input[name='aclCROWhiteList']").attr("checked");
            
            if( sliderIntervals.MODERATE ==initialLevelIndex &&
                       ( sliderIntervals.BASIC == policyLevel ||
                        sliderIntervals.CUSTOM == policyLevel)
                     )
                return true;
            else
                if((sliderIntervals.HIGH == initialLevelIndex ||
                sliderIntervals.INTERNAL_TRANSFER == initialLevelIndex ||
                 sliderIntervals.NO_TRANSACTION == initialLevelIndex)&&
                     (sliderIntervals.HIGH == policyLevel ||
                sliderIntervals.INTERNAL_TRANSFER == policyLevel ||
                 sliderIntervals.NO_TRANSACTION == policyLevel))
                    return true;
                else
                    if(sliderIntervals.CUSTOM == policyLevel )
                        return false;
                else
                    if( (sliderIntervals.CUSTOM != initialLevelIndex) && initialLevelIndex < policyLevel)
                        return true;
            

        }catch(e)
        {

        }
        return false;
    }


  function upInit(policyLevel)
  {
      try{
          initialLevelIndex = policyLevel;
         slideSlider(policyLevel);
        
      }catch( e)
      {

      }
  }


   Raxan.ready(function(){
                $.fn.mlCheckbox = function(options) {
                    var activeElm;
                    var tipmsg = Raxan.getVar("lock-tooltip");

                    var tip = (options) ? options.tip : tipmsg;
                    if (!this.data('mlChkbox-init')) {
                        var html = '<div id="mlChkBoxLock" class="acl-lock" title="'+tip+'">' +
                            '<img src="views/images/lock.png" alt="'+tip+'" width="16" height="16" />' +
                            '</div>'
                        $('body').append(html);
                        $('#mlChkBoxLock').bind('click',function(e){
                            var v, orig, inp,hidinp, elm = $(activeElm);
                            inp = $('input[type=checkbox]',activeElm);
                            hidinp = $('input[type=hidden]',activeElm);
                            v = inp.val(); orig = inp.attr('data-orig-value');
                            if (!orig && (v=='1'||v=='0')) {
                                elm.addClass('aclDisabled');
                                $('img',this).attr('src','views/images/lock_open.png');
                                inp.attr('disabled','disabled').attr('data-orig-value',v) ;
                                hidinp.attr('data-orig-value',v) ;
                                if (v=='0') v = '2'; else if (v=='1') v = '3';
                                inp.val(v);
                                hidinp.val(v);
                            }
                            else if (orig=='1'||orig=='0') {
                                elm.removeClass('aclDisabled');
                                $('img',this).attr('src','views/images/lock.png');
                                inp.removeAttr('disabled')
                                   .removeAttr('data-orig-value')
                                   .val(orig);
                                hidinp.removeAttr('data-orig-value')
                                   .val(orig);

                            }
                        });
                    }
                    this.each(function(){
                        var elm = $(this)
                        elm.addClass('inline-block');
                        elm.bind('click', function(e){
                            var v,checked,inp = $('input',this);
                            v = inp.val(); checked = inp.get(0) && inp.get(0).checked;
                            if (checked && v=='0') inp.val('1');
                            else if (!checked && v=='1') inp.val('0');
                        });
                        //insert hidden field to store value
                        inp = $('input',this);
                        var  hidElem = document.createElement("input");
                        hidElem.type = "hidden";
                        hidElem.value = inp.val();
                        hidElem.id = "hid_"+( inp.attr("id")? inp.attr("id"): inp.attr("name"));
                        hidElem.name = "hid_"+( inp.attr("id")? inp.attr("id"): inp.attr("name"));
                        $(hidElem).appendTo(this);
                        // end insert of hidden field

                        elm.bind('mouseenter mouseleave',function(e){
                            var val, orig, inp, elm = $(this);
                            inp = $('input',this);
                            val = inp.val();
                            orig = inp.attr('data-orig-value')
                            if (!orig && (val=='2'||val=='3')) return;
                            if (e.type=='mouseenter') {
                                activeElm = this;
                                elm.addClass('aclHover');
                                $('#mlChkBoxLock img').attr('src','views/images/' + (orig ? 'lock_open.png':'lock.png'));
                                $('#mlChkBoxLock')
                                    .appendTo(elm)
                                    .position({
                                        my: 'right',
                                        at :'right',
                                        of: elm
                                    });
                            }
                            else {
                                activeElm = null;
                                elm.removeClass('aclHover');
                                $('#mlChkBoxLock')
                                    .appendTo($('body'))
                                    .css('top',-1000);
                            }
                        })
                    })
                }



                // usage
                $('.acl').mlCheckbox({
                    tip: Raxan.getVar('lock-tip')
                });

           //$("input:disabled").parent().addClass("aclDisabled");

          


          $("#prefResetbtn").bind("togglecontent", function(event,mode){
              if(mode =="on")
                  {
                      location.reload(true);
                  }
          }); // reset user preferences
        // validate login form locally before sending to server
        $("#prefSavebtn").bind('togglecontent',function(event,mode) {
            if (mode=='on') {

            }
            else {
                var result = Raxan.getVar("verify");
                if(result == "success")
                {
                    showOverview();
                }

            }
        });// save user preferences

        $("#prefContinuebtn").bind('togglecontent',function(event,mode) {
            if (mode=='on') {

            }
            else {

            }
        });// show security verification  user preferences

        $("#svCancelbtn").bind('togglecontent',function(event,mode) {
            if (mode=='on') {
                showUPSection("upPreferences");
            }
            else {

            }
        });// cancel security verification  user preferences

        $("#svSavebtn").bind('togglecontent',function(event,mode) {
            if (mode=='on') {

            }
            else {

                    var result = Raxan.getVar("verify");
                    if(result == "success")
                    {
                        showOverview();
                    }
            }
        });// verify security verification  user preferences

            })


   function clearValues()
   {

       $("#emVerifyCode").val("");
       $("#secPIN").val("");
       $("#questans1").val("");
       $("#questans2").val("");
       
   }


  </script>


<div id="upPreferences" name="upPreferences" class="upPreferences round bold-border-outline user-profile-preferences">
  <div  class="clear user-preferences-user-profile ttm">
       <div class="ui-section-heading bold" langid="section.heading.user.profile">User Profile</div>
       <div class="">
           <label langid="user.profile.user.name">User Name:</label><strong><span id="upUserName" name="upUserName">TestUser2</span></strong>
       </div>
       <div class="" id="upChangeProfiles">
           <button id="upChangeName" name="upChangeName" xt-bind="#click" onclick ="javascript:showChangeUserName()" langid="user.profile.change.name">Change Name</button>
           <button id="upChangePassword" name="upChangePassword" xt-bind="#click" onclick="javascript:showChangePWD()" langid="user.profile.change.password">Change Password</button>
           <button id="upChangePIN" name="upChangePIN" xt-bind="#click" onclick="javascript:showChangePIN()" langid="user.profile.change.pin">Change PIN</button>
           <button id="upChangeQuestions" name="upChangeQuestions" xt-bind="#click" onclick="javascript:showChangeSQ()" langid="user.profile.change.questions">Change Questions</button>
       </div>
       <div class="">
           <label langid="user.profile.last.login">Last Login IP Address:</label><span id="upLastLogin" name="upLastLogin">192.168.1.1</span><span> | </span><span langid="user.profile.view.history" id="upViewHistory" name="upViewHistory">View History</span>
       </div>
     </div>


  <form name="webuserpreferences" id="webuserpreferences" action="" method="post">
    <div class="user-preferences-transaction-policy" >
        <div class="ui-section-heading bold" langid="section.heading.transaction.policy">Transaction Policy</div>
        <div class="left-panel left">
            <div id="slider-container" class="ui-widget-content ltm ui-slider-container round" >
                <div id="slider"></div>
                <div id="custom-indicator" class="ui-slider-indicator">
                    <div id="indicator" class=" ui-index-slider "></div>
                    <span id="label" class="ui-slider-label">Custom</span>
                </div>
                <div id="unrestricted-indicator" name="unrestricted-indicator" class="ui-slider-indicator">
                    <div id="indicator" class=" ui-index-slider "></div>
                    <span id="label" class="ui-slider-label">Basic</span>
                </div>
                <div id="moderate-indicator" class="ui-slider-indicator">
                    <div id="indicator" class=" ui-index-slider "></div>
                    <span id="label" class="ui-slider-label">Moderate</span>
                </div>
                <div id="high-indicator" class="ui-slider-indicator">
                    <div id="indicator" class=" ui-index-slider "></div>
                    <span id="label" class="ui-slider-label">High</span>
                </div>
                <div id="strict-indicator" class="ui-slider-indicator">
                    <div id="indicator" class=" ui-index-slider "></div>
                    <span id="label" class="ui-slider-label">Internal Transfer</span>
                </div>
                <div id="lockout-indicator" class="ui-slider-indicator">
                    <div id="indicator" class=" ui-index-slider "></div>
                    <span id="label" class="ui-slider-label">No Transactions</span>
                </div>

            </div>
            <input type="hidden" id="hid_transPolicy" name="hid_transPolicy" />
       </div>
        <div class="right-panel right ">
           <div class="transaction-policy-container hide border-outline round">
            <div class="policy-row clear">
                <div  class="policy-col left">
                    <div class="policy-title bold" langid="transaction.policy.section.title.transactions">Transactions</div>
                    <ul>
                        <li><span class="acl" id="spaclCheques" name="spaclCheques"><input id="aclCheques" name="aclCheques" type="checkbox"/><label langid="transaction.policy.allow.cheque.encashment">Allow Cheque Enhancement</label></span></li>
                        <li><span class="acl" id="spaclIntTransfers" name="spaclIntTransfers"><input id="aclIntTransfers" name="aclIntTransfers" type="checkbox"/><label langid="transaction.policy.allow.internal.transfer">Allow Internal Transfers</label></span></li>
                        <li><span class="acl" id="spaclWires" name="spaclWires"><input id="aclWires" name="aclWires" type="checkbox"/><label langid="transaction.policy.allow.local.wires">Allow Local Wires</label></span></li>
                        <li><span class="acl" id="spaclIntrWires" name="spaclIntrWires"><input id="aclIntrWires" name="aclIntrWires" type="checkbox"/><label langid="transaction.policy.allow.internaltional.wires">Allow International Wires</label></span></li>
                        <li><span class="acl" id="spaclCambio" name="spaclCambio"><input id="aclCambio" name="aclCambio" type="checkbox"/><label langid="transaction.policy.allow.cambio.transactions">Allow Cambio Transactions</label></span></li>
                        <li><span class="acl" id="spaclStandOrder" name="spaclStandOrder"><input id="aclStandOrder" name="aclStandOrder" type="checkbox"/><label langid="transaction.policy.allow.standing.orders">Allow Standing Order</label></span></li>
                        <li><span class="acl" id="spaclEquity" name="spaclEquity"><input id="aclEquity" name="aclEquity" type="checkbox"/><label langid="transaction.policy.allow.equity.trades">Allow Equity Trades</label></span></li>
                    </ul>
                </div>
                <div class="policy-col right">
                    <div class="policy-title bold" langid="transaction.policy.section.title.user.managed.payees">User Managed Payees</div>
                    <ul>
                        <li><span class="acl" id="spumpWireTransfer" name="spumpWireTransfer"><input id="umpWireTransfer" name="umpWireTransfer" type="checkbox"/><label langid="transaction.policy.user.managed.payees.wire.transfer">Wire Transfer</label></span></li>
                        <li><span class="acl" id="spumpChequeEncashment" name="spumpChequeEncashment"><input id="umpChequeEncashment" name="umpChequeEncashment" type="checkbox"/><label langid="transaction.policy.user.managed.payees.cheque.encashment">Cheque Encashment</label></span></li>
                        <li><span class="acl"  id="spumpInternalTransfer" name="spumpInternalTransfer"><input id="umpInternalTransfer" name="umpInternalTransfer" type="checkbox"/><label langid="transaction.policy.user.managed.payees.internal.transfer">Internal Transfer</label></span></li>

                    </ul>
                    <div class="user-notice highlight-bg">JMMB managed Payees are handled via Customer Care Service.</div>
                </div>
            </div>
            <div class="policy-row clear ttm">
                <div class=" policy-col left">
                    <div class="policy-title bold" langid="transaction.policy.section.title.security.verification">Security Verification</div>
                    <ul>
                        <li><span class="acl" id="spverUserPrefModification" name="spverUserPrefModification"><input id="verUserPrefModification" name="verUserPrefModification" type="checkbox"/><label langid="transaction.policy.verify.user.preference.modifications">Verify User Preference modifications</label></span></li>
                        <li><span class="acl" id="spverPayeeWireTrans" name="spverPayeeWireTrans"><input id="verPayeeWireTrans" name="verPayeeWireTrans" type="checkbox"/><label langid="transaction.policy.verify.payee.for.wire.transfer">Verify payee for Wire Transfer</label></span></li>
                        <li><span class="acl" id="spverPayeeChequeEncashment" name="spverPayeeChequeEncashment"><input id="verPayeeChequeEncashment" name="verPayeeChequeEncashment" type="checkbox"/><label langid="transaction.policy.verify.payee.for.cheque.encashment">Verify payee for Cheque Encashment</label></span></li>
                        <li><span class="acl" id="spverPayeeInternalTransfers" name="spverPayeeInternalTransfers"><input id="verPayeeInternalTransfers" name="verPayeeInternalTransfers" type="checkbox"/><label langid="transaction.policy.verify.payee.for.internal.transfers">Verify payee for Internal Transfers</label></span></li>

                    </ul>
                </div>
                <div class="policy-col right">
                    <div class="policy-title bold" langid="transaction.policy.section.title.other">Other</div>
                    <ul>
                        <li><span class="acl" id="spaclDailyLimitChange" name="spaclDailyLimitChange"><input id="aclDailyLimitChange" name="aclDailyLimitChange" type="checkbox"/><label langid="transaction.policy.allow.daily.limit.change">Allow Daily Limit Change</label></span></li>
                    </ul>
                </div>
               <div class="ttm clear">
                   <button class="right" langid="" onclick="showPolicyDescriptions(); return false;" style="margin-right: 20px;">&nbsp;Back&nbsp;</button>
               </div>
            </div>

        </div>
           <div  class="policy-descriptions">
                        <div id="custom-description" class="hide">
                            <div class="title bold" langid="transaction.policy.description.custom.title">Custom</div>
                            <div class="" langid="transaction.policy.description.custom">Use this screen to customize your transaction policy options</div>
                        </div>
                        <div id="unrestricted-description" class="hide">
                            <div class="title bold" langid="transaction.policy.description.basic.title">Basic</div>
                            <div class="" langid="transaction.policy.description.basic">Disable security verification when updating records and preferences. Allow user to dynamically create payees without verification.</div>
                        </div>
                        <div id="moderate-description" class="hide">
                            <div class="title bold" langid="transaction.policy.description.moderate.title">Moderate</div>
                            <div class="" langid="transaction.policy.description.moderate">Enable security verification when adding/updating wire transfer payees and user preferences. Allow user to create payees.</div>
                        </div>
                        <div id="high-description" class="hide">
                            <div class="title bold" langid="transaction.policy.description.high.title">High</div>
                            <div class="" langid="transaction.policy.description.high">Managed payee white-list. White-list payees can only be modified via customer care. Policy level can only be upgraded by user or change via customer care. </div>
                        </div>
                        <div id="strict-description" class="hide">
                            <div class="title bold" langid="transaction.policy.description.internal.transfer.title">Internal Transfer</div>
                            <div class="" langid="transaction.policy.description.internal.transfer">Only internal transfers to manage white-list payees are allowed. White-list payees can only be modified via JMMB customer care. Policy level can only be upgraded by user or changed via customer care.</div>
                        </div>
                        <div id="lockout-description" class="hide">
                            <div class="title bold" langid="transaction.policy.description.no.transaction.title">No Transaction</div>
                            <div class="" langid="transaction.policy.description.no.transaction">Disable all transactions. Policy level can only be changed via JMMB customer care.</div>
                        </div>
                        <div id="cutomizedbtncnt" class="hide ttm">
                            <button  id="cutomizedbtn" name="cutomizedbtn" class="" langid="transaction.policy.description.button" onclick="showTransactionPolicyLevel(); return  false;" >Customize</button>
                        </div>

                    </div>
        </div>
       

   </div><!-- end user preferences transaction policy -->
    <div  class="highlight-bg dlyTransLimit ttm clear round" >
            <div class="policy-col left">
                <div><span class="" langid="transaction.policy.daily.transaction.limit">Daily Transaction Limit</span> (<span id="dtlCurrency" name="dtlCurrency">JA$</span>)</div>
                <input type="text" size="30" id="dlyTransactionLimit" name="dlyTransactionLimit"/><br/>
                <label class="" langid="transaction.policy.email.transaction.receipts">Email Transaction Receipts:</label><span id="stEmailTransReceipts" name="stEmailTransReceipts" class="show-on bold">ON</span>
            </div>
            <div class="policy-col right" style="width:280px;">
                <span class="" langid="transaction.policy.current.usage">Current Usage:</span><br/>
                <span class="bold" id="atmCurrentUseage" name="atmCurrentUseage">JA$ 10,500.00</span>
            </div>
        </div>
   <div  class="clear user-preferences-home-page-setup ttm">
       <div class="ui-section-heading bold" langid="section.heading.home.page.setup">Home Page Setup</div>
       <div class="policy-col left">
            <ul>
                <li><input id="shAccountSummary" name="shAccountSummary" type="checkbox"/><label langid="home.page.setup.show.account.summary">Show Account Summary</label></li>
                <li><input id="shMessages" name="shMessages" type="checkbox"/><label langid="home.page.setup.show.messages">Show Messages</label></li>
                <li><input id="shPrintStatements" name="shPrintStatements" type="checkbox"/><label langid="home.page.setup.show.print.statements">Show Print Statements</label></li>
                <li><input id="shExpressRequests" name="shExpressRequests" type="checkbox"/><label langid="home.page.setup.show.express.requests">Show Express Requests</label></li>

            </ul>

       </div>
       <div class="policy-col right" style="width:280px;">
             <ul>
                 <li><label langid="home.page.setup.account.summary.details">Account Summary Details:</label><input id="rdAccountSummaryDetails" name="rdAccountSummaryDetails" type="radio" value="0"/><label langid="home.page.setup.account.summary.details.hide">Hide</label><input id="rdAccountSummaryDetails" name="rdAccountSummaryDetails" type="radio" value="1"/><label langid="home.page.setup.account.summary.details.show">Show</label></li>
                 <li><label langid="home.page.setup.account.summary.view">Account Summary View:</label><input id="rdAccountSummaryView" name="rdAccountSummaryView" style="margin-left:18px;" type="radio" value="0"/><label langid="home.page.setup.account.summary.view.grid">Grid</label><input id="rdAccountSummaryView" name="rdAccountSummaryView" type="radio" value="1" style="margin-left:8px;"/><label langid="home.page.setup.account.summary.view.chart">Chart</label></li>
                 <li><label langid="home.page.setup.default.no.transactions">Default no. Transactions:</label><select id="selNoofTrnx" name="selNoofTrnx"><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="20">20</option><option value="30">30</option><option value="40">40</option><option value="50">50</option><option value="100">100</option><option value="200">200</option></select></li>
                <li><label langid="home.page.setup.display.current.totals">Display current for totals:</label><select id="selDisCurrTotals" name="selDisCurrTotals"><option value="{0}">{0} ({1}:1)</option></select></li>

            </ul>

       </div>
   </div>
  <div  class="clear user-preferences-account-setup ttm">
       <div class="ui-section-heading bold" langid="section.heading.account.setup">Account Setup</div>
       <div class="policy-col left">
            <ul>
                <li><input id="acUseTransWizard" name="acUseTransWizard" type="checkbox"/><label langid="account.setup.use.transaction.wizard">Use Transaction Wizard</label></li>
                <li><span class="acl" id="spacEnableBroRegist" name="spacEnableBroRegist"><input id="acEnableBroRegist" name="acEnableBroRegist" type="checkbox"/><label langid="account.setup.enable.browse.registration">Enable Browse Registration</label></span></li>
                <li><label langid="account.setup.default.branch">Default Branch</label><br/><select id="selDefaultBranch" name="selDefaultBranch"><option value="{0}">{2}</option></select></li>
                <li><label langid="account.setup.default.account.type">Default Account Type</label><br/><select id="selDefaultAccountType" name="selDefaultAccountType"><option value="{priorityCode}">{displayDescription}</option></select></li>

            </ul>

       </div>
       <div class="policy-col right" style="width:280px;">
             <ul>
                 <li><label langid="account.setup.pension.view">Pension View:</label><input id="rdPensionViewDetails" name="rdPensionViewDetails" type="radio" value="1"/><label langid="account.setup.pension.view.details">Details</label><input id="rdPensionViewDetails" name="rdPensionViewDetails" type="radio" value="0"/><label langid="account.setup.pension.view.summary">Summary</label></li>
                <li><span class="acl" id="spacMaskAcNo" name="spacMaskAcNo"><input id="acMaskAcNo" name="acMaskAcNo" type="checkbox"/><label langid="account.setup.mask.account.number">Mask Account Number</label></span></li>
                <li><label langid="account.setup.default.trade.terms">Default Trade Terms</label><br/><select id="selDefaultTradeTerms" name="selDefaultTradeTerms"><option value="{Code}">{CodeDesc}</option></select></li>
                <li><label langid="account.setup.cell.phone.no">Cell Phone #</label><br/><input id="acCellPhoneNo" name="acCellPhoneNo" type="text" size="30"/></li>
                <li><label langid="account.setup.cell.phone.provider">Cell Phone Provider</label><br/><select id="selCellPhoneProvider" name="selCellPhoneProvider"><option value="{id}">{providerName}</option></select></li>

            </ul>

       </div>
       <div class="clear"><label langid="account.setup.default.account">Default Account</label><br/><select id="selDefaultAccount" name="selDefaultAccount"><option value="{AccountNo}">{AccountNo} - {AccountName}</option></select></div>

  </div>
    <div class="buttonbar clear" style="margin-top:15px;width:600px; border-top: 1px dotted  grey;height:40px;" >
    <button  class="ctrl button default right tpm btm rtm" type="submit" name="prefSavebtn" id="prefSavebtn" xt-bind="#click,savePreferences,#webuserpreferences,#webuserpreferences .ctrl">
        <img src="views/images/loader.gif" alt="." class="hide" style="margin-right:5px;"/><span langid="user.profile.button.save" style="vertical-align:middle">&nbsp;Save&nbsp;</span>
    </button>
    <button  class="ctrl button default right tpm btm rtm" type="submit" name="prefContinuebtn" id="prefContinuebtn" xt-bind="#click,showSecurityVerification,#webuserpreferences,#webuserpreferences .ctrl">
        <img src="views/images/loader.gif" alt="." class="hide" style="margin-right:5px;"/><span langid="user.profile.button.continue" style="vertical-align:middle">&nbsp;Continue&nbsp;</span>
    </button>
     <button  class="ctrl button default right tpm btm rtm" type="submit" name="prefResetbtn" id="prefResetbtn" xt-bind="#click" langid="user.profile.button.reset" >Reset</button>
    </div>

</form>
</div>
   
   <div class="hide bold-border-outline round" id="viewHistoryContainer" name="viewHistoryContainer">
       <div class="clear" id="viewHistory" name="viewHistory" >
           <h3 langid="user.profile.view.history.msg">Last Successful login(s)</h3>
           <span style="left:50px;font-weight:bold;" langid="user.profile.view.history.ip.address">IP Address</span><span style="left:100px;font-weight:bold;" langid="user.profile.view.history.date"> Date</span>
           <ul id="lstHistory" name="lstHistory">
               <li><span style="width:100px;">{remoteIP}</span><span>{dtstamp}</span> </li>
           </ul>
       </div>
  </div>

    <div id="upsecurityVerification" class="upsecurityVerification hide user-profile-security-verification clear bold-border-outline round rax-box alert" style="background-image:none;">
        <div  class="ui-section-heading bold box-title" langid="user.profile.security.verification.title" style="background-image:none;">User Profile - Security Verification</div>
        <p langid="security.questions.lookup.msg">An email verification was sent to your email account. Please enter the verification code below</p>
        <p class="bold" langid="user.profile.verification.msg">User Profile Verification</p>
        <form class="" name="webupsecurityVerification" id="webupsecurityVerification" action="" method="post">
           <div class="policy-col left">
                <ul>
                    <li><input id="secPIN" name="secPIN" type="password" class="textbox ctrl" maxlength="4"/><label langid="user.profile.security.pin">Security PIN</label></li>
                </ul>

           </div>
           <div class="policy-col right" style="width:380px;">
                 <ul>
                     <li><input id="emVerifyCode" name="emVerifyCode" type="password" class="textbox"/><label langid="user.profile.email.verification.code">Email verification Code</label><label> | </label><span langid="user.profile.resend.email" xt-bind="#click,sendVerificationCode" style="color:blue;text-decoration: underline;cursor: pointer;">Resend Email</span></li>
                </ul>
           </div>

            <div class="clear">
                <label langid="user.profile.security.question.1">Security Question #1: </label><span id="question1" name="question1"></span><br>
                <input class="ctrl textbox" type="password" name="questans1" id="questans1" value="" size="100"/><br />
                <label langid="user.profile.security.question.2">Security Question #2: </label><span id="question2" name="question2"></span><br>
                <input class="ctrl textbox" type="password" name="questans2" id="questans2" value="" size="100"/><br />
                <br class="clear tpm"/>
                <hr class="clear tpm bmm" style=""/>
                <div class="buttonbar clear" style="height:40px;" >
                    <button class="button default right tpm rtm" type="submit" name="svSavebtn" id="svSavebtn" xt-bind="#click,verifySecurity,#webupsecurityVerification,#webupsecurityVerification .ctrl ">
                        <img src="views/images/loader.gif" alt="." class="hide" style="margin-right:5px;"/><span langid="user.profile.security.verification.save.button" style="vertical-align:middle">&nbsp;Save&nbsp;</span>
                    </button>
                    <button class="button default right tpm rtm" type="submit" name="svCancelbtn" id="svCancelbtn" xt-bind="#click ">
                        <img src="views/images/loader.gif" alt="." class="hide" style="margin-right:5px;"/><span langid="user.profile.security.verification.cancel.button" style="vertical-align:middle">&nbsp;Cancel&nbsp;</span>
                    </button>
                </div>
            </div>
        </form>
    </div>


<script type="text/javascript">

    //$("#slider").slider("option","value",80);
</script>

    