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


    ul.sqlist li{ margin-left: -15px; margin-top:5px;list-style-type: decimal;
                  font-weight: bold; }

    ul.sqlist input{display:inline; width: 150px;  }
    ul.sqlist .confirm{margin-left: 40px;}

    .ui-button { margin-left: -1px; }
    .ui-button-icon-only .ui-button-text { padding: 0.35em; }
    .ui-autocomplete-input { margin: 0; padding: 0;/*.48em 0 0.47em 0.45em;*/ }
    .hide {display:none;}
    .sqlist-container {height:auto;overflow: auto;}
    .highlight {background-color: yellow!important;}

  </style>

<!--[if ! IE]><!-->
<style type="text/css">

    
    ul.sqlist .ui-autocomplete-input{ width:440px; height:26px;}
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

    
    ul.sqlist .ui-autocomplete-input{ width:440px; height:28px; position:relative; top:-6px;}
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



        $('#seqquesansnewbtn').bind('togglecontent',function(event,mode) {
            var  msg,classname='.sqlist-widget',
                ansnameTagPrefix = '#questansnew',
                ansconfirmnameTagPrefix ="#questconfirmansnew",
                ansname="",ansconfirmname="";
            if (mode=='on') {



                $(classname).each(function(index){

                    ansname= ansnameTagPrefix+(index+1);
                    ansconfirmname= ansconfirmnameTagPrefix+(index+1);
                    if($(this).children().attr('selected') == true)
                    {
                        msg = Raxan.getVar('select-security-question');
                        $(ansname).addClass('highlight');
                        $(ansname).focus();
                        return false;
                    }else
                    {
                        if(jQuery.trim($(ansname).val()).length != 0)
                            $(ansname).removeClass('highlight');
                        else
                        {

                            msg = Raxan.getVar('missing-security-question-answer');
                            $(ansname).addClass('highlight');
                            $(ansname).focus();
                            return false;
                        }

                        if(jQuery.trim($(ansconfirmname).val()).length != 0)
                            $(ansconfirmname).removeClass('highlight');
                        else
                        {

                            msg = Raxan.getVar('security.confirm.answer-missing');
                            $(ansconfirmname).addClass('highlight');
                            $(ansconfirmname).focus();
                            return false;
                        }

                        if(jQuery.trim($(ansconfirmname).val()) !=
                         jQuery.trim($(ansname).val()))
                        {
                            msg = Raxan.getVar('security.confirm.answer-mismatch');
                            $(ansname).val("");
                            $(ansconfirmname).val("");
                            $(ansname).addClass('highlight');
                            $(ansname).focus();
                            return false;

                        }



                    }
                    //return false;
                })
                // showMessage($(classname).length);

                if (!msg) {
                    $('#seqquesansnewbtn').blur();
                    $(' #websecurityquestionsNEW img').fadeOut('fast');
                    $('#seqquesansnewbtn img').show();
                    $('.langbar a,#tipbtn').attr('disabled','disabled');
                }
                else {
                    showErrorMessage(msg);
                    event.preventDefault();
                    event.stopImmediatePropagation();

                    return false;
                }


            }else
            {// mode is off

                $('#seqquesansnewbtn').show();
                $(' #websecurityquestionsNEW img').fadeIn('fast');
                $('#seqquesansnewbtn img').hide();
                $('.langbar a,#tipbtn ').attr('disabled','');

                clearValues();

                return false;



            }



        }) //New or Update Security question binding




        $('#changepinbtn').bind('togglecontent', function(event,mode)
        {

            if (mode=='on') {
                var  msg, pin = $('#pinNew'),
                retypepin = $('#retypepin'),
                oldpin = $('#pinOld');
                var minpwdlength = 4;



                if ($.trim(oldpin.val())=="")	{
                    msg = Raxan.getVar('old-pin-missing');
                    $(oldpin).addClass('highlight');
                    oldpin.focus();
                }else
                    if ($.trim(pin.val())=="")	{
                        msg = Raxan.getVar('pin-missing');
                        $(pin).addClass('highlight');
                        pin.focus();//
                    }else
                    if (! isNumeric($.trim(pin.val())))	{
                        msg = Raxan.getVar('pin-not-numeric');
                        pin.addClass('highlight');

                        pin.focus();//
                    }else
                    if ($.trim(pin.val()).length < minpwdlength)	{
                        msg = Raxan.getVar('min-pin-length');
                        $(pin).addClass('highlight');
                        pin.focus();
                    }else
                    if ($.trim(retypepin.val())=="")	{
                        msg = Raxan.getVar('retype-pin-missing');
                        $(retypepin).addClass('highlight');
                        retypepin.focus();
                    }else

                if ($.trim(retypepin.val())!= $.trim(pin.val()))	{
                    msg = Raxan.getVar('pin-mismatched');
                    $(pin).addClass('highlight');
                    pin.focus();
                }


            if (!msg) {
                $('#changepinbtn').blur();
                $(' #webchangepin img').fadeOut('fast');
                $('#changepinbtn img').show();
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
            var  msg, pin = $('#pinNew'),
            retypepin = $('#retypepin'),
            oldpin = $('#pinOld');

            clearValues();

            $('#changepinbtn').show();
            $(' #webchangepin img').fadeIn('fast');
            $('#changepinbtn img').hide();
            $('.langbar a,#tipbtn').attr('disabled','');

        }

        })///  New or Update change PIN binding



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

     //security questions
    var  classname='.sqlist-widget',
        ansnameTagPrefix = '#questansnew',
        ansconfirmnameTagPrefix ="#questconfirmansnew",
        ansname="",ansconfirmname="";

     $(classname).each(function(index){

        ansname= ansnameTagPrefix+(index+1);
        ansconfirmname= ansconfirmnameTagPrefix+(index+1);
        $(ansconfirmname).val("");
        $(ansname).val("");
    });

    $(".ui-autocomplete-input").each(function(index){
        $(this).val("Select a question...");
    });



    $("#emVerifyCode").val("");
    $("#secPIN").val("");
    $("#questans1").val("");
    $("#questans2").val("");

   }


    //
  </script>



