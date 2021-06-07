
<?php 
  class BMW_WITHDRAWAL_VIEW
{

static   function bmw_withdrawal_display($user_id,$id)
   {	
   		do_action('bmw_user_withdrawal_request_display',$user_id,$id);
   		do_action('bmw_withdrawal_pay_form',$user_id,$id);
   		do_action('bmw_withdrawal_reports_display',$user_id);
   }
 }
