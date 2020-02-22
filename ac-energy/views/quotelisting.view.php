<?php defined('RAXANPDI')||exit(); ?>
<hr class="space" />
<button class="button bmm" onclick="location='index.php'">New Grid-Tied PV Quote</button>
<table id="datatable" class="rax-table column border">
    <caption>Grid-Tied PV Quote Listing</caption>
    <thead>
       <tr class="tbl-header">
            <th>Client Name</th>
            <th>Email</th>
            <th>Place of Visit</th>
            <th>Date</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <tr class="{ROWCLASS}">
            <td>{fullname}</td>
            <td>{email}</td>
            <td>{placetype}</td>
            <td class="c3" nowrap="nowrap">{date_added}</td>
            <td class="c6">
            	<a class="edit" href="solarquoteinputs.php?id={id}" title="view form inputs for this qoute"></a>
                <a class="preview" href="preview.php?id={id}" title="preview/edit document"></a>
                <a class="pdfpreview" href="#{filename}" title="preview form inputs pdf"></a>
                <a class="pdf" href="#{filename}_{id}" title="download and view quote for {fullname}"></a>
                <a class="email" href="#{filename}" title="email quote to user" data-event-confirm="You are about to email this quote to {fullname}"></a>
                <a class="remove" href="#{id}" title="delete this quote" data-event-confirm="Are you sure you want to remove this quote?"></a>
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