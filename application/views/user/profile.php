
<?php  
    $map_api = $this->ts_functions->getsettings('map' , 'api');
	if($this->ts_functions->dd_level != 3){  
	$map_api = '';
	}
    $user_id     = $patientdetails['user_id'];
	$user_name   = $patientdetails['user_name'];
	$user_email  = $patientdetails['user_email'];
	$user_mobile =$patientdetails['user_mobile'];
	$user_gender =$patientdetails['user_gender'];
	//$user_lat ='40.7128';
	//$user_long='-74.0060';
	$user_lat ='';
	$user_long='';
	
	$user_address =$this->ts_functions->get_user_meta($user_id , 'address' );
	$user_age =$this->ts_functions->get_user_meta($user_id , 'age' );
	
	/*****doctor fields start ****/
	if(isset($doctor_profile)){
	$user_category =$this->ts_functions->get_user_meta($user_id , 'category' ); 
	$user_subcategory =$this->ts_functions->get_user_meta($user_id , 'subcategory' ); 
	
	$user_exp =$this->ts_functions->get_user_meta($user_id , 'exp' ); 
	$user_qual =$this->ts_functions->get_user_meta($user_id , 'qual' ); 
	$user_fees =$patientdetails['user_fees'];
	$user_lat =$this->ts_functions->get_user_meta($user_id , 'lat' ); 
	$user_long =$this->ts_functions->get_user_meta($user_id , 'long' ); 
    $user_spec =explode(" , ",$this->ts_functions->get_user_meta($user_id , 'spec' ));
	$user_desc =$this->ts_functions->get_user_meta($user_id , 'desc' );
	}
	/*if($user_lat==''){
	   $user_lat ='40.7128';
	   $user_long='-74.0060';
	}*/
	
	
	$username_arr=explode(' ',$user_name);
	$name_initiails=substr($username_arr[0] , 0, 1); 
	if(isset($username_arr[1])){
		$name_initiails.=substr($username_arr[1] , 0, 1); 
	}
	/***** doctor fields end ****/
	
	
    $user_image='';
	if( $patientdetails['user_pic'] !=''){
		$user_image=base_url().$patientdetails['user_pic'];
	}
	
	
	/** current Plan ***/
	$currentPlan=0;
	if($patientdetails['user_plans']!=0){
		$planDetail=$this->DatabaseModel->select_data('plan_name,plan_duration_txt','dd_plans',array('plan_id'=>$patientdetails['user_plans']),1);
		if(!empty($planDetail)){
			$currentPlan=$patientdetails['user_plans'];
		}
	}
	
 
 ?>
<div class="dd_page_title">
    <h3><?php echo $this->ts_functions->getlanguage('profile_setting', 'menus', 'solo' ); ?></h3><br><br>
</div>

