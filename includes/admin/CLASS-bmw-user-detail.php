<?php 
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class BMW_USER_DETAILS
{

	public static function bmw_display_user_details($user_id,$user_key)
	{
		bmw_register_sms_function($user_id);
		?>
		 <div class="let-col-md-12 let-col-sm-12 let-mt-5">
              <div class="let-x_panel let-pl-0 let-pr-0 ">
              
                <div class="let-x_content">
                	<div class="let-col-md-4 let-p-0">
                	<?php do_action('bmw_display_member_data',$user_id,$user_key); ?>
                </div>
                	<div class="let-col-md-8 let-p-0">
				<?php  	do_action('bmw_personal_info_display',$user_id,$user_key); ?>
					</div>
				</div>
                	
				</div>
			</div>
		 <div class="let-col-md-12 let-col-sm-12">
              <div class="let-x_panel let-pl-0 let-pr-0 ">
              
                <div class="let-x_content">
                	<div class="let-col-md-6 let-p-0">
				<?php  	do_action('bmw_pair_commission_display',$user_id,$user_key); ?>
					</div>
                	<div class="let-col-md-6 let-p-0">
				<?php  	do_action('bmw_ref_commission_display',$user_id,$user_key); ?>
					</div>
				</div>
                	
				</div>
			</div>
		 <div class="let-col-md-12 let-col-sm-12">
              <div class="let-x_panel let-pl-0 let-pr-0 ">
              
                <div class="let-x_content">
                	<div class="let-col-md-6 let-p-0">
				<?php  	do_action('bmw_faststart_commission_display',$user_id,$user_key); ?>
					</div>
                	<div class="let-col-md-6 let-p-0">
				<?php  	do_action('bmw_leadership_details_display',$user_id,$user_key); ?>
					</div>
				</div>
                	
				</div>
			</div>
				<?php  	do_action('bmw_payout_list_display',$user_id,$user_key); ?>
			
				<?php 

	}

}