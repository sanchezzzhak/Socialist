<?php namespace Tutik\Socialist;

/**
 * Class GooglePlus API
 * @package Tutik\Socialist
 */
class GooglePlus {

    protected
		$oauthToken,
		$curl,
        $app_id,
        $app_key;


    public function __construct($config)
    {
        $this->app_id  = $config['app_id'];
        $this->app_key = $config['app_key'];
		
		$this->curl = curl_init();
		
		 curl_setopt_array($this->curl, array
		 (
            CURLOPT_HEADER         => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_CONNECTTIMEOUT => 20,
            CURLOPT_TIMEOUT 	   => 30,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false
        ));
        curl_setopt($this->curl, CURLOPT_POST, false);
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, null);
    }
	
	
    public function api($method , $arg)
    {
		$headers = array();
		$headers[] = "Authorization: OAuth " . $this->oauthToken;
	
		$url = '';
		
		curl_setopt($this->curl, CURLOPT_URL, $url);
		
		curl_setopt($this->curl, CURLOPT_POST, false);
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, null);
		curl_setopt($this->curl, CURLOPT_URL, $headers);
		return curl_exec($this->curl);
    }
	
	public function getAccessToken($code = null, $isRefresh = false)
	{
		$data = array();
		if (!$isRefresh):
			$data['code'] = $code;
			$data['client_id'] = $this->app_id;
			$data['client_secret'] = $this->app_key;
			$data['redirect_uri'] = $this->callbackUrl;
			$data['grant_type'] = 'authorization_code';
			$data['scope'] = null;
		else:
			$data['client_id'] = $this->app_id;
			$data['client_secret'] = $this->app_key;
			$data['refresh_token'] = $code;
			$data['grant_type'] = 'refresh_token';
		endif;
		
		curl_setopt($this->curl, CURLOPT_POST, true);
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, $data);
		curl_setopt($this->curl, CURLOPT_URL, 'https://accounts.google.com/o/oauth2/token');
		
		$result = curl_exec($this->curl);
		
		if( in_array( curl_getinfo($this->curl, CURLINFO_HTTP_CODE ) , array(400,401))  )
		{
			
		}
		
	}
	
	
	
	public function setOAuthToken($token)
	{
		$this->oauthToken = $token;
	}
	
	
}



