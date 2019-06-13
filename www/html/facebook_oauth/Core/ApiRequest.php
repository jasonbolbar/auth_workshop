<?php

class ApiRequest {

	const DEFAULT_HEADERS = [
		'Accept: application/json',
		'User-Agent: https://oauth.facebook.authworkshop.com/'
  	];

    /**
    * Performs a request using a set of options
    * @param $url request url
    * @param $post post body or null
    * @param $headers set of headers
    * @return response in array format
    **/
	public static function send($url, $post=FALSE, $headers=array())
	{
		$curl = self::initCurl( $url );
		$headers = self::setAccessToken(self::DEFAULT_HEADERS);
		self::configureCurl( $curl, $post, $headers );
		return json_decode(curl_exec($curl), true);
	}

    /**
    * Inits a CURL instance
    * @param $url Request URL
    * @return curl instance
    **/
	private static function initCurl($url)
	{
		return curl_init( $url );
	}

    /**
    * Configures the curl instance in order to return the response and set the post body in case it's a post request
    * @param $curl curl instance
    * @param $post post body or null
    * @param $headers set of headers
    * @return void
    **/
	private static function configureCurl($curl, $post, $headers)
	{
		curl_setopt( $curl, CURLOPT_RETURNTRANSFER, TRUE );
		if($post)
		{
			curl_setopt( $curl, CURLOPT_POSTFIELDS, http_build_query($post) );
		}
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
	}

    /**
    * Sets the access token in case it's available in the session
    * @param $headers set of headers
    * @return headers set with the access token
    **/
	private static function setAccessToken($headers)
	{
		if(isset($_SESSION['access_token']))
		{
			$headers[] = 'Authorization: Bearer '.$_SESSION['access_token'];
		}
		return $headers;
	}
}