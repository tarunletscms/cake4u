<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; 
}

add_action( 'wp_head', 'bmw_base_name_information');
add_action( 'admin_head', 'bmw_base_name_information');
// register hook
add_action( 'wp_ajax_bmw_user_register', 'bmw_front_register_function' );
add_action( 'wp_ajax_nopriv_bmw_user_register', 'bmw_front_register_function' );
// register hook


// user name exist hook
add_action( 'wp_ajax_bmw_username_exist', 'bmw_username_exist_function' );
add_action( 'wp_ajax_nopriv_bmw_username_exist', 'bmw_username_exist_function' );
add_action( 'wp_ajax_select_payment_status_exist', 'select_payment_status_exist_function' );
// add_action( 'wp_ajax_nopriv_select_payment_status_exist', 'select_payment_status_exist_function' );

// user name exist hook

// user email exist hook
add_action( 'wp_ajax_bmw_email_exist', 'bmw_email_exist_function' );
add_action( 'wp_ajax_nopriv_bmw_email_exist', 'bmw_email_exist_function');
// user sponsor exist hook
add_action( 'wp_ajax_bmw_sponsor_exist', 'bmw_sponsor_exist_function' );
add_action( 'wp_ajax_nopriv_bmw_sponsor_exist', 'bmw_sponsor_exist_function');
// user parent exist hook
add_action( 'wp_ajax_bmw_parent_exist', 'bmw_parent_exist_function' );
add_action( 'wp_ajax_nopriv_bmw_parent_exist', 'bmw_parent_exist_function');

// user update hook
add_action( 'wp_ajax_bmw_update_epin', 'bmw_epin_update_function' );
add_action( 'wp_ajax_nopriv_bmw_update_epin', 'bmw_epin_update_function');

// user epin exist hook
add_action( 'wp_ajax_bmw_epin_exist', 'bmw_epin_exist_function' );
add_action( 'wp_ajax_nopriv_bmw_epin_exist', 'bmw_epin_exist_function' );
// user epin exist hook

add_action('wp_ajax_bmw_account_details_update','bmw_account_details_update_function');

//WITHDRAWAL REQUEST
add_action( 'wp_ajax_bmw_withdrwal_amount_request', 'bmw_withdrwal_amount_request_function' );

// user epin exist hook
add_action( 'wp_ajax_bmw_password_validation', 'bmw_password_validation_function' );
add_action( 'wp_ajax_nopriv_bmw_password_validation', 'bmw_password_validation_function' );

// login hook
add_action( 'wp_ajax_nopriv_bmw_login_form_hook', 'bmw_login_form_function' );
// login hook


add_action( 'wp_ajax_bmw_join_form_hook', 'bmw_front_join_network_function' );
// add_action( 'wp_ajax_nopriv_bmw_join_form_hook', 'bmw_front_join_network_function' );

//email check
add_action( 'wp_ajax_bmw_email_check', 'bmw_email_check_function' );
add_action( 'wp_ajax_nopriv_bmw_email_check', 'bmw_email_check_function'); 

// reset data hook

add_action( 'wp_ajax_bmw_admin_reset_data', 'bmw_admin_reset_data_function' );
add_action( 'wp_ajax_nopriv_bmw_admin_reset_data', 'bmw_admin_reset_data_function' );

//mail settings
add_action( 'wp_ajax_bmw_mail_settings', 'bmw_mail_settings_function' );
add_action( 'wp_ajax_nopriv_bmw_mail_settings', 'bmw_mail_settings_function' );

add_action( 'wp_ajax_bmw_mail_settings_withdrawal', 'bmw_mail_settings_withdrawal_function' );
add_action( 'wp_ajax_nopriv_bmw_mail_settings_withdrawal', 'bmw_mail_settings_withdrawal_function' );

add_action( 'wp_ajax_bmw_mail_settings_invitation', 'bmw_mail_settings_invitation_function' );
add_action( 'wp_ajax_nopriv_bmw_mail_settings_invitation', 'bmw_mail_settings_invitation_function' );

add_action( 'wp_ajax_bmw_message_center', 'bmw_message_center_function' );
add_action( 'wp_ajax_nopriv_bmw_message_center', 'bmw_message_center_function' );

add_action( 'wp_ajax_bmw_withdraw_data_update', 'bmw_withdraw_data_update_function' );
add_action( 'wp_ajax_nopriv_bmw_withdraw_data_update', 'bmw_withdraw_data_update_function' );

add_action( 'wp_ajax_bmw_distribute_commission', 'bmw_distribute_commission_function' );
add_action( 'wp_ajax_bmw_run_payout', 'bmw_run_payout_function' );


add_action( 'wp_ajax_bmw_update_profile_picture_hook', 'bmw_update_profile_picture_function' );
add_action( 'wp_ajax_nopriv_bmw_update_profile_picture_hook', 'bmw_update_profile_picture_function' );


add_action( 'wp_ajax_bmw_send_invitation_hook', 'bmw_send_invitation_hook_function' );


add_action( 'wp_ajax_bmw_mail_settings_post', 'bmw_mail_settings_post_function' );
add_action( 'wp_ajax_bmw_sms_settings_post', 'bmw_sms_settings_post_function' );

add_action( 'wp_ajax_bmw_install_addon', 'bmw_install_addon_function' );
add_action( 'wp_ajax_bmw_get_otp_action', 'bmw_get_otp_action_function' );
add_action( 'wp_ajax_nopriv_bmw_get_otp_action', 'bmw_get_otp_action_function' );

add_action( 'wp_ajax_bmw_verify_otp_action', 'bmw_verify_otp_action_function' );
add_action( 'wp_ajax_nopriv_bmw_verify_otp_action', 'bmw_verify_otp_action_function' );

add_action( 'bmw_after_user_payout_insert', 'bmw_after_user_payout_insert_function',2,10 );
add_action( 'bmw_after_user_payout_insert', 'bmw_send_payout_sms_function',2,20 );
add_action( 'bmw_after_withdrawal_init', 	'bmw_send_waithdrwal_init_sms_function',2,20 );
add_action( 'bmw_after_withdrawal_processed', 	'bmw_send_waithdrwal_process_sms_function',2,20 );

add_action( 'bmw_after_registration_action', 'bmw_register_mail_function',1,10 );
add_action( 'bmw_after_registration_action', 'bmw_register_sms_function',1,20 );
add_action( 'bmw_after_join_action', 'bmw_register_mail_function',1,10 );
