<div class="row">
    <div class="col-md-12">
        <div class="hs_heading medium">
            <h3>Social  Login</h3>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <!-- tab start -->
        <div class="hs_tabs">
            <ul class="nav nav-pills">
                <!-- <li><a data-toggle="pill" href="#fb_setting_tab">Facebook </a></li> -->
                <li class="active"><a data-toggle="pill" href="#google_setting_tab">Google </a></li>
                
            </ul>
                
            <div class="tab-content">
                <!-- Facebook setting tab start -->
                <!-- <div id="fb_setting_tab" class="tab-pane fade">
                    <div class="row">
					   <div class="col-lg-12 col-md-12">
							<div class="col-md-8">
							   <div class="hs_checkbox">
								<input type="checkbox" id="facebook_status" class=" facebookSettings" value="1" <?php echo $this->ts_functions->getsettings('facebook','status') == '1' ? 'checked' : '' ; ?>>
								 <label for="facebook_status">Show Facebook login to users</label>
							   </div>
                            </div>
							<div class="col-md-8">
								<div class="hs_input">
									<label>App Id</label>
									<input type="text" class="form-control facebookSettings" id="facebook_appid" value=" <?php echo $this->ts_functions->getsettings('facebook','appid');?>">
								</div>
                            </div>
							<div class="col-md-8">
								<div class="hs_input">
									<label>App Secret</label>
									<input type="text" class="form-control facebookSettings" id="facebook_appsecret" value=" <?php echo $this->ts_functions->getsettings('facebook','appsecret');?>">
								</div>
                            </div>
							
							<div class="col-md-12">
                             <a onclick="updatePaymentSettings('facebookSettings')" class="btn theme_btn">UPDATE</a>
                            </div>
						</div>
                    </div>
                </div> -->
                <!-- Facebook setting tab end -->

                <!-- Gmail setting tab start -->
                <div id="google_setting_tab" class="tab-pane fade in active">
                    <div class="row">
                         					
					  	<div class="col-md-8">
						   <div class="hs_checkbox">
							<input type="checkbox" id="google_status" class=" googleSettings" value="1" <?php echo $this->ts_functions->getsettings('google','status') == '1' ? 'checked' : '' ; ?>>
							 <label for="google_status">Show Google+ login to users</label>
						   </div>
					  	</div>
					  	<div class="col-md-8">
							<div class="hs_input">
								<label>Client Id</label>
								<input type="text" class="form-control googleSettings" id="google_clientid" value=" <?php echo $this->ts_functions->getsettings('google','clientid');?>">
							</div>
					  	</div>
					  
					  	<div class="col-md-8">
							<div class="hs_input">
								<label>Client Secret</label>
								<input type="text" class="form-control googleSettings" id="google_clientsecret" value=" <?php echo $this->ts_functions->getsettings('google','clientsecret');?>">
							</div>
					  	</div>
					 	<div class="col-md-12 margin-bottom-30">
					   		<a onclick="updatePaymentSettings('googleSettings')" class="btn theme_btn">UPDATE</a>
						</div>

						<div class="col-md-8">
							<div class="hs_instructions">
								<div class="hs_instruction_process">
									<h3>How to get started</h3>
									<p>1) Follow this <a href="https://developers.google.com/identity/sign-in/web/devconsole-project" target="_blank">link</a> OR use <b>https://developers.google.com/identity/sign-in/web/devconsole-project</b> to create your first Google API Console project , and get your Client Id and Client Secret.</p>
								</div>
								
								<div class="hs_instruction_process">
									<h3>Once you are done with creating a project, go to " Credentials " tab , click on your project name , which you have just created.</h3>
									<p>1) Copy your domain name with http:// or https:// , and put it in " Authorized JavaScript origins " field.</p>
									<p>2) Copy this url <b><?php echo base_url();?>authentication/googlelogin</b>, and put it in " Authorized redirect URIs " field.</p>
									<p>3) Click Save.</p>
									<p>4) Copy the Client ID and Client secret, which is under " Credentials " tab.</p>
								</div>
							</div>
						</div>
				   	</div>
                </div>
                <!-- Gmail setting tab end -->	
            </div>
        </div>
        <!-- tab end -->
    </div>
</div>