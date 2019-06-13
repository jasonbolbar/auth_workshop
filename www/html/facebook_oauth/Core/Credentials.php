<?php

class Credentials
{
	const FACEBOOK_APP_ID= '<application id goes here>';
	const FACEBOOK_APP_SECRET = '<client_secret_goes_here>';
	const AUTHORIZE_URL = 'https://www.facebook.com/v3.3/dialog/oauth';
	const TOKEN_URL = 'https://graph.facebook.com/v3.3/oauth/access_token';
	const API_BASE = 'https://graph.facebook.com';

	public static function baseURL()
	{
		return 'https://' . $_SERVER['SERVER_NAME'];
	}
 
}
