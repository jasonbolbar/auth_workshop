<?php
require 'Core/Credentials.php';
session_start();

// Removes the access token from the session
unset($_SESSION['access_token']);

// Redirects the user to the main page
header('Location: ' . Credentials::baseURL());