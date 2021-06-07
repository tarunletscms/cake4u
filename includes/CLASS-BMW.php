<?php
/**
 * BMW setup
 *
 * @package BMW
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; 
}
include_once( ABSPATH . 'wp-admin/includes/plugin.php' ); 
/**
 * Main BMW Class.
 *
 * @class BMP
 */
final class BMW {

	public $version = '2.0.0';

	protected static $_instance = null;
	
	
	public static function instance() {
		if (is_plugin_active( 'woocommerce/woocommerce.php' ) ) { 
			if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
			}
		return self::$_instance;
		}else { 
		echo __("Before activating Binary MLM WooCommerce, Please activate WooCommerce plugin.","BMW"); exit;
		}
	}
	

	public function __construct() {
		$this->define_constants();
		$this->includes();
		$this->init_hooks();
		$this->bmw_load_menus();
		do_action( 'bmw_loaded');

	}


	private function init_hooks() {
		register_activation_hook( BMW_PLUGIN_FILE, array( 'BMW_INSTALL', 'install' ) );
		add_action( 'init', array( $this, 'init' ), 0 );
		register_deactivation_hook( BMW_PLUGIN_FILE, array( 'BMW_UNINSTALL', 'uninstall' ) );
		register_uninstall_hook( BMW_PLUGIN_FILE, 'uninstall' );	


	}


	public function init() { 
		global $wpdb;
		BMW_INSTALL::insert_table_data();
		$this->load_plugin_textdomain();
		if( !session_id() )
	  	{ 
	    	session_start();
	  	}	
	 		add_filter( 'plugin_row_meta', array( $this, 'bmw_plugin_row_meta' ), 10, 2 );
	 		$mapping = get_option('bmw_manage_general'); 
			$success_mapping = $mapping['bmw_order_success_status']; 
			if(isset($success_mapping)){		
			$success_mapping_status = 'wc-' === substr( $success_mapping, 0, 3 ) ? substr( $success_mapping, 3 ) : $success_mapping;
			}
	add_action('woocommerce_order_status_'.$success_mapping_status, array($this,'bmw_customer_order' ));
	add_action('woocommerce_after_checkout_billing_form', array($this,'bmw_user_register'));
	add_action( 'woocommerce_product_options_pricing', array($this,'bmw_product_options'));
	add_action( 'woocommerce_process_product_meta', array($this,'bmw_post_custom_fields') );
	add_action('woocommerce_checkout_process', array($this,'bmw_register_fields_validation'));
	add_action('woocommerce_checkout_update_order_meta',array($this,'bmw_update_order_meta' ), 10, 1);
	add_filter('woocommerce_get_price_html', array($this, 'bmw_price_filter'),90,2);
	 		
	 		
	}

	private function define_constants() {

		$this->define( 'BMW_ABSPATH', dirname( BMW_PLUGIN_FILE ) . '/' );
		$this->define( 'BMW_PLUGIN_BASENAME', plugin_basename( BMW_PLUGIN_FILE ) );
		$this->define( 'BMW_VERSION', $this->version );

	}
	
	private function define( $name, $value ) {
		if ( ! defined( $name ) ) {
			define( $name, $value );
		}
	}

	public static function bmw_plugin_row_meta( $links, $file ) {

		if(BMW_PLUGIN_BASENAME==$file){
		$links[] = '<a href="'.esc_url(admin_url( 'admin.php?page=bmw-settings')).'" >'. __( 'Settings', 'BMW' ).'</a>';
		$links[] = '<a href="'.esc_url('https://www.letscms.com/binary-mlm-woocommerce/').'" target="_blank">'. __( 'Documentation', 'BMW' ).'</a>';
		}
		return $links;
	}

	public function includes() {
		include_once BMW_ABSPATH . 'includes/library/vendor/autoload.php';
		include_once BMW_ABSPATH . 'includes/BMW-hooks.php';
		include_once BMW_ABSPATH . 'includes/BMW-template-hooks.php';
		include_once BMW_ABSPATH . 'includes/BMW-template-function.php';
		include_once BMW_ABSPATH . 'includes/BMW-hook-functions.php';
		include_once BMW_ABSPATH . 'includes/BMW-order.php';
		include_once BMW_ABSPATH . 'includes/CLASS-BMW-INSTALL.php';
		include_once BMW_ABSPATH . 'includes/CLASS-BMW-UNINSTALL.php';
		include_once BMW_ABSPATH . 'includes/catalog/CLASS-BMW-TEMPLATE.php';
		include_once BMW_ABSPATH . 'templates/bmw-wc-register.php';
		
	}
	public function bmw_load_menus()
	{
		include_once dirname( __FILE__ ) . '/admin/CLASS-bmw-menu.php';
		if ( class_exists( 'BMW_ADMIN_MENU', false ) ) {
			new BMW_ADMIN_MENU();
		}
	}

	public function load_plugin_textdomain() {
		$locale = is_admin() && function_exists( 'get_user_locale' ) ? get_user_locale() : get_locale();
		$locale = apply_filters( 'plugin_locale', $locale, 'BMW' );
		unload_textdomain( 'BMW' );
		load_textdomain( 'BMW', BMW_ABSPATH . 'lang/'.$locale . '.mo' );
		load_plugin_textdomain( 'BMW', false, plugin_basename( dirname( BMW_PLUGIN_FILE ) ) . '/language' );
	}

	public function bmw_customer_order($order_id)
	{
		global $wpdb;
		$order = wc_get_order($order_id);

		$order_data = $order->get_data();
		$items = $order->get_items();
		$user_id=$order_data['customer_id'];
		$user_meta = get_userdata($user_id);
		$user_roles = $user_meta->roles;
		if ( in_array( 'bmw_user', $user_roles, true ) ) 
		{
			$order=new BMW_ORDER;
			$order->bmw_order_action_completed($order_id,$items,$order_data,$user_id);
		}
		else
		{
			bmw_register_mlm_user($user_id,$order_id);
			$order=new BMW_ORDER;
			$order->bmw_order_action_completed($order_id,$items,$order_data,$user_id);

		}
	}
	public function bmw_customer_order_cancellation($order_id)
	{
		global $wpdb;
		$order = wc_get_order($order_id);

		$order_data = $order->get_data();
		$items = $order->get_items();
		$user_id=$order_data['customer_id'];
		$user_meta = get_userdata($user_id);
		$user_roles = $user_meta->roles;
		if ( in_array( 'bmw_user', $user_roles, true ) ) 
		{
			$order=new bmw_ORDER;
			$order->bmw_order_action_cancelled($order_id,$items,$order_data,$user_id);
		}
	}

	public function bmw_register_fields_validation(){
		$general_settings=get_option('umw_general_settings');
			if(!empty(sanitize_text_field($_POST['createaccount_with_bmw']))){
					if(empty(sanitize_text_field($_POST['bmw_sponsor_id'])))
					{
					 	wc_add_notice(__('BMW Sponsor Could Not be Empty.','BMW') , 'error');
					}
					if(empty(sanitize_text_field($_POST['bmw_parent'])))
					{
					 	wc_add_notice(__('BMW parent Could Not be Empty.','BMW') , 'error');
					}
					if(empty(sanitize_text_field($_POST['bmw_position'])))
					{
					 	wc_add_notice(__('BMW position Could Not be Empty.','BMW') , 'error');
					}
				}
		}

	public function bmw_user_register()
	{
		global $current_user;
		wp_enqueue_script( 'bmw_main', BMW()->plugin_url() . '/assets/js/main.js', array('jquery'), '', true);
		$user_meta = get_userdata($current_user->ID);
		$user_roles = $user_meta->roles;
		if (is_user_logged_in() && !in_array( 'bmw_user', $user_roles, true ) ) 
		{
				$BMW_WOOCOMMERCE_REGISTER= new BMW_WOOCOMMERCE_REGISTER();
				$BMW_WOOCOMMERCE_REGISTER->bmw_register_form();
		}
	}
	public function bmw_update_order_meta( $order_id) {
   	if ( isset( $_POST['bmw_sponsor_id'] ) && !empty($_POST['bmw_sponsor_id']) ) {
   		$sponsor=sanitize_text_field( $_POST ['bmw_sponsor_id'] );
		add_post_meta( $order_id, 'bmw_sponsor_id', $sponsor );
	}
		$parent=sanitize_text_field( $_POST['bmw_parent'] );
		add_post_meta( $order_id, 'bmw_parent', $parent );

		$bmw_position=sanitize_text_field( $_POST['bmw_position'] );
		add_post_meta( $order_id, 'bmw_position', $bmw_position );
	}
	

	public function bmw_product_options() {
		global $post;
		$general_settings=get_option('bmw_manage_general');

		$product_points = array(
	    'id' 	=> 'product_points',
	    'name' 	=> 'product_points',
	    'label' => 	__('Product Points(PV)','BMW'),
	    'placeholder'  => __('Enter Product Points','BMW')
	 	);

		$enable_for_commission = array(
	    'id' 	=> 'enable_for_commssion',
	    'name' 	=> 'enable_for_commssion',
	    'type'  => 'checkbox',
	    'label' => 	__( 'BMW Commissions', 'BMW' ),
	    'description' => 	__( 'Enable for bmw Commissions', 'BMW' )
	  	);
		 if(isset( $general_settings['bmw_plan_base']) &&  $general_settings['bmw_plan_base']=='points'){
		woocommerce_wp_text_input( $product_points );
		}
		woocommerce_wp_checkbox( $enable_for_commission );
	}
	public function bmw_post_custom_fields($post_id)
	{
		$general_settings=get_option('bmw_manage_general');
		$commission=sanitize_text_field($_POST['enable_for_commssion']);
		$bmw_commssion = (isset( $commission ) && $commission=='yes') ? 'yes' : 'no';
  		update_post_meta($post_id, 'enable_for_commssion', $bmw_commssion);


  		if(isset( $general_settings['bmw_plan_base']) &&  $general_settings['bmw_plan_base']=='points'){
			$product_points=sanitize_text_field($_POST['product_points']);
	  		if(isset($product_points)){
	  			update_post_meta($post_id, 'product_points', $product_points);
	  		}
  		}
  	}
  	public function bmw_price_filter($price,$object)
  	{
  		$points=get_post_meta($object->get_id(), 'product_points',true);
  		if(isset($points) && !empty($points))
  		{
  		return $price.'('.$points.'PV)';
  		}else{
  		return $price;
  		}
  	}



	public function plugin_url() {
		return untrailingslashit( plugins_url( '/', BMW_PLUGIN_FILE ) );
	}

	public function plugin_path() {
		return untrailingslashit( plugin_dir_path( BMW_PLUGIN_FILE ) );
	}


}
