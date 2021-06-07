<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'BMW_ADDONS', false ) ) :

	class BMW_ADDONS {

		public static function bmw_addons_function(){
			do_action('bmw_addons_installable_template');
		}
		public static function bmw_myCred_function(){
			include_once BMW_ABSPATH . 'includes/admin/settings/view/view_mycred_settings.php';
			BMW_MYCRED_SETTINGS::bmw_mycred_settings_function();
		}
		public static function bmw_woowallet_function(){
			include_once BMW_ABSPATH . 'includes/admin/settings/view/view_woo_wallet_settings.php';
			BMW_WOO_WALLET_SETTINGS::bmw_woo_wallet_settings_function();
		}
	}
endif;