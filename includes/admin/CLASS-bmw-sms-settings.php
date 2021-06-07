<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'BMW_SMS_SETTINGS', false ) ) :

	class BMW_SMS_SETTINGS {
		
	public static function bmw_get_sms_settings(){


        global $pagenow,$wpdb;
        if(  $pagenow == 'admin.php' && $_GET['page'] == 'bmw-sms-settings' && isset($_GET['setting'])&& $_GET['setting'] == 'gateway'){
             $current = 'gateway';
        }
        if(  $pagenow == 'admin.php' && $_GET['page'] == 'bmw-sms-settings' && isset($_GET['setting'])&& $_GET['setting'] == 'settings'){
             $current = 'settings';
        }else{
            $current = 'gateway';
        }
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
            $umw_settings = array(
                                'gateway'         => 'SMS Gateway',
                                'settings'         => 'SMS Settings'
                             );
 
            foreach( $umw_settings as $setting => $name )
            {
                $class = ( $setting == $current ) ? ' nav-tab-active let-bg-success let-text-white' : '';
                ?>
                <li class="let-m-0">  <a class='nav-tab <?php echo $class;?> let-bmp-menu' href='?page=bmw-sms-settings&setting=<?php echo $setting;?>'><?php echo $name;?></a>    </li>   
                <?php 
            }
            ?>
             </ul>
                  <div class="let-clearfix"></div>
                </div>
                <div class="let-x_content">
                	<?php 


        if($pagenow == 'admin.php' && $_GET['page'] == 'bmw-sms-settings' && isset($_GET['setting'])&& $_GET['setting'] == 'gateway')
        { 
        	include_once BMW_ABSPATH . 'includes/admin/settings/sms-settings/bmw-sms-gateway.php';
            BMW_SMS_GATEWAY::bmw_sms_gateway_settings();
        } else if($pagenow == 'admin.php' && $_GET['page'] == 'bmw-sms-settings' && isset($_GET['setting'])&& $_GET['setting'] == 'settings')
        { 
          include_once BMW_ABSPATH . 'includes/admin/settings/sms-settings/bmw-sms-settings.php';
            BMW_SMS_TEMPLATE_SETTINGS::bmw_sms_template_settings_function();
        }else{
        	include_once BMW_ABSPATH . 'includes/admin/settings/sms-settings/bmw-sms-gateway.php';
          BMW_SMS_GATEWAY::bmw_sms_gateway_settings();
        }
        ?>
	</div>
</div>
</div>

		<?php 
	}	

	}

endif;

    
		//do_action('bmw_sms_configurations');
	