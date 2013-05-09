<?php
	//Use SendGrid for mailing
	require_once("sendgrid-php/SendGrid_loader.php");

	function email($em, $subject, $message = '') 
	{

		try{
			$sendgrid = new SendGrid('', '');

			$mail = new SendGrid\Mail();
			$mail->addTo($em)
				->setFrom('sayhello@opengovfoundation.org')
				->setSubject($subject)
				->setText($message);

			$sendgrid->smtp->send($mail);
		}	
		catch(Exception $e){
			error_log($e);
			return false;
		}

		return true;
	}

	//declare our assets 
	$name = stripcslashes($_POST['name']);
	$emailAddr = stripcslashes($_POST['email']);
	$comment = stripcslashes($_POST['message']);
	$subject = stripcslashes($_POST['subject']);	
	$contactMessage =  
		"Message:
		$comment 

		Name: $name
		E-mail: $emailAddr

		Sending IP:$_SERVER[REMOTE_ADDR]
		Sending Script: $_SERVER[HTTP_HOST]$_SERVER[PHP_SELF]";
		
		
		
		//send the email 
		email('sayhello@opengovfoundation.org', $subject, $contactMessage);
		echo('success'); //return success callback
		
		
		
?>