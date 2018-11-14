<script type="text/javascript" src="<?= base_url('assets/admin/js/lib/jquery-3.2.1.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/admin/js/plugins/Chart.min.js') ?>"></script>
<div class="row">
	<div class="col-md-3">
        <a href="<?= base_url('admin/patients') ?>" class="hs_analytics_data">
            <div class="pull-left">
                <span class="icon"><i class="fa fa-user-o" aria-hidden="true"></i></span>
                <p>Patients</p>
            </div>
            <h3 class="pull-right"><?php echo $patientCount; ?></h3>
        </a>
	</div>
	<div class="col-md-3">
		<a href="<?= base_url('admin/doctors') ?>" class="hs_analytics_data">
            <div class="pull-left">
                <span class="icon"><i class="fa fa-stethoscope" aria-hidden="true"></i></span>
                <p>Doctors</p>
            </div>
            <h3 class="pull-right"><?php echo $doctorCount; ?></h3>
        </a>
	</div>
	<div class="col-md-3">
		<a href="<?= base_url('admin/appointments') ?>" class="hs_analytics_data">
            <div class="pull-left">
                <span class="icon"><i class="fa fa-handshake-o" aria-hidden="true"></i></span>
                <p>Appointment</p>
            </div>
            <h3 class="pull-right"><?php echo $appointmentCount; ?></h3>
        </a>
	</div>
	<div class="col-md-3">
		<a href="<?= base_url('admin/transaction') ?>" class="hs_analytics_data">
            <div class="pull-left">
                <span class="icon"><i class="fa fa-credit-card" aria-hidden="true"></i></span>
                <p>Sale</p>
            </div>
            <h3 class="pull-right"><?php echo $paymentCount; ?></h3>
        </a>
	</div>
    
	
</div>

<div class="row">
	<div class="col-md-12">
		<div class="hs_analytics_chart">
			<h3>Registration log</h3>
			<p>User registration data</p>
			
			<div class="hs_data_filter">
				<div class="row">
				  <form method="post">
					<div class="col-md-4">
						<div class="hs_input">
							<label>Select Year</label>
							<select class="form-control" name="search_year" id="search_year_graph">
							 <?php
							 $yearlimit=date('Y')+10;
							 
							$search_year = (isset($_POST['search_year'])) ? $_POST['search_year'] : date('Y');
                              for($i=2018 ;$i<=$yearlimit;$i++){
								  $selected = ($search_year==$i) ? 'selected' : '';
								echo '<option value="'.$i.'"  '.$selected.'>'.$i.'</option>';
							  }

							 ?>
							</select>
							
						</div>
					</div>
					</form>
				</div>
			</div>
			<div class="hs_canvas_holder">
				<canvas id="hs_registration_data" />
			</div>
		</div>
	</div>
</div>
<?php
      $max=10;
      $label=array();
	  $doc_data=array();
	  $pat_data=array();
	  $search_year=date('Y');
	  $max_month=date('m');
	  if(isset($_POST['search_year'])){
		 $search_year=$_POST['search_year'];
	     $max_month=12; 
	  }
	  $cnt=1;
	  for ($i=1;$i<=$max_month;$i++){
		  if($i<10){
			$m='0'.$i;  
		  }else{
			 $m=$i;   
		  }
		  $search_month=$search_year.'-'.$m;
		  $labeltemp = date('M' , strtotime($search_month));
		 
		  $serach_cond="user_registerdate like '%$search_month%'";
		  $serach_cond_doc=$serach_cond.' AND user_level=3';
		  $serach_cond_pat=$serach_cond.' AND user_level=2';
		  $doc_temp=$this->DatabaseModel->aggregate_data('dd_users' , 'user_id' ,'count' , $serach_cond_doc);
		  $pat_temp=$this->DatabaseModel->aggregate_data('dd_users' , 'user_id' ,'count' , $serach_cond_pat);
		  
          array_push($label,$labeltemp);
          array_push($doc_data,$doc_temp);
          array_push($pat_data,$pat_temp);
	  }
       if(max($doc_data)>$max){
		 $max=max($doc_data);  
	   }
	   if(max($pat_data)>$max){
	   $max=max($pat_data);
	   }    

	   $doc_arr=array(
	       'label' =>'Doctors',
		   'backgroundColor'=> '#4bc0c0',
		   'borderColor'=>'#4bc0c0',
		   'data'=> $doc_data,
		   'fill'=> false);
		$pat_arr=array(
	       'label' =>'Patients',
		   'backgroundColor'=> '#ff9f40',
		   'borderColor'=>'#ff9f40',
		   'data'=> $pat_data,
		   'fill'=> false);   
	  $x=array($doc_arr,$pat_arr);
	  $labels=json_encode($label);
	  $datasets=json_encode($x);
	

 ?>

<script>
if($('#hs_registration_data').length){
	
	var config2 = {
		type: 'line',
		data: {
			labels: <?php echo $labels ?>,
			datasets:<?php echo $datasets; ?>,
			
		},
		options: {
			responsive: true,
			scales: {
			yAxes: [{id: 'y-axis-1', type: 'linear', position: 'left', ticks: {min: 0, max:<?php echo $max; ?>}}]
		  }
		}
	};

	window.onload = function() {
		var ctx2 = document.getElementById("hs_registration_data").getContext("2d");
		window.myPie2 = new Chart(ctx2, config2);
	};
}

</script>