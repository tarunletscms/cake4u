<?php 

class BMW_LEADERSHIPBONUS
{
  
  public static function bmw_leadership_bonus_payout()
  {

	global $wpdb;
$error=array();
$general_settings=get_option('bmw_manage_general');

if(isset($_REQUEST['bmw_leadership']) && !empty($_REQUEST['bmw_leadership']))
{
 
  $data=sanitize_text_array($_REQUEST['bmw_leadership']);

  $i=0;
  foreach ($data as $key => $value) {
  if( empty($value['bmw_leader_rank_name'])  ) 
   {
   
     $error[$i]['bmw_leader_rank_name']   = $value['bmw_leader_rank_name'];
     $data[$i]['bmw_leader_rank_name']          = '';
   
   }else{
     $data[$i]['bmw_leader_rank_name']          = $value['bmw_leader_rank_name'];
     $data[$i]['bmw_leader_personal_sponsor']   = $value['bmw_leader_personal_sponsor'];
     $data[$i]['bmw_leader_personal_volume']    = $value['bmw_leader_personal_volume'];
     $data[$i]['bmw_leader_group_volume']       = $value['bmw_leader_group_volume'];
     $data[$i]['bmw_leader_one_time_bonus']     = $value['bmw_leader_one_time_bonus'];
     $data[$i]['bmw_leader_binary_bonus']       = $value['bmw_leader_binary_bonus'];
     $data[$i]['bmw_leader_leadership_bonus']   = $value['bmw_leader_leadership_bonus'];
     // $data[$i]['bmw_leader_leadership_bonus']   = $value['bmw_leader_leadership_bonus'];
     $data[$i]['bmw_leader_type']               = $value['bmw_leader_type'];
     $data[$i]['bmw_leader_count']                = $value['bmw_leader_count'];
     $data[$i]['id']                    = $value['id'];
   }
    $i++;
  }
  // echo '<pre>';print_r($error);die;
 

    if(!empty($error)){
         $error = __("Please correct red rows first",'BMW');
         echo '<div class="error settings-error notice is-dismissible"><p>'. $error .'</p></div>';
      }else{

        foreach($data as $bonus){
          
           if(!exist_class_id($bonus['id'])){
            $wpdb->query("INSERT INTO {$wpdb->prefix}bmw_leadership_commission_setting (leader_name,personal_sponsor,personal_volume,inline_leader_count,Leader_type,group_volume,one_time_bonus,binary_bonus,leadership_bonus) values('".$bonus['bmw_leader_rank_name']."','".$bonus['bmw_leader_personal_sponsor']."','".$bonus['bmw_leader_personal_volume']."','". $bonus['bmw_leader_count']."','".$bonus['bmw_leader_type']."','".$bonus['bmw_leader_group_volume']."','".$bonus['bmw_leader_one_time_bonus']."','".$bonus['bmw_leader_binary_bonus']."','".$bonus['bmw_leader_leadership_bonus']."')");
            }
          else{
            
              $wpdb->query("UPDATE {$wpdb->prefix}bmw_leadership_commission_setting  SET leader_name='".$bonus['bmw_leader_rank_name']."',personal_sponsor='".$bonus['bmw_leader_personal_sponsor']."',personal_volume='".$bonus['bmw_leader_personal_volume']."',inline_leader_count='". $bonus['bmw_leader_count']."',Leader_type='".$bonus['bmw_leader_type']."',group_volume='".$bonus['bmw_leader_group_volume']."',one_time_bonus='".$bonus['bmw_leader_one_time_bonus']."',binary_bonus='".$bonus['bmw_leader_binary_bonus']."',leadership_bonus='".$bonus['bmw_leader_leadership_bonus']."' WHERE id='".$bonus['id']."'");
           }
         }
         $message = __("You have successfully updated your leader Commissions settings.",'BMW');
         echo '<div class="updated settings-error notice is-dismissible"><p>'.$message.'</p></div>';
      }
}

  $setting=get_leadership_bonus_setting();
 
	?>
  <div >
<form method="POST">

<table class="let-table table-bordered ">
  <thead class="let-bg-dark text-white">
    <tr class="let-text-white let-p-0 let-m-0"><th><?php _e('Rank Name','BMW'); ?></th><th><?php _e('Personal Sponsored Qualification','BMW'); ?></th><th><?php _e('Personal Volume','BMW'); ?></th><th colspan="2"><?php _e('Each leg eligibility','BMW'); ?></th><th><?php _e('Group volume','BMW'); ?></th><th><?php _e('One Time Bonus','BMW'); ?></th><th><?php _e('Binary Bonus','BMW'); ?></th><th><?php _e('Leadership Bonus','BMW'); ?></th></tr>
    <tr class="let-text-white let-p-0 let-m-0"><th colspan="3"></th><th><?php _e('Each leg count','BMW'); ?></th><th><?php _e('Leader type','BMW'); ?></th><th colspan="4"></th></tr>
  </thead>
  <tbody>
    <?php

     for($i=0;$i<=5;$i++){ ?>
 <tr <?php if(isset($error[$i]) ){ echo 'class="let-alert-danger"'; } ?>>
      <td class="let-align-middle"><input name="bmw_leadership[<?php echo $i; ?>][bmw_leader_rank_name]" id="bmw_leader_rank_name" type="text"  value="<?php echo (isset($setting[$i]->leader_name))?$setting[$i]->leader_name:'';?>"  class="let-form-control let-rounded-0"  placeholder="<?php _e('Rank Name','BMW');?>">
      <input type="hidden" name="bmw_leadership[<?php echo $i;?>][id]" value="<?php echo $setting[$i]->id; ?>">     
</td>
<td class="let-align-middle"><input name="bmw_leadership[<?php echo $i; ?>][bmw_leader_personal_sponsor]" id="bmw_leader_personal_sponsor" type="text"  value="<?php echo (isset($setting[$i]->personal_sponsor))?$setting[$i]->personal_sponsor:'';?>"  class="let-form-control let-rounded-0 let-number-only"  placeholder="<?php _e('Personal Sponsor Count','BMW');?>">
           
</td>
<td class="let-align-middle"><input name="bmw_leadership[<?php echo $i; ?>][bmw_leader_personal_volume]" id="bmw_leader_personal_volume" type="text"  value="<?php echo (isset($setting[$i]->personal_volume))?$setting[$i]->personal_volume:'';?>"  class="let-form-control let-rounded-0 let-number-only"  placeholder="<?php _e('Personal Volume Amount','BMW');?>">
           
</td>
<td class="let-align-middle"><input name="bmw_leadership[<?php echo $i; ?>][bmw_leader_count]" id="bmw_leader_count" type="text"  value="<?php echo (isset($setting[$i]->inline_leader_count))?$setting[$i]->inline_leader_count:'';?>"  class="let-form-control let-rounded-0 let-number-only"  placeholder="<?php _e('Leader count','BMW');?>">
           
</td>
<td class="let-align-middle">
       <select name="bmw_leadership[<?php echo $i;?>][bmw_leader_type]" class="let-form-control let-rounded-0">
          <option value=""><?php echo __('Type','BMW');?></option>
          <option value="1"<?php if( isset($setting[$i]->Leader_type) && $setting[$i]->Leader_type=='1'){echo 'Selected';}?>><?php echo __('Team Affiliate (TA)','BMW');?></option>
          <option value="2" <?php if( isset($setting[$i]->Leader_type) && $setting[$i]->Leader_type=='2'){echo 'Selected';}?>><?php echo __('Team Leader (TL)','BMW');?></option>
          <option value="3" <?php if( isset($setting[$i]->Leader_type) && $setting[$i]->Leader_type=='3'){echo 'Selected';}?>><?php echo __('Manager (M)','BMW');?></option>
          <option value="4" <?php if( isset($setting[$i]->Leader_type) && $setting[$i]->Leader_type=='4'){echo 'Selected';}?>><?php echo __('Director (D)','BMW');?></option>
          <option value="5" <?php if( isset($setting[$i]->Leader_type) && $setting[$i]->Leader_type=='5'){echo 'Selected';}?>><?php echo __('National Director (ND)','BMW');?></option>
        </select>    
</td>
<td class="let-align-middle"><input name="bmw_leadership[<?php echo $i; ?>][bmw_leader_group_volume]" id="bmw_leader_group_volume" type="text"  value="<?php echo (isset($setting[$i]->group_volume))?$setting[$i]->group_volume:'';?>"  class="let-form-control let-rounded-0 let-number-only"  placeholder="<?php _e('Group volume Amount','BMW');?>">
           
</td>
<td class="let-align-middle"><input name="bmw_leadership[<?php echo $i; ?>][bmw_leader_one_time_bonus]" id="bmw_leader_one_time_bonus" type="text"  value="<?php echo (isset($setting[$i]->one_time_bonus))?$setting[$i]->one_time_bonus:'';?>"  class="let-form-control let-rounded-0 let-number-only"  placeholder="<?php _e('One Time Bonus Amount','BMW');?>">
           
</td>
<td class="let-align-middle"><input name="bmw_leadership[<?php echo $i; ?>][bmw_leader_binary_bonus]" id="bmw_leader_binary_bonus" type="text"  value="<?php echo (isset($setting[$i]->binary_bonus))?$setting[$i]->binary_bonus:'';?>"  class="let-form-control let-rounded-0 let-number-only"  placeholder="<?php _e('Binary Bonus %','BMW');?>">
           
</td>

        <td class="let-align-middle"><input name="bmw_leadership[<?php echo $i; ?>][bmw_leader_leadership_bonus]" id="bmw_leader_leadership_bonus" type="text"  value="<?php echo (isset($setting[$i]->leadership_bonus))?$setting[$i]->leadership_bonus:'';?>"  class="let-form-control let-rounded-0 let-number-only"  placeholder="<?php _e('Leadership Bonus %','BMW');?>" >
             
</td>
      </tr>
        
        <?php } ?>
      
	     </tbody>
	     <tfoot>
    <tr>
      <td colspan="9" class="let-text-center"><button class="let-btn let-btn-success let-rounded-0 let-btn-sm"><?php _e('Save leadership bonus Settings','BMW');?></button></td>
    </tr>
  </tfoot>
        </table>
		</div>

	</div>

</div>
<?php 
}
}
