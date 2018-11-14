<div class="row">
    <div class="col-md-12">
        <div class="hs_heading medium">
            <h3>Fields <a href="" class="btn" data-toggle="modal" data-target="#add_fields">Add new Field</a></h3>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="alert alert-warning">
            <strong>Note!</strong> You can not edit the basic fields i.e, Name, Email, Phone, Address, Password.
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="hs_datatable_wrapper">
            <table class="hs_datatable table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>label</th>
                        <th>type</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
					<?php for($i=0;$i<count($fields);$i++){ ?>
                    <tr>
                        <td><?php echo $i+1; ?></td>
                        <td><?php echo $fields[$i]['label']; ?></td>
                        <td><?php echo $fields[$i]['type']; ?></td>
                        <td>
                            <a href="" class="btn edit_fields" data-field_id="<?php echo $fields[$i]['field_id']; ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                            <a href="" class="btn dd_fields_action" data-field_id="<?php echo $fields[$i]['field_id']; ?>" data-action="delete"><i class="fa fa-trash" aria-hidden="true"></i></a>
                        </td>
                    </tr>
					<?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add new field popup start -->
<div id="add_fields" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add new Field</h4>
            </div>
            <div class="modal-body">
                <div class="row form_contianer_add">
                    <div class="col-md-12">
                        <div class="hs_input">
                            <label>Field Label</label>
                            <input type="text" class="form-control dd_fields_creator" name="label">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="hs_input">
                            <label>Select Field Type</label>
                            <select class="form-control dd_fields_creator dd_field_type" name="type">
                                <option value="text">Text</option>
                                <option value="textarea">Textbox</option>
                                <option value="select">Select (Dropdown)</option>
                                <option value="checkbox">Checkbox</option>
                                <option value="radio">Radio</option>
                            </select>
                        </div>
                    </div>

                    <!-- manage options start -->
					<div class="manage_option_div hide">
                    <div class="clearfix"></div><hr>					
                    <div class="col-md-12">
                        <div class="hs_input">
                            <label>Manage Options <a href="" class="add_option_btn" title="Add New option"><i class="fa fa-plus" aria-hidden="true"></i> Add New</a></label>
                        </div>
                    </div>
                    <div class="col-md-12 manage_option_field_append">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="hs_input">
                                    <input type="text" class="form-control dd_fields_creator_option" placeholder="Option Value" name="options">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div><hr>    
					</div>	
                    <!-- manage options end -->
                    

                    <div class="col-md-12">
                        <div class="hs_input">
                            <label>Create this field for</label>
                            <div class="hs_checkbox_list">
                                <div class="hs_checkbox">
                                    <input type="checkbox" id="doctor_field" name="doctor" value="1" class="dd_fields_creator">
                                    <label for="doctor_field">Doctor</label>
                                </div>
                                <div class="hs_checkbox">
                                    <input type="checkbox" id="patient_field" name="patients" class="dd_fields_creator">
                                    <label for="patient_field">Patient</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <a  class="btn dd_fields_action" data-action="create">Create</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Add new field popup end -->

<!-- Add new field popup start -->
<div id="edit_fields" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit new Field</h4>
            </div>
            <div class="modal-body">
                
            </div>
        </div>
    </div>
</div>
<!-- Edit new field popup end -->