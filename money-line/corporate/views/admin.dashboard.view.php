<?php defined('RAXANPDI') || die(); ?>

<div id="msgbox" class="right c20 above pad" style="position:fixed;right:10px;top:10px;z-index:9999"></div>
<div class="container bmm">
    <form method="post" class="right">
        <input id="query" class="textbox" type="text" name="query" size="35" style="vertical-align:bottom" />&nbsp;
        <input id="btnsearch" type="button" value="Search" class="button continue" />&nbsp;
        <input id="btnadd" type="button" value="Add User" class="button process" />
    </form>
    <h3>User Administration</h3>
</div>
<div class="users container">
    <div class="admin-bar container lightgray hlf-pad"><h4 class="bottom bold">Corporate Users</h4></div>
    <table  id="tblUsers" class="rax-table border mouse-cursor" cellpadding="1" cellspacing="0">
        <thead>
            <tr class="tbl-header">
                <td>User</td>
                <td>First Name</td>
                <td>Last Name</td>
                <td>Email</td>
                <td>Status</td>
                <td>Last logon</td>
                <td><div class="right">Action</div></td>
            </tr>
        </thead>
        <tbody id="tblUsersBody">
            <tr class="{ROWCLASS}">
                <td>{userName}</td>
                <td>{firstName}</td>
                <td>{lastName}</td>
                <td>{email}</td>
                <td>{status}</td>
                <td>{lastAccessDate}</td>
                <td>
                    <div class="right">
                        <a class="edit" href="manage-user.php?id={id}"><img src="views/images/application_form_edit.png" alt="Edit User" width="16" /></a>&nbsp;
                        <a class="delete" href="#{id},{version}" data-event-confirm="Are you sure you want to delete this user?"><img src="views/images/delete.png" alt="Delete User" width="16" /></a>&nbsp;
                        <a class="resetpwd" href="#{id}" data-event-confirm="Are you sure you want to reset this user's password?"><img src="views/images/key.png" alt="Reset User Password" width="16" /></a>
                    </div>
                </td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="7" class="tpb">
                    <div class="right c2">
                        <select id="pagesize" name="pagesize">
                            <option value="10">10</option>
                            <option value="20">20</option>
                            <option value="30">30</option>
                            <option value="50">50</option>
                        </select>
                    </div>
                    <div id="pager" class="pnl-footer right rtm" style="margin-top:2px;text-align:right;font-style:normal" ><a class="hlf-pad" href="#{VALUE}">{VALUE}</a></div>
                </td>
            </tr>
        </tfoot>
    </table>
</div>