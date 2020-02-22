<?php
    include_once 'init.php';
    $_SESSION['page'] = '';

    require_once("inc/core.php");

    $objCore = new Core();

    $objCore->initSessionInfo();
    $objCore->initFormController();

    if($objCore->getSessionInfo()->isLoggedIn() && $objCore->isAdmin()){
      	$usersdata = $objCore->getUsersData(); 
    } else {
      	header("Location: login.php?redirect=admin");
    }
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<title>Baymac - Administration</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="css/coin-slider.css" />
<script type="text/javascript" src="js/cufon-yui.js"></script>
<script type="text/javascript" src="js/droid_sans_400-droid_sans_700.font.js"></script>
<!--<script type="text/javascript" src="js/cufon-titillium-900.js"></script>-->
<script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="js/script.js"></script>
<script type="text/javascript" src="js/coin-slider.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {

	$('._op_admin').bind('click', function() {
	    var obj = $(this);
		var op		= obj.next().next().val();
		var uk 		= obj.next().val();
		if(op!='delete')
			var currval	= obj.prev().text()=="No"?0:1;
		
		var url = 'inc/corecontroller.php?ts='+new Date().getTime();
		$.ajax({
			   type: "POST",
			   url: url,
			   timeout : 30000,
			   dataType: "json",
			   data: (op!='delete')?'adminopactionx=1&uk='+uk+'&currval='+currval+'&op='+op:'adminopactionx=1&uk='+uk+'&op='+op+'&currval=0',
			   success: function(data,textStatus){
							if(data.result == "1"){
								if(op!='delete'){
									if(op=='block'){
										if(currval=='0'){
										    console.log('here');
											$('#tr_'+uk).addClass('statusblocked');
										}else{
										    console.log('here2');
											$('#tr_'+uk).removeClass('statusblocked');
										}	
									}	

									(currval=='0') ? obj.prev().html('Yes') : obj.prev().html('No');
								}
								else{
									$('#tr_'+uk).remove();
									$countusrs = parseInt($('#countusers').text());
									$countusrsnow = $countusrs-1;
									$('#countusers').html($countusrsnow);
								}
							}
						}

		});
	
	});
});

</script>
</head>
<body>
<div class="main">
  <div class="header">
    <?php include('header.php'); ?>
  </div>
  <div class="content">
    <div class="content_resize">
      <div class="mainbar" style="width:960px;">
        <div class="article">
            <?php if($objCore->getSessionInfo()->isLoggedIn()) { ?>
            <p class="spec" style="float:right;"><a href="inc/corecontroller.php?logoutaction=1" class="rm">Logout</a><a href="inc/corecontroller.php?logoutaction=1" class="com"><span></span></a></p>
            <?php } ?>          
           <h2><span>User Administration</span></h2>
                 
            <p class="infopost">            
          <div class="clr"></div>
        </div>
        <div class="article">
 
          <div class="clr"></div>
			<h3><span id="countusers"><?php echo count($usersdata)?></span> Registered Users</h3>  

			<?php if(count($usersdata)>0){?>
			<table id="userslist" class="admin" style="width:100%;">
			<thead>
        	<tr>
        		<th>
        			Email
        		</th>
        		<th>
        			Name
        		</th>
        		<th>
        			Address
        		</th>
        		<th>
        			City
        		</th>
        		<th>
        			Country
        		</th>
        		<th>
        			Telephone
        		</th>
        		<th>
        			Airline
        		</th>
        		<th style="width:50px;text-align:center;">
        			Approved
        		</th>
        		<th style="width:50px;text-align:center;">
        			Admin
        		</th>
        		
        	</tr>
			</thead>
			<tbody>
      
			<?php 
          /* remove original behaviour highlighting blocked user accounts
        	for ($i=0;$i<count($usersdata);$i++){
        		if($usersdata[$i]['usr_is_blocked']=='1'){
          */
          // and replace it with behaviour highlighting unconfirmed user accounts
        	for ($i=0;$i<count($usersdata);$i++){
        		if($usersdata[$i]['usr_is_confirmed']=='0'){          
            ?>
        			<tr id="tr_<?php echo $usersdata[$i]['pk_user'];?>" class="statusblocked"> 
        		<?php }
        		else{
        			if($usersdata[$i]['usr_is_admin']=='1'){
        			?>
        				<tr id="tr_<?php echo $usersdata[$i]['pk_user'];?>" class="statusadmin">
        			<?php }else{?>
        				<tr id="tr_<?php echo $usersdata[$i]['pk_user'];?>">
        			<?php }}?>	 
        		
        		<td>
        			<?php echo $usersdata[$i]['email']; ?>
        		</td>
        		<td>
        			<?php echo $usersdata[$i]['title'].' '.$usersdata[$i]['flname']; ?>
        		</td>
        		<td>
        			<?php echo nl2br($usersdata[$i]['address']); ?>
        		</td>
        		<td>
        			<?php echo $usersdata[$i]['city']; ?>
        		</td>
        		<td>
        			<?php echo $usersdata[$i]['country_name']; ?>
        		</td>
        		<td>
        			<?php echo $usersdata[$i]['phone']; ?>
        		</td>
        		<td>
        			<?php echo $usersdata[$i]['airline']; ?>
        		</td>
        		<td style="text-align:center;">
        			<div class="admin_no"><?php echo $usersdata[$i]['usr_is_confirmed']==0?'No':'Yes'; ?></div>

        			<div class="_op_admin admin_change" title="Change approval status"></div>
        			<input type="hidden" value="<?php echo $usersdata[$i]['pk_user'];?>" />
        			<input type="hidden" value="block" />
        		</td>
        		<td style="text-align:center;">
        			<div class="_op_admin admin_delete" title="Delete User"></div>
        			<input type="hidden" value="<?php echo $usersdata[$i]['pk_user'];?>" />
        			<input type="hidden" value="delete" />
        		</td>
        	</tr>
        	<?php
        	}	
        	?>
			</tbody>
        	</table>
        	<?php }?>
        </div>
      </div>
      <!--
      <div class="sidebar">
          <?php include('sidebar.php'); ?>
      </div>
    -->
      <div class="clr"></div>
    </div>
  </div>
  <div class="fbg">
    <?php include('bottom.php'); ?>
  </div>
  <div class="footer">
    <?php include('footer.php'); ?>
  </div>
</div>
</body>

</html>

