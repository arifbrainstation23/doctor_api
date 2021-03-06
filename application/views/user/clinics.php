<div class="dd_page_title">
	<h3><?php echo $this->ts_functions->getlanguage('my_clinics', 'menus', 'solo' ); ?></h3>
</div>

<div class="container">
	<div class="row">
	 <?php if(empty($clinicDetail)){ 
		echo '<div class="col-md-12">
			<div class="dd_no_doctor">
				<div class="icon">
					<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 60 60" style="enable-background:new 0 0 60 60;" xml:space="preserve" width="512px" height="512px"><g><path d="M50.976,21.694c-0.528-9-7.947-16.194-16.891-16.194c-5.43,0-10.688,2.663-13.946,7.008 c-0.075-0.039-0.155-0.066-0.231-0.103c-0.196-0.095-0.394-0.185-0.597-0.266c-0.118-0.047-0.238-0.089-0.358-0.131 c-0.197-0.069-0.397-0.13-0.6-0.185c-0.12-0.032-0.239-0.065-0.36-0.093c-0.22-0.05-0.444-0.088-0.67-0.121 c-0.105-0.016-0.209-0.036-0.315-0.048C16.676,11.523,16.341,11.5,16,11.5c-4.962,0-9,4.037-9,9c0,0.129,0.008,0.255,0.016,0.381 C2.857,23.148,0,27.899,0,32.654C0,39.737,5.762,45.5,12.845,45.5h6.262l-5.264,9h32.313l-5.264-9h7.079 C54.604,45.5,60,40.104,60,33.472C60,27.983,56.173,23.06,50.976,21.694z M42.67,52.5H17.33l4.094-7h0.001L30,30.837L38.576,45.5 h0.001L42.67,52.5z M47.972,43.5h-8.249L30,26.876L20.277,43.5h-7.432C6.865,43.5,2,38.635,2,32.654 c0-4.154,2.705-8.466,6.432-10.253L9,22.13V21.5c0-0.123,0.008-0.249,0.015-0.375l0.009-0.173L9.012,20.75 C9.006,20.667,9,20.584,9,20.5c0-3.859,3.14-7,7-7c0.309,0,0.614,0.027,0.917,0.067c0.078,0.01,0.156,0.023,0.234,0.036 c0.267,0.044,0.53,0.102,0.789,0.176c0.035,0.01,0.071,0.017,0.106,0.027c0.285,0.087,0.563,0.198,0.835,0.321 c0.07,0.032,0.139,0.066,0.208,0.1c0.241,0.119,0.477,0.25,0.705,0.398C21.72,15.874,23,18.039,23,20.5c0,0.553,0.448,1,1,1 s1-0.447,1-1c0-2.754-1.246-5.219-3.2-6.871C24.666,9.879,29.388,7.5,34.084,7.5c7.745,0,14.178,6.135,14.849,13.888 c-1.022-0.072-2.553-0.109-4.084,0.124c-0.546,0.083-0.921,0.593-0.838,1.139c0.075,0.495,0.501,0.85,0.987,0.85 c0.05,0,0.101-0.004,0.152-0.012c2.228-0.336,4.548-0.021,4.684-0.002C54.491,24.372,58,28.661,58,33.472 C58,39.001,53.501,43.5,47.972,43.5z" fill="#d1d1d1"></path><path d="M30,35.5c-0.552,0-1,0.447-1,1v8c0,0.553,0.448,1,1,1s1-0.447,1-1v-8C31,35.947,30.552,35.5,30,35.5z" fill="#d1d1d1"></path><path d="M30,47.5c-0.552,0-1,0.447-1,1v1c0,0.553,0.448,1,1,1s1-0.447,1-1v-1C31,47.947,30.552,47.5,30,47.5z" fill="#d1d1d1"></path></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>
				</div>
				<p>'.$this->ts_functions->getlanguage('noclinic', 'profile', 'solo' ).'</p>
				<div class="text-center"><a href="'.base_url('user/add_clinic').'" class="dd_btn">'.$this->ts_functions->getlanguage('addnewclinic', 'profile', 'solo' ).'</a></div>
			</div>
		</div>';
	  } else { 
	  $cnt=0;
	echo   '<div class="col-md-12">
			 <div class="dd_appointment_list">
				<div class="text-right"><a href="'.base_url('user/add_clinic').'" class="dd_btn">'.$this->ts_functions->getlanguage('addnewclinic', 'profile', 'solo' ).'</a></div><br>
				<div class="dd_appointment_head">
					<ul>
						<li>
							<div class="dd_appointment">
								<div class="dd_appion_col">#</div>
								<div class="dd_appion_col">'.$this->ts_functions->getlanguage('name', 'profile', 'solo' ).'</div>
				                <div class="dd_appion_col">'.$this->ts_functions->getlanguage('status', 'profile', 'solo' ).'</div>
								<div class="dd_appion_col">'.$this->ts_functions->getlanguage('action', 'profile', 'solo' ).'</div>
							</div>
						</li>
					</ul>
				</div>
				<div class="dd_appointment_body">
					<ul>';
					  foreach($clinicDetail as $soloClinic){ $cnt++;
					  $clinic_id=$soloClinic['cl_id'];
					  
					   $checked = ($soloClinic['cl_status'] == '1' ? 'checked' : '' );
					  
					  
	echo				 '<li>
							<div class="dd_appointment">
								<div class="dd_appion_col">'.$cnt.'</div>
								<div class="dd_appion_col">'.$soloClinic['cl_name'].'</div>
								<div class="dd_appion_col">
									<div class="dd_switch">
									 <input type="checkbox" id="switch_id'. $clinic_id.'"  data-clid="'. $clinic_id.'" class="clinic_status" '.$checked.' >
									 <label for="switch_id'. $clinic_id.'"></label>
									</div>
								</div>
								<div class="dd_appion_col">
									<a href="'.base_url().'user/add_clinic/'.$clinic_id.'" class="btn_table" title="'.$this->ts_functions->getlanguage('edit', 'commontext', 'solo' ).'"><span class="dd_icon edit"></span></a>
								</div>
							</div>
						</li>';
					   } 
	echo				'</ul>
				</div>
				
			</div>	
		</div>';
	   } ?>	
	</div>
</div>