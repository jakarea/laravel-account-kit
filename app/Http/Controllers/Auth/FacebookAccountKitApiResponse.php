<?php

class FacebookAccountKitApiResponse
{	
	private  $code;
	private  $app_id;
	private  $app_secret;
	private  $access_token;	
	
	private  $ch;
	private  $user_access_token;
	private  $appsecret_proof;
	private  $user_account_kit_info;
	
	
	function __construct($ResponseCode) {
		
		$this->code = $ResponseCode;
		
		$this->app_id = "1461990380583214";
		
		$this->app_secret = "b0ac72d5ac3e7da57ec451cac34d084b";
		
		$this->access_token = "AA|{$this->app_id}|{$this->app_secret}";	

       
		//initial curl
		$this->ch = curl_init();		
		//return the transfer as a string
		curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);
		 
	}
	
	
	function getUserAccessTokenByAuthorizationCode()
	{
		//GET https://graph.accountkit.com/v1.0/access_token?grant_type=authorization_code&code=<authorization_code>&access_token=AA|<facebook_app_id>|<app_secret>
		
		// set url
		curl_setopt($this->ch, CURLOPT_URL, "https://graph.accountkit.com/v1.0/access_token?grant_type=authorization_code&code={$this->code}&access_token={$this->access_token}");

		// $output contains the output string
		
		$curl_result = json_decode(curl_exec($this->ch));
		
		if(isset($curl_result->access_token))
		{
			$this->user_access_token = $curl_result->access_token;
			
			return array('curl_result'=>$curl_result,'status'=>true);
		}
		else
		{						
			return array('curl_result'=>$curl_result,'status'=>false);			
		}		
		
		
	}
	
	function makeAppSecretProof()
	{
		 //$appsecret_proof = hash_hmac('sha256', $access_token, $app_secret); 
		 
		 $this->appsecret_proof = hash_hmac('sha256', $this->user_access_token, $this->app_secret);	
		
	}
	
	function getAccountKitAccountInfo()
	{
				
		// set url
		curl_setopt($this->ch, CURLOPT_URL, "https://graph.accountkit.com/v1.0/me/?access_token={$this->user_access_token}&appsecret_proof={$this->appsecret_proof}");

		// $output contains the output string
		$this->user_account_kit_info = json_decode(curl_exec($this->ch));
		
		return $this->user_account_kit_info;			
		
	}
	
	function __destruct() {
		
		curl_close($this->ch);		
	}	
	
}
?>