<div id="upPreferences" name="upPreferences" class="upPreferences round bold-border-outline user-profile-preferences">
 
    <div id="changepin" class="hide">
        <h2  class="ui-section-heading bold" langid="change.pin.lookup">Change PIN</h2>
        <strong><p langid="change.pin.msg">Enter new PIN.</p></strong>
        <form class="" name="webchangepin" id="webchangepin" action="" method="post">
            <label langid="change.pin.old.name">Old PIN:</label><input  tabindex="1" class="ctrl textbox pin-size" type="password" name="pinOld" id="pinOld" value="" size="4" maxlength="4"/><br />
            <label langid="change.pin.name">PIN:</label><input  tabindex="2" class="ctrl textbox pin-size" type="password" name="pinNew" id="pinNew" value="" size="4" maxlength="4"/><br/>
            <label langid="change.pin.retype">Retype PIN:</label><input tabindex="3" class="ctrl textbox pin-size" type="password" name="retypepin" id="retypepin" value="" size="4" maxlength="4"/>
            <hr class="clear " style="margin-top:0px;"/>
            <div class="buttonbar" style="height:40px;" >
                <button class="button default right tpm btm rtm" type="submit" name="changepinbtn" id="changepinbtn" xt-bind="#click,showSecurityVerification,#webchangepin, #webchangepin .ctrl" >
                    <img src="views/images/loader.gif" alt="." class="hide" style="margin-right:5px;"/><span langid="user.profile.button.save" style="vertical-align:middle">&nbsp;Submit&nbsp;</span>
                </button>
                <button  class="ctrl button  right tpm btm rtm" type="submit" name="prefResetbtn" id="prefResetbtn" xt-bind="#click" langid="user.profile.button.reset" >Reset</button>
            </div>
        </form>
    </div>


    <div id="securityquestionsNEW" class=" ">
        <h2  class=" ui-section-heading bold" langid="security.questions.new.title">Security Questions</h2>
        <strong><p style="margin-left:15px;" langid="security.questions.new.lookup.msg">Give an answer to each security questions</p></strong>
        <form class="" name="websecurityquestionsNEW" id="websecurityquestionsNEW" action="" method="post">

            <div  class="sqlist-container">

                <ul  class="sqlist">
                    <li id="li-sqlist-widget1" name ="li-sqlist-widget1" class=" ">
                        <div class="ui-widget">
                            <select  id="sqlist1" name="sqlist1">
                                <option value="{id}" >{question}</option>
                            </select>
                        </div>
                        <span langid="security.questions.new.label.answer">Answer:</span><input class="ctrl  ltm"  type="password" name="questansnew1" id="questansnew1" value=""/>
                        <span class="confirm" langid="security.questions.new.label.confirm.answer">Confirm:</span><input class="ctrl  ltm"  type="password" name="questconfirmansnew1" id="questconfirmansnew1" value=""/><br />
                    </li>
                    <li id="li-sqlist-widget2" name="li-sqlist-widget2" class=" ">
                        <div class="ui-widget">
                            <select  id="sqlist2" name="sqlist2">
                                <option value="{id}" >{question}</option>
                            </select>
                        </div>
                        <span langid="security.questions.new.label.answer" >Answer:</span><input class="ctrl ltm" type="password" name="questansnew2" id="questansnew2" value="" />
                        <span class="confirm" langid="security.questions.new.label.confirm.answer">Confirm:</span><input class="ctrl  ltm"  type="password" name="questconfirmansnew2" id="questconfirmansnew2" value=""/><br />
                    </li>
                    <li id="li-sqlist-widget3" name="li-sqlist-widget3" class=" ">
                        <div class="ui-widget">
                            <select  id="sqlist3" name="sqlist3">
                                <option value="{id}" >{question}</option>
                            </select>
                        </div>
                        <span langid="security.questions.new.label.answer" >Answer:</span><input class="ctrl ltm" type="password" name="questansnew3" id="questansnew3" value="" />
                        <span class="confirm" langid="security.questions.new.label.confirm.answer">Confirm:</span><input class="ctrl  ltm"  type="password" name="questconfirmansnew3" id="questconfirmansnew3" value=""/><br />
                    </li>
                    <li id="li-sqlist-widget4" name="li-sqlist-widget4" class=" ">
                        <div class="ui-widget">
                            <select  id="sqlist4" name="sqlist4">
                                <option value="{id}" >{question}</option>
                            </select>
                        </div>
                        <span langid="security.questions.new.label.answer" >Answer:</span><input class="ctrl ltm" type="password" name="questansnew4" id="questansnew4" value="" />
                        <span class="confirm" langid="security.questions.new.label.confirm.answer">Confirm:</span><input class="ctrl  ltm"  type="password" name="questconfirmansnew4" id="questconfirmansnew4" value=""/><br />
                    </li>
                    <li id="li-sqlist-widget5" name="li-sqlist-widget5" class=" ">
                        <div class="ui-widget">
                            <select  id="sqlist5" name="sqlist5">
                                <option value="{id}" >{question}</option>
                            </select>
                        </div>
                        <span langid="security.questions.new.label.answer" >Answer:</span><input class="ctrl ltm" type="password" name="questansnew5" id="questansnew5" value="" /><br />
                        <span class="confirm" langid="security.questions.new.label.confirm.answer">Confirm:</span><input class="ctrl  ltm"  type="password" name="questconfirmansnew5" id="questconfirmansnew5" value=""/><br />
                    </li>
                    <li id="li-sqlist-widget6" name="li-sqlist-widget6" class=" ">
                        <div class="ui-widget">
                            <select  id="sqlist6" name="sqlist6">
                                <option value="{id}" >{question}</option>
                            </select>
                        </div>
                        <span langid="security.questions.new.label.answer" >Answer:</span><input class="ctrl ltm" type="password" name="questansnew6" id="questansnew6" value="" />
                        <span class="confirm" langid="security.questions.new.label.confirm.answer">Confirm:</span><input class="ctrl  ltm"  type="password" name="questconfirmansnew6" id="questconfirmansnew6" value=""/><br />
                    </li>

                </ul>

            </div>

            <hr class="clear bmm" style="margin-top:-10px;"/>
            <div class="buttonbar" style="height:40px;" >
                <button class="button default right tpm btm rtm" type="submit" name="seqquesansnewbtn" id="seqquesansnewbtn" xt-bind="#click,showSecurityVerification,#websecurityquestionsNEW,#websecurityquestionsNEW .ctrl ">
                    <img src="views/images/loader.gif" alt="." class="hide" style="margin-right:5px;"/><span langid="user.profile.button.save" style="vertical-align:middle">&nbsp;Login&nbsp;</span>
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


