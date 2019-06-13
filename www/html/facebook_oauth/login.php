<?php
require 'Core/Credentials.php';
session_start();

// Unsets the access token
unset($_SESSION['access_token']);

// Defines a state that can be checked later and stores it into the session
$_SESSION['state'] = bin2hex(random_bytes(16));

// Url Parameters
$params = [
	'response_type' => 'code',
	'client_id' => Credentials::FACEBOOK_APP_ID,
	'redirect_uri' => Credentials::baseURL() . '/callback',
	'scope' => 'email',
	'state' => $_SESSION['state']
];
 
// Redirect the user to Facebook's authorization page
header('Location: '.Credentials::AUTHORIZE_URL .'?'.http_build_query($params));
die();
