<?php 
        $user_id     = $doctorDetail['user_id'];
		$user_name   = $doctorDetail['user_name'];
		
		
		$user_category =$this->ts_functions->get_user_meta($user_id , 'category' );
		$user_subcategory =$this->ts_functions->get_user_meta($user_id , 'subcategory' );
		$subcat=$this->DatabaseModel->select_data('sub_name' , 'dd_subcategories' , array('sub_id' =>  $user_subcategory) ,1);
        if(!empty($subcat)){
			$subcat=$subcat[0]['sub_name'];
		}else{
			$subcat='Uncategorized';
		}		
		
		$user_image=base_url().'assets/user/images/doctor/default_doctor.jpg';
		if( $doctorDetail['user_pic'] !=''){
			$user_image=base_url().$doctorDetail['user_pic'];
		}
		
		$first_clinic_id='';
		$first_clinic_address="";
		if(!empty($clinicDetail)){
		$first_clinic_id=$clinicDetail[0]['cl_id'];
		$first_clinic_address=$clinicDetail[0]['cl_address'];
		}

?>
<div class="dd_page_title">
	<h3><?php echo $this->ts_functions->getlanguage('book_appointment', 'doctordetail', 'solo' ); ?></h3>
</div>

<div class="dd_book_appointment_wrapper">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="dd_dr_profile">
					<div class="dd_dr_profile_img">
						<img src="<?php echo $user_image; ?>" alt="">
					</div>
					<div class="dd_dr_profile_detail">
						<h1><?php echo $user_name; ?></h1>
						<h3><?php echo $subcat; ?></h3>
					</div>
				</div>
			</div>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="dd_page_title dd_appointment_title">
					<h3><?php echo $this->ts_functions->getlanguage('select_clinic', 'doctordetail', 'solo' ); ?></h3>
				</div>
			</div>
			<div class="col-lg-10 col-md-10 col-sm-12 col-xs-12 col-lg-offset-1 col-md-offset-1 col-sm-offset-0 col-xs-offset-0">
               <?php if(!empty($clinicDetail)){ ?>			
				<div class="dd_clinic_slider">
					<div class="owl-carousel owl-theme">
					   <?php foreach ($clinicDetail as $soloClinics){ ?>
						<div class="item selected_clinic" data-id="<?php echo $soloClinics['cl_id']; ?>">
						<span class="selected_clinic_address hide"><?php echo $soloClinics['cl_address']; ?></span>
							<div class="dd_clinic_slider_section">
								<img src="<?= base_url('assets/user/images/icon/clinic_icon.svg') ?>" alt="">
								<h2><?php echo $soloClinics['cl_name']; ?></h2>
							</div>
						</div>
					   <?php } ?>
					</div>
				</div>
			   <?php } ?>
				<div class="row">
				  <?php if($first_clinic_address){ ?>
					<div class="col-lg-8 col-md-8 col-sm-12 dd_clinic_address ">
						<p class="dd_clinic_location"><span><img src="<?= base_url('assets/user/images/address.svg') ?>" alt=""></span> <span class="cl_address"><?php echo $first_clinic_address; ?></span></p>
					</div>
					<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 pull-right">
						<div class="dd_date_picker">
						    <input type="hidden" value="<?php echo $first_clinic_id; ?>" id="cl_id">
							<input type="text"  placeholder="<?php echo $this->ts_functions->getlanguage('select_date', 'doctordetail', 'solo' ); ?>" class="book_datepicker" id="booking_date">
							<input type="hidden"   class="booking_time_slot" id="booking_time_slot">
							<span><svg height=30px style="enable-background:new 0 0 60 60"version=1.1 viewBox="0 0 60 60"width=30px x=0px xml:space=preserve y=0px><g><path d="M57,4h-7V1c0-0.553-0.447-1-1-1h-7c-0.553,0-1,0.447-1,1v3H19V1c0-0.553-0.447-1-1-1h-7c-0.553,0-1,0.447-1,1v3H3   C2.447,4,2,4.447,2,5v11v43c0,0.553,0.447,1,1,1h54c0.553,0,1-0.447,1-1V16V5C58,4.447,57.553,4,57,4z M43,2h5v3v3h-5V5V2z M12,2h5   v3v3h-5V5V2z M4,6h6v3c0,0.553,0.447,1,1,1h7c0.553,0,1-0.447,1-1V6h22v3c0,0.553,0.447,1,1,1h7c0.553,0,1-0.447,1-1V6h6v9H4V6z    M4,58V17h52v41H4z"fill=#1cc2b3 /><path d="M38,23h-7h-2h-7h-2h-9v9v2v7v2v9h9h2h7h2h7h2h9v-9v-2v-7v-2v-9h-9H38z M31,25h7v7h-7V25z M38,41h-7v-7h7V41z M22,34h7v7h-7   V34z M22,25h7v7h-7V25z M13,25h7v7h-7V25z M13,34h7v7h-7V34z M20,50h-7v-7h7V50z M29,50h-7v-7h7V50z M38,50h-7v-7h7V50z M47,50h-7   v-7h7V50z M47,41h-7v-7h7V41z M47,25v7h-7v-7H47z"fill=#1cc2b3 /></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg></span>
						</div>
					</div>
				  <?php  } else{?>
				  <div class="col-lg-8 col-md-8 col-sm-12 ">
				  <h2><?php echo $this->ts_functions->getlanguage('noclinicforbook', 'doctordetail', 'solo' ); ?> </h2>
				  </div>  
				  <?php }?>
				</div>
			</div>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 dd_appointment_date_container ">
				<div class="dd_page_title dd_appointment_title">
					<h3 class="dd_appointment_date">04, Nov 2018</h3>
				</div>
			</div>
		</div>
	</div>
