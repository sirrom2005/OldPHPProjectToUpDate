<?php defined('RAXANPDI')||die(); ?>

<style type="text/css">
    #errorbox {
        background-color:#dedede;
    }
    #errorbox h4 {
        color:red;
        font-weight: bold;
    }
    #errorbox .content {
        border: 1px solid #fdb8cd;
        background: #fdc9d9 url('raxan/ui/css/moneyline/images/bg_highlight.png') top repeat-x;
        padding:10px;
    }
    #errormsg a:hover {
        text-decoration: none;
    }
    #errormsg a {
        color: navy;
    }
    #errorbox hr {
        color:#DF8282;
        background-color:#DF8282;
    }
</style>
<p>&nbsp;</p>
<div class="container c32">
    <div id="errorbox" class="c31 round ui-widget ui-widget-shadow1 ui-fixed-shadow">
        <div class="content round  pad1">
            <h2 id="errortitle" class="box-title">Error Message</h2>
            <hr />
            <div id="errormsg" class="pad"></div>
            <hr />
            <div class="pad buttonbar" align="right">
                <a id="signinbtn" class="button" href="login.php" langid="signin">Sign In</a>
                <div id="homebtn">
                    <a class="button" href="app/accsum" langid="back-to-home">Back to Home Page</a>&nbsp;
                    <a class="button cancel" href="logout.php" langid="logout">Logout</a>
                </div>
            </div>
        </div>
    </div>
</div>
<p>&nbsp;</p>
