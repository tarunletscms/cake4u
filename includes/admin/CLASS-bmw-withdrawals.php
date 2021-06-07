<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WP_List_Table' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

if ( ! class_exists( 'BMW_WITHDRAWAL_RECORDS', false ) ) :

	class BMW_WITHDRAWAL_RECORDS {
		
		public static function bmw_get_withdrawal_records(){
			global $wpdb;
              if(isset($_GET['user_id']) && isset($_GET['id']))
      {
        $user_id=sanitize_text_field($_GET['user_id']);
        $id=sanitize_text_field($_GET['id']);
        if(!class_exists('BMW_WITHDRAWAL_VIEW')){
          include_once BMW_ABSPATH . '/includes/admin/CLASS-bmw-withdrawal-pay.php';
        }
        $withdrawal = new BMW_WITHDRAWAL_VIEW();
        $withdrawal->bmw_withdrawal_display($user_id,$id);
    }else{
                $BMW_WITHDRAWAL_LIST = new BMW_WITHDRAWAL_LIST();
            $BMW_WITHDRAWAL_LIST->prepare_items();
             
             $all_withdrawals=$wpdb->get_results("SELECT * FROM {$wpdb->prefix}bmw_withdrawal");

        $i = 0;
        $csvarr = array();
        $csvarr[-1]['id'] = __('ID', 'BMW');
        $csvarr[-1]['user_id'] = __('User Id', 'BMW');
        $csvarr[-1]['user_name'] = __('User Name', 'BMW');
        $csvarr[-1]['withdrawal_initiated_date'] = __('Withdrawal Initiated Date', 'BMW');
        $csvarr[-1]['withdrawal_processed_date'] = __('Withdrawal Processed Date', 'BMW');
        $csvarr[-1]['amount'] = __('amount', 'BMW');
        $csvarr[-1]['withdrawal_fee'] = __('Withdrawal Fee', 'BMW');
        $csvarr[-1]['withdrawal_mode'] = __('Withdrawal Mode', 'BMW');
        $csvarr[-1]['transaction_id'] = __('Transaction Id', 'BMW');
        $csvarr[-1]['bank_account'] = __('Account Holder', 'BMW');
        $csvarr[-1]['account_number'] = __('Account Number', 'BMW');
        $csvarr[-1]['bank_name'] = __('Bank Name', 'BMW');
        $csvarr[-1]['ifsc_code'] = __('IFSC Code', 'BMW');
        $csvarr[-1]['branch'] = __('Branch', 'BMW');
        $csvarr[-1]['mobile'] = __('Mobile', 'BMW');

        foreach ($all_withdrawals as $key => $value) {
                $id = $value->id;
                $user_id = $value->user_id;
                $user_name = bmw_get_username_by_user_id($value->user_id);
                $withdrawal_initiated_date = $value->withdrawal_initiated_date;
                $payment_processed_date = $value->payment_processed_date;
                $amount = $value->amount;
                $withdrawal_fee = $value->withdrawal_fee;
                $withdrawal_mode = $value->withdrawal_mode;
                $transaction_id = $value->transaction_id;
                $bank_account=get_user_meta($value->user_id,'account_holder_name',true);
                $account_number=get_user_meta($value->user_id,'account_number',true);
                $bank_name=get_user_meta($value->user_id,'bank_name',true);
                $ifsc_code=get_user_meta($value->user_id,'branch',true);
                $branch=get_user_meta($value->user_id,'ifsc_code',true);
                $mobile=get_user_meta($value->user_id,'Contact_number',true);

                $csvarr[$i]['id'] = $id;
                $csvarr[$i]['user_id'] = $user_id;
                $csvarr[$i]['user_name'] = $user_name;
                $csvarr[$i]['withdrawal_initiated_date'] = $withdrawal_initiated_date;
                $csvarr[$i]['withdrawal_processed_date'] = $payment_processed_date;
                $csvarr[$i]['amount'] = $amount;
                $csvarr[$i]['withdrawal_fee'] = $withdrawal_fee;
                $csvarr[$i]['withdrawal_mode'] =$withdrawal_mode;
                $csvarr[$i]['transaction_id'] =$transaction_id;
                $csvarr[$i]['bank_account'] =$bank_account;
                $csvarr[$i]['account_number'] =$account_number;
                $csvarr[$i]['bank_name'] =$bank_name;
                $csvarr[$i]['ifsc_code'] =$ifsc_code;
                $csvarr[$i]['branch'] =$branch;
                $csvarr[$i]['mobile'] =$mobile;
            $i++;
    }
        $value = serialize($csvarr);
        ?>
        <div class="let-col-md-12 let-col-sm-12  let-mt-5">
              <div class="let-x_panel">
                <div class="let-x_title">
                  <h2><?php _e('Withdrawal Reports','BMW');?> </h2>
                  <ul class="let-nav let-navbar-right let-panel_toolbox">
                    <li>   <form method="post" action="<?php echo BMW()->plugin_url() ?>/includes/admin/export.php">
                <input type="hidden" name ="csvarray" value='<?php echo $value ?>' />
                <input type="hidden" name ="filename" value='bmw-withdrawals' />
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
         
            <form id="payout-report" method="GET" action="">
            <input type="hidden" name="page" value="<?php echo sanitize_text_field($_REQUEST['page']) ?>" />
            
            <?php
                $BMW_WITHDRAWAL_LIST->display();
            ?>
            </form>
                
            </div></div>
        </div>
       
        <?php
        
        }
    }
    }

