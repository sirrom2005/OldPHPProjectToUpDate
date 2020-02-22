<?php defined('RAXANPDI')||exit(); ?>
<hr class="space" />
<table id="datatable" class="rax-table column border">
    <caption>Form Submissions By Date</caption>
    <thead>
       <tr class="tbl-header">
            <th>Client Name</th>
            <th>Email</th>
            <th>Quote Type</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        <tr class="{ROWCLASS}">
            <td><a href="{url}">{fullname}</a></td>
            <td>{email}</td>
            <td>{quoteType}</td>
            <td class="c3" nowrap="nowrap">{date_added}</td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <td id="pager" colspan="3"></td>
        </tr>
    </tfoot>
</table>
<hr />