<?php 

class BMW_ELIGIBILITY 
{
  
public static function bmw_setting_eligibility()
  {
   
	global $wpdb;
$error=array();
if(isset($_REQUEST['bmw_elegibility']) && !empty($_REQUEST['bmw_elegibility']))
{
  $data=sanitize_text_array($_REQUEST['bmw_elegibility']);
  foreach ($data as $key => $field) {
    if(empty($field))
    {
      $error[$key]=ucwords(str_replace('_', ' ', str_replace('bmw_', '', $key))).__(" Can't Empty");
      unset($data[$key]);
    }
  }
  if(!empty($data))
  {
    update_option('bmw_manage_eligibility',$data);
  }
}
	$setting=get_option('bmw_manage_eligibility');
$general_settings=get_option('bmw_manage_general');
	
	?>
  <div>
<form method="POST">

<table class="let-table table-bordered ">
  <thead class="let-bg-dark text-white">
    <tr class="let-text-center">
      <th class="let-text-center let-p-1" colspan="3"><h3 class="let-text-white let-p-0 let-m-0"><?php echo __('Eligibility Settings','BMW');?></h3></th>
    </tr>
  </thead>
  <tbody>
    <?php if(isset( $general_settings['bmw_plan_base']) &&  $general_settings['bmw_plan_base']=='points'):?>
      <tr>
    <td class="let-align-middle"><?php _e('Minimum Personal Points','BMW');?></td>
    <td class="let-align-middle"> <input  name="bmw_elegibility[bmw_minimum_personal_points]" type="text"  value="<?php echo $setting['bmw_minimum_personal_points'];?>" placeholder="<?php _e('Minimum Personal Points','BMW');?>" class="let-form-control let-rounded-0 let-number-only" >
    <?php if (isset($error['bmw_minimum_personal_points']) && !empty($error['bmw_minimum_personal_points'])) { ?>
<div class="let-alert let-alert-danger  let-bmw-left-border let-p-1 let-text-left let-rounded-0  let-m-1"><?php echo $error['bmw_minimum_personal_points'];?></div><?php } ?></td>
    <td class="let-align-middle let-text-success">
      <?php _e('Personal Points is the Qualification Points which is provide the eligibility for commissions','BMW');?>
    </td>
   </tr>
    <?php endif;?>
     <tr>
    <td><?php _e('Direct Referrals','BMW');?></td>
    <td>
      <input  name="bmw_elegibility[bmw_direct_referrals]" id="bmw_referral"  type="text"  value="<?php echo $setting['bmw_direct_referrals'];?>" placeholder="<?php _e('Direct Referrals','BMW');?>" class="let-form-control let-rounded-0 let-number-only">
    <?php if (isset($error['bmw_direct_referrals']) && !empty($error['bmw_direct_referrals'])) { ?>
    <div class="let-alert let-alert-danger  let-bmw-left-border let-p-1 let-text-left let-rounded-0  let-m-1"><?php echo $error['bmw_direct_referrals'];?></div><?php } ?></td>
    <td class="let-align-middle let-text-success">
      <?php sprintf(__('If  Direct Referrals 1 then <br/> place 1 in Left and Right Referrals %s' ,'BMW'),'<br>');?>
    </td>
   </tr>
  
     <tr>
    <td ><?php _e('Left Leg Referral(s)','BMW');?></td>
    <td ><input name="bmw_elegibility[bmw_referral_left]" id="bmw_referral_left"  type="text"  value="<?php echo $setting['bmw_referral_left'];?>"   placeholder="<?php _e('Referral Left','BMW');?>"  class="let-form-control let-rounded-0 let-number-only" >
    <?php if (isset($error['bmw_referral_left']) && !empty($error['bmw_referral_left'])) { ?>
<div class="let-alert let-alert-danger let-bmw-left-border  let-p-1 let-text-left let-rounded-0  let-m-1"><?php echo $error['bmw_referral_left'];?></div><?php } ?></td>
<td></td>
   </tr>
   <tr>
    <td ><?php _e('Right Leg Referral(s)','BMW');?></td>
    <td><input name="bmw_elegibility[bmw_referral_right]" id="bmw_referral_right"  type="text"  value="<?php echo $setting['bmw_referral_right'];?>"  placeholder="<?php _e('Referral Right','BMW');?>" class="let-form-control let-rounded-0 let-number-only">
    <?php if (isset($error['bmw_referral_right']) && !empty($error['bmw_referral_right'])) { ?>
<div class="let-alert let-alert-danger let-bmw-left-border  let-p-1 let-text-left let-rounded-0  let-m-1"><?php echo $error['bmw_referral_right'];?></div><?php } ?></td>
<td></td>
   </tr>
    <tr class=""><td colspan="2"><h2><b><?php _e('Cake4U Eligibility','BMW');?></b></h2></td></tr>
   <tr>
    <td ><?php _e('FastStart day limit','BMW');?></td>
    <td><input name="bmw_elegibility[bmw_cake4u_faststart_day_limit]" id="bmw_cake4u_faststart_day_limit"  type="text"  value="<?php echo $setting['bmw_cake4u_faststart_day_limit'];?>"  placeholder="<?php _e('FastStart day limit','BMW');?>" class="let-form-control let-rounded-0 let-number-only">
    <?php if (isset($error['bmw_cake4u_faststart_day_limit']) && !empty($error['bmw_cake4u_faststart_day_limit'])) { ?>
<div class="let-alert let-alert-danger let-bmw-left-border  let-p-1 let-text-left let-rounded-0  let-m-1"><?php echo $error['bmw_cake4u_faststart_day_limit'];?></div><?php } ?></td>
<td></td>
   </tr>  
    <tr>
    <td ><?php _e('FastStart Direct Sponsor limit','BMW');?></td>
    <td><input name="bmw_elegibility[bmw_cake4u_faststart_sponsor_limit]" id="bmw_cake4u_faststart_sponsor_limit"  type="text"  value="<?php echo $setting['bmw_cake4u_faststart_sponsor_limit'];?>"  placeholder="<?php _e('FastStart Direct Sponsor limit','BMW');?>" class="let-form-control let-rounded-0 let-number-only">
    <?php if (isset($error['bmw_cake4u_faststart_sponsor_limit']) && !empty($error['bmw_cake4u_faststart_sponsor_limit'])) { ?>
<div class="let-alert let-alert-danger let-bmw-left-border  let-p-1 let-text-left let-rounded-0  let-m-1"><?php echo $error['bmw_cake4u_faststart_sponsor_limit'];?></div><?php } ?></td>
<td></td>
   </tr> 
     <tr>
    <td ><?php _e('FastStart Volume limit','BMW');?></td>
    <td><input name="bmw_elegibility[bmw_cake4u_faststart_volume_limit]" id="bmw_cake4u_faststart_volume_limit"  type="text"  value="<?php echo $setting['bmw_cake4u_faststart_volume_limit'];?>"  placeholder="<?php _e('FastStart Volume limit','BMW');?>" class="let-form-control let-rounded-0 let-number-only">
    <?php if (isset($error['bmw_cake4u_faststart_volume_limit']) && !empty($error['bmw_cake4u_faststart_volume_limit'])) { ?>
<div class="let-alert let-alert-danger let-bmw-left-border  let-p-1 let-text-left let-rounded-0  let-m-1"><?php echo $error['bmw_cake4u_faststart_volume_limit'];?></div><?php } ?></td>
<td></td>
   </tr>
     <tr>
    <td ><?php _e('Personal Volume','BMW');?></td>
    <td><input name="bmw_elegibility[bmw_cake4u_personal_volume]" id="bmw_cake4u_personal_volume"  type="text"  value="<?php echo $setting['bmw_cake4u_personal_volume'];?>"  placeholder="<?php _e('FastStart day limit','BMW');?>" class="let-form-control let-rounded-0 let-number-only">
    <?php if (isset($error['bmw_cake4u_personal_volume']) && !empty($error['bmw_cake4u_personal_volume'])) { ?>
<div class="let-alert let-alert-danger let-bmw-left-border  let-p-1 let-text-left let-rounded-0  let-m-1"><?php echo $error['bmw_cake4u_personal_volume'];?></div><?php } ?></td>
<td></td>
   </tr>
   
  </tbody>
  <tfoot>
    <tr>
      <td colspan="3" class="let-text-center"><button class="let-btn let-btn-success let-rounded-0 let-btn-sm"><?php _e('Save Eligibility Settings','BMW');?></button></td>
    </tr>
  </tfoot>
  </table>
</form>
</div>

<?php 
}
}