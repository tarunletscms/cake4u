<?php
/**
 * @package  
 * @version  3.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'BMW_MAIL_SEND', false ) ) :

	class BMW_MAIL_SEND {
		
	public static  function bmw_get_mail_send_form(){

		global $wpdb;
		  if(is_lic_validate()){
		$args = array(
			    'role'    => 'bmw_user',
			    'orderby' => 'user_nicename',
			    'order'   => 'ASC'
			);
		$users = get_users( $args );
		$post_link=admin_url('admin-ajax.php');
		?>
		 <div class="let-col-md-12 let-col-sm-12 ">
              <div class="let-x_panel">
                <div class="let-x_title">
                  <h2><?php _e('Mail center','BMW');?> </h2>
                  <ul class="let-nav let-navbar-right let-panel_toolbox">
                    <li><a class="let-collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                    <li><a class="let-close-link"><i class="fa fa-close"></i></a>
                    </li>
                  </ul>
                  <div class="let-clearfix"></div>
                </div>
                <div class="let-x_content">
        			<form method="POST" action="">
        			
					<div class="let-col-md-6 let-offset-md-3 let-col-xs-12">
						<div class="let-col-md-12 let-m-2">
						<label for="message_center_to"><?php echo __('To','BMW');?></label>
						<select class="let-form-control let-rounded-0" name="message_center_to" id="message_center_to">
							<?php if(isset($users)) {foreach($users as $user){?>
							<option value="<?php echo $user->user_email;?>"><?php echo $user->user_nicename;?></option><?php } }?>
							</select>
						<span class="m_c_to let-text-danger" id="err_m_c_to"></span>
						</div>
						<div class="let-col-md-12 let-m-2">
							<label for="message_center_subject"><?php echo __('Subject','BMW');?></label>
						<input type="text" name="message_center_subject" id="message_center_subject" placeholder="<?php echo __('Type Subject...','BMW');?>" value="" class="let-form-control let-rounded-0">
						<span class="m_c_subject let-text-danger" id="err_m_c_subject"></span>
						</div>
						<div class="let-col-md-12 let-m-2">
						<label for="message_center_message"><?php echo __('Message','BMW');?></label>
						<textarea placeholder="<?php _e('Type Message Body','BMW');?>" class="let-form-control let-rounded-0" id="message_center_message" cols="" rows="10"></textarea>
						<span class="m_c_message let-text-danger" id="err_m_c_message"></span>
						<span class="mail-message-success let-text-success"></span>
						</div>
					<div class="let-col-md-12 let-text-center let-m-3">
						<button type="button" class="let-btn let-btn-success let-rounded-0" onclick="message_center_post('<?php echo $post_link;?>');"><?php echo __('Send','BMW');?></button>
					</div>    				
						</div>
        			</form>
					</div>
        		</div>
</div>
<?php

	} }
}
endif;