</div>


<div class="dd_dr_time_wrapper">
	<div class="container">
		<div class="row">
		  <div class="dd_time_slot_wrapper hide">
			<div class="col-md-12">
				<h3 class="dd_title_medium text-center"><?php echo $this->ts_functions->getlanguage('select_slot', 'doctordetail', 'solo' ); ?></h3>
			</div>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="dd_time_section">	
					<div class="dd_time_icon">
						<svg enable-background="new 0 0 91 91" height="58px" version=1.1 viewBox="0 0 91 91" width="61px" x=0px xml:space=preserve y=0px><g><path d="M51.5,57h-1.1c-0.4-1.6-1-3.4-2-5.3c-3.3-6.2-9.2-9.6-16.5-9.6c-7.4,0-13.3,3.4-16.5,9.6c-1,2-1.6,4-2,5.6   C5.6,58.7,0.2,64.8,0.2,72.9C0.2,81.1,6,87.5,14,88.7c0.4,0.1,0.9,0.2,1.3,0.2h36.2c9.5,0,16.7-6.9,16.7-16   C68.2,63.7,61.2,57,51.5,57z M51.5,80.9H16.9c-6,0-8.7-4.1-8.7-8c0-4.8,3.5-8,8.7-8c2.1,0,3.9-1.7,4-3.9c0,0,0.1-3.1,1.7-6   c1.8-3.4,4.9-5.1,9.2-5.1c4.4,0,7.5,1.7,9.4,5.1c1.6,2.9,1.8,6,1.8,6c0.1,2.1,1.9,3.8,4,3.8h4.5c5.2,0,8.7,3.2,8.7,8   C60.2,76.8,57.5,80.9,51.5,80.9z"fill=#1cc2b3 /><path d="M78.9,46.3h-0.6c-0.3-1.1-0.7-2.3-1.4-3.6c-2.3-4.4-6.5-6.8-11.7-6.8c-0.7,0-1.3,0-2,0.1c-1.1-8.6-8.4-15.2-17.3-15.2   c-8.1,0-15.1,5.5-17,13.4c-0.4,1.6,0.6,3.2,2.2,3.6c1.6,0.4,3.2-0.6,3.6-2.2c1.2-5.2,5.8-8.8,11.1-8.8c6.3,0,11.4,5.1,11.4,11.4   c-1.6,1.1-2.9,2.6-3.8,4.5c-1.6,3.1-1.7,6.1-1.7,6.5c0,1.6,1.2,3,2.9,3.1c1.6,0.1,3-1.2,3.1-2.9c0.1-1.3,0.7-7.5,7.4-7.5   c6.8,0,7.5,6.3,7.5,7.5c0.1,1.6,1.4,2.9,3,2.9h3.1c3.5,0,5.8,2.1,5.8,5.3c0,2.6-1.8,5.3-5.8,5.3h-3.6c-1.7,0-3,1.3-3,3   c0,1.7,1.3,3,3,3h3.6c6.7,0,11.8-4.9,11.8-11.3C90.8,51.1,85.8,46.3,78.9,46.3z"fill=#1cc2b3 /><path d=M46,14.6c1.7,0,3-1.3,3-3V5.1c0-1.7-1.3-3-3-3s-3,1.3-3,3v6.5C43,13.3,44.3,14.6,46,14.6z fill=#1cc2b3 /><path d=M12.8,41.3h6.5c1.7,0,3-1.3,3-3s-1.3-3-3-3h-6.5c-1.7,0-3,1.3-3,3S11.1,41.3,12.8,41.3z fill=#1cc2b3 /><path d="M64.9,22.4c0.8,0,1.5-0.3,2.1-0.9l4.6-4.6c1.2-1.2,1.2-3.1,0-4.2c-1.2-1.2-3.1-1.2-4.2,0l-4.6,4.6c-1.2,1.2-1.2,3.1,0,4.2   C63.3,22.1,64.1,22.4,64.9,22.4z"fill=#1cc2b3 /><path d="M25,21.5c0.6,0.6,1.4,0.9,2.1,0.9c0.8,0,1.5-0.3,2.1-0.9c1.2-1.2,1.2-3.1,0-4.2l-4.6-4.6c-1.2-1.2-3.1-1.2-4.2,0   c-1.2,1.2-1.2,3.1,0,4.2L25,21.5z"fill=#1cc2b3 /></g></svg>
					</div>
					<div class="dd_title">
						<h3><?php echo $this->ts_functions->getlanguage('morning', 'doctordetail', 'solo' ); ?></h3>
					</div>
					<div class="dd_time">
						<ul class="morning_slot">
							
						</ul>
					</div>
				</div>
			</div>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="dd_time_section">	
					<div class="dd_time_icon">
						<svg height="58px" style="enable-background:new 0 0 22 22"version=1.1 viewBox="0 0 22 22" width="61px" x=0px xml:space=preserve y=0px><g><g><path d="M15.997,17H6.003C5.449,17,5,17.443,5,18c0,0.553,0.456,1,1.003,1h9.994C16.551,19,17,18.557,17,18    C17,17.447,16.544,17,15.997,17z"fill=#1cc2b3 /><polygon fill=#1cc2b3 points="11.001,15.996 14.001,11.997 8.001,11.997   "/><path d="M11,6.999c0.552,0,1-0.444,1-1.009V4.009C12,3.452,11.557,3,11,3c-0.552,0-1,0.443-1,1.009V5.99    C10,6.547,10.444,6.999,11,6.999z"fill=#1cc2b3 /><path d="M6.05,9.05c0.389-0.391,0.393-1.021-0.007-1.421l-1.4-1.4c-0.395-0.395-1.028-0.4-1.421-0.007    c-0.39,0.391-0.393,1.021,0.007,1.421l1.4,1.4C5.023,9.437,5.656,9.442,6.05,9.05z"fill=#1cc2b3 /><path d="M20.99,13h-1.981C18.452,13,18,13.443,18,14c0,0.525,0.402,0.956,0.927,0.997h2.146    C21.592,14.956,22,14.529,22,14C22,13.448,21.557,13,20.99,13z"fill=#1cc2b3 /><path d="M2.99,13H1.009C0.452,13,0,13.443,0,14c0,0.525,0.401,0.956,0.927,0.997h2.144    C3.59,14.956,3.999,14.529,3.999,14C3.999,13.448,3.555,13,2.99,13z"fill=#1cc2b3 /><path d="M18.777,6.222c-0.391-0.39-1.021-0.393-1.42,0.007l-1.4,1.4c-0.395,0.394-0.398,1.027-0.007,1.421    c0.391,0.389,1.021,0.393,1.421-0.007l1.4-1.4C19.166,7.248,19.171,6.616,18.777,6.222z"fill=#1cc2b3 /><path d="M5.085,14.997h2.042c-0.082-0.32-0.126-0.655-0.126-1c0-2.209,1.79-3.999,3.999-3.999    s3.999,1.79,3.999,3.999c0,0.345-0.044,0.68-0.126,1h2.042c0.056-0.325,0.083-0.659,0.083-1c0-3.312-2.686-5.998-5.998-5.998    s-5.998,2.686-5.998,5.998C5.002,14.338,5.03,14.672,5.085,14.997z"fill=#1cc2b3 /></g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>
					</div>
					<div class="dd_title">
						<h3><?php echo $this->ts_functions->getlanguage('afternoon', 'doctordetail', 'solo' ); ?></h3>
					</div>
					<div class="dd_time">
						<ul class="afternoon_slot">
							
						</ul>
					</div>
				</div>
			</div>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="dd_time_section">	
					<div class="dd_time_icon">
						<svg height=58px style="enable-background:new 0 0 45.58 45.58"version=1.1 viewBox="0 0 45.58 45.58"width=61px x=0px xml:space=preserve y=0px><g><g><path d="M32.125,30.599c1.207,0,2.186-0.904,2.186-2.111l0,0c0-6.236-5.074-11.272-11.311-11.272    c-6.237,0-11.311,5.018-11.311,11.254c0,1.207,0.979,2.13,2.186,2.13H32.125z"fill=#1cc2b3 /><g><path d=M43,39.599H2c-1.104,0-2-0.896-2-2s0.896-2,2-2h41c1.104,0,2,0.896,2,2S44.104,39.599,43,39.599z fill=#1cc2b3 /></g><g><g><g><path d="M23,13.926c-1.219,0-2-0.988-2-2.206V8.188c0-1.219,0.781-2.207,2-2.207c1.219,0,2,0.988,2,2.207v3.531       C25,12.938,24.219,13.926,23,13.926z"fill=#1cc2b3 /></g></g><g><g><path d="M33.35,18.213c-0.863-0.862-0.863-2.259,0-3.121l2.496-2.497c0.861-0.861,2.26-0.861,3.121,0       c0.862,0.862,0.862,2.26,0,3.121l-2.496,2.497C35.607,19.075,34.211,19.075,33.35,18.213z"fill=#1cc2b3 /></g></g><g><g><path d="M43.373,26.599h-3.531c-1.219,0-2.207,0.792-2.207,2.011c0,1.147,0.879,1.989,1.998,1.989h1.7c0.075,0,0.142,0,0.212,0       h1.828c1.219,0,2.207-0.781,2.207-2S44.592,26.599,43.373,26.599z"fill=#1cc2b3 /></g></g><g><g><path d="M8.364,28.599c0-1.219-0.988-2-2.207-2h-3.53c-1.219,0-2.207,0.781-2.207,2s0.988,2,2.207,2h3.531       C7.376,30.599,8.364,29.817,8.364,28.599z"fill=#1cc2b3 /></g></g><g><g><path d="M12.651,18.213c0.862-0.862,0.862-2.259,0-3.121l-2.497-2.497c-0.862-0.861-2.259-0.861-3.121,0       c-0.862,0.862-0.862,2.26,0,3.121l2.497,2.497C10.392,19.076,11.789,19.076,12.651,18.213z"fill=#1cc2b3 /></g></g></g></g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>
					</div>
					<div class="dd_title">
						<h3><?php echo $this->ts_functions->getlanguage('evening', 'doctordetail', 'solo' ); ?></h3>
					</div>
					<div class="dd_time">
						<ul class="evening_slot">
							
						</ul>
					</div>
				</div>
			</div>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="dd_time_section">	
					<div class="dd_time_icon">
						<svg height=58px style="enable-background:new 0 0 45.74 45.74"version=1.1 viewBox="0 0 45.74 45.74"width=61px x=0px xml:space=preserve y=0px><g><g><g><g><g><path d="M12.2,15.267c0-3.322,0.896-6.43,2.448-9.113c0.376-0.649-0.191-1.451-0.918-1.265       C5.35,7.041-0.711,14.961,0.067,24.179c0.736,8.701,7.768,15.803,16.463,16.617c6.033,0.565,11.517-1.811,15.221-5.848       c0.5-0.546,0.073-1.432-0.666-1.401c-0.196,0.009-0.395,0.013-0.594,0.013C20.389,33.56,12.2,25.371,12.2,15.267z"fill=#1cc2b3 /></g></g><g><path d="M23.144,5.6l0.917,2.633l2.788,0.061c0.354,0.008,0.498,0.456,0.218,0.669l-2.221,1.687l0.805,2.669      c0.104,0.338-0.279,0.614-0.568,0.414l-2.292-1.59l-2.29,1.59c-0.29,0.201-0.669-0.076-0.569-0.414l0.805-2.669l-2.221-1.687      c-0.28-0.213-0.134-0.661,0.218-0.669l2.788-0.061L22.44,5.6C22.556,5.267,23.027,5.267,23.144,5.6z"fill=#1cc2b3 /></g><g><path d="M40.26,26.44l0.881,2.53l2.679,0.057c0.389,0.009,0.549,0.502,0.24,0.737l-2.134,1.621l0.772,2.564      c0.111,0.371-0.309,0.677-0.627,0.454l-2.201-1.527l-2.2,1.527c-0.318,0.223-0.739-0.083-0.626-0.454l0.772-2.564l-2.133-1.621      c-0.31-0.234-0.149-0.729,0.238-0.737l2.679-0.057l0.884-2.53C39.612,26.074,40.131,26.074,40.26,26.44z"fill=#1cc2b3 /></g><g><path d="M39.926,8.098l1.325,3.799l4.021,0.086c0.452,0.01,0.639,0.584,0.278,0.858l-3.204,2.434l1.162,3.853      c0.131,0.433-0.356,0.788-0.729,0.529l-3.306-2.294l-3.305,2.294c-0.372,0.259-0.86-0.097-0.729-0.529l1.161-3.853l-3.205-2.434      c-0.358-0.273-0.172-0.849,0.279-0.858l4.022-0.086l1.324-3.799C39.173,7.672,39.776,7.672,39.926,8.098z"fill=#1cc2b3 /></g></g></g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>
					</div>
					<div class="dd_title">
						<h3><?php echo $this->ts_functions->getlanguage('night', 'doctordetail', 'solo' ); ?></h3>
					</div>
					<div class="dd_time">
						<ul class="night_slot">
						</ul>
					</div>
				</div>
			</div>
			
			<div class="dd_appointment_form">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 margin-bottom-20">
					<a  class="dd_btn" onclick="book_apointment()"><?php echo $this->ts_functions->getlanguage('book', 'doctordetail', 'solo' ); ?></a>
				</div>
			</div>
		  </div>	
		</div>
	</div>
</div>