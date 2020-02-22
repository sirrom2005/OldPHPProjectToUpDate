<?php	
session_start();
/******************************************************************************
  This code is an example only and is not officially supported by Plug N Pay
  Technologies inc.  If you are having problems with PHP please refer to
  http://www.php.net for help.  If you are having problems using the API please
  check the documentation in the admin area first.  If you don't find an answer
  submit a helpdesk item.

  If you are using this script please READ all documentation included with it and
  the API specification.

  This script requires a working implementation of curl (internal or external to PHP).
  If you receive any error messages like this:

    Fatal error: Call to undefined function: curl_init() in "your script here"

  It is because your installation of PHP was not configured to support curl.
  Contact your system administrator to have curl setup.

  Version 1.01

  ChangeLog:

  v1.00
    Develop Chicken Pox
    Get bored.
    Learn PHP.
    Write the module.
    Total Time 15 minutes.

  v1.00 - 10/08/2003
    Updated code for generating pnp_transaction_array so it
    doesn't include junk from parsing the results.  Thanks art.
    This will not affect old code and should work the same.

  v1.01 - 10/05/2004
    Add ability to use curl, even when curl is not compiled into PHP
    Added code to select if curl is compiled or not into PHP & set the curl file path
    Added curl parameter which can be uncommented for windows 2003 compatibility
    Updated some of the comments to help users understand what us happening & what to do

  v1.01 - 01/14/2005
    Fixed non-compile curl usage error with returned array & decoding

  v1.01 - 06/02/2005
    Updated format of the response HTML pages
    Updated response message in error.html page.
*******************************************************************************/
    /*
      Set script parameters & answer questions down here...
    */

    // Is curl complied into PHP? 
    $is_curl_compiled_into_php = "yes"; 
    // Possible answers are: 
    //  'yes' -> means that curl is compiled into PHP [DEFAULT]
    //  'no'  -> means that curl is not-compiled into PHP & must be called externally

    // If you selected 'no' to the above question, then set the absolute path to curl
    $curl_path = "/usr/bin/curl";
    // [e.g.: '/usr/bin/curl' on Unix/Linux or 'c:/curl/curl.exe' on Windows servers] 
    // If you are unsure of this, check with your hosting company.

    // Set URL that you will post the transaction to
    $pnp_post_url = "https://pay1.plugnpay.com/payment/pnpremote.cgi";
    // This should never need to be changed...


    /*
      This is where you build the query string to be posted to plugnpay.  You
      can replace this code with your own or you need to follow the instructions
      in the README file for calling this script.
    */
	
	//clean money value
	$cardValueAmount = (float)preg_replace("/[^0-9.]/", "", $_POST['card_amount']);

    if ($pnp_post_values == "") {
        $pnp_post_values .= "publisher-name=" . $_POST['publisher_name'] . "&";
        $pnp_post_values .= "card-number=" . $_POST['card_number'] . "&";
        $pnp_post_values .= "card-cvv=" . $_POST['card_cvv'] . "&";
        $pnp_post_values .= "card-exp=" . $_POST['card_exp'] . "&";
        $pnp_post_values .= "card-amount=" . $cardValueAmount . "&"; 
        $pnp_post_values .= "card-name=" . $_POST['card_name'] . "&";
        $pnp_post_values .= "publisher-email=" . $_POST['publisher_email'] . "&";
        $pnp_post_values .= "ipaddress=" . $_POST['ipaddress'] . "&";
		$pnp_post_values .= "currency=" . $_POST['currency'] . "&";
        // billing address info
        $pnp_post_values .= "card-address1=" . $_POST['card_address1'] . "&";
        $pnp_post_values .= "card-address2=" . $_POST['card_address2'] . "&";
        $pnp_post_values .= "card-zip=" . $_POST['card_zip'] . "&";
        $pnp_post_values .= "card-city=" . $_POST['card_city'] . "&";
        $pnp_post_values .= "card-state=" . $_POST['card_state'] . "&";
        $pnp_post_values .= "card-country=" . $_POST['card_country'] . "&";
	 // ADDTION
	 $pnp_post_values .= "mode" . $_POST['mode'] . "&";
        // shipping address info
        /*$pnp_post_values .= "shipname=" . $_POST['shipname'] . "&";
        $pnp_post_values .= "address1=" . $_POST['card_address1'] . "&";
        $pnp_post_values .= "address2=" . $_POST['card_address2'] . "&";
        $pnp_post_values .= "zip=" . $_POST['card_zip'] . "&";
        $pnp_post_values .= "state=" . $_POST['card_state'] . "&";
        $pnp_post_values .= "country=" . $_POST['card_country'] . "&";*/
    }


    /**************************************************************************
      UNLESS YOU KNOW WHAT YOU ARE DOING YOU SHOULD NOT CHANGE THE BELOW CODE
    **************************************************************************/

    if ($is_curl_compiled_into_php == "no") {
      // do external PHP curl connection 
      exec("$curl_path -d \"$pnp_post_values\" https://pay1.plugnpay.com/payment/pnpremote.cgi", $pnp_result_page);
      // NOTES:
      // -- The '-k' attribute can be added before the '-d' attribute to turn off curl's SSL certificate validation feature.
      // -- Only use the '-k' attribute if you know your curl path is correct & are getting back a blank response in $pnp_result_page.

      $pnp_result_decoded = urldecode($pnp_result_page[1]);
    }
    else {
      // do internal PHP curl connection
      // init curl handle
      $pnp_ch = curl_init($pnp_post_url);
      curl_setopt($pnp_ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($pnp_ch, CURLOPT_POSTFIELDS, $pnp_post_values);
      #curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);  // Upon problem, uncomment for additional Windows 2003 compatibility

      // perform ssl post
      $pnp_result_page = curl_exec($pnp_ch);

      $pnp_result_decoded = urldecode($pnp_result_page);
    }

    // decode the result page and put it into transaction_array
    $pnp_temp_array = split('&',$pnp_result_decoded);
    foreach ($pnp_temp_array as $entry) {
        list($name,$value) = split('=',$entry);
        $pnp_transaction_array[$name] = $value;
    }

    /**************************************************************************
        UNLESS YOU KNOW WHAT YOU ARE DOING DO NOT CHANGE THE ABOVE CODE
    **************************************************************************/


    /*
       These statements handle the results for the transaction and where
       the customer is sent next.  If you don't want this script to handle
       the final transaction process set $pnp_handle_post_process="no" and
       it will be skipped.  You can edit the sepearate HTML files to look
       the way you want them to or each can be replaced with a php script.
       Your php scripts should use $pnp_transaction_array[] to check the
       transaction status.  All the documented plugnpay fields should be
       valid in pnp_transation_array.
    */ 
	
	$_SESSION['DATA'] = $_POST;
	$len = strlen($_SESSION['DATA']["card_number"]);
	$cardnumber = preg_split("//", $_SESSION['DATA']["card_number"], -1, 1);
    $str = $len-5; 
	$end = $len-1; 
	$cnumber = NULL;

	for($i=$str; $i<=$end; $i++)
	{
		$cnumber .= $cardnumber[$i];
	}
 	
	$_SESSION['DATA']["card_number"] 	= $cnumber;
	$_SESSION['DATA']['TRANS_CODE']  	= $pnp_transaction_array['MErrMsg'];
	$_SESSION['DATA']['orderID']  		= $pnp_transaction_array['orderID'];
	$_SESSION['DATA']['card_amount']	= number_format($cardValueAmount,2,'.',',');//format for email
	unset($_SESSION['DATA']["card_cvv"]);
	unset($_SESSION['DATA']["publisher_email"]);
	unset($_SESSION['DATA']["ipaddress"]);
	unset($_SESSION['DATA']["publisher_name"]);
	unset($_SESSION['DATA']["mode"]);
	unset($_SESSION['DATA']["card_exp"]);	
	
	if($pnp_handle_post_process != "no") 
	{
		include_once("../config/config.php");
		include_once("../classes/mySqlDB__.class.php");
		include_once("../classes/software.class.php");
		
		$obj = new software();
		
		$data = array();
		$data['amount']  	= $cardValueAmount;
		$data['client_id']	= $_POST['client_id'];
		$data['ipaddress']	= $_POST['ipaddress'];
		$data['telstar_account_name']	= $_POST['telstar_account_name'];
		$data['MErrMsg']	= $pnp_transaction_array['MErrMsg'];
		
		if($pnp_transaction_array['FinalStatus'] == "success")
		{
			$data['trans_states'] = "Successful payment";
			if($obj->addTransaction($data))
				header("location: ../payment.php");
		}
		elseif($pnp_transaction_array['FinalStatus'] == "badcard") 
		{
			$data['trans_states'] = "Badcard";
			if($obj->addTransaction($data))
				header("location: ../payment.php?&err=".base64_encode("1"));
		}
		elseif($pnp_transaction_array['FinalStatus'] == "fraud") 
		{
			$data['trans_states'] = "Fraudulent payment";
			if($obj->addTransaction($data))
				header("location: ../payment.php?err=".base64_encode("2"));
		}
		elseif($pnp_transaction_array['FinalStatus'] == "problem") 
		{
			$data['trans_states'] = "System error";
			if($obj->addTransaction($data))
				header("location: ../payment.php?err=".base64_encode("3"));
		}
		else 
		{
			$data['trans_states'] = "Unknown error";
			if($obj->addTransaction($data))
				header("location: ../payment.php?err=".base64_encode("4"));
		}
	}
?>