<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; 
}
class BMW_DISTRIBUTE_COMMISSIONS
{
	public static function bmw_distribute_commission()
	{
		global $wpdb;
	  $bmw_users = $wpdb->get_results("SELECT user_id, user_name, user_key ,leader_post FROM {$wpdb->prefix}bmw_users WHERE payment_status='1'");
	  $last_payout = $wpdb->get_var("SELECT insert_date FROM {$wpdb->prefix}bmw_payout ORDER BY id DESC ");

	  $general_setting=get_option('bmw_manage_general');
	  $current_date=strtotime(date("Y-m-d h:i:s"));
	  $last_payout_date=strtotime($last_payout);
	   if(!empty($last_payout_date) && $general_setting['bmw_payoutrun_day']){
            $diff=$current_date-$last_payout_date;
            $days = round($diff/ (60*60*24));
            if($general_setting['bmw_payoutrun_day']<=$days){
                $payout_cycle= 1;
            }else{
                 $payout_cycle= 0;
            }
        }else{
             $payout_cycle= 1;
        }
      // echo '<pre>'; print_r($bmw_users);die;
 	  $payout_settings = get_option('bmw_manage_payout');
	?>
     
	   <table class="let-table let-table-bordered lets-datatable dt-responsive let-w-100" id="bmw_commissions_distribute_table">
	    <thead class="let-text-white let-text-center">
	      <tr class="let-text-center let-bg-dark">
	        <th class="let-text-center let-align-middle" rowspan="2">#</th>
	        <th class="let-text-center let-align-middle" rowspan="2"><?php _e('User Name','BMW');?></th>	        
	        <th class="let-text-center let-align-middle p-2" colspan="4"><?php _e('Commissions & Bonuses','BMW');?></th>
	        <th class="let-text-center let-align-middle" rowspan="2"><?php _e('Total Amt.','BMW');?></th>
	      </tr>
	      <tr class="let-text-center let-bg-success">
	        <th class="let-text-center"><?php _e('Binary Bonus','BMW');?></th>	
	        <th class="let-text-center"><?php _e('Direct Bonus','BMW');?></th>	
	        <th class="let-text-center"><?php _e('FastStart Bonus','BMW');?></th>	
	        <th class="let-text-center"><?php _e('Leadership Bonus','BMW');?></th>	
	      </tr>
	    </thead>
	    <tbody >
	    	<?php 
	    	if($payout_cycle){
	    	if(!empty($bmw_users)){
	    		$i=1;
	    		$commission_total=array();
	    		$commission_total['pair_commission']=0;
	    		$commission_total['ref_commission']=0;
	    		$commission_total['faststart_commission']=0;
	    		$commission_total['leader_bonus']=0;
	    		$commission_total['one_time_bonus']=0;

	    	foreach($bmw_users as $user){
	    		if(bmw_eligibility_check_for_commission($user->user_key)){
	    			// echo $user->user_key;
	    	$user_total=0;
	    	
	    	 $paircommission 	=	get_user_pair_commission($user->user_id,$user->user_key,$user->leader_post);
	       
	    	$referalcommission  =	get_user_display_referral_commission($user->user_key);
	    	$faststartcommission  =	get_user_display_faststart_commission($user->user_key);
	    	// $levelcommission  	=	get_user_display_level_commission($user->user_key);
	    	$leadershipbonus  	=	get_user_display_leadership_commission($user->user_key);
	    	$onetime_leadership_bonus  	=	get_user_display_one_time_leadership_commission($user->user_key);
	    	// $regularbonus  		=	get_user_display_regular_bonus($user->user_key);
		$pair_total		    =	    array_sum(array_column($paircommission,'amount'));
			// $ref_total		    =      array_sum(array_column($referalcommission,'amount'));
		$faststart_total	=	array_sum(array_column($faststartcommission,'bonus_amount'));
		$one_time_bonus_total	=	array_sum(array_column($onetime_leadership_bonus,'amount'));
		$bonus_total	    =	array_sum(array_column($leadershipbonus,'leadership_bonus'));

			$commission_total['pair_commission']+=$pair_total;
			$user_total+=$pair_total;
			
			$commission_total['faststart_commission']+=$faststart_total;
			$user_total+=$faststart_total;
			$commission_total['one_time_bonus']+=$one_time_bonus_total;
			$user_total+=$one_time_bonus_total;
			$commission_total['leader_bonus']+=$bonus_total;
			$user_total+=$bonus_total;
			
 			if ($user_total <= 0) continue;
	    	?>
	    	<tr class="let-text-center">
	    		<td class="let-align-middle "><?php echo $i;?></td>
	    		<td class="let-align-middle"><?php echo $user->user_name;?></td>
	    		<td class="let-align-middle"><?php 
			    		if(isset($paircommission) && !empty($paircommission)){	
			    		?>
			    		<table class="let-table let-table-sm let-m-0">
			    			<thead class="let-bg-info">
			    				<tr class="let-text-center let-text-white">
			    					<th><?php _e('Childs Name','BMW');?></th>
			    					<th><?php _e('Amount','BMW');?></th>
			    				</tr>
			    			</thead>
			    			<tbody>
			    				<?php 
			    				foreach($paircommission as $key=>$pair){
			    				$childs=unserialize($pair->childs); ?>
			    				<tr class="let-text-center">
			    					<td >
			    						<ul class="let-list-group">
			    						<?php if(!empty($childs))
			    						{
			    							foreach ($childs as $key => $child) {
			    							?>
			    							<li><?php echo bmw_get_username_by_userkey($child);?></li>
			    							<?php 

			    							}
			    						}
			    						?>
			    						</ul>
			    					</td>
			    					<td class="let-align-middle"><?php echo bmw_price($pair->amount,'PV');?></td>
			    				</tr>
			    			<tr class="let-align-middle let-text-white let-bg-info">
			    				<td><?php _e('Left','BMW'); ?></td><td><?php echo $pair->paid_price; ?></td>
			    			</tr>
			    			<tr class="let-align-middle let-text-white let-bg-info">
			    				<td><?php _e('Right','BMW'); ?></td><td><?php echo $pair->paid_price; ?></td>
			    			</tr>
			    			<tr><td colspan="2"></td></tr>
			    			<?php } ?>
			    			</tbody>
			    		</table>
			    		<?php    
			    		}else { echo '---';}  ?>
	    			
	    		</td>
	    		<td class="let-align-middle"><?php 
			    		if(isset($referalcommission) && !empty($referalcommission)){
			    		?>
			    		<table class="let-table let-table-sm let-m-0">
			    			<thead class="let-bg-info">
			    				<tr class="let-text-center let-text-white" >
			    					<th colspan="2"><?php _e('Child Name','BMW');?></th>
			    				</tr>

			    			</thead>
			    			<tbody>
			    				
			    				<?php 
			    				foreach($referalcommission as $referral){ ?>
                                 <?php // echo '<pre>'; print_r($referral['childs']);
			    					 foreach($referral['childs'] as $childs){ ?>
                                 <tr class="let-text-center ">
			    					<td colspan="2"><?php echo bmw_get_username_by_userkey($childs);?></td>
			    				</tr>		
			    				   <?php }  ?>
			    				
			    					<tr class="let-text-center let-bg-info let-text-white">
			    					<th><?php _e('Amount','BMW');?></th>
			    					<th><?php echo bmw_price($referral['amount'],'PV');?></th>
			    				    </tr>
			    			      <?php } ?>
			    			     <tr class="let-text-center let-bg-info let-text-white">
			    			     	<td><?php  _e('Week Provenue','BMW'); ?></td>
			    			     	<td><?php echo $payout_settings['bmw_week_provenue'].'%'; ?></td>
			    			     </tr>
			    			     <tr class="let-text-center let-bg-info let-text-white">
			    			     	<td><?php  _e('Direct Commission','BMW'); ?></td>
			    			     	<td><?php echo $ref_commission= ($referral['amount']*$payout_settings['bmw_week_provenue']/100)* $payout_settings['bmw_referral_commission_amount']/100; ?></td>
			    			     </tr>
			    			</tbody>
			    		</table>
			    		<?php 
			    		 $commission_total['ref_commission']+=$ref_commission;
			             $user_total+=$ref_commission;
			    		}else { echo '---';} ?>
	    			
	    		</td>
	    		<td class="let-align-middle"><?php 
			    		if(isset($faststartcommission) && !empty($faststartcommission)){
			    		?>
			    		<table class="let-table let-table-sm let-m-0">
			    			<thead class="let-bg-info">
			    				<tr class="let-text-center let-text-white">
			    					<th><?php _e('Child Name','BMW');?></th>
			    					<th><?php _e('Amount','BMW');?></th>
			    					<th><?php _e('Date','BMW');?></th>
			    				</tr>
			    			</thead>
			    			<tbody>
			    				<?php 
			    				foreach($faststartcommission as $key=>$commission){ ?>
			    				<tr class="let-text-center">
			    					<td><?php echo bmw_get_username_by_userkey($commission->user_key);?></td>
			    					<td><?php echo $commission->amount;?></td>
			    					<td><?php echo $commission->insert_date;?></td>
			    				</tr>
			    				<tr class="let-text-center let-bg-info let-text-white">
			    					<td colspan="2"><?php _e('Week Provenue','BMW');?></td>
			    					<td><?php echo $payout_settings['bmw_week_provenue'].'%';   ?></td>
			    				</tr>
			    				<tr class="let-text-center let-bg-info let-text-white">
			    					<td colspan="2"><?php _e('FastStart Bonus','BMW');?></td>
			    					<td><?php echo $commission->bonus_amount;  ?></td>
			    				</tr>
			    			<?php } ?>

			    			</tbody>
			    		</table>
			    		<?php 
			    		 
			    		}else { echo '---';}  ?>
	    			
	    		</td>
	    		<td class="let-align-middle"><?php 
			    		if(isset($leadershipbonus) && !empty($leadershipbonus)){
			    		?>
			    		<table class="let-table let-table-sm let-m-0">
			    			<thead class="let-bg-info">
			    				<tr class="let-text-center let-text-white">
			    					<th><?php _e('Company Volume','BMW');?></th>
			    					<th><?php _e('Leader Bonus Type','BMW');?></th>
			    					<th><?php _e('Amount','BMW');?></th>
			    				</tr>
			    			</thead>
			    			<tbody>
			    				<?php 
			    				foreach($leadershipbonus as $key=>$bonus){ ?>
			    				<tr class="let-text-center">
			    					<td><?php echo $bonus->amount;?></td>
			    					<td><?php echo get_leadership_bonus_name_leader_id($bonus->bonus_type);?></td>
			    					<td><?php echo bmw_price($bonus->leadership_bonus,'PV');?></td>
			    				</tr>
			    			<?php } ?>
			    			<tr class="let-text-center let-bg-info let-text-white">
			    					<th colspan="2"><?php _e('Week Provenue','BMW');?></th>
			    					<th><?php echo $payout_settings['bmw_week_provenue'].'%'; ?></th>
			    				</tr>
			    			</tbody>
			    		</table>
			    		<?php 
			    		 
			    		}else { echo '---';}  ?>
	    			 
	    			<?php 
			    		if(isset($onetime_leadership_bonus) && !empty($onetime_leadership_bonus)){
			    		?>
			    		<table class="let-table let-table-sm let-m-0">
			    			<thead class="let-bg-info">
			    				<tr class="let-text-center let-text-white"><td colspan="3"><?php _e('Leader One Time Bonus','BMW');?></td></tr>
			    				<tr class="let-text-center let-text-white">
			    					<th><?php _e('Amount','BMW');?></th>
			    					<th><?php _e('Leader Bonus Type','BMW');?></th>
			    					<th><?php _e('Insert Date','BMW');?></th>
			    				</tr>
			    			</thead>
			    			<tbody>
			    				<?php 
			    				foreach($onetime_leadership_bonus as $key=>$bonus){ ?>
			    				<tr class="let-text-center">
			    					<td><?php echo bmw_price($bonus->amount,'PV');?></td>
			    					<td><?php echo get_leadership_bonus_name_leader_id($bonus->leader_post);?></td>
			    					<td><?php echo $bonus->insert_date;?></td>
			    				</tr>
			    			<?php } ?>
			    			</tbody>
			    		</table>
			    		<?php 
			    		 
			    		}else { echo '---';}  ?>
	    		</td>
	    		<td class="let-align-middle"><?php echo bmw_price($user_total,'PV');?></td>
	    	</tr>
			    <?php 
			    $i++;
			}
			}
		}	
		?>
	    </tbody>
	      <tfoot>
	    	<tr class="let-text-center let-bg-success let-text-white">
	        <td class="text-white" colspan="2"><?php echo __('Total Commission','BMW');?></td>
	        <td ><?php echo bmw_price($commission_total['pair_commission'],'PV');?></td>
	        <td ><?php echo bmw_price($commission_total['ref_commission'],'PV');?></td>
	        <td ><?php echo bmw_price($commission_total['faststart_commission'],'PV');?></td>
	        <td ><?php echo bmw_price($commission_total['leader_bonus']+$commission_total['one_time_bonus'],'PV');?></td>
	        <td ><?php echo bmw_price(array_sum($commission_total),'PV');?></td>
	      </tr>
	  		<tr class="let-bg-dark let-text-center">
	    	<td colspan="8" >
	    <?php if(array_sum($commission_total)>0): ?>
			<button class="let-btn let-btn-success let-btn-sm let-rounded-0" onclick="bmw_distribute_commission('<?php echo admin_url('admin-ajax.php');?>');" ><?php echo __('Distribute Commission','ump');?></button>
		<?php endif;?>
		</td>
	    </tr>
	    </tfoot>
	<?php }else{ ?>
          <tfoot>
	    	<tr class="let-text-center let-bg-success let-text-white">
	        <td colspan="7"><?php _e(sprintf('You can not run payout before %s days',$general_setting['bmw_payoutrun_day']) ,'BMW');?></td>
	        </tr>
	      </tfoot>
<?php	}?>
	  </table>
	
<?php 
	}
}


