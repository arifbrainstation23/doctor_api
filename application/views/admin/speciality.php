<div class="row">
    <div class="col-md-12">
        <div class="hs_heading medium">
            <h3>Specializations (<?php echo count($spe_details); ?>) <a href="" class="btn" data-toggle="modal"  onclick="add_speciality()">Add new</a></h3>
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
				<?php if(!empty($spe_details)) {
					 $count = 0;
					 foreach($spe_details as $solospe) {$count++;
					 $spe_id = $solospe['spe_id'];
					 $spe_name=$solospe['spe_name'];
					
					 
					 $activeselected = ($solospe['spe_status'] == '1' ? 'selected' : '' );
					 $inactiveselected = ($solospe['spe_status'] == '0' ? 'selected' : '' );
					 $cat='spe';
					 
					 
				   
				    echo '<tr>
                        <td>'.$count.'</td>
                        <td>'.$spe_name.'</td>
                        <td>
                            <select class="form-control" onchange="updatethevalue(this,'."'".$cat."'".');"  id="'.$spe_id.'_status">
                                <option value="1" '. $activeselected.'>Active</option>
                                <option value="0"  '.$inactiveselected.'>Deactive</option>
                            </select>
                        </td>
                        <td width="200">
						    <a  class="btn" title="Edit" onclick="add_speciality('.$spe_id.' , '."'".$spe_name."'".')"><i class="fa fa-pencil" aria-hidden="true"></i></a>
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
<div id="add_new_speciality" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button> 
                <h4 class="modal-title"><span>Add New</span>  Speciality</h4>
            </div>
            <div class="modal-body">
			<form action="<?php echo base_url();?>admin/add_specializations" method="post" enctype="multipart/form-data" id="add_spe_form">
                <div class="hs_input">
                    <label>Speciality Name</label>
                    <input type="text" class="form-control add_spe_form" placeholder="Name"  name="spename" id="spename">
                </div>
                
                <div class="hs_input">
				  <input type="hidden" value="0" name="old_speid" id="old_speid">
					 <a onclick="updateSettings('add_spe_form')" class="btn ">ADD</a>
                </div>
            </div>
			</form>
        </div>
    </div>
</div>
<!-- Add New Category popup end -->