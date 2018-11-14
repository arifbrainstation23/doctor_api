<?php 
    $currency = $this->ts_functions->getsettings('portalcurreny' , 'symbol');
    $map_api = $this->ts_functions->getsettings('map' , 'api');
		$user_id     = $doctorDetail['user_id'];
		$user_name   = $doctorDetail['user_name'];
		$user_email  = $doctorDetail['user_email'];
		$user_mobile =$doctorDetail['user_mobile'];
		$user_category =$this->ts_functions->get_user_meta($user_id , 'category' );
		$user_subcategory =$this->ts_functions->get_user_meta($user_id , 'subcategory' );
		$subcat=$this->DatabaseModel->select_data('sub_name' , 'dd_subcategories' , array('sub_id' =>  $user_subcategory) ,1);
        if(!empty($subcat)){
			$subcat=$subcat[0]['sub_name'];
		}else{
			$subcat='Uncategorized';
		}		
		$user_exp =$this->ts_functions->get_user_meta($user_id , 'exp' ); 
		$user_qual =$this->ts_functions->get_user_meta($user_id , 'qual' ); 
		$user_fees =$doctorDetail['user_fees'];
		$user_address =$this->ts_functions->get_user_meta($user_id , 'address' ); 
		$user_lat =$this->ts_functions->get_user_meta($user_id , 'lat' ); 
		$user_long =$this->ts_functions->get_user_meta($user_id , 'long' ); 
		$user_spec =$this->ts_functions->get_user_meta($user_id , 'spec' );
		$user_desc =$this->ts_functions->get_user_meta($user_id , 'desc' );

		$user_image=base_url().'assets/user/images/doctor/default_doctor.jpg';
		if( $doctorDetail['user_pic'] !=''){
			$user_image=base_url().$doctorDetail['user_pic'];
		}
	 
	$avgRatings=$this->DatabaseModel->aggregate_data('dd_rating' ,'rat_rating', 'AVG' , array('rat_doctor_id' => $user_id));
	
	if(empty($avgRatings)){
		$avgRatings=0;
	}
	
	$totalRatings=$this->DatabaseModel->aggregate_data('dd_rating' ,'rat_rating', 'COUNT' , array('rat_doctor_id' => $user_id));
	$totalOne=$this->DatabaseModel->aggregate_data('dd_rating' ,'rat_rating', 'COUNT' , array('rat_doctor_id' => $user_id , 'rat_rating' =>1));
	$totalTwo=$this->DatabaseModel->aggregate_data('dd_rating' ,'rat_rating', 'COUNT' , array('rat_doctor_id' => $user_id , 'rat_rating' =>2));
	$totalThree=$this->DatabaseModel->aggregate_data('dd_rating' ,'rat_rating', 'COUNT' , array('rat_doctor_id' => $user_id , 'rat_rating' =>3));
	$totalFour=$this->DatabaseModel->aggregate_data('dd_rating' ,'rat_rating', 'COUNT' , array('rat_doctor_id' => $user_id , 'rat_rating' =>4));
	$totalFive=$this->DatabaseModel->aggregate_data('dd_rating' ,'rat_rating', 'COUNT' , array('rat_doctor_id' => $user_id , 'rat_rating' =>5));
	$widthOne=$widthTwo=$widthThree=$widthFour=$widthFive=0;
	if($totalRatings!=0){
		$widthOne=($totalOne*100)/$totalRatings;
		$widthTwo=($totalTwo*100)/$totalRatings;
		$widthThree=($totalThree*100)/$totalRatings;
		$widthFour=($totalFour*100)/$totalRatings;
		$widthFive=($totalFive*100)/$totalRatings;
	}
	
	
	$fav_active='';
	 $fav_fun='add_favourite('.$user_id.' , this)';
	 $fav_title=$this->ts_functions->getlanguage('addtofav', 'commontext', 'solo' );
	 $chk_fav=$this->DatabaseModel->select_data('fav_id' , 'dd_favourite' , array('fav_doctor_id'=> $user_id , 'fav_user_id' =>$this->user_id) , 1);
	 if($chk_fav){
		$fav_active='active';
		$fav_fun='remove_favourite('.$user_id.' , this)';
		 $fav_title=$this->ts_functions->getlanguage('removefav', 'commontext', 'solo' );
	 }
	
	
	
