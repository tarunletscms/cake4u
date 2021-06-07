<?php 
class BMW_LEVEL_COMMISSION {
	public static function bmw_setting_level(){
		$bmw_error=array();
		
	 		if(isset($_REQUEST['bmw_level']) && is_lic_validate())
			{
			$new_level_commission_array=array();
			$new_level_name_array=array();
			$bmw_levels=sanitize_text_array($_POST['bmw_level']);
			if(!empty($bmw_levels)){
				$i=1;
				foreach ($bmw_levels as $key => $value) {
					if( !(!empty($value['bmw_level_name']) && is_numeric($value['bmw_level_amount']) && $value['bmw_level_amount'] > 0 && !empty($value['bmw_level_type'])) )
					{
						$bmw_error[$i]['bmw_level_name']   = $value['bmw_level_name'];
						$bmw_error[$i]['bmw_level_amount'] = $value['bmw_level_amount'];
						$bmw_error[$i]['bmw_level_type'] = $value['bmw_level_type'];
						$new_level_name_array[$i]['bmw_level_name'] = '';
						$new_level_commission_array[$i]['bmw_level_amount'] = '';
						$new_level_commission_array[$i]['bmw_level_type'] = '';
					}
					else{
						$new_level_name_array[$i]['bmw_level_name'] = $value['bmw_level_name'];
						$new_level_commission_array[$i]['bmw_level_amount'] = $value['bmw_level_amount'];
						$new_level_commission_array[$i]['bmw_level_type'] = $value['bmw_level_type'];
						
					}
					$i++;
				}
				update_option('bmw_level_name', $new_level_name_array);
				update_option('bmw_level_commission', $new_level_commission_array);

			}
	
			if(!empty($bmw_error)){
				 $error = __("Please correct red rows first",'BMW');
			echo '<div class="error settings-error notice is-dismissible"><p>'. $error .'</p></div>';
			}else{
				$message = __("You have successfully updated your Commissions settings.",'BMW');
			echo '<div class="updated settings-error notice is-dismissible"><p>'.$message.'</p></div>';
			}

        }
         	 $bmw_level_name=get_option( 'bmw_level_name' );
         	 $bmw_level_commission=get_option( 'bmw_level_commission' );
         	 $level_settings = get_option('bmw_level_settings');
?>

<div >
	<form action="" method="post" name="bmw_level_commission" id="bmw_level_commission">
		<table class="let-table let-table-bordered">
			<thead class="let-bg-dark let-text-white">
				<tr class="let-text-center">
				<th colspan="3" class="let-p-1">
					<h3 class="let-text-white let-p-0 let-m-0"><?php echo __('Level Commissions','BMW');?></h3>
				</th>
				</tr>
			<tr class="let-text-center">
			<th class="let-p-0"><?php echo __('Level Name','BMW');?></th>
			<th class="let-p-0"><?php echo __('Commission Amount','BMW');?></th>
			<th class="let-p-0"><?php echo __('Commission Type','BMW');?></th>
		</tr>
		</thead>
		<tbody >
			<?php 
			if(isset($level_settings['bmw_level_status']) && !empty($level_settings['bmw_level_status']) && $level_settings['bmw_levels_count']>0){
			for ($i=1; $i <= $level_settings['bmw_levels_count']; $i++) 
			{ 
				?>
				<tr <?php if(isset($bmw_error[$i]) ){ echo 'class="let-alert-danger"'; } ?> >
				<td class="let-text-center">
					<input type="text" class="let-form-control let-rounded-0" placeholder="<?php echo sprintf(__('Specify the level %s Name','BMW'), $i);?>" name="bmw_level[<?php echo $i;?>][bmw_level_name]" value="<?php echo $bmw_level_name[$i]['bmw_level_name'];?>">
				</td>
				<td class="let-text-center">
					<input type="text" class="let-form-control let-rounded-0 let-number-only" placeholder="<?php _e('Amount','BMW');?>" name="bmw_level[<?php echo $i;?>][bmw_level_amount]" value="<?php echo $bmw_level_commission[$i]['bmw_level_amount'];?>">
				</td>
				<td class="let-text-center">
				<select name="bmw_level[<?php echo $i;?>][bmw_level_type]" class="let-form-control let-rounded-0">
					<option value=""><?php echo __('Type','BMW');?></option>
					<option value="fixed"<?php if( isset($bmw_level_commission[$i]['bmw_level_type']) && $bmw_level_commission[$i]['bmw_level_type']=='fixed'){echo 'Selected';}?>><?php echo __('Fixed','BMW');?></option>
					<option value="percent" <?php if( isset($bmw_level_commission[$i]['bmw_level_type']) && $bmw_level_commission[$i]['bmw_level_type']=='percent'){echo 'Selected';}?>><?php echo __('Percent','BMW');?></option>
				</select>
				</td>
			</tr>
			<?php
			} } ?>
		</tbody>
		<tfoot class=" let-text-white">
			<tr>
				<td colspan="3" class="let-text-center">
				<button type="submit"  class="let-btn let-btn-success let-btn-sm let-rounded-0"><?php echo __('Save Level Commission','BMW')?></button></td>
			</tr>
			
		</tfoot>
	</table>
</form>
</div>
<?php } } ?>