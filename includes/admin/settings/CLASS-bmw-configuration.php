<?php
/*
 * Display Settings page
 */
class BMW_DISPLAY_CONFIGURATION_SETTING {

public static function bmw_configuration_page() {
	global $wpdb;

	global $pagenow,$wpdb;
	if(  $pagenow == 'admin.php' && $_GET['page'] == 'bmw-settings' && isset($_GET['tab'])&& $_GET['tab'] == 'general')
		$current = 'general';
	else if( $pagenow == 'admin.php' && $_GET['page'] == 'bmw-settings' && isset($_GET['tab'])&& $_GET['tab'] == 'eligibility')
		$current = 'eligibility';
	else if( $pagenow == 'admin.php' && $_GET['page'] == 'bmw-settings' && isset($_GET['tab'])&& $_GET['tab'] == 'payout')
		$current = 'payout';
	else if( $pagenow == 'admin.php' && $_GET['page'] == 'bmw-settings' && isset($_GET['tab'])&& $_GET['tab'] == 'bonus')
		$current = 'bonus';
	else if( $pagenow == 'admin.php' && $_GET['page'] == 'bmw-settings' && isset($_GET['tab'])&& $_GET['tab'] == 'level')
		$current = 'level';
	else if( $pagenow == 'admin.php' && $_GET['page'] == 'bmw-settings' && isset($_GET['tab'])&& $_GET['tab'] == 'leadership_bonus')
		$current = 'leadership_bonus';
	else if( $pagenow == 'admin.php' && $_GET['page'] == 'bmw-settings' && isset($_GET['tab'])&& $_GET['tab'] == 'level_commission')
		$current = 'level_commission';
	else if( $pagenow == 'admin.php' && $_GET['page'] == 'bmw-settings' && isset($_GET['tab'])&& $_GET['tab'] == 'epins')
		$current = 'epins';
	else if( $pagenow == 'admin.php' && $_GET['page'] == 'bmw-settings' && isset($_GET['tab'])&& $_GET['tab'] == 'licence')
		$current = 'licence';
	else
 		$current = 'general';

	$tabs = array(
					'general' => __('General','BMW'),
					 'eligibility'=>__('Elegibility','BMW'),
					  'payout' => __('Payout','BMW'),
					   'bonus' => __('Bonuses','BMW'),
					   'level' => __('Levels','BMW'), 
					   'leadership_bonus' => __('Leadership Bonus','BMW'), 
					   'level_commission' => __('Level Commissions','BMW'),
					   'licence' => __('Licence','BMW'));

	$links = array();
	$settings=get_option('bmw_manage_general');
	$l_settings=get_option('bmw_level_settings');
	echo '<div class="let-col-md-12 let-row let-p-0 let-m-0 let-bmw_admin_main">';
	echo '<div class="let-col-md-2 let-bg-success let-pt-3 let-left-section">';
	echo '<ul class="let-list-group">';
    foreach( $tabs as $tab => $name )
	{
		if((!isset($l_settings['bmw_level_status']) || $l_settings['bmw_level_status']!='1') && $tab=='level_commission'){$l_none='let-d-none';}else{ $l_none='';}
        $class = ( $tab == $current ) ? 'current let-bg-dark let-text-white' : '';
        echo "<li class='list-group-item let-text-center let-p-0 ".$class.' '.$l_none."'><a  class='".$class." let-w-100 let-btn' href='?page=bmw-settings&setting=configuration&tab=$tab'>".$name."</a></li>";
    }
    echo '</ul>';
    echo '</div>';
    echo '<div class="let-col-md-10 let-p-0 let-right-section">';

if($pagenow == 'admin.php' && $_GET['page'] == 'bmw-settings')
{
	switch (@$_GET['tab']) {
		case 'general':
		if(is_lic_validate()){
		include_once BMW_ABSPATH . 'includes/admin/settings/view/view_general_settings.php';
		 BMW_GENERAL::bmw_setting_general();
		}
			break;
		case 'payout':
		if(is_lic_validate()){
		include_once BMW_ABSPATH . 'includes/admin/settings/view/view_payout_settings.php';
		BMW_PAYOUT::bmw_setting_payout();
		}
			break;
		case 'level_commission':
		if(is_lic_validate()){
		include_once BMW_ABSPATH . 'includes/admin/settings/view/view_level_commission_settings.php';
		BMW_LEVEL_COMMISSION::bmw_setting_level();
		}
			break;
		case 'eligibility':
		if(is_lic_validate()){
		include_once BMW_ABSPATH . 'includes/admin/settings/view/view_eligibility_settings.php';
		BMW_ELIGIBILITY::bmw_setting_eligibility();
		}
			break;
		case 'bonus':
		if(is_lic_validate()){
		include_once BMW_ABSPATH . 'includes/admin/settings/view/view_bonus_settings.php';
		BMW_BONUSES::bmw_setting_bonuses();
		}
			break;
		case 'level':
		if(is_lic_validate()){
		include_once BMW_ABSPATH . 'includes/admin/settings/view/view_levels_settings.php';
		BMW_LEVELS::bmw_setting_levels();
		}
			break;
		case 'leadership_bonus':
		if(is_lic_validate()){
		include_once BMW_ABSPATH . 'includes/admin/settings/view/view_leader_bonus_settings.php';
		BMW_LEADERSHIPBONUS::bmw_leadership_bonus_payout();
		}
			break;
		case 'licence':
		include_once BMW_ABSPATH . 'includes/admin/settings/view/view_licence_settings.php';
		BMW_LICENCE::bmw_setting_licence();
			break;
		
		default:
			if(is_lic_validate()){
		include_once BMW_ABSPATH . 'includes/admin/settings/view/view_general_settings.php';
		 BMW_GENERAL::bmw_setting_general();
			break;
		}
}
	

}
	echo '</div>';
}

}//end of class
?>
