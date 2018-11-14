<?php 
$scr_ad_id=0;
$scr_ad_code='';
$scr_ad_page=3;
$scr_ad_status=1;
if(!empty($script_add)){
 $scr_ad_id=$script_add[0]['ad_id'];
 $scr_ad_code=$script_add[0]['ad_code'];
 $scr_ad_page=$script_add[0]['ad_page'];
 $scr_ad_status=$script_add[0]['ad_status'];
}

$cust_ad_id=0;
$cust_ad_page=3;
$cust_ad_status=1;
$cust_ad_image='';
$cust_ad_link='';

if(!empty($custom_add)){
 $cust_ad_id=$custom_add[0]['ad_id'];
 $cust_ad_page=$custom_add[0]['ad_page'];
 $cust_ad_status=$custom_add[0]['ad_status'];
 $cust_ad_link=$custom_add[0]['ad_link'];
 $cust_ad_image=$custom_add[0]['ad_image']; 
}

?>



<div class="row">
    <div class="col-md-12">
        <div class="hs_heading medium">
            <h3>Ads Integration</h3>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <!-- tab start -->
		<div class="hs_tabs">
			<ul class="nav nav-pills">
                <li class="active"><a data-toggle="pill" href="#google_ad_tab"> Ads </a></li>
                <li><a data-toggle="pill" href="#custom_ad_tab">Custom Ads </a></li>
				<li><a data-toggle="pill" href="#addmob_ad_tab">Ad Mob </a></li>
            </ul>
			<div class="tab-content">
				<!-- google ads tab start -->
                <div id="google_ad_tab" class="tab-pane fade in active">
                    <div class="row">
					<form method="post">
                        <div class="col-md-8">
                            <div class="hs_input">
                                <label>Select Position on web</label>
                                <select class="form-control" name="ad_page">
									<option value="1" <?php if($scr_ad_page==1) echo 'selected'; ?>>Home page</option>
									<option value="2" <?php if($scr_ad_page==2) echo 'selected'; ?>>Single page</option>
									<option value="3" <?php if($scr_ad_page==3) echo 'selected'; ?>>Both pages</option>
								</select>
                            </div>
							<div class="hs_input">
                                <label> Ad code</label>
                                <textarea rows="5" class="form-control" name="ad_code"><?php echo $scr_ad_code; ?></textarea>
								<input type="hidden" name="ad_id" value="<?php echo $scr_ad_id;?>">
                            </div>
							<div class="hs_input">
                                <label>Status</label>
                                <select class="form-control" name="ad_status">
									<option value="1" <?php if($scr_ad_status==1) echo 'selected'; ?>>Active</option>
									<option value="0" <?php if($scr_ad_status==0) echo 'selected'; ?>>InActive</option>
								</select>
                            </div>
                        </div>
						<div class="col-md-12">
							<button type="submit" class="btn"  name="script">UPDATE</button>
                        </div>
					 </form>	
                    </div>
                </div>
                <!-- google ads tab end -->
				
				<!-- Custom Ads tab start -->
                <div id="custom_ad_tab" class="tab-pane fade">
                    <div class="row">
					  <form method="post"  id="custom_add_form" enctype="multipart/form-data">
                        <div class="col-md-8">
                            <div class="hs_input">
                               <label>Select Position on web</label>
                                <select class="form-control" name="ad_page">
									<option value="1" <?php if($cust_ad_page==1) echo 'selected'; ?>>Home page</option>
									<option value="2" <?php if($cust_ad_page==2) echo 'selected'; ?>>Single page</option>
									<option value="3" <?php if($cust_ad_page==3) echo 'selected'; ?>>Both pages</option>
								</select>
                            </div>
							<div class="hs_input">
                                <label>Link</label>
                                <input type="text" class="form-control" name="ad_link" value="<?php echo $cust_ad_link;?>" />
                            </div>
							<div class="hs_input">
                                <label>Upload ad image</label>
                                <input type="file" class="form-control" name="ad_image" id="ad_image" />
								<input type="hidden" value="<?php echo $cust_ad_image;  ?>" id="ad_image_chk">
                            </div>
							<div class="hs_input">
                                <label>Status</label>
                                <select class="form-control" name="ad_status">
									<option value="1" <?php if($cust_ad_status==1) echo 'selected'; ?>>Active</option>
									<option value="0" <?php if($cust_ad_status==0) echo 'selected'; ?>>InActive</option>
								</select>
                            </div>
                        </div>
						<div class="col-md-12">
						     <input type="hidden" name="ad_id" value="<?php echo $cust_ad_id;?>">
							 <input type="hidden" name="custom" >
                           <button type="" class="btn" onclick="updateadd()"  >UPDATE</button>
                        </div>
					 </form>	
                    </div>
                </div>
                <!-- Custom Ads tab end -->
				
				 <!-- Ad Mob tab start -->
                <div id="addmob_ad_tab" class="tab-pane fade">
                    <div class="row">
				     <div class="col-md-8">
                            <div class="hs_input">
                                <label>Ad Mob Api Id(Banner Ad)</label>
                                <input type="text" class="form-control settingsfields" id="admob_appid" value=" <?php echo $this->ts_functions->getsettings('admob','appid');?>">
                            </div>
                      </div>
                      <div class="col-md-12">
                            <a onclick="updateSettings('settingsfields')" class="btn ">UPDATE</a>
                      </div>					  
                    </div>
                </div>
                <!-- Ad Mob tab end -->
			</div>
		</div>
        <!-- tab end -->		
	</div>
</div>