<?php
if(isset($patientdetails)){
	
	$user_id     = $patientdetails[0]['user_id'];
	$user_name   = $patientdetails[0]['user_name'];
	$user_email  = $patientdetails[0]['user_email'];
	$user_mobile =$patientdetails[0]['user_mobile'];
	$user_address =$this->ts_functions->get_user_meta($user_id , 'address' ); 
	
}else{
	$user_id     = 0;
	$user_name   = '';
	$user_email  ='';
	$user_mobile ='';

	$user_address ='';
}	
	
?>

<div class="row">
    <div class="col-md-12">
        <div class="hs_heading medium">
            <h3><?php echo (isset($patientdetails) ? 'Update ' : 'Add New' );?>  Patient</h3>
        </div>
    </div>
</div>

<div class="row">
  <form action="<?php echo base_url().'admin/update_patients';?>"  method="post" id="add_user_form">
    <div class="col-md-4">
        <div class="hs_input">
            <label>Full Name</label>
            <input type="text" class="form-control required" id="user_name" name="user_name" value="<?php echo $user_name; ?>">
        </div>
    </div>
    <div class="col-md-4">
        <div class="hs_input">
            <label>Email address</label>
            <input type="email" class="form-control required" id="user_email" name="user_email" value="<?php echo $user_email; ?>" data-valid="email" data-error="Please enter valid email" <?php echo (isset($patientdetails) ? 'readonly ' : '' );?>>
        </div>
    </div>
    <div class="col-md-4">
        <div class="hs_input">
            <label>Phone</label>
            <input type="text" class="form-control" id="user_mobile" name="user_mobile" value="<?php echo $user_mobile; ?>" data-valid="mobile" data-error="Please enter valid mobile">
        </div>
    </div>
 
    <div class="col-md-12">
        <div class="hs_input">
            <label>Address</label>
            <textarea rows="4" class="form-control" id="user_address" name="user_address"><?php echo $user_address; ?></textarea>
			 <input id="user_id" type="hidden"     class="" name="user_id" value="<?php echo $user_id; ?>" >  
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
				 if(isset($patientdetails)){
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
				 if(isset($patientdetails)){
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
				 if(isset($patientdetails)){
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
				 if(isset($patientdetails)){
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
				 if(isset($patientdetails)){
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
	 
    <div class="col-md-12">
        <div class="hs_checkbox">
            <input type="checkbox" id="send_detail" name="send_detail">
            <label for="send_detail">Send this details to this Patient's Email</label>
        </div>
    </div>
    <div class="col-md-12">
        <a  class="btn " onclick="adddoctorbutton(this)"><?php echo (isset($patientdetails) ? 'Update ' : 'Add' );?></a>
    </div>
</form>	
</div>