<?php defined('RAXANPDI')||die(); ?>

<div id ="accountentry">
    
    <label langid="get.acc">Enter Account</label>
    <input name= "account_no" >
    <input type ="submit" value= "Submit" xt-bind="#click,processAccount" >
</div>

<div id ="branchEntry">

    <label >Enter Branch</label>
    <input name= "branch" >
    <input type ="submit" value= "Submit" xt-bind="#click,processBranch" >
</div>



<div id ="confirm">
<div id ="results"></div>
<p>
    <label >enter pin</label>
    <input name= "pin" >
 <input type ="submit" value= "Submit" xt-bind="#click, processPinFinal"   >

<div >
    <select id ="displaylisting" >
        <option data-amount =" blabla" value ="{0}">{2}</option>
    </select>


</div>