<div class="dd_page_title">
    <h3><?php echo $this->ts_functions->getlanguage('favourite', 'menus', 'solo' ); ?></h3>
</div>

<div class="dd_doctor_list_wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
			   <form method="post" id="fav_form" method="post">
			   <input type="hidden" name="formKey" id="formKey">
			   </form>
				<?php if(empty($doctorDetail)){ ?>
				<!-- no doctor found start -->
                <div class="dd_no_doctor">
                    <div class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 60 60" style="enable-background:new 0 0 60 60;" xml:space="preserve" width="512px" height="512px"><g><path d="M50.976,21.694c-0.528-9-7.947-16.194-16.891-16.194c-5.43,0-10.688,2.663-13.946,7.008 c-0.075-0.039-0.155-0.066-0.231-0.103c-0.196-0.095-0.394-0.185-0.597-0.266c-0.118-0.047-0.238-0.089-0.358-0.131 c-0.197-0.069-0.397-0.13-0.6-0.185c-0.12-0.032-0.239-0.065-0.36-0.093c-0.22-0.05-0.444-0.088-0.67-0.121 c-0.105-0.016-0.209-0.036-0.315-0.048C16.676,11.523,16.341,11.5,16,11.5c-4.962,0-9,4.037-9,9c0,0.129,0.008,0.255,0.016,0.381 C2.857,23.148,0,27.899,0,32.654C0,39.737,5.762,45.5,12.845,45.5h6.262l-5.264,9h32.313l-5.264-9h7.079 C54.604,45.5,60,40.104,60,33.472C60,27.983,56.173,23.06,50.976,21.694z M42.67,52.5H17.33l4.094-7h0.001L30,30.837L38.576,45.5 h0.001L42.67,52.5z M47.972,43.5h-8.249L30,26.876L20.277,43.5h-7.432C6.865,43.5,2,38.635,2,32.654 c0-4.154,2.705-8.466,6.432-10.253L9,22.13V21.5c0-0.123,0.008-0.249,0.015-0.375l0.009-0.173L9.012,20.75 C9.006,20.667,9,20.584,9,20.5c0-3.859,3.14-7,7-7c0.309,0,0.614,0.027,0.917,0.067c0.078,0.01,0.156,0.023,0.234,0.036 c0.267,0.044,0.53,0.102,0.789,0.176c0.035,0.01,0.071,0.017,0.106,0.027c0.285,0.087,0.563,0.198,0.835,0.321 c0.07,0.032,0.139,0.066,0.208,0.1c0.241,0.119,0.477,0.25,0.705,0.398C21.72,15.874,23,18.039,23,20.5c0,0.553,0.448,1,1,1 s1-0.447,1-1c0-2.754-1.246-5.219-3.2-6.871C24.666,9.879,29.388,7.5,34.084,7.5c7.745,0,14.178,6.135,14.849,13.888 c-1.022-0.072-2.553-0.109-4.084,0.124c-0.546,0.083-0.921,0.593-0.838,1.139c0.075,0.495,0.501,0.85,0.987,0.85 c0.05,0,0.101-0.004,0.152-0.012c2.228-0.336,4.548-0.021,4.684-0.002C54.491,24.372,58,28.661,58,33.472 C58,39.001,53.501,43.5,47.972,43.5z" fill="#d1d1d1"/><path d="M30,35.5c-0.552,0-1,0.447-1,1v8c0,0.553,0.448,1,1,1s1-0.447,1-1v-8C31,35.947,30.552,35.5,30,35.5z" fill="#d1d1d1"/><path d="M30,47.5c-0.552,0-1,0.447-1,1v1c0,0.553,0.448,1,1,1s1-0.447,1-1v-1C31,47.947,30.552,47.5,30,47.5z" fill="#d1d1d1"/></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>
                    </div>
                    <p><?php echo $this->ts_functions->getlanguage('empty_favroite', 'profile', 'solo' ); ?></p>
                </div>
				<!-- no doctor found end -->
				<?php } else{
				$currency = $this->ts_functions->getsettings('portalcurreny' , 'symbol');
				foreach($doctorDetail as $cData){
					 $user_id= $cData['user_id'];
					 $user_name=$cData['user_name'];
					 $user_email=$cData['user_email'];
					 $user_image=base_url().'assets/user/images/doctor/default_doctor.jpg';
					 if( $cData['user_pic'] !=''){
						$user_image=base_url().$cData['user_pic'];
					}
					 
					 $doccurlname=$this->ts_functions->getDocUrlName($user_name);
					 // $user_image='';
					 $user_subcategory =$this->ts_functions->get_user_meta($user_id , 'subcategory' );
					 $subcat=$this->DatabaseModel->select_data('sub_name' , 'dd_subcategories' , array('sub_id' =>  $user_subcategory) ,1);
					 if($subcat){
						$subcat=$subcat[0]['sub_name'];
					 }else{
						 $subcat="Uncategorized";
					 }
					 $user_address =$this->ts_functions->get_user_meta($user_id , 'address' ); 
					
					
					 $rating=$this->DatabaseModel->aggregate_data('dd_rating' ,'rat_rating', 'AVG' , array('rat_doctor_id' => $user_id));
					 $rating=round($rating,2);

					 $doc_url= base_url().'doctor-details/'.$doccurlname.'?practice_id='.base64_encode($user_id);	
					 $book_url= base_url().'book-appointment/'.$doccurlname.'?practice_id='.base64_encode($user_id);
					 
					 $book_status=true;
					 if($this->user_level==3){$book_status=false;}
					 if($this->ts_functions->get_user_meta($user_id , 'booking_status' )=='no' ){ $book_status=false;}
					 $chat_status=false;
				 $this->ts_functions->getsettings('chat','status');
				 if($this->user_id!='' && $this->ts_functions->getsettings('chat','status')==1){
				  $appid=$this->ts_functions->getsettings('chat','appid');
				  $authkey=$this->ts_functions->getsettings('chat','authkey');
				  $authsecret=$this->ts_functions->getsettings('chat','authsecret');
				   if($appid!='' && $authkey!='' &&  $authsecret!='' ){
					$chat_status=true;
					$chat_function="chat('".$user_email."')";
				   }
				 } 
					 
				?>
                <!-- doctor listing start -->
                <?php
                
               echo '<div class="dd_doctor_box">
                    <div class="doc_image" style="background-image:url('.$user_image.');">
                        <img src="'.$user_image.'" alt="">
                    </div>
                    <div class="doc_detail">
                        <h3>'.$user_name.'</h3>
                        <div class="dd_review_rating">
                            <label></label>
                            <ul>';
							for($r=1 ; $r<=5 ;$r++){
								if($r<=$rating){
									$ratingactive='active';
								}else{
									$ratingactive='';
								}
                 echo             	'<li><span class="star '.$ratingactive.'"></span></li>';	
							}
                echo         '</ul>
                        </div>
                        <span>'.$subcat.'</span>
                        <ul>
                            <li><span><img src="'. base_url().'assets/user/images/address.svg" alt=""></span> '.$user_address.'</li>
                        </ul>
                         <h4>Fees - '.$currency.$cData['user_fees'].'</h4>
                        <div class="btn_wrapper">
                            <a href="'.$doc_url.'" class="dd_btn dd_btn_small" title="'.$this->ts_functions->getlanguage('views', 'commontext', 'solo' ).'" target="_blank">'.$this->ts_functions->getlanguage('views', 'commontext', 'solo' ).'</a>';
                           if($book_status){
                 echo          '<a href="'.$book_url.'" class="dd_btn dd_btn_small" title="'.$this->ts_functions->getlanguage('book_appo', 'commontext', 'solo' ).'">'.$this->ts_functions->getlanguage('book', 'commontext', 'solo' ).'</a>';
							}
							
							if($chat_status){
                echo     '<a  class="dd_btn dd_btn_small" title="'.$this->ts_functions->getlanguage('chats', 'commontext', 'solo' ).'" onclick="'.$chat_function.'">'.$this->ts_functions->getlanguage('chats', 'commontext', 'solo' ).'</a>';
							}
                 echo       '<a class="dd_btn dd_btn_small dd_btn_white btn_favourite dd_btn_icon active" title="'.$this->ts_functions->getlanguage('removefav', 'commontext', 'solo' ).'" onclick="remove_favourite('.$user_id.' , this)" > 
                                <span class="icon">
                                    <svg width="23px" height="22px"><path fill-rule="evenodd" stroke-width="1px" stroke="rgb(14, 213, 227)" fill="rgb(0, 0, 0)" d="M19.476,7.971 C19.242,5.379 17.422,3.498 15.144,3.498 C13.627,3.498 12.237,4.321 11.455,5.641 C10.680,4.304 9.348,3.497 7.855,3.497 C5.577,3.497 3.757,5.378 3.523,7.971 C3.505,8.086 3.429,8.688 3.659,9.671 C3.991,11.089 4.758,12.379 5.875,13.400 L11.452,18.502 L17.124,13.400 C18.241,12.379 19.008,11.089 19.340,9.671 C19.570,8.689 19.494,8.086 19.476,7.971 ZM18.740,9.529 C18.437,10.824 17.735,12.004 16.712,12.938 L11.455,17.667 L6.289,12.940 C5.264,12.003 4.562,10.824 4.259,9.529 C4.041,8.599 4.130,8.073 4.131,8.070 L4.135,8.038 C4.335,5.767 5.899,4.118 7.855,4.118 C9.297,4.118 10.568,5.012 11.170,6.450 L11.454,7.128 L11.737,6.450 C12.330,5.034 13.668,4.118 15.144,4.118 C17.099,4.118 18.664,5.767 18.868,8.068 C18.869,8.073 18.958,8.599 18.740,9.529 Z"/></svg>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>';
				 } ?>
              

               
                <!-- doctor listing end -->
				<?php } ?>	
                
                <!-- pagination start -->
				<?php if(!empty($paginnation)){ 
				echo '<div class="dd_pagination dd_fav_pagination">'.$paginnation.'</div>';
				}
				?>
               
                <!-- pagination end -->

            </div>
        </div>
    </div>
</div>