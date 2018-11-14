<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ts_functions {
	public $dd_uid = '';
	public $dd_uname = '';
	public $dd_level = '';
	public $dd_email = '';
	

    public function __construct()
	{
        $this->CI = get_instance();
		if(isset($_SESSION['dd_uid'])){
			$this->dd_uid = $_SESSION['dd_uid'];
			$this->dd_uname = $_SESSION['dd_uname'];
			$this->dd_level = $_SESSION['dd_level'];
			if(isset($_SESSION['dd_email'])){
			$this->dd_email = $_SESSION['dd_email'];}
		}
	}

    /****
        getsettings : Function responsible to fetch the basic settings of the application,
        First Param : Pagename eg., login, register...
        Second Param : Type eg., title , metatags...
    ****/

    public function getsettings($pagename='',$type='')
    {
        $whrParam = $pagename.'_'.$type;
        $whrArray = array('key_text'=>$whrParam);
        $resArray = $this->CI->DatabaseModel->select_data('value_text' , 'dd_settings' , $whrArray , 1);

        return (!empty($resArray) ? $resArray[0]['value_text'] : 'NF' );
    }


    /****
        updatesettings : Function responsible to update the settings of the application,
        First Param : key ...
        Second Param : value ...
    ****/

    public function updatesettings($key='',$value='')
    {
        $whrArray = array('key_text'=>$key);
        $updateArray = array('value_text'=>$value);

        $this->CI->DatabaseModel->access_database('dd_settings','update', $updateArray , $whrArray);
    }


    /****
        getlanguage : Function responsible to fetch the language depending on either key or type,
        First Param : key
        Second Param : type
    ****/

    public function getlanguage($key='',$type='',$return='')
    {
        if( $key == 'all' ) {
            $whrArray = array('language_type'=>$type);
        }
        else {
            $whrArray = array('language_key'=>$key,'language_type'=>$type);
        }

      //  $resArray = $this->CI->DatabaseModel->access_database('ts_language','select','',$whrArray);
        $resArray = $this->CI->DatabaseModel->select_data('*' , 'dd_language' , $whrArray);

        if( $return == 'solo' ) {
            //$resArr = $this->CI->DatabaseModel->access_database('ts_settings','select','',array('key_text'=>'weblanguage_text'));
            $resArr = $this->CI->DatabaseModel->select_data('value_text' , 'dd_settings' , array('key_text'=>'weblanguage_text') , 1);
            $selectedLanguage =  $resArr[0]['value_text'];
            if( isset($_COOKIE['language']) ) {
            	$k = 'language_'.$_COOKIE['language'] ;
            }
            else {
            	$k = 'language_'.$selectedLanguage ;
            }
            
            return (!empty($resArray) ? $resArray[0][$k] : 'NF' );
        }
        else {
            return (!empty($resArray) ? $resArray : 'NF' );
        }
    }


    

	public function getDocUrlName($name=''){
        if($name != ''){
                $p = strtolower($name);
                $p = str_replace(' ','-',$p);
                $p = preg_replace('!-+!', '-', $p);
                return $p.'/';
        }
        else {
            return '/';
        }
        die();
	}

	
	
	 public function sendnotificationemails($type,$to,$subject,$username,$linkhref='',$password='' , $website_link=''){
		$this->CI->load->library('parser');
		$link = "<a href='".$linkhref."'>".$linkhref."</a>";
		$emContent = $this->getsettings($type,'text');
		$emContent = str_replace("[linktext]",$link,$emContent);
		$emContent = str_replace("[username]",$username,$emContent);
		$emContent = str_replace("[password]",$password,$emContent);
		$emContent = str_replace("[website_link]",$website_link,$emContent);
        $emContent = str_replace("[break]","<br/>",$emContent);
		$email_body ='<table><tr><td>'.$emContent.'</td></tr></table>';
		
		$email_data = array(
				'email_body' => $email_body,    
		);	
       $body=$this->CI->parser->parse('email_template', $email_data , true);
	   $subject = $this->getsettings($type,'subject');
	   $this->sendUserEmailCI($to,'','', $subject, $body);
	   //return $body; 
	 }
	
	public function sendUserEmailCI($to,$fromname='',$fromemail='', $subject = '', $body = '', $attachments = array(),$filePath='',$emailtype=''){
	
	$fromname = ($fromname != '') ? $fromname : $this->getsettings('email','fromname');
	$fromemail = ($fromemail != '') ? $fromemail : $this->getsettings('email','fromemail');
    $config['mailtype']="html";
	 
	$config['charset'] ="iso-8859-1";
    $this->CI->load->library('email');
	$this->CI->email->initialize($config);
    $this->CI->email->from($fromemail, $fromname);
    $this->CI->email->to($to);
    $this->CI->email->subject($subject);
    $this->CI->email->message($body);
    $this->CI->email->send();
   
	}
	
	public function sendtransactionemails($tranId){
        $this->CI->load->library('parser');
        $transactionDetails = $this->CI->DatabaseModel->select_data('*','dd_paymentdetails',array('payment_id'=>$tranId) , 1);

        if( !empty($transactionDetails) ) {

            $userDetails = $this->CI->DatabaseModel->select_data('*','dd_users',array('user_id'=>$transactionDetails[0]['payment_uid']),1);
            $pId=$transactionDetails[0]['payment_pid'];

            $prod_name_list = '';
			$findPlan = $this->CI->DatabaseModel->select_data('*','dd_plans',array('plan_id'=>$pId,'plan_status'=>1));
			$prod_name_list .= ' '.$findPlan[0]['plan_name'].' ,';
			
            $sym = $this->getsettings('portalcurreny','symbol');
            
            $productStr = '<p> Plan Name : '.rtrim($prod_name_list,',').'</p>';
            $productStr .= '<p> Amount Paid : '.$sym.' '.$transactionDetails[0]['payment_amount'].'</p>';

            $to = $userDetails[0]['user_email'];
           
            $bodyUser_email ="<p>Hi ".$userDetails[0]['user_name'].",</p> <p> Congratulations, your purchase is successful. <br/> Below is the product detail : </p> <hr/> ".$productStr."<br/> <p> Your listing will show on our portal .</p> <p>Thanks, <br/> ".$this->getsettings('sitename','text')." Team</p>";

           
            $bodyAdmin_email ="<p>Hi Admin,</p> <p> User has done a successfull purchase. <br/> User details who has done the transaction <p> Username : ".$userDetails[0]['user_name']." </p>  <p> User Email : ".$userDetails[0]['user_email']." </p>  <p> Transaction mode : ".$transactionDetails[0]['payment_mode']." </p>  Below is the product detail : </p> <hr/> ".$productStr."<br/><p> You can get the transaction details from Admin dashboard, transaction history section.</p> <p>Thanks, <br/> ".$this->getsettings('sitename','text')." Team</p>";
			
			
			

            
            $admin_add = $this->getsettings('email','contactemail');

			$subject = $this->getsettings('transactionemail','subject');
            $email_dataUser = array('email_body' => $bodyUser_email);	
            $email_dataAdmin = array('email_body' => $bodyAdmin_email);
			
			$bodyUser=$this->CI->parser->parse('email_template', $email_dataUser , true);
			$bodyAdmin=$this->CI->parser->parse('email_template', $email_dataAdmin , true);
			//echo $bodyUser;
			//echo $bodyAdmin;
        	  
			
			$this->sendUserEmailCI($to,'','',$subject,$bodyUser);
			$this->sendUserEmailCI($admin_add,'','',$subject,$bodyAdmin);
			if($userDetails[0]['user_device_token']!=''){
				$this->firebase_notification($userDetails[0]['user_device_token'], strip_tags($email_dataUser),$subject);
				
			}
			
            return 1;
        }


        die();
	}
	
	public function sendbookingemails($apo_id='' , $type=''){
      /*
	  1 book by user         bookappointment_text
	  2 cancel by user       cancelbyuser_text
	  3 cancel by doctor     cancelbydoctor_text
	  */
	  
	  $email_bodyUser=$email_bodyDoctor='';
	  $emailtemplate='bookappointment';
	  $this->CI->load->library('parser');
      $apoDetails = $this->CI->DatabaseModel->select_data('*','dd_appointment',array('apo_id'=>$apo_id) , 1);
	  
	  if( !empty($apoDetails) ) {
		 $user_id=$apoDetails[0]['apo_user_id'];
		 $doctor_id=$apoDetails[0]['apo_doctor_id'];
		 $apo_date=date("d-M-Y", strtotime($apoDetails[0]['apo_date']));
		 $apo_timing=date("h:i A", strtotime($apoDetails[0]['apo_timing']));
		 
		 
		 $userDetails = $this->CI->DatabaseModel->select_data('*','dd_users',array('user_id'=>$user_id),1);
		 $docDetails = $this->CI->DatabaseModel->select_data('*','dd_users',array('user_id'=>$doctor_id),1);
		 $username=$userDetails[0]['user_name'];
		 $user_mobile=$userDetails[0]['user_mobile'];
		 $user_device_token	=$userDetails[0]['user_device_token'];
		 $doctorname=$docDetails[0]['user_name'];
		 $doctor_mobile=$docDetails[0]['user_mobile'];
		 $doctor_device_token=$docDetails[0]['user_device_token'];
		
		 $subject = $this->getsettings('bookingemail','subject');
		// booked by user start
		 if($type==1){ 
		 $emContentUser = $this->getsettings('bookappointment' , 'text'); 
		 $email_bodyUser= $this->parseBotemp($apoDetails ,$userDetails,$docDetails ,$emContentUser);
		 
		 $emContentDoctor = $this->getsettings('bookappointmentdoc' , 'text');
         $email_bodyDoctor= $this->parseBotemp($apoDetails ,$userDetails,$docDetails ,$emContentDoctor);
		 
		 
		 }
		 // booked by user end
		 
		 // cancel by user start
		 if($type==2){
			$emContentDoctor = $this->getsettings('cancelbyuser' , 'text');
            $email_bodyDoctor= $this->parseBotemp($apoDetails ,$userDetails,$docDetails ,$emContentDoctor);
            			
		 }
		 // cancel by user end
		 
		 // cancel by doctor start
		 if($type==3){
			$emContentUser = $this->getsettings('cancelbydoctor' , 'text');
            $email_bodyUser= $this->parseBotemp($apoDetails ,$userDetails,$docDetails ,$emContentUser);			
		 }
		 // cancel by doctor end
		 
		 if($email_bodyUser!=''){
			$bodyUser=$this->CI->parser->parse('email_template', array('email_body' => $email_bodyUser)	, true);
			
			$this->sendUserEmailCI( $userDetails[0]['user_email'],'','',$subject,$bodyUser);
			if($user_mobile!=''){
				$this->send_msg($user_mobile ,strip_tags($email_bodyUser));
			}
            if($user_device_token!=''){
				$this->firebase_notification($user_device_token, strip_tags($email_bodyUser),$subject);
			} 			
		 }
		 
		 if($email_bodyDoctor!=''){
			$bodyDoctor=$this->CI->parser->parse('email_template', array('email_body' => $email_bodyDoctor)	, true);
			$this->sendUserEmailCI($docDetails[0]['user_email'],'','',$subject,$bodyDoctor);
			if($doctor_mobile!=''){
				$this->send_msg($doctor_mobile ,strip_tags($email_bodyDoctor));
			}
            if($doctor_device_token!=''){
				$this->firebase_notification($doctor_device_token, strip_tags($email_bodyDoctor),$subject);
			} 	 			
		 }
		
		   
	  }
	
	}
	function parseBotemp($apoDetails ,$userDetails,$docDetails ,$emContent){
		
		 $user_id=$apoDetails[0]['apo_user_id'];
		 $doctor_id=$apoDetails[0]['apo_doctor_id'];
		 $apo_date=date("d-M-Y", strtotime($apoDetails[0]['apo_date']));
		 $apo_timing=date("h:i A", strtotime($apoDetails[0]['apo_timing']));
		 $username=ucfirst($userDetails[0]['user_name']);
		 $doctorname=ucfirst($docDetails[0]['user_name']);
		 
		 $emContent = str_replace("[username]",$username,$emContent);
		 $emContent = str_replace("[doctorname]",$doctorname,$emContent);
		 $emContent = str_replace("[apo_date]",$apo_date,$emContent);
		 $emContent = str_replace("[apo_timing]",$apo_timing,$emContent);
		 $emContent = str_replace("[website_link]",base_url(),$emContent);
         $emContent = str_replace("[break]","<br/>",$emContent);
		 $email_body ='<table><tr><td class="main_reason">'.$emContent.'</td></tr></table>'; 
         return $email_body;	 
		
	}
	
	function send_msg($mob_no ,$MESSAGE ){ 
		$msg91_status=$this->getsettings('msg91','status');
		$AUTHKEY=$this->getsettings('msg91','key');
		if($msg91_status!=0 && $AUTHKEY!='' ){
         $SENDER=$this->getsettings('msg91','sender');
		 $ROUTE="4";
		 $url='https://control.msg91.com/api/sendhttp.php?authkey='.$AUTHKEY.'&mobiles='.$mob_no.'&message='.urlencode($MESSAGE).'&sender='.$SENDER.'&response=json&route='.$ROUTE;  
		 $ch      = curl_init($url);
		 curl_setopt($ch, CURLOPT_HEADER, false);
		 curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		 $resp  = curl_exec($ch);
		 $json = json_decode($resp);
		// echo "<pre>";print_r($json);
		 curl_close($ch);	
		}
	}
	
	function firebase_notification($deviceToken, $body,$title){
     $firebase_status=$this->getsettings('firebase','status');
	 $ACCESS_KEY=$this->getsettings('firebase','key');
	 if($firebase_status!=0 && $ACCESS_KEY!='' ){ 
	// $API_ACCESS_KEY= 'AAAAJqAQ63k:APA91bEaUfpeV7f-UU6fkHIlZyyhmpPhcyJCd73cZNyDYiwDV5W09boNfEWl2SIO3WOS4kfAtfILFHx0MbDPVTVvdLSYSZg7H7UH-I17jDkCPHhV6kE7pH5-0FDayK5g47J3B9mWVOtF';
    // $deviceToken='f_SBaZNolgU:APA91bFVgEkdMsS7a0utatppuYhOYLRtyVPxKnISYQn2TUMm7tAHjnSGHwgnYBMeKa37ny3AFMVX4rVhoCwwGZFNZvuRde8jdjvBLEqwkbbmwF-Px6sNPth8RyfpSZLNUBDNRjXTqbr8';
	 $msg = array(
            'body'    => $body,
            'title'   => $title,
            'icon'    => 'myicon',/*Default Icon*/
            'sound'   =>  'mySound'/*Default sound*/
          );
    $fields = array(
                'to'        => $deviceToken,
                'notification'    => $msg
            );
    $headers = array(
                'Authorization: key=' . $ACCESS_KEY,
                'Content-Type: application/json'
            );
        #Send Reponse To FireBase Server    
		$ch = curl_init();
		curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
		curl_setopt( $ch,CURLOPT_POST, true );
		curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
		curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
		$result = curl_exec($ch );
		curl_close( $ch );
		#Echo Result Of FireBase Server
		//print_r($result);
	 }	
    }
	
	function get_city_by_latlong($lat,$long,$key=''){
	$city='';
	$key = $this->getsettings('map' , 'api');
	$send_url='https://maps.googleapis.com/maps/api/geocode/json?latlng='.$lat.','.$long.'&key='.$key;
    $curlSession = curl_init();
    curl_setopt($curlSession, CURLOPT_URL, $send_url);
    curl_setopt($curlSession, CURLOPT_BINARYTRANSFER, true);
    curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, 1);
    $jsonData = curl_exec($curlSession);
    curl_close($curlSession);
	$data=json_decode($jsonData);
	
	$add_array=$data->results;
	
	if(isset($data->results)){
		$add_array  = $data->results;
		$add_array = $add_array[0];
		$add_array = $add_array->address_components;
		
		foreach ($add_array as $key) {
			
		  if($key->types[0] == 'administrative_area_level_2')
		  {  
			$city = $key->long_name;
		  }else if($key->types[0] == 'administrative_area_level_1') {  
			$city = $key->long_name;
		  }else if($key->types[0] == 'locality') {  
			$city = $key->long_name;
		  }else if($key->types[0] == 'political') {  
			$city = $key->long_name;
		  }else if($key->types[0] == 'route') {  
			$city = $key->long_name;
		  }						  
		} 
	}
	
	return $city;
} 
	
	
	function upload_image($upPath , $name , $postFix = NULL){
		$this->CI = get_instance();
		$basePath = explode('application',dirname(__FILE__))[0];
		$uploadPath = $basePath.$upPath; 
		$config['upload_path'] = $uploadPath;
		$config['allowed_types'] = '*';
		$this->CI->load->library('upload', $config);
		if ($this->CI->upload->do_upload($name)){
			//$this->upload->display_errors();	
			$uploaddata = $this->CI->upload->data();
			$imgName = $uploaddata['raw_name'];
			$imgExt = $uploaddata['file_ext'];
			$randomstr = substr(md5(microtime()), 0, 10);
			$uploadedImage = $randomstr.$postFix.$imgExt;
			rename($uploadPath.$imgName.$imgExt, $uploadPath.$uploadedImage); 
			return $uploadedImage;
		}else{ 
		//echo "<pre>";print_r($this->CI->upload->display_errors());
			return '';
		}
	}
	
	function add_user_meta($user_id , $key ,  $value){
		$whrArray = array('user_id'=>$user_id , 'key' => $key );
        $resArray = $this->CI->DatabaseModel->select_data('id' , 'dd_user_meta' , $whrArray , 1);
		$dataArr= array('user_id'=>$user_id , 'key' => $key , 'value' => $value);
		
		if(empty($resArray)){
			$this->CI->DatabaseModel->access_database('dd_user_meta','insert',$dataArr, '');
		}else{
			$this->CI->DatabaseModel->access_database('dd_user_meta','update',$dataArr,$whrArray);
		}
	}
	
	function get_user_meta($user_id , $key ){
		$whrArray = array('user_id'=>$user_id , 'key' => $key );
        $resArray = $this->CI->DatabaseModel->select_data('value' , 'dd_user_meta' , $whrArray , 1);
		if(!empty($resArray)){
			return $resArray[0]['value'];
		}else{
			return '';
		}
	}
	
	function get_plan_user($user_id=''){
		if($user_id==''){
		$get_user_sql = "SELECT user_id FROM dd_users u INNER JOIN dd_plans p ON p.plan_id = u.user_plans && p.plan_duration >= DATEDIFF(NOW(), u.user_plansdate)  WHERE user_level =3";	
		}else{
			 $get_user_sql = "SELECT user_id FROM dd_users u INNER JOIN dd_plans p ON p.plan_id = u.user_plans && p.plan_duration >= DATEDIFF(NOW(), u.user_plansdate)  WHERE user_level =3 AND user_id= '$user_id'  LIMIT 1" ;	
		}	
	     $result = $this->CI->DatabaseModel->query( $get_user_sql, true );
		 if(empty($result)) {
			$user_ids=0;
		 }else{
		 $user_ids = implode(',',array_map('implode',$result));	
		 }
		 return $user_ids;
	}
	
	

}

/* End of file Ts_functions.php */
?>
