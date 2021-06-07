<?php 

class BMW_WOO_WALLET_SETTINGS
{
  
public static function bmw_woo_wallet_settings_function()
  {
   
	global $wpdb;
if(isset($_REQUEST['woo_wallet_setting']) && !empty($_REQUEST['woo_wallet_setting']))
{
  $data=sanitize_text_array($_REQUEST['woo_wallet_setting']);
  if(!empty($data))
  {
     if(isset($data['bmw_woo_wallet_status']) && $data['bmw_woo_wallet_status']==1)
    {
      $mycred_page=array(
          'page_slug'    => 'tera_wallet',
          'name'    => _x( 'TeraWallet', 'Page slug', 'BMW' ),
          'title'   => _x( 'TeraWallet', 'Page title', 'BMW' ),
          'content' => '',
        );
      $page_id=get_page_by_title( $mycred_page['title'], OBJECT, 'page');
      
      if(empty($page_id)){
        $page_id=BMW_INSTALL::bmw_create_page($mycred_page['title'],$mycred_page['content'],$mycred_page['page_slug']);
        update_post_meta($page_id, 'bmw_page_title',$mycred_page['title']);
      }
    }

    update_option('bmw_woo_wallet_setting',$data);
  }
}
	$settings=get_option('bmw_woo_wallet_setting');
	?>
  <div>
<form method="POST">

<table class="let-table let-table-bordered ">
  <thead>
    <tr class="let-text-center">
      <th class="let-text-center let-p-1" colspan="2">
        <h3 class="let-text-success let-float-left let-p-1 let-m-0"><?php echo __('Woo Wallet Settings','BMW');?></h3>
        <div class="let-float-right">
          <small class="let-text-secondary" style="font-size: 10px;"><?php _e('Disable/Enable','BMW');?></small><br/>
          <label class="let-switch" for="bmw_woo_wallet_status">
            <input type="checkbox" name="woo_wallet_setting[bmw_woo_wallet_status]" value="1" id="bmw_woo_wallet_status" <?php if(isset($settings['bmw_woo_wallet_status'])=='1'){echo 'checked="checked"';}?>>
            <div class="let-slider let-round"></div>
            </label>
          </div>
          </th>
    </tr>
  </thead>
  <tbody class="let-bmw_level_setting">
    <tr>
    <td class="let-w-25"><?php _e('Show Woo Wallet Menu','BMW');?></td>
    <td class="let-text-left"> 
      <label class="let-switch" for="bmw_woo_wallet_show_menu">
            <input type="checkbox" name="woo_wallet_setting[bmw_woo_wallet_show_menu]" value="1" id="bmw_woo_wallet_show_menu" <?php if(isset($settings['bmw_woo_wallet_show_menu'])=='1'){echo 'checked="checked"';}?>>
            <div class="let-slider let-round"></div>
            </label>
    </td>
   </tr>
  
  </tbody>
  <tfoot class="let-">
    <tr>
      <td colspan="2" class="let-text-center"><button class="let-btn let-btn-success let-rounded-0 let-btn-sm"><?php _e('Save Woo Wallet Settings','BMW');?></button></td>
    </tr>
  </tfoot>
  </table>
</form>
</div>

<?php 
}
}