<div class="dd_profile_wrapper">
    <div class="container">
        <div class="row">
			<div class="col-md-4">
                <div class="dd_profile_image_wrapper">
                    <div class="dd_user_img">
					   <form action="<?php echo base_url().'user/update_profile_pic';?>" method="post" enctype="multipart/form-data" id="update_profilepic_form">
					   <?php if($user_image!=''){ ?>
                        <img src="<?php echo $user_image; ?>" alt="" >
					   <?php } ?>
						<input type="file" class="user_profile_upload" name="user_pic" >
						<?php if($user_image!=''){ ?>
						<span class="dd_remove_image"></span>
						<?php } ?>
                        <span class="dd_user_initials"><?php echo $name_initiails; ?></span>
					</form>	
                    </div>
                    <div class="dd_user_name">
                        <p><?php echo  strtoupper($user_name) ; ?></p>
						
                        <span><?php echo $this->ts_functions->getlanguage('age', 'profile', 'solo' ); ?> - <?php echo  $user_age ; ?> <?php echo $this->ts_functions->getlanguage('years', 'profile', 'solo' ); ?></span>
                    </div>
                </div>
				<?php if($this->ts_functions->dd_level != 3){ ?>
                <div class="text-center margin-bottom-10">
                   
					<button type="button" class="dd_btn" data-toggle="modal" data-target="#become_a_doctor"><?php echo $this->ts_functions->getlanguage('become_doctor', 'profile', 'solo' ); ?></button>
                </div>
				<?php } ?>
            </div>
			
			<div class="col-md-8">
				<div class="dd_tab_wrapper">
					<ul class="nav nav-tabs">
						<li class="active"><a data-toggle="tab" href="#account_information_tab"><?php echo $this->ts_functions->getlanguage('account_info', 'profile', 'solo' ); ?></a></li>
						<li><a data-toggle="tab" href="#change_password_tab"><?php echo $this->ts_functions->getlanguage('change_pass', 'profile', 'solo' ); ?></a></li>
						
						<?php if($this->ts_functions->dd_level == 3){ 
						
						if($this->ts_functions->getsettings('portal','revenuemodel') == 'plan'){
							echo '<li><a data-toggle="tab" href="#bills_and_plans_tab">'.$this->ts_functions->getlanguage('bills_plans', 'profile', 'solo' ).'</a></li>';
						} ?>
						
						<li><a data-toggle="tab" href="#settings_tab"><?php echo $this->ts_functions->getlanguage('setting', 'profile', 'solo' ) ?></a></li>
						<?php } ?>
					</ul>
 
					
						<div class="tab-content">
							<!-- account information tab start -->
							<div id="account_information_tab" class="tab-pane fade in active">
							 <form action="<?php echo base_url().'user/update_profile';?>"  method="post" id="update_profile_form">
								<div class="row">
									<div class="col-md-12">
										<h3 class="dd_title_medium"><?php echo $this->ts_functions->getlanguage('account_info', 'profile', 'solo' ); ?></h3>
									</div>
									<div class="col-md-6">
										<div class="dd_input_wrapper">
											<label><?php echo $this->ts_functions->getlanguage('full_name', 'profile', 'solo' ); ?></label>
											<input type="text" class="form-control required" placeholder=""  id="user_name" name="user_name" value="<?php echo $user_name; ?>">
										</div>
									</div>
									<div class="col-md-6">
										<div class="dd_input_wrapper">
											<label><?php echo $this->ts_functions->getlanguage('email', 'profile', 'solo' ); ?></label>
											<input type="text" class="form-control required" id="user_email" name="user_email" value="<?php echo $user_email; ?>" readonly>
										</div>
									</div>
									<div class="col-md-6">
										<div class="dd_input_wrapper">
											<label><?php echo $this->ts_functions->getlanguage('phone', 'profile', 'solo' ); ?></label>
											<input type="text" class="form-control required" placeholder="" id="user_mobile" name="user_mobile" value="<?php echo $user_mobile; ?>" data-valid="mobile" data-error="<?php echo $this->ts_functions->getlanguage('validmobile', 'message', 'solo' ); ?></label>">	
										</div>
									</div>
									<div class="col-md-3">
										<div class="dd_input_wrapper">
											<label><?php echo $this->ts_functions->getlanguage('age', 'profile', 'solo' ); ?></label>
											<input type="text" class="form-control required"  id="user_age" name="user_age" value="<?php echo $user_age; ?>" data-valid="number" data-error="<?php echo $this->ts_functions->getlanguage('validnumber', 'message', 'solo' ); ?>">
										</div>
									</div>
									<div class="col-md-3">
										<div class="dd_input_wrapper">
											<label><?php echo $this->ts_functions->getlanguage('gender', 'profile', 'solo' ); ?></label>
											<select class="form-control required" id="user_gender" name="user_gender">
												<option value="female" <?php if($user_gender=='female') echo 'selected';?>><?php echo $this->ts_functions->getlanguage('female', 'profile', 'solo' ); ?></option>
												<option value="male" <?php if($user_gender=='male') echo 'selected';?> ><?php echo $this->ts_functions->getlanguage('male', 'profile', 'solo' ); ?></option>
											</select>
										</div>
									</div>
									<div class="col-md-12">
										<div class="dd_input_wrapper">
											<label><?php echo $this->ts_functions->getlanguage('address', 'profile', 'solo' ); ?></label>
											<textarea rows="4" id="user_address required" name="user_address" class="form-control" placeholder=""><?php echo $user_address; ?></textarea>
											<input id="latitute"  type="hidden"    name="user_lat" value="<?php echo $user_lat; ?>">
											<input id="longtitute" type="hidden"    name="user_long" value="<?php echo $user_long; ?>">
											 
										</div>
									</div>
									
									<!--------------Doctor fields Start-------------------->
									<?php
									if(isset($doctor_profile)){ ?>
									<div class="col-md-4">
										<div class="dd_input_wrapper">
											<label><?php echo $this->ts_functions->getlanguage('select_category', 'profile', 'solo' ); ?></label>
											<select class="form-control required" onchange="getSubCategories(this)" id="user_category" name="user_category">
											<option value="0"><?php echo $this->ts_functions->getlanguage('choose_one', 'profile', 'solo' ); ?></option>
												<?php
												 foreach($categoryList as $soloCate) {
													if( $user_category !='' ) {
														$selected = ($user_category  == $soloCate['cat_id']) ? 'selected' : '' ;
													}
													else {
														$selected = '';
													}
													echo '<option value="'.$soloCate['cat_id'].'" '.$selected.'>'.$soloCate['cat_name'].'</option>';
												  } ?>
											</select>
										</div>
									</div>
									
									<div class="col-md-4">
										<div class="dd_input_wrapper">
										 <?php
												if( $user_subcategory!='' ) {
													$subCate = $this->DatabaseModel->access_database('dd_subcategories','select','',array('sub_parent'=>$user_category));
												}
												else {
													$subCate = '';
												}

											?>
											<label><?php echo $this->ts_functions->getlanguage('select_subcategory', 'profile', 'solo' ); ?></label>
											<select class="form-control required" id="user_subcategory" name="user_subcategory">
											   <option value="0"><?php echo $this->ts_functions->getlanguage('choose_one', 'profile', 'solo' ); ?></option>
												 <?php
												 if(!empty($subCate)) {
												 foreach($subCate as $solo_subCate) {
													if($user_subcategory!='') {
														$selected = ($user_subcategory == $solo_subCate['sub_id']) ? 'selected' : '' ;
													}
													else {
														$selected = '';
													}
													echo '<option value="'.$solo_subCate['sub_id'].'" '.$selected.'>'.$solo_subCate['sub_name'].'</option>';
												  }
												}
												?>
											</select>
										</div>
									</div>
									 <div class="col-md-4">
										<div class="dd_input_wrapper">
											<label><?php echo $this->ts_functions->getlanguage('exp', 'profile', 'solo' ); ?></label>
											<input type="text" class="form-control required" id="user_exp" name="user_exp" value="<?php echo $user_exp; ?>" data-valid="number" data-error="Please enter valid number">
										</div>
									</div>
									<div class="col-md-4">
										<div class="dd_input_wrapper">
											<label><?php echo $this->ts_functions->getlanguage('qualification', 'profile', 'solo' ); ?></label>
											<input type="text" class="form-control required" id="user_qual" name="user_qual" value="<?php echo $user_qual; ?>">
										</div>
									</div>
									<div class="col-md-4">
										<div class="dd_input_wrapper">
											<label><?php echo $this->ts_functions->getlanguage('fee', 'profile', 'solo' ); ?></label>
											<input type="text" class="form-control required" id="user_fees" name="user_fees" value="<?php echo $user_fees; ?>" data-valid="number" data-error="Please enter valid number">
										</div>
									</div>
									<div class="col-md-4">
										<div class="dd_input_wrapper">
											<label><?php echo $this->ts_functions->getlanguage('spec', 'profile', 'solo' ); ?></label>
											<select   class="form-control required" id="user_spec" name="user_spec[]" multiple>
											
												<?php
												 foreach($specialityList as $soloSpc) {
													if( $user_spec!='') {
														//$selected = ($productdetails[0]['prod_cateid'] == $soloCate['cate_id']) ? 'selected' : '' ;
														$selected = (in_array($soloSpc['spe_name'], $user_spec)) ? 'selected' : '' ;
													}
													else {
														$selected = '';
													}
													//$selected = 'selected';
													echo '<option value="'.$soloSpc['spe_name'].'" '.$selected.'>'.$soloSpc['spe_name'].'</option>';
												  } ?>
																	
											</select>
										</div>
									</div>
									 <div class="col-md-12">
										<div class="dd_input_wrapper">
											<label><?php echo $this->ts_functions->getlanguage('short_info', 'profile', 'solo' ); ?></label>
											<textarea rows="4" class="form-control required" id="user_desc" name="user_desc"><?php echo $user_desc; ?></textarea>
										</div>
									</div>
								  
									<?php } ?>
									
									<!--------------Doctor fields End---------------------->
									
									
									
									<?php
									 if(!empty($fields)){
										 foreach($fields as $solofield){
											 $meta_value='';
											 $field_id=$solofield['field_id'];
											 $key=$solofield['name'];
											 $type=$solofield['type'];
											 $label=$solofield['label'];
											
											 
											 if($type=='text'){
												 if(isset($patientdetails)){
													 $meta_value =$this->ts_functions->get_user_meta($user_id , $key );  
												 }
												 echo '<div class="col-md-12">
														<div class="dd_input_wrapper" >
															<label>'.$label.'</label>
															<input type="text"  value="'.$meta_value.'" id="'.$key.'" name="'.$key.'" class="form-control customField" ftype="text">
															
														</div>
													</div>';
											 }
											 
											 if($type=='textarea'){
												 if(isset($patientdetails)){
													 $meta_value =$this->ts_functions->get_user_meta($user_id , $key );  
												 }
												 echo '<div class="col-md-12">
														<div class="dd_input_wrapper" id="'.$key.'" class="customField">
															<label>'.$label.'</label>
															<textarea  id="'.$key.'" name="'.$key.'" class="form-control customField" ftype="textarea">'.$meta_value.'</textarea>
														</div>
													</div>';
											 }
											 
											 if($type=="select"){
												 if(isset($patientdetails)){
													 $meta_value =$this->ts_functions->get_user_meta($user_id , $key );  
												 }
												 $options = !empty($solofield['options']) ? json_decode($solofield['options']) : array();
												 
												 echo '<div class="col-md-12">  
														<div class="dd_input_wrapper">
															<label>'. $label.'</label>
															<select  id="'.$key.'"  name="'.$key.'" class="form-control customField" ftype="select">';
																for($i=0;$i<count($options);$i++){
																	 $selected = ($options[$i]== $meta_value) ? 'selected' : '';									
																	echo '<option value="'.$options[$i].'"  '.$selected.'>'.$options[$i].'</option>';
																}
																	
												echo		'</select>
														</div>
													</div>';
												 
											 }
											 
											 
											 if($type=='radio'){
												 if(isset($patientdetails)){
													 $meta_value =$this->ts_functions->get_user_meta($user_id , $key );  
												 }
												$options = !empty($solofield['options']) ? json_decode($solofield['options']) : array();
												echo '<div class="col-md-12">
													   <div class="dd_input_wrapper">
														 <label>'. $label.'</label> 
														 <div class="dd_radio_list">';
															  for($i=0;$i<count($options);$i++){
																	$checked = ($options[$i]== $meta_value) ? 'checked' : '';									
																	echo '<div class="dd_radio">
																				<input type="radio" id="'.$key.$i.'" name="'.$key.'"  '.$checked.' class="customField" value="'.$options[$i].'">
																				<label for="'.$key.$i.'">'.$options[$i].'</label>
																		  </div>';
																}
																
												echo		'</div>
													  </div>	
													</div>';				
											 }
											 
											  if($type=='checkbox'){
												  $meta_value_arr=array();
												 if(isset($patientdetails)){
													 $meta_value_arr =explode(',',$this->ts_functions->get_user_meta($user_id , $key ));  
												 } 
												  
												$options = !empty($solofield['options']) ? json_decode($solofield['options']) : array();
												echo '<div class="col-md-12">
													  <div class="dd_input_wrapper">
														<label>'. $label.'</label>
														<div class="dd_checkbox_list">';
														 for($i=0;$i<count($options);$i++){
															$checked = (in_array($options[$i], $meta_value_arr)) ? 'checked' : '' ;							
														   echo	'<div class="dd_checkbox">
																	<input type="checkbox" id="'.$key.$i.'""  name="'.$key.'[]"  '.$checked.' value="'.$options[$i].'">
																	<label for="'.$key.$i.'">'.$options[$i].'</label>
															  </div>';	
														  }  
												 echo  '</div>
													 </div>	
													</div>';				
											  
											  }
										 
										 
										 }
									 }

									?>
								 
									<?php 
									if($map_api!=''){ ?>
									<div class="col-md-12">
									<input id="pac-input" class="controls" type="text" placeholder="Search Box">
										<div class="dd_input_wrapper">
											<label><?php echo $this->ts_functions->getlanguage('select_location', 'profile', 'solo' ); ?></label>
											<div class="dd_map_wrapper">
												<div id="map_canvas" style="width: 100%; height: 300px;"></div>
											</div>
										</div>
									</div>
									 <script src="https://maps.googleapis.com/maps/api/js?key=<?php echo $map_api;?>&libraries=places" ></script>
									<?php } ?>	
									
									<div class="col-md-12">
										<div class="dd_input_wrapper">
                                           <input type="hidden" name="general">										
											<button type="button" class="dd_btn" onclick="updateprofile()" ><?php echo $this->ts_functions->getlanguage('save_changes', 'profile', 'solo' ); ?></button>
										</div>
									</div>
									
								</div>
							  </form>	
							</div>
							<!-- account information tab end -->
							
							<!-- change password tab start -->
							<div id="change_password_tab" class="tab-pane fade">
							 <form action="<?php echo base_url().'user/update_profile';?>"  method="post" id="">
								<div class="row">
									 <div class="col-md-12">
										<h3 class="dd_title_medium"><?php echo $this->ts_functions->getlanguage('change_pass', 'profile', 'solo' ); ?></h3>
									</div>
									<div class="col-md-6">
										<div class="dd_input_wrapper">
											<input type="password" class="form-control" placeholder="<?php echo $this->ts_functions->getlanguage('logpwdtext', 'authentication', 'solo' ); ?>" name="user_password">
										</div>
									</div>
									<div class="col-md-6">
										<div class="dd_input_wrapper">
											<input type="password" class="form-control" placeholder="<?php echo $this->ts_functions->getlanguage('logconfirmpwdtext', 'authentication', 'solo' ); ?>" name="user_cpassword">
										</div>
									</div>				
									<div class="col-md-12">
										<div class="dd_input_wrapper"> 
											<button type="submit" class="dd_btn" onclick="" name="chng_pass"><?php echo $this->ts_functions->getlanguage('save_changes', 'profile', 'solo' ); ?></button>
										</div>
									</div>
								</div>
							   </form>
							</div>
							<!-- change password tab end -->
							<?php if($this->ts_functions->getsettings('portal','revenuemodel') == 'plan'){?>
							<!-- bills and plans start -->
							<div id="bills_and_plans_tab" class="tab-pane fade">
								<div class="row">
									<div class="col-md-12">
										<h3 class="dd_title_medium"><?php echo $this->ts_functions->getlanguage('current_plan', 'profile', 'solo' ); ?></h3>
									</div>
								<?php if(!empty($currentPlan)){ 
								
									$currency = $this->ts_functions->getsettings('portalcurreny' , 'symbol');
					 echo        '<div class="col-md-12">
										<div class="dd_current_plan">
											<ul>
												<li>
													<label>'.$this->ts_functions->getlanguage('plan_name', 'profile', 'solo' ).'</label>
													<p>'.$planDetail[0]['plan_name'].'</p>	
												</li>
												<li>
													<label>'.$this->ts_functions->getlanguage('plan_duration', 'profile', 'solo' ).'</label>
													<p>'.$planDetail[0]['plan_duration_txt'].'</p>	
												</li>
												
												<li>
													<label>'.$this->ts_functions->getlanguage('active_date', 'profile', 'solo' ).'</label>
													<p>'.date("d-M-Y", strtotime($patientdetails['user_plansdate'])).'</p>	
												</li>
												
												
											</ul>
										</div>
									</div>';
								
								}
									?>
									
								</div>
								
								<div class="row">
									<div class="col-md-12">
										<h3 class="dd_title_medium"><?php echo $this->ts_functions->getlanguage('my_payment', 'profile', 'solo' ) ?></h3>
									</div>
								<?php if(!empty($paymentdetails)){ 
								foreach($paymentdetails as $soloPayment){
									$currency = $this->ts_functions->getsettings('portalcurreny' , 'symbol');
					 echo        '<div class="col-md-12">
										<div class="dd_current_plan">
											<ul>
												<li>
													<label>'.$this->ts_functions->getlanguage('plan_name', 'profile', 'solo' ).'</label>
													<p>'.$soloPayment['plan_name'].'</p>	
												</li>
												
												<li>
													<label>'.$this->ts_functions->getlanguage('amount', 'profile', 'solo' ).'</label>
													<p>'.$currency.' '.$soloPayment['payment_amount'].'</p>	
												</li> 
												<li>
													<label>'.$this->ts_functions->getlanguage('payment_mode', 'profile', 'solo' ).'</label>
													<p>'.$soloPayment['payment_mode'].'</p>	
												</li>
												<li>
													<label>'.$this->ts_functions->getlanguage('payment_date', 'profile', 'solo' ).'</label>
													<p>'.date("d-M-Y", strtotime($soloPayment['payment_date'])).'</p>	
												</li>
												
												
											</ul>
										</div>
									</div>';
								}
								}
									?>
									
								</div>
							</div>
							<?php } ?>
							<!-- bills and plans end -->
							<!-- settings start -->
							<div id="settings_tab" class="tab-pane fade">
								<div class="row">
									<div class="col-md-12">
										<h3 class="dd_title_medium"><?php echo $this->ts_functions->getlanguage('setting', 'profile', 'solo' ); ?></h3>
									</div>
									
									<div class="col-md-12">
									<?php
									$checked=($this->ts_functions->get_user_meta($user_id , 'booking_status' )=='no'? '':'checked' );
									
                                     
									?>
										<div class="dd_input_wrapper">
											<label><?php echo $this->ts_functions->getlanguage('deactive_book', 'profile', 'solo' ); ?></label>
											<div class="dd_switch">
												<input type="checkbox"  id="start_booking" data-type="booking_status" <?php echo $checked; ?>>
												<label for="start_booking"></label>
											</div>
										</div>
										
									</div>
									
								</div>
							</div>
							<!-- settings end -->
						</div>
				</div>
			</div>
		
        </div>
    </div>
