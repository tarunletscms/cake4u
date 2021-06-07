<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; 
}
global $wpdb;
if(!empty($_GET['payout_id'])){
  $payout_id=sanitize_text_field($_GET['payout_id']);  
} else{
  $payout_id=0;
}

if(!empty($_GET['user_key'])){
  $user_key=sanitize_text_field($_GET['user_key']);  
} else{
  $user_key=0;
}
$user_id=bmw_get_user_id_by_userkey($user_key);

?>
<?php  	do_action('bmw_payout_list_display',$user_id,$user_key,$payout_id); ?>
		 <div class="let-col-md-12 let-col-sm-12">
              <div class="let-x_panel let-pl-0 let-pr-0 ">
              
                <div class="let-x_content">
                	<div class="let-col-md-6 let-p-0">
				<?php  	do_action('bmw_pair_commission_display',$user_id,$user_key,$payout_id); ?>
					</div>
                	<div class="let-col-md-6 let-p-0">
				<?php  	do_action('bmw_ref_commission_display',$user_id,$user_key,$payout_id); ?>
					</div>
				</div>
                	
				</div>
			</div>
		 <div class="let-col-md-12 let-col-sm-12">
              <div class="let-x_panel let-pl-0 let-pr-0 ">
              
                <div class="let-x_content">
                	<div class="let-col-md-6 let-p-0">
				<?php  
					// do_action('bmw_level_commission_display',$user_id,$user_key,$payout_id);
					do_action('bmw_faststart_commission_display',$user_id,$user_key,$payout_id);
					 ?>
					</div>
                	<div class="let-col-md-6 let-p-0">
				<?php  	
				// do_action('bmw_bonus_details_display',$user_id,$user_key,$payout_id);
				do_action('bmw_leadership_details_display',$user_id,$user_key,$payout_id);
				 ?>
					</div>
				</div>
                	
				</div>
			</div>
				