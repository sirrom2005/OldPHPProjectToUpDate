<?php defined('RAXANPDI')||die(); ?>

<!-- Panel HTML Code -->
<style type="text/css">
    input.textbox { width:334px; }
    select { width:340px;}
    .buttonbar {
        text-align:right;
        line-height:30px;
        vertical-align:baseline
    }
</style>

<hr class="space" />
<div id="forgetpwd" class="container c25 rax-box info">
    <h2 class="bottom">Password Reset</h2>
    <p class="bmm">Please enter your email address.</p>
    <div id="msgbox" class="flashmsg bmm"></div>
    <form class="webform ltm" method="post" action="login.php">
        <div>
            <div class="ctrl-group">
                <label class="bold">User Name:</label><input class="textbox" type="text" id="username" name="username" size="30" /><br />
            </div>
            <div class="ctrl-group">
                <label class="bold">Corporate ID:</label><input class="textbox" type="text" id="corpid" name="corpid" size="30" /><br />
            </div>
            <div id="continue" class="ctrl-group append1 buttonbar">
                <a href="login.php">Cancel</a>&nbsp;|&nbsp;
                <input id="btncontinue" type="button" value="Continue" xt-bind="#click,continueEvent,form"/>
            </div>
        </div>
        <div id="questions" class="hide">
            <hr />
            <p class="bmm">Please enter security questions below.</p>
            <div class="ctrl-group">
                <label class="bold">First Question:</label><input type="hidden" name="question1" /><div id="question1text"></div>
                <label>&nbsp;&nbsp;Your Answer:</label><input class="textbox" type="text" name="answer1" size="30" autocomplete="off" /><br />
            </div>
            <div class="ctrl-group">
                <label class="bold">Second Question:</label><input type="hidden" name="question2" /><div id="question2text"></div>
                <label>&nbsp;&nbsp;Your Answer:</label><input class="textbox" type="text" name="answer2" size="30" autocomplete="off" /><br />
            </div>
            <div class="ctrl-group">
                <label class="bold">Third Question:</label><input type="hidden" name="question3" /><div id="question3text"></div>
                <label>&nbsp;&nbsp;Your Answer:</label><input class="textbox" type="text" name="answer3" size="30" autocomplete="off" /><br />
            </div>
            <div class="ctrl-group">
                <label class="bold">Fourth Question:</label><input type="hidden" name="question4" /><div id="question4text"></div>
                <label>&nbsp;&nbsp;Your Answer:</label><input class="textbox" type="text" name="answer4" size="30" autocomplete="off" /><br />
            </div>
            <hr />
            <div class="ctrl-group buttonbar">
                <a href="login.php">Cancel</a>&nbsp;|&nbsp;<input id="btnreset" type="submit" value="Reset Password" xt-bind="#click,resetEvent" />
            </div>
        </div>
    </form>
</div>
<p>&nbsp;</p>