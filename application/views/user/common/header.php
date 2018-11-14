<?php   
        $seo_title=$this->ts_functions->getsettings('sitetitle','text'); 
        $seodescr       =$this->ts_functions->getsettings('seodescr','text');
		$seoauthor      = $this->ts_functions->getsettings('siteauthor','text');
		$ogImage        = base_url('upload/webimages/'.$this->ts_functions->getsettings('logo','img'));
		$ogUrl              =  base_url();
		$meta_keywords= $this->ts_functions->getsettings('metatags','text');
		if(isset($page_seo)){
		 $seo_title      =($page_seo['seo_title']!= '') ? $page_seo['seo_title']  : $seo_title;
		 $seodescr = ($page_seo['seodescr']!= '') ? $page_seo['seodescr']  : $seodescr;
		 $meta_keywords = ($page_seo['seo_keywords']!= '') ? $page_seo['seo_keywords']  : $meta_keywords;
		 $ogImage = ($page_seo['seo_Image']!= '') ? $page_seo['seo_Image']  : $ogImage;
	    }
		
		 $chat_status=false;
			 $this->ts_functions->getsettings('chat','status');
			 if($this->user_id!='' && $this->ts_functions->getsettings('chat','status')==1){
	          $appid=$this->ts_functions->getsettings('chat','appid');
	          $authkey=$this->ts_functions->getsettings('chat','authkey');
	          $authsecret=$this->ts_functions->getsettings('chat','authsecret');
			   if($appid!='' && $authkey!='' &&  $authsecret!='' ){
				$chat_status=true;
			   }
			 } 
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo $seo_title;?></title>
	<meta content="<?php echo $seo_title;?>" property="og:title">
	<meta content="website" property="og:type">
	<meta content="<?php echo $ogUrl;?>" property="og:url">
	<meta content="<?php echo $ogImage;?>" property="og:image">
	<meta content="<?php echo $seodescr;?>" property="og:description">
	<meta content="<?php echo $this->ts_functions->getsettings('sitename','text');?>" property="og:site_name">
	<meta name="description"  content="<?php echo $seodescr;?>"/>
	<meta name="keywords" content="<?php echo $meta_keywords;?>">
	<meta name="author" content="<?php echo $seoauthor;?>"/>
	<meta content="width=device-width, initial-scale=1.0" name="viewport" />
	<meta name="MobileOptimized" content="320">
	
	
	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">
	<link rel="icon" type="image/ico" href="<?= base_url($this->ts_functions->getsettings('favicon','img')) ?>" />
	
	<link href="<?= base_url('assets/user/css/bootstrap.min.css') ?>" rel="stylesheet">
	<link href="<?php echo base_url().'assets/common/css/toastr.css';?>" rel="stylesheet">
	<link href="<?php echo base_url().'assets/common/css/bootstrap-material-datetimepicker.css';?>" rel="stylesheet">
	
	<link href="<?= base_url('assets/user/css/owl.carousel.min.css') ?>" rel="stylesheet">
	<link href="<?= base_url('assets/user/css/style.css') ?>" rel="stylesheet">
	<style>
    /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      #description {
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
      }

      #infowindow-content .title {
        font-weight: bold;
      }

      #infowindow-content {
        display: none;
      }

      #map #infowindow-content {
        display: inline;
      }

      .pac-card {
        margin: 10px 10px 0 0;
        border-radius: 2px 0 0 2px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        outline: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        background-color: #fff;
        font-family: Roboto;
      }

      #pac-container {
        padding-bottom: 12px;
        margin-right: 12px;
      }

      .pac-controls {
        display: inline-block;
        padding: 5px 11px;
      }

      .pac-controls label {
        font-family: Roboto;
        font-size: 13px;
        font-weight: 300;
      }

      #pac-input {
        background-color: #fff;
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
        margin-left: 12px;
        padding: 0 11px 0 13px;
        text-overflow: ellipsis;
        width: 400px;
      }

      #pac-input:focus {
        border-color: #4d90fe;
      }

      #title {
        color: #fff;
        background-color: #4d90fe;
        font-size: 25px;
        font-weight: 500;
        padding: 6px 12px;
      }
      #target {
        width: 345px;
      }
</style>
  <?php echo $this->ts_functions->getsettings('google','anaylitics');?>
</head>
<body>
<input type="hidden" id="base_url" value="<?php echo  base_url();?>">
<div class="dd_loading_wrapper">
    <div class="dd_loading_inner">
        <img src="<?= base_url('assets/user/images/loader01.gif') ?>" alt="" />
    </div>
