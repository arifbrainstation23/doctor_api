<div class="row">
    <div class="col-md-12">
        <div class="hs_heading medium">
            <h3>Clinics (<?php echo count($clinicList); ?>) <a href="<?= base_url('admin/add_clinic/') ?>" class="btn">Add new</a></h3>
        </div>
        <div class="hs_datatable_wrapper">
            <table class="hs_datatable table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        
                        <th>Status</th>
						
                       
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
				 <?php
				 if(!empty($clinicList)){ $cnt=0;
					 foreach($clinicList as $cData){
					   $cnt++;
					   $clinic_id=$cData['cl_id'];
					   
					  
					 $useractiveselected = ($cData['cl_status'] == '1' ? 'selected' : '' );
					 $userinactiveselected = ($cData['cl_status'] == '0' ? 'selected' : '' );
					 $clinic='clinic';
					 
					
					   
			echo '<tr>
                        <td>'.$cnt.'</td>
                        <td>'.$cData['cl_name'].'</td>
						<td>
                            <select class="form-control" onchange="updatethevalue(this,'."'".$clinic."'".');"  id="'.$clinic_id.'_status">
                                <option value="1" '. $useractiveselected.'>Active</option>
                                <option value="0"  '.$userinactiveselected.'>Inactive</option>
                            </select>
                        </td>
                       <td width="200">
                            <a href="'.base_url().'admin/add_clinic/'.$clinic_id.'" class="btn" title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                            <a  class="btn" title="Delete" onclick="delete_clinic('.$clinic_id.')"><i class="fa fa-trash" aria-hidden="true"></i></a>
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
