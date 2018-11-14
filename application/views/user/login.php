<script>
function open_window(url){
    var w = 880, h = 600,
        left = Number((screen.width/2)-(w/2)), tops = Number((screen.height/2)-(h/2)),
        popupWindow = window.open(url, '', 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=1, copyhistory=no, width='+w+', height='+h+', top='+tops+', left='+left);
    popupWindow.focus(); return false;
}
</script>
<div class="dd_main_wrapper">
    <div class="dd_auth_box_wrapper">
        <div class="container">
            <div class="dd_auth_box">
                <div class="dd_auth_image">
                    <a href="<?= base_url() ?>"><img src="<?= base_url($this->ts_functions->getsettings('login','img')) ?>" alt="" /></a>
                </div>
                <div class="dd_auth_form">
                    <div class="dd_auth_tab_wrapper">
                        <div class="dd_auth_tab_link">
                            <ul>
							   <?php if(isset($reset_password)){
								   echo '<li><a href="#reset_tab">'.$this->ts_functions->getlanguage( 'resetpassword', 'authentication', 'solo' ).'</a></li>';
							   }else{
								   echo '<li><a href="#signup_tab">'.$this->ts_functions->getlanguage('signup', 'authentication', 'solo' ).'</a></li>
                                   <li><a href="#login_tab">'.$this->ts_functions->getlanguage('login', 'authentication', 'solo' ).'</a></li>';
							   } ?>
                                
                            </ul>
                        </div>
                        <div class="dd_auth_tab_panel">
						 <?php if(isset($reset_password)){?>
						    <!-- Reset tab start -->
                            <div id="reset_tab" class="dd_tab_panel">
							<form id="reset_form">
                                <div class="dd_input_wrapper dd_input_icon">
                                    <input type="password" class="form-control" placeholder="<?php echo $this->ts_functions->getlanguage('logpwdtext', 'authentication', 'solo' ); ?>" id="users_pwd" name="users_pwd" />
                                    <span class="icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 482.8 482.8" style="enable-background:new 0 0 482.8 482.8;" xml:space="preserve" width="512px" height="512px"><g><g><path d="M395.95,210.4h-7.1v-62.9c0-81.3-66.1-147.5-147.5-147.5c-81.3,0-147.5,66.1-147.5,147.5c0,7.5,6,13.5,13.5,13.5 s13.5-6,13.5-13.5c0-66.4,54-120.5,120.5-120.5c66.4,0,120.5,54,120.5,120.5v62.9h-275c-14.4,0-26.1,11.7-26.1,26.1v168.1 c0,43.1,35.1,78.2,78.2,78.2h204.9c43.1,0,78.2-35.1,78.2-78.2V236.5C422.05,222.1,410.35,210.4,395.95,210.4z M395.05,404.6 c0,28.2-22.9,51.2-51.2,51.2h-204.8c-28.2,0-51.2-22.9-51.2-51.2V237.4h307.2L395.05,404.6L395.05,404.6z" fill="#909090"/><path d="M241.45,399.1c27.9,0,50.5-22.7,50.5-50.5c0-27.9-22.7-50.5-50.5-50.5c-27.9,0-50.5,22.7-50.5,50.5 S213.55,399.1,241.45,399.1z M241.45,325c13,0,23.5,10.6,23.5,23.5s-10.5,23.6-23.5,23.6s-23.5-10.6-23.5-23.5 S228.45,325,241.45,325z" fill="#909090"/></g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>
                                    </span>
                                </div>
                                <div class="dd_input_wrapper dd_input_icon">
                                    <input type="password" class="form-control" placeholder="<?php echo $this->ts_functions->getlanguage('logconfirmpwdtext', 'authentication', 'solo' ); ?>"  id="users_repwd" name="users_repwd"/>
                                    <span class="icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 482.8 482.8" style="enable-background:new 0 0 482.8 482.8;" xml:space="preserve" width="512px" height="512px"><g><g><path d="M395.95,210.4h-7.1v-62.9c0-81.3-66.1-147.5-147.5-147.5c-81.3,0-147.5,66.1-147.5,147.5c0,7.5,6,13.5,13.5,13.5 s13.5-6,13.5-13.5c0-66.4,54-120.5,120.5-120.5c66.4,0,120.5,54,120.5,120.5v62.9h-275c-14.4,0-26.1,11.7-26.1,26.1v168.1 c0,43.1,35.1,78.2,78.2,78.2h204.9c43.1,0,78.2-35.1,78.2-78.2V236.5C422.05,222.1,410.35,210.4,395.95,210.4z M395.05,404.6 c0,28.2-22.9,51.2-51.2,51.2h-204.8c-28.2,0-51.2-22.9-51.2-51.2V237.4h307.2L395.05,404.6L395.05,404.6z" fill="#909090"/><path d="M241.45,399.1c27.9,0,50.5-22.7,50.5-50.5c0-27.9-22.7-50.5-50.5-50.5c-27.9,0-50.5,22.7-50.5,50.5 S213.55,399.1,241.45,399.1z M241.45,325c13,0,23.5,10.6,23.5,23.5s-10.5,23.6-23.5,23.6s-23.5-10.6-23.5-23.5 S228.45,325,241.45,325z" fill="#909090"/></g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>
                                    </span>
                                </div>

                                <div class="dd_input_wrapper">
								 <input type="hidden" id="user_key" value="<?php echo $pwdKey; ?>">
                                    <a class="dd_btn dd_btn_block target-submit" button-type="reset_password" ><?php echo $this->ts_functions->getlanguage('submittext', 'authentication', 'solo' ); ?></a>	
                                </div>
                                <?php  if( $this->ts_functions->getsettings('google','status') == '1' ) { ?>
								
                                <div class="dd_input_wrapper">
                                    <div class="dd_ORdivider">
                                        <span><?php echo $this->ts_functions->getlanguage('or', 'authentication', 'solo' ); ?></span>
                                    </div>
                                </div>

                                 <div class="dd_input_wrapper">
                                    <div class="dd_auth_social">
                                        <a  onclick="open_window('<?php echo base_url();?>authentication/googlelogin');" class="google"><img src="<?= base_url('assets/user/images/google.svg') ?>" alt=""></a>
                                    </div>
                                </div>
								<?php } ?>
                              </form>
                            </div>
                            <!-- Reset tab end -->
						 <?php }else{ ?>
							
                            <!-- signup tab start -->
                            <div id="signup_tab" class="dd_tab_panel">
							<form id="signup_form">
                                <div class="dd_input_wrapper dd_input_icon">
                                    <input type="text" class="form-control" placeholder="<?php echo $this->ts_functions->getlanguage('logusernametext', 'authentication', 'solo' ); ?>" id="user_name"/>
                                    <span class="icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 482.9 482.9" style="enable-background:new 0 0 482.9 482.9;" xml:space="preserve" width="512px" height="512px"><g><g><path d="M239.7,260.2c0.5,0,1,0,1.6,0c0.2,0,0.4,0,0.6,0c0.3,0,0.7,0,1,0c29.3-0.5,53-10.8,70.5-30.5 c38.5-43.4,32.1-117.8,31.4-124.9c-2.5-53.3-27.7-78.8-48.5-90.7C280.8,5.2,262.7,0.4,242.5,0h-0.7c-0.1,0-0.3,0-0.4,0h-0.6 c-11.1,0-32.9,1.8-53.8,13.7c-21,11.9-46.6,37.4-49.1,91.1c-0.7,7.1-7.1,81.5,31.4,124.9C186.7,249.4,210.4,259.7,239.7,260.2z M164.6,107.3c0-0.3,0.1-0.6,0.1-0.8c3.3-71.7,54.2-79.4,76-79.4h0.4c0.2,0,0.5,0,0.8,0c27,0.6,72.9,11.6,76,79.4 c0,0.3,0,0.6,0.1,0.8c0.1,0.7,7.1,68.7-24.7,104.5c-12.6,14.2-29.4,21.2-51.5,21.4c-0.2,0-0.3,0-0.5,0l0,0c-0.2,0-0.3,0-0.5,0 c-22-0.2-38.9-7.2-51.4-21.4C157.7,176.2,164.5,107.9,164.6,107.3z" fill="#909090"/><path d="M446.8,383.6c0-0.1,0-0.2,0-0.3c0-0.8-0.1-1.6-0.1-2.5c-0.6-19.8-1.9-66.1-45.3-80.9c-0.3-0.1-0.7-0.2-1-0.3 c-45.1-11.5-82.6-37.5-83-37.8c-6.1-4.3-14.5-2.8-18.8,3.3c-4.3,6.1-2.8,14.5,3.3,18.8c1.7,1.2,41.5,28.9,91.3,41.7 c23.3,8.3,25.9,33.2,26.6,56c0,0.9,0,1.7,0.1,2.5c0.1,9-0.5,22.9-2.1,30.9c-16.2,9.2-79.7,41-176.3,41 c-96.2,0-160.1-31.9-176.4-41.1c-1.6-8-2.3-21.9-2.1-30.9c0-0.8,0.1-1.6,0.1-2.5c0.7-22.8,3.3-47.7,26.6-56 c49.8-12.8,89.6-40.6,91.3-41.7c6.1-4.3,7.6-12.7,3.3-18.8c-4.3-6.1-12.7-7.6-18.8-3.3c-0.4,0.3-37.7,26.3-83,37.8 c-0.4,0.1-0.7,0.2-1,0.3c-43.4,14.9-44.7,61.2-45.3,80.9c0,0.9,0,1.7-0.1,2.5c0,0.1,0,0.2,0,0.3c-0.1,5.2-0.2,31.9,5.1,45.3 c1,2.6,2.8,4.8,5.2,6.3c3,2,74.9,47.8,195.2,47.8s192.2-45.9,195.2-47.8c2.3-1.5,4.2-3.7,5.2-6.3 C447,415.5,446.9,388.8,446.8,383.6z" fill="#909090"/></g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>
                                    </span>
                                </div>
                                <div class="dd_input_wrapper dd_input_icon">
                                    <input type="text" class="form-control" placeholder="<?php echo $this->ts_functions->getlanguage('logemailtext', 'authentication', 'solo' ); ?>" id="user_emails" />
                                    <span class="icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 483.3 483.3" style="enable-background:new 0 0 483.3 483.3;" xml:space="preserve" width="512px" height="512px"><g><g><path d="M424.3,57.75H59.1c-32.6,0-59.1,26.5-59.1,59.1v249.6c0,32.6,26.5,59.1,59.1,59.1h365.1c32.6,0,59.1-26.5,59.1-59.1 v-249.5C483.4,84.35,456.9,57.75,424.3,57.75z M456.4,366.45c0,17.7-14.4,32.1-32.1,32.1H59.1c-17.7,0-32.1-14.4-32.1-32.1v-249.5 c0-17.7,14.4-32.1,32.1-32.1h365.1c17.7,0,32.1,14.4,32.1,32.1v249.5H456.4z" fill="#909090"/><path d="M304.8,238.55l118.2-106c5.5-5,6-13.5,1-19.1c-5-5.5-13.5-6-19.1-1l-163,146.3l-31.8-28.4c-0.1-0.1-0.2-0.2-0.2-0.3 c-0.7-0.7-1.4-1.3-2.2-1.9L78.3,112.35c-5.6-5-14.1-4.5-19.1,1.1c-5,5.6-4.5,14.1,1.1,19.1l119.6,106.9L60.8,350.95 c-5.4,5.1-5.7,13.6-0.6,19.1c2.7,2.8,6.3,4.3,9.9,4.3c3.3,0,6.6-1.2,9.2-3.6l120.9-113.1l32.8,29.3c2.6,2.3,5.8,3.4,9,3.4 c3.2,0,6.5-1.2,9-3.5l33.7-30.2l120.2,114.2c2.6,2.5,6,3.7,9.3,3.7c3.6,0,7.1-1.4,9.8-4.2c5.1-5.4,4.9-14-0.5-19.1L304.8,238.55z" fill="#909090"/></g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>
                                    </span>
                                </div>
                                <div class="dd_input_wrapper dd_input_icon">
                                    <input type="password" class="form-control" placeholder="<?php echo $this->ts_functions->getlanguage('logpwdtext', 'authentication', 'solo' ); ?>" id="user_passs" />
                                    <span class="icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 482.8 482.8" style="enable-background:new 0 0 482.8 482.8;" xml:space="preserve" width="512px" height="512px"><g><g><path d="M395.95,210.4h-7.1v-62.9c0-81.3-66.1-147.5-147.5-147.5c-81.3,0-147.5,66.1-147.5,147.5c0,7.5,6,13.5,13.5,13.5 s13.5-6,13.5-13.5c0-66.4,54-120.5,120.5-120.5c66.4,0,120.5,54,120.5,120.5v62.9h-275c-14.4,0-26.1,11.7-26.1,26.1v168.1 c0,43.1,35.1,78.2,78.2,78.2h204.9c43.1,0,78.2-35.1,78.2-78.2V236.5C422.05,222.1,410.35,210.4,395.95,210.4z M395.05,404.6 c0,28.2-22.9,51.2-51.2,51.2h-204.8c-28.2,0-51.2-22.9-51.2-51.2V237.4h307.2L395.05,404.6L395.05,404.6z" fill="#909090"/><path d="M241.45,399.1c27.9,0,50.5-22.7,50.5-50.5c0-27.9-22.7-50.5-50.5-50.5c-27.9,0-50.5,22.7-50.5,50.5 S213.55,399.1,241.45,399.1z M241.45,325c13,0,23.5,10.6,23.5,23.5s-10.5,23.6-23.5,23.6s-23.5-10.6-23.5-23.5 S228.45,325,241.45,325z" fill="#909090"/></g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>
                                    </span>
                                </div>
                                <div class="dd_input_wrapper dd_input_icon">
                                    <input type="password" class="form-control" placeholder="<?php echo $this->ts_functions->getlanguage('logconfirmpwdtext', 'authentication', 'solo' ); ?>"  id="user_cpass"/>
                                    <span class="icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 482.8 482.8" style="enable-background:new 0 0 482.8 482.8;" xml:space="preserve" width="512px" height="512px"><g><g><path d="M395.95,210.4h-7.1v-62.9c0-81.3-66.1-147.5-147.5-147.5c-81.3,0-147.5,66.1-147.5,147.5c0,7.5,6,13.5,13.5,13.5 s13.5-6,13.5-13.5c0-66.4,54-120.5,120.5-120.5c66.4,0,120.5,54,120.5,120.5v62.9h-275c-14.4,0-26.1,11.7-26.1,26.1v168.1 c0,43.1,35.1,78.2,78.2,78.2h204.9c43.1,0,78.2-35.1,78.2-78.2V236.5C422.05,222.1,410.35,210.4,395.95,210.4z M395.05,404.6 c0,28.2-22.9,51.2-51.2,51.2h-204.8c-28.2,0-51.2-22.9-51.2-51.2V237.4h307.2L395.05,404.6L395.05,404.6z" fill="#909090"/><path d="M241.45,399.1c27.9,0,50.5-22.7,50.5-50.5c0-27.9-22.7-50.5-50.5-50.5c-27.9,0-50.5,22.7-50.5,50.5 S213.55,399.1,241.45,399.1z M241.45,325c13,0,23.5,10.6,23.5,23.5s-10.5,23.6-23.5,23.6s-23.5-10.6-23.5-23.5 S228.45,325,241.45,325z" fill="#909090"/></g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>
                                    </span>
                                </div>

                                <div class="dd_input_wrapper">
                                    <a class="dd_btn dd_btn_block target-submit" button-type="signup" ><?php echo $this->ts_functions->getlanguage('submittext', 'authentication', 'solo' ); ?></a>	
                                </div>
                                
                                <?php  if( $this->ts_functions->getsettings('google','status') == '1' ) { ?>
								
                                <div class="dd_input_wrapper">
                                    <div class="dd_ORdivider">
                                        <span><?php echo $this->ts_functions->getlanguage('or', 'authentication', 'solo' ); ?></span>
                                    </div>
                                </div>

                                 <div class="dd_input_wrapper">
                                    <div class="dd_auth_social">
                                        <a  onclick="open_window('<?php echo base_url();?>authentication/googlelogin');" class="google"><img src="<?= base_url('assets/user/images/google.svg') ?>" alt=""></a>
                                    </div>
                                </div>
								<?php } ?>
                              </form>
                            </div>
                            <!-- signup tab end -->

                            <!-- login tab start -->
                            <div id="login_tab" class="dd_tab_panel">
							<form id="login_form">
                                <div class="dd_input_wrapper dd_input_icon">
                                    <input type="text" class="form-control require" placeholder="<?php echo $this->ts_functions->getlanguage('logemailtext', 'authentication', 'solo' ); ?>" id="user_email" />
                                    <span class="icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 482.9 482.9" style="enable-background:new 0 0 482.9 482.9;" xml:space="preserve" width="512px" height="512px"><g><g><path d="M239.7,260.2c0.5,0,1,0,1.6,0c0.2,0,0.4,0,0.6,0c0.3,0,0.7,0,1,0c29.3-0.5,53-10.8,70.5-30.5 c38.5-43.4,32.1-117.8,31.4-124.9c-2.5-53.3-27.7-78.8-48.5-90.7C280.8,5.2,262.7,0.4,242.5,0h-0.7c-0.1,0-0.3,0-0.4,0h-0.6 c-11.1,0-32.9,1.8-53.8,13.7c-21,11.9-46.6,37.4-49.1,91.1c-0.7,7.1-7.1,81.5,31.4,124.9C186.7,249.4,210.4,259.7,239.7,260.2z M164.6,107.3c0-0.3,0.1-0.6,0.1-0.8c3.3-71.7,54.2-79.4,76-79.4h0.4c0.2,0,0.5,0,0.8,0c27,0.6,72.9,11.6,76,79.4 c0,0.3,0,0.6,0.1,0.8c0.1,0.7,7.1,68.7-24.7,104.5c-12.6,14.2-29.4,21.2-51.5,21.4c-0.2,0-0.3,0-0.5,0l0,0c-0.2,0-0.3,0-0.5,0 c-22-0.2-38.9-7.2-51.4-21.4C157.7,176.2,164.5,107.9,164.6,107.3z" fill="#909090"/><path d="M446.8,383.6c0-0.1,0-0.2,0-0.3c0-0.8-0.1-1.6-0.1-2.5c-0.6-19.8-1.9-66.1-45.3-80.9c-0.3-0.1-0.7-0.2-1-0.3 c-45.1-11.5-82.6-37.5-83-37.8c-6.1-4.3-14.5-2.8-18.8,3.3c-4.3,6.1-2.8,14.5,3.3,18.8c1.7,1.2,41.5,28.9,91.3,41.7 c23.3,8.3,25.9,33.2,26.6,56c0,0.9,0,1.7,0.1,2.5c0.1,9-0.5,22.9-2.1,30.9c-16.2,9.2-79.7,41-176.3,41 c-96.2,0-160.1-31.9-176.4-41.1c-1.6-8-2.3-21.9-2.1-30.9c0-0.8,0.1-1.6,0.1-2.5c0.7-22.8,3.3-47.7,26.6-56 c49.8-12.8,89.6-40.6,91.3-41.7c6.1-4.3,7.6-12.7,3.3-18.8c-4.3-6.1-12.7-7.6-18.8-3.3c-0.4,0.3-37.7,26.3-83,37.8 c-0.4,0.1-0.7,0.2-1,0.3c-43.4,14.9-44.7,61.2-45.3,80.9c0,0.9,0,1.7-0.1,2.5c0,0.1,0,0.2,0,0.3c-0.1,5.2-0.2,31.9,5.1,45.3 c1,2.6,2.8,4.8,5.2,6.3c3,2,74.9,47.8,195.2,47.8s192.2-45.9,195.2-47.8c2.3-1.5,4.2-3.7,5.2-6.3 C447,415.5,446.9,388.8,446.8,383.6z" fill="#909090"/></g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>
                                    </span>
                                </div>
                                <div class="dd_input_wrapper dd_input_icon margin-bottom-10">
                                    <input type="password" class="form-control require" placeholder="<?php echo $this->ts_functions->getlanguage('logpwdtext', 'authentication', 'solo' ); ?>" id="user_pass"/>
									
                                    <span class="icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 482.8 482.8" style="enable-background:new 0 0 482.8 482.8;" xml:space="preserve" width="512px" height="512px"><g><g><path d="M395.95,210.4h-7.1v-62.9c0-81.3-66.1-147.5-147.5-147.5c-81.3,0-147.5,66.1-147.5,147.5c0,7.5,6,13.5,13.5,13.5 s13.5-6,13.5-13.5c0-66.4,54-120.5,120.5-120.5c66.4,0,120.5,54,120.5,120.5v62.9h-275c-14.4,0-26.1,11.7-26.1,26.1v168.1 c0,43.1,35.1,78.2,78.2,78.2h204.9c43.1,0,78.2-35.1,78.2-78.2V236.5C422.05,222.1,410.35,210.4,395.95,210.4z M395.05,404.6 c0,28.2-22.9,51.2-51.2,51.2h-204.8c-28.2,0-51.2-22.9-51.2-51.2V237.4h307.2L395.05,404.6L395.05,404.6z" fill="#909090"/><path d="M241.45,399.1c27.9,0,50.5-22.7,50.5-50.5c0-27.9-22.7-50.5-50.5-50.5c-27.9,0-50.5,22.7-50.5,50.5 S213.55,399.1,241.45,399.1z M241.45,325c13,0,23.5,10.6,23.5,23.5s-10.5,23.6-23.5,23.6s-23.5-10.6-23.5-23.5 S228.45,325,241.45,325z" fill="#909090"/></g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>
                                    </span>
                                </div>
								<div class="dd_input_wrapper text-right">
                                    <a href="#dd_forgot_password" class="forgot_password dd_popup_link"><?php echo $this->ts_functions->getlanguage('logforgotpwdtext', 'authentication', 'solo' ); ?></a>
                                </div>
                                <div class="dd_input_wrapper">
                                    <a  button-type="login" data-target="login-form" class="dd_btn dd_btn_block dd_login target-submit"><?php echo $this->ts_functions->getlanguage('submittext', 'authentication', 'solo' ); ?></a>	
                                </div>
                                
                                 <?php  if( $this->ts_functions->getsettings('google','status') == '1' ) { ?>
								
                                <div class="dd_input_wrapper">
                                    <div class="dd_ORdivider">
                                        <span><?php echo $this->ts_functions->getlanguage('or', 'authentication', 'solo' ); ?></span>
                                    </div>
                                </div>

                                 <div class="dd_input_wrapper">
                                    <div class="dd_auth_social">
                                        <a  onclick="open_window('<?php echo base_url();?>authentication/googlelogin');" class="google"><img src="<?= base_url('assets/user/images/google.svg') ?>" alt=""></a>
                                    </div>
                                </div>
								<?php } ?>
							</form>	
                            </div>
                            <!-- login tab end -->
						 <?php } ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Forgot Password popup start -->
<div id="dd_forgot_password" class="dd_popup_wrapper">
    <div class="dd_popup_close"></div>
    <div class="dd_popup_inner">
        <div class="dd_popup_header">
            <h3><?php echo $this->ts_functions->getlanguage('logforgotpwdtext', 'authentication', 'solo' ); ?></h3>
            <span class="icon"> 
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="66px" height="67px"><path fill-rule="evenodd" fill="#1bcbd5" d="M32.815,66.188 C14.747,66.188 0.046,51.490 0.046,33.423 C0.046,15.356 14.747,0.659 32.815,0.659 C50.885,0.659 65.585,15.357 65.585,33.424 C65.585,51.492 50.885,66.188 32.815,66.188 ZM32.815,3.182 C16.137,3.182 2.569,16.748 2.569,33.424 C2.569,50.099 16.137,63.666 32.815,63.666 C49.492,63.666 63.061,50.099 63.061,33.424 C63.061,16.748 49.494,3.182 32.815,3.182 ZM40.424,19.763 C38.332,19.763 36.637,21.457 36.637,23.550 C36.637,25.640 38.333,27.337 40.424,27.337 C42.516,27.337 44.212,25.640 44.212,23.550 C44.212,21.457 42.516,19.763 40.424,19.763 ZM24.652,19.763 C22.560,19.763 20.865,21.457 20.865,23.550 C20.865,25.640 22.561,27.337 24.652,27.337 C26.744,27.337 28.440,25.640 28.440,23.550 C28.440,21.457 26.746,19.763 24.652,19.763 ZM49.091,42.548 C49.867,41.848 49.926,40.651 49.226,39.875 C48.523,39.102 47.328,39.042 46.552,39.740 C42.796,43.135 37.937,45.003 32.872,45.003 C27.789,45.003 22.918,43.126 19.158,39.713 C18.387,39.011 17.187,39.067 16.485,39.842 C15.781,40.616 15.841,41.814 16.615,42.515 C21.073,46.561 26.847,48.789 32.873,48.789 C38.876,48.787 44.638,46.573 49.091,42.548 Z"/></svg>
            </span>
        </div>
        <div class="dd_popup_body">
		<form id="forget_form">
            <div class="dd_input_wrapper dd_input_icon">
                <input type="text" class="form-control" placeholder="<?php echo $this->ts_functions->getlanguage('fgpwdinputtext', 'authentication', 'solo' ); ?>" id="forget_email" />
                <span class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 483.3 483.3" style="enable-background:new 0 0 483.3 483.3;" xml:space="preserve" width="512px" height="512px"><g><g><path d="M424.3,57.75H59.1c-32.6,0-59.1,26.5-59.1,59.1v249.6c0,32.6,26.5,59.1,59.1,59.1h365.1c32.6,0,59.1-26.5,59.1-59.1 v-249.5C483.4,84.35,456.9,57.75,424.3,57.75z M456.4,366.45c0,17.7-14.4,32.1-32.1,32.1H59.1c-17.7,0-32.1-14.4-32.1-32.1v-249.5 c0-17.7,14.4-32.1,32.1-32.1h365.1c17.7,0,32.1,14.4,32.1,32.1v249.5H456.4z" fill="#909090"></path><path d="M304.8,238.55l118.2-106c5.5-5,6-13.5,1-19.1c-5-5.5-13.5-6-19.1-1l-163,146.3l-31.8-28.4c-0.1-0.1-0.2-0.2-0.2-0.3 c-0.7-0.7-1.4-1.3-2.2-1.9L78.3,112.35c-5.6-5-14.1-4.5-19.1,1.1c-5,5.6-4.5,14.1,1.1,19.1l119.6,106.9L60.8,350.95 c-5.4,5.1-5.7,13.6-0.6,19.1c2.7,2.8,6.3,4.3,9.9,4.3c3.3,0,6.6-1.2,9.2-3.6l120.9-113.1l32.8,29.3c2.6,2.3,5.8,3.4,9,3.4 c3.2,0,6.5-1.2,9-3.5l33.7-30.2l120.2,114.2c2.6,2.5,6,3.7,9.3,3.7c3.6,0,7.1-1.4,9.8-4.2c5.1-5.4,4.9-14-0.5-19.1L304.8,238.55z" fill="#909090"></path></g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>
                </span>
            </div>
            <div class="dd_input_wrapper">
				<a  button-type="forget_pass"  class="dd_btn dd_btn_block target-submit"><?php echo $this->ts_functions->getlanguage('submittext', 'authentication', 'solo' ); ?></a>	
            </div>
		 </form>	
        </div>
    </div>
</div>
<!-- Forgot Password popup end -->