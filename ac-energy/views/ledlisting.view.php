<?php defined('RAXANPDI')||exit(); ?>

<hr class="space" />
<button class="button bmm" onclick="location='ledsform.php'">LED FORM</button>
<table id="datatable" class="rax-table column border">
    <caption>LED Listing</caption>
    <thead>
       <tr class="tbl-header">
       		<th>Client Name</th>
            <th>Email</th>
            <th>Color Temperature</th>
            <th>A19 light bulb fixtures</th>
            <th>Outdoor floodlights</th>
            <th>Date</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <tr class="{ROWCLASS}">
        	<td>{fullname}</td>
        	<td>{email}</td>
            <td>{colour_tem}</td>
            <td>{a19_light_bulb_cnt}</td>
            <td>{outdoor_floodlights_cnt}</td>
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