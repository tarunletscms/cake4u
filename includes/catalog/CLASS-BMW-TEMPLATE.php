<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; 
}
add_filter( 'page_template', 'bmw_page_template',10,2);
function bmw_page_template( $page_template,$temp)
{
	global $post;
  	if (is_page('dashboard') && get_post_meta($post->ID,'bmw_page_title',true)==$post->post_title) { 
  			add_action( 'wp_enqueue_scripts', 'custom_dashboard_style' );
  			$page_template = BMW_ABSPATH . '/templates/bmw-dashboard.php';
		}	
	if (is_page('personal_info') && get_post_meta($post->ID,'bmw_page_title',true)==$post->post_title) { 
				add_action( 'wp_enqueue_scripts', 'custom_bmw_style' );
			$page_template = BMW_ABSPATH . '/templates/bmw-personal-info.php';
		}	

	if (is_page('bank_details') && get_post_meta($post->ID,'bmw_page_title',true)==$post->post_title) { 
				add_action( 'wp_enqueue_scripts', 'custom_bmw_style' );
			$page_template = BMW_ABSPATH . '/templates/bmw-bank-details.php';
		}	

	if (is_page('payout_list') && get_post_meta($post->ID,'bmw_page_title',true)==$post->post_title) { 
				add_action( 'wp_enqueue_scripts', 'custom_bmw_style' );
			$page_template = BMW_ABSPATH . '/templates/bmw-payout-list.php';
		}	
		
	if (is_page('join_network')  && get_post_meta($post->ID,'bmw_page_title',true)==$post->post_title) { 
  			add_action( 'wp_enqueue_scripts', 'custom_bmw_style' );
  			$page_template = BMW_ABSPATH . '/templates/bmw-join-network.php';
		}
	if (is_page('register') && get_post_meta($post->ID,'bmw_page_title',true)==$post->post_title) { 
  			add_action( 'wp_enqueue_scripts', 'custom_bmw_style' );
  			$page_template = BMW_ABSPATH . '/templates/bmw-register.php';
		}

	if (is_page('genealogy') && get_post_meta($post->ID,'bmw_page_title',true)==$post->post_title) { 
				add_action( 'wp_enqueue_scripts', 'custom_bmw_style' );
			$page_template = BMW_ABSPATH . '/templates/bmw-genealogy.php';
		}	
	if (is_page('account_detail') && get_post_meta($post->ID,'bmw_page_title',true)==$post->post_title) { 
				add_action( 'wp_enqueue_scripts', 'custom_bmw_style' );
			$page_template = BMW_ABSPATH . '/templates/bmw-account-detail.php';
		}
	if (is_page('payout_detail') && get_post_meta($post->ID,'bmw_page_title',true)==$post->post_title) { 
				add_action( 'wp_enqueue_scripts', 'custom_bmw_style' );
			$page_template = BMW_ABSPATH . '/templates/bmw-payout-detail.php';
		}	
	if (is_page('withdrawal_amount') && get_post_meta($post->ID,'bmw_page_title',true)==$post->post_title) { 
				add_action( 'wp_enqueue_scripts', 'custom_bmw_style' );
			$page_template = BMW_ABSPATH . '/templates/bmw-withdrawal-amount.php';
		}
	if (is_page('invitation') && get_post_meta($post->ID,'bmw_page_title',true)==$post->post_title) { 
				add_action( 'wp_enqueue_scripts', 'custom_bmw_style' );
			$page_template = BMW_ABSPATH . '/templates/bmw-send-invitation.php';
		}
	if (is_page('mycred_wallet') && get_post_meta($post->ID,'bmw_page_title',true)==$post->post_title) { 
				add_action( 'wp_enqueue_scripts', 'custom_bmw_style' );
			$page_template = BMW_ABSPATH . '/templates/bmw-mycred.php';
		}
	if (is_page('tera_wallet') && get_post_meta($post->ID,'bmw_page_title',true)==$post->post_title) { 
				add_action( 'wp_enqueue_scripts', 'custom_bmw_style' );
			$page_template = BMW_ABSPATH . '/templates/bmw-terawallet.php';
		}


    return $page_template;
}


function custom_bmw_style() {
	global $post;
	switch ($post->post_name) {
			case 'join_network':
			bmw_style_enque();
			break;
			case 'payout_list':
			bmw_style_enque();
			bmw_dataTable_enque();
			break;
			case 'personal_info':
			bmw_style_enque();
			break;
			case 'bank_details':
			bmw_style_enque();
			break;
			case 'withdrawal_amount':
			bmw_style_enque();
			bmw_dataTable_enque();
			break;
			case 'register':
			bmw_style_enque();
			bmw_icheck_enque();
			break;
			case 'genealogy':
			bmw_style_enque();
			enque_genealogy_scripts();
			break;
			case 'invitation':
			bmw_style_enque();
			break;
			case 'mycred_wallet':
			bmw_style_enque();
			break;
			case 'tera_wallet':
			bmw_style_enque();
			break;
		default:
			# code...
			break;
	}
}

