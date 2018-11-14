    </div>
    <!-- page body end -->
    <div class="hs_footer">
        <p class="hs_copyright"><?php echo $this->ts_functions->getlanguage('footerbottom','footer','solo'); ?> </p>
		<p class="hs_copyright">  Developed by <a href="http://himanshusofttech.com/" target="_blank"> Himanshusofttech (v1.0)</a></p>
        <div class="hs_footer_social">
            <a href="<?php echo $this->ts_functions->getsettings('fblink','url'); ?>" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a>
            <a href="<?php echo $this->ts_functions->getsettings('googlelink','url'); ?>" target="_blank"><i class="fa fa-google-plus" aria-hidden="true"></i></a>
            <a href="<?php echo $this->ts_functions->getsettings('twitterlink','url'); ?>" target="_blank"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
        </div>
    </div>
</div>
<!-- page end -->
<input type="hidden" id="base_url" value="<?php echo base_url(); ?>">
<script>
    less = {
        env: "development",
        logLevel: 2,
        async: true,
        compress: false,
    };
</script>
<script type="text/javascript" src="<?= base_url('assets/admin/js/less.min.js') ?>"></script>

<!-- library javascript start -->
<script type="text/javascript" src="<?= base_url('assets/admin/js/lib/jquery-3.2.1.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/admin/js/lib/bootstrap.min.js') ?>"></script>
<!-- library javascript end -->

<!-- plugin javascript start -->
<script type="text/javascript" src="<?= base_url('assets/admin/js/plugins/scrollbar.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/admin/js/plugins/datatables.min.js') ?>"></script>


<script src="<?php echo base_url().'assets/common/js/toastr.js'; ?>"></script>

<script src= "<?php echo base_url().'assets/common/js/moment.js'; ?>"></script>
<script src= "<?php echo base_url().'assets/common/js/bootstrap-material-datetimepicker.js'; ?>"></script>

<!-- plugin javascript end -->

<script type="text/javascript" src="<?php echo  base_url().'assets/admin/js/main.js?'.date('his'); ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/admin/js/custom.js?').date('his'); ?>"></script>



<?php 
	if(isset($_SESSION['ts_error']) && $_SESSION['ts_error'] != ''){
		echo '<script>toastr.error("'.$_SESSION['ts_error'].'");</script>';
		$_SESSION['ts_error']='';
	}
	if(isset($_SESSION['ts_success']) && $_SESSION['ts_success'] != ''){
		echo '<script>toastr.success("'.$_SESSION['ts_success'].'");</script>';
		$_SESSION['ts_success']='';
	}
	?>
</body>
</html>