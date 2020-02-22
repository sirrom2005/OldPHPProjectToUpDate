<?php  
	require_once("DB.php");	
	$user 		= 'dbo192914155';
	$pwd 		= 'UW79Tn.Z';
	$host 		= 'db628.perfora.net';
	$db_name 	= 'db192914155';
	$db_type 	= 'mysql';	 
	$dsn = "$db_type://$user:$pwd@$host/$db_name";
	$db = DB::connect($dsn); 
	if(DB::isError($db))
	{
		echo"<script>location='under_con.html'</script>";
	}
		//die ($db->getMessage());	
	$db->setFetchMode(DB_FETCHMODE_ASSOC);
?>