</div>

<div class="dd_sidebar_close"></div>


<!-- header after login start -->
 <div class="dd_header">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="dd_logo">
				
                    <a href="<?php echo base_url(); ?>"><img src="<?= base_url($this->ts_functions->getsettings('logo','img')); ?>" alt=""></a>
                </div>
                <div class="dd_nav">
                    <ul>
                        <li><a href="<?= base_url() ?>" class="<?php if(isset($doctor_active)) echo 'active'; ?>"><?php echo $this->ts_functions->getlanguage( 'doctors', 'menus', 'solo' ); ?></a></li>
						
                        <li><a href="<?= base_url('appointments') ?>"  class="<?php if(isset($appointment_active)) echo 'active'; ?>"><?php echo $this->ts_functions->getlanguage('appointments', 'menus', 'solo' ); ?></a></li>
						
                        <li><a href="<?= base_url('favourite') ?>" class="<?php if(isset($favorite_active)) echo 'active'; ?>"><?php echo $this->ts_functions->getlanguage( 'favourite', 'menus', 'solo' ); ?></a></li>
						
						<?php if($this->ts_functions->dd_level==3){ ?>
						<li><a href="<?= base_url('user/my_clinics'); ?>" class="<?php if(isset($clinics_active)) echo 'active'; ?>"><?php echo $this->ts_functions->getlanguage('my_clinics', 'menus', 'solo' ); ?></a></li>
						<?php } ?>
						<?php 
						if($this->ts_functions->dd_level!=2){
							if($this->ts_functions->getsettings('portal','revenuemodel') == 'plan'){
							$plan_active=(isset($plan_active)) ? 'active' : '';
	
							echo'<li><a href="'.base_url('plans').'" class="'.$plan_active.'">'.$this->ts_functions->getlanguage('plan', 'menus', 'solo' ).'</a></li>';
							 }
						}
						?>
						
                    </ul>
                </div>
               
                <div class="dd_header_right">
				 <?php  if($this->ts_functions->dd_uid != ''){
                 
				 $user_header_details=$this->DatabaseModel->select_data('user_pic,user_name' ,'dd_users' , array('user_id' =>$this->ts_functions->dd_uid) ,1);
				 $header_user_pic='' ;
				 if($user_header_details[0]['user_pic']!=''){
					 $header_user_pic= base_url().$user_header_details[0]['user_pic'];
				 }
				 
				$username_arr=explode(' ',$user_header_details[0]['user_name']);
				$name_initiails=substr($username_arr[0] , 0, 1); 
				if(isset($username_arr[1])){
					$name_initiails.=substr($username_arr[1] , 0, 1); 
				}
				 

				  ?>
                        				 
                    <div class="dd_profile_dd dd_dropdown_wrapper dropdown_right">
                        <div class="icon has_image">
						<?php if($header_user_pic !=''){ ?>
                            <img src="<?=$header_user_pic; ?>" alt="" />
						<?php } ?>	
                            <span class="name_initial"><?php echo  $name_initiails; ?></span>
                        </div>
                        <label><span><?php echo $this->ts_functions->getlanguage('hi', 'menus', 'solo' ) ?> <?php echo  ucfirst($user_header_details[0]['user_name']); ?></span></label>
                        <div class="dd_dropdown">
                            <div class="dd_dropdown_inner">
                                <ul>
                                    <li><a href="<?php echo base_url().'profile'; ?>"><?php echo $this->ts_functions->getlanguage('profile_setting', 'menus', 'solo' ); ?></a></li>
									<?php 
									if($chat_status){
									echo '<li><a target="_blank" href="'.base_url().'chats'.'">'.$this->ts_functions->getlanguage('chats', 'menus', 'solo' ).'</a></li>';	
									}
									?>
                                    <li><a  onclick="logout()"><?php echo $this->ts_functions->getlanguage('logout', 'menus', 'solo' ); ?></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
				 <?php } else{ ?>
					 <div class="dd_profile_dd">
                        <label><a href="<?= base_url('authentication') ?>"><?php echo $this->ts_functions->getlanguage('login', 'menus', 'solo' ); ?></a></label>
                    </div>
				 <?php } ?> 
                  <div class="dd_nav_toggle">
                        <span></span>
                        <span></span>
                        <span></span>
                  </div>				 
                </div>
            </div>
        </div>
    </div>
</div>    
<!-- header after login end -->

<!-- main wrapper start -->
<div class="dd_main_wrapper">