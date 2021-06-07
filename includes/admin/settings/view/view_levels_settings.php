<?php 

class BMW_LEVELS 
{
  
public static function bmw_setting_levels()
  {
   
	global $wpdb;
$error=array();
if(isset($_REQUEST['level_setting']) && !empty($_REQUEST['level_setting']))
{
  $data=sanitize_text_array($_REQUEST['level_setting']);
  foreach ($data as $key => $field) {
    if(empty($field))
    {
      $error[$key]=ucwords(str_replace('_', ' ', str_replace('bmw_', '', $key))).__(" Can't Empty");
      unset($data[$key]);
    }
  }
  if(!empty($data))
  {
    update_option('bmw_level_settings',$data);
    echo '<script>location.reload(true);</script>';
  }
}
	$settings=get_option('bmw_level_settings');
	?>
  <div>
<form method="POST">

<table class="let-table let-table-bordered ">
  <thead class="let-bg-dark let-text-white">
    <tr class="let-text-center">
      <th class="let-text-center let-p-1" colspan="2">
        <h3 class="let-text-white let-float-left let-p-1 let-m-0"><?php echo __('Levels Settings','BMW');?></h3>
        <div class="let-float-right">
          <small class="let-text-secondary" style="font-size: 10px;"><?php _e('Disable/Enable','BMW');?></small><br/>
          <label class="let-switch" for="bmw_level_status">
            <input type="checkbox" name="level_setting[bmw_level_status]" value="1" id="bmw_level_status" <?php if(isset($settings['bmw_level_status'])=='1'){echo 'checked="checked"';}?>>
            <div class="let-slider let-round"></div>
            </label>
          </div>
          </th>
    </tr>
  </thead>
  <tbody class="let-bmw_level_setting">
     <tr>
    <td><?php _e('No Of levels','BMW');?></td>
    <td><input  name="level_setting[bmw_levels_count]" id="bmw_levels_count"  type="text"  value="<?php echo (isset($settings['bmw_levels_count']))?$settings['bmw_levels_count']:'';?>"  placeholder="<?php _e('No Of levels','BMW'); ?>" class="let-form-control let-rounded-0 let-number-only" >
    <?php if (isset($error['bmw_levels_count']) && !empty($error['bmw_levels_count'])) { ?>
<div class="let-alert let-alert-danger let-bmp-left-border let-p-1 let-text-left let-rounded-0 let-w-50 let-m-1"><?php echo $error['bmw_levels_count'];?></div><?php } ?></td>
   </tr>
  
  </tbody>
  <tfoot class="let-">
    <tr>
      <td colspan="2" class="let-text-center"><button class="let-btn let-btn-success let-rounded-0 let-btn-sm"><?php _e('Save Levels Settings','BMW');?></button></td>
    </tr>
  </tfoot>
  </table>
</form>
</div>
<script type="text/javascript">
  $(document).ready(function() {
    //set initial state.
   if($('#bmw_level_status').is(":checked"))
   {
     $('.bmw_level_setting').show();
   }else{
    $('.bmw_level_setting').hide();
   }
  
    $('#bmw_level_status').change(function() {
        if($(this).is(":checked")) {
          $('.bmw_level_setting').show(1000);
        }else{
           $('.bmw_level_setting').hide(1000);
        }
             
    });
});
</script>
<?php 
}
}