</div>


<?php if($this->ts_functions->dd_level==2) {?>
<!-- Become a doctor popup start -->
<div id="become_a_doctor" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><span><?php echo $this->ts_functions->getlanguage('become_doctor', 'profile', 'solo' ); ?></h4>
            </div>
            <div class="modal-body">
			  <div class="ts_tnc_section">
				<?php /*$tnc = $this->ts_functions->getsettings('doctor','tnctext');
				    $tncArr = explode(PHP_EOL, $tnc);
				    for($i=0;$i<count($tncArr);$i++) {
                         echo '<p>'.$tncArr[$i].'</p>';
                    }*/
					 echo $this->ts_functions->getlanguage('tnctext', 'profile', 'solo' );
				?>
				</div>
				 <div class="dd_input_wrapper">
					<div class="dd_checkbox">
						<input type="checkbox" id="tnc">
						<label for="tnc"><?php echo $this->ts_functions->getlanguage('acceptt_terms', 'profile', 'solo' ); ?></label>
					</div>
				</div>
				<div class="dd_input_wrapper"> 
				  <button type="button" class="dd_btn" onclick="become_a_doctor()"><?php echo $this->ts_functions->getlanguage('continue', 'profile', 'solo' ); ?></button>
                 </div>
            </div>
			
        </div>
    </div>
</div>
<!-- Become a doctor popup end -->

<?php } ?>