?>
<div class="dd_single_detail">
	<div class="container">
		<div class="single_image">
			<img src="<?=$user_image; ?>" alt="<?php echo $user_name; ?>">
		</div>
		<div class="single_detail">
			<h3><?php echo $user_name; ?></h3>
			<span><?php echo $subcat; ?> </span>
			<ul>
				<li><span><img src="<?= base_url('assets/user/images/address_single.svg') ?>" alt=""></span> <?php echo $user_address; ?></li>
				
			</ul>
			<div class="clearfix"></div>
			<h4><?php echo $this->ts_functions->getlanguage('fees', 'doctordetail', 'solo' ); ?> - <?php echo $currency.$user_fees; ?></h4>
			<div class="btn_wrapper">
				<a  class="dd_btn dd_btn_small dd_btn_white dd_btn_icon <?php echo $fav_active; ?>"  onclick="<?php echo $fav_fun;?>"><?php echo $fav_title; ?>
					<span class="icon">
						<svg width="23px" height="22px"><path fill-rule="evenodd" stroke-width="1px" stroke="rgb(14, 213, 227)" fill="rgb(0, 0, 0)" d="M19.476,7.971 C19.242,5.379 17.422,3.498 15.144,3.498 C13.627,3.498 12.237,4.321 11.455,5.641 C10.680,4.304 9.348,3.497 7.855,3.497 C5.577,3.497 3.757,5.378 3.523,7.971 C3.505,8.086 3.429,8.688 3.659,9.671 C3.991,11.089 4.758,12.379 5.875,13.400 L11.452,18.502 L17.124,13.400 C18.241,12.379 19.008,11.089 19.340,9.671 C19.570,8.689 19.494,8.086 19.476,7.971 ZM18.740,9.529 C18.437,10.824 17.735,12.004 16.712,12.938 L11.455,17.667 L6.289,12.940 C5.264,12.003 4.562,10.824 4.259,9.529 C4.041,8.599 4.130,8.073 4.131,8.070 L4.135,8.038 C4.335,5.767 5.899,4.118 7.855,4.118 C9.297,4.118 10.568,5.012 11.170,6.450 L11.454,7.128 L11.737,6.450 C12.330,5.034 13.668,4.118 15.144,4.118 C17.099,4.118 18.664,5.767 18.868,8.068 C18.869,8.073 18.958,8.599 18.740,9.529 Z"></path></svg>
					</span>
				</a>
			</div>
		</div>
	</div>
</div>

