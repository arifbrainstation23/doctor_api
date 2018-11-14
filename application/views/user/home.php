
<div class="dd_page_title">
    <h3><?php echo $this->ts_functions->getlanguage('find_doctor', 'homepage', 'solo' );?></h3>
    <div class="dd_search_box_wrapper">
        <div class="dd_search_box_inner "> <!-- class for open result - search_result_open -->
            <input type="text" placeholder="<?php echo $this->ts_functions->getlanguage('search_doctor_placeholder', 'homepage', 'solo' );?>" class="form-control dd_input_search">
            <a class="icon">
                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 56.966 56.966" style="enable-background:new 0 0 56.966 56.966;" xml:space="preserve"><path d="M55.146,51.887L41.588,37.786c3.486-4.144,5.396-9.358,5.396-14.786c0-12.682-10.318-23-23-23s-23,10.318-23,23s10.318,23,23,23c4.761,0,9.298-1.436,13.177-4.162l13.661,14.208c0.571,0.593,1.339,0.92,2.162,0.92c0.779,0,1.518-0.297,2.079-0.837C56.255,54.982,56.293,53.08,55.146,51.887z M23.984,6c9.374,0,17,7.626,17,17s-7.626,17-17,17s-17-7.626-17-17S14.61,6,23.984,6z"/><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>
            </a>
            <div class="dd_search_result">
                <ul>
                   
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="dd_doctor_list_wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <!-- category start -->
                <div class="dd_category_toggle">
                    <svg x="0px" y="0px" viewBox="0 0 60.123 60.123" style="enable-background:new 0 0 60.123 60.123;" xml:space="preserve" width="512px" height="512px"><g><path d="M57.124,51.893H16.92c-1.657,0-3-1.343-3-3s1.343-3,3-3h40.203c1.657,0,3,1.343,3,3S58.781,51.893,57.124,51.893z" fill="#11ccc2"/><path d="M57.124,33.062H16.92c-1.657,0-3-1.343-3-3s1.343-3,3-3h40.203c1.657,0,3,1.343,3,3 C60.124,31.719,58.781,33.062,57.124,33.062z" fill="#11ccc2"/><path d="M57.124,14.231H16.92c-1.657,0-3-1.343-3-3s1.343-3,3-3h40.203c1.657,0,3,1.343,3,3S58.781,14.231,57.124,14.231z" fill="#11ccc2"/><circle cx="4.029" cy="11.463" r="4.029" fill="#11ccc2"/><circle cx="4.029" cy="30.062" r="4.029" fill="#11ccc2"/><circle cx="4.029" cy="48.661" r="4.029" fill="#11ccc2"/></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>
                </div>
                <div class="dd_category_wrapper">
                    <h3><?php echo $this->ts_functions->getlanguage('find_category', 'homepage', 'solo' );?></h3>
                    <div class="panel-group" id="category_id">
					  <?php if(!empty($categoryList)){
						       $in='in';
						       foreach($categoryList as $soloCat){
								 $cat_id=$soloCat['cat_id'];
								 $href='category'.$cat_id;  
								// $cat_image=base_url('assets/user/images/category/specialist.svg');
                                 $cat_image=base_url().'assets/admin/images/icon/default_category_icon.svg';
								 if($soloCat['cat_image']!=''){
									 $cat_image=base_url().$soloCat['cat_image']; 
								 }								 
							   
					 echo	'<div class="panel panel-default">
									<div class="panel-heading">
										<h4 class="panel-title">
											<a data-toggle="collapse" data-parent="#category_id" href="#'.$href.'" aria-expanded="true">
												<img src="'.$cat_image.'" alt=""> '.$soloCat['cat_name'].'
											</a>
										</h4>
									</div>
									<div id="'.$href.'" class="panel-collapse collapse '.$in.'">
										<div class="panel-body">
											<ul class="list-group">';
											  $subcategory=$this->DatabaseModel->select_data('sub_id , sub_name' , 'dd_subcategories' , array('sub_status' => 1 , 'sub_parent' => $cat_id ));
											      if(!empty($subcategory)){
													  foreach($subcategory as $soloSub){
														 $sub_id=$soloSub['sub_id'];
														 $join_array = array('dd_user_meta','dd_user_meta.user_id = dd_users.user_id');
														 $cond="user_level = 3 AND user_status = 1 AND key = 'subcategory' AND value = '$sub_id'";
														 
														  if($this->ts_functions->getsettings('portal','revenuemodel') == 'plan'){
															  $user_ids=$this->ts_functions->get_plan_user();
															 $cond.="AND dd_users.user_id in($user_ids)";
														   }
														 
														 $countDoc=$this->DatabaseModel->aggregate_data('dd_users' ,'DISTINCT(dd_user_meta.user_id)', 'count' , $cond,'',$join_array);
														 
														 
														 
				       
					   echo                             '<li><a class="list-group-item list_sub_cate" data-subid="'.$sub_id.'">'.$soloSub['sub_name'].'<span class="badge">'.$countDoc.                                  '</span></a></li>';
													  }
												  }else{
						echo							  '<li class="dd_no_subcategory">'.$this->ts_functions->getlanguage('nodata_category', 'homepage', 'solo' ).'</li>';
												  }
						echo				'</ul>
										</div>
									</div>
                               </div>';
							   $in='';
								   
						   }
						  
					  }?>
                    </div>
                </div>
                <!-- category end -->
				
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
            <div class="col-md-8">
			   <form method="post" id="search_form">
			   <input type="hidden" name="formKey" id="formKey">
			   <input type="hidden" name="sub_cat" id="sub_cat">
			   <input type="hidden" name="order_by" id="order_by">
			   </form>
                <!-- filter start -->
                <div class="dd_filter_wrapper">
                    <div class="dd_filter dd_dropdown_wrapper dropdown_right">
                    <span class="icon">
                        <svg width="15px" height="15px"><path fill-rule="evenodd" fill="rgb(182, 182, 182)" d="M14.936,0.414 C14.816,0.137 14.606,-0.002 14.308,-0.002 L0.691,-0.002 C0.393,-0.002 0.184,0.137 0.064,0.414 C-0.057,0.705 -0.007,0.954 0.213,1.160 L5.457,6.413 L5.457,11.592 C5.457,11.777 5.525,11.936 5.659,12.071 L8.383,14.799 C8.511,14.934 8.670,15.002 8.862,15.002 C8.947,15.002 9.035,14.984 9.127,14.948 C9.404,14.828 9.543,14.618 9.543,14.320 L9.543,6.413 L14.787,1.160 C15.007,0.954 15.057,0.705 14.936,0.414 Z"/></svg>
                    </span> <?php echo $this->ts_functions->getlanguage('filter_by', 'homepage', 'solo' );?>
                        <div class="dd_dropdown">
                            <div class="dd_dropdown_inner">
                                <ul>
                                    <li><a data-order="user_name,asc"><?php echo $this->ts_functions->getlanguage('ascendatnt_by', 'homepage', 'solo' );?></a></li>
                                    <li><a data-order="user_name,desc"><?php echo $this->ts_functions->getlanguage('descendatnt_by', 'homepage', 'solo' );?></a></li>
                                    <li><a data-order="user_fees,asc"><?php echo $this->ts_functions->getlanguage('minprice_by', 'homepage', 'solo' );?></a></li>
									<li><a data-order="user_fees,desc"><?php echo $this->ts_functions->getlanguage('maxprice_by', 'homepage', 'solo' );?></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- filter end -->
                <div class="dd_access_doctor_data">
                
               
			    </div>	<!-- dd accesss data end -->
				 <!-- pagination start -->
                <div class="dd_pagination dd_home_pagination">
                </div>
                <!-- pagination end -->

            </div>
        </div>
    </div>
</div>