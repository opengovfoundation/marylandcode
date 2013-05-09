<?php

$email = $_POST['email'];
if (filter_var($email_a, FILTER_VALIDATE_EMAIL)){
	echo json_encode(array('success'=>false, 'msg'=>'Please enter a valid email.'));
}

require_once('../includes/MCAPI.class.php');

//API Key - see http://admin.mailchimp.com/account/api
$apikey = '';

// A List Id to run examples against. use lists() to view all
// Also, login to MC account, go to List, then List Tools, and look for the List ID entry
$listId = '';

$api = new MCAPI($apikey);

$retval = $api->listSubscribe($listId, $email);

if($api->errorCode){
	$toReturn = array(
		'success'	=>	false,
		'msg'		=>	$api->errorMessage
	);
}else{
	$toReturn = array(
		'success'	=>	true,
		'msg'		=>	'Subscribed - look for the confirmation email.'
	);
}

echo json_encode($toReturn);
