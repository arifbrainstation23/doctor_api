<div class="row">
    <div class="col-md-12">
        <div class="hs_heading medium">
            <h3>General Option</h3>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <!-- tab start -->
        <div class="hs_tabs">
            <ul class="nav nav-pills">
                <li class="active"><a data-toggle="pill" href="#site_setting_tab">Site </a></li>
                <li><a data-toggle="pill" href="#image_setting_tab">Image </a></li>
                <li><a data-toggle="pill" href="#footer_setting_tab">Footer </a></li>
                <li><a data-toggle="pill" href="#language_setting_tab">Language </a></li>
                <li><a data-toggle="pill" href="#revenue_setting_tab">Revenue </a></li>
                <li><a data-toggle="pill" href="#sms_setting_tab">Sms </a></li>
				<li><a data-toggle="pill" href="#map_setting_tab">Map  </a></li>
				<li><a data-toggle="pill" href="#chat_setting_tab">Chat  </a></li>
				<li><a data-toggle="pill" href="#creditial_setting_tab">Credintials  </a></li>
				<li><a data-toggle="pill" href="#firebase_setting_tab">Firebase  </a></li>
				
				<li><a data-toggle="pill" href="#timezone_setting_tab">Timezone  </a></li>
                <li><a data-toggle="pill" href="#analytics_setting_tab">Google Analytics  </a></li> 				
            </ul>
                
            <div class="tab-content">
				<!-- site setting tab start -->
                <div id="site_setting_tab" class="tab-pane fade in active">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="hs_input">
                                <label>Site Title</label>
                               <input type="text" class="form-control settingsfields" id="sitetitle_text" value=" <?php echo $this->ts_functions->getsettings('sitetitle','text');?>">
                            </div>
                        </div>
						<div class="col-md-8">
                            <div class="hs_input">
                                <label>Site Author</label>
                               <input type="text" class="form-control settingsfields" id="siteauthor_text" value=" <?php echo $this->ts_functions->getsettings('siteauthor','text');?>">
                            </div>
                        </div>
						<div class="col-md-8">
                            <div class="hs_input">
                                <label>Description</label>
                                <textarea class="form-control settingsfields" id="seodescr_text"> <?php echo $this->ts_functions->getsettings('seodescr','text');?></textarea>
                            </div>
                        </div>
						<div class="col-md-8">
                            <div class="hs_input">
                                <label>Meta Keywords</label>
                               <textarea class="form-control settingsfields" id="metatags_text"><?php echo $this->ts_functions->getsettings('metatags','text');?></textarea>
                            </div>
                        </div>
						<div class="col-md-12">
                            <a onclick="updateSettings('settingsfields')" class="btn theme_btn">UPDATE</a>
                        </div>
                    </div>
                </div>
                <!-- site setting tab end -->
				
                <!-- image setting tab start -->
                <div id="image_setting_tab" class="tab-pane fade">
                    <div class="row">
					 <form id="logoform" method="post" action="<?php echo base_url();?>settings/upload_imagesettings"  enctype="multipart/form-data">
                        <div class="col-md-12">
                            <div class="hs_image_viewer">
                                <label>Favicon</label>
                                <div class="iv_image">
                                    <img src="<?php echo base_url().$this->ts_functions->getsettings('favicon','img');?>">	
                                </div>
                                <p class="help-block">Preferred favicon size 32x32px</p>
                                <div class="iv_action">
                                    <div class="uploader_link">
                                        <label for="favicon_img">Upload New</label>
										 <input type="file"  name="favicon_img" id="favicon_img">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="hs_image_viewer">
                                <label>Logo</label>
                                <div class="iv_image">
                                    <img src="<?php echo base_url().$this->ts_functions->getsettings('logo','img');?>">	
                                </div>
                                <p class="help-block">Preferred image size 180x43px , but maximum it can be 250x50px</p>
                                <div class="iv_action">
                                    <div class="uploader_link">
                                        <label for="logo_img">Upload New</label>
                                        <input type="file" id="logo_img" name="logo_img"/>
                                    </div>  
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="hs_image_viewer last">
                                <label>Authenticate Page</label>
                                <div class="iv_image">
                                    <img src="<?php echo base_url().$this->ts_functions->getsettings('login','img');?>">	  
                                </div>
                                <p class="help-block">Preferred image size 670*730px , but maximum it can be 250x50px </p>
                                <div class="iv_action">
                                    <div class="uploader_link">
                                        <label for="login_img">Upload New</label>
                                        <input type="file" id="login_img" name="login_img" />
                                    </div>   
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button type="submit" class="btn" onclick="updateSettings('logoform')">Update</button>
                        </div>
                       </form> 
                    </div>
                </div>
                <!-- image setting tab end -->

                <!-- footer setting tab start -->
                <div id="footer_setting_tab" class="tab-pane fade">
                    <div class="row">
						<div class="col-md-8">
                            <div class="hs_input">
                                <label>Facebbok link</label>
                                <input type="text" class="form-control settingsfields" id="fblink_url" value=" <?php echo $this->ts_functions->getsettings('fblink','url');?>">
                            </div>
                        </div>
						<div class="col-md-8">
                            <div class="hs_input">
                                <label>Twitter link</label>
                                <input type="text" class="form-control settingsfields" id="twitterlink_url " value=" <?php echo $this->ts_functions->getsettings('twitterlink','url');?>">
                            </div>
                        </div>
						<div class="col-md-8">
                            <div class="hs_input">
                                <label>Google link</label>
                                <input type="text" class="form-control settingsfields" id="googlelink_url" value=" <?php echo $this->ts_functions->getsettings('googlelink','url');?>">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <a onclick="updateSettings('settingsfields')" class="btn ">UPDATE</a>
                        </div>
                    </div>
                </div>
                <!-- footer setting tab end -->
				
				<!-- language setting tab start -->
                <div id="language_setting_tab" class="tab-pane fade">
                    <div class="row">
					 <form action="<?php echo base_url();?>settings/updatelanguages" method="post" id="languageForm">
                        <div class="col-md-8">
                            <div class="hs_input">
                                <label>Site Language</label>
                                <?php $langArr = explode(',',$this->ts_functions->getsettings('languageoption','text')); ?>
								<select class="form-control" name="weblanguage_text">
									<?php 
									 for($i=0;$i<count($langArr);$i++) {
									  $selected = ( $this->ts_functions->getsettings('weblanguage','text') == $langArr[$i] ) ? 'selected' : '' ;
									  echo '<option '.$selected.' value="'.$langArr[$i].'">'.$langArr[$i].'</option>';
									}?>
								</select>
								<span class="input_help_info">To see effect of language change you have to restart app in your Androide and Ios device</span>
                            </div>
                        </div>
						<div class="col-md-8">
							<div class="hs_input">
									<label>Add new language</label>
									<input type="hidden" id="existinglanguage" value="<?php echo $this->ts_functions->getsettings('languageoption','text');?>">
									<input type="text" class="form-control" name="addnewlanguage" id="addnewlanguage">
									<span class="input_help_info">Should be in lower case , and one at a time</span><br>
									<span class="input_help_info"><a href="<?php echo base_url(); ?>settings/texts">Add language text here<a></span>
							</div>
						</div>
                        <div class="col-md-12">
                            <a onclick="updateSettings('languageSettings')" class="btn ">UPDATE</a>
                        </div>
					  </form>	
                    </div>
					
					<div class="row">
                        <div class="col-md-8">
						     <h3 class="hs_subheading" style="color:#F44336;"> Delete Language Section </h3>
                            <div class="hs_input">
                                <label>Delete Language</label>
                                <?php $langArr = explode(',',$this->ts_functions->getsettings('languageoption','text')); ?>
								<select class="form-control" id="lan_to_delete">
									<?php for($i=0;$i<count($langArr);$i++) {
									echo '<option value="'.$langArr[$i].'">'.$langArr[$i].'</option>';
									}?>
								</select>
								
                            </div>
                        </div>
                        <div class="col-md-12">
                           <a onclick="delete_selected_language()" class="btn ">DELETE</a>
                        </div>
                    </div>
                </div>
                <!-- language setting tab end -->
				
				 <!-- revenue setting tab start -->
                <div id="revenue_setting_tab" class="tab-pane fade">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="hs_input">
                               <label>Revenue Model</label>
                               <select class="form-control revenuefields" id="portal_revenuemodel">
									<option value="plan" <?php echo ($this->ts_functions->getsettings('portal','revenuemodel') == 'plan') ? 'selected' : '' ; ?>> PLAN BASE (Only subscribed doctors will be shown on website/app) </plan>
									<option value="free" <?php echo ($this->ts_functions->getsettings('portal','revenuemodel') == 'free') ? 'selected' : '' ; ?>> FREE (Any   doctor will be shown on website/app)</option>
							   </select>
                            </div>
                        </div>
						<div class="col-md-8">
                            <div class="hs_input">
                                <label>Currency</label>
                                 <input type="text" class="form-control revenuefields" id="portal_curreny" value="<?php echo $this->ts_functions->getsettings('portal','curreny');?>" maxlength=3>
								 <p class="help-block">This will be used for transactions with Paypal. Use specific currency code. <a href="https://developer.paypal.com/docs/classic/mass-pay/integration-guide/currency_codes/">Click here to get the list.</a></p>
                            </div>
                        </div>
						<div class="col-md-8">
							  <div class="hs_input">
								<label>Currency Symbol</label>
								<input type="text" class="form-control revenuefields" id="portalcurreny_symbol" value="<?php echo $this->ts_functions->getsettings('portalcurreny','symbol');?>">
								<p class="help-block">This will be displayed with  price.</p>
							</div>
					   </div>
                       <div class="col-md-12">
                           <button type="submit" class="btn" id="update_revenuemodel">Update</button>
                       </div>
                    </div>
                </div>
                <!-- revenue setting tab end -->
				
				<!-- sms setting tab start -->
			    <div id="sms_setting_tab" class="tab-pane fade">
                    <div class="row">
                        <div class="col-md-8">
                           <div class="hs_checkbox">
							<input type="checkbox" id="msg91_status" class="smsSettings settingsfields" value="1" <?php echo $this->ts_functions->getsettings('msg91','status') == '1' ? 'checked' : '' ; ?>>
                              <label for="msg91_status">Use Msg91 to send sms</label>
						   </div>
                        </div>
						 <div class="col-md-8">
                            <div class="hs_input">
                                <label>Msg91 Api Key</label>
                                <input type="text" class="form-control settingsfields" id="msg91_key"   value="<?php echo $this->ts_functions->getsettings('msg91','key');?>" >
                            </div>
                        </div>
                        <div class="col-md-12">
                            <a  class="btn" onclick="updateSettings('settingsfields')">Save Changes</a>
                        </div>
                    </div>
                </div>
			  <!-- sms setting tab end -->
			  
			  <!-- map setting tab start -->
			    <div id="map_setting_tab" class="tab-pane fade">
                    <div class="row">
                        
						 <div class="col-md-8">
                            <div class="hs_input">
                                <label>Google Map Api Key</label>
                                <input type="text" class="form-control settingsfields" id="map_api"   value="<?php echo $this->ts_functions->getsettings('map','api');?>" >
                                <p class="help-block">Here you get your <a href="https://developers.google.com/maps/documentation/javascript/get-api-key" target="_blank">google map api key</a></p>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <a  class="btn" onclick="updateSettings('settingsfields')">Save Changes</a>
                        </div>
                    </div>
                </div>
			  <!-- map setting tab end -->
			  
			  <!-- chat setting tab start -->
			    <div id="chat_setting_tab" class="tab-pane fade">
                    <div class="row">
                        <div class="col-md-8">
                           <div class="hs_checkbox">
							<input type="checkbox" id="chat_status" class="smsSettings settingsfields" value="1" <?php echo $this->ts_functions->getsettings('chat','status') == '1' ? 'checked' : '' ; ?>>
                              <label for="chat_status">Active Chat</label>
						   </div>
                        </div>
						 <div class="col-md-8">
                            <div class="hs_input">
                                <label>QuickBlox App Id</label>
                                <input type="text" class="form-control settingsfields" id="chat_appid"   value="<?php echo $this->ts_functions->getsettings('chat','appid');?>" >
                            </div>
                        </div>
						<div class="col-md-8">
                            <div class="hs_input">
                                 <label>QuickBlox Authorization  Key</label>
                                <input type="text" class="form-control settingsfields" id="chat_authkey"   value="<?php echo $this->ts_functions->getsettings('chat','authkey');?>" >
                            </div>
                        </div>
						<div class="col-md-8">
                            <div class="hs_input">
                                <label>QuickBlox Authorization  Secrete</label>
                                <input type="text" class="form-control settingsfields" id="chat_authsecret"   value="<?php echo $this->ts_functions->getsettings('chat','authsecret');?>" >
                            </div>
                        </div>
						<div class="col-md-8">
                         <div class="hs_input">
                                <label>QuickBlox Account  Key</label>
                                <input type="text" class="form-control settingsfields" id="chat_accountkey"   value="<?php echo $this->ts_functions->getsettings('chat','accountkey');?>" >
                            </div>
                        </div>
                        <div class="col-md-12">
                            <a  class="btn" onclick="updateSettings('settingsfields')">Save Changes</a>
                        </div>
                    </div>
                </div>
			  <!-- chat setting tab end -->
			  
			   <!-- Credintials setting tab start -->
                <div id="creditial_setting_tab" class="tab-pane fade">
                    <div class="row">
					<form method="post">
						<div class="col-md-8">
                            <div class="hs_input">
                                <label>Email</label>
                                 <input type="email" class="form-control" name="user_email"  value="<?php echo $_SESSION['dd_email'];?>" >
								
                            </div>
                        </div>
						<div class="col-md-8">
							  <div class="hs_input">
								<label>Password</label>
								<input type="text" class="form-control" name="user_pass"  pattern=".{8,}"   required title="8 characters minimum"  >
								
							</div>
					   </div>
                       <div class="col-md-12">
                           <button type="submit" class="btn"  name="change_pass">Update</button>
                       </div>
					  </form> 
                    </div>
                </div>
                <!-- Credintials setting tab end -->
			 	<!-- Firebase setting tab start -->
			    <div id="firebase_setting_tab" class="tab-pane fade">
                    <div class="row">
                        <div class="col-md-8">
                           <div class="hs_checkbox">
							<input type="checkbox" id="firebase_status" class="smsSettings settingsfields" value="1" <?php echo $this->ts_functions->getsettings('firebase','status') == '1' ? 'checked' : '' ; ?>>
                              <label for="firebase_status">Use Firebase to send push notification </label>
						   </div>
                        </div>
						 <div class="col-md-8">
                            <div class="hs_input">
                                <label>Firebase Server Key</label>
                                <input type="text" class="form-control settingsfields" id="firebase_key"   value="<?php echo $this->ts_functions->getsettings('firebase','key');?>" >
                            </div>
                        </div>
                        <div class="col-md-12">
                            <a  class="btn" onclick="updateSettings('settingsfields')">Save Changes</a>
                        </div>
                    </div>
                </div>
			  <!-- Firebase setting tab end -->	
			  <!-- Timezone setting tab start -->
			    <div id="timezone_setting_tab" class="tab-pane fade">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="hs_input">
                                <label>Select Timezone</label>
                                <select id="site_timezone" class="form-control settingsfields">
                                    <?php 
                                    $site_timezone=$this->ts_functions->getsettings('site','timezone');
                                    $tzlist = DateTimeZone::listIdentifiers(DateTimeZone::ALL);
                                    foreach( $tzlist as $soloZone){
                                        $selected = ( $site_timezone == $soloZone ) ? 'selected' : '' ; 
                                        echo '<option value="'.$soloZone.'"   '.$selected.'>'.$soloZone.'</option>';  
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
						
                        <div class="col-md-12">
                            <a  class="btn" onclick="updateSettings('settingsfields')">Save Changes</a>
                        </div>
                    </div>
                </div>
			  <!-- Timezone setting tab end -->
              <!-- Analytics setting tab start -->
			    <div id="analytics_setting_tab" class="tab-pane fade">
                    <div class="row">
                        <div class="col-md-8">
						
						   <div class="hs_input">
                                <label>Google Analytics Script </label>
                                <textarea rows="4" class="form-control settingsfields" id="google_anaylitics"><?php echo $this->ts_functions->getsettings('google','anaylitics');?></textarea>
                            </div>
                        </div>
						
                        <div class="col-md-12">
                            <a  class="btn" onclick="updateSettings('settingsfields')">Save Changes</a>
                        </div>
                    </div>
                </div>
			  <!-- Analytics setting tab end -->				  
			  <!-- bk setting tab start -->
                <div id="dsd" class="tab-pane fade">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="hs_input">
                                <label>Copyright text</label>
                                <input type="text" class="form-control" value="Copyright © 2018 Doctor Directory. All rights reserved">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <a href="" class="btn">Save Changes</a>
                        </div>
                    </div>
                </div>
                <!-- bk setting tab end -->	
				
            </div>
        </div>
        <!-- tab end -->
    </div>
</div>