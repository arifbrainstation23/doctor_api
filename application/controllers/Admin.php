<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		if(isset($_POST) && !empty($_POST)) {
	        if(!isset($_SERVER['HTTP_REFERER'])) {
                die('Direct Access Not Allowed!!');
	        }
	    }
		
		$this->user_id=$this->ts_functions->dd_uid;
		$this->user_level=$this->ts_functions->dd_level;
		if($this->user_id==''){ redirect (base_url());}
		if($this->user_level!=1){ redirect (base_url('profile'));}		
		
	}
	public function index(){
		
		redirect(base_url().'admin/dashboard');
	}
	public function dashboard(){
		
		$data['patientCount']=$this->DatabaseModel->aggregate_data('dd_users' , 'user_id' ,'count' , array('user_level' =>2));
		$data['doctorCount']=$this->DatabaseModel->aggregate_data('dd_users' , 'user_id' ,'count' , array('user_level' =>3));
		$data['appointmentCount']=$this->DatabaseModel->aggregate_data('dd_appointment' , 'apo_id' ,'count' );
		$data['paymentCount']=$this->DatabaseModel->aggregate_data('dd_paymentdetails' , 'payment_id' ,'count' );
		
		$data['dashboard_active']=1;
		$this->load->view('admin/common/header',$data);
		$this->load->view('admin/dashboard',$data);
		$this->load->view('admin/common/footer',$data);
	}
	
	public function doctors(){
		$data['doctorList'] = $this->DatabaseModel->select_data('*','dd_users',array('user_level' => 3, 'user_deleted'=>0));
		if( $this->ts_functions->getsettings('portal','revenuemodel') == 'plan' ) { 
        $data['plans']=$this->DatabaseModel->select_data('plan_id,plan_name' ,'dd_plans');
        }
		$data['doctors_active']=1;
		$data['doctor_active']=1;
		$this->load->view('admin/common/header' ,$data);
		$this->load->view('admin/doctors' ,$data);
		$this->load->view('admin/common/footer' ,$data);
	}
	public function add_doctor($doc_id=''){
		if( $doc_id != '' ) {
			$doctor_details=$this->DatabaseModel->select_data('*','dd_users',array('user_id' =>$doc_id , 'user_level' => 3),'');
			if(empty($doctor_details)){redirect(base_url().'admin/add_doctor');}
			 $data['doctordetails'] = $doctor_details;
		     $data['user_meta']=$this->DatabaseModel->select_data('key,value','dd_user_meta',array('user_id' =>$doc_id ),'');
		}
		
	    $data['categoryList'] = $this->DatabaseModel->select_data('cat_id,cat_name','dd_categories','','');
	    $data['specialityList'] = $this->DatabaseModel->select_data('*','dd_speciality','','');
		$data['fields']       = $this->DatabaseModel->select_data('*','dd_fields',array('doctor' =>1),'');
		
		$data['doctors_active']=1;
		$data['adddoctor_active']=1;
		$this->load->view('admin/common/header' , $data);
		$this->load->view('admin/add_doctor' , $data);
		$this->load->view('admin/common/footer' , $data);
	}
	
	
	function update_doctors(){
		//echo "<pre>";print_r($_POST);die;
		if($_POST){
			$dataArr = array(
				'user_name' =>  trim($_POST['user_name']),
				'user_level' =>  3,
				'user_status' => 1,
				'user_mobile' => trim($_POST['user_mobile']),
				'user_fees' => trim($_POST['user_fees'])
			);
			
			$user_lat=$_POST['user_lat'];
			$user_long=$_POST['user_long'];
			
			$map_api = $this->ts_functions->getsettings('map' , 'api');
			if($map_api!=''){
				$dataArr['user_city'] =$this->ts_functions->get_city_by_latlong($user_lat,$user_long,$map_api);
			}
			
			if($_POST['user_id']=='0') { 
				$user_pass = substr(str_shuffle("01234123456789123489"), 0, 8);
				$dataArr['user_pass'] =md5($user_pass);
				$dataArr['user_email'] =$_POST['user_email'];
				$dataArr['user_registerdate'] =date('Y-m-d h:i:s');
				$user_id =  $this->DatabaseModel->access_database('dd_users','insert',$dataArr,'');
				$this->session->userdata['ts_success'] = 'Doctor added successfully.';
				
			}
			else {
				$this->DatabaseModel->access_database('dd_users','update',$dataArr, array('user_id'=>$_POST['user_id']));
				 $user_id = $_POST['user_id'];
				 $this->session->userdata['ts_success'] = 'Doctor updated successfully.';
			}
			
			$this->ts_functions->add_user_meta($user_id , 'category' ,  $_POST['user_category']);
			$this->ts_functions->add_user_meta($user_id , 'subcategory' ,  $_POST['user_subcategory']);
			$this->ts_functions->add_user_meta($user_id , 'exp' ,  $_POST['user_exp']);
			$this->ts_functions->add_user_meta($user_id , 'qual' ,  $_POST['user_qual']);
			$this->ts_functions->add_user_meta($user_id , 'address' ,  $_POST['user_address']);
			$this->ts_functions->add_user_meta($user_id , 'lat' ,  $user_lat);
			$this->ts_functions->add_user_meta($user_id , 'long' , $user_long);
			$this->ts_functions->add_user_meta($user_id , 'spec' , implode(" , ",$_POST['user_spec']));
			$this->ts_functions->add_user_meta($user_id , 'desc' , $_POST['user_desc']);

			//custom field section start
			$fields=$this->DatabaseModel->select_data('*','dd_fields',array('doctor' =>1),'');
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
			//custom field section end
			
			if(isset($_POST['send_detail'])){
            	$subject='';
			     $password="Your Old Password";	
				 if($_POST['user_id']=='0') { 
				  $password= $user_pass;
				 }
				
              $this->ts_functions->sendnotificationemails('addnewuseremail',$_POST['user_email'],$subject,$_POST['user_email'],$linkhref='',$password ,base_url());		 
			
			}
		    redirect(base_url().'admin/doctors');
			
		}
	}
	
	/************************Patient Section Start *******************/
	
	public function patients(){
		$data['patientsList'] = $this->DatabaseModel->select_data('*','dd_users',array('user_level' => 2 ,'user_deleted'=>0));
		if( $this->ts_functions->getsettings('portal','revenuemodel') == 'plan' ) { 
        $data['plans']=$this->DatabaseModel->select_data('plan_id,plan_name' ,'dd_plans');
        }
		
		$data['patients_active']=1;
		$this->load->view('admin/common/header' ,$data);
		$this->load->view('admin/patients' ,$data);
		$this->load->view('admin/common/footer' ,$data);
	}
	public function add_patient($user_id=''){
		if( $user_id != '' ) {
			$patient_details=$this->DatabaseModel->select_data('*','dd_users',array('user_id' =>$user_id , 'user_level' => 2),'');
			if(empty($patient_details)){redirect(base_url().'admin/add_patient');}
			 $data['patientdetails'] = $patient_details;
		     $data['user_meta']=$this->DatabaseModel->select_data('key,value','dd_user_meta',array('user_id' =>$user_id ),'');
		}
		
		$data['fields']       = $this->DatabaseModel->select_data('*','dd_fields',array('patients' =>1 , 'status' =>1),'');
		$data['patients_active']=1;
		$this->load->view('admin/common/header' , $data);
		$this->load->view('admin/add_patient' , $data);
		$this->load->view('admin/common/footer' , $data);
	}
	
	function update_patients(){
		if($_POST){
			$dataArr = array(
				'user_name' =>  trim($_POST['user_name']),
				'user_level' =>  2,
				'user_status' => 1,
				'user_mobile' => trim($_POST['user_mobile'])
			);
			if($_POST['user_id']=='0') {
				$user_pass = substr(str_shuffle("01234123456789123489"), 0, 8);
				$dataArr['user_pass'] =md5($user_pass);
				$dataArr['user_email'] =$_POST['user_email'];
				$dataArr['user_registerdate'] =date('Y-m-d h:i:s');
				$user_id =  $this->DatabaseModel->access_database('dd_users','insert',$dataArr,'');
				$this->session->userdata['ts_success'] = 'Patient added successfully.';
				
			}
			else {
				$this->DatabaseModel->access_database('dd_users','update',$dataArr, array('user_id'=>$_POST['user_id']));
				 $user_id = $_POST['user_id'];
				 $this->session->userdata['ts_success'] = 'Patient updated successfully.';
			}
			
			
			$this->ts_functions->add_user_meta($user_id , 'address' ,  $_POST['user_address']);
			
			//custom field section start
			$fields=$this->DatabaseModel->select_data('*','dd_fields',array('patients' =>1),'');
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
			//custom field section end
			
			if(isset($_POST['send_detail'])){
            	$subject='';
			     $password="Your Old Password";	
				 if($_POST['user_id']=='0') { 
				  $password= $user_pass;
				 }
				
              $this->ts_functions->sendnotificationemails('addnewuseremail',$_POST['user_email'],$subject,$_POST['user_email'],$linkhref='',$password ,base_url());		 
			
			}
		 
		  redirect(base_url().'admin/patients');	
			
		}
	}
