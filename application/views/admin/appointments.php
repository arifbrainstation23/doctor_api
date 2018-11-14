<div class="row">
    <div class="col-md-12">
        <div class="hs_heading medium">
            <h3>Appointments (<?php echo count($total_appo); ?>) </h3>
        </div>
        <div class="hs_datatable_wrapper">
            <table class="hs_datatable table table-bordered">
                <thead>
                    <tr>
                        <th>#</th> 
                        <th>Clinic</th>
                        <th>Patients</th>
                        <th>Appointment date</th>
                        <th>Appointment time</th>
                        <th>Status</th>
                        
                    </tr>
                </thead>
                <tbody>
				<?php if(!empty($total_appo)) {
					 $count = 0;
					foreach($total_appo as $soloApp){ $count++;
					  $clinic_name=$this->DatabaseModel->select_data('cl_name' , 'dd_clinics' , array('cl_id' =>$soloApp['apo_clinic_id']) ,1 );
					  if(!empty($clinic_name)){
						  $clinic_name= $clinic_name[0]['cl_name'];
					  }else{
						  $clinic_name= 'Deleted';
					  }
					  $patient_name=$this->DatabaseModel->select_data('user_name' , 'dd_users' , array('user_id' =>$soloApp['apo_user_id']) ,1 );
						  if(!empty($patient_name)){
							  $patient_name= $patient_name[0]['user_name'];
						  }else{
							  $patient_name= 'Deleted';
						  }
						  
						  $bookStatus = ($soloApp['apo_status'] == '1' ? 'Booked' : 'Canceled' );
					      
					 
					 
				   
				    echo '<tr>
                        <td>'.$count.'</td>
                        <td>'.$clinic_name.'</td>
                        <td>'.$patient_name.'</td>
						<td>'.date("d-M-Y", strtotime($soloApp['apo_date'])).'</td>
                        <td>'.date("h:i A", strtotime($soloApp['apo_timing'])).'</td>
						<td>'.$bookStatus.'</td>
                    </tr>';
					 }
				}
					?>
                </tbody>
            </table>
        </div>
    </div>
</div>


