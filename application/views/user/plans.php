<div class="dd_page_title">
	<h3><?php echo $this->ts_functions->getlanguage('plan', 'menus', 'solo' ); ?></h3>
</div>

<div class="container">
	<div class="row">
	 <?php foreach($plandetails as $solo_plans) {?>
		<div class="col-md-4">
			<div class="dd_plans">
				<label><?php echo $solo_plans['plan_name'];?></label>
				<h3><?php echo $this->ts_functions->getsettings('portalcurreny','symbol');?><?php echo $solo_plans['plan_amount'];?></h3>
				<p><?php echo $this->ts_functions->getlanguage('plan_duration', 'profile', 'solo' ); ?> - <?php echo $solo_plans['plan_duration_txt'];?></p>
				<?php
				if( $solo_plans['plan_description'] != '' ) {
				$featureArr = explode(PHP_EOL, $solo_plans['plan_description']); ?>
					<div class="dd_pritable_list">
						<ul>
						<?php for($i=0;$i<count($featureArr);$i++) {
							 echo '<li>'.$featureArr[$i].'</li>';
						} ?>
						</ul>
					</div>
				 <?php } ?>
				<a class="dd_btn" onclick="plan_purchase(<?php echo $solo_plans['plan_id']; ?>)"><?php echo $this->ts_functions->getlanguage('bynow', 'commontext', 'solo' ); ?></a>
			</div>
		</div>
	 <?php  } ?>		
	</div>
</div>
<div id="pay_form_box" style="text-align:center;">

</div>