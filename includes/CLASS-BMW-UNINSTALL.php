<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; 
}
class BMW_UNINSTALL{
	public function uninstall(){
	    global $wpdb;

    	$tables = array(
    		"{$wpdb->prefix}bmw_users",
            "{$wpdb->prefix}bmw_hierarchy",
            "{$wpdb->prefix}bmw_bank_details",
            "{$wpdb->prefix}bmw_pair_commission",
            "{$wpdb->prefix}bmw_withdrawal",
            "{$wpdb->prefix}bmw_payout_master",
            "{$wpdb->prefix}bmw_payout",
            "{$wpdb->prefix}bmw_mail_settings",
            "{$wpdb->prefix}bmw_referral_commission",
            "{$wpdb->prefix}bmw_bonus_commission",
            "{$wpdb->prefix}bmw_level_commission",
            "{$wpdb->prefix}bmw_direct_commission",
            "{$wpdb->prefix}bmw_epins",
            "{$wpdb->prefix}bmw_phone_codes",
            "{$wpdb->prefix}bmw_orders",
            "{$wpdb->prefix}bmw_point_transaction",
            "{$wpdb->prefix}bmw_faststart_bonus_commission",
            "{$wpdb->prefix}bmw_leadership_bonus_commission",
            "{$wpdb->prefix}bmw_leadership_commission_setting",
            "{$wpdb->prefix}bmw_leader_one_time_bonus",
    	);
	    
	    
	foreach ( $tables as $table ) {
		$wpdb->query( "DROP TABLE IF EXISTS {$table}" ); 
	}
	
            $Pages = array('Dashboard','Personal Info','Bank Details','Genealogy','Payout List','Withdrawal Amount','Register','Join Network','Invitation');
                

                    //delete post from wp_posts and wp_postmeta table
                    foreach($Pages as $value)
                    {
                        $post_id = $wpdb->get_var("SELECT id from {$wpdb->prefix}posts where post_title = '$value'" );
                        wp_delete_post( $post_id, true );
                    }

                    foreach($Pages as $value)
                    {
                        $results = $wpdb->get_results("SELECT p.id from {$wpdb->prefix}posts as p join {$wpdb->prefix}postmeta as pm on p.id=pm.post_id where pm.meta_key='bmp_page_title' AND pm.meta_value = '$value'" );
                        foreach($results as $result)
                            {
                                wp_delete_post( $result->id, true );
                            }
                    }

                    $results = $wpdb->get_results("SELECT p.id from {$wpdb->prefix}posts as p join {$wpdb->prefix}postmeta as pm on p.id=pm.post_id where pm.meta_value = 'Binary MLM Plan Pro'" );
                        foreach($results as $result)
                        {
                            wp_delete_post( $result->id, true );
                        }


                if($wpdb->prefix!='bmp_'){
                      $wpdb->query( "DELETE FROM $wpdb->options WHERE option_name LIKE '%bmp_%';" );
                     }

    	$wp_roles = new WP_Roles();
    	$wp_roles->remove_role("bmp_user");
    	session_destroy();
	}
}