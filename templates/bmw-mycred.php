<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; 
}

get_header();
global $current_user;

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

           ?>
           <div class="let-col-md-12 let-col-sm-12 ">
            <div class="let-x_panel">
              <div class="let-x_title">
               <h2><?php _e('MyCred History','BMW');?> </h2> 
               <ul class="let-nav let-navbar-right let-panel_toolbox">
                <li><?php echo sprintf(__('Current Balance : %s','BMW'), bmw_price((float)mycred_get_users_balance($current_user->ID)));?>
                </li>
                 <li><a class="let-collapse-link"><i class="fa fa-chevron-up"></i></a>
                </li>
                <li><a class="let-close-link"><i class="fa fa-close"></i></a>
                </li>
              </ul>
              <div class="let-clearfix"></div>
            </div>
            <div class="let-x_content">
             <?php echo do_shortcode('['.MYCRED_SLUG . '_history]'); ?>
           </div>
         </div>
       </div>
        <?php }  ?>
     </div>
   </div>
 </div>
</div>
<?php 
get_footer();
?>
