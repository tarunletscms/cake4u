<?php 

class BMW_PAYOUT
{
  
  public static function bmw_setting_payout()
  {

	global $wpdb;
$error=array();
$general_settings=get_option('bmw_manage_general');
if(isset($_REQUEST['bmw_payout']) && !empty($_REQUEST['bmw_payout']))
{
  $data=sanitize_text_array($_REQUEST['bmw_payout']);
  foreach ($data as $key => $field) {
    if(empty($field))
    {
      $error[$key]=ucwords(str_replace('_', ' ', str_replace('bmw_', '', $key))).__(" Can't Empty");
      unset($data[$key]);
    }
  }
  if(!empty($data))
  {
    if(isset($data['bmw_points_value'])){
    update_option('bmw_manage_general',$general_settings+array('bmw_points_value'=>$data['bmw_points_value']));
    unset($data['bmw_points_value']);
  }
    update_option('bmw_manage_payout',$data);
  }
}
	$setting=get_option('bmw_manage_payout');
	?>
  <div >
<form method="POST">

<table class="let-table table-bordered ">
  <thead class="let-bg-dark text-white">
    <tr class="let-text-center">
      <th class="let-text-center let-p-1" colspan="3"><h3 class="let-text-white let-p-0 let-m-0"><?php echo __('Payout Settings','BMW');?></h3></th>
    </tr>
  </thead>
  <tbody>
    <?php if(isset( $general_settings['bmw_plan_base']) &&  $general_settings['bmw_plan_base']=='points'):?>
         <tr>
         	<td class="let-align-middle let-text-center"><?php _e('Points Value','BMW');?></td>
         	  <td class="let-align-middle let-text-right">
              <?php echo bmw_price(1,'P');?>
            </td>

         	    <td class="let-align-middle"><input name="bmw_payout[bmw_points_value]" id="bmw_points_value" type="text"  value="<?php echo (isset($general_settings['bmw_points_value']))?$general_settings['bmw_points_value']:'';?>"  class="let-form-control let-rounded-0 let-number-only"  placeholder="<?php _e('No. Points','BMW');?>" >
         	    <?php if (isset($error['bmw_points_value']) && !empty($error['bmw_points_value'])) { ?>
<div class="let-alert let-alert-danger  let-bmp-left-border let-p-1 let-text-left let-rounded-0 let-m-1"><?php echo $error['bmw_points_value'];?></div><?php } ?>
</td>
		  </tr>
    <?php endif;?>
         <tr>
          <td class="let-align-middle let-text-center"><?php _e('Pair','BMW');?></td>
            <td class="let-align-middle"><input name="bmw_payout[bmw_pair1]" id="bmw_pair1" type="text"  value="<?php echo (isset($setting['bmw_pair1']))?$setting['bmw_pair1']:'';?>"  class="let-form-control let-rounded-0 let-number-only"  placeholder="<?php _e('Pair1','BMW');?>">
            <?php if (isset($error['bmw_pair1']) && !empty($error['bmw_pair1'])) { ?>
<div class="let-alert let-alert-danger let-bmp-left-border let-p-1 let-text-left let-rounded-0  let-m-1"><?php echo $error['bmw_pair1'];?></div><?php } ?>
</td>

              <td class="let-align-middle"><input name="bmw_payout[bmw_pair2]" id="bmw_pair2" type="text"  value="<?php echo (isset($setting['bmw_pair2']))?$setting['bmw_pair2']:'';?>"  class="let-form-control let-rounded-0 let-number-only"  placeholder="<?php _e('Pair1','BMW');?>" >
              <?php if (isset($error['bmw_pair2']) && !empty($error['bmw_pair2'])) { ?>
<div class="let-alert let-alert-danger  let-bmp-left-border let-p-1 let-text-left let-rounded-0 let-m-1"><?php echo $error['bmw_pair2'];?></div><?php } ?>
</td>
      </tr>
      <!--    <tr>
         	<td class="let-align-middle let-text-center"><?php _e('Further Pair','BMW');?></td>

         	  <td class="let-align-middle"><input name="bmw_payout[bmw_further_pair1]" id="bmw_further_pair1" type="text"  value="<?php echo (isset($setting['bmw_further_pair1']))?$setting['bmw_further_pair1']:'';?>" class="let-form-control let-rounded-0 let-number-only"  placeholder="<?php _e('Pair1','BMW');?>">
         	  <?php if (isset($error['bmw_further_pair1']) && !empty($error['bmw_further_pair1'])) { ?>
<div class="let-alert let-alert-danger  let-bmp-left-border let-p-1 let-text-left let-rounded-0  let-m-1"><?php echo $error['bmw_further_pair1'];?></div><?php } ?>
</td>
         	    <td class="let-align-middle"><input name="bmw_payout[bmw_further_pair2]" id="bmw_further_pair2" type="text"  value="<?php echo (isset($setting['bmw_further_pair2']))?$setting['bmw_further_pair2']:'';?>"  class="let-form-control let-rounded-0 let-number-only"  placeholder="<?php _e('Pair1','BMW');?>" >
         	    <?php if (isset($error['bmw_further_pair2']) && !empty($error['bmw_further_pair2'])) { ?>
<div class="let-alert let-alert-danger  let-bmp-left-border let-p-1 let-text-left let-rounded-0  let-m-1"><?php echo $error['bmw_further_pair2'];?></div><?php } ?>
</td>
		  </tr> -->
      <!--    <tr>
         	<td class="let-align-middle let-text-center"><?php _e('Initial Pairs','BMW');?></td>

         	  <td colspan="2"><input name="bmw_payout[bmw_initial_pair]" id="bmw_initial_pair" type="text"  value="<?php echo (isset($setting['bmw_initial_pair']))?$setting['bmw_initial_pair']:'';?>" class="let-form-control let-rounded-0 let-number-only"  placeholder="<?php _e('Initial Pairs','BMW');?>">
         	  	<?php if (isset($error['bmw_initial_pair']) && !empty($error['bmw_initial_pair'])) { ?>
<div class="let-alert let-alert-danger  let-bmp-left-border let-p-1 let-text-left let-rounded-0  let-m-1"><?php echo $error['bmw_initial_pair'];?></div><?php } ?>
</td>
         	   
		  </tr> -->
         <tr>
         	<td class="let-align-middle let-text-center"><?php _e('Week Provenue ','BMW');?></td>

         	  <td class="let-align-middle"><input name="bmw_payout[bmw_week_provenue]" id="bmw_week_provenue" type="text"  value="<?php echo (isset($setting['bmw_week_provenue']))?$setting['bmw_week_provenue']:'';?>" class="let-form-control let-rounded-0 let-number-only"  placeholder="<?php _e('Binary Bonus Amount','BMW');?>" >
         	  <?php if (isset($error['bmw_week_provenue']) && !empty($error['bmw_week_provenue'])) { ?>
<div class="let-alert let-alert-danger  let-bmp-left-border let-p-1 let-text-left let-rounded-0  let-m-1"><?php echo $error['bmw_week_provenue'];?></div><?php } ?>
</td>
         		<td ><select name="bmw_payout[bmw_week_provenue_type]" id="bmw_week_provenue_type" type="text"  value="1" class="let-form-control let-rounded-0" >
						<option value="fixed" <?php echo ($setting['bmw_week_provenue_type']=='fixed')?'selected':'';?>><?php _e('Fixed','BMW');?></option>
						<option value="percentage" <?php echo ($setting['bmw_week_provenue_type']=='percentage')?'selected':'';?>><?php _e('Percent','BMW');?></option>
					</select>
				</td>
         	   
		  </tr>  
      <tr>
          <td class="let-align-middle let-text-center"><?php _e('Binary Bonus','BMW');?></td>

            <td class="let-align-middle"><input name="bmw_payout[bmw_initial_pair_commission_amount]" id="bmw_initial_pair_commission_amount" type="text"  value="<?php echo (isset($setting['bmw_initial_pair_commission_amount']))?$setting['bmw_initial_pair_commission_amount']:'';?>" class="let-form-control let-rounded-0 let-number-only"  placeholder="<?php _e('Binary Bonus Amount','BMW');?>" >
            <?php if (isset($error['bmw_initial_pair_commission_amount']) && !empty($error['bmw_initial_pair_commission_amount'])) { ?>
<div class="let-alert let-alert-danger  let-bmp-left-border let-p-1 let-text-left let-rounded-0  let-m-1"><?php echo $error['bmw_initial_pair_commission_amount'];?></div><?php } ?>
</td>
            <td ><select name="bmw_payout[bmw_initial_pair_commission_type]" id="bmw_initial_pair_commission_type" type="text"  value="1" class="let-form-control let-rounded-0" >
            <option value="fixed" <?php echo ($setting['bmw_initial_pair_commission_type']=='fixed')?'selected':'';?>><?php _e('Fixed','BMW');?></option>
            <option value="percentage" <?php echo ($setting['bmw_initial_pair_commission_type']=='percentage')?'selected':'';?>><?php _e('Percent','BMW');?></option>
          </select>
        </td>
             
      </tr>
         <tr>
         	<td class="let-align-middle let-text-center"><?php _e('Direct Bonus','BMW');?></td>

         	  <td class="let-align-middle"><input name="bmw_payout[bmw_referral_commission_amount]" id="bmw_referral_commission_amount" type="text"  value="<?php echo (isset($setting['bmw_referral_commission_amount']))?$setting['bmw_referral_commission_amount']:'';?>" class="let-form-control let-rounded-0 let-number-only"   placeholder="<?php _e('Referral Commission Amount','BMW');?>" >
         	  <?php if (isset($error['bmw_referral_commission_amount']) && !empty($error['bmw_referral_commission_amount'])) { ?>
<div class="let-alert let-alert-danger  let-bmp-left-border let-p-1 let-text-left let-rounded-0  let-m-1"><?php echo $error['bmw_referral_commission_amount'];?></div><?php } ?>
</td>
         		<td  ><select name="bmw_payout[bmw_referral_commission_type]" id="bmw_referral_commission_type" type="text"  value="1" class="let-form-control let-rounded-0" >
						<option value="fixed" <?php echo ($setting['bmw_referral_commission_type']=='fixed')?'selected':'';?>><?php _e('Fixed','BMW');?></option>
						<option value="percentage" <?php echo ($setting['bmw_referral_commission_type']=='percentage')?'selected':'';?>><?php _e('Percent','BMW');?></option>
					</select>
				</td>
         	   
		  </tr>
       <tr>
          <td class="let-align-middle let-text-center"><?php _e('FastStart Bonus','BMW');?></td>

            <td class="let-align-middle"><input name="bmw_payout[bmw_faststart_amount]" id="bmw_faststart_amount" type="text"  value="<?php echo (isset($setting['bmw_faststart_amount']))?$setting['bmw_faststart_amount']:'';?>" class="let-form-control let-rounded-0 let-number-only"  placeholder="<?php _e('FastStart Bonus amount','BMW');?>" >
            <?php if (isset($error['bmw_faststart_amount']) && !empty($error['bmw_faststart_amount'])) { ?>
<div class="let-alert let-alert-danger  let-bmp-left-border let-p-1 let-text-left let-rounded-0  let-m-1"><?php echo $error['bmw_faststart_amount'];?></div><?php } ?>
</td>
            <td ><select name="bmw_payout[bmw_faststart_amount_type]" id="bmw_faststart_amount_type" type="text"  value="1" class="let-form-control let-rounded-0" >
            <option value="fixed" <?php echo ($setting['bmw_faststart_amount_type']=='fixed')?'selected':'';?>><?php _e('Fixed','BMW');?></option>
            <option value="percentage" <?php echo ($setting['bmw_faststart_amount_type']=='percentage')?'selected':'';?>><?php _e('Percent','BMW');?></option>
          </select>
        </td>
             
      </tr>
       <tr>
          <td class="let-align-middle let-text-center"><?php _e('Leadership Bonus Pool','BMW');?></td>

            <td class="let-align-middle"><input name="bmw_payout[bmw_leadership_bonus_pool]" id="bmw_leadership_bonus_pool" type="text"  value="<?php echo (isset($setting['bmw_leadership_bonus_pool']))?$setting['bmw_leadership_bonus_pool']:'';?>" class="let-form-control let-rounded-0 let-number-only"  placeholder="<?php _e('Leadership bonus pool','BMW');?>" >
            <?php if (isset($error['bmw_leadership_bonus_pool']) && !empty($error['bmw_leadership_bonus_pool'])) { ?>
<div class="let-alert let-alert-danger  let-bmp-left-border let-p-1 let-text-left let-rounded-0  let-m-1"><?php echo $error['bmw_leadership_bonus_pool'];?></div><?php } ?>
</td>
            <td ><select name="bmw_payout[bmw_leadership_bonus_pool_type]" id="bmw_leadership_bonus_pool_type" type="text"  value="1" class="let-form-control let-rounded-0" >
            <option value="fixed" <?php echo ($setting['bmw_leadership_bonus_pool_type']=='fixed')?'selected':'';?>><?php _e('Fixed','BMW');?></option>
            <option value="percentage" <?php echo ($setting['bmw_leadership_bonus_pool_type']=='percentage')?'selected':'';?>><?php _e('Percent','BMW');?></option>
          </select>
        </td>
             
      </tr>
        <!--  <tr>
         	<td class="let-align-middle let-text-center"><?php _e('Further Pair Amount','BMW');?></td>

         	  <td class="let-align-middle"><input name="bmw_payout[bmw_further_amount]" id="bmw_further_amount" type="text"  value="<?php echo (isset($setting['bmw_further_amount']))?$setting['bmw_further_amount']:'';?>" class="let-form-control let-rounded-0 let-number-only"   placeholder="<?php _e('Initial Pair Commission Amount','BMW');?>" >
         	  <?php if (isset($error['bmw_further_amount']) && !empty($error['bmw_further_amount'])) { ?>
<div class="let-alert let-alert-danger  let-bmp-left-border let-p-1 let-text-left let-rounded-0  let-m-1"><?php echo $error['bmw_further_amount'];?></div><?php } ?>
</td>
         		<td  ><select name="bmw_payout[bmw_further_amount_type]" id="bmw_further_amount_type" type="text"  value="1" class="let-form-control let-rounded-0" >
						<option value="fixed" <?php echo ($setting['bmw_further_amount_type']=='fixed')?'selected':'';?>><?php _e('Fixed','BMW');?></option>
						<option value="percentage" <?php echo ($setting['bmw_further_amount_type']=='percentage')?'selected':'';?>><?php _e('Percent','BMW');?></option>
					</select>
				</td>
         	   
		  </tr> -->
         <tr>
         	<td class="let-align-middle let-text-center"><?php _e('Service Charge (If any)','BMW');?></td>

         	  <td class="let-align-middle"><input name="bmw_payout[bmw_service_charge_amount]" id="bmw_service_charge_amount" type="text"  value="<?php echo (isset($setting['bmw_service_charge_amount']))?$setting['bmw_service_charge_amount']:'';?>" class="let-form-control let-rounded-0 let-number-only"   placeholder="<?php _e('Service Charge Amount','BMW');?>" >
         	  <?php if (isset($error['bmw_service_charge_amount']) && !empty($error['bmw_service_charge_amount'])) { ?>
<div class="let-alert let-alert-danger  let-bmp-left-border let-p-1 let-text-left let-rounded-0  let-m-1"><?php echo $error['bmw_service_charge_amount'];?></div><?php } ?>
</td>
         		<td  ><select name="bmw_payout[bmw_service_charge_type]" id="bmw_service_charge_type" type="text"  value="1" class="let-form-control let-rounded-0" >
						<option value="fixed" <?php echo ($setting['bmw_service_charge_type']=='fixed')?'selected':'';?>><?php _e('Fixed','BMW');?></option>
						<option value="percentage" <?php echo ($setting['bmw_service_charge_type']=='percentage')?'selected':'';?>><?php _e('Percent','BMW');?></option>
					</select>
				</td>
         	   
		  </tr>
         <tr>
         	<td class="let-align-middle let-text-center"><?php _e('Tax Deduction','BMW');?></td>

         	  <td class="let-align-middle"><input name="bmw_payout[bmw_tds]" id="bmw_tds" type="text"  value="<?php echo (isset($setting['bmw_tds']))?$setting['bmw_tds']:'';?>" class="let-form-control let-rounded-0 let-number-only"   placeholder="<?php _e('Tds','BMW');?>" >
         	  <?php if (isset($error['bmw_tds']) && !empty($error['bmw_tds'])) { ?>
<div class="let-alert let-alert-danger  let-bmp-left-border let-p-1 let-text-left let-rounded-0  let-m-1"><?php echo $error['bmw_tds'];?></div><?php } ?>
</td>

         		<td  ><select name="bmw_payout[bmw_tds_type]" id="bmw_tds_type" type="text"  value="1" class="let-form-control let-rounded-0" >
						<option value="fixed" <?php echo ($setting['bmw_tds_type']=='fixed')?'selected':'';?>><?php _e('Fixed','BMW');?></option>
						<option value="percentage" <?php echo ($setting['bmw_tds_type']=='percentage')?'selected':'';?>><?php _e('Percent','BMW');?></option>
					</select>
				</td>
         	   
		  </tr>
	     </tbody>
	     <tfoot>
    <tr>
      <td colspan="3" class="let-text-center"><button class="let-btn let-btn-success let-rounded-0 let-btn-sm"><?php _e('Save Payout Settings','BMW');?></button></td>
    </tr>
  </tfoot>
        </table>
		</div>

	</div>

</div>
<?php 
}
}
