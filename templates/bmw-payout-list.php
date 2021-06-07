<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; 
}
get_header();
?>
<div class="let-bmp-body">
<div class="let-nav-md">
<div class="let-container let-body">
      <div class="let-main_container">
      	<?php
do_action('bmw_sidebar');
?>
  <div class="<?php echo (is_user_logged_in())?'let-right_col':'';?>" role="main">
  	<?php
$status=bmw_user_check_validate_function();
$section=(isset($_GET['section']))?$_GET['section']:'';
if($status){
	global $current_user;
	$user_key=bmw_get_current_user_key();
switch ($section) {
	case 'pair_commission':
	do_action('bmw_pair_commission_display',$current_user->ID,$user_key);
		break;
	case 'ref_commission':
	do_action('bmw_ref_commission_display',$current_user->ID,$user_key);
		break;
	case 'leadership_commission':
	do_action('bmw_leadership_details_display',$current_user->ID,$user_key);
		break;
	case 'faststart_commision':
	do_action('bmw_faststart_commission_display',$current_user->ID,$user_key);
		break;
	default:
	do_action('bmw_payout_list_display',$current_user->ID,$user_key);
		break;
}
	
}
?>
</div>
</div>
</div>
</div>
</div>
<?php 
get_footer();
?>
