<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'BMW_PAYOUT_REPORTS', false ) ) :

	class BMW_PAYOUT_REPORTS {

		public static function bmw_get_payout_reports(){
            global $wpdb;
            remove_all_actions( 'admin_notices' );
            
            if(!empty($_GET['payout_id']))
            {
              include_once dirname( __FILE__ ) . '/CLASS-bmw-payout-detail.php';
          } 
          else
          {
             $BMW_PAYOUT_LIST = new BMW_PAYOUT_LIST();
             $BMW_PAYOUT_LIST->prepare_items();
             $payouts=$wpdb->get_results("SELECT * FROM {$wpdb->prefix}bmw_payout");

             $i = 0;
             $csvarr = array();
             $csvarr[-1]['id']                   = __('Payout Id', 'BMW');
             $csvarr[-1]['user_key']             = __('User Key', 'BMW');
             $csvarr[-1]['user_name']            = __('User Name', 'BMW');
             $csvarr[-1]['pair_commission']      = __('Pair Bonus', 'BMW');
             $csvarr[-1]['referral_commission']  = __('Referral Bonus', 'BMW');
             $csvarr[-1]['faststart_commission']     = __('Level Bonus', 'BMW');
             $csvarr[-1]['leadership_commission'] = __('Leadership Bonus', 'BMW');
             $csvarr[-1]['one_time_bonus'] = __('One time Leader Bonus', 'BMW');
             $csvarr[-1]['total_amount']         = __('Total Amount', 'BMW');
             $csvarr[-1]['tax']                  = __('Tax', 'BMW');
             $csvarr[-1]['service_charge']       = __('Service Charge', 'BMW');
             $csvarr[-1]['date']                 = __('Payout Date', 'BMW');

             foreach ($payouts as $key => $payout) {

                $csvarr[$i]['id']                       = $payout->payout_id;
                $csvarr[$i]['user_key']                 = $payout->user_key;
                $csvarr[$i]['user_name']                = bmw_get_username_by_userkey($payout->user_key);
                $csvarr[$i]['pair_commission']          = bmw_price($payout->pair_commission);
                $csvarr[$i]['referral_commission']      = bmw_price($payout->referral_commission);
                $csvarr[$i]['faststart_commission']         = bmw_price($payout->faststart_commission);
                $csvarr[$i]['leadership_commission']        = bmw_price($payout->leadership_commission);
                $csvarr[$i]['one_time_bonus']            = bmw_price($payout->one_time_bonus);
                $csvarr[$i]['total_amount']             = bmw_price($payout->total_amount);
                $csvarr[$i]['tax']                      = bmw_price($payout->tax);
                $csvarr[$i]['service_charge']           = bmw_price($payout->service_charge);
                $csvarr[$i]['date']                     = date('d-m-Y',strtotime($payout->insert_date));
                $i++;
            }
            $payout_array = serialize($csvarr);

            ?>
            <div class="let-col-md-12 let-col-sm-12  let-mt-5">
              <div class="let-x_panel">
                <div class="let-x_title">
                  <h2><?php _e('Payout Reports','BMW');?> </h2>
                  <ul class="let-nav let-navbar-right let-panel_toolbox">
                    <li> <form method="post" action="<?php echo BMW()->plugin_url() ?>/includes/admin/export.php">
                        <input type="hidden" name ="csvarray" value='<?php echo $payout_array ?>' />
                        <input type="hidden" name ="filename" value='bmw-payouts' />
                        <button type="submit" name="export_csv" id="export_csv" class="let-btn let-btn-success let-btn-sm"><?php _e('Export to CSV','BMW');?> &raquo;</button>
                    </form> </li>
                    <li><a class="let-collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                    <li><a class="let-close-link"><i class="fa fa-close"></i></a>
                    </li>
                </ul>
                <div class="let-clearfix"></div>
            </div>
            <div class="let-x_content">
            	
              <form id="payout-report" method="GET" action="">
                <input type="hidden" name="page" value="<?php echo sanitize_text_field($_REQUEST['page']) ?>" />
                
                <?php
                $BMW_PAYOUT_LIST->display();
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


if ( ! class_exists( 'BMW_PAYOUT_LIST', false ) ) :
    class BMW_PAYOUT_LIST extends WP_List_Table {

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
            case 'user_key':
            case 'payout_id':
            case 'pair_commission':
            case 'referral_commission':
            case 'faststart_commission':
            case 'leadership_commission':
            case 'one_time_bonus':
            case 'tax':
            case 'service_charge':
            case 'total_amount':
            case 'date':
            case 'action';
            
            return $item[ $column_name ];
            default:
            return print_r( $item, true );
        }
    }

    function get_columns(){
      $columns = array(
        'user_key'      => __( 'User Key', 'BMW' ),
        'payout_id'     => __( 'Payout Id', 'BMW' ),
        'pair_commission'    => __( 'Pair C.', 'BMW' ),
        'referral_commission'    => __( 'Referral C.', 'BMW' ),
        'faststart_commission'    => __( 'FastStart C.', 'BMW' ),
        'leadership_commission'    => __( 'Leadership C.', 'BMW' ),
        'one_time_bonus'    => __( 'One time Leader C.', 'BMW' ),
        'tax'    => __( 'Tax.', 'BMW' ),
        'service_charge'    => __( 'Service Charge.', 'BMW' ),
        'total_amount'    => __( 'Total C.', 'BMW' ),
        'date'    => __( 'Date', 'BMW' ),
        'action'    => __( 'Action', 'BMW' ),
    );

      return $columns;
  }


  function prepare_items(){

    global $wpdb;
    global $date_format;
    $per_page = 10;

    $columns = $this->get_columns();
    $hidden = array();
    $sortable = $this->get_sortable_columns();
    $this->_column_headers = array($columns, $hidden, $sortable);
    $sql = "SELECT * FROM {$wpdb->prefix}bmw_payout ORDER BY id ASC";

    $results = $wpdb->get_results($sql, ARRAY_A);

    $i = 0;
    $listdata = array();
    $num = $wpdb->num_rows;
    if ($num > 0) {
      if(is_lic_validate()){
        foreach($results as $row) {
            $listdata[$i]['user_key'] = $row['user_key'];
            $listdata[$i]['payout_id'] = $row['payout_id'];
            $listdata[$i]['pair_commission'] = $row['pair_commission'];
            $listdata[$i]['referral_commission'] = $row['referral_commission'];
            $listdata[$i]['faststart_commission'] = $row['faststart_commission'];
            $listdata[$i]['leadership_commission'] = $row['leadership_commission'];
            $listdata[$i]['one_time_bonus']        = $row['one_time_bonus'];
            $listdata[$i]['tax'] = $row['tax'];
            $listdata[$i]['service_charge'] = $row['service_charge'];
            $listdata[$i]['total_amount'] = $row['total_amount'];
            $listdata[$i]['date'] = date('d-m-Y',strtotime($row['insert_date']));
            $listdata[$i]['action'] = '<a href="'.admin_url().'admin.php?page=bmw-payout-reports&payout_id='.$row['payout_id'].'&user_key='.$row['user_key'].'" class="let-btn let-btn-success let-rounded-0 let-btn-sm let-pl-3 let-pr-3 let-p-1"><i class="fa fa-eye"></i></a>';
            $i++;
        }
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