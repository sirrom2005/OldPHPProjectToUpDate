<?php defined('RAXANPDI')||die();?>

<!DOCTYPE html>

<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>Moneyline</title>
    <base href="" />
    <link href="../common/raxan/ui/css/master.css" type="text/css" rel="stylesheet" />
    <!--[if lt IE 8]><link href="../common/raxan/ui/css/master.ie.css" type="text/css" rel="stylesheet" /><![endif]-->
    <link href="../common/raxan/ui/css/moneyline/theme.css" type="text/css" rel="stylesheet" />
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
    <script language="JavaScript" src="views/scripts/moneyline.js" type="text/javascript"></script>

    <div id="msgbox" xt-ui="MessageBox"></div>
    <div id="flashbar" class="flashmsg"></div>
    

    <div class="container page-header">
        <img class="right" src="views/images/banner_rt.png" alt="JMMB Moneyline" height="70" />
        <img class="left" src="views/images/banner_lt.png" alt="JMMB Moneyline" height="70" />
    </div>
    <div class="container login-menubar">
        <span id="help" name="help"  class="right ui-icon ui-icon-help" style="margin-right: 10px;cursor:help" title="JMMB Moneyline - Help"  ></span>
        <span class="right bmm">| </span>
       <div id="logininfo" class="right"></div>
        <div id="currentdate"></div>
        
    </div>
    
    <div class="master-content container e95 white tpm bmm"></div>
    
    <hr class="space" />
    <div class="container page-footer tpm">
        <div class="ft-top" ><img src="views/images/footer_tp.png" alt="." height="3" /></div>
      <!--  <div class="seal">
            <script language="JavaScript" src="https://seal.networksolutions.com/siteseal/javascript/siteseal.js" type="text/javascript"></script>
            <script language="JavaScript" type="text/javascript"> SiteSeal("https://seal.networksolutions.com/images/basicrecblue.gif", "NETSP", "none");</script>
        </div>-->
        <img src="views/images/seal-sitesafe.gif" alt="Security" class="hide left prepend1 dn1"/>
        <div class="text prepend1" style="padding-top:10px">
            Products &amp; Services: <span class="ft-branches">Save Smart | Sure Investor | Tax Shelter | Income Builder | EMMA | Retirement Solutions </span><br />
            Telephone: (876) 998-JMMB (5662)
            <div class="copyright">© Copyright JMMB. All rights reserved.</div>
        </div>
    </div>
    <div id="jQueryUI-conponents" class="hide" >
        <div  id="dialog-message" title="JMMB Moneyline - Message"></div>
        <div id="dialog-help" title="JMMB Moneyline - HELP"></div>
        <div id="confirm-ok"  xt-bind="#click,confirmOk"></div>
        <div id="confirm-cancel"  xt-bind="#click,confirmCancel"></div>
    </div>
    
</body>


</html>