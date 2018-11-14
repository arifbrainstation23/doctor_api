<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->user_id=$this->ts_functions->dd_uid;
		$this->user_level=$this->ts_functions->dd_level;
		
	}

	/* Common Logout */
    public function logout(){
        $this->session->sess_destroy();
        redirect(base_url());
	}
	
	public function check_user(){
		$user_email=$_POST['user_email'];
		$check_user= $this->DatabaseModel->select_data('user_id','dd_users',array('user_email' => $user_email),'');
		if(empty($check_user)){
			echo 1;
		}else{
			0;
		}
	}
	
	 function getSubCategories(){
        if(isset($_POST['cateId'])) {
            $subCate  = $this->DatabaseModel->access_database('dd_subcategories','select','',array('sub_parent'=>$_POST['cateId']));
            $str = '<option value="0">'.$this->ts_functions->getlanguage('choose_one','commontext','solo').'</option>';
            if(!empty($subCate)) {
                foreach($subCate as $solo_subCate) {
                    $str .= '<option value="'.$solo_subCate['sub_id'].'">'.$solo_subCate['sub_name'].'</option>';
                }
            }
            else {
                $str .= '<option value="0">'.$this->ts_functions->getlanguage('nothing_found','commontext','solo').'</option>';
            }
            echo $str;
        }
        else {
	        echo '0';
	    }
	    die();
    }

	
	function plan_purchase(){
		$plan_id=$_POST['plan_id'];
		$payment_method=$_POST['payment_method'];
		$user_id=$this->user_id;
		if($user_id=='' ){
			$resp = array('status' => false , 'message' => 'Please login' ,'data'=>'login'); 
		}elseif($this->user_level!=3){
			$resp = array('status' => false , 'message' =>$this->ts_functions->getlanguage('not_docor','commontext','solo'),'data'=>'invaliduser'); 
		}else{
			
			$plan_detail=$this->DatabaseModel->select_data('plan_name,plan_amount','dd_plans',array('plan_id'=>$plan_id),1);
			$plan_name=	$plan_detail[0]['plan_name'];
			$plan_amount=$plan_detail[0]['plan_amount'];
			$custom_arr=$user_id;
			
			
			
			
		 if( $payment_method == 'paypal' ) {
					$formData =
						  '<form action="https://www.paypal.com/cgi-bin/webscr" method="post" name="pay_form_name">
						  <input type="hidden" name="business" value="'.$this->ts_functions->getsettings('paypal','email').'">
						  <input type="hidden" name="item_name" value="'.$plan_name.'">
						  <input type="hidden" name="amount" value="'.$plan_amount.'">
						  <input type="hidden" name="item_number" value="'.$plan_id.'">
						  <input type="hidden" name="no_shipping" value="1">
						  <input type="hidden" name="currency_code" value="'.$this->ts_functions->getsettings('portal','curreny').'">
						  <input type="hidden" name="cmd" value="_xclick">
						  <input type="hidden" name="handling" value="0">
						  <input type="hidden" name="no_note" value="1">
						  <input type="hidden" name="cpp_logo_image" value="'.$this->ts_functions->getsettings('logo','url').'">
						  <input type="hidden" name="custom" value="'.$custom_arr.'">
						  <input type="hidden" name="cancel_return" value="'.base_url().'pages/canceled_payment">
						  <input type="hidden" name="return" value="'.base_url().'pages/success_payment">
							<input type="hidden" name="notify_url" value="'.base_url().'pages/notify_payment">
						 </form>';
				
				}
			$resp = array('status' => true , 'message' => '' ,'data'=>$formData); 
		}
		
		header('Content-Type: application/json');      
        echo json_encode($resp);
		
	}
	
	
	
}
