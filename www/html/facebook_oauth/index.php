<?php
require 'Core/ApiRequest.php';
require 'Core/Credentials.php';
session_start();


echo <<<HTML
	<html>
		<header>
			<title>Facebook Login Page</title>
			<link rel="stylesheet" href="styles.css">
		</header>
		<body>
			<h1>Facebook Login Page</h1>
HTML;
if(!empty($_SESSION['access_token'])) 
{
	$userInfo = (object) ApiRequest::send( Credentials::API_BASE . "/me");
	echo <<<HTML
		<h3>Logged In</h3>
		<img src="https://graph.facebook.com/{$userInfo->id}/picture?type=large">
		<p>Username: {$userInfo->name}</p>
		<p>
			<a href="/logout">Log Out</a>
		</p>
HTML;
} 
else 
{
  	echo <<<HTML
  		<h3>Not logged in</h3>
  		<p>
  			<a href="/login">Log In</a>
		</p>
HTML;
}
echo '</body></html>';