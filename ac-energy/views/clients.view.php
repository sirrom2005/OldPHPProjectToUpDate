<?php defined('RAXANPDI')||exit(); ?>

<hr class="space" />
<form class="right" method="post" name="ssfrm" action="">
	<input type="text" class="text" id="stext" name="stext" /> <input type="submit" id="sbtn" value="Find Client" />
</form>
<button class="button bmm" onclick="location='client.php'">Add Client</button>
<table id="datatable" class="rax-table column border">
    <caption>Client Listing</caption>
    <thead>
       <tr class="tbl-header">
            <th>Fullname</th>
            <th>Email</th>
            <th>Date</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <tr class="{ROWCLASS}">
            <td><a href="clientdetail.php?id={id}" title="view client detail">{title} {firstname} {lastname}</a></td>
            <td>{email}</td>
            <td class="c3" nowrap="nowrap">{date_added}</td>
            <td class="c3">
            	<a class="preview" href="clientdetail.php?id={id}" title="view client detail"></a>
                <a class="edit" href="client.php?id={id}" title="edit this client"></a>
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