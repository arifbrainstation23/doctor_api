<div class="row">
    <div class="col-md-12">
        <div class="hs_heading medium">
            <h3>Reviews (<?php echo count($rat_details); ?>) </h3>
        </div>
        <div class="hs_datatable_wrapper">
            <table class="hs_datatable table table-bordered">
                <thead>
                    <tr>
                        <th>#</th> 
                        <th>Name</th>
                        <th>Doctor</th>
                        <th>Review</th>
                        <th>Rating</th>                        
                    </tr>
                </thead>
                <tbody>
				<?php if(!empty($rat_details)) {
					 $count = 0;
					 foreach($rat_details as $solorat) {$count++;
					
					 $rat_doctor_id=$solorat['rat_doctor_id'];
					 $doc_detail= $this->DatabaseModel->select_data('user_name','dd_users',array('user_id'=>$solorat['rat_doctor_id']),1);
					if( $doc_detail){
						$doctor_name=$doc_detail[0]['user_name'];
					}else{
						$doctor_name='';
					}
									   
				    echo '<tr>
                        <td>'.$count.'</td>
                        <td>'.$solorat['user_name'].'</td>
                        <td>'.$doctor_name.'</td>
                        <td>'.$solorat['rat_comment'].'</td>
                        <td>'.$solorat['rat_rating'].'</td>                        
                    </tr>';
					 }
				}
					?>
                </tbody>
            </table>
        </div>
    </div>
</div>
