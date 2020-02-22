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
    form label                          {display:inline-block;}
    form .textbox                       {width:auto;}

    
     .policy-row                        {height:170px;}
     .left-border                       {border-left: 1px solid #B8D152;}
     .policy-col {
                 width:250px;
                padding-left: 5px;
                position: relative;
                vertical-align: top;
                display:inline-block;}
    
     .policy-col .policy-widget{ left:  5px;position: relative;}
     .policy-col li{ list-style-type: none;}
     .policy-col ul {margin: 0px; padding: 0px;}
    
    .user-notice{width: 200px;}
    


    .ui-section-heading{font-size: 120%;border-bottom: 1px solid #404040;width:100%;margin-bottom: 10px;color:#404040;}
    

    

    .rax-box.info {background-color: lightgrey;color:auto;}


    button{cursor: pointer;}
    .user-profile-preferences       { padding:10px;}


    form#webupsecurityVerification label {width:auto;}

  </style>

<!--[if ! IE]><!-->
<style type="text/css">

    
    .right-panel{margin: 0px;}
    .user-profile-security-verification, .user-profile-preferences {width: 663px; position: relative;}



</style>

<script type="text/javascript">
        function showOverview()
       {
            window.location.href = "app/profile/index.php";
       }
 </script>
<!--<![endif]-->

<!--[if IE]>
<style type="text/css">

    
    .right-panel{margin: 0px;clear:both;}
    .user-profile-security-verification, .user-profile-preferences {width: 580px; position: relative;}


</style>
<script type="text/javascript">
        function showOverview()
       {
            window.location.href = "app/profile/index.php";
       }
    </script>
<![endif]-->


  <script type="text/javascript">


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


   Raxan.ready(function(){

            $("#prefResetbtn").bind("togglecontent", function(event,mode){
              if(mode =="on")
                  {
                      location.reload(true);
                  }
            }); // reset user change password


            


        $('#changeusernamebtn').bind('togglecontent', function(event,mode)
        {

            if (mode=='on') {
                var  msg, username = $('#username');
                
                if ($.trim(username.val())=="")	{
                    msg = Raxan.getVar('username-missing');
                    $(username).addClass('highlight');
                    username.focus();
                }
                


            if (!msg) {
                $('#changeusernamebtn').blur();
                $(' #webchangepin img').fadeOut('fast');
                $('#changeusername img').show();
                $('.langbar a,#tipbtn').attr('disabled','disabled');
            }
            else {
                showErrorMessage(msg);
                event.preventDefault();
                event.stopImmediatePropagation();
                return false;
            }


        }else
        {
            var  msg;

            clearValues();

            $('#changeusernamebtn').show();
            $(' #webchangepin img').fadeIn('fast');
            $('#changeusername img').hide();
            $('.langbar a,#tipbtn').attr('disabled','');

        }

        })///  New or Update change username binding



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

       //change pin
     var username = $('#username');

    username.val("");
    


    $("#emVerifyCode").val("");
    $("#secPIN").val("");
    $("#questans1").val("");
    $("#questans2").val("");

   }


    //
  </script>



<div id="upPreferences" name="upPreferences" class="upPreferences round bold-border-outline user-profile-preferences">
 
    <div id="changeusername" class="">
        <h2  class="ui-section-heading bold" langid="change.username.lookup">Change User Name</h2>
        <strong><p langid="change.username.msg">Enter new User Name.</p></strong>
        <form class="" name="webchangeusername" id="webchangeusername" action="" method="post">
            <label langid="change.user.name.label">User Name:</label><input  tabindex="1" class="ctrl textbox " type="text" name="username" id="username" value="" size="30" /><br/><br/><br/>
            <hr class="clear " style="margin-top:0px;"/>
            <div class="buttonbar" style="height:40px;" >
                <button class="button default right tpm btm rtm" type="submit" name="changeusernamebtn" id="changeusernamebtn" xt-bind="#click,showSecurityVerification,#webchangeusername, #webchangeusername .ctrl" >
                    <img src="views/images/loader.gif" alt="." class="hide" style="margin-right:5px;"/><span langid="user.profile.button.save" style="vertical-align:middle">&nbsp;Submit&nbsp;</span>
                </button>
                <button  class="ctrl button  right tpm btm rtm" type="submit" name="prefResetbtn" id="prefResetbtn" xt-bind="#click" langid="user.profile.button.reset" >Reset</button>
            </div>
        </form>
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


