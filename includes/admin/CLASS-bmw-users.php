<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'BMW_USERS_REPORT', false ) ) :

	class BMW_USERS_REPORT {

		public static function bmw_get_users_reports(){
            global $wpdb;
        if(!empty($_GET['user_id']))
        {
             include_once BMW_ABSPATH . 'includes/admin/CLASS-bmw-user-detail.php';
             BMW_USER_DETAILS::bmw_display_user_details($_GET['user_id'],$_GET['user_key']);
        }
        else
        {
			$bmw_admin_users_list = new bmw_admin_users_list();
    		$bmw_admin_users_list->prepare_items();

            $all_users=$wpdb->get_results("SELECT * FROM {$wpdb->prefix}bmw_users");
        $i = 0;
        $csvarr = array();
        $csvarr[-1]['id'] = __('ID', 'BMW');
        $csvarr[-1]['user_id'] = __('User Id', 'BMW');
        $csvarr[-1]['user_name'] = __('User Name', 'BMW');
        $csvarr[-1]['user_key'] = __('User Key', 'BMW');
        $csvarr[-1]['parent_key'] = __('Parent Key', 'BMW');
        $csvarr[-1]['sponsor_key'] = __('Sponsor Key', 'BMW');
        $csvarr[-1]['position'] = __('Position', 'BMW');
        $csvarr[-1]['creation_date'] = __('Creation Date', 'BMW');
        $csvarr[-1]['payment_status'] = __('Payment Status', 'BMW');
        $csvarr[-1]['payment_date'] = __('Payment Date', 'BMW');
        $csvarr[-1]['product_price'] = __('Product Price', 'BMW');

        foreach ($all_users as $key => $value) {
                $id = $value->id;
                $user_id = $value->user_id;
                $user_name = $value->user_name;
                $user_key = $value->user_key;
                $parent_key = $value->parent_key;
                $sponsor_key = $value->sponsor_key;
                $position = $value->position;
                $creation_date = $value->creation_date;
                $payment_status = ($value->payment_status)?'Paid':'UnPaid';
                $payment_date = $value->payment_date;

                $csvarr[$i]['id'] = $id;
                $csvarr[$i]['user_id'] = $user_id;
                $csvarr[$i]['user_name'] = $user_name;
                $csvarr[$i]['user_key'] = $user_key;
                $csvarr[$i]['parent_key'] = $parent_key;
                $csvarr[$i]['sponsor_key'] = $sponsor_key;
                $csvarr[$i]['position'] = $position;
                $csvarr[$i]['creation_date'] =$creation_date;
                $csvarr[$i]['payment_status'] =$payment_status;
                $csvarr[$i]['payment_date'] =$payment_date;
            $i++;
    }
        $value = serialize($csvarr);

    	?>
    	<div class="let-col-md-12 let-col-sm-12  let-mt-5">
              <div class="let-x_panel">
                <div class="let-x_title">
                  <h2><?php _e('Users Reports','BMW');?> </h2>
                  <ul class="let-nav let-navbar-right let-panel_toolbox">
                    <li><form method="post" action="<?php echo BMW()->plugin_url() ?>/includes/admin/export.php">
                <input type="hidden" name ="csvarray" value='<?php echo $value ?>' />
                <input type="hidden" name ="filename" value='bmw-users' />
                 <button type="submit" name="export_csv" id="export_csv" class="let-btn let-btn-success let-btn-sm"><?php _e('Export to CSV','BMW');?> &raquo;</button>
            </form> 
                    </li>
                    <li><a class="let-collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                    <li><a class="let-close-link"><i class="fa fa-close"></i></a>
                    </li>
                  </ul>
                  <div class="let-clearfix"></div>
                </div>
                <div class="let-x_content">
            	
    		<form id="users-report" method="GET" action="">
            <input type="hidden" name="page" value="<?php echo sanitize_text_field($_REQUEST['page']) ?>" />
            
    		<?php
    		  if(is_lic_validate()){
    			$bmw_admin_users_list->display();
            }
    		?>
    	    </form>
            	
        	</div>
        </div>
    </div>
    	<?php
    }
		}
	}

endif;


