<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Authentication extends CI_Controller {
	
	private $userID;
	
	function __construct() {
		parent::__construct();
		if($this->ts_functions->dd_uid != ''){
			redirect(base_url().'admin');
		}
		$this ->load->model('Chat_model');
	}
	
	
	public function index(){
		$this->load->view('user/common/header_auth');
		$this->load->view('user/login');
		$this->load->view('user/common/footer_auth');
	}
	
	public function verify($key=''){
	    if($key != '') {
	        $res = $this->DatabaseModel->select_data('*','dd_users',array('user_key'=>$key,'user_status'=>2));
			
	        if( !empty($res) ) {
	            $this->DatabaseModel->access_database('dd_users','update',array('user_status'=>1,'user_key'=>''),array('user_key'=>$key));
	        }
	    }
	 echo "<h1>".$this->ts_functions->getlanguage('accountverifysuccess','authentication','solo')."</h1>";
		//redirect(base_url().'authentication');
	}
	
	public function login(){
		if(isset($_POST['user_email'])){
		$user_email=$_POST['user_email'];
		$user_pass=$_POST['user_pass'];
		$user_offset=$_POST['user_offset'];
		}else{
		   $user_email=$_POST['email'];
		   $user_pass=$_POST['password'];
		   $user_offset=-($_POST['user_offset']);
		}
		$result = $this->DatabaseModel->select_data('*','dd_users',array('user_email'=>$user_email,'user_pass'=>md5($user_pass) ,'user_deleted'=>0));
		if(empty($result)){
		 //  echo 0; die; // Login credentials don't match
		 $message=$this->ts_functions->getlanguage('loginerror','message','solo');
         $resp=array('status' => 'false','message'=>$message, 'data' => '0' );	   
		}else if($result[0]['user_status'] == '2') {
          $message=$this->ts_functions->getlanguage('actvtacnt_text','message','solo');
		  $resp=array('status' => 'false','message'=> $message, 'data' => '2' );
		} else if($result[0]['user_status'] == '3') {
		 $message=$this->ts_functions->getlanguage('blockacnt_text','message','solo');
		  $resp=array('status' => 'false','message'=>$message, 'data' => '3' );
		}else{
		
         /**device token**/
		 if(isset($_POST['device_id']) && isset($_POST['device_type']) && isset($_POST['device_token'])){
			$update_arr = array(
				'user_device_id' => $_POST['device_id'],
				'user_device_type' => $_POST['device_type'],
				'user_device_token' => $_POST['device_token']
			);
			$this->DatabaseModel->access_database('dd_users', 'update', $update_arr, array('user_id' => $result[0]['user_id']));
		 }
         /**device token**/
             $this->DatabaseModel->access_database('dd_users' , 'update' , array('user_offset'=>$user_offset) , array('user_id' =>$result[0]['user_id']));
		 
		     if(isset($_POST['user_email'])){
				 $user_details	= array(
					'dd_uid'		=> $result[0]['user_id'],
					'dd_email'		=> $result[0]['user_email'],
					'dd_uname'		=> $result[0]['user_name'],
					'dd_level'		=> $result[0]['user_level'],
				 );

				$this->session->set_userdata($user_details);

				if($_POST['rem'] == '1'){
					setcookie("dd_emanu", $user_email , time()+3600 * 24 * 14,'/');
					setcookie("dd_dwp", $user_pass , time()+3600 * 24 * 14,'/');
				}
				elseif($_POST['rem'] == '0')
				{
					setcookie("dd_emanu", $user_email , time()-3600 * 24 * 365,'/');
					setcookie("dd_dwp", $user_pass , time()-3600 * 24 * 365,'/');
				 }
		    }else{
				
			} 
			
			if($this->ts_functions->getsettings('chat','status') == '1'){
			$this->Chat_model->registerSession($result[0]['user_name'],$result[0]['user_email'],'User');
			}
			$message=$this->ts_functions->getlanguage('loginsuc','message','solo');
			$results=$result[0];
			$results['user_address'] =$this->ts_functions->get_user_meta($result[0]['user_id'], 'address' );
	        $results['user_age'] =$this->ts_functions->get_user_meta($result[0]['user_id'] , 'age' );
			$resp=array('status' => 'true','message'=>$message, 'data' =>$results,'base_url' => base_url()); 
			}
      echo json_encode($resp);			
	}
	
	function signup(){
		if(isset($_POST['user_name'])){
			$user_name  =   $_POST['user_name'];
			$user_email = $_POST['user_email'];
			$user_pass  =  $_POST['user_pass'];
		}else{
			$user_name  =   $_POST['fullname'];
			$user_email = $_POST['email'];
			$user_pass  =  $_POST['password'];
		}
        $checkEmail = $this->DatabaseModel->select_data('user_email','dd_users',array('user_email'=>$user_email,'user_deleted'=>0));
		if(empty($checkEmail)) {
			$key = md5(date('his').$user_email);
			$data_arr	= array('user_name'=>$user_name,'user_email'=>$user_email,'user_pass'=>md5($user_pass),'user_level'=>2,'user_status'=>2);
			$data_arr['user_key'] = $key;
			$data_arr['user_registerdate'] = date('Y-m-d H:i:s');

			$uid = $this->DatabaseModel->access_database('dd_users','insert',$data_arr,'');
			$reg_data=array();
			if(isset($_POST['fullname'])){
				$reg_data = array(
					'user_name' => $_POST['fullname'],
					'user_email' => $_POST['email'],
					'user_pass' => md5($_POST['password']),
					'user_mobile' => $_POST['mobile'],
					'user_gender' => $_POST['gender'],
					'user_city' => $_POST['city'],
					'user_level' => $_POST['level'],
					'user_device_id' => $_POST['device_id'],
					'user_device_type' => $_POST['device_type'],
					'user_device_token' => $_POST['device_token'],
					'user_status' => 2
				);
              $this->DatabaseModel->access_database('dd_users','update',$reg_data,array('user_id' =>$uid));				
			}
			

		 	$this->ts_functions->sendnotificationemails('registrationemail',$user_email,'Verification Link',$user_name,base_url().'authentication/verify/'.$key);
            $message=$this->ts_functions->getlanguage('registersuc','message','solo');
			$resp=array('status' => 'true','message'=>$message, 'data' =>$reg_data);
		}else {
			$message=$this->ts_functions->getlanguage('emailexists','message','solo');
			$resp=array('status' => 'false','message'=>$message, 'data' => array());
			
		}
		 echo json_encode($resp);
	}
	
  function fwd_section(){
		$result = $this->DatabaseModel->select_data('*','dd_users',array('user_email' => $_POST['email']));
		if(empty($result)){
			$message=$this->ts_functions->getlanguage('forgotpwderror','message','solo');
			$resp=array('status' => 'false' , 'message'=>$message, 'data'=>'' );
		}elseif($result[0]['user_status'] == '2') {
			$message=$this->ts_functions->getlanguage('actvtacnt_text','message','solo');
		  $resp=array('status' => 'false','message'=> $message, 'data' => '2' );
		}elseif($result[0]['user_status'] == '3') {
		  $message=$this->ts_functions->getlanguage('blockacnt_text','message','solo');
		  $resp=array('status' => 'false','message'=>$message, 'data' => '3' );
		}else{
			$uid = $result[0]['user_id'];
			$key = md5(date('Ymdhis').$uid);
			$this->DatabaseModel->access_database('dd_users','update',array('user_key'=>$key),array('user_id'=>$uid));
			$this->ts_functions->sendnotificationemails('forgotpwdemail', $result[0]['user_email'], 'Forgot Password' , $result[0]['user_name'] , base_url().'authentication/reset_password/'.$key );
            $message=$this->ts_functions->getlanguage('forgotpassword','message','solo');			
			$resp=array('status' => 'true' , 'message'=>$message, 'data'=>'' );
			
		}  
        echo json_encode($resp);
		
	}
	
	
	// Reset Password

	function reset_password($key=''){
	    if($key == '') {
		redirect(base_url()); 	
		} 
		$res = $this->DatabaseModel->select_data('*','dd_users',array('user_key'=>$key),1);
	    
		$data['invalidAccess'] = (!empty($res)) ? 0 : 1 ;
		if(empty($res)){
			 $this->session->userdata['ts_error'] = $this->ts_functions->getlanguage('invalidresetkey','message','solo');;
			 redirect(base_url());
		}
		$data['pwdKey'] = $key;
		$data['basepath'] = base_url();
		$data['name_of_page'] = 'resetpwd'; 
		$data['reset_password']=1;
        $this->load->view('user/common/header_auth' ,$data);
		$this->load->view('user/login' ,$data);
		$this->load->view('user/common/footer_auth' ,$data);		
	}
	
	function update_password(){ 
		if(isset($_POST['user_pass'])) {
			$key = $_POST['user_key'];
           
			$this->DatabaseModel->access_database('dd_users','update',array('user_key'=>'','user_status'=>1,'user_pass'=>md5($_POST['user_pass'])),array('user_key'=>$key));
			
			$message=$this->ts_functions->getlanguage('pwdchngsuc_text','message','solo');
			$resp=array('status' => 'true' , 'message'=>$message, 'data'=>'' );
		}else {
			$message=$this->ts_functions->getlanguage('newslettererr','message','solo');
			$resp=array('status' => 'false' , 'message'=>$message, 'data'=>'' );
		} 
		 echo json_encode($resp);
	}
	
	
	/************* Google Login STARTS ****************/
	public function googlelogin(){
        include_once("google_login/autoload.php");
        $client_id = $this->ts_functions->getsettings('google','clientid');
        $client_secret = $this->ts_functions->getsettings('google','clientsecret');
        $redirect_uri = base_url().'authentication/googlelogin';

        $client = new Google_Client();
        $client->setClientId($client_id);
        $client->setClientSecret($client_secret);
        $client->setRedirectUri($redirect_uri);
        $client->addScope("email");
        $client->addScope("profile");


        $service = new Google_Service_Oauth2($client);
        if (isset($_GET['code'])) {
          $client->authenticate($_GET['code']);
          $_SESSION['access_token'] = $client->getAccessToken();
        }else {
          $authUrl = $client->createAuthUrl();
          redirect($authUrl);
        }

        /************************************************
          If we have an access token, we can make
          requests, else we generate an authentication URL.
         ************************************************/
        if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
            $client->setAccessToken($_SESSION['access_token']);
            $user = $service->userinfo->get();

            $email = $user['email'];

            $checkUser = $this->DatabaseModel->select_data('*','dd_users',array('user_email'=>$email));

            if(empty($checkUser)) {
                $user_name = strtolower($user['givenName']);
                $user_name = substr($user_name,0,10);

                $insert_array = array(
                    'user_name'   =>  $user_name,
                    'user_email'   =>  $user['email'],
                    'user_status'   =>  1,
                    'user_level'   =>  2,
                    'user_offset'   =>  0
                );
                
                $userId = $this->DatabaseModel->access_database('dd_users','insert',$insert_array,'');
                $this->create_session($userId);
            }
            else {
                $this->create_session($checkUser[0]['user_id']);
                $userId = $checkUser[0]['user_id'];
            }
            echo '<script type="text/javascript">window.close(); window.opener.location.reload();</script>';

        } else {
            $authUrl = $client->createAuthUrl();
            redirect($authUrl);
        }

	}
	/************* Google Login ENDS ****************/
  private function create_session($userid) {
		$result = $this->DatabaseModel->select_data('*','dd_users',array('user_id'=>$userid));
		
		if($result[0]['user_status'] == '3') {
			$this->session->userdata['ts_loginstatus'] = 'Blocked'; // Blocked
		}else{
			if($result[0]['user_status'] == '2') {
				$this->DatabaseModel->access_database('dd_users','update',array('user_status'=>1),array('user_id'=>$userid));
				$result = $this->DatabaseModel->select_data('*','dd_users',array('user_id'=>$userid));
			}
			
			$user_details	= array(
			'dd_uid'		=> $result[0]['user_id'],
			'dd_email'		=> $result[0]['user_email'],
			'dd_uname'		=> $result[0]['user_name'],
			'dd_level'		=> $result[0]['user_level'],
		    );
			$this->session->set_userdata($user_details);
			if($this->ts_functions->getsettings('chat','status') == '1'){
			$this->Chat_model->registerSession($result[0]['user_name'],$result[0]['user_email'],'User');
			}  
			
		}
   }
	
}
