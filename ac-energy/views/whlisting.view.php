<?php defined('RAXANPDI')||exit(); ?>

<hr class="space" />
<button class="button bmm" onclick="location='form1.php'">Water Heater Form</button>
<table id="datatable" class="rax-table column border">
    <caption>Water Heater Form Listing</caption>
    <thead>
       <tr class="tbl-header">
       		<th>Client Name</th>
            <th>Email</th>
            <th>Number of users</th>
            <th>System size</th>
            <th>Eletrical back up</th>
            <th>Date</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <tr class="{ROWCLASS}">
        	<td>{fullname}</td>
        	<td>{email}</td>
            <td>{value1}</td>
            <td>{value3}</td>
            <td>{value4}</td>
            <td class="c3" nowrap="nowrap">{date_added}</td>
            <td class="c2">
                <a class="preview" href="#{id}" title="preview form inputs"></a>
                <a class="remove" href="#{id}" title="delete this record" data-event-confirm="You are about to delete this record"></a>
            </td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <td id="pager" colspan="4"></td>
        </tr>
    </tfoot>
</table>
<hr />