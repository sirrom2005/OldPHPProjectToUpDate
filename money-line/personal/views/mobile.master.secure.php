
<!DOCTYPE html>

<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>Moneyline Mobile</title>
    <base href="" />
    <link href="raxan/ui/css/master.css" type="text/css" rel="stylesheet" />
    <!--[if lt IE 8]><link href="raxan/ui/css/master.ie.css" type="text/css" rel="stylesheet" /><![endif]-->
    <link href="raxan/ui/css/moneyline/theme.css" type="text/css" rel="stylesheet" />
    <link rel="icon" type="image/png" href="favicon.png" />
    <style type="text/css">
        #dialog-message{
            text-align: left;
        }
         #dialog-message a {
            color:#1c94c4;
            font-weight: bold;
        }
        #dialog-message a:hover
        {
            color: #f6a828 ;
        }
        #dialog-message h4,
        #dialog-message h3,
        #dialog-message h2,
        #dialog-message h1{
            text-align: center;
        }
        .ui-dialog-buttonpane{
            text-align: right!important;
        }
    </style>
</head>

<body>
    <div id="msgbox" xt-ui="MessageBox" style="position: absolute;z-index:100;display:none"></div>

    <div class="container page-header">
        <h2 class="bottom">Moneyline Mobile</h2>
    </div>
    <div class="container rax-box">
        <div id="logininfo" class="right"></div>
       
        <span id="help" name="help"  class="right ui-icon ui-icon-help" style="margin-right: 10px;cursor:help" title="JMMB Moneyline - Help"  ></span>
        <span class="right bmm">| </span>
         
        <?php if( rememberSQ::isRegisteredPC()) {?>
        <div  class="right" style="margin-right:10px;">
            <a  id="unregpc" name="unregpc" href="#" xt-bind="#click" >Unregister  PC&nbsp;|</a>
        </div>
        <?php } ?>
        <div id="currentdate"></div>
    </div>
    
    <div class="master-content container e95 white tpm bmm"></div>
    
    <hr class="space" />
    <div class="container tpm">
        <div class="seal">
            <script language="JavaScript" src="https://seal.networksolutions.com/siteseal/javascript/siteseal.js" type="text/javascript"></script>
            <script language="JavaScript" type="text/javascript"> SiteSeal("https://seal.networksolutions.com/images/basicrecblue.gif", "NETSP", "none");</script>
        </div>
        <div class="text prepend1" style="padding-top:10px">
            <div class="copyright">© Copyright JMMB. All rights reserved.</div>
        </div>
    </div>
    <div id="jQueryUI-conponents" class="hide" >
        <div  id="dialog-message" title="JMMB Moneyline - Message"></div>
        <div id="dialog-help" title="JMMB Moneyline - HELP"></div>
        <div id="confirm-ok"  xt-bind="#click,confirmOk"></div>
        <div id="confirm-cancel"  xt-bind="#click,confirmCancel"></div>
    </div>


      <?php if( rememberSQ::isRegisteredPC()) {?>
        <script type="text/javascript">
            //alert(document.cookie);

            function GetCookie( check_name ) {
                    // first we'll split this cookie up into name/value pairs
                    // note: document.cookie only returns name=value, not the other components
                    var a_all_cookies = document.cookie.split( ';' );
                    var a_temp_cookie = '';
                    var cookie_name = '';
                    var cookie_value = '';
                    var b_cookie_found = false; // set boolean t/f default f

                    for ( i = 0; i < a_all_cookies.length; i++ )
                    {
                            // now we'll split apart each name=value pair
                            a_temp_cookie = a_all_cookies[i].split( '=' );


                            // and trim left/right whitespace while we're at it
                            cookie_name = a_temp_cookie[0].replace(/^\s+|\s+$/g, '');

                            // if the extracted name matches passed check_name
                            if ( cookie_name == check_name )
                            {
                                    b_cookie_found = true;
                                    // we need to handle case where cookie has no value but exists (no = sign, that is):
                                    if ( a_temp_cookie.length > 1 )
                                    {
                                            cookie_value = unescape( a_temp_cookie[1].replace(/^\s+|\s+$/g, '') );
                                    }
                                    // note that in cases where cookie is initialized but no value, null is returned
                                    return cookie_value;
                                    break;
                            }
                            a_temp_cookie = null;
                            cookie_name = '';
                    }
                    if ( !b_cookie_found )
                    {
                            return null;
                    }
            }
            function DeleteCookie( name, path, domain ) {
                if ( GetCookie( name ) ) document.cookie = name + "=" +
                ( ( path ) ? ";path=" + path : "") +
                ( ( domain ) ? ";domain=" + domain : "" ) +
                ";expires=Thu, 01-Jan-1970 00:00:01 GMT";
            }
            function SetCookie( name, value, expires, path, domain, secure )
            {
                // set time, it's in milliseconds
                var today = new Date();
                today.setTime( today.getTime() );

                /*
                if the expires variable is set, make the correct
                expires time, the current script below will set
                it for x number of days, to make it for hours,
                delete * 24, for minutes, delete * 60 * 24
                */
                if ( expires )
                {
                expires = expires * 1000 * 60 * 60 * 24;
                }
                var expires_date = new Date( today.getTime() + (expires) );

                document.cookie = name + "=" +escape( value ) +
                ( ( expires ) ? ";expires=" + expires_date.toGMTString() : "" ) +
                ( ( path ) ? ";path=" + path : "" ) +
                ( ( domain ) ? ";domain=" + domain : "" ) +
                ( ( secure ) ? ";secure" : "" );
            }
        </script>

       <script type="text/javascript">
           <?php
                    $path= Raxan::config("site.url");
                    $url = $path."unRegPC.php";
           ?>
        Raxan.ready(function(){
            $("#unregpc").click(function(){
                Raxan.dispatchEvent({
                    type: "unregister",     // event name
                    url:  "<?php echo $url;?>",    // page url where event is registered
                    complete: function(result,success){
                        var msg;
                        if (result=="failed" || !success)
                        {
                            msg = Raxan.getVar("PCnotregisterPCMsg");
                        }else
                        if (result=="successful")
                        {
                            msg = Raxan.getVar("unregisterPCMsg");
                        }
                        showMessage(msg);
                    }
                })
               });



            });
        </script>
    <?php }?>


    <script type="text/javascript">
     <?php
                    $path= Raxan::config("site.url");
                    $url = "";
      ?>
     Raxan.ready(function(){
            $("#help").click(function(){
                <?php $url = $path."help.php";?>
                Raxan.dispatchEvent({
                    type: "show",     // event name
                    url:  "<?php echo $url;?>",    // page url where event is registered
                    complete: function(result,success){
                        var msg;
                        if (result=="failed" || !success)
                        {
                            msg = "";
                        }else
                        if (result=="successful")
                        {
                            msg = "";
                        }
                        //showMessage(msg);
                    }
                });
            })


            })//ready function


    </script>


</body>

</html>