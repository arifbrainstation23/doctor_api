<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Common extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		
		$this->user_id=$this->ts_functions->dd_uid;
		$this->user_level=$this->ts_functions->dd_level;
	}
	
	

  /************** favroite start**************/  
  function add_favourite(){
	   $doctor_id=$_POST['doctor_id'];
	   $user_id = (isset($_POST['user_id'])) ? $_POST['user_id'] : $this->user_id;
		$user_level=(isset($_POST['user_level'])) ? $_POST['user_level'] : $this->user_level;
	   
	   $DataArr= array('fav_doctor_id'=> $doctor_id , 'fav_user_id' =>$user_id);
	   if($user_id=='' || $user_level==1){
		   $resp = array('status' => 'false' , 'message' => 'Please login' ); 
	   }else{
		   $chk_fav=$this->DatabaseModel->select_data('fav_id' , 'dd_favourite' ,$DataArr , 1);
		   if(empty($chk_fav)){
			 $this->DatabaseModel->access_database('dd_favourite' , 'insert' ,$DataArr , ''); 
		   }
		   $resp = array('status' => 'true' , 'message' =>$this->ts_functions->getlanguage( 'add_fav', 'message', 'solo' )); 
	   }
       header('Content-Type: application/json');      
       echo json_encode($resp);		
	}
	
	function remove_favourite(){
		$doctor_id=$_POST['doctor_id'];
		$user_id = (isset($_POST['user_id'])) ? $_POST['user_id'] : $this->user_id;
		$user_level=(isset($_POST['user_level'])) ? $_POST['user_level'] : $this->user_level;
		$this->DatabaseModel->access_database('dd_favourite','delete','',array('fav_user_id'=>$user_id , 'fav_doctor_id' =>$doctor_id));
		$resp = array('status' => 'true' , 'message' =>$this->ts_functions->getlanguage( 'remove_fav', 'message', 'solo' )); 
		header('Content-Type: application/json');      
        echo json_encode($resp);
	}
	
 /************** favroite end**************/
  
 /************** Review start**************/
 	function add_review(){
		if(isset($_POST['doctor_id']) && isset($_POST['rating']) && isset($_POST['comment'])){
		$rat_doctor_id=$_POST['doctor_id'];
		$rat_rating=$_POST['rating'];
		$rat_comment=$_POST['comment'];
		
		
		//$rat_user_id=$this->user_id;
		$rat_user_id = (isset($_POST['user_id'])) ? $_POST['user_id'] : $this->user_id;
		
		
		$check=$this->DatabaseModel->select_data('rat_id', 'dd_rating' , array('rat_user_id' =>$rat_user_id , 'rat_doctor_id' =>$rat_doctor_id) , 1);
		$dataArr=array(
		'rat_user_id' =>$rat_user_id,
		'rat_doctor_id' =>$rat_doctor_id,
		'rat_rating' =>$rat_rating,
		'rat_comment' =>$rat_comment
		);
		if(empty($check)){
			$this->DatabaseModel->access_database('dd_rating' , 'insert' , $dataArr ,'');
			$resp=array('status' => 'true' , 'message'=>$this->ts_functions->getlanguage( 'rat_add', 'message', 'solo' ), 'data'=>'' );
		}else{
			$this->DatabaseModel->access_database('dd_rating' , 'update' , $dataArr , array('rat_user_id' =>$rat_user_id , 'rat_doctor_id' =>$rat_doctor_id));
			
			$resp=array('status' => 'true' , 'message'=>$this->ts_functions->getlanguage('rat_update', 'message', 'solo' ), 'data'=>'' );
		 }
		}else{
			$resp=array('status' => 'false' , 'message'=>'You missed out some fields', 'data'=>'' );
		}
		header('Content-Type: application/json');      
        echo json_encode($resp);   	
	}
 
   /************** Review end**************/
   
   
   /************** Appointments start**************/
   public function appointments ($slug=''){ 
	    $map_api = $this->ts_functions->getsettings('map' , 'api');
		$user_id = (isset($_POST['user_id'])) ? $_POST['user_id'] : $this->user_id;
		$user_level=(isset($_POST['user_level'])) ? $_POST['user_level'] : $this->user_level;
		if($user_id==''){redirect(base_url().'authentication');}
		
		$patientDetail = $this->DatabaseModel->select_data('user_offset' , 'dd_users' , array('user_id' => $user_id ) ,1);
		//$order_by=array('apo_date','asc','apo_timing','asc');
		$order_by=array('apo_datetime','asc');
		$now =date('Y-m-d H:i:s');
		$my_offset=-($patientDetail[0]['user_offset']);
		$current_date = date("Y-m-d", strtotime($my_offset.' minutes', strtotime($now)));
		$current_time = date("H:i", strtotime($my_offset.' minutes', strtotime($now)));
		$past=array();
		$upcoming=array();
		
		$current_datetime=$current_date.' '.$current_time;
		
		if($user_level==2){
		 $upcomingapp= array('apo_user_id' => $user_id , 'apo_datetime >=' =>$current_datetime);
		 $pastapp= array('apo_user_id' => $user_id , 'apo_datetime <' =>$current_datetime);	 	
		}else{
        $upcomingapp= array('apo_doctor_id' => $user_id , 'apo_datetime >=' =>$current_datetime );
		$pastapp= array('apo_doctor_id' => $user_id , 'apo_datetime <' =>$current_datetime);
		}
		
		
		$total_upcoming=$this->DatabaseModel->select_data('*' , 'dd_appointment' , $upcomingapp,'','',$order_by);
		$total_past=$this->DatabaseModel->select_data('*' , 'dd_appointment' , $pastapp,'','',$order_by);
		
		if($total_upcoming){
		foreach ($total_upcoming as $soloApp){
			   $clDetail=$this->DatabaseModel->select_data('cl_name,cl_address,cl_coordinates' , 'dd_clinics' , array('cl_id' => $soloApp['apo_clinic_id']) ,1 );
			     $clinic_name= $this->ts_functions->getlanguage('deleted', 'profile', 'solo' );
			     $clinic_address= $this->ts_functions->getlanguage('deleted', 'profile', 'solo' );
			     $clinic_lat= '';
			     $clinic_long= '';
				if(!empty($clDetail)){
					  $clinic_name= $clDetail[0]['cl_name'];
					  $clinic_address= $clDetail[0]['cl_address'];
					  if($map_api !='' ){
   					  $cl_coordinates=json_decode($clDetail[0]['cl_coordinates']);
			          $clinic_lat=$cl_coordinates->lat; 
			          $clinic_long=$cl_coordinates->long;
					  }	  
				 }
				
				$patient_name=$this->DatabaseModel->select_data('user_name' , 'dd_users' , array('user_id' =>$soloApp['apo_user_id']) ,1 );
				  if(!empty($patient_name)){
					  $patient_name= ucfirst($patient_name[0]['user_name']);
				  }else{
					  $patient_name= $this->ts_functions->getlanguage('deleted', 'profile', 'solo' );
				  }
			
			
			   $temp=array();
			   $temp['apo_id']=$soloApp['apo_id'];
			   $temp['apo_date']=date("d-M-Y", strtotime($soloApp['apo_date']));
			   $temp['apo_timing']=date("h:i A", strtotime($soloApp['apo_timing']));
			   $temp['apo_status']=$soloApp['apo_status'];
			   $temp['apo_clinic']=$clinic_name;
			   $temp['apo_clinicadd']=$clinic_address;
			   $temp['apo_cliniclat']=$clinic_lat;
			   $temp['apo_cliniclong']=$clinic_long;
			   $temp['apo_patient']=$patient_name;
			   $temp['apo_note']=$this->ts_functions->getlanguage($soloApp['apo_note'], 'profile', 'solo' );
			   array_push($upcoming ,$temp); 
		  }
		}
		if($total_past){
			foreach ($total_past as $soloApp){
			   $clDetail=$this->DatabaseModel->select_data('cl_name,cl_address,cl_coordinates' , 'dd_clinics' , array('cl_id' => $soloApp['apo_clinic_id']) ,1 );
			     $clinic_name= $this->ts_functions->getlanguage('deleted', 'profile', 'solo' );
			     $clinic_address= $this->ts_functions->getlanguage('deleted', 'profile', 'solo' );
			     $clinic_lat= '';
			     $clinic_long= '';
				if(!empty($clDetail)){
					  $clinic_name= $clDetail[0]['cl_name'];
					  $clinic_address= $clDetail[0]['cl_address'];
					  if($map_api !='' ){
   					  $cl_coordinates=json_decode($clDetail[0]['cl_coordinates']);
			          $clinic_lat=$cl_coordinates->lat; 
			          $clinic_long=$cl_coordinates->long;
					  }	  
				 }
				
				$patient_name=$this->DatabaseModel->select_data('user_name' , 'dd_users' , array('user_id' =>$soloApp['apo_user_id']) ,1 );
				  if(!empty($patient_name)){
					  $patient_name= $patient_name[0]['user_name'];
				  }else{
					  $patient_name= $this->ts_functions->getlanguage('deleted', 'profile', 'solo' );
				  }
			
			
			   $temp=array();
			   $temp['apo_id']=$soloApp['apo_id'];
			   $temp['apo_date']=date("d-M-Y", strtotime($soloApp['apo_date']));
			   $temp['apo_timing']=date("h:i A", strtotime($soloApp['apo_timing']));
			   $temp['apo_status']=$soloApp['apo_status'];
			   $temp['apo_clinic']=$clinic_name;
			   $temp['apo_clinicadd']=$clinic_address;
			   $temp['apo_cliniclat']=$clinic_lat;
			   $temp['apo_cliniclong']=$clinic_long;
			   $temp['apo_patient']=$patient_name;
			   $temp['apo_note']=$this->ts_functions->getlanguage($soloApp['apo_note'], 'profile', 'solo' );
			   array_push($past ,$temp); 
		  }
	}
	 if(isset($_POST['user_id'])){
		 
			$results=array();     
			$results['upcoming']=$upcoming;	 
			$results['past']=$past;	 	 
			if(!empty($upcoming) || !empty($past)){
				 $resp=array('status' => 'true','message'=>$this->ts_functions->getlanguage('appointment_list', 'api', 'solo' ), 'data' => $results ,'map_api'=>$map_api);		
			}else{
				 $resp=array('status' => 'false','message'=>$this->ts_functions->getlanguage('empty_appointments', 'profile', 'solo' ), 'data' => array()); 
			}
			echo json_encode($resp);	
		}else{
			
			$data['user_level']=$this->user_level;
			$data['total_upcoming']=$upcoming;
		    $data['total_past']=$past;
			$data['appointment_active']=1;
			$this->load->view('user/common/header' ,$data);
			$this->load->view('user/appointments' ,$data);
			$this->load->view('user/common/footer' ,$data);
	  }	
	}
    public function appointment_details( $appointmentID ){
        $user_id = (isset($_POST['user_id'])) ? $_POST['user_id'] : $this->user_id;
        $user_level=(isset($_POST['user_level'])) ? $_POST['user_level'] : $this->user_level;

        if($user_id==''){redirect(base_url().'authentication');}

        $cond = "user_status = 1 AND dd_users.user_id = ".$user_id;

        $data['userDetail'] = $this->DatabaseModel->select_data('dd_users.*' , 'dd_users' , $cond ,1)[0];
        $data['userMeta']   = $this->DatabaseModel->select_data('*','dd_user_meta',array('user_id' => $user_id));
        $data['user_level'] = $user_level;

        $this->load->view('user/common/header' ,$data);
        $this->load->view('user/appointment_details' ,$data);
        $this->load->view('user/common/footer' ,$data);
    }

        /************** Appointments end**************/
   
   /************** Clinic start**************/
   function update_clinics(){
	  
		if(isset($_POST['cl_id'])){
		   $user_id = (isset($_POST['user_id'])) ? $_POST['user_id'] : $this->user_id;
		   $user_level=(isset($_POST['user_level'])) ? $_POST['user_level'] : $this->user_level;
			if(isset($_POST['user_id'])){
				$cl_open_days=trim($_POST['cl_open_days']);
			}else{
				$cl_open_days=(isset($_POST['open_days'])) ? json_encode($_POST['open_days']) : json_encode(array());
			}
			
			$dataArr = array(
				'cl_name' =>  trim($_POST['cl_name']),
				'cl_contact' => trim($_POST['cl_contact']),
				'cl_address' => trim($_POST['cl_address']),
				'cl_uid' =>$user_id,
				'cl_motime' =>date("H:i", strtotime($_POST['cl_motime'])),
				'cl_mctime' => date("H:i", strtotime($_POST['cl_mctime'])),
				'cl_eotime' => date("H:i", strtotime($_POST['cl_eotime'])),
				'cl_ectime' => date("H:i", strtotime($_POST['cl_ectime'])),
				'cl_time_interval' => trim($_POST['cl_time_interval']),
				'cl_open_days' =>$cl_open_days, 
				'cl_coordinates' =>json_encode(array('lat' => $_POST['cl_lat'] , 'long' => $_POST['cl_long']))
			);
		
		
			if($_POST['cl_id']=='' || $_POST['cl_id']==0) {
				$user_id =  $this->DatabaseModel->access_database('dd_clinics','insert',$dataArr,'');
				$this->session->userdata['ts_success'] = $this->ts_functions->getlanguage('add_success', 'message', 'solo' );
				 $resp = array('status' => 'true', 'message' => $this->ts_functions->getlanguage('add_success', 'message', 'solo' )); 
			}
			else {
				$this->DatabaseModel->access_database('dd_clinics','update',$dataArr, array('cl_id'=>$_POST['cl_id'],'cl_uid' =>$user_id));
				
				 $this->session->userdata['ts_success'] = $this->ts_functions->getlanguage('update_success', 'message', 'solo' );
				 $resp = array('status' => 'true', 'message' => $this->ts_functions->getlanguage('update_success', 'message', 'solo' )); 	 
			}
			if(isset($_POST['user_id'])){
			header('Content-Type: application/json');      
            echo json_encode($resp); 
			}else{
			   redirect(base_url().'user/my_clinics');		
			}
		 		
		}
	}
	
	function delete_clinic($cl_ids=''){
		$user_id = (isset($_POST['user_id'])) ? $_POST['user_id'] : $this->user_id;
		$user_level=(isset($_POST['user_level'])) ? $_POST['user_level'] : $this->user_level;
		if(isset($_POST['cl_id'])){
			$cl_id=$_POST['cl_id'];
		}else{
			$cl_id=$cl_ids;
		}
		
		$cond="cl_id = $cl_id"; 
		if($user_level!=1){
			$cond.=" AND cl_uid=$user_id";
		}
		$this->DatabaseModel->access_database('dd_clinics','delete','',$cond);
		$resp=array('status'=>'true','message'=> $this->ts_functions->getlanguage('delete_success', 'message', 'solo' ) , 'data'=>'');
		if($user_level!=1){
		echo json_encode($resp);die;
		}else{	
			$this->session->userdata['ts_success'] = $this->ts_functions->getlanguage('delete_success', 'message', 'solo' );
			redirect('admin/clinics');
		}				
	}

    function clinic_status(){
	  $user_id = ($this->user_id != '') ? $this->user_id : $_POST['user_id'];
	  $this->DatabaseModel->access_database('dd_clinics','update',array('cl_status' =>$_POST['cl_status'] ), array('cl_id'=>$_POST['cl_id'],'cl_uid' =>$user_id));
	  $resp=array('status' => 'true' , 'message'=>$this->ts_functions->getlanguage('update_success', 'message', 'solo' ), 'data'=>'' );  
      header('Content-Type: application/json');      
      echo json_encode($resp); 	  
	}	
   /************** Clinic end**************/

   function start_booking(){
		$user_id = ($this->user_id != '') ? $this->user_id : $_POST['user_id'];
		$this->ts_functions->add_user_meta($user_id , 'booking_status' ,$_POST['status']);
		$resp = array('status' => 'true' , 'message' => $this->ts_functions->getlanguage('update_success', 'message', 'solo' ) ,'data'=>''); 
		header('Content-Type: application/json');      
        echo json_encode($resp);
	}
	
	function become_doctor() {
		$user_id=$_POST['user_id'];
		$sub_cat=$this->DatabaseModel->select_data('sub_parent,sub_id','dd_subcategories','',1);
		if(empty($sub_cat)){
			$this->session->userdata['ts_error'] = $this->ts_functions->getlanguage('emptysubcategory_doc', 'message', 'solo' );
            $resp=array('status'=>'false','message'=>$this->ts_functions->getlanguage('emptysubcategory_doc', 'message', 'solo' ), 'data'=>'');			
		}else{
			 $this->DatabaseModel->access_database('dd_users','update',array('user_level'=>3),array('user_id'=>$user_id));
			 $this->session->userdata['ts_success'] = $this->ts_functions->getlanguage('becomedoct_success', 'message', 'solo' );
			 $this->session->userdata['dd_level'] = 3;
			 $this->ts_functions->add_user_meta($user_id , 'category' ,   $sub_cat[0]['sub_parent']);
			 $this->ts_functions->add_user_meta($user_id , 'subcategory' , $sub_cat[0]['sub_id']);
			 $resp=array('status'=>'true','message'=>$this->ts_functions->getlanguage('becomedoct_success', 'message', 'solo' ) , 'data'=>'');	
		}
			
        echo json_encode($resp);		
    }
	
	
   
}
