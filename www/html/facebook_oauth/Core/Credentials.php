<?php

class Credentials
{
	const FACEBOOK_APP_ID= '299073131005192';
	const FACEBOOK_APP_SECRET = '4638d0fca7457ee8ae868c688059b13b';
	const AUTHORIZE_URL = 'https://www.facebook.com/v3.3/dialog/oauth';
	const TOKEN_URL = 'https://graph.facebook.com/v3.3/oauth/access_token';
	const API_BASE = 'https://graph.facebook.com';

	public static function baseURL()
	{
		return 'https://' . $_SERVER['SERVER_NAME'];
	}
 
}