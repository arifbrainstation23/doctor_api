<div class="row">
    <div class="col-md-12">
        <div class="hs_heading medium">
            <h3>Sub-Category (<?php echo count($sub_cate_details); ?>) <a href="" class="btn" data-toggle="modal" onclick="add_subcategory();">Add new</a></h3>
        </div>
        <div class="hs_datatable_wrapper">
            <table class="hs_datatable table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Parent</th>
                        <th>Icon</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    
					
						<?php  if(!empty($sub_cate_details)) {
							    $count = 0;
							    foreach($sub_cate_details as $solo_sub_cate) {
							    $cid = $solo_sub_cate['sub_id'];
								$name=$solo_sub_cate['sub_name'];
								
							    $parentid = $solo_sub_cate['sub_parent'];
							    $count++;

								$ca_array       = array('cat_id'=>$parentid);
								$getCategories  = $this->DatabaseModel->select_data('cat_name','dd_categories',$ca_array ,'');
								$parent_name    =$getCategories[0]['cat_name'];
								
								 $cat_icon=base_url().'assets/admin/images/icon/default_category_icon.svg';
								 if($solo_sub_cate['sub_image']!=''){
									 $cat_icon=base_url().$solo_sub_cate['sub_image'];  
								 }
								
								$activeselected = ($solo_sub_cate['sub_status'] == '1' ? 'selected' : '' );
								 $inactiveselected = ($solo_sub_cate['sub_status'] == '0' ? 'selected' : '' );
								 $subcat='subcat';
								
						    
							echo       '<tr>
										<td>'.$count.'</td>
										<td>'.$name.'</td>
										<td>'.$parent_name.'</td>
                                        <td>
                                            <div class="hs_category_icon">
                                                <img src="'.$cat_icon.'" alt="icon">
                                            </div>
                                        </td>
                                        <td>
											<select class="form-control" onchange="updatethevalue(this,'."'".$subcat."'".');"  id="'.$cid.'_status">
												<option value="1" '. $activeselected.'>Active</option>
												<option value="0"  '.$inactiveselected.'>Deactive</option>
											</select>
										</td>
										<td width="200">
											<a class="btn" title="Edit" data-name="'.$name.'" onclick="add_subcategory('.$cid.' , '.$parentid.' ,this )"><i class="fa fa-pencil" aria-hidden="true"></i></a>
										</td>
									</tr>';
							 } } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<!-- Add New Sub Category popup start -->
<div id="add_new_subcategory" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><span>Add New </span> Sub-Category</h4>
            </div>
            <div class="modal-body">
			 <form action="<?php echo $basepath;?>admin/add_sub_categories" method="post" enctype="multipart/form-data" id="add_sub_cate_form">
                <div class="hs_input">
                    <label>Sub-Category Name</label>
                    <input type="text" class="form-control add_sub_cate_form" name="sub_catename"  id="sub_catename" value="">
					 <input type="hidden" value="0" name="old_sub_cateid" id="old_sub_cateid">
                </div>
				<div class="hs_input">
                    <label>Select Category</label>
					 <select class="form-control add_sub_cate_form" name="sub_parent" id="sub_parent">
                            <?php
                                echo '<option value="">Select One</option>';
                            if(!empty($cate_details)) {
                                foreach($cate_details as $solo_cate) {
                                
                                    echo '<option value="'.$solo_cate['cat_id'].'" >'.$solo_cate['cat_name'].'</option>';
                                }
                            } else {
                                echo '<option value="">No Parent</option>';
                            } ?>
                      </select>
                </div>
                
                <div class="hs_input">
                    <label>Sub-Category Icon</label>
                    <input type="file" class="form-control"  name="subcateimage" id="subcateimage" >
                </div>
                <div class="hs_input">
                    <a onclick="updateSettings('add_sub_cate_form')" class="btn">ADD</a>
                </div>
			  </form>
            </div>
        </div>
    </div>
</div>
<!-- Add New Sub Category popup end -->