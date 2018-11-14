<div class="row">
    <div class="col-md-12">
        <div class="hs_heading medium">
            <h3>Patients (<?php echo count($patientsList); ?>) <a href="<?= base_url('admin/add_patient/') ?>" class="btn">Add new</a></h3>
        </div>
        <div class="hs_datatable_wrapper">
            <table class="hs_datatable table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Doctor</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>Status</th>
						
                       
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
				 <?php
				 if(!empty($patientsList)){ $cnt=0;
					 foreach($patientsList as $soloDoc){
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
					   
			echo '<tr>
                        <td>'.$cnt.'</td>
                        <td width="200">
                            <div class="hs_user">
                                <div class="user_img">
                                    <span class="hs_user_initials">'.substr($soloDoc['user_name'], 0, 2).'</span>
                                </div>
                                <div class="user_name">
                                    <p>'.$soloDoc['user_name'].'</p>
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
                        </td>
						
                       <td width="200">
                            <a href="'.base_url().'admin/add_patient/'.$soloDoc['user_id'].'" class="btn" title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                            <a  class="btn" title="Delete" onclick="delete_user('.$user_id.' ,2)"><i class="fa fa-trash" aria-hidden="true"></i></a>
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
