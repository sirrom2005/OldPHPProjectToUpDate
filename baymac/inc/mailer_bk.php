<?php 
class Mailer
{

	public function __construct(){
	}
	
	
	public function sendForReg($email, $hash, $flname){
		$encoded_email = urlencode($email);
		$from = "From: ".EMAIL_FROM_NAME." <".EMAIL_FROM_ADDR.">";
		$subject = "Baymac Registration";
    /* Temporarily disable activation link
		$body = "Hi ".$flname."\n\n"
			 ."You recently registered on baymac.net. You must confirm your account to complete the registration process. "
             ."Click on the link below to activate your account:\n\n"
			 .CONFIRMACCOUNTLINK."?hash=$hash&email=$encoded_email";
    */   
       
		$body = "Hi ".$flname."\n\n"
			 ."You recently registered on baymac.net. Your registration is being processed and we will contact you shortly. ";      

		return mail($email,$subject,$body,$from);
	}
	
	public function sendMail($emailtosend,$message_subject,$message_body,$headers){
		return mail($emailtosend,$message_subject,$message_body,$headers);
	}
   
};
?>
