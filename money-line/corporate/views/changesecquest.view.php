<?php defined('RAXANPDI') || die(); ?>

<style tyle="text/css">
    input.textbox { width:334px; }
    select { width:340px;}
    .buttonbar {
        text-align:right;
        line-height:30px;
        vertical-align:baseline;
    }
</style>

<!-- Panel HTML Code -->
<div id="changequest" class="container c25 rax-box alert">
    <h2 class="bottom">Update Security Question</h2>
    <p class="bmm">You are required to update your security questions</p>
    <div id="msgbox" class="bmm"></div>
    <form id="webForm" class="webform ltm" method="post" action="login.php">
        <div class="security-questions"></div>
        <hr />
        <div class="buttonbar">
            <a href="login.php?do=logoff">Logout</a>&nbsp;|&nbsp;
            <input id="btnchange" type="submit" value="Update" xt-bind="#click,changeEvent"/>
        </div>
    </form>
</div>