if ( ! class_exists( 'WP_List_Table' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

if ( ! class_exists( 'bmw_admin_users_list', false ) ) :
class bmw_admin_users_list extends WP_List_Table {

    /** Class constructor */
    function __construct() {
        global $status, $page;

        parent::__construct(array(
            'singular' => __( 'id', 'BMW' ),
            'plural'   => __( 'id', 'BMW' ),
            'ajax'     => false

        ));
    }

    function get_sortable_columns() {
        $sortable_columns = array();
        return $sortable_columns;
    }

    function column_default( $item, $column_name ) {
      switch ( $column_name ) {
        case 'id':
        case 'user_name':
        case 'user_key':
        case 'parent_key':
        case 'sponsor_key':
        case 'payment_status':
        case 'position':
        case 'pair_commission':
        case 'leadership_commission':
        case 'referral_commission':
        case 'faststart_commission':
        case 'one_time_bonus':
        case 'action';
          return $item[ $column_name ];
        default:
          return print_r( $item, true );
      }
    }

    function get_columns(){
      $columns = array(
        'id'                    => __( 'Id', 'BMW' ),
        'user_name'             => __( 'User Name', 'BMW' ),
        'user_key'              => __( 'User key', 'BMW' ),
        'parent_key'            => __( 'Parent Key', 'BMW' ),
        'sponsor_key'           => __( 'Sponsor Key', 'BMW' ),
        'payment_status'        => __( 'Status', 'BMW' ),
        'position'              => __( 'Position', 'BMW' ),
        'pair_commission'       => __( 'Pair C.', 'BMW' ),
        'leadership_commission'      => __( 'Leadership C.', 'BMW' ),
        'referral_commission'   => __( 'Referral C.', 'BMW' ),
        'faststart_commission'   => __( 'Faststart C.', 'BMW' ),
        'one_time_bonus'   => __( 'OneTime Leader C.', 'BMW' ),
        'action'                => __( 'Action', 'BMW' ),

      );

      return $columns;
    }


    function prepare_items(){

        global $wpdb,$date_format;
        $per_page = 10;

        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();
        $this->_column_headers = array($columns, $hidden, $sortable);

         $results = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}bmw_users ORDER BY id ASC");

        $i = 0;
        $listdata = array();
        $num = $wpdb->num_rows;
        if ($num > 0) {
            foreach($results as $row) {
                $listdata[$i]['id']                 = $row->user_id;
                $listdata[$i]['user_name']          = $row->user_name;
                $listdata[$i]['user_key']           = $row->user_key;
                $listdata[$i]['parent_key']         = $row->parent_key;
                $listdata[$i]['sponsor_key']        = $row->sponsor_key;
                // $listdata[$i]['payment_status']     = ($row->payment_status)?'Paid':'Un Paid';
                $status=($row->payment_status)?__('Paid','BMW'):__('Un Paid','BMW');
                $status1=($row->payment_status)?__('Un Paid','BMW'):__('Paid','BMW');
                if($row->payment_status==1){
                    $statusvalue="0";
                }else
                {
                   $statusvalue="1"; 
                }
                $listdata[$i]['payment_status']     = '<select name="select_payment_status" onchange="select_payment_status_fun('.$row->user_id.');" id="select_payment_status">'.'<option value="'.($row->payment_status).'">'.($status).'</option><option  value="'.$statusvalue.'">'.$status1.'</option>';

                //  $listdata[$i]['payment_status']     = '<select name="select_payment_status"><option value="'.($row->payment_status).'">'.($row->payment_status)?'Paid':'Un Paid'.'</option>
                // <option="">'.($row->payment_status)?'Paid':'Un Paid'.'</option></select>';
                $listdata[$i]['position']           = ucwords($row->position);
                $listdata[$i]['pair_commission']    = bmw_price(bmw_user_pair_commission_sum($row->user_key));
                $listdata[$i]['leadership_commission']   = bmw_price(bmw_user_leadership_commission_sum($row->user_key));
                $listdata[$i]['referral_commission']     = bmw_price(bmw_user_referral_commission_sum($row->user_key));
                $listdata[$i]['faststart_commission']    = bmw_price(bmw_user_faststart_commission_sum($row->user_key));
                $listdata[$i]['one_time_bonus']       = bmw_price(bmw_user_onetime_bonus_sum($row->user_key));
                $listdata[$i]['action'] = '<a href="'.admin_url().'admin.php?page=bmw-user-reports&user_id='.$row->user_id.'&user_key='.$row->user_key.' "class="let-btn let-btn-success let-rounded-0 let-btn-sm let-pl-3 let-pr-3 let-p-1"><i class="fa fa-eye"></i></a>';    
                $i++;
            } 
        }

        $data = $listdata;

        $current_page = $this->get_pagenum();
        $total_items = count($data);
        $data = array_slice($data, (($current_page - 1) * $per_page), $per_page);
        $this->items = $data;
        $this->set_pagination_args(array(
            'total_items' => $total_items,
            'per_page' => $per_page,
            'total_pages' => ceil($total_items / $per_page)
        ));
          
    }

}

endif;
