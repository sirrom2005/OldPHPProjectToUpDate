<style type="text/css">
    .login.container {
        margin-top: 20px;
        color: #404040;
    }
    .login.container legend {
        color:#000;
    }
    .login-panel {
        background: url('views/images/login_panel.png') 0 0 no-repeat;
        width: 397px;
        height: 309px;
        position: relative;
        border:1px solid transparent;
        z-index:1;

    }
    .login-extended-panel {
        background: url('views/images/login_panel_extended.png') 0 0 no-repeat;
        width: 600px;
        height: 380px;
    }
    .login-panel .header {
        color:#fff;
        font-weight: bold;
    }
    .login-panel .content {
        margin: 20px 30px 25px 35px;
        padding-top: 15px;
    }
    .login-panel form {
        margin-left:15px;
    }
    .login-panel p {
        margin: 0 0 10px 0px;
        color: #F9AD81;
    }
    .login-panel .langbar {
        float:right;
        color:#720000;
        margin-top:-18px;
    }
    .login-panel .langbar a { color:#fff; }
    .login-panel .langbar a:hover { color:#FFF0B3; }

    form .section {
        margin-left:90px;
    }
    form label, form span#question1, form span#question2,
    form span#question1FP, form span#question2FP,
    form span#checkquestion1, form span#checkquestion2
    {

        width:90px;
        color:#fff;
        font-weight: bold;
    }
    form .textbox {
        width:215px;
        border-color: #aa0000;
    }
    form hr {
        color: #480000;
        background: #600000;
    }
    form .buttonbar a img {
        vertical-align: baseline;
    }
    form .buttonbar a {
        color:#FFF0B3;
        font-weight: bold;
        line-height: 32px;
    }
    form .button.default {
        border-color: #480000;
    }

    /* Tips */
    .tip {
        background: url('views/images/tip_bg.png') 0 0 repeat-x;
        height:267px;
        width:300px;
        margin: 20px 0 0 -20px;
        padding-left:20px;
    }
    .tip a {
        color:#744B24;
    }
    .tip-rt {
        margin-top: 20px;
    }
    #tipheader.announce {
        color:#EC1A2B;
    }
    #tipheader {
        margin-top: 20px;
        color: #ff8800;
        font-weight: 600
    }
    #tiptitle {
        color:#5F3712
    }

    #tipcontent {
        color: #404040;
        height:130px;
        overflow:auto;
    }
    fieldset {
        border-color:#FFD5D5;
        border-top:0;
    }
    #pin { width:60px; }
    #login, #forgetpwd { position: relative; }

    .password {  border: 1px solid #cc9933 ; font-family:ariel, sans-serif; }
    .pstrength-minchar{font-size:10px;display:none;}

    .pwd-strength-container {padding-left: 5px; background-color: whitesmoke; border: 1px solid grey;}

    .reset-pstrength-bar {border: 1px solid white; font-size: 1px; height: 5px; width: 0px; color:white;}


    ul.sqlist li{ margin-left: -15px; list-style-type: decimal; color:#fff;
                  font-weight: bold; }

    ul.sqlist input{display:inline; width: 150px; }
    ul.sqlist .ui-autocomplete-input{ width:440px;}
    ul.sqlist .confirm{margin-left: 40px;}

    .ui-button { margin-left: -1px; }
    .ui-button-icon-only .ui-button-text { padding: 0.35em; }
    .ui-autocomplete-input { margin: 0; padding: 0;/*.48em 0 0.47em 0.45em;*/ }
    .hide {display:none;}
    .sqlist-container {height:auto;overflow: auto;}
    .highlight {background-color: yellow!important;}
    .pin-size{width:80px!important;}
    .complete-process-tick {list-style-image: url(views/images/tick-bullet.png);}


    /* simple css-based tooltip */
    /*
    .tooltip {
	background-color:#000;
	border:1px solid #fff;
	padding:10px 15px;
	width:200px;
	display:none;
	color:#fff;
	text-align:left;
	font-size:12px;

	/* outline radius for mozilla/firefox only /
	-moz-box-shadow:0 0 10px #000;
	-webkit-box-shadow:0 0 10px #000;
    }*/
</style>


<!--[if ! IE]><!-->
<style type="text/css">
    .sqlistbtn {height:20px;margin-bottom:0px;padding-bottom:0px;bottom:-4px;}

</style>
<!--<![endif]-->

<!--[if IE]>
<style type="text/css">
  .ui-button-icon-only .ui-icon {margin-top:0px!important; margin-left: -3px!important; position:static!important;}
 .sqlistbtn { height:20px;margin-bottom:0px;padding-bottom:0px;position:static!important;}

</style>
<![endif]-->


<script type="text/javascript">


    Raxan.ready(function(){
        $("#fpbackbtn,#securityCodebackbtn,#changepwdbackbtn,#pwdchangedbackbtn,#backbtn,#backbtnFP,#backbtnsqnew,\n\
#changepwdNewbackbtn,#changepinbackbtn").click(function(e)
        {
            loginActions("login");
        } );

        $('#forgetbtn,#backbtn').click(function(e){
            var id = $(this).attr('id');
            if (id!='forgetbtn') {
                showSection('login',true); // show login
            }
            else {
                loginActions("forget password");
                $('#login form input[type="password"]').val(''); // clear passwords
            }

            e.preventDefault();
        })

        // validate login form locally before sending to server
        $("#loginbtn").bind('togglecontent',function(event,mode) {
            if (mode=='on') {
                var msg, usr = $('#username'),
                pwd = $('#password');//, pin = $('#pin');

                if ($.trim(usr.val())=="")	{
                    msg = Raxan.getVar('username-missing');
                    usr.focus();
                }
                else if ($.trim(pwd.val())=="") {
                    msg = Raxan.getVar('password-missing');
                    pwd.focus();
                }

                if (!msg) {
                    $('#loginbtn').blur();
                    $('#loginbtn img').show();
                    $('#forgetbtn').fadeOut('fast');
                    $('.langbar a,#tipbtn').attr('disabled','disabled');
                }
                else {
                    showErrorMessage(msg);
                    event.preventDefault();
                    event.stopImmediatePropagation();
                    return false;
                }
            }
            else {
                $('#loginbtn img').hide();
                $('#forgetbtn').fadeIn('fast');
                $('.langbar a,#tipbtn').attr('disabled','');


                var action = Raxan.getVar('loginaction');

                loginActions(action);
//                var securityQuestions = Raxan.getVar('securityQuestions');
//                if(action =="check security questions")
//                    showSecurityQuestions(securityQuestions,'checksecurityquestions');
//                else
//                    showSecurityQuestions(securityQuestions,'securityquestions');
            }
        });// forget and back to login buttons binding


        $('#forgetpwdbtn').bind('togglecontent', function(event,mode)
        {
            if (mode=='on') {
                var  msg, userpin = $('#fppin'),
                username = $('#fpusername');

                if ($.trim(username.val())=="")	{
                    msg = Raxan.getVar('username-missing');
                    username.focus();
                }
                else if ($.trim(userpin.val())=="") {
                    msg = Raxan.getVar('pin-missing');//Raxan.getVar('email-missing');
                    userpin.focus();
                }

                if (!msg) {
                    $('#seqquesbtn').blur();
                    $('#fpbackbtn, #webforgetpwd img').fadeOut('fast');
                    $('#seqquesbtn img').show();
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

                var securityQuestions = Raxan.getVar('securityQuestions');//securityquestionFP
                var loginAction = Raxan.getVar('loginaction');


                if(loginAction == "security questions forget password")
                {
                    showSecurityQuestions(securityQuestions,'securityquestionsFP');

                }
                $('#seqquesbtn').show();
                $('#fpbackbtn, #webforgetpwd img').fadeIn('fast');
                $('#seqquesbtn img').hide();
                $('.langbar a,#tipbtn').attr('disabled','');


            }

        })/// forgetpwd



        $('#verifypinbtn').bind('togglecontent', function(event,mode)
        {
            if (mode=='on') {
                var  msg, userpin = $('#vppin');//,
                //username = $('#vpusername');

//                if ($.trim(username.val())=="")	{
//                    msg = Raxan.getVar('username-missing');
//                    username.focus();
//                }
//                else
                    if ($.trim(userpin.val())=="") {
                    msg = 'missing user PIN';//Raxan.getVar('email-missing');
                    userpin.focus();
                }

                if (!msg) {
                    $('#seqquesbtn').blur();
                    $('#vpbackbtn, #webverifypin img').fadeOut('fast');
                    $('#seqquesbtn img').show();
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

               var userpin = $('#vppin');
               userpin.val("");
                var loginaction = Raxan.getVar('loginaction');
                loginActions(loginaction);

                $('#seqquesbtn').show();
                $('#vpbackbtn, #webverifypin img').fadeIn('fast');
                $('#seqquesbtn img').hide();
                $('.langbar a,#tipbtn').attr('disabled','');


            }

        })/// verify PIN




        $('#securityCodebtn').bind('togglecontent', function(event,mode)
        {
            if (mode=='on') {
                var  msg, securityCode = $('#seccode');

                if ($.trim(securityCode.val())=="")	{
                    msg = Raxan.getVar('securitycode-missing');
                    securityCode.focus();
                }

                if (!msg) {
                    $('#securityCodebtn').blur();
                    $('#securityCodebackbtn, #websecurityCode img').fadeOut('fast');
                    $('#securityCodebtn img').show();
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
                var  msg,vscResponse, securitycode = $('#seccode');

                vscResponse  = Raxan.getVar('verifySecurityCode');//securityquestionFP
                if(vscResponse =='yes')
                    loginActions("set password");

                else
                {
                    $('#securityCodebtn').show();
                    $('#securityCodebackbtn, #websecurityCode img').fadeIn('fast');
                    $('#securityCodebtn img').hide();
                    $('.langbar a,#tipbtn ').attr('disabled','');
                    securitycode.focus();
                    return false;


                }

            }

        })/// security code



        $('#changepwdbtn').bind('togglecontent', function(event,mode)
        {
            if (mode=='on') {
                var  msg, password = $('#pwd'),
                retypepassword = $('#retypepwd');
                var minpwdlength = 8;


                if ($.trim(password.val())=="")	{
                    msg = Raxan.getVar('password-missing');
                    password.focus();
                }else
                    if ($.trim(password.val()).length < minpwdlength)	{
                        msg = Raxan.getVar('min-password-length');
                        password.focus();
                    }else
                    if ($.trim(retypepassword.val())=="")	{
                        msg = Raxan.getVar('retype-password-missing');
                        retypepassword.focus();
                    }else

                if ($.trim(retypepassword.val())!= $.trim(password.val()))	{
                    msg = Raxan.getVar('password-mismatched');
                    password.focus();
                }


            if (!msg) {
                $('#changepwdbtn').blur();
                $('#changepwdbackbtn,  #webchangepwd img').fadeOut('fast');
                $('#changepwdbtn img').show();
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
            var  msg, password = $('#pwd'),
            retypepassword = $('#retypepwd');

            var pwdchanged  = Raxan.getVar('pwdchanged');//

            if(pwdchanged =='yes')
                {
                    loginActions("password changed");
                    password.val("");
                    retypepassword.val("");
                    $(".pstrength-info").html("");
                    $("#pwd_bar").attr("style","");
                    $("#pwd_bar").addClass("reset-pstrength-bar");
                }


            else
            {
                $('#changepwdbtn').show();
                $('#changepwdbackbtn, #webchangepwd img').fadeIn('fast');
                $('#changepwdbtn img').hide();
                $('.langbar a,#tipbtn ').attr('disabled','');
                password.focus();
                return false;


            }

        }

    })/// change password


    $('#pwdchangedbtn').bind('togglecontent', function(event,mode)
    {
        if (mode=='on') {
            var  msg;



            if (!msg) {
                $('#pwdchangedbtn').blur();
                $('#pwdchangedbackbtn, #webpwdchanged img').fadeOut('fast');
                $('#pwdchangedbtn img').show();
                $('.langbar a, #tipbtn').attr('disabled','disabled');
            }
            else {
                showErrorMessage(msg);
                event.preventDefault();
                event.stopImmediatePropagation();
                return false;
            }


        }else
        {

        }

    })///  password changed

    $('#seqquesbtn').bind('togglecontent',function(event,mode) {
        if (mode=='on') {
            var  msg, ans1 = $('#questans1'),
            ans2 = $('#questans2');

            if ($.trim(ans1.val())=="")	{
                msg = Raxan.getVar('securityans-missing');
                ans1.focus();
            }
            else if ($.trim(ans2.val())=="") {
                msg = Raxan.getVar('securityans-missing');
                ans2.focus();
            }


            if (!msg) {
                $('#seqquesbtn').blur();
                $('#backbtn, #websecurityquestions img').fadeOut('fast');
                $('#seqquesbtn img').show();
                $('.langbar a,#tipbtn').attr('disabled','disabled');
            }
            else {
                showMessage(msg);
                event.preventDefault();
                event.stopImmediatePropagation();
                return false;
            }


        }else
        {// mode is off
            var  msg, ans1 = $('#questans1'),
            ans2 = $('#questans2');

            $('#seqquesbtn').show();
            $('#backbtn, #websecurityquestions img').fadeIn('fast');
            $('#seqquesbtn img').hide();
            $('.langbar a,#tipbtn ').attr('disabled','');
            ans1.focus();
            return false;



        }



    }) //security question binding

    $('#seqquesbtnFP').bind('togglecontent',function(event,mode) {
        if (mode=='on') {
            var  msg, ans1 = $('#questans1FP'),
            ans2 = $('#questans2FP');

            if ($.trim(ans1.val())=="")	{
                msg = Raxan.getVar('securityans-missing');
                ans1.focus();
            }
            else if ($.trim(ans2.val())=="") {
                msg = Raxan.getVar('securityans-missing');
                ans2.focus();
            }


            if (!msg) {
                $('#seqquesbtnFP').blur();
                $('#backbtnFP, #websecurityquestionsFP img').fadeOut('fast');
                $('#seqquesbtnFP img').show();
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
            var  msg, ans1 = $('#questans1FP'),
            ans2 = $('#questans2FP');

            $('#seqquesbtnFP').show();
            $('#backbtnFP, #websecurityquestionsFP img').fadeIn('fast');
            $('#seqquesbtnFP img').hide();
            $('.langbar a,#tipbtn ').attr('disabled','');
            ans1.focus();
            var loginAction = Raxan.getVar('loginaction');


                //show security verification
                loginActions(loginAction);
             return false;



        }



    }) //forget password security question binding


    $('#checkseqquesbtn').bind('togglecontent',function(event,mode) {
        if (mode=='on') {
            var  msg, ans1 = $('#checkquestans1'),
            ans2 = $('#checkquestans2');

            if ($.trim(ans1.val())=="")	{
                msg = Raxan.getVar('securityans-missing');
                ans1.focus();
            }
            else if ($.trim(ans2.val())=="") {
                msg = Raxan.getVar('securityans-missing');
                ans2.focus();
            }


            if (!msg) {
                $('#checkseqquesbtn').blur();
                $('#checkbackbtn, #webchecksecurityquestions img').fadeOut('fast');
                $('#checkseqquesbtn img').show();
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
            var  msg, ans1 = $('#checkquestans1'),
            ans2 = $('#checkquestans2');

            $('#checkseqquesbtn').show();
            $('#checkbackbtn, #webchecksecurityquestions img').fadeIn('fast');
            $('#checkseqquesbtn img').hide();
            $('.langbar a,#tipbtn ').attr('disabled','');
            ans1.focus();
            var loginAction = Raxan.getVar('loginaction');


                //show security verification
                //showMessage(loginAction);
                loginActions(loginAction);
             return false;
        }

    }) //check security question binding


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
                $('#backbtnsqnew, #websecurityquestionsNEW img').fadeOut('fast');
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
            $('#backbtnsqnew, #websecurityquestionsNEW img').fadeIn('fast');
            $('#seqquesansnewbtn img').hide();
            $('.langbar a,#tipbtn ').attr('disabled','');

            var action = Raxan.getVar('loginaction');

            loginActions(action);

            $(classname).each(function(index){

                ansname= ansnameTagPrefix+(index+1);
                ansconfirmname= ansconfirmnameTagPrefix+(index+1);
                $(ansconfirmname).val("");
                $(ansname).val("");
            });

            $(".ui-autocomplete-input").each(function(index){
                $(this).val("Select a question...");
            });

            return false;



        }



    }) //New or Update Security question binding



    $('#changepwdNewbtn').bind('togglecontent', function(event,mode)
    {

        if (mode=='on') {
            var  msg, password = $('#pwdNew'),
            retypepassword = $('#retypepwdNew'),
            oldpassword = $('#pwdOld');
            var minpwdlength = 8;



            if ($.trim(oldpassword.val())=="")	{
                msg = Raxan.getVar('old-password-missing');
                $(oldpassword).addClass('highlight');
                oldpassword.focus();
            }else
                if ($.trim(password.val())=="")	{
                    msg = Raxan.getVar('password-missing');
                    $(password).addClass('highlight');
                    password.focus();
                }else
                if ($.trim(password.val()).length < minpwdlength)	{
                    msg = Raxan.getVar('min-password-length');
                    $(password).addClass('highlight');
                    password.focus();
                }else
                if ($.trim(retypepassword.val())=="")	{
                    msg = Raxan.getVar('retype-password-missing');
                    $(retypepassword).addClass('highlight');
                    retypepassword.focus();
                }else

            if ($.trim(retypepassword.val())!= $.trim(password.val()))	{
                msg = Raxan.getVar('password-mismatched');
                $(password).addClass('highlight');
                password.focus();
            }


        if (!msg) {
            $('#changepwdNewbtn').blur();
            $('#changepwdNewbackbtn, #webchangepwdNew img').fadeOut('fast');
            $('#changepwdNewbtn img').show();
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
        var  msg, password = $('#pwdNew'),
        retypepassword = $('#retypepwdNew'),
        oldpassword = $('#pwdOld');

        password.val("");
        retypepassword.val("");
        oldpassword.val("");
        $(".pstrength-info").html("");
        $("#pwdNew_bar").attr("style","");
        $("#pwdNew_bar").addClass("reset-pstrength-bar");
        var action = Raxan.getVar('loginaction');


        loginActions(action);
        $('#changepwdNewbtn').show();
        $('#changepwdNewbackbtn, #webchangepwdNew img').fadeIn('fast');
        $('#changepwdNewbtn img').hide();
        $('.langbar a,#tipbtn').attr('disabled','');



    }

})///  New or Update change password binding



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
        $('#changepinbackbtn, #webchangepin img').fadeOut('fast');
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

    pin.val("");
    retypepin.val("");
    oldpin.val("");

    var action = Raxan.getVar('loginaction');

    loginActions(action);

    $('#changepinbtn').show();
    $('#changepinbackbtn, #webchangepin img').fadeIn('fast');
    $('#changepinbtn img').hide();
    $('.langbar a,#tipbtn').attr('disabled','');

}

})///  New or Update change PIN binding

// Password Strength Indicator changepinbtn
$(function(){

try
{
    //
    $(".password").each(function(index){

        $(this).pstrength();

        if($.trim($(this).attr("id"))=="pwdNew")
        {
            //move strenght meter to the bottom of fields
            $("#pwdNew_bar").appendTo($("#changepwdNewpwdstrg"));
            $("#pwdNew_text").appendTo($("#changepwdNewpwdstrg"));
            $("#pwdNew_minchar").appendTo($("#changepwdNewpwdstrg"));

        }
        if($.trim($(this).attr("id"))=="pwd")
        {

            //move strenght meter to the bottom of fields
            $("#pwd_bar").appendTo($("#changepwdpwdstrg"));
            $("#pwd_text").appendTo($("#changepwdpwdstrg"));
            $("#pwd_minchar").appendTo($("#changepwdpwdstrg"));

        }
    })
}catch(e)
{showMessage(e.message);}
});



})/// Raxan.ready


//// select all desired input fields and attach tooltips to them
//$("input[title]").tooltip({
//
//	// place tooltip on the right edge
//	position: "center right",
//
//	// a little tweaking of the position
//	offset: [-2, 10],
//
//	// use the built-in fadeIn/fadeOut effect
//	effect: "fade",
//
//	// custom opacity setting
//	opacity: 0.7
//
//});


function resetFields()
{

    //change pin
     var pin = $('#pinNew'),
    retypepin = $('#retypepin'),
    oldpin = $('#pinOld');

    pin.val("");
    retypepin.val("");
    oldpin.val("");

    //login password
    $('#password').val("");
    $("#username").val("");


    //change password
    $('#pwdNew').val("");
    $('#retypepwdNew').val("");
    $('#pwdOld').val("");


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

    //forget password security questions answers
    $('#questans1FP').val("");
    $('#questans2FP').val("");

    //check security questions answers
    $('#checkquestans1').val("");
    $('#checkquestans2').val("");

    //login security questions answers
    $('#questans1').val("");
    $('#questans2').val("");


    //set new password
    $('#pwd').val("");
    $('#retypepwd').val("");

    // password strength
    $(".pstrength-info").html("");
    $("#pwdNew_bar").attr("style","");
    $("#pwdNew_bar").addClass("reset-pstrength-bar");
    $("#pwd_bar").attr("style","");
    $("#pwd_bar").addClass("reset-pstrength-bar");


    //security verification code
    $('#seccode').val("");


    //forget password
    $('#fppin').val("");
    $('#fpusername').val("");

    //verify pin
    $('#vppin').val("");
    //$('#vpusername').val("");

}

function isNumeric(sText)
{
var ValidChars = "0123456789.";
var IsNumber = true;
var Char;

for(i = 0; i  < sText.length && IsNumber == true ; i++)
{
Char = sText.charAt(i);
if(ValidChars.indexOf(Char) == -1)
{

    IsNumber = false;
}

}
return IsNumber;
}
// Show Section
function showSection(id,forward) {
var lastId,elm,ani
lastId = this.lastId ? this.lastId : 'login';
elm = $('#'+lastId);
forward = forward ? true: false;
ani = (!forward) ? {'left':'-400px'} : {'left':'+400px'};
elm.animate(ani,{
duration:'slow',
complete: function(){
    var tar = $('#'+id);
    elm.hide();
    if (tar.css('left')!='0')
        tar.css({'left':'0'});
    tar.fadeIn();

}
});


this.lastId = id;

}




function loginActions(actiontype)
{

    if($("#login-panel").hasClass("login-extended-panel"))
    {
        $("#securityquestionsNEW").fadeOut("fast");
        $("#login-panel").removeClass("login-extended-panel");
        $(".tip, .tip-rt").fadeIn("fast");
    }

    switch(actiontype)
    {
    case 'no security questions':
    case 'set security questions':
        $("#login-panel").addClass("login-extended-panel");
        $(".tip, .tip-rt").fadeOut("fast");

        showSection('securityquestionsNEW');
        break;
    case  'change password':
        showSection('changepwdNew');
        break;
    case 'change pin':
        showSection('changepin');
        break;
    case 'login':

        resetFields()
        showSection('login');
        break;
    case 'security questions':
        showSection('securityquestions');
        break;
    case 'security questions forget password':
        showSection('securityquestionsFP');
        break;
    case 'show security questions':
    case 'check security questions':
        showSection('checksecurityquestions');
        break;
    case 'security verification':
        showSection('securityCode');
        break;
    case "set password":
        showSection('changepwd');
        break;
    case 'password changed':
        showSection('pwdchanged');
        break;
    case 'forget password':
        showSection('forgetpwd');
        break;
    case 'verify pin':
        showSection('verifyPIN');
        break;
    default:
        //$('#password').val("");
        //showSection('login');
        break;

    }
}
//alert('test');

</script>
<div class="login container c37">
    <div id="login-panel" class="login-panel left clip">
        <div class="content clip">

            <div id="login" class="">
                <div class="external langbar" xt-delegate="a click,setLocale">
                    <a href="#en">English</a> | <a href="#es">Spanish</a> | <a href="#fr">French</a> | <a href="#zh">中文</a>
                </div>
                <h2 class="external header bottom" langid="login.title">Login</h2>
                <h2 class="internal header bottom">Client Login</h2>
                <p class="external" langid="login.msg">Enter your Username, Password and Security Answers to sign in</p>
                <p class="internal">Enter Client Id number to sign in</p>
                <form class="" name="weblogin" id="weblogin" action="" method="post">
                    <div class="external">
                        <label langid="user.name">User name:</label><input  tabindex="1" class="ctrl textbox" type="text" name="username" id="username" value="" size="30"/><br />
                        <label langid="pwd">Password:</label><input tabindex="2" class="ctrl textbox" type="password" name="password" id="password" value="" size="30"/><br />
                        <!--<div class="external tpm left" style="margin-top:5px;">
                            <label class="c7"><input tabindex="4" class="ctrl" type="checkbox" name="rememberme" id="rememberme" value="yes" />&nbsp;<span langid="remember.me">Remember me</span></label>
                        </div>-->
                        <!--<label langid="pin">Pin:</label><input tabindex="3" class="ctrl textbox " type="password" name="pin" id="pin" value="" size="5" /><br />-->
                    </div>
                    <div class="internal">
                        <hr class="space"/>
                        <label langid="user.name">Client Id:</label><input class="ctrl textbox" type="text" name="username" id="username" value="" size="30"/><br />
                        <input class="textbox" type="hidden" name="password" id="password" value="" />
                        <!--<input class="textbox" type="hidden" name="pin" id="pin" value="" />-->
                    </div>
                    <hr class="clear tpm bmm" style="margin-top:5px;"/>
                    <div class="buttonbar" style="margin-top:15px;" >
                        <!--             <button tabindex="6" class="ctrl button default right tpm rtm" type="submit" name="loginbtn" id="loginbtn" xt-bind="#click,login,#weblogin,#weblogin .ctrl">-->
                        <button tabindex="6" class="ctrl button default right rtm" type="submit" name="loginbtn" id="loginbtn" xt-bind="#click,validateLogin,#weblogin,#weblogin .ctrl">
                            <img src="views/images/loader.gif" alt="." class="hide" style="margin-right:5px;"/><span langid="login" style="vertical-align:middle">&nbsp;Submit&nbsp;</span>
                        </button>
                        <a tabindex="5" class="external" id="forgetbtn" href="#"  ><img src="views/images/lock.png" alt="Forget my password" class="left" />&nbsp;<span langid="pwd.usr.lookup">Password / User Name Lookup</span></a>
                    </div>
                </form>
            </div>

            <div id="forgetpwd" class="hide external">
                <h2  class="header bottom" langid="pwd.lookup">Password Lookup</h2>
                <p langid="pwd.lookup.msg">Fill out this form to be reminded of your Password or PIN.</p>
                <form class="" name="webforgetpwd" id="webforgetpwd" action="" method="post">
                    <label langid="user.name">User name:</label><input  tabindex="1" class="ctrl textbox" type="text" name="fpusername" id="fpusername" value="" size="30"/><br />
                    <label langid="user.pin">PIN:</label><input class="ctrl textbox pin-size" type="password" name="fppin" id="fppin" value="" size="4" maxlength="4"/>
                    <br class="clear bmm"/>
                    <hr class="clear tpm bmm" style="margin-top:5px;"/>
                    <div class="buttonbar" style="margin-top:35px" >
                        <button class="button default right tpm rtm" type="submit" name="forgetpwdbtn" id="forgetpwdbtn" xt-bind="#click,validateUser,#webforgetpwd, #webforgetpwd .ctrl" >&nbsp;Submit&nbsp;</button>
                        <img src="views/images/back.png" alt="Back to login" class="left" /><a id="fpbackbtn" href="#"  xt-bind="#click,logout" langid="back.to.login" class="left">&nbsp;Back To Login</a>
                    </div>
                </form>
            </div>


            <div id="verifyPIN" class="hide external">
                <h2  class="header bottom" langid="verify.pin.lookup">Verify PIN</h2>
                <p langid="verify.pin.lookup.msg">You are required to enter your User Name and PIN to complete verification.</p>
                <form class="" name="webverifypin" id="webverifypin" action="" method="post">
                    <!--<label langid="user.name">User name:</label><input  tabindex="1" class="ctrl textbox" type="text" name="vpusername" id="vpusername" value="" size="30"/><br />-->
                    <label langid="user.pin">PIN:</label><input class="ctrl textbox pin-size" type="password" name="vppin" id="vppin" value="" size="4" maxlength="4"/>
                    <br class="clear bmm"/>
                    <hr class="clear tpm bmm" style="margin-top:5px;"/>
                    <div class="buttonbar" style="margin-top:35px" >
                        <button class="button default right tpm rtm" type="submit" name="verifypinbtn" id="verifypinbtn" xt-bind="#click,verifyPIN,#webverifypin, #webverifypin .ctrl" langid="verfiy.pin.submit.button">&nbsp;Submit&nbsp;</button>
                        <img src="views/images/back.png" alt="Back to login" class="left" /><a id="verifypinbackbtn" name="verifypinbackbtn" href="#"  xt-bind="#click,logout" langid="back.to.login" class="left">&nbsp;Back To Login</a>
                    </div>
                </form>
            </div>


            <div id="securityCode" class="hide external">
                <h2  class="header bottom" langid="securityCode.title">Security Code</h2>
                <p langid="securityCode.msg">A security code has been sent to your Email.<br>Enter security to change password.</p>
                <form class="" name="websecurityCode" id="websecurityCode" action="" method="post">
                    <label langid="security.code" style="white-space: nowrap">Security Code:</label><input  tabindex="1" class="ctrl textbox" type="password" name="seccode" id="seccode" value="" size="30"/><br />
                    <br class="clear bmm"/>
                    <hr class="clear tpm bmm" style="margin-top:5px;"/>
                    <div class="buttonbar" style="margin-top:35px" >
                        <button class="button default right tpm rtm" type="submit" langid="securityCode.submit.button" name="securityCodebtn" id="securityCodebtn" xt-bind="#click,verifySecurityCode,#websecurityCode, #websecurityCode .ctrl" >&nbsp;Submit&nbsp;</button>
                        <img src="views/images/back.png" alt="Back to login" class="left" /><a id="securityCodebackbtn" href="#"  xt-bind="#click,logout" langid="back.to.login" class="left">&nbsp;Back To Login</a>
                    </div>
                </form>
            </div>


            <div id="changepwd" class="hide  external">
                <h2  class="header bottom" langid="change.pwd.lookup">Change Password</h2>
                <p langid="change.pwd.msg">Enter new password.</p>
                <form class="" name="webchangepwd" id="webchangepwd" action="" method="post">
                    <label langid="change.pwd.name">Password:</label><input  tabindex="1" class="ctrl textbox password" type="password" name="pwd" id="pwd" value="" size="30"/>
                    <label langid="change.pwd.retype">Retype Password:</label><input class="ctrl textbox" type="password" name="retypepwd" id="retypepwd" value="" size="15"/>
                    <br class="clear "/>
                    <div class="clear pwd-strength-container" id="changepwdpwdstrg" name="changepwdpwdstrg" style="text-align: left;">
                        <div  style="font-weight:bold;" langid="password.strength">Password Strength:</div>

                    </div>
                    <hr class="clear bmm" style="margin-top:2px;"/>
                    <div class="buttonbar" style="margin-top:3px" >
                        <button class="button default right tpm rtm" type="submit" name="changepwdbtn" id="changepwdbtn" xt-bind="#click,setPassword,#webchangepwd, #webchangepwd .ctrl" >&nbsp;Submit&nbsp;</button>
                        <img src="views/images/back.png" alt="Back to login" class="left" /><a id="changepwdbackbtn" href="#"  xt-bind="#click,logout" langid="back.to.login" class="left">&nbsp;Back To Login</a>
                    </div>
                </form>
            </div>



            <div id="pwdchanged" class="hide external">
                <h2  class="header bottom" langid="pwd.changed.lookup">Password Changed</h2>
                <p langid="pwd.changed.msg">Your password has been successfully changed<br><br>You can click continue to login</p>
                <form class="" name="webpwdchanged" id="webpwdchanged" action="" method="post">

                    <br class="clear bmm"/>
                    <hr class="clear tpm bmm" style="margin-top:5px;"/>
                    <div class="buttonbar" style="margin-top:35px" >
                        <button class="button default right tpm rtm" type="submit" name="pwdchangedbtn" id="pwdchangedbtn" xt-bind="#click,logout,#webpwdchanged" >
                            <img src="views/images/loader.gif" alt="." class="hide" style="margin-right:5px;"/><span langid="pwd.changed.button" style="vertical-align:middle">&nbsp;Continue&nbsp;</span>
                        </button>
                        <img src="views/images/back.png" alt="Back to login" class="left" /><a id="pwdchangedbackbtn" href="#"  xt-bind="#click,logout" langid="back.to.login" class="left">&nbsp;Back To Login</a>
                    </div>
                </form>
            </div>


            <div id="securityquestionsFP" class=" hide external">
                <h2  class="header bottom" langid="security.questions.title">Security Questions</h2>
                <p langid="security.questions.lookup.msg">Answer Security Questions</p>
                <form class="" name="websecurityquestionsFP" id="websecurityquestionsFP" action="" method="post">
                    <span id="question1FP" name="question1FP"></span><br>
                    <input class="ctrl textbox" type="password" name="questans1FP" id="questans1FP" value="" size="30"/><br />
                    <span id="question2FP" name="question2FP"></span><br>
                    <input class="ctrl textbox" type="password" name="questans2FP" id="questans2FP" value="" size="30"/><br />
                    <br class="clear tpm"/>
                    <hr class="clear tpm bmm" style="margin-top:-5px;"/>
                    <div class="buttonbar" style="margin-top:-10px" >
                        <img src="views/images/back.png" alt="Back to login" class="left" /><a id="backbtnFP" href="#"  xt-bind="#click,logout" langid="back.to.login" class="left">&nbsp;Back To Login</a>
                        <button class="button default right tpm rtm" type="submit" name="seqquesbtnFP" id="seqquesbtnFP" xt-bind="#click,checkAnswersFP,#websecurityquestionsFP,#websecurityquestionsFP .ctrl ">
                            <img src="views/images/loader.gif" alt="." class="hide" style="margin-right:5px;"/><span langid="login.button" style="vertical-align:middle">&nbsp;Login&nbsp;</span>
                        </button>
                    </div>
                </form>
            </div>


            <div id="securityquestions" class=" hide external">
                <h2  class="header bottom" langid="security.questions.title">Security Questions</h2>
                <p langid="security.questions.lookup.msg">Answer Security Questions</p>
                <form class="" name="websecurityquestions" id="websecurityquestions" action="" method="post">
                    <span id="question1" name="question1"></span><br>
                    <input class="ctrl textbox" type="password" name="questans1" id="questans1" value="" size="30"/><br />
                    <span id="question2" name="question2"></span><br>
                    <input class="ctrl textbox" type="password" name="questans2" id="questans2" value="" size="30"/><br />
                    <div class="external left" id="cntRememberPC" name="cntRememberPC" style="margin-top:-5px;margin-left:-3px;">
                        <label class="c7"><input tabindex="4" class="ctrl" type="checkbox" name="rememberpc" id="rememberpc" value="yes" />&nbsp;<span langid="remember.pc">Remember this PC</span></label>
                    </div>
                    <br class="clear tpm"/>
                    <hr class="clear tpm bmm" style="margin-top:-5px;"/>
                    <div class="buttonbar" style="margin-top:-10px" >
                        <img src="views/images/back.png" alt="Back to login" class="left" /><a id="backbtn" href="#"  xt-bind="#click,logout" langid="back.to.login" class="left">&nbsp;Back To Login</a>
                        <button class="button default right tpm rtm" type="submit" name="seqquesbtn" id="seqquesbtn" xt-bind="#click,checkAnswers,#websecurityquestions,#websecurityquestions .ctrl ">
                            <img src="views/images/loader.gif" alt="." class="hide" style="margin-right:5px;"/><span langid="login.button" style="vertical-align:middle">&nbsp;Login&nbsp;</span>
                        </button>
                    </div>
                </form>
            </div>




            <div id="checksecurityquestions" class="hide external">
                <h2  class="header bottom" langid="security.questions.title">Security Questions</h2>
                <p langid="security.questions.lookup.msg">Answer Security Questions</p>
                <form class="" name="webchecksecurityquestions" id="webchecksecurityquestions" action="" method="post">
                    <span id="checkquestion1" name="checkquestion1"></span><br>
                    <input class="ctrl textbox" type="password" name="checkquestans1" id="checkquestans1" value="" size="30"/><br />
                    <span id="checkquestion2" name="checkquestion2"></span><br>
                    <input class="ctrl textbox" type="password" name="checkquestans2" id="checkquestans2" value="" size="30"/><br />
                    <br class="clear bmm"/>
                    <hr class="clear tpm bmm" style="margin-top:-15px;"/>

                    <div class="buttonbar" style="margin-top:-10px" >
                        <button class="button default right tpm rtm" type="submit" name="checkseqquesbtn" id="checkseqquesbtn" xt-bind="#click,checkSecurityAnswers,#webchecksecurityquestions,#webchecksecurityquestions .ctrl ">
                            <img src="views/images/loader.gif" alt="." class="hide" style="margin-right:5px;"/><span langid="security.questions.submit.button" style="vertical-align:middle">&nbsp;Submit&nbsp;</span>
                        </button>
                        <img src="views/images/back.png" alt="Back to login" class="left" /><a id="checkbackbtn" href="#" xt-bind="#click,logout"  langid="back.to.login">&nbsp;Back To Login</a>
                    </div>
                </form>
            </div>


            <div id="securityquestionsNEW" class=" hide external">
                <h2 style="margin-left:15px;" class="header bottom" langid="security.questions.new.title">Security Questions</h2>
                <p style="margin-left:15px;" langid="security.questions.new.lookup.msg">Give an answer to each security questions</p>
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
                    <div class="buttonbar" style="margin-top:-10px" >
                        <button class="button default right rtm" type="submit" name="seqquesansnewbtn" id="seqquesansnewbtn" xt-bind="#click,saveSecurityQuestionAnswers,#websecurityquestionsNEW,#websecurityquestionsNEW .ctrl ">
                            <img src="views/images/loader.gif" alt="." class="hide" style="margin-right:5px;"/><span langid="security.questions.submit.button" style="vertical-align:middle">&nbsp;Login&nbsp;</span>
                        </button>
                        <img src="views/images/back.png" alt="Back to login" class="left" /><a id="backbtnsqnew" name="backbtnsqnew" href="#" xt-bind="#click,logout" style="margin-top:-15px;"  langid="back.to.login">&nbsp;Back To Login</a>
                    </div>
                </form>
            </div>



            <div id="changepwdNew" class="hide external">
                <h2  class="header bottom" langid="change.pwd.lookup">Change Password</h2>
                <p langid="change.pwd.msg">Enter new password.</p>
                <form class="" name="webchangepwdNew" id="webchangepwdNew" action="" method="post">
                    <label langid="change.pwd.old.name">Old Password:</label><input  tabindex="1" class="ctrl textbox" type="password" name="pwdOld" id="pwdOld" value="" size="30"/><br />
                    <label langid="change.pwd.name">Password:</label><input  tabindex="1" class="ctrl textbox password" type="password" name="pwdNew" id="pwdNew" value="" size="30"/>
                    <label langid="change.pwd.retype">Retype Password:</label><input class="ctrl textbox" type="password" name="retypepwdNew" id="retypepwdNew" value="" size="15"/>
                    <div class="clear pwd-strength-container" id="changepwdNewpwdstrg" name="changepwdNewpwdstrg" style="text-align: left;">
                        <div  style="font-weight:bold;" langid="password.strength">Password Strength:</div></div>
                    <hr class="clear " style="margin-top:0px;"/>
                    <div class="buttonbar" style="margin-top:0px" >
                        <button class="button default right rtm" type="submit" name="changepwdNewbtn" id="changepwdNewbtn" xt-bind="#click,changePassword,#webchangepwdNew, #webchangepwdNew .ctrl" >
                            <img src="views/images/loader.gif" alt="." class="hide" style="margin-right:5px;"/><span langid="change.pwd.submit.button" style="vertical-align:middle">&nbsp;Submit&nbsp;</span>
                        </button>
                        <img src="views/images/back.png" alt="Back to login" class="left" /><a id="changepwdNewbackbtn" name="changepwdNewbackbtn" href="#" xt-bind="#click,logout" style="margin-top:-15px;"  langid="back.to.login">&nbsp;Back To Login</a>
                    </div>
                </form>
            </div>



            <div id="changepin" class="hide external">
                <h2  class="header bottom" langid="change.pin.lookup">Change PIN</h2>
                <p langid="change.pin.msg">Enter new PIN.</p>
                <form class="" name="webchangepin" id="webchangepin" action="" method="post">
                    <label langid="change.pin.old.name">Old PIN:</label><input  tabindex="1" class="ctrl textbox pin-size" type="password" name="pinOld" id="pinOld" value="" size="4" maxlength="4"/><br />
                    <label langid="change.pin.name">PIN:</label><input  tabindex="1" class="ctrl textbox pin-size" type="password" name="pinNew" id="pinNew" value="" size="4" maxlength="4"/><br/>
                    <label langid="change.pin.retype">Retype PIN:</label><input class="ctrl textbox pin-size" type="password" name="retypepin" id="retypepin" value="" size="4" maxlength="4"/>
                    <hr class="clear " style="margin-top:0px;"/>
                    <div class="buttonbar" style="margin-top:0px" >
                        <button class="button default right rtm" type="submit" name="changepinbtn" id="changepinbtn" xt-bind="#click,changePIN,#webchangepin, #webchangepin .ctrl" >
                            <img src="views/images/loader.gif" alt="." class="hide" style="margin-right:5px;"/><span langid="change.pin.submit.button" style="vertical-align:middle">&nbsp;Submit&nbsp;</span>
                        </button>
                        <img src="views/images/back.png" alt="Back to login" class="left" /><a id="changepinbackbtn" name="changepinbackbtn" href="#" xt-bind="#click,logout" style="margin-top:-15px;"  langid="back.to.login">&nbsp;Back To Login</a>
                    </div>
                </form>
            </div>





            <div id="logindashboard" class="hide"></div>
        </div>
    </div>


    <hr class="clear space" />



    <div class="prepend2 external">
        <fieldset class="c15 r7 column round">
            <legend landid="new.users">New Users</legend>
            <a class="button ok right bmm bold" href="#" style="margin-top:-35px;line-height: 22px;padding-bottom: 0" langid="sign.up">Sign Up Now</a>
            <img class="column" src="views/images/users.png" alt="New User" align="left" />
            <div class="c12 left" langid="new.usr.info">
                JMMB's Moneyline now with more powerful features, and an easy to use interface.&nbsp;<br /><br />
                Some of these great features include <span style="color:maroon">Account Information</span>,<span style="color:maroon">Online Transactions</span> and <span style="color:maroon">Statements</span>
            </div>
        </fieldset>

        <fieldset class="column c15 r7 round">
            <legend langid="pub.access">Public Access</legend>
            <img class="column" src="views/images/secure_badge.png" alt="Public Access" />
            <div class="left c12" langid="pub.access.info">
                When accessing moneyline from a public computer make sure that the computer is free of virus and malware.<br /><br />
                Make sure no one is standing behind you while you're logging in.
            </div>
        </fieldset>
    </div>
</div>