<div class="dd_basic_wrapper">
	<div class="container">
		<div class="row">
			<div class="col-md-7">
				<div class="dd_basic_detail">
					<h3><?php echo $this->ts_functions->getlanguage('doc_basic_info', 'doctordetail', 'solo' ); ?></h3>
					<p><label><?php echo $this->ts_functions->getlanguage('special_in', 'doctordetail', 'solo' ); ?> :</label> <span><?php echo $user_spec; ?></span></p> 
					
					<p><label><?php echo $this->ts_functions->getlanguage('exp', 'doctordetail', 'solo' ); ?> :</label> <span><?php echo $user_exp; ?> <?php echo $this->ts_functions->getlanguage('years', 'doctordetail', 'solo' ); ?></span></p>
					
					<p><label><?php echo $this->ts_functions->getlanguage('qualification', 'doctordetail', 'solo' ); ?> :</label> <span><?php echo $user_qual; ?></span></p>
					
					<p><label><?php echo $this->ts_functions->getlanguage('contact_number', 'doctordetail', 'solo' ); ?> :</label> <span><?php echo $user_mobile; ?></span></p>

					<p><label><?php echo $this->ts_functions->getlanguage('email_address', 'doctordetail', 'solo' ); ?> :</label> <span><?php echo $user_email; ?></span></p>
					<?php 
					if(!empty($fields)){
		              foreach($fields as $solofield){
						  $key=$solofield['name'];
			              $label=$solofield['label'];
						  $meta_value =$this->ts_functions->get_user_meta($user_id , $key );
                          echo '<p><label>'.$label.' :</label> <span>'.$meta_value.'</span></p>'; 						  
					  }
					}?>
					<div class="clearfix"></div><br><br>
					<h3><?php echo $this->ts_functions->getlanguage('doc_description', 'doctordetail', 'solo' ); ?></h3>
					<p><?php echo $user_desc; ?></p>
				</div>
				
				<div class="dd_reviews">
					<div class="total_review">
						<label><?php echo $this->ts_functions->getlanguage('reviews', 'doctordetail', 'solo' ); ?></label>
						<h3><?php echo round($avgRatings,2); ?></h3>
						<div class="star_list">
							<a class="<?php if($avgRatings>0) echo 'active'; ?>"><svg width="21px" height="20px"><path fill-rule="evenodd" fill="rgb(232, 232, 232)" d="M10.996,0.329 L13.668,6.643 L20.506,7.230 C20.981,7.271 21.174,7.862 20.814,8.173 L15.626,12.661 L17.181,19.338 C17.289,19.802 16.785,20.167 16.378,19.920 L10.500,16.381 L4.623,19.920 C4.215,20.166 3.712,19.801 3.820,19.338 L5.375,12.661 L0.186,8.172 C-0.174,7.860 0.018,7.270 0.493,7.229 L7.332,6.642 L10.004,0.329 C10.189,-0.110 10.811,-0.110 10.996,0.329 Z"/></svg></a>
							<a class="<?php if($avgRatings>1) echo 'active'; ?>"><svg width="21px" height="20px"><path fill-rule="evenodd" fill="rgb(232, 232, 232)" d="M10.996,0.329 L13.668,6.643 L20.506,7.230 C20.981,7.271 21.174,7.862 20.814,8.173 L15.626,12.661 L17.181,19.338 C17.289,19.802 16.785,20.167 16.378,19.920 L10.500,16.381 L4.623,19.920 C4.215,20.166 3.712,19.801 3.820,19.338 L5.375,12.661 L0.186,8.172 C-0.174,7.860 0.018,7.270 0.493,7.229 L7.332,6.642 L10.004,0.329 C10.189,-0.110 10.811,-0.110 10.996,0.329 Z"/></svg></a>
							<a class="<?php if($avgRatings>2) echo 'active'; ?>"><svg width="21px" height="20px"><path fill-rule="evenodd" fill="rgb(232, 232, 232)" d="M10.996,0.329 L13.668,6.643 L20.506,7.230 C20.981,7.271 21.174,7.862 20.814,8.173 L15.626,12.661 L17.181,19.338 C17.289,19.802 16.785,20.167 16.378,19.920 L10.500,16.381 L4.623,19.920 C4.215,20.166 3.712,19.801 3.820,19.338 L5.375,12.661 L0.186,8.172 C-0.174,7.860 0.018,7.270 0.493,7.229 L7.332,6.642 L10.004,0.329 C10.189,-0.110 10.811,-0.110 10.996,0.329 Z"/></svg></a>
							<a class="<?php if($avgRatings>3) echo 'active'; ?>"><svg width="21px" height="20px"><path fill-rule="evenodd" fill="rgb(232, 232, 232)" d="M10.996,0.329 L13.668,6.643 L20.506,7.230 C20.981,7.271 21.174,7.862 20.814,8.173 L15.626,12.661 L17.181,19.338 C17.289,19.802 16.785,20.167 16.378,19.920 L10.500,16.381 L4.623,19.920 C4.215,20.166 3.712,19.801 3.820,19.338 L5.375,12.661 L0.186,8.172 C-0.174,7.860 0.018,7.270 0.493,7.229 L7.332,6.642 L10.004,0.329 C10.189,-0.110 10.811,-0.110 10.996,0.329 Z"/></svg></a>
							<a class="<?php if($avgRatings>4) echo 'active'; ?>"><svg width="21px" height="20px"><path fill-rule="evenodd" fill="rgb(232, 232, 232)" d="M10.996,0.329 L13.668,6.643 L20.506,7.230 C20.981,7.271 21.174,7.862 20.814,8.173 L15.626,12.661 L17.181,19.338 C17.289,19.802 16.785,20.167 16.378,19.920 L10.500,16.381 L4.623,19.920 C4.215,20.166 3.712,19.801 3.820,19.338 L5.375,12.661 L0.186,8.172 C-0.174,7.860 0.018,7.270 0.493,7.229 L7.332,6.642 L10.004,0.329 C10.189,-0.110 10.811,-0.110 10.996,0.329 Z"/></svg></a>
						</div>
						<span class="total_count"><svg width="15px" height="20px"><path fill-rule="evenodd" fill="rgb(72, 72, 72)" d="M14.999,17.377 C14.999,17.064 15.001,17.332 14.999,17.377 ZM7.500,20.000 C1.105,20.000 0.001,17.743 0.001,17.743 C0.001,17.481 0.001,17.330 0.000,17.249 C0.002,17.292 0.005,17.272 0.012,16.898 C0.096,12.317 0.739,10.996 5.325,10.156 C5.325,10.156 5.978,11.000 7.500,11.000 C9.021,11.000 9.674,10.156 9.674,10.156 C14.311,11.005 14.917,12.346 14.990,17.051 C14.995,17.352 14.997,17.404 14.999,17.377 C14.999,17.457 14.998,17.574 14.998,17.743 C14.998,17.743 13.894,20.000 7.500,20.000 ZM0.000,17.249 C-0.001,17.202 -0.000,17.084 0.000,17.249 ZM7.500,9.781 C5.307,9.781 3.529,7.592 3.529,4.890 C3.529,2.190 4.113,-0.000 7.500,-0.000 C10.886,-0.000 11.470,2.190 11.470,4.890 C11.470,7.592 9.692,9.781 7.500,9.781 Z"/></svg> <?php echo $totalRatings; ?></span>
					</div>
					<div class="review_bar">
						<ul>
							<li>
								<div class="icon">
									<svg width="21px" height="20px"><path fill-rule="evenodd" fill="rgb(201, 190, 39)" d="M10.996,0.329 L13.668,6.643 L20.506,7.230 C20.981,7.270 21.174,7.862 20.814,8.173 L15.626,12.661 L17.181,19.338 C17.289,19.802 16.785,20.167 16.378,19.920 L10.500,16.381 L4.623,19.920 C4.215,20.166 3.712,19.801 3.820,19.338 L5.375,12.661 L0.186,8.172 C-0.174,7.860 0.018,7.269 0.493,7.228 L7.332,6.642 L10.003,0.329 C10.189,-0.110 10.811,-0.110 10.996,0.329 Z"/></svg>
								</div>
								<div class="star_count">5</div>
								<div class="progress_count">
									<span style="width: <?php echo $widthFive; ?>%;"></span> <?php echo $totalFive; ?>
								</div>
							</li>
							<li>
								<div class="icon">
									<svg width="21px" height="20px"><path fill-rule="evenodd" fill="rgb(201, 190, 39)" d="M10.996,0.329 L13.668,6.643 L20.506,7.230 C20.981,7.270 21.174,7.862 20.814,8.173 L15.626,12.661 L17.181,19.338 C17.289,19.802 16.785,20.167 16.378,19.920 L10.500,16.381 L4.623,19.920 C4.215,20.166 3.712,19.801 3.820,19.338 L5.375,12.661 L0.186,8.172 C-0.174,7.860 0.018,7.269 0.493,7.228 L7.332,6.642 L10.003,0.329 C10.189,-0.110 10.811,-0.110 10.996,0.329 Z"/></svg>
								</div>
								<div class="star_count">4</div>
								<div class="progress_count">
									<span style="width: <?php echo $widthFour; ?>%;"></span> <?php echo $totalFour; ?>
								</div>
							</li>
							<li>
								<div class="icon">
									<svg width="21px" height="20px"><path fill-rule="evenodd" fill="rgb(201, 190, 39)" d="M10.996,0.329 L13.668,6.643 L20.506,7.230 C20.981,7.270 21.174,7.862 20.814,8.173 L15.626,12.661 L17.181,19.338 C17.289,19.802 16.785,20.167 16.378,19.920 L10.500,16.381 L4.623,19.920 C4.215,20.166 3.712,19.801 3.820,19.338 L5.375,12.661 L0.186,8.172 C-0.174,7.860 0.018,7.269 0.493,7.228 L7.332,6.642 L10.003,0.329 C10.189,-0.110 10.811,-0.110 10.996,0.329 Z"/></svg>
								</div>
								<div class="star_count">3</div>
								<div class="progress_count">
									<span style="width: <?php echo $widthThree; ?>%;"></span> <?php echo $totalThree; ?>
								</div>
							</li>
							<li>
								<div class="icon">
									<svg width="21px" height="20px"><path fill-rule="evenodd" fill="rgb(201, 190, 39)" d="M10.996,0.329 L13.668,6.643 L20.506,7.230 C20.981,7.270 21.174,7.862 20.814,8.173 L15.626,12.661 L17.181,19.338 C17.289,19.802 16.785,20.167 16.378,19.920 L10.500,16.381 L4.623,19.920 C4.215,20.166 3.712,19.801 3.820,19.338 L5.375,12.661 L0.186,8.172 C-0.174,7.860 0.018,7.269 0.493,7.228 L7.332,6.642 L10.003,0.329 C10.189,-0.110 10.811,-0.110 10.996,0.329 Z"/></svg>
								</div>
								<div class="star_count">2</div>
								<div class="progress_count">
									<span style="width: <?php echo $widthTwo; ?>%;"></span> <?php echo $totalTwo; ?>
								</div>
							</li>
							<li>
								<div class="icon">
									<svg width="21px" height="20px"><path fill-rule="evenodd" fill="rgb(201, 190, 39)" d="M10.996,0.329 L13.668,6.643 L20.506,7.230 C20.981,7.270 21.174,7.862 20.814,8.173 L15.626,12.661 L17.181,19.338 C17.289,19.802 16.785,20.167 16.378,19.920 L10.500,16.381 L4.623,19.920 C4.215,20.166 3.712,19.801 3.820,19.338 L5.375,12.661 L0.186,8.172 C-0.174,7.860 0.018,7.269 0.493,7.228 L7.332,6.642 L10.003,0.329 C10.189,-0.110 10.811,-0.110 10.996,0.329 Z"/></svg>
								</div>
								<div class="star_count">1</div>
								<div class="progress_count">
									<span style="width: <?php echo $widthOne; ?>%;"></span> <?php echo $totalOne; ?>
								</div>
							</li>

						</ul>
					</div>

				</div>
				
				<div class="text-center">
				 <?php if($this->ts_functions->dd_uid==""){
					 echo '<a href="'.base_url().'authentication" class="dd_btn ">'.$this->ts_functions->getlanguage('write_review', 'doctordetail', 'solo' ).'</a>';
				 }else{
					 echo  '<a href="#dd_write_review" class="dd_btn dd_popup_link">'.$this->ts_functions->getlanguage('write_review', 'doctordetail', 'solo' ).'</a>';
				 } ?>
					
				</div>

			</div>
			<div class="col-md-5">
			    <div class="map_wrapper">
				<?php if(empty($map_api)){?>
					<iframe src='https://maps.google.com/maps?&amp;q="+<?php echo urlencode($user_address); ?>+"&amp;output=embed' width="100%" height="528" frameborder="0" style="border:0" allowfullscreen></iframe>
				<?php } else { ?>
				<input id="no_dragend" type="hidden">
				<input id="latitute" type="hidden"      name="user_lat" value="<?php echo $user_lat; ?>">
			    <input id="longtitute" type="hidden"     name="user_long" value="<?php echo $user_long; ?>">
				<div id="map_canvas" style="width: 100%; height: 300px;"></div>
				<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?v=3.exp&key= <?php echo $map_api;?>&callback"></script>
				<?php }?>
				</div>
				
				<!-- ad wrapper start -->
				<div class="dd_ad_wrapper">
				  <?php if(!empty($customAd)){
					  $ad_link=$customAd[0]['ad_link'];
					  $ad_image=base_url().$customAd[0]['ad_image'];
				      echo  '<a target="_blank" href="'.$ad_link.'"><img src="'.$ad_image.'" alt=""></a>';
				   } ?>
				</div>
				<div class="dd_ad_wrapper">
				<?php if(!empty($scriptAd)){
					  echo $scriptAd[0]['ad_code'];
					  
				   } ?>
				</div>
				<!-- ad wrapper end -->
				
				
			</div>
		</div>
	</div>
