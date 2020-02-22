<?php defined('RAXANPDI')||exit(); ?>
<hr class="space" />
<button class="button" onclick="location='adduser.php'">New User</button>
<table id="datatable" class="rax-table column border" style="margin-top:10px;" >
    <caption>Account Users</caption>
    <thead>
       <tr class="tbl-header">
            <th>Username</th>
            <th>Fullname</th>
            <th>Email</th>
            <td>Account Type</td>
            <th ></th>
        </tr>
    </thead>
    <tbody>
        <tr class="{ROWCLASS}">
            <td>{username}</td>
            <td>{fullname}</td>
            <td>{email}</td>
            <td>{acc_type}</td>
            <td class="c2">
                <a class="edit" href="adduser.php?id={id}" title="edit this user"></a>
                <a class="remove" href="#{id}" title="delete this user" data-event-confirm="Are you sure you want to remove this user?"></a>
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