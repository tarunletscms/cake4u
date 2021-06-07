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
	$user_key=bmw_get_current_user_key();
 do_action('bmw_display_member_data',$current_user->ID,$user_key);
}
?>
</div>
</div>
</div>
</div>
</div>
<?php 
get_footer();