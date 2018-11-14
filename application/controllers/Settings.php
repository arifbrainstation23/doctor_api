<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if( !isset($this->session->userdata['dd_uid']) ) {
		    redirect(base_url());
		}
		/*if( isset($this->session->userdata['ts_uid']) ) {
    		if($this->session->userdata['ts_level'] != 1) {
			    redirect(base_url());
			}
		}*/
		if(isset($_POST) && !empty($_POST)) {
	        if(!isset($_SERVER['HTTP_REFERER'])) {
                die('Direct Access Not Allowed!!');
	        }
	    }
	    
	}

	public function index(){
	    redirect(base_url().'settings/texts');
	}

	

	public function websites(){
	    $data['basepath'] = base_url();
	    $data['useColor'] = '1';
		$this->load->view('backend/include/header',$data);
		$this->load->view('backend/settings_website',$data);
		$this->load->view('backend/include/footer',$data);
	}

    /**** Function to upload images to server ****/
   /* public function upload_imagesettings() {
	    if(isset($_FILES)) {
	        $path=dirname(__FILE__);
            $abs_path=explode('/application/',$path);
            
            $pathToBGImg = $abs_path[0].'/themes/default/images/';
            $pathTo404Img = $abs_path[0].'/themes/default/images/web/';
            
	        foreach( $_FILES as $k=>$v ) {
                if($v['name'] != ''){
                
                	if( $k == 'backgroundimg_url' ) {
                		$pathToImages = $abs_path[0].'/themes/default/images/';
                	}
                	elseif( $k == 'accountaccessimg_url' || $k == 'notfoundimg_url' || $k == 'oopsimg_url' || $k == 'successimg_url' ) {
                		$pathToImages = $abs_path[0].'/themes/default/images/web/';
                	}
                	else {
                		$pathToImages = $abs_path[0].'/webimage/';
                	}
                	
                    $config['upload_path'] = $pathToImages;
                    $config['allowed_types'] = 'jpg|jpeg|png|gif|ico';

                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);

                    if ($this->upload->do_upload($k))
                    {
                        $arr = explode('_',$k);
                        $imgNewname = $arr[0];
                        $uploaddata=$this->upload->data();

                        $img_name = $uploaddata['raw_name'];
                        $img_ext = $uploaddata['file_ext'];

                        $imgNewname = $imgNewname.$img_ext;
                        if( $img_name != $arr[0] ) {
                            if( file_exists ($pathToImages.$imgNewname) ) {
                                unlink($pathToImages.$imgNewname);
                            }
                        }

                        rename($pathToImages.$img_name.$img_ext, $pathToImages.$imgNewname);

                        if( $k == 'backgroundimg_url' ) {
							$completeLink = base_url().'themes/default/images/'.$imgNewname;
						}
						elseif( $k == 'accountaccessimg_url' || $k == 'notfoundimg_url' || $k == 'oopsimg_url' || $k == 'successimg_url' ) {
							$completeLink = base_url().'themes/default/images/web/'.$imgNewname;
						}
						else {
							$completeLink = base_url().'webimage/'.$imgNewname;
						}
					
                        
                        $this->DatabaseModel->access_database('ts_settings','update',array('value_text'=>$completeLink),array('key_text'=>$arr[0].'_url'));
                    }
                }
            }
            redirect($_SERVER['HTTP_REFERER']);
	    }
	    else {
	        redirect(base_url());
	    }
	    die();
	}*/
	
	public function upload_imagesettings() {
		
	    if(isset($_FILES)) {
	        $path=dirname(__FILE__);
            $abs_path=explode('application',$path);
            
           
            
	        foreach( $_FILES as $k=>$v ) {
                if($v['name'] != ''){
                
                	$pathToImages = $abs_path[0].'/upload/webimages/';
					
                    $config['upload_path'] = $pathToImages;
                    $config['allowed_types'] = 'jpg|jpeg|png|gif|ico|svg';

                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);

                    if ($this->upload->do_upload($k))
                    {
                        $arr = explode('_',$k);
                        $imgNewname = $arr[0];
                        $uploaddata=$this->upload->data();

                        $img_name = $uploaddata['raw_name'];
                        $img_ext = $uploaddata['file_ext'];

                        $imgNewname = 'upload/webimages/'.$imgNewname.$img_ext;
                        if( $img_name != $arr[0] ) {
                            if( file_exists ($pathToImages.$imgNewname) ) {
                                unlink($abs_path[0].$imgNewname);
                            }
                        }

                        rename($pathToImages.$img_name.$img_ext, $abs_path[0].$imgNewname);
                        
                        $this->DatabaseModel->access_database('dd_settings','update',array('value_text'=>$imgNewname),array('key_text'=>$arr[0].'_img'));
                    }else{
						echo "<pre>";print_r($this->upload->display_errors());die;
					}
                }
            }
            redirect($_SERVER['HTTP_REFERER']);
	    }
	    else {
	        redirect(base_url());
	    }
	    die();
	}

    /**** Ajax function to handel updation of settings ****/
	public function update_settingsdetails() {
	    if(isset($_POST['updateform'])) {
	        $updatedata = json_decode($_POST['updatedata']);
	        foreach( $updatedata as $soloKey=>$soloValue ) {
	            if( $soloKey == 'sitecolor_code' ) {
	                $soloValue = ltrim($soloValue,'#');

                    // change color front end 
                    $path=dirname(__FILE__);
                    $abs_path=explode('/application/',$path);
                    $pathToColorFile = $abs_path[0].'/themes/'.$this->theme.'/css/';

                    $curColorCodes = file_get_contents($pathToColorFile.'color.txt');
                    $newColorCodes = str_replace('{ColorCode}',$soloValue,$curColorCodes);
					file_put_contents($pathToColorFile.'color.css',$newColorCodes);
					
					// change color vendor end 
                    
                    $pathToColorFile = $abs_path[0].'/adminassets/css/';

                    $curColorCodes = file_get_contents($pathToColorFile.'color.txt');
                    $newColorCodes = str_replace('{ColorCode}',$soloValue,$curColorCodes);
					file_put_contents($pathToColorFile.'color.css',$newColorCodes);

	            }

	            if( $soloKey == 'sitehighcolor_code' ) {
	                $soloValue = ltrim($soloValue,'#');

                    // change color
                    $path=dirname(__FILE__);
                    $abs_path=explode('/application/',$path);
                    $pathToColorFile = $abs_path[0].'/themes/'.$this->theme.'/css/';

                    $curColorCodes = file_get_contents($pathToColorFile.'color.css');
                    $newColorCodes = str_replace('{ColorCodeHigh}',$soloValue,$curColorCodes);file_put_contents($pathToColorFile.'color.css',$newColorCodes);
					
					// change color vendor end 
                    
                    $pathToColorFile = $abs_path[0].'/adminassets/css/';

                    $curColorCodes = file_get_contents($pathToColorFile.'color.css');
                    $newColorCodes = str_replace('{ColorCodeHigh}',$soloValue,$curColorCodes);file_put_contents($pathToColorFile.'color.css',$newColorCodes);

	            }
	            $this->DatabaseModel->access_database('dd_settings','update',array('value_text'=>$soloValue),array('key_text'=>$soloKey));
	        }
	        echo '1';
	    }
	    else {
	        echo '0';
	    }
	    die();
	}

	/**** Ajax function to handel language text updates ****/
    public function update_languagetext() {
	    if(isset($_POST['currentText'])) {
	        $colArr = explode('#',$_POST['dataId']);

	        $k = 'language_'.$colArr[2];
	        $this->DatabaseModel->access_database('dd_language','update',array($k=>$_POST['currentText']),array('language_key'=>$colArr[0],'language_type'=>$colArr[1]));

	        echo '1';
	    }
	    else {
	        echo '0';
	    }
	    die();
	}

	/**** Function to update main language settings ****/
    public function updatelanguages() {
	    if(isset($_POST['weblanguage_text'])) {
	        if( trim($_POST['addnewlanguage']) != '' ) {
	            $existingLang = $this->ts_functions->getsettings('languageoption','text');
	            $this->DatabaseModel->access_database('dd_settings','update',array('value_text'=>$existingLang.','.$_POST['addnewlanguage']),array('key_text'=>'languageoption_text'));

	            $this->load->dbforge();
	            $k = 'language_'.$_POST['addnewlanguage'];
	            $fields = array(
                    $k => array('type' => 'TEXT')
                );
                $this->dbforge->add_column('dd_language', $fields);
	        }

            $this->DatabaseModel->access_database('dd_settings','update',array('value_text'=>$_POST['weblanguage_text']),array('key_text'=>'weblanguage_text'));
            
            //setcookie("language", $_POST['weblanguage_text'] , time()+60*60*24*30,'/');
            			
			/*$languageswitch_checkbox = (isset($_POST['languageswitch_checkbox'])) ? 1 : 0 ;
			$rtlswitch_checkbox = (isset($_POST['rtlswitch_checkbox'])) ? 1 : 0 ;
			
$this->DatabaseModel->access_database('ts_settings','update',array('value_text'=>$languageswitch_checkbox),array('key_text'=>'languageswitch_checkbox'));
$this->DatabaseModel->access_database('ts_settings','update',array('value_text'=>$rtlswitch_checkbox),array('key_text'=>'rtlswitch_checkbox'));*/

			redirect($_SERVER['HTTP_REFERER']);
	    }
	    else {
	        redirect(base_url());
	    }
	    die();
	}
	
	/******************** Delete Language STARTS ********************/

	function delete_selected_language($langname=''){
		if( $langname != '' ) {
			$existingLang = $this->ts_functions->getsettings('languageoption','text');;
			$lan_arr = explode(',',$existingLang);
			$current_lan = $this->ts_functions->getsettings('weblanguage','text');
			
			$lan_str = '';
			$f_lan = '';
			for($i=0;$i<count($lan_arr);$i++) {
				if( $lan_arr[$i] != $langname ) {
					$lan_str .= $lan_arr[$i].',';
					$f_lan = $lan_arr[$i];
				}
			}
			if( $current_lan == $langname ) {
				$this->DatabaseModel->access_database('dd_settings','update',array('value_text'=>$f_lan),array('key_text'=>'weblanguage_text'));
			}
			
			$lan_str = rtrim($lan_str,',');
			$this->DatabaseModel->access_database('dd_settings','update',array('value_text'=>$lan_str),array('key_text'=>'languageoption_text'));

			$this->load->dbforge();
			$k = 'language_'.$langname;
			$this->dbforge->drop_column('dd_language', $k);
			
		}
		redirect($_SERVER['HTTP_REFERER']);
	}

	/******************** Delete Language ENDS ********************/

	/**** Function to update values of tables ****/

	function updatethevalue() {
	    if(isset($_POST['id'])) {
	        if( $_POST['type'] == 'products' ) {
	            $dArr = explode('_',$_POST['id']);
	            $k = 'prod_'.$dArr[1];
	            $this->DatabaseModel->access_database('ts_products','update',array($k=>$_POST['vlu']),array('prod_id'=>$dArr[0]));
				if( $k == 'prod_status' ) {
					$this->ts_functions->sendnotificationemails_productstatus($dArr[0],$_POST['vlu']);
				}
	        }
	        elseif( $_POST['type'] == 'coupons' ) {
	            $dArr = explode('_',$_POST['id']);
	            $k = 'coup_'.$dArr[1];
	            $this->DatabaseModel->access_database('ts_coupons','update',array($k=>$_POST['vlu']),array('coup_id'=>$dArr[0]));

	        }
	        elseif( $_POST['type'] == 'testi' ) {
	            $dArr = explode('_',$_POST['id']);
	            $k = 'testi_'.$dArr[1];
	            $this->DatabaseModel->access_database('ts_testimonial','update',array($k=>$_POST['vlu']),array('testi_id'=>$dArr[0]));

	        }
	        elseif( $_POST['type'] == 'cat' ) {
	            $dArr = explode('_',$_POST['id']);
	            $k = 'cat_'.$dArr[1];
	            $this->DatabaseModel->access_database('dd_categories','update',array($k=>$_POST['vlu']),array('cat_id'=>$dArr[0]));

	        }
			elseif( $_POST['type'] == 'subcat' ) { 
	            $dArr = explode('_',$_POST['id']);
	            $k = 'sub_'.$dArr[1];
	            $this->DatabaseModel->access_database('dd_subcategories','update',array($k=>$_POST['vlu']),array('sub_id'=>$dArr[0]));

	        }
			elseif( $_POST['type'] == 'blogcate' ) {
	            $dArr = explode('_',$_POST['id']);
	            $k = 'blog_category_'.$dArr[1];
	            $this->DatabaseModel->access_database('ts_blog_category','update',array($k=>$_POST['vlu']),array('blog_category_id'=>$dArr[0]));

	        }
	        elseif( $_POST['type'] == 'categories' ) {
	            $this->ts_functions->updatesettings($_POST['id'],$_POST['vlu']);
	        }
	        elseif( $_POST['type'] == 'user' ) {
	            $dArr = explode('_',$_POST['id']);
	            $k = 'user_'.$dArr[1];
	           
	            $data_ins=array($k=>$_POST['vlu']);
				if($k=='user_plans'){
					
				   $userDetail=$this->DatabaseModel->select_data('user_plansdate' ,'dd_users' , array('user_id' =>$dArr[0]));
				  
				   if($userDetail[0]['user_plansdate']=='0000-00-00 00:00:00'){
					  $data_ins['user_plansdate'] =date('Y-m-d h:i:s ');
				   }
				}
				$this->DatabaseModel->access_database('dd_users','update',$data_ins,array('user_id'=>$dArr[0]));  

	        }
			elseif( $_POST['type'] == 'comment' ) {
	            $dArr = explode('_',$_POST['id']);
	            $k = 'comment_'.$dArr[1];
			$this->DatabaseModel->access_database('ts_comments','update',array($k=>$_POST['vlu']),array('comment_id'=>$dArr[0]));

	        }
			elseif( $_POST['type'] == 'blog' ) {
	            $dArr = explode('_',$_POST['id']);
	            $k = 'blog_'.$dArr[1];
			$this->DatabaseModel->access_database('ts_blogs','update',array($k=>$_POST['vlu']),array('blog_id'=>$dArr[0]));

	        }elseif( $_POST['type'] == 'clinic' ) {
	            $dArr = explode('_',$_POST['id']);
	            $k = 'cl_'.$dArr[1];
	            $this->DatabaseModel->access_database('dd_clinics','update',array($k=>$_POST['vlu']),array('cl_id'=>$dArr[0]));

	        }
	        echo '1';
	    }
	    else {
	        echo '0';
	    }
	    die();
	}


	
	

	

	
	
	
	
	/*************** Plan settings STARTS *********************/
	
	function plans() {
		if($_POST){

			$plan_duration_count=$_POST['plan_duration_count'];
			$plan_duration_type=$_POST['plan_duration_type'];
			$old_planid=$_POST['old_planid'];
			if($plan_duration_type=='Days'){
				$plan_duration=$plan_duration_count*1;
			}elseif($plan_duration_type=='Weeks'){
				$plan_duration=$plan_duration_count*7;
			}elseif($plan_duration_type=='Months'){
				$plan_duration=$plan_duration_count*30;
			}elseif($plan_duration_type=='Years'){
				$plan_duration=$plan_duration_count*365;
			}
			
			$dArr=array(
			'plan_name'=>$_POST['plan_name'],
			'plan_amount'=>$_POST['plan_amount'],
			'plan_description'=>$_POST['plan_description'],
			'plan_duration'=>$plan_duration,
			'plan_duration_txt'=>$_POST['plan_duration_count'].' '.$_POST['plan_duration_type'],
			);
			 if($old_planid=='0') {
                    $this->DatabaseModel->access_database('dd_plans','insert',$dArr,'');
                    $this->session->userdata['ts_success'] = 'Plan added successfully.';
			}
			else {
				$this->DatabaseModel->access_database('dd_plans','update',$dArr, array('plan_id'=>$old_planid));
				$this->session->userdata['ts_success'] = 'Plan updated successfully.';
			}
			
		}
	    $data['basepath'] = base_url();
	    $data['plan_details'] = $this->DatabaseModel->select_data('*','dd_plans','','');
		$data['settings_active']=1;
		$data['plans_active']=1;
	    $this->load->view('admin/common/header',$data);
		$this->load->view('admin/plans',$data);
		$this->load->view('admin/common/footer',$data);
	}
	public function get_plan_detail(){
		$plan_id=$_POST['plan_id'];
		$plan_detail=$this->DatabaseModel->select_data('*','dd_plans',array('plan_id'=>$plan_id),1);
		if(!empty($plan_detail)){
			$resp=array('status' => true ,'message'=>'', 'data'=>$plan_detail[0]);
		}else{
			$resp=array('status' => false ,'message'=>'Invalid access', 'data'=> '');
		}
		echo json_encode($resp , JSON_UNESCAPED_SLASHES);	
	}
	
	public function texts(){
	    $data=array();
		$data['settings_active']=1;
		$data['text_active']=1;
		$this->load->view('admin/common/header',$data);
		$this->load->view('admin/settings_text',$data);
		$this->load->view('admin/common/footer',$data);   
	}
	
	public function social_login(){
	    $data=array();
		$data['settings_active']=1;
		$data['social_active']=1;
		$this->load->view('admin/common/header',$data);
		$this->load->view('admin/social_login',$data);
		$this->load->view('admin/common/footer',$data);   
	}
	
	function payment(){
	    $data=array();
		$data['settings_active']=1;
		$data['paymethod_active']=1;
		$this->load->view('admin/common/header',$data);
		$this->load->view('admin/settings_payment',$data); 
		$this->load->view('admin/common/footer',$data);   
	}
	

}
?>
