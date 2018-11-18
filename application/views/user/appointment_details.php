<script src="<?= base_url('sinch/sinch.min.js') ?>"></script>
<div class="dd_page_title">
	<h3><?php echo $this->ts_functions->getlanguage('appointments', 'menus', 'solo' ); ?></h3>
</div>

<div class="container">
	<div class="row">
        <?php
        if($user_level == 2){ // Patient
            ?>

            <?php
        }else{ // Doctor
            ?>

            <?php
        }
        ?>
	</div>
</div>
<script>
    //*** Set up sinchClient ***/
    sinchClient = new SinchClient({
        applicationKey: 'abc57560-5dc2-4f98-a418-4b71e95f41da',
        capabilities: {calling: true, video: true},
        supportActiveConnection: true,
        //Note: For additional loging, please uncomment the three rows below
        onLogMessage: function(message) {
            console.log(message);
        }
    });
</script>