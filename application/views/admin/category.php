<div class="row">
    <div class="col-md-12">
        <div class="hs_heading medium">
            <h3>Category (<?php echo count($cate_details); ?>) <a href="" class="btn" data-toggle="modal"  onclick="add_category()">Add new</a></h3>
        </div>
        <div class="hs_datatable_wrapper">
            <table class="hs_datatable table table-bordered">
                <thead>
                    <tr>
                        <th>#</th> 
                        <th>Name</th>
                        <th>Category icon</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
				<?php if(!empty($cate_details)) {
					 $count = 0;
					 foreach($cate_details as $solocate) {$count++;
					 $cid = $solocate['cat_id'];
					 $cat_name=$solocate['cat_name'];
					 $cat_icon=base_url().'assets/admin/images/icon/default_category_icon.svg';
					 if($solocate['cat_image']!=''){
						 $cat_icon=base_url().$solocate['cat_image']; 
					 }
					 
					 $activeselected = ($solocate['cat_status'] == '1' ? 'selected' : '' );
					 $inactiveselected = ($solocate['cat_status'] == '0' ? 'selected' : '' );
					 $cat='cat';
					 
					 
				   
				    echo '<tr>
                        <td>'.$count.'</td>
                        <td>'.$cat_name.'</td>
                        <td>
                            <div class="hs_category_icon">
                                <img src='.$cat_icon.' alt="icon">
                            </div>                            
                        </td>
                        <td>
                            <select class="form-control" onchange="updatethevalue(this,'."'".$cat."'".');"  id="'.$cid.'_status">
                                <option value="1" '. $activeselected.'>Active</option>
                                <option value="0"  '.$inactiveselected.'>Deactive</option>
                            </select>
                        </td>
                        <td width="200">
						    <a  class="btn" title="Edit" data-name="'.$cat_name.'" onclick="add_category('.$cid.' , this)"><i class="fa fa-pencil" aria-hidden="true"></i></a>
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
<div id="add_new_category" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><span>Add New</span> Category</h4>
            </div>
            <div class="modal-body">
			<form action="<?php echo base_url();?>admin/add_categories" method="post" enctype="multipart/form-data" id="add_cate_form">
                <div class="hs_input">
                    <label>Category Name</label>
                    <input type="text" class="form-control add_cate_form" placeholder="Name"  name="catename" id="catename">
                </div>
                <div class="hs_input">
                    <label>Category Icon</label>
                    <input type="file" class="form-control " name="cateimage" id="cateimage">
                </div>
                <div class="hs_input">
				  <input type="hidden" value="0" name="old_cateid" id="old_cateid">
					 <a onclick="updateSettings('add_cate_form')" class="btn ">ADD</a>
                </div>
            </div>
			</form>
        </div>
    </div>
</div>
<!-- Add New Category popup end -->