<?php 
/**
 * 
 */
class BMW_GENERAL 
{
  
 public static function bmw_setting_general()
  {
global $wpdb;
$error=array();
if(isset($_REQUEST['bmw_general']) && !empty($_REQUEST['bmw_general']))
{
  $data=sanitize_text_array($_REQUEST['bmw_general']);
  foreach ($data as $key => $field) {
    if(empty($field))
    {
      $error[$key]=ucwords(str_replace('_', ' ', str_replace('bmw_', '', $key))).__(" Can't Empty","BMW");
      unset($data[$key]);
    }
  }
  if(!empty($data))
  {
    update_option('bmw_manage_general',$data);
  }
}
$usercount = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}bmw_users");
$pages = get_pages(); 
$settings=get_option('bmw_manage_general');
// echo '<pre>';print_r($settings);die;
?>
<div >
<form name="bmw_general[bmw_general_settings_form]" id="bmw_general_settings_form" method="POST">

<table class="let-table let-table-bordered ">
  <thead class="let-bg-dark text-white">
    <tr class="let-text-center">
      <th class="let-text-center let-p-1" colspan="2"><h3 class="let-text-white let-p-0 let-m-0"><?php echo __('General Settings','BMW');?></h3></th>
    </tr>
  </thead>
  <tbody>
      <?php if(isset( $settings['bmw_plan_base']) &&  $settings['bmw_plan_base']=='points'):?>
        <input name="bmw_general[bmw_points_value]" type="hidden"  value="<?php echo (isset($settings['bmw_points_value']))?$settings['bmw_points_value']:'';?>"   >
      <?php endif;?>
    <tr class="let-text-center">
      <td class="let-align-middle"><?php _e('Cron Job Url:','BMW');?></td>
      <td class="let-align-middle"><?php echo BMW()->plugin_url();?>/cron.php</td>
    </tr>
     <tr class="let-text-center">
      <td class="let-align-middle"><?php _e('Plan Based On','BMW');?></td>
      <td class="let-align-middle">
        <select name="bmw_general[bmw_plan_base]"  class="let-form-control let-rounded-0">
          <option value=""><?php echo _e('Select Plan Base','BMW');?></option>
          <option value="points" <?php echo (@$settings['bmw_plan_base']=='points')?'selected':'';?>><?php _e('Points','BMW');?></option>
          <option value="price" <?php echo (@$settings['bmw_plan_base']=='price')?'selected':'';?>><?php _e('Price','BMW');?></option>
        </select>
        <?php if (isset($error['bmw_plan_base']) && !empty($error['bmw_plan_base'])) { ?>
<div class="let-alert let-alert-danger let-text-white let-fade let-show let-bmw-left-border let-p-1 let-text-left let-rounded-0 let-w-50 let-m-1"><small class=""><?php echo $error['bmw_plan_base'];?></small></div><?php } ?>
      </td>
    </tr>

    <tr class="let-text-center">
      <td class="let-align-middle"><?php _e('Affiliate user Redirect Page','BMW');?></td>
      <td class="let-align-middle">
        <select name="bmw_general[bmw_affiliate_url]"  class="let-form-control let-rounded-0">
          <option value=""><?php echo __('Select Redirect Page','BMW');?></option>
            <?php
        foreach ($pages as $page_data) { ?>
          <option value="<?php echo $page_data->ID;?>" <?php if( isset($settings['bmw_affiliate_url']) && $page_data->ID==$settings['bmw_affiliate_url']){echo 'selected';}?>><?php echo $page_data->post_title;?></option>
          <?php } ?>
        </select>
        <?php if (isset($error['bmw_affiliate_url']) && !empty($error['bmw_affiliate_url'])) { ?>
<div class="let-alert let-alert-danger let-text-white let-fade let-show let-bmw-left-border let-p-1 let-text-left let-rounded-0 let-w-50 let-m-1"><small class=""><?php echo $error['bmw_affiliate_url'];?></small></div><?php } ?>
      </td>
    </tr>
   
