<div class="row">
    <div class="col-md-12">
        <div class="hs_heading medium">
            <h3>Payment Method</h3>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <!-- tab start -->
        <div class="hs_tabs">
            <ul class="nav nav-pills">
                <li class="active"><a data-toggle="pill" href="#paypal">Paypal </a></li> 
                
            </ul>
                
            <div class="tab-content">
           
			  <!-- Paypal setting tab start -->
               <div id="paypal" class="tab-pane fade in active">
                    <div class="row"> 
						<div class="col-md-8">
						  <div class="hs_checkbox">
							<input type="checkbox" id="paypal_status" class="paypalSettings" value="1" <?php echo $this->ts_functions->getsettings('paypal','status') == '1' ? 'checked' : '' ; ?>>
							  <label for="paypal_status">Use Paypal for payment</label>
						  </div>
						</div>
						<div class="col-md-8">
						  <div class="hs_input">
							<label>Paypal Email</label>
							<input type="text" class="form-control paypalSettings" id="paypal_email" value="<?php echo $this->ts_functions->getsettings('paypal','email');?>">
						  </div>
						</div>
						<div class="col-md-12">
                              <a onclick="updatePaymentSettings('paypalSettings')" class="btn theme_btn">UPDATE</a>
                        </div> 
                    </div>
                </div>
                <!-- Paypal setting tab end -->	
				
            </div>
        </div>
        <!-- tab end -->
    </div>
</div>