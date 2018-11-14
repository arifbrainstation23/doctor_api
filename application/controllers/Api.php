<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		define( 'TBL_DD_USERS', 'dd_users' );
		define( 'TBL_DD_LANGUAGE', 'dd_language' );
		define( 'TBL_DD_CATEGORY', 'dd_categories' );
		define( 'TBL_DD_SUBCATEGORY', 'dd_subcategories' );
		define( 'TBL_DD_USER_META', 'dd_user_meta' );
		define( 'TBL_DD_PLANS', 'dd_plans' );
		define( 'TBL_DD_FIELDS', 'dd_fields' );
		define( 'TBL_DD_ClINICS', 'dd_clinics' );
		$this->user_id=$this->ts_functions->dd_uid;
		$this->user_level=$this->ts_functions->dd_level;
	}
	
	public function index(){
		if(isset($_POST['function'])){
			call_user_func( array( 'Api', $_POST['function'] ) );
		}
	}
	
	public function language1(){
		$success = $this->ts_functions->getlanguage( 'language_success', 'api', 'solo' );
		$failure = $this->ts_functions->getlanguage( 'language_failure', 'api', 'solo' );
		if(isset($_POST['language']) && $_POST['language']){
			$result = $this->DatabaseModel->access_database( TBL_DD_LANGUAGE, 'select', '', array(
				'language_type' => $_POST['language_type']
			) );
			echo json_encode( array(
				'status' => 1,
				'message' => $success,
				'data' => $result
			) );
		}else{
			echo json_encode( array(
				'status' => 1,
				'message' => $failure,
				'data' => array()
			) );
		}
	}
	public function language(){
		
		//$result = $this->DatabaseModel->access_database( TBL_DD_LANGUAGE, 'select', '', '');
		$selectedLanguage =$this->ts_functions->getsettings('weblanguage','text');
		$data=array();
		$fields='language_key as key,language_'.$selectedLanguage.' as value';
		$result = $this->DatabaseModel->select_data($fields ,TBL_DD_LANGUAGE, '', ''); 
			$temp=array();
		foreach($result as $solo){
			$temp[$solo['key']]=$solo['value'];
		}
		$resp=array('status' => 'true','message' => 'success','data' => $temp,'admob_appid' =>$this->ts_functions->getsettings('admob','appid'));
		
		echo json_encode($resp);
	}
	

	
	
	public function change_password(){
		if(isset($_POST['user_password']) && isset($_POST['user_id']) && $_POST['user_password']!=''){
			
		  $user_password=trim($_POST['user_password']);
		 
			if(strlen($user_password) <7){ 
				//$message=$this->ts_functions->getlanguage('password','message','solo');
				$message=$user_password;
				$resp=array('status' => 'false','message' => $message,'data' => array());
			}else if($user_password != $_POST['user_cpassword']){
				$message= $this->ts_functions->getlanguage('repassword','message','solo');
				$resp=array('status' => 'false','message' => $message,'data' => array());
			}else{
				$user_id=$_POST['user_id'];
				$this->DatabaseModel->access_database('dd_users','update',array('user_pass' => md5($user_password)), array('user_id'=>$user_id));
				$message=$this->ts_functions->getlanguage('update_success','message','solo');
				$resp=array('status' => 'true','message' => $message,'data' => array());
			}	
			
		}else{ 
			$message = $this->ts_functions->getlanguage('newslettererr','message','solo');
			$resp=array('status' => 'false','message' => $message,'data' => array());
		}
		header('Content-Type: application/json');      
        echo json_encode($resp);
		
	}
	
	public function category(){
		$success = $this->ts_functions->getlanguage( 'category_success', 'api', 'solo' );
		$failure = $this->ts_functions->getlanguage( 'category_failure', 'api', 'solo' );
		if(isset($_POST['category']) && $_POST['category']){
			$result = $this->DatabaseModel->access_database( TBL_DD_CATEGORY, 'select', '', array(
				'cat_status' => 1
			) );
			echo json_encode( array(
				'status' => 'true',
				'message' => $success,
				'base_url' => base_url(),
				'data' => $result
			) );
		}else{
			echo json_encode( array(
				'status' => 'false',
				'message' => $failure,
				'data' => array()
			) );
		}
	}
	
	public function subcategory(){
		$success = $this->ts_functions->getlanguage( 'subcategory_success', 'api', 'solo' );
		$failure = $this->ts_functions->getlanguage( 'subcategory_failure', 'api', 'solo' );
		if(isset($_POST['category_id']) && $_POST['category_id']){
			if($this->ts_functions->getsettings('portal','revenuemodel') != 'plan'){
				$get_user_sql = "SELECT user_id FROM ".TBL_DD_USERS." u WHERE user_level = 3";
			}else{
				$get_user_sql = "SELECT user_id FROM ".TBL_DD_USERS." u INNER JOIN ".TBL_DD_PLANS." p ON p.plan_id = u.user_plans && p.plan_duration >= DATEDIFF(NOW(), u.user_plansdate)  WHERE user_level = 3";	
			}
			
			$sql = "SELECT d.*, COUNT(um.id) as doctor_total FROM ".TBL_DD_SUBCATEGORY." d INNER JOIN ".TBL_DD_USER_META." um ON d.sub_id = um.value && um.key = 'subcategory' WHERE d.sub_parent = ".$_POST['category_id']." && um.user_id IN(".$get_user_sql.") GROUP BY d.sub_id";
			
			$result = $this->DatabaseModel->query( $sql, true );
			if(count($result)){
				echo json_encode( array(
					'status' => 'true',
					'message' => $success,
					'base_url' => base_url(),
					'data' => $result
				) );
			}else{
				echo json_encode( array(
					'status' => 'false',
					'message' => $failure,
					'data' => array()
				) );
			}
		}else{
			echo json_encode( array(
				'status' => 0,
				'message' => $failure,
				'data' => array()
			) );
		}
	}
	
	public function doctors(){
		$success = $this->ts_functions->getlanguage( 'doctors_cat_success', 'api', 'solo' );
		$failure = $this->ts_functions->getlanguage( 'doctors_cat_failure', 'api', 'solo' );
		if(isset($_POST['start']) && isset($_POST['length'])){
			
			$cond="user_level = '3' AND  user_status = '1' ";
	        $order_by=array('user_name' , 'asc');
	        $currentPosition=$_POST['start'];
	        $limit=$_POST['length'];
			
			if($this->ts_functions->getsettings('portal','revenuemodel') == 'plan'){
			 $user_ids=$this->ts_functions->get_plan_user();
			 $cond.="AND dd_users.user_id in($user_ids)";
		    }
		   
		   if(isset($_POST['subcat_id']) && $_POST['subcat_id']!=''){
		   $sub_cat=$_POST['subcat_id'];
		   $cond.= " AND key='subcategory' AND value= '$sub_cat' ";
	       }
		   
		   if(isset($_POST['keyword']) && $_POST['keyword']!=''){
		   $keyword=$_POST['keyword'];
		   $cond.= "AND ((user_name LIKE '%$keyword%') OR (user_city LIKE '%$keyword%') OR (key = 'spec'  AND value LIKE '%$keyword%') )";
	       }
		   $join_array = array('dd_user_meta','dd_user_meta.user_id = dd_users.user_id');
		  
		   
		   $user_fields='DISTINCT(dd_user_meta.user_id),dd_users.user_id, dd_users.user_name, dd_users.user_email, dd_users.user_level, dd_users.user_pic, dd_users.user_mobile, dd_users.user_gender, dd_users.user_city, dd_users.user_dob, dd_users.user_fees';
	       
		   $doctorDetail = $this->DatabaseModel->select_data($user_fields, 'dd_users' , $cond , array($limit , $currentPosition) , $join_array ,$order_by );
		   $result = $doctorDetail;
		   $results = array();
		   if(!empty($result)){
		   for($i=0;$i<count($result);$i++){
			   $results[$i] = $result[$i];
			   $user_id=$result[$i]['user_id'];
				$results[$i]['spec'] = $this->ts_functions->get_user_meta($user_id, 'spec');
				$user_subcategory =$this->ts_functions->get_user_meta($user_id , 'subcategory' );
				$subcat=$this->DatabaseModel->select_data('sub_name' , 'dd_subcategories' , array('sub_id' =>  $user_subcategory) ,1);
				if(!empty($subcat)){
					$results[$i]['user_sub']=$subcat[0]['sub_name'];
				}else{
					$results[$i]['user_sub']='Uncategorized';
				}		
				
				$current_user=$_POST['user_id'];
				$chk_fav=$this->DatabaseModel->select_data('fav_id' , 'dd_favourite' , array('fav_doctor_id'=> $result[$i]['user_id'] , 'fav_user_id' =>$current_user) , 1);
				 $results[$i]['fav']='0';
				if($chk_fav){
				 $results[$i]['fav']='1';
			    }
                				
			}
		   }
			
		  if(count($result)){
				echo json_encode( array(
					'status' => 'true',
					'message' => $success,
					'base_url' => base_url(),
					'symbol' => $this->ts_functions->getsettings( 'portalcurreny', 'symbol' ),
					'curreny' => $this->ts_functions->getsettings( 'portal', 'curreny' ),
					'data' => $results
				) );
			}else{
				echo json_encode( array(
					'status' => 'false',
					'message' => $failure,
					'data' => array()
				) );
			}
		}
	}
	
	public function doctor(){
		$success = $this->ts_functions->getlanguage( 'doctor_profile_success', 'api', 'solo' );
		$failure = $this->ts_functions->getlanguage( 'doctor_profile_failure', 'api', 'solo' );
		if(isset($_POST['doctor_id']) && !empty($_POST['doctor_id'])){
			if($this->ts_functions->getsettings('portal','revenuemodel') != 'plan'){
				$get_user_sql = "SELECT * FROM ".TBL_DD_USERS." u WHERE user_level = 3 && user_status = 1 && user_id = ".$_POST['doctor_id'];
			}else{
				$get_user_sql = "SELECT * FROM ".TBL_DD_USERS." u INNER JOIN ".TBL_DD_PLANS." p ON p.plan_id = u.user_plans && p.plan_duration >= DATEDIFF(NOW(), u.user_plansdate)  WHERE user_level = 3 && user_status = 1 && user_id = ".$_POST['doctor_id'];	
			}
			$result = $this->DatabaseModel->query( $get_user_sql, true );
			
			$fields = $this->DatabaseModel->access_database( TBL_DD_FIELDS, 'select', '', array(
				'doctor' => 1
			) );
			$results = array();
			if(count($result)){
				$results = $result[0];
				$u_id = $_POST['doctor_id'];
				for($i=0;$i<count($fields);$i++){
					$key = $fields[$i]['name'];
					$results['custom'][$key] = array( 'label' => $fields[$i]['name'], 'value' => $this->ts_functions->get_user_meta( $u_id, $key ) );
				}
				$results['user_desc']=$this->ts_functions->get_user_meta($u_id , 'desc' );
				$current_user=$_POST['user_id'];
			    $chk_fav=$this->DatabaseModel->select_data('fav_id' , 'dd_favourite' , array('fav_doctor_id'=> $results['user_id'] , 'fav_user_id' =>$current_user) , 1);
				 $results['fav']='0';
				if($chk_fav){
				 $results['fav']='1';
			    }
				
				$doctor_id=$_POST['doctor_id'];
				$avgRatings=$this->DatabaseModel->aggregate_data('dd_rating' ,'rat_rating', 'AVG' , array('rat_doctor_id' => $doctor_id));
				if(empty($avgRatings)){
					$avgRatings=0;
				}
				$results['avgRatings']=round($avgRatings,2);
				$results['totalRatings']=$this->DatabaseModel->aggregate_data('dd_rating' ,'rat_rating', 'COUNT' , array('rat_doctor_id' => $doctor_id));
				$results['totalOne']=$this->DatabaseModel->aggregate_data('dd_rating' ,'rat_rating', 'COUNT' , array('rat_doctor_id' => $doctor_id , 'rat_rating' =>1));
				$results['totalTwo']=$this->DatabaseModel->aggregate_data('dd_rating' ,'rat_rating', 'COUNT' , array('rat_doctor_id' => $doctor_id , 'rat_rating' =>2));
				$results['totalThree']=$this->DatabaseModel->aggregate_data('dd_rating' ,'rat_rating', 'COUNT' , array('rat_doctor_id' => $doctor_id , 'rat_rating' =>3));
				$results['totalFour']=$this->DatabaseModel->aggregate_data('dd_rating' ,'rat_rating', 'COUNT' , array('rat_doctor_id' => $doctor_id , 'rat_rating' =>4));
				$results['totalFive']=$this->DatabaseModel->aggregate_data('dd_rating' ,'rat_rating', 'COUNT' , array('rat_doctor_id' => $doctor_id , 'rat_rating' =>5));
				;
				$join=array('dd_users','dd_users.user_id=dd_rating.rat_user_id');
				$reviews=$this->DatabaseModel->select_data('user_name,user_pic,rat_rating,rat_comment,created_at','dd_rating',array('rat_doctor_id'=>$doctor_id),'',$join);
				$results['reviews']=$reviews;
                
				
			}
			
			if(count($result)){
				echo json_encode( array(
					'status' => 'true',
					'message' => $success,
					'base_url' => base_url(),
					'data' => (object) $results
				) );
			}else{
				echo json_encode( array(
					'status' => 'false',
					'message' => $failure,
					'data' => (object) array()
				) );
			}
		}
	}
	
	public function clinics(){
		$success = $this->ts_functions->getlanguage( 'clinic_success', 'api', 'solo' );
		$failure = $this->ts_functions->getlanguage( 'clinic_failure', 'api', 'solo' );
		if(isset($_POST['doctor_id']) && isset($_POST['cl_status'])){
			$booking_status=$this->ts_functions->get_user_meta($_POST['doctor_id'] , 'booking_status' );
			if($_POST['cl_status']==1){
			$sql = "SELECT * FROM ".TBL_DD_ClINICS." u WHERE cl_uid = ".$_POST['doctor_id']." && cl_status = ".$_POST['cl_status'];
			}else{
			$sql = "SELECT * FROM ".TBL_DD_ClINICS." u WHERE cl_uid = ".$_POST['doctor_id'];	
			}
			$result = $this->DatabaseModel->query( $sql, true );
			$clinics=array();
			if ($result){ 
			  foreach ($result as $soloCl){
			   $temp=array();
			   $temp['cl_id']=$soloCl['cl_id'];  
			   $temp['cl_name']=$soloCl['cl_name'];  
			   $temp['cl_uid']=$soloCl['cl_uid'];  
			   $temp['cl_open_days']=json_decode($soloCl['cl_open_days'],true); 
			   $temp['cl_time_interval']=$soloCl['cl_time_interval']; 	   
			   $temp['cl_motime']=$soloCl['cl_motime']; 	   
			   $temp['cl_mctime']=$soloCl['cl_mctime']; 	   
			   $temp['cl_eotime']=$soloCl['cl_eotime']; 	   
			   $temp['cl_ectime']=$soloCl['cl_ectime']; 	   
			   $temp['cl_address']=$soloCl['cl_address']; 	   
			   $temp['cl_contact']=$soloCl['cl_contact']; 	   
			   $temp['cl_status']=$soloCl['cl_status'];
			   $cl_coordinates=json_decode($soloCl['cl_coordinates']);
			   $temp['cl_lat']=$cl_coordinates->lat; 
			   $temp['cl_long']=$cl_coordinates->long;	   
			   array_push($clinics ,$temp); 
			  }
			  $resp = array('status' => 'true', 'message' => $success,'data'=> $clinics,'google_map' =>$this->ts_functions->getsettings('map','api'),'booking_status'=>$booking_status);  
			}
			else{
				$resp = array('status' => 'false', 'message' => $failure ,); 
			}
			header('Content-Type: application/json');      
            echo json_encode($resp); 
			
		}
	}
	
	

  /************** favroite start**************/
 function my_favourite(){ 
	   $success = $this->ts_functions->getlanguage( 'doctors_cat_success', 'api', 'solo' );
	   $failure = $this->ts_functions->getlanguage( 'doctors_cat_failure', 'api', 'solo' );
	    $limit=$_POST['length'];;
		$currentPosition=$_POST['start'];
		$user_id=$_POST['user_id'];
		
		$cond="fav_user_id = '$user_id' AND user_status = '1'";
		
	   if($this->ts_functions->getsettings('portal','revenuemodel') == 'plan'){
	      $user_ids=$this->ts_functions->get_plan_user();
	      $cond.="AND dd_users.user_id in($user_ids)";
	   }
	
	   $join_array = array('dd_users','dd_users.user_id = dd_favourite.fav_doctor_id');
       $result=$this->DatabaseModel->select_data('user_id,user_name,user_email,user_level,user_level,user_mobile,user_gender,user_city,user_fees,user_pic' , 'dd_favourite' , $cond, array($limit , $currentPosition) ,$join_array );
	  
	  
	   $results = array();
		 if(!empty($result)){
		   for($i=0;$i<count($result);$i++){
			   $results[$i] = $result[$i];
			   $doc_id=$result[$i]['user_id'];
				$results[$i]['spec'] = $this->ts_functions->get_user_meta($doc_id, 'spec');
				$user_subcategory =$this->ts_functions->get_user_meta($doc_id , 'subcategory' );
				$subcat=$this->DatabaseModel->select_data('sub_name' , 'dd_subcategories' , array('sub_id' =>  $user_subcategory) ,1);
				if(!empty($subcat)){
					$results[$i]['user_sub']=$subcat[0]['sub_name'];
				}else{
					$results[$i]['user_sub']='Uncategorized';
				}		
				
				$current_user=$_POST['user_id'];
				$chk_fav=$this->DatabaseModel->select_data('fav_id' , 'dd_favourite' , array('fav_doctor_id'=> $result[$i]['user_id'] , 'fav_user_id' =>$current_user) , 1);
				 $results[$i]['fav']='0';
				if($chk_fav){
				 $results[$i]['fav']='1';
				}		
			}
		   }	
		if(count($result)){
			echo json_encode( array(
				'status' => 'true',
				'message' => $success,
				'base_url' => base_url(),
				'symbol' => $this->ts_functions->getsettings( 'portalcurreny', 'symbol' ),
				'curreny' => $this->ts_functions->getsettings( 'portal', 'curreny' ),
				'data' => $results
			) );
		}else{
			echo json_encode( array(
				'status' => 'false',
				'message' => $failure,
				'data' => array()
			) );
		}
  }
  
  function custom_fields(){
	  $fields = $this->DatabaseModel->select_data('label,name,type,options','dd_fields',array('doctor' =>1 , 'status' =>1),'');
	  echo json_encode( array(
				'status' => 'true',
				'message' => 'test custom field for doctort',
				'data' => $fields
			) );
  }
  
  public function edit_user(){
		$success = $this->ts_functions->getlanguage( 'doctor_profile_success', 'api', 'solo' );
		$failure = $this->ts_functions->getlanguage( 'doctor_profile_failure', 'api', 'solo' );
		if(isset($_POST['user_id']) && !empty($_POST['user_id'])){
			$get_user_sql = "SELECT * FROM ".TBL_DD_USERS." u WHERE user_id = ".$_POST['user_id'];
			
			$result = $this->DatabaseModel->query( $get_user_sql, true );
			
			$user_level=$_POST['user_level'];
			if($user_level==2){
				$field_cond=array('patients' => 1);
			}else{
				$field_cond=array('doctor' => 1);
			}
			$fields = $this->DatabaseModel->access_database( TBL_DD_FIELDS, 'select', '',$field_cond);
			
			$results = array();
			
			if(count($result)){
				$results = $result[0];
				
				$user_id = $_POST['user_id'];
				
				if($user_level==3){
				$results['user_exp'] =$this->ts_functions->get_user_meta($user_id , 'exp' ); 
				$results['user_qual'] =$this->ts_functions->get_user_meta($user_id , 'qual' ); 
				$results['user_lat'] =$this->ts_functions->get_user_meta($user_id , 'lat' ); 
				$results['user_long'] =$this->ts_functions->get_user_meta($user_id , 'long' ); 
				$results['user_spec'] =explode(" , ",$this->ts_functions->get_user_meta($user_id , 'spec' ));
				$results['user_desc'] =$this->ts_functions->get_user_meta($user_id , 'desc' );
				$results['user_category'] =$this->ts_functions->get_user_meta($user_id , 'category' ); 
	            $results['user_subcategory'] =$this->ts_functions->get_user_meta($user_id , 'subcategory' );
			    $results['booking_status'] = ($this->ts_functions->get_user_meta($user_id , 'booking_status' ) == 'no') ? 'no' : 'yes';
				}
				$results['user_address'] =$this->ts_functions->get_user_meta($user_id , 'address' );
	            $results['user_age'] =$this->ts_functions->get_user_meta($user_id , 'age' );
				
			   $condition_text =$this->ts_functions->getlanguage('acceptt_terms', 'profile', 'solo' ); 
$results['condition_text'] = trim(preg_replace('/\s\s+/', ' ', $condition_text));

             	  
				
				
			  for($i=0;$i<count($fields);$i++){
					$key = $fields[$i]['name'];
					$options=$fields[$i]['options'];
					if($options){
						$options=json_decode($options);
					}
					
					$results['custom'][$key] = array( 'label' => $fields[$i]['label'], 'value' => $this->ts_functions->get_user_meta( $user_id, $key ) , 'name' =>$fields[$i]['name'],'type' =>$fields[$i]['type'],'options' =>$options);
				}	
			}
			
			if(count($result)){
				echo json_encode( array(
					'status' => 'true',
					'message' => $success,
					'base_url' => base_url(),
					'data' => (object) $results
				) );
			}else{
				echo json_encode( array(
					'status' => 'false',
					'message' => $failure,
					'data' => (object) array()
				) );
			}
		}
	}
	
	function category_list(){
	   $categoryList = $this->DatabaseModel->select_data('cat_id,cat_name','dd_categories','','');
	   if($categoryList){
		   $resp=array('status'=>'true','message'=>"" ,'data'=>$categoryList);
	   }else{
		    $resp=array('status'=>'false','message'=>"" ,'data'=>'');
	   }
       echo json_encode($resp);      
	}
	function subcategory_list(){
       $subCateList=$this->DatabaseModel->select_data('sub_id,sub_name,sub_parent','dd_subcategories',''); 
       if($subCateList){
		   $resp=array('status'=>'true','message'=>"" ,'data'=>$subCateList);
	   }else{
		    $resp=array('status'=>'false','message'=>"" ,'data'=>'');
	   }
     echo json_encode($resp); 	   
	}
	function specialization_list(){ 
       $specialityList = $this->DatabaseModel->select_data('spe_id,spe_name','dd_speciality','','');
       if($specialityList){
		   $resp=array('status'=>'true','message'=>"" ,'data'=>$specialityList);
	   }else{
		    $resp=array('status'=>'false','message'=>"" ,'data'=>'');
	   }
       echo json_encode($resp); 	   
	}
	
	
	function update_user(){
		//echo  "<pre>";print_r($_POST);die;
	   if(isset($_POST['user_id'])){
			$user_id=$_POST['user_id'];
			$user_level=$_POST['user_level'];
			$dataArr = array(
				'user_name' =>  trim($_POST['user_name']),
				'user_mobile' => trim($_POST['user_mobile']),
				'user_gender' => trim(strtolower($_POST['user_gender']))
			);
			
			$user_lat=$_POST['user_lat'];
			$user_long=$_POST['user_long'];
			$map_api = $this->ts_functions->getsettings('map' , 'api');
			if($user_lat!='' && $user_long!=''){
			if($map_api!=''){
				$dataArr['user_city'] =$this->ts_functions->get_city_by_latlong($user_lat,$user_long,$map_api);
			}
			}
			if($user_level==3){
				$dataArr['user_fees']=trim($_POST['user_fees']);
			}
			
			$this->DatabaseModel->access_database('dd_users','update',$dataArr, array('user_id'=>$user_id));
		    
		    
			$this->ts_functions->add_user_meta($user_id , 'address' ,  $_POST['user_address']);
			$this->ts_functions->add_user_meta($user_id , 'age' ,  $_POST['user_age']);
			
			if($user_level==3){
				$this->ts_functions->add_user_meta($user_id , 'category' ,  $_POST['user_category']);
				$this->ts_functions->add_user_meta($user_id , 'subcategory' ,  $_POST['user_subcategory']);
				$this->ts_functions->add_user_meta($user_id , 'exp' ,  $_POST['user_exp']);
				$this->ts_functions->add_user_meta($user_id , 'qual' ,  $_POST['user_qual']);
				$this->ts_functions->add_user_meta($user_id , 'address' ,  $_POST['user_address']);
				if($user_lat!='' && $user_long!='' ){
				$this->ts_functions->add_user_meta($user_id , 'lat' ,  $user_lat);
				$this->ts_functions->add_user_meta($user_id , 'long' ,  $user_long);
				}
				
				//$this->ts_functions->add_user_meta($user_id , 'spec' , $_POST['user_spec']);
				$this->ts_functions->add_user_meta($user_id , 'spec' , implode(" , ",json_decode($_POST['user_spec'])));
				$this->ts_functions->add_user_meta($user_id , 'desc' , $_POST['user_desc']);
				
			 }
			
			if($user_level==3){
				$fields=$this->DatabaseModel->select_data('*','dd_fields',array('doctor' =>1 , 'status' =>1),'');
			}else{
				$fields=$this->DatabaseModel->select_data('*','dd_fields',array('patients' =>1 , 'status' =>1),'');
			}
			//custom field section start
			
			if($fields){
				 foreach($fields as $solofield){
					 $key=$solofield['name'];
					 $type=$solofield['type'];
					 if(isset($_POST[$key])){
						 $value=$_POST[$key];
						 if(is_array ($value) || $type=='checkbox'){
							 if($_POST['user_id']){
							  $value=implode(",",json_decode($value));
							 }else{
								$value=implode(",",$value);
							 }
                             $this->ts_functions->add_user_meta($user_id , $key ,$value); 							 
							}else{
								$this->ts_functions->add_user_meta($user_id , $key ,  $value);
							}	
					 }else{
						 $this->ts_functions->add_user_meta($user_id , $key ,  '');
					 }
					 
				 }	
			}
			
			$resp=array('status' => 'true','message'=>$this->ts_functions->getlanguage('update_success', 'message', 'solo' ), 'data' => '' );	
		  }else{
			  $resp=array('status' => 'false','message'=>$this->ts_functions->getlanguage('newslettererr', 'message', 'solo' ), 'data' => '' );	
		  }
          echo json_encode($resp);		  
	}
	
    public function update_profile_pic(){
		if($_FILES['user_pic']['name'] != ''){
			$user_id=$_POST['user_id'];
			  $imagename=$this->ts_functions->upload_image('upload/user_profile/' , 'user_pic' );
			   if($imagename!=''){
				  $user_detail = $this->DatabaseModel->access_database('user_pic','dd_users','',array('user_id'=>$user_id));
					if( $user_detail[0]['user_pic'] != '' ) {
						$path=dirname(__FILE__);
						$abs_path=explode('application',$path);
						//$pathToImages = $abs_path[0].'/upload/user_profile/';
						unlink($abs_path[0].$user_detail[0]['user_pic'] );
					}				
				$this->DatabaseModel->access_database('dd_users','update',array('user_pic' =>'upload/user_profile/'.$imagename), array('user_id'=>$user_id));
				
				 $resp=array('status' => 'true','message'=>$this->ts_functions->getlanguage('update_success', 'message', 'solo' ), 'data' => $imagename);
			   }else{
				 
                  $resp=array('status' => 'false','message'=>'Profile not updated.', 'data' => '' );				 
			   }				  
			 }else{
				 $resp=array('status' => 'false','message'=>$this->ts_functions->getlanguage('newslettererr', 'message', 'solo' ), 'data' => '' );	
			 }
			echo json_encode($resp);			
		}

  /* function bill_plan(){
	 $paymentdetails=array();
	 $planDetail=array();
	 $user_id=$_POST['user_id'];	 
	 $currency = $this->ts_functions->getsettings('portalcurreny' , 'symbol');
	 $userDetails=$this->DatabaseModel->select_data('*','dd_users',array('user_id' =>$user_id),1);
	 
	 if(empty($userDetails)){
		$resp=array('status' => 'false','message'=>'', 'data' => '' );
	 }else{
	 
	 $joinplan=array('dd_plans' , 'dd_plans.plan_id =dd_paymentdetails.payment_pid');
	 $result=$this->DatabaseModel->select_data('payment_mode,payment_amount,payment_date,plan_name,plan_duration_txt','dd_paymentdetails',array('payment_uid' =>$user_id),'',$joinplan,array('payment_id' ,'desc'));
	 if ($result){ 
	  foreach ($result as $soloPay){
	   $temp=array();
	   $temp[$this->ts_functions->getlanguage('plan_name', 'profile', 'solo' )]=$soloPay['plan_name'];  
	   $temp[$this->ts_functions->getlanguage('amount', 'profile', 'solo' )]=$soloPay['payment_amount'];  
	   $temp[$this->ts_functions->getlanguage('payment_mode', 'profile', 'solo' )]=$soloPay['payment_mode'];  
	   $temp[$this->ts_functions->getlanguage('payment_date', 'profile', 'solo' )]=date("d-M-Y", strtotime($soloPay['payment_date']));  
	   array_push($paymentdetails ,$temp); 
	  }
	}
	
	 
	 if($userDetails[0]['user_plans']!=0){
		$currentDetail=$this->DatabaseModel->select_data('plan_name,plan_duration_txt','dd_plans',array('plan_id'=>$userDetails[0]['user_plans']),1);
		if(!empty($currentDetail)){
			$planDetail[0][$this->ts_functions->getlanguage('plan_name', 'profile', 'solo' )]=$currentDetail[0]['plan_name'];
			$planDetail[0][$this->ts_functions->getlanguage('plan_duration', 'profile', 'solo' )]=$currentDetail[0]['plan_duration_txt'];
			$planDetail[0][$this->ts_functions->getlanguage('active_date', 'profile', 'solo' )]= date("d-M-Y", strtotime($userDetails[0]['user_plansdate']));
			
		}
	 }
	 //$data=array('paymentdetails'=>$paymentdetails,'planDetail'=>$planDetail,'currency'=>$currency);
	 $data=array('paymentdetails'=>$result,'planDetail'=>$currentDetail[0],'currency'=>$currency); 
      $resp=array('status' => 'true','message'=>'', 'data' =>  $data );	 
	 }
	 echo json_encode($resp);
   }*/
   
   function bill_plan(){
	 $paymentdetails=array();
	 $planDetail=array();
	 $user_id=$_POST['user_id'];	 
	 $currency = $this->ts_functions->getsettings('portalcurreny' , 'symbol');
	 $userDetails=$this->DatabaseModel->select_data('*','dd_users',array('user_id' =>$user_id),1);
	 
	 if(empty($userDetails)){
		$resp=array('status' => 'false','message'=>'', 'data' => '' );
	 }else{
	 
	 $joinplan=array('dd_plans' , 'dd_plans.plan_id =dd_paymentdetails.payment_pid');
	 $result=$this->DatabaseModel->select_data('payment_mode,payment_amount,payment_date,plan_name,plan_duration_txt','dd_paymentdetails',array('payment_uid' =>$user_id),'',$joinplan,array('payment_id' ,'desc'));
	 if ($result){ 
	  foreach ($result as $soloPay){
	   $temp=array();
	   $temp['plan_name']=$soloPay['plan_name'];  
	   $temp['amount']=$soloPay['payment_amount'];  
	   $temp['payment_mode']=$soloPay['payment_mode'];  
	   $temp['payment_date']=date("d-M-Y", strtotime($soloPay['payment_date']));  
	   array_push($paymentdetails ,$temp); 
	  }
	}else{
	$temp=array();
	   $temp['plan_name']='NA';  
	   $temp['amount']='NA';   
	   $temp['payment_mode']='NA'; 
	   $temp['payment_date']='NA'; 
       array_push($paymentdetails ,$temp); 	   
	}
	
	 
	 $na=array('plan_name'=>'NA','plan_duration'=>'NA','active_date'=>'NA');
	 if($userDetails[0]['user_plans']!=0){
		$currentDetail=$this->DatabaseModel->select_data('plan_name,plan_duration_txt','dd_plans',array('plan_id'=>$userDetails[0]['user_plans']),1);
		if(!empty($currentDetail)){
			$planDetail[0]['plan_name']=$currentDetail[0]['plan_name'];
			$planDetail[0]['plan_duration']=$currentDetail[0]['plan_duration_txt'];
			$planDetail[0]['active_date']= date("d-M-Y", strtotime($userDetails[0]['user_plansdate']));	
		}else{$planDetail[0]= $na;}
	 }else{$planDetail[0]= $na;}
	
	 $data=array('paymentdetails'=>$paymentdetails,'planDetail'=>$planDetail,'currency'=>$currency);
	
      $resp=array('status' => 'true','message'=>'', 'data' =>  $data );	 
	 }
	 echo json_encode($resp);
   }
   function settings(){
	 $set=array();
     $set['portalcurreny_symbol']=$this->ts_functions->getsettings('portalcurreny' , 'symbol');	 
     $set['portal_revenuemodel']=$this->ts_functions->getsettings('portal' , 'revenuemodel');	 
     $set['weblanguage_text']=$this->ts_functions->getsettings('weblanguage' , 'text');	 
     $set['sitename_text']=$this->ts_functions->getsettings('sitename' , 'text');	 
     $set['googlelink_url']=$this->ts_functions->getsettings('googlelink' , 'url');	 
     $set['twitterlink_url']=$this->ts_functions->getsettings('twitterlink' , 'url');	 
     $set['fblink_url']=$this->ts_functions->getsettings('fblink' , 'url');	 
     $set['paypal_status']=$this->ts_functions->getsettings('paypal' , 'status');	 
     $set['paypal_email']=$this->ts_functions->getsettings('paypal' , 'email');	 
     $set['msg91_status']=$this->ts_functions->getsettings('msg91' , 'status');	 
     $set['chat_status']=$this->ts_functions->getsettings('chat' , 'status');	 
     $set['chat_appid']=$this->ts_functions->getsettings('chat' , 'appid');	 
     $set['chat_authkey']=$this->ts_functions->getsettings('chat' , 'authkey');	 
     $set['chat_authsecret']=$this->ts_functions->getsettings('chat','authsecret');	 
     $set['chat_accountkey']=$this->ts_functions->getsettings('chat','accountkey');
	 $set['plan_page']=base_url().'plans';
     $resp=array('status' => 'true','message'=>'', 'data' =>  $set );
     echo json_encode($resp);	 
   }

	 		
}
