<?php 

 add_action('bmw_sidebar','bmw_sidebar_function');

 add_action('bmw_user_top_bar','bmw_user_top_bar_function');
 add_action('bmw_user_withdrawal_graph','bmw_user_withdrawal_graph_function');

 add_action('bmw_user_earnings_graph','bmw_user_earnings_graph_function');
 add_action('bmw_personal_info_display','bmw_personal_info_display_function',2,10);
 add_action('bmw_bank_details_display','bmw_bank_details_display_function');


 add_action('bmw_payout_list_display','bmw_payout_list_display_function',3,10);
 add_action('bmw_pair_commission_display','bmw_pair_commission_display_function',3,10);
 add_action('bmw_ref_commission_display','bmw_ref_commission_display_function',3,10);
 add_action('bmw_level_commission_display','bmw_level_commission_display_function',3,10);
 add_action('bmw_bonus_details_display','bmw_bonus_details_display_function',3,10);
 
 add_action('bmw_leadership_details_display','bmw_leadership_details_display_function',3,10);
 add_action('bmw_faststart_commission_display','bmw_faststart_commission_display_function',3,10);

 add_action('bmw_withdrawal_display','bmw_withdrawal_display_function');
 add_action('bmw_withdrawal_reports_display','bmw_withdrawal_reports_display_function',1,10);


 add_action('bmw_registration_display','bmw_registration_display_function');
 add_action('bmw_display_member_data','bmw_display_member_data_function',2,10);
 add_action('bmw_send_invitation_display','bmw_send_invitation_display_function');


 add_action('bmw_user_withdrawal_request_display','bmw_user_withdrawal_request_display_function',2,10);
 add_action('bmw_withdrawal_pay_form','bmw_withdrawal_pay_form_function',2,10);
 add_action('bmw_mail_configurations','bmw_mail_configurations_function');
 add_action('bmw_sms_configurations','bmw_sms_configurations_function');
 add_action('bmw_addons_installable_template','bmw_addons_installable_template_function');
