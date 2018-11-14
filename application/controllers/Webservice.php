<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Webservice extends CI_Controller
{
    public function __construct(){
        parent::__construct();
		
		  $this -> load -> model('Chat_model');
		$this->user_id=$this->ts_functions->dd_uid;
		$this->user_level=$this->ts_functions->dd_level;
       
    }
	
   public function getUserID()
  {
    $login = $this->input->post('login');     
    echo trim($this->Chat_model->getUserID($login));
  }
 
    public function trim_time($time){
      $temp = date("H:i", strtotime($time));
      $temp = str_replace(':', '', $temp);
      $temp = str_replace('AM', '', $temp);
      $temp = str_replace('PM', '', $temp);

      return $temp;
    }

	public  function slot_diffrence($timestop){
	// date_default_timezone_set('Asia/Calcutta'); 
	 date_default_timezone_set($this->ts_functions->getsettings('site','timezone')); 
	 $timestart = date('Y-m-d h:i A');

	 $timestart = strtotime($timestart);
	 $timestop = strtotime($timestop); 

	 $time_diff = $timestop - $timestart; //time difference
	  if ($time_diff < 0) {
	  $time_diff += 12;
	  }
	  return $time_diff;
	}
	
    public function get_slot(){

    $clinic_id=$this->input->post('cl_id');
	$booking_status='';
	if(isset($_POST['cl_uid'])){
		$booking_status=$this->ts_functions->get_user_meta($_POST['cl_uid'] , 'booking_status' );
	}
	
	if($booking_status!='no'){
	
    $date=$this->input->post('date');
	$date = date("Y-m-d", strtotime($date));
    $dateTrue =false;

    $currentDate  = date('Y-m-d');
    $tempd = DateTime::createFromFormat('Y-m-d', $date);
    $postDate  = $tempd->format('Y-m-d');
	
    if(strtotime($currentDate) == strtotime($postDate)){
      $dateTrue = true;
    }
     
    $myDateTime = DateTime::createFromFormat('Y-m-d', $date);
    $day =  $formattedweddingdate = $myDateTime->format('D');
	
    $data = $slotsTemp = array();
    $find_day = false;
   
	$get_clinic=$this->DatabaseModel->select_data('*' ,'dd_clinics' , array('cl_id' =>$clinic_id));
    $day_arr = json_decode($get_clinic[0]['cl_open_days']);
	
    $day=strtoupper($day);
    $find_day=false;
    if (in_array($day, $day_arr)){
	 $find_day=true; 
    }
	$data['morning']=array();
	$data['afternoon']=array();
	$data['evening']=array();
	$data['night']=array();


    if($get_clinic && $find_day){
        $time_interval=$get_clinic[0]['cl_time_interval'];
        $morning_start_time=$get_clinic[0]['cl_motime'];
        $morning_close_time=$get_clinic[0]['cl_mctime'];
        $evening_start_time=$get_clinic[0]['cl_eotime'];
        $evening_close_time=$get_clinic[0]['cl_ectime'];
		
        if($this->trim_time($morning_start_time) <= 1200){
 
          $slots_M  = [];
          $partial_slot = $this->trim_time($morning_start_time);
          $closing_time = $this->trim_time($morning_close_time);
           if($closing_time != 1200 && $closing_time > 1200){
            $closing_time = 1200;
           }
            
           $temp_closing = strtotime($closing_time);
           $temp_opening = strtotime($partial_slot);
           $partial_slot =round(abs($temp_opening - $temp_closing) / 60,2);
           $morning_slots = $partial_slot/$time_interval; 

             for ($i=0; $i<=$morning_slots;$i++){
                $minute =($time_interval*$i);
                $endTime = strtotime("+$minute minutes", strtotime($morning_start_time));
  
                if($dateTrue) { 
				   if($this->slot_diffrence(date('Y-m-d h:i A', $endTime)) >0){
					$slots_M [] =  date('h:i A', $endTime);
					}
                }else{
                $slots_M [] =  date('h:i A', $endTime);
               }
            }
           $data['morning'] = $slots_M;
        }
 
 
        
         if($this->trim_time($morning_close_time) > 1200 ){
           $slots_A  = [];
           $partial_slot = '1200';

           $closing_time = $this->trim_time($morning_close_time);
           if($closing_time != 1600 && $closing_time > 1600){
            $closing_time = 1600;
           }

           if($this->trim_time($morning_start_time) > '1200'){
            $slotTime = $morning_start_time;
           }else{
             $slotTime ='12:00 PM';
           }
   
           $temp_closing = strtotime($closing_time);
           $temp_opening = strtotime($partial_slot);
           $partial_slot =round(abs($temp_opening - $temp_closing) / 60,2);
           $morning_slots = $partial_slot/$time_interval;  
             
			for ($i=1; $i<=$morning_slots;$i++){
                  $minute =($time_interval*$i);
                  $endTime = strtotime("+$minute minutes", strtotime($slotTime));
                  if($dateTrue){ 
					 if($this->slot_diffrence(date('Y-m-d h:i A', $endTime)) >0){
						$slots_A [] =  date('h:i A', $endTime);
					 }
                  }else{
                  $slots_A [] =  date('h:i A', $endTime);
				  }  


            }
           $data['afternoon'] = $slots_A;
        }
        
 
 
         if($this->trim_time($evening_start_time) >= 1600 ){

           $slots_E = [];
           $partial_slot = $this->trim_time($evening_start_time);
           $closing_time = $this->trim_time($evening_close_time);
           if($closing_time != 2100 && $closing_time > 2100){
            $closing_time = 2100;
           }
           
           $temp_closing = strtotime($closing_time);
           $temp_opening = strtotime($partial_slot);
           $partial_slot =round(abs($temp_opening - $temp_closing) / 60,2);
           $morning_slots = $partial_slot/$time_interval; 

           for ($i=0; $i<=$morning_slots;$i++){
                $minute =($time_interval*$i);
                $endTime = strtotime("+$minute minutes", strtotime($evening_start_time));

               if($dateTrue){ 
                  if($this->slot_diffrence(date('Y-m-d h:i A', $endTime)) >0){
                    $slots_E [] =  date('h:i A', $endTime);
                  }
               }
              else{
                $slots_E [] =  date('h:i A', $endTime);
              } 

            }
           $data['evening'] = $slots_E;

        }
        

        // getting Evening time slots
         if($this->trim_time($evening_close_time) <= 2400  && $this->trim_time($evening_close_time) > 2100 ){
           $slots_N = [] ;
           $partial_slot = '2100';
           $closing_time = $this->trim_time($evening_close_time);
         
           $temp_closing = strtotime($closing_time);
           $temp_opening = strtotime($partial_slot);
           $partial_slot =round(abs($temp_opening - $temp_closing) / 60,2);
           $morning_slots = $partial_slot/$time_interval; 

           
            
             for ($i=1; $i<=$morning_slots;$i++){
                  $minute =($time_interval*$i);
                  $endTime = strtotime("+$minute minutes", strtotime('09:00 PM'));
               

               if($dateTrue)  { 
                  if($this->slot_diffrence(date('Y-m-d h:i A', $endTime)) >0){
                    $slots_N [] =  date('h:i A', $endTime);
                  }
               }else{
                  $slots_N [] =  date('h:i A', $endTime);
                } 
            }
           $data['night'] = $slots_N;
        }
        $arr = array('status' => 'true', 'message' => 'GET_MY_CLENIC','data'=>  $data);
       
	  }else{
		$arr = array('status' => 'false', 'message' => $this->ts_functions->getlanguage( 'closed_clinic', 'message', 'solo' )); 
			
	  }
	}else{
		$arr = array('status' => 'false', 'message' => $this->ts_functions->getlanguage( 'bookingclosedbydoctor', 'message', 'solo' )); 
	} 
	   header('Content-Type: application/json');      
       echo json_encode($arr);
   }  

    /******************************Book Apointment Start***********/

	public function book_appointment(){
		$user_id = (isset($_POST['user_id'])) ? $_POST['user_id'] : $this->user_id;
		$user_level=(isset($_POST['user_level'])) ? $_POST['user_level'] : $this->user_level;
		$apo_clinic_id=$_POST['cl_id'];
		$timing=$_POST['timing'];
		//$apo_timeoffset=$_POST['timeoffset'];
		$apo_timeoffset='-330';
		$date=$_POST['date'];
		
		
		$apo_timing = date("H:i", strtotime($timing));
		$apo_date = date("Y-m-d", strtotime($date));
		$apo_user_id = $user_id ;
		
		$check_slot=$this->DatabaseModel->select_data('apo_id' , 'dd_appointment' ,array('apo_date' =>$apo_date  , 'apo_timing' =>$apo_timing ,'apo_clinic_id' =>$apo_clinic_id),1);
		$clinic_detail=$this->DatabaseModel->select_data('cl_uid' , 'dd_clinics' ,array('cl_id' =>$apo_clinic_id ));
	    $apo_doctor_id=$clinic_detail[0]['cl_uid'];
		
		
		if(!empty($check_slot)){
			$resp=array('status' => 'false' , 'message'=>$this->ts_functions->getlanguage('appointment_fail', 'api', 'solo' ), 'data'=>'' );
		}else{
			$dataArr=array(
			'apo_user_id' =>$apo_user_id,
			'apo_clinic_id'=>$apo_clinic_id,
			'apo_doctor_id'=>$apo_doctor_id,
			'apo_timing'=>$apo_timing,
			'apo_date'=>$apo_date,
			'apo_datetime'=>$apo_date.' '.$apo_timing,
			'apo_note'=>'bookedbyuser',
			);
			
			$apo_id=$this->DatabaseModel->access_database('dd_appointment','insert',$dataArr, '');
            $this->ts_functions->sendbookingemails($apo_id,1);			
			$resp=array('status' => 'true' , 'message'=>$this->ts_functions->getlanguage( 'appointment_sucess', 'api', 'solo' ), 'data'=>'' );
		}
		header('Content-Type: application/json');      
        echo json_encode($resp);  
		 
	}
	
	public function app_email(){
	  $this->ts_functions->sendbookingemails(1,3);
	  
	}
  /******************************Book Apointment END***********/
  
  /******************************Book Apointment Start***********/
  function canceled_appointment(){
	 
		$apo_id=$_POST['apo_id'];
		$apo_status=$_POST['apo_status'];
		$cod="apo_id = $apo_id";
		
		$user_id = ($this->user_id != '') ? $this->user_id : $_POST['user_id'];
	    $user_level=($this->user_level != '') ? $this->user_level : $_POST['user_level'];
		
		
		if($user_level == 3){
		$cod.=" AND apo_doctor_id = $user_id";	
		}else{
		$cod.=" AND apo_user_id = $user_id";	
		}
		$checkApo=$this->DatabaseModel->select_data('*' , 'dd_appointment' , $cod , 1);
		
		
		if($checkApo){
		  $updateArr=array('apo_status' => $apo_status);
		  if($user_level == 3){
			  if($apo_status==0){
				$updateArr['apo_note']='cancelebydoctor';
                $this->ts_functions->sendbookingemails($apo_id,3);				 
			  }else{
				  $updateArr['apo_note']='rebookebydoctor';
			  }
		  }else{
			  if($apo_status==0){
				 $updateArr['apo_note']='rebookebydoctor';
                  $this->ts_functions->sendbookingemails($apo_id,2);				 
			  }else{
				  $updateArr['apo_note']='rebookebyuser';
			  }
		  }	
		 
		  
		  $this->DatabaseModel->access_database('dd_appointment' , 'update' ,$updateArr , $cod);
		  
		  $resp=array('status' => 'true' , 'message'=>$this->ts_functions->getlanguage('update_success', 'message', 'solo' ), 'data'=>'' ); 
		}else{
			 $resp=array('status' => 'False' , 'message'=>$this->ts_functions->getlanguage('newslettererr', 'message', 'solo' ), 'data'=>'' ); 
		}
		header('Content-Type: application/json');      
        echo json_encode($resp); 
		
	}
  
  /******************************Book Apointment End***********/
  
}