     <tr>
    <td ><?php _e('Payout Run (After Days)','BMW');?></td>
    <td ><input name="bmw_general[bmw_payoutrun_day]" id="bmw_payoutrun_day"  type="number"  value="<?php echo $settings['bmw_payoutrun_day'];?>"   placeholder="<?php _e('Referral Left','BMW');?>"  class="let-form-control let-rounded-0 let-number-only" >
    <?php if (isset($error['bmw_payoutrun_day']) && !empty($error['bmw_payoutrun_day'])) { ?>
<div class="let-alert let-alert-danger let-bmw-left-border  let-p-1 let-text-left let-rounded-0  let-m-1"><?php echo $error['bmw_payoutrun_day'];?></div><?php } ?></td>
<td></td>
   </tr>
   <td ><?php _e('Leadership Bonus Run (After Months)','BMW');?></td>
    <td ><input name="bmw_general[bmw_leadership_month]" id="bmw_leadership_month"  type="number"  value="<?php echo $settings['bmw_leadership_month'];?>"   placeholder="<?php _e('Leadership Bonus Run (After Months)','BMW');?>"  class="let-form-control let-rounded-0 let-number-only" >
    <?php if (isset($error['bmw_leadership_month']) && !empty($error['bmw_leadership_month'])) { ?>
<div class="let-alert let-alert-danger let-bmw-left-border  let-p-1 let-text-left let-rounded-0  let-m-1"><?php echo $error['bmw_leadership_month'];?></div><?php } ?></td>
<td></td>
   </tr>
    <tr class="let-text-center">
      <td class="let-align-middle"><?php _e('Redirect After Registeration','BMW');?></td>
      <td class="let-align-middle">
        <select name="bmw_general[bmw_register_url]"  class="let-form-control let-rounded-0">
          <option value=""><?php echo __('Select Redirect Page','BMW');?></option>
            <?php
        foreach ($pages as $page_data) { ?>
          <option value="<?php echo $page_data->ID;?>" <?php if( isset($settings['bmw_register_url']) && $page_data->ID==$settings['bmw_register_url']){echo 'selected';}?>><?php echo $page_data->post_title;?></option>
          <?php } ?>
        </select>
      <?php if (isset($error['bmw_register_url']) && !empty($error['bmw_register_url'])) { ?>
<div class="let-alert let-alert-danger let-text-white let-fade let-show let-bmw-left-border let-p-1 let-text-left let-rounded-0 let-w-50 let-m-1"><small class="let-"><?php echo $error['bmw_register_url'];?></small></div><?php } ?>
</td>
    </tr>
    <tr class="let-text-center">
      <td class="let-align-middle"><?php _e('Order Status for Distribution','BMW');?></td>
      <td class="let-align-middle">
        <select name="bmw_general[bmw_order_success_status]"  class="let-form-control let-rounded-0">
          <option value=""><?php echo __('Select Order Status','BMW');?></option>
            <?php
            $order = wc_get_order_statuses(); 
       foreach ($order as $key => $value) { 
           ?>
            <option value="<?php echo $key;?>"  <?php if( isset($settings['bmw_order_success_status']) && $key==$settings['bmw_order_success_status']){echo 'selected';}?>><?php echo $value; ?>
            </option>
          <?php } ?>
        </select>
      <?php if (isset($error['bmw_order_success_status']) && !empty($error['bmw_order_success_status'])) { ?>
<div class="let-alert let-alert-danger let-text-white let-fade let-show let-bmw-left-border let-p-1 let-text-left let-rounded-0 let-w-50 let-m-1"><small class="let-"><?php echo $error['bmw_order_success_status'];?></small></div><?php } ?>
</td>
    </tr>
 
    <tr class="let-text-center">
      <td class="let-align-middle"><?php _e('OTP Verification','BMW');?></td>
      <td class="let-text-left let-align-middle">
        <div class="let-col-md-12 let-row let-m-0 let-p-0">
          <div class="let-col-md-2 let-border let-text-center let-p-3 ">
       <input type="checkbox" id="bmw_otp_verification" name="bmw_general[bmw_otp_verification]" value="1"class="let-form-control let-rounded-0" <?php echo (isset($settings['bmw_otp_verification'])==1)?'checked':'';?>>
    </div>
    <div class="let-col-md-10 let-border let-text-left let-alert-info let-alert  let-m-0 let-rounded-0 let-bmw-left-border">
      <?php _e("Notice:",'BMW');?>
      <?php _e("Please confirm SMS setings for this feature","BMW");?>
    </div>
  </div>
</td>
    </tr>
 