/************************Patient Section End *******************/


/************************Clinic Section Start *******************/
    public function clinics(){
		$data['clinicList'] = $this->DatabaseModel->select_data('*','dd_clinics');
		$data['clinics_active']=1;
		$this->load->view('admin/common/header' ,$data);
		$this->load->view('admin/clinics' ,$data);
		$this->load->view('admin/common/footer' ,$data);
	}
	
	public function add_clinic($cl_id=''){
		if( $cl_id != '' ) {
			$clinic_details=$this->DatabaseModel->select_data('*','dd_clinics',array('cl_id' =>$cl_id ),'');
			if(empty($clinic_details)){redirect(base_url().'admin/add_clinic');}
			 $data['clinicdetails'] = $clinic_details;
		     
		}
		$data['week_days']=array('MON','TUE','WED','THU','FRI','SAT','SUN');
		$data['time_intervals']=array(10,15,20,30);
	    $data['doctorList'] = $this->DatabaseModel->select_data('user_id,user_name','dd_users',array('user_level' => 3));
	   
	    $data['clinics_active']=1;
		$this->load->view('admin/common/header' , $data);
		$this->load->view('admin/add_clinic' , $data);
		$this->load->view('admin/common/footer' , $data);
	}
	function update_clinics(){
		if($_POST){
			
			$dataArr = array(
				'cl_name' =>  trim($_POST['cl_name']),
				'cl_contact' => trim($_POST['cl_contact']),
				'cl_address' => trim($_POST['cl_address']),
				'cl_uid' => trim($_POST['cl_uid']),
				'cl_motime' => trim($_POST['motime']),
				'cl_mctime' => trim($_POST['mctime']),
				'cl_eotime' => trim($_POST['eotime']),
				'cl_ectime' => trim($_POST['ectime']),
				'cl_time_interval' => trim($_POST['cl_time_interval']),
				'cl_open_days' =>(isset($_POST['open_days'])) ? json_encode($_POST['open_days']) : json_encode(array()),
				'cl_coordinates' =>json_encode(array('lat' => $_POST['cl_lat'] , 'long' => $_POST['cl_long']))
			);
			
		
			if($_POST['cl_id']=='0') {
				$user_id =  $this->DatabaseModel->access_database('dd_clinics','insert',$dataArr,'');
				$this->session->userdata['ts_success'] = 'Clinic added successfully.';
				
			}
			else {
				$this->DatabaseModel->access_database('dd_clinics','update',$dataArr, array('cl_id'=>$_POST['cl_id']));
				 
				 $this->session->userdata['ts_success'] = 'Clinic updated successfully.';
			}
		  redirect(base_url().'admin/clinics');	
			
		}
	}
