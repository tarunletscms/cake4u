<?php 

if ( ! defined( 'ABSPATH' ) ) {
	exit; 
}
class BMW_ORDER{
	function bmw_order_action_completed($order_id,$items,$order_data,$customer_id)
	{
		global $wpdb;
		$settings=get_option('bmw_manage_general');
		$total_points=self::bmw_get_order_points($items);
		$total_price=self::bmw_get_order_prices($items);
		 if(isset($order_id) && ($total_points+$total_price)>0)
		{
			$user_data=bmw_get_user_info_by_user_id($customer_id);
			$wpdb->query("INSERT INTO {$wpdb->prefix}bmw_orders  SET order_id='".$order_id."', user_id='".$customer_id."', total_amount='".$total_price."', total_points='".$total_points."',order_date='".date_i18n('Y-m-d H:i:s')."'");

			if($wpdb->insert_id)
			{	
				$type=(isset( $settings['bmw_plan_base']) &&  $settings['bmw_plan_base']=='points')?'point':'price';

				self::bmw_update_user_status($user_data,$status=1);		
				if($type=='point'){		
				self::bmw_update_user_points($total_points,$user_data,$order_id,$type);
				}else{
					 $total_points=$total_price;
				}			
				
				$ref_count=$wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}bmw_orders WHERE user_id='".$customer_id."'");

				if($ref_count==1){
				self::bmw_insert_referral_commission($total_points,$user_data,$order_id,$type);}	
				self::bmw_insert_level_commission($total_points,$user_data,$order_id,$type);	
				// self::bmw_insert_leadership_commission($user_data);	
			}
		}
	}

	function bmw_get_order_points($items)
	{
		$points=0;
		if(isset($items) && !empty($items))
		{
			foreach ($items as $key => $item) {
	    	$product_id = $item['product_id'];
	    	$quantity = $item['quantity'];
	    	$is_enable=get_post_meta( $product_id, 'enable_for_commssion', true );
	    	if($is_enable=='yes')
	    	{
	    	$product_points=get_post_meta( $product_id, 'product_points', true );
		    	if(isset($product_points) && !empty($product_points)){
		    	$points+=$product_points*$quantity;
		    	}
	    	}
			}
		}
		return $points;
	}


function bmw_get_order_prices($items)
	{
		$total_amount=0;
		if(isset($items) && !empty($items))
		{
			foreach ($items as $key => $item) {
			$product = wc_get_product( $item['product_id'] );
	    	$product_id = $item['product_id'];
	    	$quantity = $item['quantity'];
	    	$regular_price = $product->get_regular_price();
			$sale_price = $product->get_sale_price();
	    	$is_enable=get_post_meta( $product_id, 'enable_for_commssion', true );
		    	if($is_enable=='yes')
		    	{
			    	if($sale_price){
						$total_amount+=$sale_price*$quantity;
				    } else {
				    	$total_amount+=$regular_price*$quantity;
				    }
		    	}
			}
		}
		return $total_amount;
	}
function bmw_update_user_status($user_data,$status)
	{
		global $wpdb;
		$wpdb->query("UPDATE {$wpdb->prefix}bmw_users SET payment_status='1' WHERE user_key='".$user_data->user_key."'");
	}
function bmw_update_user_points($points,$user_data,$order_id,$type)
	{
		global $wpdb;
		$rmq=0;$lvq=0;$owp=0;
		$eligibility_settings=get_option('bmw_manage_eligibility');
		$lvq=$eligibility_settings['bmw_minimum_personal_points'];  //$lvq is Level Qualification Points	
		$sqp=$user_data->qualified_points; //$sqp is Self Qualification Points
		if($lvq>$sqp){
		$rmq=$lvq-$sqp;	//$rmq is remaining qualification points
			if($rmq>=$points)
			{
				$rmq=$points;
				$owp=0;
			}else{
				$owp=$points-$rmq;
			}
	   	}else{
			$owp=$points;
		}

		self::bmw_insert_user_points($user_data->user_id,$user_data->user_key,$rmq,$owp,$order_id,$type);
	}
	function bmw_insert_level_commission($order_value,$user_data,$order_id,$type)
	{
		global $wpdb;
			$level_settings=get_option('bmw_level_settings');
			if($level_settings['bmw_level_status']==1){
		    $bmw_level_commission=get_option('bmw_level_commission');
		    if(!empty($bmw_level_commission))
		    {
		     $sponsor_key=$user_data->sponsor_key;
	 	      foreach ($bmw_level_commission as $key => $bmw_level) {
		        	// print_r($sponsor_key);
		        if( $sponsor_key != 0 && bmw_eligibility_check_for_commission($sponsor_key)){
		        if($bmw_level['bmw_level_type']=='percent')
		        {
		          $commission_amount=$order_value*$bmw_level['bmw_level_amount']/100;
		        }else{
		          $commission_amount=$bmw_level['bmw_level_amount'];
		        }
		        	$wpdb->query("INSERT INTO {$wpdb->prefix}bmw_level_commission SET user_key='".$user_data->user_key."', sponsor_key='".$sponsor_key."', amount='".$commission_amount."', level='".$key."', status='0', insert_date='".date_i18n('Y-m-d H:i:s')."'");
		        	$rkey=array('reference_key'=>$user_data->user_key,'order_id'=>$order_id,'comment'=>sprintf(__('Level %s Commission'),$key));
					bmw_insert_point_transaction_entry($sponsor_key,serialize($rkey),0,0,0,$commission_amount,0,0,$type);
		        }
		     $sponsor_key = bmw_get_sponsor_key_by_userkey($sponsor_key);

		    }
		 }
		}
	}
function bmw_insert_referral_commission($order_value,$user_data,$order_id,$type)
	{
		global $wpdb;
		$ref=0;
		$settings=get_option('bmw_manage_payout');
		if(isset($settings['bmw_referral_commission_amount']) && !empty($settings['bmw_referral_commission_amount']))
		{
			if($settings['bmw_referral_commission_type']=='percentage')
			{
				$ref=$order_value*$settings['bmw_referral_commission_amount']/100;
			}else{
				$ref=$settings['bmw_referral_commission_amount'];
			}

			if(isset($ref) && $ref>0  && $user_data->sponsor_key>0 && bmw_eligibility_check_for_commission($user_data->sponsor_key))
			{
				$wpdb->query("INSERT INTO {$wpdb->prefix}bmw_referral_commission SET user_key='".$user_data->sponsor_key."', child_key='".$user_data->user_key."', amount='".$ref."', status='0', order_id='".$order_id."',date_notified='".date_i18n('Y-m-d H:i:s')."'");
				$rkey=array('reference_key'=>$user_data->user_key,'order_id'=>$order_id,'comment'=>'Referral Commission');
				bmw_insert_point_transaction_entry($user_data->sponsor_key,serialize($rkey),0,0,0,$ref,0,0,$type);
			}
		}
	}

function bmw_insert_user_points($user_id,$user_key,$qpv,$owp,$order_id,$type) 
	{ 
		global $wpdb;
		$wpdb->query("UPDATE {$wpdb->prefix}bmw_users SET  qualified_points = qualified_points + ".$qpv.",own_points = own_points + ".$owp." WHERE `user_id` = '".$user_id."'");
		$rkey=array('reference_key'=>$user_key,'order_id'=>$order_id,'comment'=>'Self Insertion');
		bmw_insert_point_transaction_entry($user_key,serialize($rkey),0,0,0,$qpv,0,0,$type);
		
	}



}