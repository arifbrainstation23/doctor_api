<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pages extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->user_id=$this->ts_functions->dd_uid;
		$this->user_level=$this->ts_functions->dd_level;
	}
	
	function test(){
		$res='{"mc_gross":"99.00","protection_eligibility":"Ineligible","payer_id":"HBCQKADFVN6BC","tax":"0.00","payment_date":"05:41:19 Feb 28, 2017 PST","payment_status":"Completed","charset":"windows-1252","first_name":"shabaj","mc_fee":"1.72","notify_version":"3.8","custom":"13","payer_status":"verified","business":"syinfotech333-facilitator1@gmail.com","quantity":"1","verify_sign":"A0KTMB4-ZjjK-X-NYRBS6h0mNzW.AiR-jz5sUKxihoCq.D8QRGj7EIcn","payer_email":"shahbaj.shah@himanshusofttech.com","txn_id":"9687093922225500H","payment_type":"instant","last_name":"shah","receiver_email":"syinfotech333-facilitator1@gmail.com","payment_fee":"1.72","receiver_id":"2NFKYQB4RV5M6","txn_type":"web_accept","item_name":"Moto Themes Developer","mc_currency":"USD","item_number":"3","residence_country":"US","test_ipn":"1","handling_amount":"0.00","transaction_subject":"","payment_gross":"99.00","shipping":"0.00","ipn_track_id":"1ce2d64ec0a58"}';
		$_POST=json_decode($res ,true);
		//$this->DatabaseModel->access_database('dd_record' , 'insert' , array('type' => 'paypal' , 'data' =>json_encode($_POST)) , '');
		if(isset($_POST['payer_id'])) {
            $user_id = trim($_POST['custom']);
            $plan_id = $_POST['item_number'];
			$payable_amount = $_POST['mc_gross'];
			
			
            $checkPlan = $this->DatabaseModel->select_data('*','dd_plans',array('plan_id'=>$plan_id));
			
            if( !empty($checkPlan) ) {
               if($payable_amount==$checkPlan[0]['plan_amount']){
				   
				   $this->DatabaseModel->access_database('dd_users','update',array('user_plans'=>$plan_id,'user_plansdate' => date('Y-m-d H:i:s')),array('user_id'=>$user_id));
				   $payment_arr=array(
				   'payment_uid'=>$user_id,
				   'payment_pid'=>$plan_id,
				   'payment_mode'=>'paypal',
				   'payment_amount'=>$payable_amount,
				   'payment_date'=>date('Y-m-d H:i:s'),
				   );
				   $this->DatabaseModel->access_database('dd_paymentdetails' ,'insert' , $payment_arr ,'' );
			   }
                
            }
        }
		
		
	}
	
	function canceled_payment() {
        $data['pagetype_toptext'] = 'payCanceledHeading';
        $data['pagetype_heading'] = 'payCancelh3';
        $data['pagetype_text'] = 'payCanceltext';
        $this->load->view('user/common/header' , $data);
		$this->load->view('user/success' , $data);
		$this->load->view('user/common/footer' , $data);
    }
	
	function success_payment() {
      
        $data['pagetype_toptext'] = 'paySuccessHeading';
        $data['pagetype_heading'] = 'paySuccessh3';
        $data['pagetype_text'] = 'paySuccesstext';
      
		$this->load->view('user/common/header' , $data);
		$this->load->view('user/success' , $data);
		$this->load->view('user/common/footer' , $data);
    }
	
	
	function notify_payment() {
     if(isset($_POST['payer_id'])) {
		  $this->DatabaseModel->access_database('dd_record' , 'insert' , array('type' => 'paypal' , 'data' =>json_encode($_POST)) , '');
            $user_id = trim($_POST['custom']);
            $plan_id = $_POST['item_number'];
			$payable_amount = $_POST['mc_gross'];
			
			
            $checkPlan = $this->DatabaseModel->select_data('*','dd_plans',array('plan_id'=>$plan_id));
			
            if( !empty($checkPlan) ) {
               if($payable_amount==$checkPlan[0]['plan_amount']){
				   
				   $this->DatabaseModel->access_database('dd_users','update',array('user_plans'=>$plan_id,'user_plansdate' => date('Y-m-d H:i:s')),array('user_id'=>$user_id));
				   $payment_arr=array(
				   'payment_uid'=>$user_id,
				   'payment_pid'=>$plan_id,
				   'payment_mode'=>'paypal',
				   'payment_amount'=>$payable_amount,
				   'payment_date'=>date('Y-m-d H:i:s'),
				   );
				 $tranId=$this->DatabaseModel->access_database('dd_paymentdetails' ,'insert' , $payment_arr ,'' );
				   $this->ts_functions->sendtransactionemails($tranId);
			   }
                
            }
        }
    }
}	