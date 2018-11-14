<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if(isset($_POST) && !empty($_POST)) {
	        if(!isset($_SERVER['HTTP_REFERER'])) {
                die('Direct Access Not Allowed!!');
	        }
	    }
		$this->load->library('ci_pagination');
		$this->user_id=$this->ts_functions->dd_uid;
		$this->user_level=$this->ts_functions->dd_level;
		
		if($this->user_id==''){
			redirect(base_url().'authentication');
		}
		if($this->user_level==1){
			redirect(base_url().'admin');
		}
	}

	
	public function index(){
		redirect(base_url().'profile');
	}
	/*public function chat (){ 
		
		redirect(base_url('chats'));
	}*/
	public function profile(){
		$data=array();
		$userDetails=$this->DatabaseModel->select_data('*','dd_users',array('user_id' =>$this->user_id),1);
		if(empty($userDetails)){redirect(base_url()); }
		$data['patientdetails']=$userDetails[0];
		
		if($this->user_level==3){
		$data['categoryList'] = $this->DatabaseModel->select_data('cat_id,cat_name','dd_categories','','');
	    $data['specialityList'] = $this->DatabaseModel->select_data('*','dd_speciality','','');
		$data['doctor_profile']=1;
		$data['fields'] = $this->DatabaseModel->select_data('*','dd_fields',array('doctor' =>1 , 'status' =>1),'');
		}else{
			$data['fields'] = $this->DatabaseModel->select_data('*','dd_fields',array('patients' =>1 , 'status' =>1),'');
		}
		$joinplan=array('dd_plans' , 'dd_plans.plan_id =dd_paymentdetails.payment_pid');
	    $data['paymentdetails']=$this->DatabaseModel->select_data('payment_mode,payment_amount,payment_date,plan_name,plan_duration_txt','dd_paymentdetails',array('payment_uid' =>$this->user_id),'',$joinplan,array('payment_id' ,'desc'));
		//echo "<pre>";print_r($data['paymentdetails']);die;
		$data['profile_active']=1;
		$this->load->view('user/common/header' ,$data);
		$this->load->view('user/profile' ,$data);
		$this->load->view('user/common/footer' ,$data);
	}
	
	public function update_profile(){
		
		if(isset($_POST['general'])){
			$user_id=$this->user_id;
			$dataArr = array(
				'user_name' =>  trim($_POST['user_name']),
				'user_mobile' => trim($_POST['user_mobile']),
				'user_gender' => trim($_POST['user_gender'])
			);
			if(isset($_POST['user_fees'])){
			$dataArr['user_fees']	= trim($_POST['user_fees']);
			} 
			
			$user_lat=$_POST['user_lat'];
			$user_long=$_POST['user_long'];
			
			$map_api = $this->ts_functions->getsettings('map' , 'api');
			if($user_lat!='' && $user_long!=''){
			if($map_api!=''){
				$dataArr['user_city'] =$this->ts_functions->get_city_by_latlong($user_lat,$user_long,$map_api);
			}
			}
			
			$this->DatabaseModel->access_database('dd_users','update',$dataArr, array('user_id'=>$user_id));
		    
		    
			$this->ts_functions->add_user_meta($user_id , 'address' ,  $_POST['user_address']);
			$this->ts_functions->add_user_meta($user_id , 'age' ,  $_POST['user_age']);
			
			if($this->user_level==3){
				$this->ts_functions->add_user_meta($user_id , 'category' ,  $_POST['user_category']);
				$this->ts_functions->add_user_meta($user_id , 'subcategory' ,  $_POST['user_subcategory']);
				$this->ts_functions->add_user_meta($user_id , 'exp' ,  $_POST['user_exp']);
				$this->ts_functions->add_user_meta($user_id , 'qual' ,  $_POST['user_qual']);
				$this->ts_functions->add_user_meta($user_id , 'address' ,  $_POST['user_address']);
				$this->ts_functions->add_user_meta($user_id , 'lat' ,  $user_lat);
				$this->ts_functions->add_user_meta($user_id , 'long' ,  $user_long);
				$this->ts_functions->add_user_meta($user_id , 'spec' , implode(" , ",$_POST['user_spec']));
				$this->ts_functions->add_user_meta($user_id , 'desc' , $_POST['user_desc']);
				
			}
			
			if($this->user_level==3){
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
						 if(is_array ($value)){
							 $this->ts_functions->add_user_meta($user_id , $key , implode(",",$value)); 
							}else{
								$this->ts_functions->add_user_meta($user_id , $key ,  $value);
							}	
					 }else{
						 $this->ts_functions->add_user_meta($user_id , $key ,  '');
					 }
					 
				 }	
			}
			$this->session->userdata['ts_success'] = 'Profile updated successfully.';
		  }	
			
			/* change password start */
			if(isset($_POST['chng_pass'])){
				if($_POST['user_password']!=''){
					$user_password=trim($_POST['user_password']);
					if(strlen($user_password) <8){
						$this->session->userdata['ts_error'] = 'Password should be 8 character long';
						redirect(base_url().'profile');	
					}
					if($user_password != $_POST['user_cpassword']){
						$this->session->userdata['ts_error'] = 'Password and confirm password must be same';
						redirect(base_url().'profile');
					}
					
					$this->DatabaseModel->access_database('dd_users','update',array('user_pass' => md5($user_password)), array('user_id'=>$user_id));
					$this->session->userdata['ts_success'] = 'Profile updated successfully.';
				}else{
					$this->session->userdata['ts_error'] = 'You missed out some fields';
				}
			}
			/* change password  end */
			
			
		    redirect(base_url().'profile');	
			
		
	}	
		
	public function update_profile_pic(){
		if($_FILES['user_pic']['name'] != ''){
			$user_id=$this->user_id;
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
				$this->session->userdata['ts_success'] = 'Profile updated successfully.';
			   }else{
				 $this->session->userdata['ts_error'] = 'Something went wrong.';  
			   }				  
			 }
			 redirect(base_url().'profile');		
		}
		
	function remove_profile_image(){
		$user_id=$this->user_id;
		
		$user_detail = $this->DatabaseModel->select_data('user_pic','dd_users',array('user_id'=>$user_id));
		if( $user_detail[0]['user_pic'] != '' ) {
			$path=dirname(__FILE__);
			$abs_path=explode('application',$path);
			//$pathToImages = $abs_path[0].'/upload/user_profile/';
			unlink($abs_path[0].$user_detail[0]['user_pic'] );
		}				
		$this->DatabaseModel->access_database('dd_users','update',array('user_pic' => ''), array('user_id'=>$user_id));
		$this->session->userdata['ts_success'] = 'Profile updated successfully.';
		 redirect(base_url().'profile');	
		
			
	 }
     
     function complete_doctor() {
		$user_id=$this->ts_functions->dd_uid;
		$sub_cat=$this->DatabaseModel->select_data('sub_parent,sub_id','dd_subcategories','',1);
		if(empty($sub_cat)){
			$this->session->userdata['ts_error'] = 'Empty subcategory please after sometime back'; 
		}else{
			 $this->DatabaseModel->access_database('dd_users','update',array('user_level'=>3),array('user_id'=>$user_id));
			 $this->session->userdata['ts_success'] = 'You are successfully become our doctor now update you profile.';
			 $this->session->userdata['dd_level'] = 3;
			 $this->ts_functions->add_user_meta($user_id , 'category' ,   $sub_cat[0]['sub_parent']);
			 $this->ts_functions->add_user_meta($user_id , 'subcategory' , $sub_cat[0]['sub_id']);
		}
		redirect(base_url().'profile');
       
    }

	public function book_appointment($slug=''){
		//if(!isset($_GET['practice_id'])){redirect(base_url());}
		$cond="user_level =  '3' ";
		$user_id = base64_decode($_GET['practice_id']);
		//$user_id=6;
	
		$cond.="AND dd_users.user_id = '$user_id' "; 
		
		$join_array = array('dd_user_meta','dd_user_meta.user_id = dd_users.user_id');
		$doctorDetail = $this->DatabaseModel->select_data('DISTINCT(dd_user_meta.user_id),dd_users.*' , 'dd_users' , $cond ,1 , $join_array ,''  );
		if(empty($doctorDetail)){redirect(base_url());}
		
		
		$data['doctorDetail']=$doctorDetail[0];
		$data['clinicDetail']=$this->DatabaseModel->select_data('cl_id,cl_name,cl_address','dd_clinics',array('cl_uid' => $user_id , 'cl_status' =>1));
		
		$data['doctor_active']=1;
		$this->load->view('user/common/header' ,$data);
		$this->load->view('user/book_appointment' , $data);
		$this->load->view('user/common/footer' ,$data);
				
	}
	
	public function favourite(){
		$limit=10;
		$currentPosition=0;
		$user_id=$this->user_id;
		$cond="fav_user_id = '$user_id' AND user_status = '1'";
		
		if($this->ts_functions->getsettings('portal','revenuemodel') == 'plan'){
	      $user_ids=$this->ts_functions->get_plan_user();
	     $cond.="AND dd_users.user_id in($user_ids)";
	   }
		
		if(isset($_POST['formKey']) && $_POST['formKey']!=''){
		  $currentPosition = $_POST['formKey'];
	     }

		$join_array = array('dd_users','dd_users.user_id = dd_favourite.fav_doctor_id');
        $data['doctorDetail']=$this->DatabaseModel->select_data('*' , 'dd_favourite' , $cond, array($limit , $currentPosition) ,$join_array );
        
	    $countDoc=$this->DatabaseModel->aggregate_data('dd_favourite' ,'fav_id', 'count' , $cond,'',$join_array );
	  
	    
 		$data['paginnation'] =$this->ci_pagination->pagination_data($countDoc, $currentPosition , $limit);
		$data['favorite_active']=1;
		$this->load->view('user/common/header' ,$data);
		$this->load->view('user/favourite',$data);
		$this->load->view('user/common/footer',$data);
	}
	
	function add_review(){
		if(isset($_POST['rat_doctor_id']) && isset($_POST['rat_rating']) && isset($_POST['rat_comment'])){
		$rat_doctor_id=$_POST['rat_doctor_id'];
		$rat_rating=$_POST['rat_rating'];
		$rat_comment=$_POST['rat_comment'];
		
		
		$rat_user_id=$this->user_id;
		$check=$this->DatabaseModel->select_data('rat_id', 'dd_rating' , array('rat_user_id' =>$rat_user_id , 'rat_doctor_id' =>$rat_doctor_id) , 1);
		$dataArr=array(
		'rat_user_id' =>$rat_user_id,
		'rat_doctor_id' =>$rat_doctor_id,
		'rat_rating' =>$rat_rating,
		'rat_comment' =>$rat_comment
		);
		if(empty($check)){
			$this->DatabaseModel->access_database('dd_rating' , 'insert' , $dataArr ,'');
			$resp=array('status' => true , 'message'=>'Rating  add succesfully', 'data'=>'' );
		}else{
			$this->DatabaseModel->access_database('dd_rating' , 'update' , $dataArr , array('rat_user_id' =>$rat_user_id , 'rat_doctor_id' =>$rat_doctor_id));
			$resp=array('status' => true , 'message'=>'Rating  update succesfully', 'data'=>'' );
		 }
		}else{
			$resp=array('status' => false , 'message'=>'You missed out some fields', 'data'=>'' );
		}
		header('Content-Type: application/json');      
        echo json_encode($resp);  
		
	}
	
	
	
	
	/****************************Only for doctor start ***************************************/
	
	function my_clinics(){
		if($this->user_level!=3){redirect(base_url());}
		$limit=9;
		$currentPosition=0;
		
		$join_array = array('dd_users','dd_users.user_id = dd_clinics.cl_uid');
        $data['clinicDetail']=$this->DatabaseModel->select_data('*' , 'dd_clinics' , array('cl_uid' =>$this->user_id), array($limit , $currentPosition) ,$join_array );
		
		$data['clinics_active']=1;
		$this->load->view('user/common/header' ,$data);
		$this->load->view('user/clinics',$data);
		$this->load->view('user/common/footer',$data);
	}
	
	
	public function add_clinic($cl_id=''){
		if($this->user_level!=3){redirect(base_url());}
		if( $cl_id != '' ) {
			$clinic_details=$this->DatabaseModel->select_data('*','dd_clinics',array('cl_id' =>$cl_id ,'cl_uid' =>$this->user_id),'');
			if(empty($clinic_details)){redirect(base_url().'user/add_clinic');}
			 $data['clinicdetails'] = $clinic_details;
		     
		}
		$data['week_days']=array('MON','TUE','WED','THU','FRI','SAT','SUN');
		$data['time_intervals']=array(10,15,20,30);
	   
	   
		$this->load->view('user/common/header' , $data);
		$this->load->view('user/add_clinic' , $data);
		$this->load->view('user/common/footer' , $data);
	}
	
	
	
	/****************************Only for doctor start ***************************************/
	
		
}