</div>


<!-- write review popup start -->
<div id="dd_write_review" class="dd_popup_wrapper">
    <div class="dd_popup_close"></div>
    <div class="dd_popup_inner">
        <div class="dd_popup_header">
            <h3><?php echo $this->ts_functions->getlanguage('write_review', 'doctordetail', 'solo' ); ?></h3>
            <span class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="66px" height="67px"><path fill-rule="evenodd" fill="#1bcbd5" d="M32.815,66.188 C14.747,66.188 0.046,51.490 0.046,33.423 C0.046,15.356 14.747,0.659 32.815,0.659 C50.885,0.659 65.585,15.357 65.585,33.424 C65.585,51.492 50.885,66.188 32.815,66.188 ZM32.815,3.182 C16.137,3.182 2.569,16.748 2.569,33.424 C2.569,50.099 16.137,63.666 32.815,63.666 C49.492,63.666 63.061,50.099 63.061,33.424 C63.061,16.748 49.494,3.182 32.815,3.182 ZM40.424,19.763 C38.332,19.763 36.637,21.457 36.637,23.550 C36.637,25.640 38.333,27.337 40.424,27.337 C42.516,27.337 44.212,25.640 44.212,23.550 C44.212,21.457 42.516,19.763 40.424,19.763 ZM24.652,19.763 C22.560,19.763 20.865,21.457 20.865,23.550 C20.865,25.640 22.561,27.337 24.652,27.337 C26.744,27.337 28.440,25.640 28.440,23.550 C28.440,21.457 26.746,19.763 24.652,19.763 ZM49.091,42.548 C49.867,41.848 49.926,40.651 49.226,39.875 C48.523,39.102 47.328,39.042 46.552,39.740 C42.796,43.135 37.937,45.003 32.872,45.003 C27.789,45.003 22.918,43.126 19.158,39.713 C18.387,39.011 17.187,39.067 16.485,39.842 C15.781,40.616 15.841,41.814 16.615,42.515 C21.073,46.561 26.847,48.789 32.873,48.789 C38.876,48.787 44.638,46.573 49.091,42.548 Z"/></svg>
            </span>
        </div>
        <div class="dd_popup_body">
            <div class="dd_input_wrapper">
				<select class="form-control r_required" id="rat_rating">
					<option value=""><?php echo $this->ts_functions->getlanguage('select_review_start', 'doctordetail', 'solo' ); ?></option>
					<option value="1">★</option>
					<option value="2">★★</option>
					<option value="3">★★★</option>
					<option value="4">★★★★</option>
					<option value="5">★★★★★</option>
				</select>
			</div>
			<div class="dd_input_wrapper dd_input_icon">
				<textarea rows="4" class="form-control r_required" placeholder="<?php echo $this->ts_functions->getlanguage('review_comment', 'doctordetail', 'solo' ); ?>" id="rat_comment"></textarea>
				<span class="icon">
					<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 483.3 483.3" style="enable-background:new 0 0 483.3 483.3;" xml:space="preserve" width="512px" height="512px"><g><g><path d="M424.3,57.75H59.1c-32.6,0-59.1,26.5-59.1,59.1v249.6c0,32.6,26.5,59.1,59.1,59.1h365.1c32.6,0,59.1-26.5,59.1-59.1 v-249.5C483.4,84.35,456.9,57.75,424.3,57.75z M456.4,366.45c0,17.7-14.4,32.1-32.1,32.1H59.1c-17.7,0-32.1-14.4-32.1-32.1v-249.5 c0-17.7,14.4-32.1,32.1-32.1h365.1c17.7,0,32.1,14.4,32.1,32.1v249.5H456.4z" fill="#909090"></path><path d="M304.8,238.55l118.2-106c5.5-5,6-13.5,1-19.1c-5-5.5-13.5-6-19.1-1l-163,146.3l-31.8-28.4c-0.1-0.1-0.2-0.2-0.2-0.3 c-0.7-0.7-1.4-1.3-2.2-1.9L78.3,112.35c-5.6-5-14.1-4.5-19.1,1.1c-5,5.6-4.5,14.1,1.1,19.1l119.6,106.9L60.8,350.95 c-5.4,5.1-5.7,13.6-0.6,19.1c2.7,2.8,6.3,4.3,9.9,4.3c3.3,0,6.6-1.2,9.2-3.6l120.9-113.1l32.8,29.3c2.6,2.3,5.8,3.4,9,3.4 c3.2,0,6.5-1.2,9-3.5l33.7-30.2l120.2,114.2c2.6,2.5,6,3.7,9.3,3.7c3.6,0,7.1-1.4,9.8-4.2c5.1-5.4,4.9-14-0.5-19.1L304.8,238.55z" fill="#909090"></path></g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>
				</span>
			</div>
            <div class="dd_input_wrapper">
			    <input type="hidden" id="rat_doctor_id" value="<?php echo  $user_id;?>">
                <a  class="dd_btn dd_btn_block" onclick="add_review()"><?php echo $this->ts_functions->getlanguage('submittext', 'authentication', 'solo' ); ?></a>
            </div>
        </div>
    </div>
</div>
<!-- write review popup end -->