/************************Clinic Section Start *******************/
	
	public function edit_fields(){
		$data['fields_active']=1;
		$this->load->view('admin/common/header');
		$this->load->view('admin/edit_fields');
		$this->load->view('admin/common/footer');
	}
	
	public function ads_integration(){
		if($_POST){
			if(isset($_POST['script'])){
				$ad_type='script';
				$data_arr=array(
				'ad_page' =>$_POST['ad_page'],
				'ad_code' =>$_POST['ad_code'],
				'ad_status' =>$_POST['ad_status'],
				'ad_type' =>$ad_type
				);	
			}
			if(isset($_POST['custom'])){
				$ad_type='custom';
				$data_arr=array(
				'ad_page' =>$_POST['ad_page'],
				'ad_link' =>$_POST['ad_link'],
				'ad_status' =>$_POST['ad_status'],
				'ad_type' =>$ad_type
				);
				
				if($_FILES['ad_image']['name'] != ''){
					  $imagename=$this->ts_functions->upload_image('upload/ad_image/' , 'ad_image' );
					   if($imagename!=''){
						 if($_POST['ad_id']!='0') {
						  $add_detail = $this->DatabaseModel->access_database('add_image','dd_advertisements','',array('ad_id'=>$_POST['ad_id']));
							if( $add_detail[0]['add_image'] != '' ) {
								$path=dirname(__FILE__);
								$abs_path=explode('application',$path);
								unlink($abs_path[0].$add_detail[0]['cat_image'] );
							}				
						}
						$data_arr['ad_image']='upload/ad_image/'.$imagename;	   
					   }				  
				 }
			}

            if($_POST['ad_id']=='0') {
						$this->DatabaseModel->access_database('dd_advertisements','insert',$data_arr,'');
						$this->session->userdata['ts_success'] = 'Ad added successfully.';
				}else {
					 $this->DatabaseModel->access_database('dd_advertisements','update',$data_arr, array('ad_id'=>$_POST['ad_id'] , 'ad_type' =>$ad_type));
					 $this->session->userdata['ts_success'] = 'Ad updated successfully.';
				}			
			
			
		}	
		
		//die;
		$data['custom_add']=$this->DatabaseModel->select_data('*', 'dd_advertisements' , array('ad_type' =>'custom'));
		$data['script_add']=$this->DatabaseModel->select_data('*', 'dd_advertisements' , array('ad_type' =>'script'));
		
		$data['ads_active']=1;
		$this->load->view('admin/common/header',$data);
		$this->load->view('admin/ads_integration',$data);
		$this->load->view('admin/common/footer',$data);
	}
	public function settings( $page = 'general' ){
		$data = array();
	//	echo "<pre>";print_r($_POST);die;
		if(isset($_POST['user_pass']) && $_POST['user_pass']!=''){
		 $data_arr=array('user_email'=>$_POST['user_email'],'user_pass'=>md5($_POST['user_pass']));
		  $this->DatabaseModel->access_database('dd_users','update',$data_arr, array('user_id'=>$this->ts_functions->dd_uid));
		  $this->session->set_userdata('dd_email', $_POST['user_email']);
          $this->session->userdata['ts_success'] = 'Data saved successfully.';		  
		}
		$data['page'] = $page;
		$data['settings_active']=1;
		if($page == 'fields'){
		$data['fields_active']=1;	
		}else{
			$data['general_active']=1;
		}
		$this->load->view('admin/common/header' ,$data);
		if($page == 'fields'){
			$data['fields'] = $this->DatabaseModel->select_data('*','dd_fields','','');
			$this->load->view('admin/fields', $data);
		}else{
			$this->load->view('admin/settings' ,$data);
		}
		
		$this->load->view('admin/common/footer');
	}
	public function elements(){
		$this->load->view('admin/common/header');
		$this->load->view('admin/elements');
		$this->load->view('admin/common/footer');
	}
	
	/********* Category Settings STARTS **********/

	function categories($cid='') {
	    $data['basepath'] = base_url();
	    $data['cate_details'] = $this->DatabaseModel->select_data('*','dd_categories','','');
		$data['category_active']=1;
	    $this->load->view('admin/common/header',$data);
		$this->load->view('admin/category',$data);
		$this->load->view('admin/common/footer',$data);
	}

	function add_categories() {
	    if(isset($_POST['catename'])) {
	        $cateDataArr = array();
            if( $_POST['catename'] != '' ) {
                $cateDataArr['cat_name'] = $_POST['catename'];
				
				if($_FILES['cateimage']['name'] != ''){
				  $imagename=$this->ts_functions->upload_image('upload/category/' , 'cateimage' );
                   if($imagename!=''){
					 if($_POST['old_cateid']!='0') {
					  $cat_detail = $this->DatabaseModel->access_database('cat_image','dd_categories','',array('cat_id'=>$_POST['old_cateid']));
						if( $cat_detail[0]['cat_image'] != '' ) {
							$path=dirname(__FILE__);
							$abs_path=explode('application',$path);
							//$pathToImages = $abs_path[0];
							unlink($abs_path[0].$cat_detail[0]['cat_image'] );
						}				
                    }
					$cateDataArr['cat_image']='upload/category/'.$imagename;	   
				   }				  
	             }
              
                if($_POST['old_cateid']=='0') {
                    $this->DatabaseModel->access_database('dd_categories','insert',$cateDataArr,'');
                    $this->session->userdata['ts_success'] = 'Category added successfully.';
                }
                else {
                    $this->DatabaseModel->access_database('dd_categories','update',$cateDataArr, array('cat_id'=>$_POST['old_cateid']));
                    $this->session->userdata['ts_success'] = 'Category updated successfully.';
                }
            }
            else {
                $this->session->userdata['ts_error'] = "Category can not be added.";
            }

            redirect(base_url().'admin/categories');
	    }
	    else {
	        echo '0';
	    }
	    die();
	}
	
	/*function get_category(){
		$cat_id=$_POST['cat_id'];
		
		$catDetails=$this->DatabaseModel->select_data('*','dd_categories',array('cat_id'=>$cat_id));
		echo json_encode($catDetails , JSON_UNESCAPED_SLASHES);
		
	}

	/********* Category Settings ENDS **********/

	/********* Sub Category Settings STARTS **********/

	function sub_categories($sub_cid='') {
	    $data['basepath'] = base_url();
	    if($sub_cid != '') {
	        $data['solo_sub_cate'] = $this->DatabaseModel->access_database('ts_subcategories','select','',array('sub_id'=>$sub_cid));
	    }
	    else {
	        $data['solo_sub_cate'] = array();
	    }
	    $data['sub_cate_details'] = $this->DatabaseModel->select_data('*','dd_subcategories','','');
	    $data['cate_details'] = $this->DatabaseModel->select_data('*','dd_categories','','');
	    $data['subcategory_active']=1;
		
	    $this->load->view('admin/common/header',$data);
		$this->load->view('admin/sub_category',$data);
		$this->load->view('admin/common/footer',$data);
	}

	function add_sub_categories() {
	    if(isset($_POST['sub_catename'])) {
	        $sub_cateDataArr = array();
            if( $_POST['sub_catename'] != '' ) {
                $sub_cateDataArr['sub_name'] = $_POST['sub_catename'];
                $sub_cateDataArr['sub_parent'] = $_POST['sub_parent'];
				
				if($_FILES['subcateimage']['name'] != ''){
					
				  $imagename=$this->ts_functions->upload_image('upload/sub_category/' , 'subcateimage' );
				 
                   if($imagename!=''){
					 if($_POST['old_sub_cateid']!='0') {
					  $subcat_detail = $this->DatabaseModel->access_database('sub_image','dd_subcategories','',array('sub_id'=>$_POST['old_sub_cateid']));
						if( $subcat_detail[0]['sub_image'] != '' ) {
							$path=dirname(__FILE__);
							$abs_path=explode('application',$path);
							//$pathToImages = $abs_path[0];
							unlink($abs_path[0].$subcat_detail[0]['sub_image'] );
						}				
                    }
					$sub_cateDataArr['sub_image']='upload/sub_category/'.$imagename;	   
				   }				  
	            
	             }

                if($_POST['old_sub_cateid']=='0') {
                    $this->DatabaseModel->access_database('dd_subcategories','insert',$sub_cateDataArr,'');
                    $this->session->userdata['ts_success'] = 'Sub Category added successfully.';
                }
                else {
                    $this->DatabaseModel->access_database('dd_subcategories','update',$sub_cateDataArr, array('sub_id'=>$_POST['old_sub_cateid']));
                    $this->session->userdata['ts_success'] = 'Sub Category updated successfully.';
                }
            }
            else {
                $this->session->userdata['ts_error'] = "Sub Category can not be added.";
            }

            redirect(base_url().'admin/sub_categories');  
	    }
	    else {
	        echo '0';
	    }
	    die();
	}

   
	/********* Sub Category Settings ENDS **********/
	
	
	/********* Specialization Settings STARTS **********/

	function specializations($cid='') {
	    $data['basepath'] = base_url();
	    $data['spe_details'] = $this->DatabaseModel->select_data('*','dd_speciality','','');
		
		$data['doctors_active']=1;
		$data['specializations_active']=1;
	    $this->load->view('admin/common/header',$data);
		$this->load->view('admin/speciality',$data);
		$this->load->view('admin/common/footer',$data);
	}

	function add_specializations() {
	    if(isset($_POST['spename'])) {
	        $cateDataArr = array();
            if( $_POST['spename'] != '' ) {
                $cateDataArr['spe_name'] = $_POST['spename'];
				
                if($_POST['old_speid']=='0') {
                    $this->DatabaseModel->access_database('dd_speciality','insert',$cateDataArr,'');
                    $this->session->userdata['ts_success'] = 'Speciality added successfully.';
                }
                else {
                    $this->DatabaseModel->access_database('dd_speciality','update',$cateDataArr, array('spe_id'=>$_POST['old_speid']));
                    $this->session->userdata['ts_success'] = 'Speciality updated successfully.';
                }
            }
            else {
                $this->session->userdata['ts_error'] = "Speciality can not be added.";
            }

            redirect(base_url().'admin/specializations');
	    }
	    else {
	        echo '0';
	    }
	    die();
	}
	
	

	/********* Specialization Settings ENDS **********/
	
	/* fields setting */
	public function fields(){
		
		if($_POST['action'] == 'create'){
			$array = array(
				'label' => $_POST['label'],
				'name' => str_replace(' ','_',$_POST['label']),
				'type' => $_POST['type'],
				'options' => isset($_POST['options']) ? json_encode($_POST['options']) : '',
				'doctor' => $_POST['doctor'],
				'patients' => $_POST['patients'],
				'datetime' => date('Y-m-d H:i:s'),
				'status' => 1
			);
			$insert_id = $this->DatabaseModel->access_database( 'dd_fields', 'insert', $array, '' );
			echo json_encode( array( 'status' => 1, 'msg' => 'Data have inserted successfuly.', 'insert_id' => $insert_id ) );
		}
		if($_POST['action'] == 'update'){
			$array = array(
				'label' => $_POST['label'],
				'type' => $_POST['type'],
				'options' => isset($_POST['options']) ? json_encode($_POST['options']) : '',
				'doctor' => $_POST['doctor'],
				'patients' => $_POST['patients'],
				'status' => 1
			);
			$where = array( 'field_id' => $_POST['field_id'] );
			$this->DatabaseModel->access_database( 'dd_fields', 'update', $array, $where, '' );
			echo json_encode( array( 'status' => 1, 'msg' => 'Data have updated successfuly.' ) );
		}
		if($_POST['action'] == 'delete'){
			$where = array( 'field_id' => $_POST['field_id'] );
			$this->DatabaseModel->access_database( 'dd_fields', 'delete', '', $where, '' );
			echo json_encode( array( 'status' => 1, 'msg' => 'Data have deleted successfuly.' ) );
		}
		die();
	}
	public function edit_fields_popup($field_id){
		$data = array();
		$data['fields'] = $this->DatabaseModel->select_data('*','dd_fields',array('field_id'=>$field_id),'');
		$this->load->view('admin/popup',$data);
	}
	/* fields setting */
	
	
	function ratings($cid='') {
	    $data['basepath'] = base_url();
		$join_array = array('dd_users','dd_users.user_id = dd_rating.rat_user_id');
	    $data['rat_details'] = $this->DatabaseModel->select_data('user_name,rat_doctor_id,rat_rating,rat_comment','dd_rating','','',$join_array,array('rat_id' , 'DESC'));
		
		$data['reviews_active']=1;
	    $this->load->view('admin/common/header',$data);
		$this->load->view('admin/ratings',$data);
		$this->load->view('admin/common/footer',$data);
	}
	
	function transaction($cid='') {
	    $data['basepath'] = base_url();
		$join_array = array('dd_users','dd_users.user_id = dd_paymentdetails.payment_uid');
	    $data['payment_details'] = $this->DatabaseModel->select_data('user_name,payment_pid,payment_date,payment_mode,payment_amount,payment_date','dd_paymentdetails','','',$join_array,array('payment_id','desc'));
		
		$data['transaction_active']=1;
	    $this->load->view('admin/common/header',$data);
		$this->load->view('admin/transaction',$data);
		$this->load->view('admin/common/footer',$data);
	}
	
	public function appointments ($slug=''){
		$data['total_appo']=$this->DatabaseModel->select_data('*' , 'dd_appointment' , '' , '' , '' , array('apo_id','desc'));
		
		$data['appointments_active']=1;
		$data['doctor_active']=1;
		$this->load->view('admin/common/header',$data);
		$this->load->view('admin/appointments',$data);
		$this->load->view('admin/common/footer',$data);
	}
	
	public function email() {
		$data['basepath'] = base_url();
		$data['settings_active']=1;
		$data['email_active']=1;
		$this->load->view('admin/common/header',$data);
		$this->load->view('admin/email_templates',$data);
		$this->load->view('admin/common/footer',$data);	
		
	}
	
	
	function delete_user($user_id='',$user_level=''){
		$user_detail=$this->DatabaseModel->select_data('*' , 'dd_users' ,array('user_id'=>$user_id,'user_level'=>$user_level), 1);
		if( $user_detail[0]['user_pic'] != '' ) {
			$path=dirname(__FILE__);
			$abs_path=explode('application',$path);
			//$pathToImages = $abs_path[0].'/upload/user_profile/';
			unlink($abs_path[0].$user_detail[0]['user_pic'] );
		}				
		$this->DatabaseModel->access_database('dd_users','update',array('user_pic' => '','user_status'=>0,'user_deleted'=>1), array('user_id'=>$user_id));
		 $this->session->userdata['ts_success'] = ' Delete successfully.';
		 if($user_level==3){
			redirect(base_url().'admin/doctors');	 
		 }else{
			redirect(base_url().'admin/patients');	  
		 }
		 
	}
	
}
