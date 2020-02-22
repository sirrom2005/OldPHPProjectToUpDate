<?php defined('RAXANPDI')||die(); ?>

<div class="details clear lightgray pad">
    <div class="bold clear bmb" langid="new-reminder">Details</div>

    <div class="c8">
        <label class="c4 bold quiet left" langid="priority">Priority:</label>
        <span class="{PriorityDesc}" langid="{PriorityDesc}">{PriorityDesc}</span><br />
    </div>

    <div class="c8">
        <label class="c4 bold quiet left" langid="action-date">Action Date:</label>
        <span class="left">{ActionDate}</span>
    </div>

    <div class="clear">
        <label class="c4 bold quiet left" langid="priority">Summary:</label>
        <div class="c8 left" langid="{PriorityDesc}">{Summary}</div>
        <div class="clear" style="margin-bottom:5px"></div>

        <label class="c4 bold quiet left" langid="priority">Details:</label>
        <div class="c8 left" langid="{PriorityDesc}">{Details}</div><br />
        <div class="clear" style="margin-bottom:5px"></div>
    </div>

</div>
<div align="right" class="border bmm">
    <a href="#" class="close bold" langid="close">Close</a>&nbsp;
</div>