endif;


class BMW_WITHDRAWAL_LIST extends WP_List_Table {
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
        // case 'product_id':
        case 'user_id':
      case 'user_name':
      case 'initiated_date':
      case 'processed_date':
      case 'amount':
      case 'withdrawal_fee':
      case 'status':
      case 'action';
          return $item[ $column_name ];
        default:
          return print_r( $item, true );
      }
    }

    function get_columns(){
      $columns = array(
        'user_id'    => __( 'User Id', 'BMW' ),
      'user_name' => __( 'User Name', 'BMW' ),
      'initiated_date'    => __( 'Initeated Date', 'BMW' ),
      'processed_date'    => __( 'Processed Date', 'BMW' ),
      'amount'    => __( 'Amount', 'BMW' ),
      'withdrawal_fee'    => __( 'Withdraw Fee', 'BMW' ),
      'status'    => __( 'Status', 'BMW' ),
      'action'    => __( 'Action', 'BMW' ),
      );

      return $columns;
    }

    function prepare_items($search =''){
/**
 * Retrieve customer’s data from the database
 *
 * @param int $per_page
 * @param int $page_number
 *
 * @return mixed
 */
        global $wpdb;
        global $date_format;
        $per_page = 15;
        $paged = isset($_REQUEST['paged']) ? max(0, intval($_REQUEST['paged'] -1) * 10) : 0;
        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();
        $this->_column_headers = array($columns, $hidden, $sortable);

         $sql = "SELECT * FROM {$wpdb->prefix}bmw_withdrawal ORDER BY id desc";  
         $results = $wpdb->get_results($sql, ARRAY_A);

        $i = 0;
        $listdata = array();
        $num = $wpdb->num_rows;
        if ($num > 0) {
            foreach($results as $row) {
              $listdata[$i]['user_id'] = $row['user_id'];
                $listdata[$i]['user_name'] = bmw_get_username_by_user_id($row['user_id']);
                $listdata[$i]['initiated_date'] = date('d-M-Y',strtotime($row['withdrawal_initiated_date']));
                $listdata[$i]['processed_date'] = ($row['payment_processed_date']!='0000-00-00')?date('d-M-Y',strtotime($row['payment_processed_date'])):'---';
                $listdata[$i]['amount'] = $row['amount'];
                $listdata[$i]['withdrawal_fee'] = $row['withdrawal_fee'];
                $listdata[$i]['status'] = ($row['payment_processed']==0)?'<span class="let-badge let-btn-sm let-p-2 w-100 let-btn-warning  let-rounded-0">'.__('Initiated','BMW').'</span>':'<span class="let-badge let-btn-sm w-100  let-p-2 let-btn-success let-rounded-0">'.__('Processed','BMW').'</span>';
                $listdata[$i]['action'] = '<a href="'.admin_url().'admin.php?page=bmw-withdrawal-records&user_id='.$row['user_id'].'&id='.$row['id'].'" class="let-btn let-btn-success let-btn-sm let-rounded-0 let-p-1 let-pl-3 let-pr-3"><i class="fa fa-eye"></i></a>';
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
            'total_pages' => ceil($total_items / $per_page),
        )); 
  }

  }