<?php

class Chat_model extends CI_Model
{
    public function __construct(){
       $this->appid=$this->ts_functions->getsettings('chat','appid');
	   $this->authkey=$this->ts_functions->getsettings('chat','authkey');
	   $this->authsecret=$this->ts_functions->getsettings('chat','authsecret');
    }
    
	
   function registerSession($fullname,$email,$tags,$mobile=''){

	DEFINE('QB_API_ENDPOINT1', "https://api.quickblox.com");
	DEFINE('QB_PATH_SESSION1', "users.json");
	 
	$session = $this->createSession();
	$token = $session->token;
    $post_body = http_build_query( array(
    'user[login]' => $email,
    'user[password]' =>'12345678',
    'user[email]'=>$email,
    'token' =>$token,
    'user[tag_list]' => $tags,
    'user[full_name]' =>$fullname,
    'user[phone]' =>$mobile
   )); 

   $curl = curl_init();
   curl_setopt($curl, CURLOPT_URL, QB_API_ENDPOINT1 . '/' . QB_PATH_SESSION1); // Full path is - https://api.quickblox.com/session.json
   curl_setopt($curl, CURLOPT_POST, true); // Use POST
   curl_setopt($curl, CURLOPT_POSTFIELDS, $post_body); // Setup post body
   curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); // Receive server response
   $response = curl_exec($curl);
 }

  function createSession() {
	$appId  =$this->appid;
    $authKey =$this->authkey;
    $authSecret=$this->authsecret; 

   DEFINE('QB_API_ENDPOINT', "https://api.quickblox.com");
   DEFINE('QB_PATH_SESSION', "session.json");

   if (!$appId || !$authKey || !$authSecret ) {
    return false;
   }

  // Generate signature
   $nonce = rand();
   $timestamp = time(); // time() method must return current timestamp in UTC but seems like hi is return timestamp in current time zone
   $signature_string = "application_id=" . $appId . "&auth_key=" . $authKey . "&nonce=" . $nonce . "&timestamp=" . $timestamp;

   $signature = hash_hmac('sha1', $signature_string , $authSecret);

  // Build post body
  $post_body = http_build_query( array(
    'application_id' => $appId,
    'auth_key' => $authKey,
    'timestamp' => $timestamp,
    'nonce' => $nonce,
    'signature' => $signature,
  ));

  $curl = curl_init();
  curl_setopt($curl, CURLOPT_URL, QB_API_ENDPOINT . '/' . QB_PATH_SESSION); // Full path is - https://api.quickblox.com/session.json
  curl_setopt($curl, CURLOPT_POST, true); // Use POST
  curl_setopt($curl, CURLOPT_POSTFIELDS, $post_body); // Setup post body
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); // Receive server response

  // Execute request and read response
   $response = curl_exec($curl);
   
  $responseJSON = json_decode($response)->session;

  // Check errors
  if ($responseJSON) {
    return $responseJSON;
  } else {
    $error = curl_error($curl). '(' .curl_errno($curl). ')';
    return $error;
  }

  curl_close($curl);

 }

// get id of user
  function getUserID($login){
	  $session = $this->createSession();
	  $token = $session->token;
		
	  $ch = curl_init();
	  $headers = array( 'Content-Type: application/x-www-form-urlencoded',);
	  curl_setopt($ch, CURLOPT_URL, 'https://api.quickblox.com/users/by_login.json?login='.$login.'&token='.$token);
	  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	  curl_setopt($ch, CURLOPT_HEADER, 0);
	  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	  $response = curl_exec($ch);
	  $response=json_decode($response);
		  if(isset($response->user->id)){
			 $id =$response->user->id;
		  }else{
			$id =0;  
		  }
	  return $id;
  }


  } 