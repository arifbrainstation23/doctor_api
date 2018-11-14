<?php
$map_api = $this->ts_functions->getsettings('map' , 'api');
if(isset($doctordetails)){
	$user_id     = $doctordetails[0]['user_id'];
	$user_name   = $doctordetails[0]['user_name'];
	$user_email  = $doctordetails[0]['user_email'];
	$user_mobile =$doctordetails[0]['user_mobile'];
	$user_category =$this->ts_functions->get_user_meta($user_id , 'category' ); 
	$user_subcategory =$this->ts_functions->get_user_meta($user_id , 'subcategory' ); 
	$user_exp =$this->ts_functions->get_user_meta($user_id , 'exp' ); 
	$user_qual =$this->ts_functions->get_user_meta($user_id , 'qual' ); 
	$user_fees =$doctordetails[0]['user_fees'];
	$user_address =$this->ts_functions->get_user_meta($user_id , 'address' ); 
	$user_lat =$this->ts_functions->get_user_meta($user_id , 'lat' ); 
	$user_long =$this->ts_functions->get_user_meta($user_id , 'long' ); 
	$user_spec =explode(" , ",$this->ts_functions->get_user_meta($user_id , 'spec' ));
	$user_desc =$this->ts_functions->get_user_meta($user_id , 'desc' );
	
}else{
	$user_id     = 0;
	$user_name   = '';
	$user_email  ='';
	$user_mobile ='';
	$user_category =''; 
	$user_subcategory =''; 
	$user_exp =''; 
	$user_qual =''; 
	$user_fees =''; 
	$user_address =''; 
	$user_lat =''; 
	$user_long =''; 
	$user_spec =''; 
	$user_desc='';
}
?>

<div class="row">
    <div class="col-md-12">
        <div class="hs_heading medium">
            <h3><?php echo (isset($doctordetails) ? 'Update ' : 'Add New' );?>  Doctor</h3>
        </div>
    </div>
</div>

