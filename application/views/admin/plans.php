<div class="row">
    <div class="col-md-12">
        <div class="hs_heading medium">
            <h3>Plans (<?php echo count($plan_details); ?>) <a href="" class="btn" data-toggle="modal"  onclick="add_plan()">Add new</a></h3>
        </div>
        <div class="hs_datatable_wrapper">
            <table class="hs_datatable table table-bordered">
                <thead>
                    <tr>
                        <th>#</th> 
                        <th>Plan Name</th>
                        <th>Plan Amount</th>
						<!--<th>Plan Listing</th> -->
						<th>Plan Duration</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
				<?php if(!empty($plan_details)) {
					 $count = 0;
					 foreach($plan_details as $soloplan) {$count++;
					 $plan_id = $soloplan['plan_id'];
					 $plan_name=$soloplan['plan_name'];
					 $plan_amount=$soloplan['plan_amount'];
					 //$plan_listing=$soloplan['plan_listing'];
					 $plan_duration=$soloplan['plan_duration_txt'];
					 
					 
					 $activeselected = ($soloplan['plan_status'] == '1' ? 'selected' : '' );
					 $inactiveselected = ($soloplan['plan_status'] == '0' ? 'selected' : '' );
					 $plan='plan';
					 
					 
				   
				    echo '<tr>
                        <td>'.$count.'</td>
                        <td>'.$plan_name.'</td>
                        <td>'.$plan_amount.'</td>
                        
                        <td>'.$plan_duration.'</td>
						
                        
                        <td>
                            <select class="form-control" onchange="updatethevalue(this,'."'".$plan."'".');"  id="'.$plan_id.'_status">
                                <option value="1" '. $activeselected.'>Active</option>
                                <option value="0"  '.$inactiveselected.'>Deactive</option>
                            </select>
                        </td>
                        <td width="200">
						    <a  class="btn" title="Edit" onclick="add_plan('.$plan_id.')"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                        </td>
                    </tr>';
					 }
				}
					?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<!-- Add New Category popup start -->
<div id="add_new_plan" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><span>Add New Plan</span></h4>
            </div>
            <div class="modal-body">
			<form action="<?php echo base_url();?>settings/plans" method="post" enctype="multipart/form-data" id="add_plan_form">
                <div class="hs_input">
                    <label>Plan Name</label>
                    <input type="text" class="form-control add_plan_form" placeholder="Plan Name"  name="plan_name" id="plan_name">
                </div>
				<div class="hs_input">
                    <label>Plan amount</label>
                    <input type="text" class="form-control add_plan_form" placeholder="Plan Amount"  name="plan_amount" id="plan_amount">
                </div>
				<div class="hs_input">
                    <label>Plan Duration</label>
					<div class="row">
						<div class="col-md-6">
							<select class="form-control add_plan_form" id="plan_duration_count" name="plan_duration_count">
							<?php for($i=1;$i<31;$i++) { ?>
								<option value="<?php echo $i; ?>" ><?php echo $i; ?></option>
							<?php } ?>
							</select>
						</div>
						<div class="col-md-6">
							<select class="form-control add_plan_form" id="plan_duration_type" name="plan_duration_type">
								<option value="Days" >Days</option>
								<option value="Weeks" >Weeks</option>
								<option value="Months" >Months</option>
								<option value="Years" >Years</option>
							</select>
						</div>
					</div>
					
					
                </div>
				<div class="hs_input">
                    <label>Description</label>
                    <textarea class="form-control add_plan_form"  name="plan_description" id="plan_description"></textarea>
                </div>
                <div class="hs_input">
				  <input type="hidden" value="0" name="old_planid" id="old_planid">
					 <a onclick="updateSettings('add_plan_form')" class="btn ">ADD</a>
                </div>
            </div>
			</form>
        </div>
    </div>
</div>
<!-- Add New Category popup end -->