    <tr class="let-text-center">
      <td class="let-align-middle"><?php _e('Auto Fill','BMW');?></td>
      <td class="let-text-left let-align-middle">
        <div class="let-col-md-12 let-row let-m-0 let-p-0">
          <div class="let-col-md-2 let-border let-text-center let-p-3 ">
    <?php if(isset($settings['bmw_auto_fill'])==1 && @$usercount>1){?>
  <input type="checkbox" id="bmw_auto_fill-1" name="bmw_general[bmw_auto_fill]" value="1" class="let-form-control let-rounded-0" <?php echo (isset($settings['bmw_auto_fill'])==1)?'checked':'';?> disabled>
<?php } else if(isset($settings['bmw_auto_fill'])==1 && @$usercount==1){?>
  <input type="checkbox" id="bmw_auto_fill-1" name="bmw_general[bmw_auto_fill]" value="1" class="let-form-control let-rounded-0" <?php echo (isset($settings['bmw_auto_fill'])==1)?'checked':'';?> >
<?php } else{?>
  <input type="checkbox" id="bmw_auto_fill-1" name="bmw_general[bmw_auto_fill]" value="1" class="let-form-control let-rounded-0" >
<?php } ?>
    </div>
    <div class="let-col-md-10 let-border let-text-left let-alert-danger let-alert  let-m-0 let-rounded-0 let-bmw-left-border">
      <?php _e("Notice:",'BMW');?>
      <?php _e("If you checked auto fill and register more then one member then can not be change Auto Fill.","BMW");?>
    </div>
  </div>
</td>
    </tr>
    
  
    <tr class="let-text-center">
      <td class="let-align-middle"><?php _e('Withdrawal Limit','BMW');?></td>
      <td class="let-text-left"><input name="bmw_general[bmw_withdrawal_limit_min]" id="bmw_withdrawal_limit_min" type="text" style="" value="<?php echo !empty($settings['bmw_withdrawal_limit_min'])?$settings['bmw_withdrawal_limit_min']:'';?>" class="let-form-control-small let-rounded-0" placeholder="<?php echo __('Min Amount','BMW');?>">
  <input name="bmw_general[bmw_withdrawal_limit_max]" id="bmw_withdrawal_limit_max" type="text" style="" value="<?php echo !empty($settings['bmw_withdrawal_limit_max'])?$settings['bmw_withdrawal_limit_max']:'';?>"  class="let-form-control-small let-rounded-0"  placeholder="<?php echo __('Max Amount','BMW');?>">
<?php if (isset($error['bmw_withdrawal_limit_min']) && !empty($error['bmw_withdrawal_limit_min'])) { ?>
<div class="let-alert let-alert-danger let-text-white let-fade let-show let-bmw-left-border let-p-1 let-text-left let-rounded-0 let-w-50 let-m-1"><small class="let-"><?php echo $error['bmw_withdrawal_limit_min'];?></small></div><?php } ?>
<?php if (isset($error['bmw_withdrawal_limit_max']) && !empty($error['bmw_withdrawal_limit_max'])) { ?>
<div class="let-alert let-alert-danger let-text-white let-fade let-show let-bmw-left-border let-p-1 let-text-left let-rounded-0 let-w-50 let-m-1"><small class="let-"><?php echo $error['bmw_withdrawal_limit_max'];?></small></div><?php } ?>
</td>
    </tr>
  </tbody>
  <tfoot>
    <tr>
      <td colspan="2" class="let-text-center"><button class="let-btn let-btn-success let-rounded-0 let-btn-sm"><?php _e('Save General Settings','BMW');?></button></td>
    </tr>
  </tfoot>
</table>
</form>
</div>
</div>
<?php
  }
}