<?php
//echo "<pre>"; print_r($_SERVER); exit();
	include_once("config/config.php");
	include_once("classes/mySqlDB__.class.php");
	include_once("classes/software.class.php");
	include_once("classes/pagination.class.php");
	
	$obj = new software();
	
	$data['sortby'] = "trans_date";
	$data['ord'] 	= "desc";
	$data['status'] = "Successful payment";
	$data['now'] 	= date("Y-m-d", strtotime("-1 day"));
	
	$result = $obj->getTransactions($data);

	$csv 	= "Date,Account No,Account Name,Amount Paid\r\n";
	$date 	= date("Ymd");
	
	$i		= 0;
	$total 	= 0;
	$ph	    = "";
	$dph    = ""; 
	if(!empty($result))
	{
		foreach($result as $row)
		{			
			$clientId = $row['client_id'];
			for($x=strlen($clientId); $x<6; $x++){ $ph .="0"; }
				$clientId  = $ph.$clientId;
			
			$amount = str_replace(".", "", number_format($row['amount'], 2, "", "")); 
	 		for($z=strlen($amount); $z<10; $z++){ $dph .="0"; } 
				$amount = $dph.$amount;
				
			$dt = date("Ymd", strtotime($row['trans_date']));
				
			$str .= "0{$clientId}{$amount}1{$dt}\r\n"; 
			$csv .= date("dMy", strtotime($row['trans_date'])).",{$row['client_id']},{$row['telstar_account_name']},".number_format($row['amount'], 2, ".", "")."\r\n";
			$i++;
			
			$total += $row['amount'];
			$ph  = "";
			$dph = "";
		}
		
		$csv .= "\r\nNo. of Payments: $i\r\nTotal Amount Paid: ".number_format($total, 2, ".", "");
		
		for($c=strlen($i); $c<6; $c++){ $ph .="0"; } 
		$i = $ph.$i;
		$ph = "";
		
		$total = str_replace(".", "", number_format($total, 2, "", ""));
		for($c=strlen($total); $c<10; $c++){ $ph .="0"; } 
		$total  = $ph.$total;
		$ph ="0"; 

		$str .= "9{$i}{$total}1{$date}";
	}
			
	$fp1 = fopen("report/report_{$data['now']}.dat", "w");
	if( fwrite($fp1, $str, strlen($str)) ){ echo "<b>Report file added...</b>"; }else{ exit("Error creating dat file"); }
	fclose($fp1);
	
	$fp2 = fopen("report/report_{$data['now']}.csv", "w");
	if( fwrite($fp2, $csv, strlen($csv)) ){ echo "<b><br>CSV file added...</b>"; }else{ exit("Error creating csv file"); }
	fclose($fp2);

	if(!empty($result))
	{
		$to 	= "roma040662@yahoo.com, judianstewart.telstar@yahoo.com, flodarby@hotmail.com";
		$sub 	= "Daily Transaction reports";
		$mes	= "Daily Transaction reports<br>Click the following links to download file.<br>[<a href='http://www.telstarjamaica.com/billpayment/report/file.php?f=report_{$data['now']}.dat'>DAT</a>] [<a href='http://www.telstarjamaica.com/billpayment/report/file.php?f=report_{$data['now']}.csv'>CSV</a>]";
		$hdr	= "Content-type: text/html; charset=iso-8859-1" . "\r\n";
		$hdr .= "From: no-reply@telstarjamaica.com\r\n";
		
		if(mail($to, "Daily Transaction report", $mes, $hdr))
		{
			echo "<br>Message sent...";
		}
	}
?>