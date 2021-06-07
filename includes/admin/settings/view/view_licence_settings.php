<?php 

class BMW_LICENCE
{
  
public static function bmw_setting_licence()
  {
   
	global $wpdb;
if(isset($_REQUEST['licence-key']))
    { 
      $licence_key=sanitize_text_field($_REQUEST['licence-key']);
      $url = 'https://mlmtrees.com/wp-json/letscms/v1/licence';
          $website='mlmforest.com';
          $fields = array(
              'website' => $website,
              'licence_key' => $licence_key
          );
          $fields_string='';
          foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
          rtrim($fields_string, '&');
          //open connection
          $ch = curl_init();
          //set the url, number of POST vars, POST data
          curl_setopt($ch,CURLOPT_URL, $url);
          curl_setopt($ch,CURLOPT_POST, count($fields));
          curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
          curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
          //execute post
          $result = curl_exec($ch);
          //close connection
          curl_close($ch);
          $data=json_decode($result);
          if($data->success==true)
          {
            update_option('bmw_licence_key', $licence_key);
            update_option('bmw_licence_expiry',$data->expiry);
            $message = __("Your Licence is valid, Now you can enjoy our plugin.
              Your licence Expiry Date is ".date('d-M-Y',strtotime($data->expiry)),'BMW');
            echo '<div class="let-updated settings-success notice is-dismissible"><p>'.$message.'</p></div>';
          }
          else{
              $error = __("Your Licence Key is invalid, Please Enter valid licence key",'BMW');
              echo '<div class="let-error settings-error notice is-dismissible"><p>'. $error .'</p></div>';
         
          }
  } 

  $expiry=get_licence_expiry();
	
	?>
  <div>
<form method="POST">
<table class="let-table let-table-bordered">
      <thead class="let-bg-dark text-white">
        <tr class="let-text-center">
        <th  <?php if($expiry){?>colspan="2"<?php } else {?> colspan="3" <?php } ?> class="let-align-middle let-p-1">
          <h3 class="let-text-white let-p-0 let-m-0"><?php echo __('Licence','BMW');?> </h3>
        </th>
        <?php if($expiry){?>
        <td class="let-text-white"> <?php echo __('Your licence expiry date is ','BMW').'<br/>'.date('d-M-Y',strtotime(get_licence_expiry()));?></td>
      <?php } ?>
        </tr>
      </thead>
      <tbody>
      <tr <?php if(isset($error)){echo 'class="let-alert-danger"';}?>>
            <th class="let-p-3 let-text-center let-align-middle"><?php echo __('Your Licence Key','BMW');?></th>
        <td class="let-align-middle">
          <input type="text" name="licence-key" id="licence-key" class="let-form-control let-rounded-0" placeholder="<?php _e('Enter Key','BMW'); ?>" value="<?php echo (get_option('bmw_licence_key'))?get_option('bmw_licence_key'):'';?>">
        <br/>
          <p id="tagline-description" class="let-alert let-alert-warning let-text-dark let-p-1 let-rounded-0 let-bmp-left-border"><?php _e('Enter your Licence Key , if you have not any key! so please purchase the licence key.','BMW');?></p>
        </td>
        <td class="let-align-middle text-center">
          <a class="let-btn let-btn-success let-rounded-0 let-btn-sm br-0 let-pointer" href="https://mlmtrees.com/product/bmw-wordpress/" target="_blank"><?php _e('Purchase Licence','BMW');?></a>
        </td>
        </tr>
      </tbody>
        <tfoot class="let-text-white">
      <tr>
        <td colspan="3" class="let-text-center"><button type="submit"   class='let-btn let-btn-success let-btn-sm let-rounded-0'><?php echo __('Update Licence Key', 'BMW')?></button>
        </td>
        </tr>
      </tfoot>
    </table>
    </form>
</form>
</div>

<?php 
}
}