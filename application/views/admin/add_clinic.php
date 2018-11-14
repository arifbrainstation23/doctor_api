
<?php
$map_api = $this->ts_functions->getsettings('map' , 'api');
if(isset($clinicdetails)){
	
	$cl_id     = $clinicdetails[0]['cl_id'];
	$cl_uid    = $clinicdetails[0]['cl_uid'];
	$cl_name   = $clinicdetails[0]['cl_name'];
	$cl_open_days  =json_decode($clinicdetails[0]['cl_open_days']);
	$cl_address =$clinicdetails[0]['cl_address'];
	$cl_contact =$clinicdetails[0]['cl_contact'];
	$cl_coordinates=json_decode($clinicdetails[0]['cl_coordinates']);
	
	$cl_lat =$cl_coordinates->lat; 
	$cl_long =$cl_coordinates->long; 
	$motime=$clinicdetails[0]['cl_motime'];
	$mctime=$clinicdetails[0]['cl_mctime'];
	$eotime=$clinicdetails[0]['cl_eotime'];
	$ectime=$clinicdetails[0]['cl_ectime'];
	$open_days_arr=json_decode($clinicdetails[0]['cl_open_days']);
	$cl_time_interval=$clinicdetails[0]['cl_time_interval'];
	
	
}else{
	$cl_id     = 0;
	$cl_uid    = '';
	$cl_name   = '';
	$cl_open_days  ='';
	$cl_address ='';
	$cl_contact ='';
	$cl_lat =''; 
	$cl_long =''; 
	$motime='';
	$mctime='';
	$eotime='';
	$ectime='';
	$open_days_arr=array();
	$cl_time_interval='';
}	
	
?>

<div class="row">
    <div class="col-md-12">
        <div class="hs_heading medium">
            <h3><?php echo (isset($clinicdetails) ? 'Update ' : 'Add New' );?>  Clinic</h3>
        </div>
    </div>
</div>

<div class="row">
  <form action="<?php echo base_url().'admin/update_clinics';?>"  method="post" id="add_clinic_form">
    <div class="col-md-6">
        <div class="hs_input">
            <label>Clinic Name</label>
            <input type="text" class="form-control required" id="cl_name" name="cl_name" value="<?php echo $cl_name; ?>">
        </div>
    </div>
   
    <div class="col-md-6">
        <div class="hs_input">
            <label>Clinic Contact</label>
            <input type="text" class="form-control" id="cl_contact" name="cl_contact" value="<?php echo $cl_contact; ?>" data-valid="mobile" data-error="Please enter valid mobile">
        </div>
    </div>
 
    <div class="col-md-12">
        <div class="hs_input">
            <label>Address</label>
            <textarea rows="4" class="form-control" id="cl_address" name="cl_address"><?php echo $cl_address; ?></textarea>
			 <input id="latitute" type="hidden"     name="cl_lat" value="<?php echo $cl_lat; ?>">
			 <input id="longtitute" type="hidden"     name="cl_long" value="<?php echo $cl_long; ?>">
			 <input id="cl_id" type="hidden"      name="cl_id" value="<?php echo $cl_id; ?>" >  
        </div>
    </div>
	<div class="col-md-6">
        <div class="hs_input">
            <label>Clinic Doctor</label>
            <select class="form-control required" id="cl_uid" name="cl_uid">
			<option value="0">Choose one</option>
				<?php
				 foreach($doctorList as $soloDoc) {
					if( $cl_uid !='' ) {
						$selected = ($cl_uid  == $soloDoc['user_id']) ? 'selected' : '' ;
					}
					else {
						$selected = '';
					}
					echo '<option value="'.$soloDoc['user_id'].'" '.$selected.'>'.$soloDoc['user_name'].'</option>';
				  } ?>
            </select>
        </div>
    </div>

	
	<div class="col-md-6 ">
        <div class="hs_input">
            <label>Clinic Time Interval </label>
            <select class="form-control "  id="cl_time_interval" name="cl_time_interval">
			<?php 
			for($i=0;$i<count($time_intervals);$i++){
				$selected = ($cl_time_interval  == $time_intervals[$i]) ? 'selected' : '' ;
				echo '<option value="'.$time_intervals[$i].'" '.$selected.' >'.$time_intervals[$i].'</option>';
			}
			?>
            </select>
        </div>
    </div>
	
    <div class="col-md-6">
        <div class="hs_input">
            <label>Morning Time (Open)</label>
            <input type="text" class="form-control  timepicker" id="motime" name="motime" value="<?php echo $motime; ?>">
        </div>
    </div>
   
    <div class="col-md-6">
        <div class="hs_input">
            <label>Morning Time (Close)</label> 
            <input type="text" class="form-control timepicker" id="mctime" name="mctime" value="<?php echo $mctime; ?>" >
        </div>
    </div>
	
	<div class="col-md-6">
        <div class="hs_input">
            <label>Evening Time (Open)</label>
            <input type="text" class="form-control  timepicker" id="eotime" name="eotime" value="<?php echo $eotime; ?>">
        </div>
    </div>
   
    <div class="col-md-6">
        <div class="hs_input">
            <label>Evening Time (Close)</label> 
            <input type="text" class="form-control timepicker" id="ectime" name="ectime" value="<?php echo $ectime; ?>" >
        </div>
    </div>
	<div class="col-md-12">
	  <div class="hs_input">
		<label>Open  Days</label>
		<div class="hs_checkbox_list">
		 <?php
		   for($i=0;$i<count($week_days);$i++){
				$checked = (in_array($week_days[$i], $open_days_arr)) ? 'checked' : '' ;							
			   echo	'<div class="hs_checkbox">
						<input type="checkbox" id="open_days'.$i.'""  name="open_days[]"  '.$checked.' value="'.$week_days[$i].'">
						<label for="open_days'.$i.'">'.$week_days[$i].'</label>
				  </div>';	
			  }  
		 ?>
		
	  </div>
	 </div>	
	</div>
	
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
		<a  class="btn " onclick="adddoctorbutton(this)"><?php echo (isset($clinicdetails) ? 'Update ' : 'Add' );?></a>
    </div>
</form>	
</div>