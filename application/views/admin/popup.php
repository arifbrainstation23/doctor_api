<?php if(isset($fields)){ ?>
<!-- Modal content-->
<div class="row form_contianer_update" >
	<div class="col-md-12">
		<div class="hs_input">
			<label>Field Label</label>
			<input type="text" class="form-control dd_fields_creator" name="label" value="<?php echo $fields[0]['label']; ?>">
		</div>
	</div>
	<div class="col-md-12">
		<div class="hs_input">
			<label>Select Field Type</label>
			<select class="form-control dd_fields_creator dd_field_type" name="type">
				<option value="text" <?php echo $fields[0]['type'] == 'text' ? 'selected' : ''; ?>>Text</option>
				<option value="textarea" <?php echo $fields[0]['type'] == 'textarea' ? 'selected' : ''; ?>>Textbox</option>
				<option value="select" <?php echo $fields[0]['type'] == 'select' ? 'selected' : ''; ?>>Select (Dropdown)</option>
				<option value="checkbox" <?php echo $fields[0]['type'] == 'checkbox' ? 'selected' : ''; ?>>Checkbox</option>
				<option value="radio" <?php echo $fields[0]['type'] == 'radio' ? 'selected' : ''; ?>>Radio</option>
			</select>
		</div>
	</div>
	
	<!-- manage options start -->
	<div class="manage_option_div <?php echo $fields[0]['options'] == '' ? 'hide' : ''; ?>">
	<div class="clearfix"></div><hr>					
	<div class="col-md-12">
		<div class="hs_input">
			<label>Manage Options <a href="" class="add_option_btn" title="Add New option"><i class="fa fa-plus" aria-hidden="true"></i> Add New</a></label>
		</div>
	</div>
	<div class="col-md-12 manage_option_field_append">
		<?php
		$options = !empty($fields[0]['options']) ? json_decode($fields[0]['options']) : array();
		?>
		<?php for($i=0;$i<count($options);$i++){ ?>
		<div class="row">
			<div class="col-md-8">
				<div class="hs_input">
					<input type="text" class="form-control dd_fields_creator_option" placeholder="Option Value" name="options" value="<?php echo $options[$i]; ?>">
				</div>
			</div>
		</div>
		<?php } ?>
	</div>
	<div class="clearfix"></div><hr>    
	</div>	
	<!-- manage options end -->
	
	<div class="col-md-12">
		<div class="hs_input">
			<label>Create this field for</label>
			<div class="hs_checkbox_list">
				<div class="hs_checkbox">
					<input type="checkbox" id="doctor_field" name="doctor" <?php echo $fields[0]['doctor'] == '1' ? 'checked' : ''; ?> class="dd_fields_creator">
					<label for="doctor_field">Doctor</label>
				</div>
				<div class="hs_checkbox">
					<input type="checkbox" id="patient_field" name="patients" <?php echo $fields[0]['patients'] == '1' ? 'checked' : ''; ?> class="dd_fields_creator">
					<label for="patient_field">Patient</label>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-12">
	   
		<a class="btn dd_fields_action" data-action="update" data-field_id="<?php echo $fields[0]['field_id']; ?>">Update</a>
	</div>
	
</div>
<!-- Modal content-->
<?php } ?>