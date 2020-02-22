<?php defined('RAXANPDI')||exit(); ?>
<hr class="space" />
<form name="frm" id="frm" method="post" action="" class="rax-backdrop">
<fieldset>
	<legend>Client Information</legend>
    <p id="info">
        <p><b>Client Name</b><br />{clientname}</p>
        <p id="address">{address}</p>
        <p><b>Email</b><br />{email}</p>
        <p><b>Telephone</b><br />{telephone}</p>
        <hr />
    </p>
    <table id="datatable" class="c30 rax-table column border">
    <caption>Client Quotes</caption>
    <thead>	
        <tr class="tbl-header">
            <th>Quote/Request</th>
            <th>Date Added</th>
            <th></th>
        </tr>
    </thead> 
    <tbody>
        <tr>
            <td>{title}</td>
            <td class="c14">{date_added}</td>
            <td class="c2">
                <a class="preview" href="#{filename}" title="view pdf"></a>
                <a class="remove" href="#{id}" title="delete this record from the system" data-event-confirm="You are about to delete this record"></a>
            </td>
        </tr>
    </tbody>   
    </table>
</fieldset>    
</form>
<hr />
