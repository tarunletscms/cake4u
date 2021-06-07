<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( ! class_exists( 'BMW_RESET_DATA', false ) ) :

	class BMW_RESET_DATA {

		public static function bmw_get_reset_data(){?>
  <div class="let-col-md-12 let-col-sm-12 ">
              <div class="let-x_panel">
                <div class="let-x_title">
                  <h2><?php _e('Reset BMP PLan','BMW');?> </h2>
                  <ul class="let-nav let-navbar-right let-panel_toolbox">
                    <li><a class="let-collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                    <li><a class="let-close-link"><i class="fa fa-close"></i></a>
                    </li>
                  </ul>
                  <div class="let-clearfix"></div>
                </div>
                <div class="let-x_content">
        	<?php $link=admin_url('admin-ajax.php')?>
          <div class="let-col-md-12 let-text-center">
          <button class="let-btn let-btn-success let-rounded-0" onclick="reset_data('<?php echo $link;?>')" type="button"><?php echo __('Reset Data','BMW');?></button>
                  
        </div>
			</div>
		</div>
	</div>
    	<?php 
		}
	}

endif;

  		?>
