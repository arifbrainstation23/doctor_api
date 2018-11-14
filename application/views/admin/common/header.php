<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $this->ts_functions->getsettings('sitetitle','text'); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">

   <link rel="icon" type="image/ico" href="<?= base_url($this->ts_functions->getsettings('favicon','img')) ?>" />

    <link rel="stylesheet" type="text/css" media="screen" href="<?= base_url('assets/admin/css/preloader.css') ?>" />
    <link rel="stylesheet/less" type="text/css" media="screen" href="<?= base_url('assets/admin/css/bootstrap/bootstrap.less') ?>" />
	<link rel="stylesheet/less" type="text/css" media="screen" href="<?= base_url('assets/admin/css/font_awesome/font-awesome.less') ?>" />
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/admin/css/scrollbar.css') ?>" />
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/admin/css/datatables.min.css') ?>" />
	
	<link href="<?php echo base_url().'assets/common/css/toastr.css';?>" rel="stylesheet">
	<link href="<?php echo base_url().'assets/common/css/bootstrap-material-datetimepicker.css';?>" rel="stylesheet">
    <link rel="stylesheet/less" type="text/css" media="screen" href="<?= base_url('assets/admin/css/main.less') ?>" /> 
	
</head>
<body>
<input type="hidden" id="base_url" value="<?php echo base_url(); ?>">
<!-- preloader start -->
<div class="hs_preloader">
    <div class="hs_preloader_inner">
        <img src="<?= base_url('assets/admin/images/admin_preloader.gif') ?>" alt="">
    </div>
</div>
<!-- preloader end -->

<!-- sidebar start -->
<div class="hs_sidebar_wrapper">
    <div class="hs_logo">
        <a href="<?= base_url('admin/dashboard')?>"><img src="<?= base_url($this->ts_functions->getsettings('logo','img')); ?>" alt="<?php echo $this->ts_functions->getsettings('sitetitle','text'); ?>"> </a>
    </div>
    <div class="hs_sidebar_body hs_custom_scrollbar">
        <div class="hs_nav">
            <ul>
                <li><a class="<?php if(isset($dashboard_active)) echo 'active'; ?>" href="<?= base_url('admin/dashboard') ?>"><i class="fa fa-home" aria-hidden="true"></i> Dashboard</a></li>
                <li><a class="<?php if(isset($patients_active)) echo 'active'; ?>" href="<?= base_url('admin/patients') ?>"><i class="fa fa-user-o" aria-hidden="true"></i> Patients</a></li>
                
				<li class="hs_nav_dropdown"><a a class="<?php if(isset($doctors_active)) echo 'active'; ?>"><i class="fa fa-stethoscope" aria-hidden="true"></i> Doctors</a>
                    <ul>
                        <li><a class="<?php if(isset($doctor_active)) echo 'active'; ?>" href="<?= base_url('admin/doctors') ?>">View Doctors</a></li>
                        <li><a class="<?php if(isset($adddoctor_active)) echo 'active'; ?>" href="<?= base_url('admin/add_doctor') ?>">Add Doctor</a></li>
                        <li><a class="<?php if(isset($appointments_active)) echo 'active'; ?>" href="<?= base_url('admin/appointments') ?>">Appointments</a></li>
                        <li><a class="<?php if(isset($specializations_active)) echo 'active'; ?>" href="<?= base_url('admin/specializations') ?>">Specializations</a></li>
                    </ul>
                </li>
				<li><a class="<?php if(isset($clinics_active)) echo 'active'; ?>" href="<?= base_url('admin/clinics') ?>"><i class="fa fa-hospital-o" aria-hidden="true"></i> Clinics</a></li>
                <li><a class="<?php if(isset($category_active)) echo 'active'; ?>" href="<?= base_url('admin/categories') ?>"><i class="fa fa-stop" aria-hidden="true"></i> Category</a></li>
                <li><a class="<?php if(isset($subcategory_active)) echo 'active'; ?>" href="<?= base_url('admin/sub_categories') ?>"><i class="fa fa-pause" aria-hidden="true"></i> Sub-Category</a></li>
				<li><a  class="<?php if(isset($reviews_active)) echo 'active'; ?>" href="<?= base_url('admin/ratings') ?>"><i class="fa fa-star-half-empty" aria-hidden="true"></i> Reviews</a></li>
                <li><a class="<?php if(isset($ads_active)) echo 'active'; ?>"  href="<?= base_url('admin/ads_integration') ?>"><i class="fa fa-suitcase" aria-hidden="true"></i> Ads Integration</a></li>
				 <li><a class="<?php if(isset($transaction_active)) echo 'active'; ?>"  href="<?= base_url('admin/transaction') ?>"><i class="fa fa-stop" aria-hidden="true"></i> Transactions</a></li>
				
                <li class="hs_nav_dropdown"><a class="<?php if(isset($settings_active)) echo 'active'; ?>"><i class="fa fa-cog" aria-hidden="true"></i> Settings</a>
                    <ul>
                        <li><a class="<?php if(isset($general_active)) echo 'active'; ?>" href="<?= base_url('admin/settings') ?>">General Option</a></li>
                        <li><a class="<?php if(isset($fields_active)) echo 'active'; ?>" href="<?= base_url('admin/settings/fields') ?>">Fields</a></li>
						
						<?php if($this->ts_functions->getsettings('portal','revenuemodel') == 'plan'){?>
						<li><a class="<?php if(isset($plans_active)) echo 'active'; ?>" href="<?php echo base_url('settings/plans'); ?>">Subscription Plan</a></li>
						<?php } ?>
						
						<li><a class="<?php if(isset($social_active)) echo 'active'; ?>" href="<?= base_url('settings/social_login') ?>">Social Login Setting</a></li>
                        <li><a class="<?php if(isset($text_active)) echo 'active'; ?>" href="<?= base_url('settings/texts') ?>">Language Option</a></li>
                        <li><a class="<?php if(isset($paymethod_active)) echo 'active'; ?>" href="<?= base_url('settings/payment') ?>">Payment Methods</a></li>
						 <li><a <?php if(isset($email_active)) echo 'active'; ?> href="<?= base_url('admin/email') ?>">Email Templates</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
    
</div>
<!-- sidebar end -->

<!-- page start -->
<div class="hs_page_wrapper">
    <!-- page title start -->
    <div class="hs_page_title">
        <h3><a href="<?= base_url()?>" target="_blank"><i class="fa fa-external-link" aria-hidden="true"></i> Visit Site</a></h3>
        <div class="hs_logout">
            <a onclick="logout()"><i class="fa fa-sign-out" aria-hidden="true"></i> Logout</a>
        </div>
    </div>
    <!-- page title end -->

    <!-- page body start -->
    <div class="hs_page_body">

    