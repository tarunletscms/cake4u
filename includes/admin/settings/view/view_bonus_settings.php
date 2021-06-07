<?php 

class BMW_BONUSES 
{
  
public static function bmw_setting_bonuses()
  {
   
	global $wpdb;
$error=array();
if(isset($_REQUEST['bmw_bonus_criteria']) && !empty($_REQUEST['bmw_bonus_criteria']))
{
  $criteria=sanitize_text_field($_REQUEST['bmw_bonus_criteria']);
  if(!empty($criteria))
  {
    update_option('bmw_bonus_criteria',$criteria);
  }
}
if(isset($_REQUEST['bmw_bonus']) && !empty($_REQUEST['bmw_bonus']))
{
  $data=sanitize_text_array($_REQUEST['bmw_bonus']);
  if(!empty($data)){
  foreach ($data as $key => $field) {
    if(empty($field['pair']) || empty($field['amount']))
    {
      $error[$key]=__("PLease Correct this Slab",'BMW');
      unset($data[$key]);
    }
  }
}
  if(!empty($data))
  {
    update_option('bmw_bonus',$data);
  }
}
	
	?>
	<?php $row_num=0;
	$bmw_bonus_criteria=get_option('bmw_bonus_criteria');
	$bmw_bonuses=get_option('bmw_bonus');
	
	?>
	<div >
<form method="POST">

<table class="let-table let-table-bordered ">
  <thead class="let-bg-dark let-text-white">
    <tr class="let-text-center">
      <th class="let-text-center let-p-1" colspan="3"><h3 class="let-text-white let-p-0 let-m-0"><?php echo __('Bonus Settings','BMW');?></h3></th>
    </tr>
  </thead>
  <tbody id="bonus_slab_rows">
     <tr>
     	<th class="let-text-center ">
		<?php _e('Bonus Criteria','BMW');?>
		</th>	
	<td colspan="2" class="let-text-center">
   <select name="bmw_bonus_criteria" id="bmw_bonus_criteria"class="let-form-control let-rounded-0">
		<option value=""><?php _e('Select Bonus Criteria','BMW');?></option>
		<option value="pair" <?php echo ($bmw_bonus_criteria=='pair')?'selected=selected':'';?>><?php _e('No. of Pairs','BMW');?></option>
		<option value="personal" <?php echo ($bmw_bonus_criteria=='personal')?'selected=selected':'';?>><?php _e('No. of Personal Referrals','BMW');?></option>
   </select>
  	</td>
  </tr>

     <tr>
	
	<th colspan="3" class="let-text-center let-bg-secondary let-text-white">
		<?php _e('Bonus Slab','BMW');?></th>
	</tr>
<?php if($bmw_bonuses){ foreach($bmw_bonuses as $key=>$bmw_bonus){?>
	 <tr id="bmw_bonus_row_<?php echo $row_num;?>" class="let-text-center">
	 <td>
		<input name="bmw_bonus[<?php echo $row_num;?>][pair]"   type="text" value="<?php echo $bmw_bonus['pair'];?>" class="let-form-control let-rounded-0 let-number-only" placeholder="<?php _e('No. of Pairs','BMW');?>">
	</td>
	<td>
		<input name="bmw_bonus[<?php echo $row_num;?>][amount]"   type="text" style="" value="<?php echo $bmw_bonus['amount'];?>" class="let-form-control let-rounded-0  let-number-only" placeholder="">
	</td>
	<td>
		<button class="let-btn let-btn-danger let-btn-sm let-rounded-0"  onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" type="button" onclick="removeBonusRow(<?php echo $row_num;?>)"><?php echo _e('Remove','BMW');?></button>
	</td>
</tr>
<?php 
$row_num++;
}
}
 ?>
 
  </tbody>
  <tfoot>
  	<tr>
	<td colspan="2" class="let-text-center">
   <button type="submit" class="let-btn let-btn-success let-btn-sm let-rounded-0"><?php _e('Submit','BMW');?></button>
  	</td>
	<td class="let-text-center">
   <buttontype="button" onclick="addBonusRow()" class="let-btn let-btn-info let-btn-sm let-rounded-0"><?php _e('Add','BMW');?></button>
  	</td>
  </tr>
  </tfoot>
  </table>				
</form>
</div>
				
<script>

var row_num='<?php echo $row_num;?>';
function addBonusRow(){
	$('#bonus_slab_rows').append('<tr id="bmw_bonus_row_'+row_num+'" class="let-text-center"><td><input name="bmw_bonus['+row_num+'][pair]"  onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57 || event.charCode==46))" type="text" value="" class="let-form-control let-rounded-0" placeholder="<?php _e('No. of Pairs','BMW');?>"></td><td><input name="bmw_bonus['+row_num+'][amount]"  onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57) || event.charCode==46)" type="text" class="let-form-control let-rounded-0" placeholder="<?php _e('Amount','BMW');?>"></td><td><button class="let-btn let-btn-danger let-btn-sm let-rounded-0"  onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" type="button" onclick="removeBonusRow('+row_num+')"><?php echo _e('Remove','BMW');?></button></td></tr>');
	row_num++;
}

function removeBonusRow(row_num){
	$( '#bmw_bonus_row_'+row_num ).remove();
}

</script>
<?php 
}
}
	