<div class="row">
  <form action="<?php echo base_url().'admin/update_doctors';?>"  method="post" id="add_user_form">
    <div class="col-md-4">
        <div class="hs_input">
            <label>Full Name</label>
            <input type="text" class="form-control required" id="user_name" name="user_name" value="<?php echo $user_name; ?>">
        </div>
    </div>
    <div class="col-md-4">
        <div class="hs_input">
            <label>Email address</label>
            <input type="email" class="form-control required" id="user_email" name="user_email" value="<?php echo $user_email; ?>" data-valid="email" data-error="Please enter valid email" <?php echo (isset($doctordetails) ? 'readonly ' : '' );?>>
        </div>
    </div>
    <div class="col-md-4">
        <div class="hs_input">
            <label>Phone</label>
            <input type="text" class="form-control required" id="user_mobile" name="user_mobile" value="<?php echo $user_mobile; ?>" data-valid="mobile" data-error="Please enter valid mobile">
        </div>
    </div>
    <div class="col-md-4">
        <div class="hs_input">
            <label>Select Category</label>
            <select class="form-control required" onchange="getSubCategories(this)" id="user_category" name="user_category">
			<option value="0">Choose one</option>
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
        <div class="hs_input">
		 <?php
				if( $user_subcategory!='' ) {
					$subCate = $this->DatabaseModel->select_data('*','dd_subcategories',array('sub_parent'=>$user_category));
					
				}
				else {
					$subCate = '';
				}

			?>
            <label>Select Sub-Category</label>
            <select class="form-control required" id="user_subcategory" name="user_subcategory">
               <option value="0">Choose one</option>
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
        <div class="hs_input">
            <label>Experience</label>
            <input type="text" class="form-control required" id="user_exp" name="user_exp" value="<?php echo $user_exp; ?>" data-valid="number" data-error="Please enter valid number">
        </div>
    </div>
    <div class="col-md-4">
        <div class="hs_input">
            <label>Qualification</label>
            <input type="text" class="form-control required" id="user_qual" name="user_qual" value="<?php echo $user_qual; ?>">
        </div>
    </div>
    <div class="col-md-4">
        <div class="hs_input">
            <label>Fee</label>
            <input type="text" class="form-control required" id="user_fees" name="user_fees" value="<?php echo $user_fees; ?>">
        </div>
    </div>
	<div class="col-md-4">
        <div class="hs_input">
            <label>SPECIALIZATION</label>
			<select   class="form-control required" id="user_spec" name="user_spec[]" multiple>
			
				<?php
				 foreach($specialityList as $soloSpc) {
					if( $user_spec!='') {
						$selected = (in_array($soloSpc['spe_name'], $user_spec)) ? 'selected' : '' ;
					}
					else {
						$selected = '';
					}
					
					echo '<option value="'.$soloSpc['spe_name'].'" '.$selected.'>'.$soloSpc['spe_name'].'</option>';
				  } ?>
									
			</select>
        </div>
    </div>
   
    <div class="col-md-12">
        <div class="hs_input">
            <label>Address</label>
            <textarea rows="4" class="form-control required" id="user_address" name="user_address"><?php echo $user_address; ?></textarea>
			 <input id="latitute" type="hidden"      name="user_lat" value="<?php echo $user_lat; ?>">
			 <input id="longtitute" type="hidden"     name="user_long" value="<?php echo $user_long; ?>">
			 <input id="user_id" type="hidden"     name="user_id" value="<?php echo $user_id; ?>" >  
        </div>
    </div>
	
	 <div class="col-md-12">
        <div class="hs_input">
            <label>Short Description</label>
            <textarea rows="4" class="form-control required" id="user_desc" name="user_desc"><?php echo $user_desc; ?></textarea>
        </div>
    </div>
	
	<?php
     if(!empty($fields)){
		 foreach($fields as $solofield){
			 $meta_value='';
			 $field_id=$solofield['field_id'];
			 $key=$solofield['name'];
			 $type=$solofield['type'];
			 $label=$solofield['label'];
			
			 
			 if($type=='text'){
				 if(isset($doctordetails)){
					 $meta_value =$this->ts_functions->get_user_meta($user_id , $key );  
				 }
				 echo '<div class="col-md-12">
						<div class="hs_input" >
							<label>'.$label.'</label>
							<input type="text"  value="'.$meta_value.'" id="'.$key.'" name="'.$key.'" class="form-control customField" ftype="text">
							
						</div>
					</div>';
			 }
			 
			 if($type=='textarea'){
				 if(isset($doctordetails)){
					 $meta_value =$this->ts_functions->get_user_meta($user_id , $key );  
				 }
				 echo '<div class="col-md-12">
						<div class="hs_input" id="'.$key.'" class="customField">
							<label>'.$label.'</label>
							<textarea  id="'.$key.'" name="'.$key.'" class="form-control customField" ftype="textarea">'.$meta_value.'</textarea>
						</div>
					</div>';
			 }
			 
			 if($type=="select"){
				 if(isset($doctordetails)){
					 $meta_value =$this->ts_functions->get_user_meta($user_id , $key );  
				 }
				 $options = !empty($solofield['options']) ? json_decode($solofield['options']) : array();
				 
				 echo '<div class="col-md-12">  
						<div class="hs_input">
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
				 if(isset($doctordetails)){
					 $meta_value =$this->ts_functions->get_user_meta($user_id , $key );  
				 }
				$options = !empty($solofield['options']) ? json_decode($solofield['options']) : array();
				echo '<div class="col-md-12">
				       <div class="hs_input">
					     <label>'. $label.'</label> 
						 <div class="hs_radio_list">';
						      for($i=0;$i<count($options);$i++){
                                    $checked = ($options[$i]== $meta_value) ? 'checked' : '';									
									echo '<div class="hs_radio">
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
				 if(isset($doctordetails)){
					 $meta_value_arr =explode(',',$this->ts_functions->get_user_meta($user_id , $key ));  
				 } 
				  
				$options = !empty($solofield['options']) ? json_decode($solofield['options']) : array();
				echo '<div class="col-md-12">
				      <div class="hs_input">
					    <label>'. $label.'</label>
						<div class="hs_checkbox_list">';
						 for($i=0;$i<count($options);$i++){
                            $checked = (in_array($options[$i], $meta_value_arr)) ? 'checked' : '' ;							
				           echo	'<div class="hs_checkbox">
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
	<?php if($map_api!=''){ ?>
	<div class="col-md-12">
	<input id="pac-input" class="controls" type="text" placeholder="Search Box"> 
		<div class="hs_input">
			<label>Select location (Move pointer)</label>
			<div class="hs_map_wrapper">
				<div id="map_canvas" style="width: 100%; height: 300px;"></div>
			</div>
		</div>
	</div>
	   <script src="https://maps.googleapis.com/maps/api/js?key=<?php echo $map_api;?>&libraries=places" ></script>
	
	<?php } ?>	
     
    <div class="col-md-12">
        <div class="hs_checkbox">
            <input type="checkbox" id="send_detail" name="send_detail">
            <label for="send_detail">Send this details to this Doctor's Email</label>
        </div>
    </div>
    <div class="col-md-12">
        <a  class="btn " onclick="adddoctorbutton(this)"><?php echo (isset($doctordetails) ? 'Update ' : 'Add' );?></a>
		 
    </div>
</form>	
</div>

                            