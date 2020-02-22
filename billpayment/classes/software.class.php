<?php
class software extends mySqlDB
{	
	function software(){ parent::mySqlDB(); }
	
	function addTransaction($data)
	{
		$sql = "INSERT INTO odb_transaction 
				( trans_date, trans_states, client_id, telstar_account_name, amount, ipaddress, transaction_code ) 
				VALUES 
				( NOW(), '{$data['trans_states']}', '{$data['client_id']}', '{$data['telstar_account_name']}', '{$data['amount']}', '{$data['ipaddress']}', '{$data['MErrMsg']}' )";
		return $this->executeNoneQuery( $sql );
	}
	
	function getTransactions($data=NULL)
	{
		$query1 = ( !empty($data['sortby'])  )? "ORDER BY {$data['sortby']} {$data['ord']}" : "ORDER BY trans_date DESC";
		$query2 = ( !empty($data['status'])  )? "AND trans_states = \"{$data['status']}\"" : "";
		$query3 = ( !empty($data['strdate']) )? "AND DATE_FORMAT(trans_date, '%Y-%m-%d') >= '{$data['strdate']}'" : "";
		$query4 = ( !empty($data['enddate']) )? "AND DATE_FORMAT(trans_date, '%Y-%m-%d') <= '{$data['enddate']}'" : "";
		/* FOR TODAYS LIST*/
		$query5 = ( !empty($data['now']) )? "AND DATE_FORMAT(trans_date, '%Y-%m-%d') = '{$data['now']}'" : "";
				
		$sql = "SELECT * FROM odb_transaction WHERE 0=0 $query5 $query3 $query4 $query2 $query1";
		return $this->executeQuery( $sql, true );
	}
	
	function getStatus()
	{
		$sql = "SELECT DISTINCT(trans_states) FROM odb_transaction ORDER BY trans_states";
		return $this->executeQuery( $sql, true );
	}
	
	function getCountry()
	{
		$sql = "select * from odb_country order by ord ASC";
		return $this->executeQuery( $sql, true );
	}
	
	function getCountryByCode($code)
	{
		$sql = "select name from odb_country where iso_code_2 = '$code'";
		return $this->executeQuery( $sql, false );
	}
	
}
?>