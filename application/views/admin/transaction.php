<div class="row">
    <div class="col-md-12">
        <div class="hs_heading medium">
            <h3>Transaction (<?php echo count($payment_details); ?>) </h3>
        </div>
        <div class="hs_datatable_wrapper">
            <table class="hs_datatable table table-bordered">
                <thead>
                    <tr>
                        <th>#</th> 
                        <th>Doctor</th>
						<th>Plan</th>
                        <th>Mode</th>
						<th>Amount</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
				<?php if(!empty($payment_details)) {
					 $count = 0;
					 foreach($payment_details as $solopay) {$count++;
					
					 
					 $plan_detail= $this->DatabaseModel->select_data('plan_name','dd_plans',array('plan_id'=>$solopay['payment_pid']),1);
						if( $plan_detail){
							$plan_name=$plan_detail[0]['plan_name'];
						}else{
							$plan_name='';
						}
									   
				    echo '<tr>
                        <td>'.$count.'</td>
                        <td>'.$solopay['user_name'].'</td>
                        <td>'.$plan_name.'</td>
                        <td>'.$solopay['payment_mode'].'</td>
                        <td>'.$solopay['payment_amount'].'</td>
						<td>'.$solopay['payment_date'].'</td>
                    </tr>';
					 }
				}
					?>
                </tbody>
            </table>
        </div>
    </div>
</div>


