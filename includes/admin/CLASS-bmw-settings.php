<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'BMW_ADMIN_SETTINGS', false ) ) :

	
	class BMW_ADMIN_SETTINGS {


		public static function bmw_get_settings_pages() {
		global $pagenow,$wpdb;
		$users=$wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}bmw_users");
		if(!$users)
		{ 
			 include_once BMW_ABSPATH . 'includes/admin/settings/view/view_first_user_settings.php';
			$first_user_register= new BMW_First_Registration();
			$first_user_register-> bmw_register_first_user();
		}
		else {
		if(  $pagenow == 'admin.php' && $_GET['page'] == 'bmw-settings' && isset($_GET['setting']) && $_GET['setting'] == 'configuration'){
			 $current = 'configuration';
		} else if($pagenow == 'admin.php' && $_GET['page'] == 'bmw-settings' && isset($_GET['setting'])&& $_GET['setting'] == 'distribute-commission'){
			$current = 'distribute-commission';
		} else if($pagenow == 'admin.php' && $_GET['page'] == 'bmw-settings' && isset($_GET['setting'])&& $_GET['setting'] == 'payout-run'){
			$current = 'payout-run';
		}else if($pagenow == 'admin.php' && $_GET['page'] == 'bmw-settings' && isset($_GET['setting'])&& $_GET['setting'] == 'addons'){
			$current = 'addons';
		} else{
	 		$current = 'configuration';
		}
	$bmw_settings = array(
                                'configuration'         => __('Configuration','BMW'),
                                'distribute-commission' => __('Distribute Commission','BMW'),
                                // 'payout-run'            =>  __('Payout Run','BMW'),
                                'addons'            	=> __('Addons','BMW')
                             );
	?>
	<div class="let-col-md-12 let-col-sm-12 let-mt-3">
              <div class="let-x_panel">
              	 <div class="let-loader-layer">
                          <div class="let-loader"></div>
                        </div>
                <div class="let-x_title let-p-2">
                   <ul class="let-nav let-navbar-right let-panel_toolbox">
                    <li><a class="let-collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                    <li><a class="let-close-link"><i class="fa fa-close"></i></a>
                    </li>
                  </ul>
                   <ul class="let-nav let-navbar-left let-float-left let-panel_toolbox">
                  	<?php 
                  	 foreach( $bmw_settings as $setting => $name )
					{
				        $class = ( $setting == $current ) ? ' nav-tab-active let-bg-success let-text-white' : '';
				        ?>
				       <li class="let-m-0">  <a class='nav-tab <?php echo $class;?> let-bmp-menu' href='?page=bmw-settings&setting=<?php echo $setting;?>'><?php echo $name;?></a>    </li>
				        <?php 
				    } ?>
                   
                  </ul>
                  <div class="let-clearfix"></div>
                </div>
                <div class="let-x_content">
		<?php 
			
			
		   
	
	

	    if($pagenow == 'admin.php' && $_GET['page'] == 'bmw-settings' && ((isset($_GET['setting']) && $_GET['setting'] == 'configuration') || !isset($_GET['setting'])))
		{ 
			include_once BMW_ABSPATH . 'includes/admin/settings/CLASS-bmw-configuration.php';
			BMW_DISPLAY_CONFIGURATION_SETTING::bmw_configuration_page();
		}	
		else if($pagenow == 'admin.php' && $_GET['page'] == 'bmw-settings' && isset($_GET['setting'])&& $_GET['setting'] == 'distribute-commission')
		{
            if(is_lic_validate()){
            bmw_dataTable_enque();
			include_once BMW_ABSPATH . 'includes/admin/settings/payout/BMW-distribute-commission.php';
			BMW_DISTRIBUTE_COMMISSIONS::bmw_distribute_commission();
            }
		}
		
		else if($pagenow == 'admin.php' && $_GET['page'] == 'bmw-settings' && isset($_GET['setting'])&& $_GET['setting'] == 'payout-run')
		{
            if(is_lic_validate()){
            bmw_dataTable_enque();
			include_once BMW_ABSPATH . 'includes/admin/settings/payout/BMW-run-payout.php';
			BMW_RUN_PAYOUT::bmw_payout_run_page();
            }
		}
		else if($pagenow == 'admin.php' && $_GET['page'] == 'bmw-settings' && isset($_GET['setting'])&& $_GET['setting'] == 'addons')
		{
            if(is_lic_validate()){
			include_once BMW_ABSPATH . 'includes/admin/CLASS-bmw-addons.php';
			if(isset($_GET['addon-setting']) && $_GET['addon-setting']=='mycred'){
			BMW_ADDONS::bmw_myCred_function();
            }
            else if(isset($_GET['addon-setting']) && $_GET['addon-setting']=='terawallet')
            {
			BMW_ADDONS::bmw_woowallet_function();
            }else{
			BMW_ADDONS::bmw_addons_function();
            }
		}
		else{ 
			include_once BMW_ABSPATH . 'includes/admin/settings/CLASS-bmw-configuration.php';
			BMW_DISPLAY_CONFIGURATION_SETTING::bmw_configuration_page();
		}
	}
}
		?>
	</div>
</div>
</div>

		<?php 
	}	

	}

endif;
