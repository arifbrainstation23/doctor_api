<div class="row">
    <div class="col-md-12">
        <div class="hs_heading medium">
            <h3>Email Templates</h3>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <!-- tab start -->
        <div class="hs_tabs">
            <ul class="nav nav-pills">
			    <li class="active"><a data-toggle="pill" href="#basic_setting_tab">Basic </a></li>
                <li ><a data-toggle="pill" href="#registartion_tab">Registration </a></li>
                <li><a data-toggle="pill" href="#forget_tab">Forget Password </a></li>
                <li><a data-toggle="pill" href="#add_newuser_tab">Add New User </a></li>
                <li><a data-toggle="pill" href="#book_appointment_tab">Book Appointment </a></li>
                <li><a data-toggle="pill" href="#cancel_appointment_tab">Cancel Appointment </a></li>
            </ul>
                
            <div class="tab-content">
			    <!-- Basic Setting tab start -->
                <div id="basic_setting_tab" class="tab-pane fade in active">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="hs_input">
                                <label>From name</label>
                                 <input type="text" class="form-control settingsfields" id="email_fromname" value="<?php echo $this->ts_functions->getsettings('email','fromname');?>">
                            </div>
                        </div>
						<div class="col-md-8">
                            <div class="hs_input">
                               <label>From email</label>
                              <input type="text" class="form-control settingsfields" id="email_fromemail" value="<?php echo $this->ts_functions->getsettings('email','fromemail');?>">
                            </div>
                        </div>
						<div class="col-md-8">
                            <div class="hs_input">
                              <label>Email on which you wish to receive Contact page  queries / support </label>
                              <input type="text" class="form-control settingsfields" id="email_contactemail" value="<?php echo $this->ts_functions->getsettings('email','contactemail');?>">
                            </div>
                        </div>
						<div class="col-md-12">
						   <a onclick="updateSettings('settingsfields')" class="btn ">UPDATE</a>
                        </div>
                    </div>
                </div>
               <!-- Basic Serring tab end -->
			   
			   <!-- Registartion template tab start -->
                <div id="registartion_tab" class="tab-pane fade ">
                    <div class="row">
					    <div class="col-md-8">
						 <div class="alert alert-info th_setting_text">
                            <p><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Use below shortcodes.</p>
                        </div>
						<div class="th_shortcode_wrapper">
                            <p> [username] : To use Registered User's Name </p>
                            <p> [linktext] : Activation link will appear here</p>
                            <p> [break] : To break the line</p>
						</div>
                        <div class="alert alert-info th_setting_text">
                            <p><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Use above shortcodes.</p>
                        </div>
						</div>
						 <div class="col-md-8">
                            <div class="hs_input">
                               <label>Subject</label>
								<input type="text" class="form-control settingsfields" id="registrationemail_subject" value="<?php echo $this->ts_functions->getsettings('registrationemail','subject');?>">
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="hs_input">
                               <label>Template text</label>
                                <textarea rows='8' class="form-control settingsfields" id="registrationemail_text"><?php echo $this->ts_functions->getsettings('registrationemail','text');?></textarea>
                            </div>
                        </div>
						<div class="col-md-8 hide">
                            <div class="hs_input">
                               <label>Activation link text</label>
                               <input type="text" class="form-control settingsfields" id="registrationemail_linktext" value="<?php echo $this->ts_functions->getsettings('registrationemail','linktext');?>">
                            </div>
                        </div>
						<div class="col-md-12">
						  <a onclick="updateSettings('settingsfields')" class="btn ">UPDATE</a>
                        </div>
                    </div>
                </div>
               <!-- Registartion template tab end -->
				
				
                <!-- Forget password tab start -->
                <div id="forget_tab" class="tab-pane fade">
                    <div class="row">
                        <div class="col-md-8">
							<div class="alert alert-info th_setting_text">
								<p><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Use below shortcodes.</p>
							</div>
							<div class="th_shortcode_wrapper">
								<p> [username] : To use User's Name </p>
								<p> [linktext] : Reset password link will appear here</p>
								<p> [break] : To break the line</p>
							</div>
							<div class="alert alert-info th_setting_text">
								<p><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Use above shortcodes.</p>
							</div>
						</div>
						<div class="col-md-8">
                            <div class="hs_input">
                               <label>Subject</label>
								<input type="text" class="form-control settingsfields" id="forgotpwdemail_subject" value="<?php echo $this->ts_functions->getsettings('forgotpwdemail','subject');?>">
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="hs_input">
                               <label>Template text</label>
                                <textarea rows='8' class="form-control settingsfields" id="forgotpwdemail_text"><?php echo $this->ts_functions->getsettings('forgotpwdemail','text');?></textarea>
                            </div>
                        </div>
						 <div class="col-md-8 hide">
                            <div class="hs_input">
                               <label>Forgot password link text</label>
                                <input type="text" class="form-control settingsfields" id="forgotpwdemail_linktext" value="<?php echo $this->ts_functions->getsettings('forgotpwdemail','linktext');?>">
                            </div>
                        </div>
						
                        <div class="col-md-12">
                             <a onclick="updateSettings('settingsfields')" class="btn ">UPDATE</a>
                        </div>
                      
                    </div>
                </div>
                <!-- Forget password tab end -->

                <!-- Add New User tab start -->
                <div id="add_newuser_tab" class="tab-pane fade">
                    <div class="row">
						<div class="col-md-8">
                        <div class="alert alert-info th_setting_text">
                            <p><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Use below shortcodes.</p>
                        </div>
						<div class="th_shortcode_wrapper">
							<p> [username] : User's Name </p>
							<p> [password] : Password</p>
							<p> [website_link] : Website link</p>
							<p> [break] : To break the line</p>
						</div>
                        <div class="alert alert-info th_setting_text">
                            <p><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Use above shortcodes.</p>
                        </div>
                        </div>
						<div class="col-md-8">
                            <div class="hs_input">
                               <label>Subject</label>
								<input type="text" class="form-control settingsfields" id="addnewuseremail_subject" value="<?php echo $this->ts_functions->getsettings('addnewuseremail','subject');?>">
                            </div>
                        </div>
						<div class="col-md-8">
                           <div class="hs_input">
                                 <label>Template text</label>
                                 <textarea rows='8' class="form-control settingsfields" id="addnewuseremail_text"><?php echo $this->ts_functions->getsettings('addnewuseremail','text');?></textarea>
                           </div>
                        </div>
					
                        <div class="col-md-12">
                            <a onclick="updateSettings('settingsfields')" class="btn ">UPDATE</a>
                        </div>
                    </div>
                </div>
                <!-- Add New User tab end -->
				
				<!-- Book Appointment start -->
                <div id="book_appointment_tab" class="tab-pane fade">
                    <div class="row">
						<div class="col-md-8">
                        <div class="alert alert-info th_setting_text">
                            <p><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Use below shortcodes.</p>
                        </div>
						<div class="th_shortcode_wrapper">
							<p> [username] : User's Name </p>
							<p> [website_link] : Website link</p>
							<p> [break] : To break the line</p>
						</div>
                        <div class="alert alert-info th_setting_text">
                            <p><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Use above shortcodes.</p>
                        </div>
                        </div>
						<div class="col-md-8">
                            <div class="hs_input">
                               <label>Subject (This will use for all appointment email)</label>
							   
								<input type="text" class="form-control settingsfields" id="bookingemail_subject" value="<?php echo $this->ts_functions->getsettings('bookingemail','subject');?>">
                            </div>
                        </div>
						<div class="col-md-8">
                           <div class="hs_input">
                                 <label>Template text (User)</label>
                                 <textarea rows='8' class="form-control settingsfields" id="bookappointment_text"><?php echo $this->ts_functions->getsettings('bookappointment','text');?></textarea>
                           </div>
                        </div>
						<div class="col-md-8">
                           <div class="hs_input">
                                 <label>Template text (Dcotor)</label>
                                 <textarea rows='8' class="form-control settingsfields" id="bookappointmentdoc_text"><?php echo $this->ts_functions->getsettings('bookappointmentdoc','text');?></textarea>
                           </div>
                        </div>
					
                        <div class="col-md-12">
                            <a onclick="updateSettings('settingsfields')" class="btn ">UPDATE</a>
                        </div>
                    </div>
                </div>
               <!-- Book Appointment end -->
			   
			   <!-- Cancel Appointment start -->
                <div id="cancel_appointment_tab" class="tab-pane fade">
                    <div class="row">
						<div class="col-md-8">
                        <div class="alert alert-info th_setting_text">
                            <p><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Use below shortcodes.</p>
                        </div>
						<div class="th_shortcode_wrapper">
							<p> [username] : User's Name </p>
							<p> [doctorname] : Doctor's name</p>
							<p> [website_link] : Website link</p>
							<p> [break] : To break the line</p>
						</div>
                        <div class="alert alert-info th_setting_text">
                            <p><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Use above shortcodes.</p>
                        </div>
                        </div>
						<div class="col-md-8">
                           <div class="hs_input">
                                 <label>Template text(Canceled by patient)</label>
                                 <textarea rows='8' class="form-control settingsfields" id="cancelbyuser_text"><?php echo $this->ts_functions->getsettings('cancelbyuser','text');?></textarea>
                           </div>
                        </div>
						<div class="col-md-8">
                           <div class="hs_input">
                                 <label>Template text(Canceled by Doctor)</label>
                                 <textarea rows='8' class="form-control settingsfields" id="cancelbydoctor_text"><?php echo $this->ts_functions->getsettings('cancelbydoctor','text');?></textarea>
                           </div>
                        </div>
					
                        <div class="col-md-12">
                            <a onclick="updateSettings('settingsfields')" class="btn ">UPDATE</a>
                        </div>
                    </div>
                </div>
               <!-- Cancel Appointment end -->
				
				
            </div>
		  <!-- tab end -->
        </div>   
    </div>
</div>