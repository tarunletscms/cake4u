<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; 
}
class BMW_RUN_PAYOUT
{
	public static function bmw_payout_run_page()
	{
		$dataArray=bmw_payout_display_functions();
		  	$settings=get_option('bmw_manage_general');
            
	?>        
	  <table class="let-table let-table-bordered lets-datatable dt-responsive">
	    <thead class="let-bg-dark text-white text-center">
	   	  <tr>
	   	  	<th></th>
	   	  	<th colspan="<?php echo (@$settings['bmw_plan_base']=='points')?'9':'8';?>" class="let-text-center let-text-white"> <?php _e('Run Payouts','BMW');?></th>
	   	  	<th></th>
	      </tr>
	      <tr class="let-text-white let-bg-success">
	        <th class="let-text-center let-align-middle let-bg-dark ">#</th>
	        <th class="let-text-center let-align-middle"><?php _e('User Name','BMW');?></th>
	       <th class="let-text-center let-align-middle"><?php _e('Pair Commission','BMW');?></th>
	       <th class='text-center let-align-middle'><?php _e('Referral Commission','BMW');?></th>
	        <th class="let-text-center let-align-middle"><?php _e('Level Commission','BMW');?></th>
	        <th class="let-text-center let-align-middle"><?php _e('Regular Bonus','BMW');?></th>
	        <th class="let-text-center let-align-middle"> <?php _e('Total Points','BMW');?></th>	        
	        <th class="let-text-center let-align-middle"><?php _e('Service Charge','BMW');?></th>
	        <th class="let-text-center let-align-middle"><?php _e('TDS','BMW');?></th>
	        <th class="let-text-center let-align-middle"> <?php _e('Net Amount','BMW');?></th>
	        <th class="let-text-center let-align-middle let-bg-dark "></th>
	      </tr>
	     
	    </thead>
	    <tbody>
	    	<?php 
	    	if($dataArray){
	    		$i=1;
	    	foreach($dataArray as $key=>$row){?>
	      <tr class="let-text-center">
	        <td class="let-bg-dark let-text-white"><?php echo $i;?></td>
	        <td class="let-bg-info let-text-white"><?php echo $row['username'];?></td>
	        <td><?php echo $row['pair_commission'];  ?></td>
	      	<td><?php echo $row['referral_commission'];?></td>
	        <td><?php echo $row['level_commission'];?></td>
	        <td><?php echo $row['regular_bonus'];?></td>
	        <td><?php echo bmw_price(@$row['total_points'],'PV');?></td>
	        <td><?php echo bmw_price($row['service_charge']);?></td>
	        <td><?php echo bmw_price($row['tds']);?></td>
	        <td><?php echo bmw_price($row['net_amount']);?></td>
	        <td class="let-bg-dark let-text-white"></td>
	      </tr>
	      <?php $i++;
	  }
	}?>
	  		<tfoot>
	  		<tr class="let-bg-success let-text-white let-text-center">
	  			<td class="let-bg-dark"></td>
	  			<td><?php echo __('Total','BMW');?></td>
	  			<td><?php echo array_sum(array_column($dataArray,'pair_commission'));?></td>
	  			<td><?php echo array_sum(array_column($dataArray,'referral_commission'));?></td>
	  			<td><?php echo array_sum(array_column($dataArray,'level_commission'));?></td>
	  			<td><?php echo array_sum(array_column($dataArray,'regular_bonus'));?></td>
	  			<td><?php echo bmw_price(array_sum(array_column($dataArray,'total_points')),'PV');?></td>
	  			<td><?php echo bmw_price(array_sum(array_column($dataArray,'service_charge')));?></td>
	  			<td><?php echo bmw_price(array_sum(array_column($dataArray,'tds')));?></td>
	  			<td><?php echo bmw_price(array_sum(array_column($dataArray,'net_amount')));?></td>
	  			<td  class="let-bg-dark"></td>
	  		</tr>
	  		<tr class="let-bg-dark let-text-white let-text-center">
	    	<th colspan="<?php echo (@$settings['bmw_plan_base']=='points')?'11':'10';?>" class="let-text-center">
	    		<?php if(array_sum(array_column($dataArray,'net_amount'))>0):?>
			<button class="let-btn let-btn-success let-rounded-0 let-btn-sm" onclick="bmw_run_payout('<?php echo admin_url('admin-ajax.php');?>');"><?php echo __('Run Payout','BMW');?></button>
				<?php endif;?>
		</th>
	    	</tr>
	    </tfoot>
	    </tbody>
	  </table>
	
<?php 
	}
}