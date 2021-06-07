<?php


if ( !defined( 'ABSPATH' ) || !defined( 'BMW_ABSPATH') ) {
	exit; 
}
/**
 * BMW_ADMIN_MENU Class.
 */
 Class BMW_ADMIN_MENU {

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'admin_menu' ), 9 );
		add_action( 'admin_menu', array( $this, 'settings_menu' ), 50 );

	}


	public function admin_menu()
	{
		global $menu;

		if ( current_user_can( 'manage_bmw' ) ) {
			$menu[] = array( '', 'read', 'separator-bmw', '', 'wp-menu-separator bmw' ); 
		}
		$icon_url = BMW()->plugin_url() . '/image/mlm_tree.png';
		add_menu_page( __( 'Binary MLM WooCommerce', 'BMW' ), __( 'Binary MLM WooCommerce', 'BMW' ), 'manage_bmw', 'bmw-settings', null, $icon_url, '56.5' );
		add_submenu_page('bmw-settings',__('Binary MLM WooCommerce', 'BMW' ), __( 'Binary MLM WooCommerce', 'BMW' ), 'manage_bmw', 'bmw-settings', null, null, '56.5' );

	}

	public function settings_menu() { 
		
		$settings_page = add_submenu_page( 'BMW', __( 'Binary MLM WooCommerce', 'BMW' ), __( 'Settings', 'BMW' ), 'manage_bmw', 'bmw-settings', array( $this, 'settings_page' ) );

		add_submenu_page( 'bmw-settings', __( 'User Reports', 'BMW' ), __( 'User Reports', 'BMW' ), 'manage_bmw', 'bmw-user-reports', array( $this, 'bmw_user_reports' ) );

		add_submenu_page( 'bmw-settings', __( 'payout Reports', 'BMW' ), __( 'payout Reports', 'BMW' ), 'manage_bmw', 'bmw-payout-reports', array( $this, 'bmw_payout_reports' ) );

		add_submenu_page( 'bmw-settings', __( 'Withdrawal Records', 'BMW' ), __( 'Withdrawal Records', 'BMW' ), 'manage_bmw', 'bmw-withdrawal-records', array( $this, 'bmw_withdrawal_records' ) );

		add_submenu_page( 'bmw-settings', __( 'Geneology', 'BMW' ), __( 'Geneology', 'BMW' ), 'manage_bmw', 'bmw-geneology', array( $this, 'bmw_geneology' ) );

		add_submenu_page( 'bmw-settings', __( 'Message Center', 'BMW' ), __( 'Message Center', 'BMW' ), 'manage_bmw', 'bmw-message-center', array( $this, 'bmw_message_center' ) );

		add_submenu_page( 'bmw-settings', __( 'Mail Settings', 'BMW' ), __( 'Mail Settings', 'BMW' ), 'manage_bmw', 'bmw-mail-settings', array( $this, 'bmw_mail_settings' ) );

		add_submenu_page( 'bmw-settings', __( 'SMS Settings', 'BMW' ), __( 'SMS Settings', 'BMW' ), 'manage_bmw', 'bmw-sms-settings', array( $this, 'bmw_sms_settings' ) );
	
		add_submenu_page( 'bmw-settings', __( 'Reset Data', 'BMW' ), __( 'Reset Data', 'BMW' ), 'manage_bmw', 'bmw-reset-data', array( $this, 'bmw_reset_data' ) );

	}

	public function bmw_user_reports(){
		if(!empty(first_user_created())){
		include_once BMW_ABSPATH . 'includes/admin/CLASS-bmw-users.php';
		bmw_admin_style_enque();
		bmw_dataTable_enque();
		BMW_USERS_REPORT::bmw_get_users_reports();
	}else{
		include_once BMW_ABSPATH . 'includes/admin/CLASS-bmw-settings.php';
		bmw_admin_style_enque();
		bmw_icheck_enque();
		BMW_ADMIN_SETTINGS::bmw_get_settings_pages();
	}
}
	public function bmw_geneology(){
		if(first_user_created()==true){
		include_once BMW_ABSPATH . 'includes/admin/CLASS-bmw-geneology.php';
		bmw_admin_style_enque();
		enque_genealogy_scripts();
		BMW_GENEALOGY::bmw_get_geneology();
		}else{
		include_once BMW_ABSPATH . 'includes/admin/CLASS-bmw-settings.php';
		bmw_admin_style_enque();
		bmw_icheck_enque();
		BMW_ADMIN_SETTINGS::bmw_get_settings_pages();
	}
	}
	public function bmw_payout_reports(){
		if(first_user_created()==true){
		include_once BMW_ABSPATH . 'includes/admin/CLASS-bmw-payouts.php';
		bmw_admin_style_enque();
		bmw_dataTable_enque();
		BMW_PAYOUT_REPORTS::bmw_get_payout_reports();
		}else{
		include_once BMW_ABSPATH . 'includes/admin/CLASS-bmw-settings.php';
		bmw_admin_style_enque();
		bmw_icheck_enque();
		BMW_ADMIN_SETTINGS::bmw_get_settings_pages();
	}

	}
	public function bmw_withdrawal_records(){
		if(first_user_created()==true){
		include_once BMW_ABSPATH . 'includes/admin/CLASS-bmw-withdrawals.php';
		bmw_admin_style_enque();
		bmw_dataTable_enque();
		BMW_WITHDRAWAL_RECORDS::bmw_get_withdrawal_records();
		}else{
		include_once BMW_ABSPATH . 'includes/admin/CLASS-bmw-settings.php';
		bmw_admin_style_enque();
		bmw_icheck_enque();
		BMW_ADMIN_SETTINGS::bmw_get_settings_pages();
	}

	}	
	public function bmw_message_center(){
		if(first_user_created()==true){
		include_once BMW_ABSPATH . 'includes/admin/CLASS-bmw-mail-send.php';
		bmw_admin_style_enque();
		BMW_MAIL_SEND::bmw_get_mail_send_form();
		}else{
		include_once BMW_ABSPATH . 'includes/admin/CLASS-bmw-settings.php';
		bmw_admin_style_enque();
		bmw_icheck_enque();
		BMW_ADMIN_SETTINGS::bmw_get_settings_pages();
	}

	}
	public function bmw_mail_settings(){
		if(first_user_created()==true){
		include_once BMW_ABSPATH . 'includes/admin/CLASS-bmw-mail-settings.php';
		bmw_admin_style_enque();
		bmw_text_editor_enque();
		BMW_MAIL_SETTINGS::bmw_get_mail_settings();
		}else{
		include_once BMW_ABSPATH . 'includes/admin/CLASS-bmw-settings.php';
		bmw_admin_style_enque();
		bmw_icheck_enque();
		BMW_ADMIN_SETTINGS::bmw_get_settings_pages();
	}

	}
	public function bmw_sms_settings(){

		if(first_user_created()==true){
		include_once BMW_ABSPATH . 'includes/admin/CLASS-bmw-sms-settings.php';
		bmw_admin_style_enque();
		bmw_text_editor_enque();
		BMW_SMS_SETTINGS::bmw_get_sms_settings();
		}else{
		include_once BMW_ABSPATH . 'includes/admin/CLASS-bmw-settings.php';
		bmw_admin_style_enque();
		bmw_icheck_enque();
		BMW_ADMIN_SETTINGS::bmw_get_settings_pages();
	}

	}
	public function bmw_reset_data(){
		if(first_user_created()==true){
		include_once BMW_ABSPATH . 'includes/admin/CLASS-bmw-reset.php';
		bmw_admin_style_enque();
		bmw_text_editor_enque();
		BMW_RESET_DATA::bmw_get_reset_data();
		}else{
		include_once BMW_ABSPATH . 'includes/admin/CLASS-bmw-settings.php';
		bmw_admin_style_enque();
		bmw_icheck_enque();
		BMW_ADMIN_SETTINGS::bmw_get_settings_pages();
	}

	}
	public function settings_page() {
		include_once BMW_ABSPATH . 'includes/admin/CLASS-bmw-settings.php';
		bmw_admin_style_enque();
		bmw_icheck_enque();
		BMW_ADMIN_SETTINGS::bmw_get_settings_pages();
	}

}
