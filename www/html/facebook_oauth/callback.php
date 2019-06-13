<?php
require 'Core/ApiRequest.php';
require 'Core/Credentials.php';
session_start();

// Checks if Authorization code was set
if(isset($_GET['code'])) {

// Checks the original generated state and invalidates the login if it's not equal
if( !isset($_GET['state']) || $_SESSION['state'] != $_GET['state'] ) {
	header('Location: ' . Credentials::baseURL() . '?error=invalid_state');
	die();
}

// Exchange the Authorization code for an access token
$token = ApiRequest::send(Credentials::TOKEN_URL, [
	'grant_type' => 'authorization_code',
	'client_id' => Credentials::FACEBOOK_APP_ID,
	'client_secret' => Credentials::FACEBOOK_APP_SECRET,
	'redirect_uri' => Credentials::baseURL() . '/callback',
	'code' => $_GET['code']
]);

// Stores the access token into the session
$_SESSION['access_token'] = $token["access_token"];

}

// Redirects the user to the main page
header('Location: ' . Credentials::baseURL());
die();