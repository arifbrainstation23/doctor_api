<div class="row">
    <div class="col-md-12">
        <div class="hs_heading medium">
            <h3>Doctor (<?php echo count($doctorList); ?>) <a href="<?= base_url('admin/add_doctor') ?>" class="btn">Add new</a></h3>
        </div>
        <div class="hs_datatable_wrapper">
            <table class="hs_datatable table table-bordered responsive">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Doctor</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>Status</th>
						<?php if( $this->ts_functions->getsettings('portal','revenuemodel') == 'plan' ) { echo '<th>Plan</th>'; } ?>
                       
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
				 <?php
				 if(!empty($doctorList)){ $cnt=0;
					 foreach($doctorList as $soloDoc){
					   $cnt++;
					   $user_id=$soloDoc['user_id'];
					   $user_img='';
					   if($soloDoc['user_pic']!=''){
						  $user_img=base_url().$soloDoc['user_pic']; 
					   }
					   
					 $useractiveselected = ($soloDoc['user_status'] == '1' ? 'selected' : '' );
					 $userinactiveselected = ($soloDoc['user_status'] == '0' ? 'selected' : '' );
					 $user='user';
					 
					 $user_plans = $soloDoc['user_plans'];
					
					$user_name=$soloDoc['user_name'];
					 $username_arr=explode(' ',$user_name);
						$name_initiails=substr($username_arr[0] , 0, 1); 
						if(isset($username_arr[1])){
							$name_initiails.=substr($username_arr[1] , 0, 1); 
						}
					   
			echo '<tr>
                        <td>'.$cnt.'</td>
                        <td width="200">
                            <div class="hs_user">
                                <div class="user_img">
                                    <span class="hs_user_initials">'.$name_initiails.'</span>
                                </div>
                                <div class="user_name">
                                    <p>'.$user_name.'</p>
                                    <span>Created at - '.date("d-m-Y", strtotime($soloDoc['user_registerdate'])).'</span>
                                </div>
                            </div>
                        </td>
                        <td>'.$soloDoc['user_email'].'</td>
                        <td>'.$soloDoc['user_mobile'].'</td>
						<td>
                            <select class="form-control" onchange="updatethevalue(this,'."'".$user."'".');"  id="'.$user_id.'_status">
                                <option value="1" '. $useractiveselected.'>Active</option>
                                <option value="0"  '.$userinactiveselected.'>Inactive</option>
                            </select>
                        </td>';
						if( $this->ts_functions->getsettings('portal','revenuemodel') == 'plan' ) {	
				   echo '<td>
                            <select class="form-control" onchange="updatethevalue(this,'."'".$user."'".');"  id="'.$user_id.'_plans">
							<option value="0">No Plan</option>';
                                if(!empty($plans)){
								   foreach($plans as $plan){
									$selected=($plan['plan_id'] == $user_plans) ? 'selected' : '';
									echo'<option value="'.$plan['plan_id'].'"  '.$selected.' >'.$plan['plan_name'].'</option>';
									}
								}
                   echo     '</select>
                        </td>';
						}
                   echo '<td width="200">
                            <a href="'.base_url().'admin/add_doctor/'.$soloDoc['user_id'].'" class="btn" title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                            <a  class="btn" title="Delete" onclick="delete_user('.$user_id.' ,3)"><i class="fa fa-trash" aria-hidden="true"></i></a>
                        </td>
                     </tr>' ;
					 }
				 
				 }
				 ?>
                   
                </tbody>
            </table>
        </div>
    </div>
</div>