function custom_dashboard_style(){
		
		wp_enqueue_script('jquery');
		bmw_style_enque();
		wp_enqueue_style( 'bmw_animate', BMW()->plugin_url() . '/assets/css/additional/animate.min.css' );
		wp_enqueue_style( 'bmw_progress', BMW()->plugin_url() . '/assets/css/additional/nprogress.css' );
		wp_enqueue_script( 'bmw_chart', BMW()->plugin_url() . '/assets/js/charts.js', array(), '', true);
}

function bmw_style_enque()
{
	wp_enqueue_script('jquery');
	wp_enqueue_style( 'bmw_style', BMW()->plugin_url() . '/assets/css/bmw-style.css' );
	wp_enqueue_style( 'bmw_style_custom', BMW()->plugin_url() . '/assets/css/bmw-style-custom.css' );
	wp_enqueue_style( 'bmw_fawe', BMW()->plugin_url() . '/assets/css/font-awesome/css/font-awesome.min.css' );
	
	wp_enqueue_script( 'bmw_js', BMW()->plugin_url() . '/assets/js/bmw-js.js', array(), '', true);
	wp_enqueue_script( 'bmw_main', BMW()->plugin_url() . '/assets/js/main.js', array(), '', true);
}

function bmw_admin_style_enque()
{
	wp_enqueue_script('jquery');
	wp_enqueue_style( 'bmw_admin', BMW()->plugin_url() . '/assets/css/admin/admin.css' );
	wp_enqueue_style( 'bmw_style', BMW()->plugin_url() . '/assets/css/bmw-style.css' );
	wp_enqueue_style( 'bmw_style_custom', BMW()->plugin_url() . '/assets/css/bmw-style-custom.css' );
	wp_enqueue_style( 'bmw_fawe', BMW()->plugin_url() . '/assets/css/font-awesome/css/font-awesome.min.css' );
	
	wp_enqueue_script( 'bmw_js', BMW()->plugin_url() . '/assets/js/bmw-js.js', array(), '', true);
	wp_enqueue_script( 'bmw_main', BMW()->plugin_url() . '/assets/js/admin/admin.js', array('jquery'), '', true);
}
function bmw_text_editor_enque()
{
	wp_enqueue_script('jquery');
	wp_enqueue_style( 'bmw_text_editor', BMW()->plugin_url() . '/assets/js/lib/text-editor/text-editor.css' );
	wp_enqueue_script( 'bmw_text_editor', BMW()->plugin_url() . '/assets/js/lib/text-editor/text-editor.js', array('jquery'), '', true);
	wp_enqueue_script( 'bmw_text_insert', BMW()->plugin_url() . '/assets/js/lib/text-editor/text-insert.js', array('jquery'), '', true);
}


function bmw_icheck_enque()
{
	wp_enqueue_script( 'bmw_icheck', BMW()->plugin_url() . '/assets/js/lib/icheck/icheck.min.js', array('jquery'), '', true);
}

function bmw_dataTable_enque()
{
	wp_enqueue_style('bmw_datatable-css', BMW()->plugin_url() . '/assets/css/datatable/datatables.min.css', false, false,'all');
    wp_enqueue_script('bmw_datatable_js', BMW()->plugin_url() . '/assets/css/datatable/datatables.min.js',array(),false,true);
    wp_enqueue_script('bmw_datatable', BMW()->plugin_url() . '/assets/css/datatable/bmw-dataTables.js',array(),false,true);

}


function enque_genealogy_scripts()
{
  wp_enqueue_style( 'bmw_fawe', BMW()->plugin_url() . '/assets/css/font-awesome/css/font-awesome.min.css' );
  wp_enqueue_style( 'bmw_genealogy', BMW()->plugin_url() . '/assets/js/genealogy/genealogy.min.css', false, false,'all');
  wp_enqueue_script('bmw_genealogy_boot', BMW()->plugin_url() . '/assets/js/genealogy/genealogy_boot.js',array(),false,true);
  wp_enqueue_script('bmw_genealogy_main', BMW()->plugin_url() . '/assets/js/genealogy/genealogy_main.js',array('jquery'),false,true);
  wp_localize_script('bmw_genealogy_main', 'WPURLS', array( 'siteurl' => get_option('siteurl'),'plugin_url'=>BMW()->plugin_url() ));
}