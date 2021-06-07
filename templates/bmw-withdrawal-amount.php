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
if($status){
	global $current_user;
 do_action('bmw_withdrawal_display');
 do_action('bmw_withdrawal_reports_display',$current_user->ID);
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
