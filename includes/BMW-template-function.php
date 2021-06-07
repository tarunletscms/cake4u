<?php 

if(!function_exists('bmw_sidebar_function')):
	function bmw_sidebar_function()
	{
		global $wpdb,$current_user;
    if(!is_user_logged_in())
    {
      return;
    }
    $user_info=bmw_get_user_info_by_user_id($current_user->ID);
    $menu_array=get_menu_array();
    ?>

    <div class="let-col-md-3 let-left_col">
      <div class="let-scroll-view">
        <div class="let-navbar let-nav_title" style="border: 0;">
          <a href="<?php echo get_url_bmw('dashboard');?>" class="let-site_title"><i class="fa fa-group"></i> <span><?php _e('BMW PRO','BMW');?></span></a>
        </div>
        <div class="let-clearfix"></div>
        <div class="let-profile let-clearfix">

          <div class="let-pic-profile_info">
            <div class="let-pic-user-info">
              <div class="let-pic-profile-pic"><img id="profilePictureImg" src="<?php echo bmw_get_profile_picture($current_user->ID);?>"/>
                <div class="let-pic-layer">
                  <div class="let-pic-loader"></div>
                </div><a class="let-pic-image-wrapper" href="javascript:void(0)">
                  <form id="profilePictureForm" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="bmw_update_profile_picture_hook">
                    <input class="let-pic-hidden-input" id="changePicture" name="profile_picture" type="file"/>
                    <label class="let-pic-edit" for="changePicture" type="file" title="Change picture"><i class="fa fa-pencil"></i></label>
                  </form></a>
                </div>
                <div class="let-pic-username">
                  <div class="let-pic-name"><span class="let-pic-verified"></span><?php echo (isset($user_info->user_name))?$user_info->user_name:__('Log in Please','BMW');?></div>
                  <div class="let-pic-about"><?php echo (isset($current_user->user_email))?$current_user->user_email:'';?></div>
                </div>
              </div>
            </div>  
          </div>
          <!-- /menu profile quick info -->

          <!-- sidebar menu -->
          <div id="let-sidebar-menu" class="let-main_menu_side let-hidden-print let-main_menu">
            <div class="let-menu_section">
              <ul class="let-nav  let-side-menu">
                <?php $menu_array=apply_filters('bmw_side_menu_item',$menu_array);
                if(!empty($menu_array)):
                  echo side_menu_dynamic_html($menu_array);
                endif;
                ?>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="let-top_nav">
        <div class="let-nav_menu">
          <div class="let-nav let-toggle">
            <a id="let_menu_toggle"><i class="fa fa-bars"></i></a>
          </div>
        </div>
      </div>
      <?php 
    }
  endif;

  if(!function_exists('become_bmw_user_box')):
    function become_bmw_user_box(){
      bmw_icheck_enque();
      ?>
      <div class="let-col-md-12 let-col-sm-12 ">
        <div class="let-x_panel">
          <div class="let-x_title">
            <h2><?php _e('Join Us','BMW');?></h2>
            <ul class="let-nav let-navbar-right let-panel_toolbox">
              <li><a class="let-collapse-link"><i class="fa fa-chevron-up"></i></a>
              </li>
              <li><a class="let-close-link"><i class="fa fa-close"></i></a>
              </li>
            </ul>
            <div class="let-clearfix"></div>
          </div>
          <div class="let-x_content">
            <div class="let-jumbotron">
              <div class="let-login_wrapper">
                <div class="let-form let-login_form">
                  <section class="let-login_content">
                    <form id="bmw_join_form">
                      <h1><?php _e('Join Now','BMW');?></h1>
                      <div>
                        <input type="hidden" name="action" class="let-form-control" value="bmw_join_form_hook" />
                        <input type="text" id="bmw_sponsor_id" name="bmw_sponsor_id" placeholder="<?php esc_html_e('Sponsor Name *','BMW');?>" class="let-form-control">
                        <span class=" let-small bmw_sponsor_message"></span>
                      </div>
                      <div>
                       <input  id="bmw_parent" name="bmw_parent"  type="text" class="let-form-control" placeholder="<?php esc_html_e('Parent Name*','BMW');?>" value="" >
                       <span class=" let-small bmw_parent_message"></span>
                     </div>
                     
                    <div class=" let-row">
                     <div class="let-col-md-4 let-p-2">
                      <?php _e('Position','BMW');?>
                    </div>
                    <div class="let-radio let-col-md-4 let-p-1">
                      <label class="let-m-1">
                        <input type="radio" id="bmw_position" class="let-flat" value="left" name="bmw_position" > &nbsp;<?php _e('Left','BMW');?>
                      </label>
                    </div>
                    <div class="let-radio let-col-md-4 let-p-1">
                      <label class="let-m-1">
                        <input type="radio" id="bmw_position" class="let-flat" value="right" name="bmw_position" > &nbsp;<?php _e('Right','BMW');?>
                      </label>
                    </div>

                    <span class=" let-small bmw_position_message let-w-100"></span>


                  </div>
                  <div class="let-text-center">
                    <button type="submit" class="let-btn let-btn-info"><?php _e('Join Now','BMW');?></button>
                  </div>

                  <div class="let-clearfix"></div>
                </form>
              </section>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
  <?php 
}
endif;
if(!function_exists('bmw_login_function')):
  function bmw_login_function(){

    ?>
    <div class="let-col-md-12 let-col-sm-12 ">
      <div class="let-x_panel">
        <div class="let-x_title">
          <h2><?php _e('Please Login','BMW');?></h2>
          <ul class="let-nav let-navbar-right let-panel_toolbox">
            <li><a class="let-collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
            <li><a class="let-close-link"><i class="fa fa-close"></i></a>
            </li>
          </ul>
          <div class="let-clearfix"></div>
        </div>
        <div class="let-x_content">
          <div class="let-jumbotron">
            <div class="let-login_wrapper">
              <div class="let-form let-login_form">
                <section class="let-login_content">
                  <form id="bmw_login_form">
                    <h1><?php _e('Login Form','BMW');?></h1>
                    <div>
                      <input type="hidden" name="action" class="let-form-control" value="bmw_login_form_hook" />
                      <input type="text" name="username"class="let-form-control" placeholder="<?php esc_html_e('Username','BMW'); ?>" required="" />
                      <span id="username_error" class="let-text-danger let-small"></span>
                    </div>
                    <div>
                      <input type="password" name="password" class="let-form-control" placeholder="<?php esc_html_e('Password','BMW'); ?>" required="" />
                      <span id="password_error" class="let-text-danger let-small"></span>
                    </div>
                    <div class="let-text-center">
                      <span id="incorrect_credentials" class="let-text-danger let-small"></span>
                      <button type="submit" class="let-btn let-btn-success let-rounded-0  "><?php _e('Log in','BMW');?></button>
                    </div>

                    <div class="let-clearfix"></div>

                    <div class="let-separator">
                      <p class="let-change_link"><?php _e('New to site?','BMW');?>
                      <a href="<?php echo get_url_bmw('register');?>" class="let-text-success"><?php _e('Create Account','BMW');?> </a>
                    </p>
                    <div class="let-clearfix"></div>
                  </div>
                </form>
              </section>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
  <?php 
}
endif;
if(!function_exists('bmw_registration_display_function')):
  function bmw_registration_display_function(){
    global $wpdb,$current_user;

    if (!empty($_REQUEST['sp']) && isset($_REQUEST['sp'])) {
      $sp = sanitize_text_field ( $_REQUEST['sp'] );
      $sponsor_id = $wpdb->get_var("SELECT u.ID from {$wpdb->prefix}users as u,{$wpdb->prefix}bmw_users as bmp where bmp.user_name='" . $sp . "' AND u.Id=bmp.user_id");
    }
    else if(is_user_logged_in()){
      $sponsor_id=$current_user->ID;
    } else {
     $sponsor_id=''; 
   }
   if(isset($_REQUEST['leg']) && !empty($_REQUEST['leg'])){
    $position=sanitize_text_field($_REQUEST['leg']);
    if($position=='left'){
      $prdisable="let-disabled let-not-allowed";
      $pldisable="";
    }else{
      $prdisable="";
      $pldisable="let-disabled let-not-allowed";
    }
  } else{
    $position='';
    $prdisable='';
    $pldisable='';
  }
  if(isset($_REQUEST['parent']) && !empty($_REQUEST['parent'])){
    $parent=bmw_get_username_by_user_id(sanitize_text_field($_REQUEST['parent']));
  } else{
    $parent='';
  }

  $bmw_manage_general=get_option('bmw_manage_general');
$ip_address=bmw_get_client_ip();
$geopluginURL='http://www.geoplugin.net/php.gp?ip='.$ip_address;
$addrDetailsArr = unserialize(file_get_contents($geopluginURL));
//print_r($addrDetailsArr);
$country = $addrDetailsArr['geoplugin_countryCode'];
if(!$country){
   $country='';
}
// print_r($bmw_manage_general);
?>
  <div class="let-col-md-12 let-col-sm-12 ">
    <div class="let-x_panel">
              <div class="let-loader-layer">
                <div class="let-loader"></div>
              </div>
      <div class="let-x_title">
        <h2><?php _e('Register With BMP','BMW');?></h2>
        <ul class="let-nav let-navbar-right let-panel_toolbox">
          <li><a class="let-collapse-link"><i class="fa fa-chevron-up"></i></a>
          </li>
          <li><a class="let-close-link"><i class="fa fa-close"></i></a>
          </li>
        </ul>
        <div class="let-clearfix"></div>
      </div>
      <div class="let-x_content">
        <div class="let-jumbotron">
          <div class="let-registration_wrapper">
            <div class="let-form let-login_form">
              <section class="let-login_content">
                <form id="bmw_register_form">
                  <h1><?php _e('Registeration Form','BMW');?></h1>
                  <div class="let-col-md-12 let-col-xs-12 let-p-0 let-row">
                    <div class="let-col-md-6 let-col-xs-12">
                      <input type="hidden" name="action" value="bmw_user_register">
                      <input type="hidden" name="redirect_URL" value="<?php echo get_permalink($bmw_manage_general['bmw_register_url']);?>">
                      <input id="bmw_username" name="bmw_username" type="text" class="let-form-control" placeholder="<?php esc_html_e('User Name *','BMW');?>" value="">
                      <span  class=" let-small bmw_username_message"></span>
                    </div>
                    <div class="let-col-md-6 let-col-xs-12">
                     <input id="bmw_email" name="bmw_email" type="email" class="let-form-control" placeholder="<?php esc_html_e('Your Email *','BMW');?>" value="" >
                     <span  class=" let-small bmw_email_message"></span>
                   </div>

                 <!-- </div> -->
                 <!-- <div class="let-col-md-12 let-col-xs-12 let-p-0"> -->
                   <div class="let-col-md-6 let-col-xs-12">
                    <input id="bmw_first_name" name="bmw_first_name" type="text" class="let-form-control" placeholder="<?php esc_html_e('First Name *','BMW');?>" value="">
                    <span  class=" let-small bmw_first_name_message"></span>
                  </div>
                  <div class="let-col-md-6 let-col-xs-12">
                   <input  id="bmw_last_name" name="bmw_last_name" type="text" class="let-form-control" placeholder="<?php esc_html_e('Last Name *','BMW');?>" value="">
                   <span  class=" let-small bmw_last_name_message"></span>
                 </div>

               <!-- </div> -->
               <!-- <div class="let-col-md-12 let-col-xs-12 let-p-0"> -->
                <div class="let-col-md-6 let-col-xs-12">
                 <input id="bmw_password" name="bmw_password" type="password" class="let-form-control" placeholder="<?php esc_html_e('Password *','BMW');?>" value="">
                 <span  class=" let-small bmw_password_message"></span>
               </div>
               <div class="let-col-md-6 let-col-xs-12">
                <input  id="bmw_confirm_password" name="bmw_confirm_password" type="password" class="let-form-control"  placeholder="<?php esc_html_e('Confirm Password *','BMW');?>" value="" >
                <span  class=" let-small bmw_confirm_password_message"></span>
              </div>

            <!-- </div> -->
            <!-- <div class="let-col-md-12 let-col-xs-12 let-p-0"> -->
              <div class="let-col-md-6 let-col-xs-12 row let-m-0 let-p-0">
              <div class="let-col-md-3 let-col-xs-3 let-pr-md-0">
                <select class="let-form-control let-select" name="bmw-country-code" id="bmw-country-code">
                  <?php
                  $phoneCodes=bmw_get_phone_codes();
                   if(!empty( $phoneCodes)):
                    foreach ($phoneCodes as $key => $code):
                      ?>
                      <option value="<?php echo $code->phonecode;?>" <?php echo ($country==$code->iso)?'selected':'';?>><?php echo '+'.$code->phonecode.' ('.$code->country_nicename.')';?></option>
                     <?php  endforeach;
                    endif;
                    ?>
                </select>
              </div>
              <div class="let-col-md-9 let-col-xs-9 let-pl-md-0 bmw-phone-section">
                <input id="bmw_phone" name="bmw_phone" type="text" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" minlength="10" maxlength="10"  class="let-form-control" placeholder="<?php esc_html_e('Your Phone *','BMW');?>">
                <div  class=" let-small bmw_phone_message"></div>
              </div>
            </div>
                <?php if(isset($bmw_manage_general['bmw_otp_verification']) && $bmw_manage_general['bmw_otp_verification']==1):?>
              <div class="let-col-md-6 let-col-xs-12 let-text-left">
                <div class="let-d-none let-row let-m-0" id="otp_confirm_section">
                <input id="bmw_otp_field" name="bmw_otp_field" type="number" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" minlength="4" maxlength="4"  class="let-form-control let-w-50 let-ml-2 let-mr-2 let-border" placeholder="<?php esc_html_e('Enter OTP','BMW');?>">
               <a href="javascript:void(0)" class="let-text-success bmw-get-otp let-m-0 let-p-2" title="<?php _e('Resend','BMW');?>"><i class="fa fa-refresh"></i></a>
               <button class="let-btn let-btn-sm let-btn-success" type="button" id="bmw-verify-otp"><?php _e('Verify','BMW');?></button>
               </div>
               <button class="let-btn let-btn-sm let-btn-success bmw-get-otp" type="button" id="bmw-get-otp"><?php _e('Get OTP','BMW');?></button>
              </div>
             <?php endif;?>
            <!-- </div> -->
            <!-- <div class="let-col-md-12 let-col-xs-12 let-p-0"> -->
               <div class="let-col-md-6 let-col-xs-12">
                <input type="text" id="bmw_sponsor_id" name="bmw_sponsor_id" placeholder="<?php esc_html_e('Sponsor Name *','BMW');?>" value="<?php echo (isset($sponsor_id))?bmw_get_username_by_user_id($sponsor_id):'';?>" class="let-form-control">
                <span class=" let-small bmw_sponsor_message"></span>
              </div>
              <div class="let-col-md-6 let-col-xs-12">
                <input  id="bmw_parent" name="bmw_parent"  type="text" class="let-form-control" value="<?php echo  $parent;?>" placeholder="<?php esc_html_e('Parent Name*','BMW');?>" value="" >
                <span class=" let-small bmw_parent_message"></span>
              </div>
            <!-- </div> -->
            <div class="let-col-md-12 let-col-xs-12 let-row">
             <div class="let-col-md-4 let-p-2">
              <?php _e('Position','BMW');?>
            </div>
            <div class="let-radio let-col-md-4 let-p-1">
              <label class="let-m-1">
                <input type="radio" id="bmw_position" class="let-flat" value="left" name="bmw_position" <?php echo (isset($position) && $position=='left')?'checked readonly':'';?>  <?php echo $pldisable;?>> &nbsp;<?php _e('Left');?>
              </label>
            </div>
            <div class="let-radio let-col-md-4 let-p-1">
              <label class="let-m-1">
                <input type="radio" id="bmw_position" class="let-flat" value="right" name="bmw_position"  <?php echo (isset($position) && $position=='right')?'checked readonly':'';?> <?php echo $prdisable;?>> &nbsp;<?php _e('Right');?>
              </label>
            </div>

            <span class=" let-small bmw_position_message let-w-100"></span>


          </div>
        </div>
        <div class="let-text-center">
          <button type="submit" class="let-btn let-btn-success"><?php _e('Submit','BMW');?></button>
        </div>

        <div class="let-clearfix"></div>

        <div class="let-separator let-text-center">
          <p class="let-change_link let-small"><?php _e('Already have Account?','BMW');?>
          <a href="<?php echo get_url_bmw('dashboard');?>" class=""><?php _e('Login Now','BMW');?> </a>
        </p>
        <div class="let-clearfix"></div>
      </div>
    </form>
  </section>
</div>

</div>
</div>
</div>
</div>
</div>
<?php 
}
endif;

if(!function_exists('bmw_user_top_bar_function')):
  function  bmw_user_top_bar_function(){
    global $wpdb,$current_user;
    $user_id=$current_user->ID;
    $user_key=bmw_get_current_user_key();

    $total_earning=$wpdb->get_var("SELECT SUM(total_amount) FROM {$wpdb->prefix}bmw_payout WHERE user_key='".$user_key."'");
    $total_withdrawal=$wpdb->get_var("SELECT SUM(amount) FROM {$wpdb->prefix}bmw_withdrawal WHERE user_id='".$user_id."'");
    $total_bonus=$wpdb->get_var("SELECT SUM(total_bonus) FROM {$wpdb->prefix}bmw_payout WHERE user_key='".$user_key."'");

    $total_downliners=$wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}bmw_users WHERE sponsor_key='".$user_key."'"); 

    $total_left_downliners=$wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}bmw_users WHERE sponsor_key='".$user_key."' AND position='left'");

    $total_right_downliners=$wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}bmw_users WHERE sponsor_key='".$user_key."' AND position='right'");

    $total_downliners_week=$wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}bmw_users WHERE sponsor_key='".$user_key."' AND DATE(creation_date) > (NOW() - INTERVAL 7 DAY)");  
    
    $total_left_downliners_week=$wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}bmw_users WHERE sponsor_key='".$user_key."' AND position='left' AND DATE(creation_date) > (NOW() - INTERVAL 7 DAY)"); 

    $total_right_downliners_week=$wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}bmw_users WHERE sponsor_key='".$user_key."' AND position='right' AND DATE(creation_date) > (NOW() - INTERVAL 7 DAY)"); 

    $total_earning_week=$wpdb->get_var("SELECT SUM(total_amount) FROM {$wpdb->prefix}bmw_payout WHERE user_key='".$user_key."' AND DATE(insert_date) > (NOW() - INTERVAL 7 DAY)"); 
    $total_withdrawal_week=$wpdb->get_var("SELECT SUM(amount) FROM {$wpdb->prefix}bmw_withdrawal WHERE user_id='".$user_id."' AND DATE(withdrawal_initiated_date) > (NOW() - INTERVAL 7 DAY)");
    $total_bonus_week=$wpdb->get_var("SELECT SUM(total_bonus) FROM {$wpdb->prefix}bmw_payout WHERE user_key='".$user_key."' AND DATE(insert_date) > (NOW() - INTERVAL 7 DAY)");
    if(isset($total_downliners) && $total_downliners_week){$user_week_percent=$total_downliners_week/$total_downliners*100;} 
    if(isset($total_left_downliners) && $total_left_downliners_week){$left_week_percent=$total_left_downliners_week/$total_left_downliners*100;}
    if(isset($total_right_downliners) && $total_right_downliners_week){$right_week_percent=$total_right_downliners_week/$total_right_downliners*100;}
    if(isset($total_earning) && !empty((int)$total_earning_week) && !empty((int)$total_earning)){$earning_week_percent=$total_earning_week/$total_earning*100;}
    if(isset($total_earning) && !empty((int)$total_earning_week) && !empty((int)$total_earning)){
      if($total_withdrawal==0){
        $withdrawal_week_percent=$total_withdrawal_week*100;
      } else {
      $withdrawal_week_percent=$total_withdrawal_week/$total_withdrawal*100;  
      }
      
    }
    if(isset($total_bonus) && !empty((int)$total_bonus_week) && !empty((int)$total_bonus)){$bonus_week_percent=$total_bonus_week/$total_bonus*100;}
    ?>
    <div class="let-container">
      <div class=" let-tile_count">
        <div class="let-col-md-2 let-col-sm-4 let-col-xs-6 let-tile_stats_count let-text-center let-p-0">
          <span class="let-count_top"><i class="fa fa-user"></i><?php echo __('Total Downliners','BMW');?></span>
          <div class="let-count"><?php echo $total_downliners;?></div>
          <span class="let-count_bottom"><i class="let-green"><?php if(isset($user_week_percent)){echo round($user_week_percent,2).'%';}else{echo '0%';}?></i> <?php echo __('From last Week','BMW');?></span>
        </div>
        <div class="let-col-md-2 let-col-sm-4 let-col-xs-6 let-tile_stats_count let-text-center let-p-0">
          <span class="let-count_top"><i class="fa fa-money "></i><?php echo __('Total Earnings','BMW');?></span>
          <div class="let-count let-green"><?php echo bmw_price($total_earning);?></div>
          <span class="let-count_bottom"><i class="let-green"><i class="fa fa-sort-asc"></i><?php if(isset($earning_week_percent)){echo round($earning_week_percent,2).'%';}else{echo '0%';}?> </i> <?php echo __('From last Week','BMW');?></span>
        </div>
        <div class="let-col-md-2 let-col-sm-4 let-col-xs-6 let-tile_stats_count let-text-center let-p-0">
          <span class="let-count_top"><i class="fa fa-caret-square-o-down"></i> <?php echo __('Total Withdrawals','BMW');?></span>
          <div class="let-count let-red"><?php echo bmw_price($total_withdrawal);?></div>
          <span class="let-count_bottom"><i class="let-green"><i class="fa fa-sort-asc"></i><?php if(isset($withdrawal_week_percent)){echo round($withdrawal_week_percent,2).'%';}else{echo '0%';}?></i><?php echo __('From last Week','BMW');?></span>
        </div>
        <div class="let-col-md-2 let-col-sm-4 let-col-xs-6 let-tile_stats_count let-text-center let-p-0">
          <span class="let-count_top"><i class="fa fa-money"></i> <?php echo __('Total Bonus Earn','BMW');?></span>
          <div class="let-count let-blue"><?php echo bmw_price($total_bonus,'PV');?></div>
          <span class="let-count_bottom"><i class="let-green"><i class="fa fa-sort-asc"></i><?php if(isset($bonus_week_percent)){echo round($bonus_week_percent).'%';}else{echo '0%';}?></i><?php echo __('From last Week','BMW');?></span>
        </div>
        <div class="let-col-md-2 let-col-sm-4 let-col-xs-6 let-tile_stats_count let-text-center let-p-0">
          <span class="let-count_top"><i class="fa fa-user"></i> <?php echo __('Total Left Users','BMW');?></span>
          <div class="let-count"><?php echo $total_left_downliners;?></div>
          <span class="let-count_bottom"><i class="let-green"><i class="fa fa-sort-asc"></i><?php if(isset($left_week_percent)){echo round($left_week_percent,2).'%';}else{echo '0%';}?> </i><?php echo __('From last Week','BMW');?></span>
        </div>
        <div class="let-col-md-2 let-col-sm-4 let-col-xs-6 let-tile_stats_count let-text-center let-p-0">
          <span class="let-count_top"><i class="fa fa-user"></i> <?php echo __('Total Right Users','BMW');?></span>
          <div class="let-count"><?php echo $total_right_downliners;?></div>
          <span class="let-count_bottom"><i class="let-green"><i class="fa fa-sort-asc"></i><?php if(isset($right_week_percent)){echo round($right_week_percent,2).'%';}else{echo '0%';}?></i><?php echo __('From last Week','BMW');?></span>
        </div>

      </div>
    </div>
  <?php }

endif;

if(!function_exists('bmw_user_withdrawal_graph_function')):
  function bmw_user_withdrawal_graph_function(){
    global $wpdb,$current_user;
    $user_id=$current_user->ID;
    $user_key=bmw_get_current_user_key();

    $months_array=array('0'=>1,'1'=>2,'2'=>3,'3'=>4,'4'=>5,'5'=>6,'6'=>7,'7'=>8,'8'=>9,'9'=>10,'10'=>11,'11'=>12);
    $Year_array=date('Y');
    $data=array();
    $earningdata=array();
    foreach ($months_array as $key => $months_array) {
      $amount=$wpdb->get_var("SELECT SUM(amount) FROM {$wpdb->prefix}bmw_withdrawal WHERE user_id='".$user_id."' AND MONTH(withdrawal_initiated_date)='".$months_array."' AND YEAR(withdrawal_initiated_date)='".$Year_array."'");
      $earning=$wpdb->get_var("SELECT SUM(total_amount) FROM {$wpdb->prefix}bmw_payout WHERE user_key='".$user_key."' AND MONTH(insert_date)='".$months_array."' AND YEAR(insert_date)='".$Year_array."'");
      $data[]=array($months_array,($amount)?$amount:0);
      $earningdata[]=array($months_array,($earning)?$earning:0);
    }
    $jsonstr='';
    $jsonern='';
    foreach($data as $key=>$value){
    //echo date("l F Y h:i:s");
      if($key==11){
       $jsonstr.= '"'.$key.'":"'.$value[1].'"';  
     } else {
       $jsonstr.= '"'.$key.'":"'.$value[1].'",';
     }

   }foreach($earningdata as $key=>$value){
    //echo date("l F Y h:i:s");
    if($key==11){
     $jsonern.= '"'.$key.'":"'.$value[1].'"';  
   } else {
     $jsonern.= '"'.$key.'":"'.$value[1].'",';
   }

 }

 $users=$wpdb->get_results("SELECT * FROM {$wpdb->prefix}bmw_users WHERE sponsor_key='".$user_key."' ORDER BY user_id DESC LIMIT 5");
 ?>
 <br/>
 <div class="let-container">
  <div class="let-col-md-7 let-col-sm-7 let-col-xs-12">
    <div class="let-col-md-12 let-col-sm-12 ">
      <div class="let-x_panel">
        <div class="let-x_title">
          <h2><?php _e('Graphical Transaction Details','BMW');?> <span class="let-small"><?php echo __('As per Month','BMW');?></span></h2>
          <ul class="let-nav let-navbar-right let-panel_toolbox">
            <li><a class="let-collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
            <li><a class="let-close-link"><i class="fa fa-close"></i></a>
            </li>
          </ul>
          <div class="let-clearfix"></div>
        </div>
        <div class="let-x_content">
          <input type="hidden" name="data" id="data" value='<?php echo $jsonstr;?>'>
          <input type="hidden" name="earndata" id="earndata" value='<?php echo $jsonern;?>'>

          <div class="let-graph_column">
            <canvas id="bar-chart" width="800px" height="450px"></canvas>
          </div>
        </div>
      </div>
    </div>

  </div>
  <div class="let-col-md-5 let-col-sm-12 let-col-xs-12">

    <div class="let-col-md-12 let-col-sm-12 ">
      <div class="let-x_panel">
        <div class="let-x_title">
          <h2><?php _e('Top User','BMW');?> <span class="let-small"><?php echo __('Profiles','BMW');?></span></h2>
          <ul class="let-nav let-navbar-right let-panel_toolbox">
            <li><a class="let-collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
            <li><a class="let-close-link"><i class="fa fa-close"></i></a>
            </li>
          </ul>
          <div class="let-clearfix"></div>
        </div>
        <div class="let-x_content">
         <div class="let-profile_column">
          <div class="let-x_title let-text-center"> 
            <i class="fa fa-square let-blue"></i><span><?php echo __('Paid & Right','BMW');?></span><i class="fa fa-square let-green"></i><span><?php echo __('Paid & Left','BMW');?></span><i class="fa fa-square let-aero"></i><span><?php echo __('UnPaid','BMW');?></span>
          </div>
          <ul class="let-list-unstyled let-top_profiles let-scroll-view">
            <?php foreach ($users as $key => $user) {$user_info=get_userdata($user->user_id); ?>

              <li class="let-media let-event">
                <?php if($user->payment_status==0){?>
                  <a class="let-pull-left let-border-aero let-profile_thumb">
                    <i class="fa fa-user let-aero"></i>
                  </a>
                <?php } else if ($user->payment_status!==0 && $user->position=='left') {?>
                  <a class="let-pull-left let-border-green let-profile_thumb">
                    <i class="fa fa-user let-green"></i>
                    </a><?php } else if($user->payment_status!==0 && $user->position=='right') {?>
                      <a class="let-pull-left let-border-blue let-profile_thumb">
                        <i class="fa fa-user let-blue"></i>
                      </a>
                    <?php }?>

                    <div class="let-media-body">
                      <p class="let-title"><?php echo $user->user_name;?></p>
                      <p><strong><?php echo __('User Key','BMW');?>&nbsp;:</strong><?php echo $user->user_key;?><strong>, <?php echo __('Position','BMW');?> :</strong><?php echo $user->position;?></p>
                      <p><small><?php echo __('Email','BMW'); echo '&nbsp;: '.$user_info->user_email;?></small> <small>, <?php echo __('Earnings','BMW'); echo ' :'.bmw_price(bmw_get_earning_sum_by_user_key($user->user_key));?></small>
                      </p>
                    </div>
                  </li>
                <?php } ?>

              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
  <script type="text/javascript">
    jQuery(document).ready(function(){ 
      var data=$('#data').val();
      var dataearn=$('#earndata').val();
      var DATA='{'+data+'}';
      var DATAEARN='{'+dataearn+'}';
      var obj = jQuery.parseJSON(DATA);
      var objearn = jQuery.parseJSON(DATAEARN);
      var dt= new Date();
      var year = dt.getFullYear();
      new Chart(document.getElementById("bar-chart"), {
        type: 'bar',
        data: {
          labels: ["<?php _e('Jan','BMW');?>", "<?php _e('Feb','BMW');?>", "<?php _e('Mar','BMW');?>", "<?php _e('Apr','BMW');?>", "<?php _e('May','BMW');?>", "<?php _e('Jun','BMW');?>", "<?php _e('Jul','BMW');?>", "<?php _e('Aug','BMW');?>", "<?php _e('Sep','BMW');?>", "<?php _e('Oct','BMW');?>", "<?php _e('Nov','BMW');?>", "<?php _e('Dec','BMW');?>"],
          datasets: [
          {label: "<?php _e('Total Withdrawals','BMW');?>",
          backgroundColor: "rgba(71, 181, 241, 0.31)",
          borderColor: "rgba(38, 185, 154, 0.7)",
          pointBorderColor: "rgba(38, 185, 154, 0.7)",
          pointBackgroundColor: "rgba(38, 185, 154, 0.7)",
          pointHoverBackgroundColor: "#fff",
          pointHoverBorderColor: "rgba(220,220,220,1)",
          pointBorderWidth: 2,
          type: "line",
          // borderColor: "rgb(25, 38, 140)",
          // pointBorderWidth:4,
          // pointBorderColor:"rgb(242, 192, 130)",
          data: [obj[0],obj[1],obj[2],obj[3],obj[4],obj[5],obj[6],obj[7],obj[8],obj[9],obj[10],obj[11]],
          fill: true
        },{
          label: "<?php _e('Total Earnings','BMW');?>",
          backgroundColor: "rgb(6, 86, 165)",
          //borderColor:"rgb(30, 121, 206)",
          //borderWidth:3,
          data: [objearn[0],objearn[1],objearn[2],objearn[3],objearn[4],objearn[5],objearn[6],objearn[7],objearn[8],objearn[9],objearn[10],objearn[11]]
          

        },
        ]
      },
      options: {
        legend: { display: true,labels: {defaultFontSize:'125'} },
        title: {
          display: false,
          text: "<?php _e('Graphical Transaction Details As per Month','BMW');?>"
        },
        responsive: true 
      }
    });
    });
  </script>
  <?php
}
endif;

if(!function_exists('bmw_user_earnings_graph_function')):
  function bmw_user_earnings_graph_function(){
    global $wpdb,$current_user;
    $earnings=array();
    $settings=get_option('bmw_manage_general');
    $user_key=bmw_get_current_user_key();
    $recent_registers=$wpdb->get_results("SELECT u.user_id, u.user_name, u.creation_date, u.parent_key FROM {$wpdb->prefix}bmw_users as u JOIN {$wpdb->prefix}bmw_hierarchy as h ON u.user_key=h.user_key WHERE h.parent_key='".$user_key."' ORDER BY user_id DESC LIMIT 5 ");
    $my_earning=bmw_user_total_earnings_by_user_key($user_key);
    $my_earnings=json_encode($my_earning);
    $total=(isset( $settings['bmw_plan_base']) &&  $settings['bmw_plan_base']=='points')?'total_points':'total_amount';
    if($my_earning[$total]>0){

      $pair_commission=$my_earning['pair_commission']/$my_earning[$total]*100;
      $faststart_commission=$my_earning['faststart_commission']/$my_earning[$total]*100;
      $tax=$my_earning['tax']/$my_earning[$total]*100;
      $service_charge=$my_earning['service_charge']/$my_earning[$total]*100;
      $referral_commission=$my_earning['referral_commission']/$my_earning[$total]*100;
      $leadership_commission=$my_earning['leadership_commission']/$my_earning[$total]*100;
      $one_time_bonus=$my_earning['one_time_bonus']/$my_earning[$total]*100;}
      ?>

      <div class="let-container">
        <div class="let-col-md-7 let-col-sm-7 let-col-xs-12">
          <div class="let-col-md-12 let-col-sm-12 ">
            <div class="let-x_panel">
              <div class="let-x_title">
                <h2><?php _e('My Total Earnings','BMW');?> <span class="let-small"><?php echo $my_earning[$total];?></span><span class="let-small"><?php _e('Charges','BMW');?></span><span class="let-small"><?php echo bmw_price($my_earning['tax']+$my_earning['service_charge'],'PV');?></span></h2>
                <ul class="let-nav let-navbar-right let-panel_toolbox">
                  <li><a class="let-collapse-link"><i class="fa fa-chevron-up"></i></a>
                  </li>
                  <li><a class="let-close-link"><i class="fa fa-close"></i></a>
                  </li>
                </ul>
                <div class="let-clearfix"></div>
              </div>
              <div class="let-x_content">
                <input type="hidden" name="total_earnings" value='<?php echo json_encode($my_earning);?>' id="my_earnings">
                <div class="let-col-lg-6 let-col-md-6 let-col-sm-12 let-col-xs-12">
                  <canvas class="canvasDoughnut" height="200" width="200" style="margin: 15px 10px 10px 0"></canvas>

                </div>
                <div class="let-col-lg-6 let-col-md-6 let-col-sm-12 let-col-xs-12">
                  <table class="let-table let-table-sm let-table-borderless let-pie-table">
                    <tr>
                      <td>
                        <i class="fa fa-square let-blue"></i><?php echo __('Pair Commission','BMW');?>
                      </td>
                      <td><?php if(isset($pair_commission)){echo round($pair_commission,2).'%';}else {echo '0%';}?></td><br/>
                    </tr>
                    <tr>
                      <td>
                        <i class="fa fa-square let-green"></i><?php echo __('Refferal Commission','BMW');?>
                      </td>
                      <td><?php if(isset($referral_commission)){echo round($referral_commission,2).'%';}else {echo '0.00%';}?></td>
                    </tr>
                    <tr>
                      <td>
                       <i class="fa fa-square" style="color: #34495E"></i><?php echo __('Leadership Commission','BMW');?>
                     </td>
                     <td><?php if(isset($leadership_commission)){echo round($leadership_commission,2).'%';}else {echo '0.00%';}?></td>
                   </tr>
                   <tr>
                    <td>
                      <i class="fa fa-square let-green"></i><?php echo __('Faststart Commission','BMW');?>
                    </td>
                    <td><?php if(isset($bonus_commission)){ echo round($faststart_commission,2).'%';}else {echo '0.00%';}?></td>
                  </tr>
                    <tr>
                      <td>
                        <i class="fa fa-square let-purple"></i><?php echo __('One Time Leader Bonus','BMW');?>
                      </td>
                      <td><?php if(isset($one_time_bonus)){echo round($one_time_bonus,2).'%';}else {echo '0%';}?></td><br/>
                    </tr>
                  <tr>
                    <td>
                     <i class="fa fa-square let-aero"></i><?php echo __('Tax','BMW');?>
                   </td>
                   <td><?php if(isset($tax)){ echo round($tax,2).'%';}else {echo '0.00%';}?></td>
                 </tr>
                 <tr>
                  <td>
                   <i class="fa fa-square let-red"></i><?php echo __('Service Charge','BMW');?> 
                 </td>
                 <td><?php if(isset($service_charge)){echo round($service_charge,2).'%';}else {echo '0.00%';}?></td>
               </tr>
             </table>


           </div>

         </div>
       </div>
     </div>
   </div>
   

   <div class="let-col-md-5 let-col-sm-5 let-col-xs-12">
    <div class="let-col-md-12 let-col-sm-12 ">
      <div class="let-x_panel">
        <div class="let-x_title">
          <h2><?php _e('Recent Registerations','BMW');?> </h2>
          <ul class="let-nav let-navbar-right let-panel_toolbox">
            <li><a class="let-collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
            <li><a class="let-close-link"><i class="fa fa-close"></i></a>
            </li>
          </ul>
          <div class="let-clearfix"></div>
        </div>
        <div class="let-x_content">
         <ul class="let-list-unstyled let-timeline">

           <?php if(!empty($recent_registers)){
            foreach ($recent_registers as $key => $recent_users) {
              $user=get_userdata($recent_users->user_id); 
              ?>
              <li>
                <div class="let-block">
                  <div class="let-tags">
                    <a href="" class="let-tag">
                      <span><?php echo $recent_users->user_name;?></span>
                    </a>
                  </div>
                  <div class="let-block_content">
                    <h2 class="let-title"> <?php echo $user->user_email;?></h2>
                    <div class="let-byline">
                      <span class="let-small"><?php echo get_time_ago($recent_users->creation_date)?>&nbsp;<?php _e('Under','BMW');?></span>  <a href="javascript:void(0)"><?php if($recent_users->parent_key){ echo bmw_get_username_by_userkey($recent_users->parent_key);}?></a>
                    </div>
                    <p class="let-excerpt"></p>
                  </div>
                </div>
              </li>
            <?php } }?>

          </ul>



        </div>
      </div>
    </div>

  </div>
</div>
<script type="text/javascript">
  jQuery(document).ready(function(){
    var earnings=$('#my_earnings').val();
    var earnings_data = jQuery.parseJSON(earnings);
    console.log(earnings_data);
    if ($('.canvasDoughnut').length){   
      var chart_doughnut_settings = {
        type: 'doughnut',
        tooltipFillColor: "rgba(51, 51, 51, 0.55)",
        data: {
          labels: [
          "Pair",
          "One Time Bonus",
          "Tax",
          "Service",
          "Refferal",
          "Leader Bonus",
          "FastStart Bonus"
          ],
          datasets: [{
            data: [earnings_data['pair_commission'], earnings_data['one_time_bonus'], earnings_data['tax'], earnings_data['service_charge'], earnings_data['referral_commission'], earnings_data['leadership_commission'], earnings_data['faststart_commission']],
            backgroundColor: [
            "#3498DB",
            "#9B59B6",
            "#BDC3C7",
            "#E74C3C",
            "#26B99A",
            "#34495E",
            "#00cc7a"

            ],
            hoverBackgroundColor: [
            "#49A9EA",
            "#B370CF",
            "#CFD4D8",
            "#E95E4F",
            "#36CAAB",
            "#34495E",
            "#00995c"

            ]
          }]
        },
        options: { 
          legend: false, 
          responsive: false 
        }
      }
      $('.canvasDoughnut').each(function(){

        var chart_element = $(this);
        var chart_doughnut = new Chart( chart_element, chart_doughnut_settings);

      });         

    }  
  });
</script>

<?php
}
endif;

if(!function_exists('bmw_personal_info_display_function')):
  function bmw_personal_info_display_function($user_id,$user_key)
  {
    global $wpdb;
    $user=get_user_by('ID',$user_id);
    $user_info=bmw_get_user_info_by_userkey($user_key); 
    ?>
    <div class="let-col-md-12 let-col-sm-12 ">
      <div class="let-x_panel">
        <div class="let-x_title">
          <h2><?php _e('Personal Information','BMW');?> </h2>
          <ul class="let-nav let-navbar-right let-panel_toolbox">
            <li><a class="let-collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
            <li><a class="let-close-link"><i class="fa fa-close"></i></a>
            </li>
          </ul>
          <div class="let-clearfix"></div>
        </div>
        <div class="let-x_content">

          <div class="let-col-md-12 let-row let-col-sm-12  let-col-xs-12  let-m-0 let-p-0">
            <div class="let-col-md-6 let-col-xs-6 let-col-sm-12  let-col-xs-12  let-m-0 let-p-1">
              <div class="let-x_panel">
                <div class="let-x_title">
                  <h2><?php _e('User Details','BMW');?> </h2>
                  <ul class="let-nav let-navbar-right let-panel_toolbox">
                    <li><a class="let-collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                    <li><a class="let-close-link"><i class="fa fa-close"></i></a>
                    </li>
                  </ul>
                  <div class="let-clearfix"></div>
                </div>
                <div class="let-x_content">
                  <table class="let-table let-table-bordered">
                    <tbody class="let-text-center">
                      <tr>
                        <th class="let-w-50"><?php _e('Username','BMW');?></th>
                        <td class="let-w-50"><?php echo $user->user_login;?></td>
                      </tr>
                      <tr>
                        <th class="let-w-50"><?php _e('Your Email','BMW');?></th>
                        <td class="let-w-50"><?php echo $user->user_email;?></td>
                      </tr>
                      <tr>
                        <th class="let-w-50"><?php _e('Leader Post','BMW');?></th>
                        <td class="let-w-50"><?php echo get_leadership_bonus_name_leader_id($user_info->leader_post)?get_leadership_bonus_name_leader_id($user_info->leader_post):'--';?></td>
                      </tr>
                      <tr>
                        <th class="let-w-50"><?php _e('Your Mobile','BMW');?></th>
                        <td class="let-w-50"><?php echo (get_user_meta($user_id,'bmw_phone',true)?get_user_meta($user_id,'bmw_phone',true):get_user_meta($user_id,'billing_phone',true));?></td>
                      </tr>
                      <tr>
                        <th class="let-w-50"><?php _e('Reg. Date','BMW');?></th>
                        <td class="let-w-50"><?php echo date('d-M-Y',strtotime($user->user_registered));?></td>
                      </tr>
                    </tbody>
                  </table>

                </div>
              </div>
            </div>
            <div class="let-col-md-6 let-col-xs-6 let-col-sm-12  let-col-xs-12  let-m-0 let-p-1 ">
              <div class="let-x_panel">
                <div class="let-x_title">
                  <h2><?php _e('BMP Details','BMW');?> </h2>
                  <ul class="let-nav let-navbar-right let-panel_toolbox">
                    <li><a class="let-collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                    <li><a class="let-close-link"><i class="fa fa-close"></i></a>
                    </li>
                  </ul>
                  <div class="let-clearfix"></div>
                </div>
                <div class="let-x_content">
                  <table class="let-table let-table-bordered">
                    <tbody class="let-text-center">
                      <tr>
                        <th class="let-w-50"><?php _e('User Key','BMW');?></th>
                        <td class="let-w-50"><?php echo $user_info->user_key;?></td>
                      </tr>
                      <tr>
                        <th class="let-w-50"><?php _e('Sponsor Key','BMW');?></th>
                        <td class="let-w-50"><?php echo $user_info->sponsor_key;?></td>
                      </tr>
                      <tr>
                        <th class="let-w-50"><?php _e('Parent Key','BMW');?></th>
                        <td class="let-w-50"><?php echo $user_info->parent_key;?></td>
                      </tr>
                      <tr>
                        <th class="let-w-50"><?php _e('Position','BMW');?></th>
                        <td class="let-w-50"><?php echo ucwords($user_info->position);?></td>
                      </tr>
                      <tr>
                        <th class="let-w-50"><?php _e('Payment Date','BMW');?></th>
                        <td class="let-w-50"><?php if($user_info->payment_date!=='0000-00-00 00:00:00'){ echo  date('d-M-Y',strtotime($user_info->payment_date));} else { echo __('Not Paid Yet','bmw');}?></td>
                      </tr>
                    </tbody>
                  </table>

                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>

    <?php 
  }
endif;


if(!function_exists('bmw_bank_details_display_function')):
  function bmw_bank_details_display_function()
  {
    global $wpdb;
    $user_key=bmw_get_current_user_key();
    $bank_info=bmw_get_bank_info($user_key); 
    ?>
    <div class="let-col-md-12 let-col-sm-12 ">
      <div class="let-x_panel">
        <div class="let-x_title">
          <h2><?php _e('Bank Details','BMW');?> </h2>
          <ul class="let-nav let-navbar-right let-panel_toolbox">
            <li><a class="let-collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
            <li><a class="let-close-link"><i class="fa fa-close"></i></a>
            </li>
          </ul>
          <div class="let-clearfix"></div>
        </div>
        <div class="let-x_content">
         <span id="form-message"></span>
         <form class="let-form-label-left let-input_mask" id="account_details_form">

           <div class="let-form-group let-row ">
            <label class="let-control-label let-col-md-4 let-col-sm-4 let-col-xs-12 let-font-weight-normal let-text-secondary let-p-2 let-small"><?php _e('Account Holder Name','BMW');?>:*</label>
            <div class="let-col-md-8 let-col-sm-8 let-col-xs-12">
              <input type="hidden" name="action" value="bmw_account_details_update" >
              <input type="text" name="account_holder_name" class="let-form-control let-rounded-0"  value="<?php echo (!empty($bank_info->account_holder))?$bank_info->account_holder:'';?>"  placeholder="<?php _e('A/c Holder Name','BMW');?>">
              <span class="let-small let-text-danger" id="account_holder_name"></span>
            </div>
          </div>
          <div class="let-form-group let-row ">
            <label class="let-control-label let-col-md-4 let-col-sm-4 let-col-xs-12 let-font-weight-normal let-text-secondary let-p-2 let-small"><?php _e('Account No','BMW');?>:*</label>
            <div class="let-col-md-8 let-col-sm-8 let-col-xs-12">
              <input type="text" name="account_number" class="let-form-control let-rounded-0"  value="<?php echo (!empty($bank_info->account_number))?$bank_info->account_number:'';?>"  placeholder="<?php _e('Account No','BMW');?>">
              <span class="let-small let-text-danger" id="account_number"></span>
            </div>
          </div>
          <div class="let-form-group let-row ">
            <label class="let-control-label let-col-md-4 let-col-sm-4 let-col-xs-12 let-font-weight-normal let-text-secondary let-p-2 let-small"><?php _e('Bank Name','BMW');?>:*</label>
            <div class="let-col-md-8 let-col-sm-8 let-col-xs-12">
              <input type="text" name="bank_name" class="let-form-control let-rounded-0"  value="<?php echo (!empty($bank_info->bank_name))?$bank_info->bank_name:'';?>"  placeholder="<?php _e('Bank Name','BMW');?>">
              <span class="let-small let-text-danger" id="bank_name"></span>
            </div>
          </div>
          <div class="let-form-group let-row ">
            <label class="let-control-label let-col-md-4 let-col-sm-4 let-col-xs-12 let-font-weight-normal let-text-secondary let-p-2 let-small"><?php _e('Branch','BMW');?>:*</label>
            <div class="let-col-md-8 let-col-sm-8 let-col-xs-12">
              <input type="text" name="branch" class="let-form-control let-rounded-0"  value="<?php echo (!empty($bank_info->branch))?$bank_info->branch:'';?>"  placeholder="<?php _e('Branch Name','BMW');?>">
              <span class="let-small let-text-danger" id="branch"></span>
            </div>
          </div>
          <div class="let-form-group let-row ">
            <label class="let-control-label let-col-md-4 let-col-sm-4 let-col-xs-12 let-font-weight-normal let-text-secondary let-p-2 let-small"><?php _e('IFSC Code','BMW');?>:*</label>
            <div class="let-col-md-8 let-col-sm-8 let-col-xs-12">
              <input type="text" name="ifsc_code" class="let-form-control let-rounded-0"  value="<?php echo (!empty($bank_info->ifsc_code))?$bank_info->ifsc_code:'';?>"  placeholder="<?php _e('IFSC Code','BMW');?>">
              <span class="let-small let-text-danger" id="ifsc_code"></span>

            </div>
          </div>
          <div class="let-form-group let-row ">
            <label class="let-control-label let-col-md-4 let-col-sm-4 let-col-xs-12 let-font-weight-normal let-text-secondary let-p-2 let-small"><?php _e('Contact No.','BMW');?>:*</label>
            <div class="let-col-md-8 let-col-sm-8 let-col-xs-12">
              <input type="text" name="contact_number" class="let-form-control let-rounded-0"  value="<?php echo (!empty($bank_info->contact_number))?$bank_info->contact_number:'';?>"  placeholder="<?php _e('Contact No.','BMW');?>">
              <span class="let-small let-text-danger" id="contact_number"></span>
            </div>
          </div>
          <div class="let-text-center let-col-md-12">
            <button class="let-btn let-btn-success let-rounded-0"><?php _e('Submit','BMW');?></button>
          </div>

        </form>

      </div>
    </div>

  </div>

  <?php 
}
endif;
if(!function_exists('bmw_payout_list_display_function')):
  function bmw_payout_list_display_function($user_id,$user_key,$payout_id=NULL)
  {
    $payouts_list=bmw_payout_list_by_user_key($user_key,$payout_id);
    ?>
    <div class="let-col-md-12 let-col-sm-12 ">
      <div class="let-x_panel">
        <div class="let-x_title">
          <h2><?php _e('Payouts List','BMW');?> </h2>
          <ul class="let-nav let-navbar-right let-panel_toolbox">
            <li><a class="let-collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
            <li><a class="let-close-link"><i class="fa fa-close"></i></a>
            </li>
          </ul>
          <div class="let-clearfix"></div>
        </div>
        <div class="let-x_content">
          <div class="let-row">
            <div class="let-col-sm-12">
              <div class="let-card-box let-table-responsive">
                <table class="let-table let-table-sm lets-datatable let-table-bordered dt-responsive" cellspacing="0" width="100%">
                  <thead>
                    <tr class="let-text-center">
                      <th><small><?php _e('Payout id','BMW');?></small></th>
                      <th><small><?php _e('Pair C.','BMW');?></small></th>
                      <th><small><?php _e('Referral C.','BMW');?></small></th>
                      <th><small><?php _e('FastStart C.','BMW');?></small></th>
                      <th><small><?php _e('Leadership C.','BMW');?></small></th>
                      <th><small><?php _e('One time Leader Bonus','BMW');?></small></th>
                      <th><small><?php _e('Tax','BMW');?></small></th>
                      <th><small><?php _e('Service Charge','BMW');?></small></th>
                      <th><small><?php _e('Total Points','BMW');?></small></th>
                      <th><small><?php _e('Total Amount','BMW');?></small></th>
                      <th><small><?php _e('Date','BMW');?></small></th>

                    </tr>
                  </thead>
                  <tbody>
                    <?php  
                    if(!empty($payouts_list)){
                      foreach ($payouts_list as $key => $payout) {
                       ?>
                       <tr class="let-text-center">
                         <td><?php echo $payout->payout_id;?></td>
                         <td><?php echo $payout->pair_commission;?></td>
                         <td><?php echo $payout->referral_commission;?></td>
                         <td><?php echo $payout->faststart_commission;?></td>
                         <td><?php echo $payout->leadership_commission;?></td>
                         <td><?php echo $payout->one_time_bonus;?></td>
                         <td><?php echo $payout->tax;?></td>
                         <td><?php echo $payout->service_charge;?></td>
                         <td><?php echo bmw_price($payout->total_points,'PV');?></td>
                         <td><?php echo bmw_price($payout->total_amount);?></td>
                         <td><?php echo date('d-M-Y',strtotime($payout->insert_date));?></td>
                       </tr>
                       <?php 
                     }
                   }
                   ?>
                 </tbody>
               </table>
             </div>
           </div>
         </div>
       </div>
     </div>

   </div>

   <?php 
 }
endif;


if(!function_exists('bmw_pair_commission_display_function')):
  function bmw_pair_commission_display_function($user_id,$user_key,$payout_id=NULL)
  {
    $commissions=bmw_user_pair_commission_by_user_key($user_key,$payout_id);

    ?>
    <div class="let-col-md-12 let-col-sm-12 ">
      <div class="let-x_panel">
        <div class="let-x_title">
          <h2><?php _e('Pair Commissions','BMW');?> </h2>
          <ul class="let-nav let-navbar-right let-panel_toolbox">
            <li><a class="let-collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
            <li><a class="let-close-link"><i class="fa fa-close"></i></a>
            </li>
          </ul>
          <div class="let-clearfix"></div>
        </div>
        <div class="let-x_content">
          <div class="let-row">
            <div class="let-col-sm-12">
              <div class="let-card-box let-table-responsive">
                <table class="let-table let-table-sm lets-datatable let-table-bordered dt-responsive" cellspacing="0" width="100%">
                  <thead>
                    <tr class="let-text-center">
                      <th><small><?php _e('Payout id','BMW');?></small></th>
                      <th><small><?php _e('Childs','BMW');?></small></th>
                      <th><small><?php _e('Amount','BMW');?></small></th>
                      <th><small><?php _e('Date','BMW');?></small></th>

                    </tr>
                  </thead>
                  <tbody>
                    <?php  
                    $amount=0;
                    if(!empty($commissions)){
                      foreach ($commissions as $key => $commission) {
                        $amount+=$commission->amount;
                        ?>
                        <tr class="let-text-center ">
                         <td class="let-align-middle"><?php echo $commission->payout_id;?></td>
                         <td class="let-align-middle"><?php if(!empty($commission->childs))
                         {
                          echo '<ul class="let-list-group" style="list-style:none;">';
                          $childs=unserialize($commission->childs);
                          foreach ($childs as $key => $child) {
                           echo '<li class="let-list-item let-border let-m-1">'.bmw_get_username_by_userkey($child).'</li>';
                         }
                         echo '</ul>';
                       }?></td>
                       <td class="let-align-middle"><?php echo bmw_price($commission->amount);?></td>
                       <td class="let-align-middle"><?php echo date('d-M-Y',strtotime($commission->insert_date));?></td>
                     </tr>
                     <?php 
                   }
                 }
                 ?>
               </tbody>
               <tfoot>
                <tr class="let-text-center ">
                  <th colspan="2" ><?php _e('Total Commission','BMW');?></th>
                  <th ><?php  echo bmw_price($amount);?></th>
                  <th></th>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>

<?php 
}
endif;
if(!function_exists('bmw_ref_commission_display_function')):
  function bmw_ref_commission_display_function($user_id,$user_key,$payout_id=NULL)
  {
    $commissions=bmw_user_referral_commission_by_user_key($user_key,$payout_id);
    ?>
    <div class="let-col-md-12 let-col-sm-12 ">
      <div class="let-x_panel">
        <div class="let-x_title">
          <h2><?php _e('Referral Commissions','BMW');?> </h2>
          <ul class="let-nav let-navbar-right let-panel_toolbox">
            <li><a class="let-collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
            <li><a class="let-close-link"><i class="fa fa-close"></i></a>
            </li>
          </ul>
          <div class="let-clearfix"></div>
        </div>
        <div class="let-x_content">
          <div class="let-row">
            <div class="let-col-sm-12">
              <div class="let-card-box let-table-responsive">
                <table class="let-table let-table-sm lets-datatable let-table-bordered dt-responsive" cellspacing="0" width="100%">
                  <thead>
                    <tr class="let-text-center">
                      <th><small><?php _e('Payout id','BMW');?></small></th>
                      <th><small><?php _e('User Name','BMW');?></small></th>
                      <th><small><?php _e('Child Name','BMW');?></small></th>
                      <th><small><?php _e('Total Amount','BMW');?></small></th>
                      <th><small><?php _e('Direct Bonus Amount','BMW');?></small></th>
                      <th><small><?php _e('Date','BMW');?></small></th>

                    </tr>
                  </thead>
                  <tbody>
                    <?php  
                    $amount=0;
                    if(!empty($commissions)){
                      foreach ($commissions as $key => $commission) {
                        $amount+=$commission->direct_bonus_amount;
                        ?>
                        <tr class="let-text-center ">
                         <td class="let-align-middle"><?php echo $commission->payout_id;?></td>
                         <td class="let-align-middle"><?php echo bmw_get_username_by_userkey($commission->user_key);?></td>
                         <td class="let-align-middle"><?php foreach(unserialize($commission->childs) as $child){ echo bmw_get_username_by_userkey($child);echo '<br>'; } ?></td>
                         <td class="let-align-middle"><?php echo bmw_price($commission->total_amount);?></td>
                         <td class="let-align-middle"><?php echo bmw_price($commission->direct_bonus_amount);?></td>
                         <td class="let-align-middle"><?php echo ($commission->insert_date);?></td>
                       </tr>
                       <?php 
                     }
                   }
                   ?>
                 </tbody>
                 <tfoot>
                  <tr class="let-text-center ">
                    <th colspan="4" ><?php _e('Total Commission','BMW');?></th>
                    <th ><?php  echo bmw_price($amount);?></th>
                    <th></th>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>

  <?php 
}
endif;
if(!function_exists('bmw_level_commission_display_function')):
  function bmw_level_commission_display_function($user_id,$user_key,$payout_id=NULL)
  {
    $commissions=bmw_user_level_commission_by_user_key($user_key,$payout_id);
    ?>
    <div class="let-col-md-12 let-col-sm-12 ">
      <div class="let-x_panel">
        <div class="let-x_title">
          <h2><?php _e('Level Commissions','BMW');?> </h2>
          <ul class="let-nav let-navbar-right let-panel_toolbox">
            <li><a class="let-collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
            <li><a class="let-close-link"><i class="fa fa-close"></i></a>
            </li>
          </ul>
          <div class="let-clearfix"></div>
        </div>
        <div class="let-x_content">
          <div class="let-row">
            <div class="let-col-sm-12">
              <div class="let-card-box let-table-responsive">
                <table class="let-table let-table-sm lets-datatable let-table-bordered dt-responsive" cellspacing="0" width="100%">
                  <thead>
                    <tr class="let-text-center">
                      <th><small><?php _e('Payout id','BMW');?></small></th>
                      <th><small><?php _e('Child Name','BMW');?></small></th>
                      <th><small><?php _e('Level','BMW');?></small></th>
                      <th><small><?php _e('Amount','BMW');?></small></th>
                      <th><small><?php _e('Date','BMW');?></small></th>

                    </tr>
                  </thead>
                  <tbody>
                    <?php  
                    $amount=0;
                    if(!empty($commissions)){
                      foreach ($commissions as $key => $commission) {
                        $amount+=$commission->amount;
                        ?>
                        <tr class="let-text-center ">
                         <td class="let-align-middle"><?php echo $commission->payout_id;?></td>
                         <td class="let-align-middle"><?php echo bmw_get_username_by_userkey($commission->user_key);?></td>
                         <td class="let-align-middle"><?php echo $commission->level;?></td>
                         <td class="let-align-middle"><?php echo bmw_price($commission->amount);?></td>
                         <td class="let-align-middle"><?php echo date('d-M-Y',strtotime($commission->insert_date));?></td>
                       </tr>
                       <?php 
                     }
                   }
                   ?>
                 </tbody>
                 <tfoot>
                  <tr class="let-text-center ">
                    <th colspan="3" ><?php _e('Total Commission','BMW');?></th>
                    <th ><?php  echo bmw_price($amount);?></th>
                    <th></th>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>

  <?php 
}
endif;
if(!function_exists('bmw_bonus_details_display_function')):
  function bmw_bonus_details_display_function($user_id,$user_key,$payout_id=NULL)
  {
    $commissions=bmw_user_bonus_details_by_user_key($user_key);
    ?>
    <div class="let-col-md-12 let-col-sm-12 ">
      <div class="let-x_panel">
        <div class="let-x_title">
          <h2><?php _e('Bonus Details','BMW');?> </h2>
          <ul class="let-nav let-navbar-right let-panel_toolbox">
            <li><a class="let-collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
            <li><a class="let-close-link"><i class="fa fa-close"></i></a>
            </li>
          </ul>
          <div class="let-clearfix"></div>
        </div>
        <div class="let-x_content">
          <div class="let-row">
            <div class="let-col-sm-12">
              <div class="let-card-box let-table-responsive">
                <table class="let-table let-table-sm lets-datatable let-table-bordered dt-responsive" cellspacing="0" width="100%">
                  <thead>
                    <tr class="let-text-center">
                      <th><small><?php _e('Payout id','BMW');?></small></th>
                      <th><small><?php _e('Bonus Count','BMW');?></small></th>
                      <th><small><?php _e('Amount','BMW');?></small></th>
                      <th><small><?php _e('Date','BMW');?></small></th>

                    </tr>
                  </thead>
                  <tbody>
                    <?php  
                    $amount=0;
                    if(!empty($commissions)){
                      foreach ($commissions as $key => $commission) {
                        $amount+=$commission->amount;
                        ?>
                        <tr class="let-text-center ">
                         <td class="let-align-middle"><?php echo $commission->payout_id;?></td>
                         <td class="let-align-middle"><?php echo $commission->bonus_count;?></td>
                         <td class="let-align-middle"><?php echo bmw_price($commission->amount);?></td>
                         <td class="let-align-middle"><?php echo date('d-M-Y',strtotime($commission->insert_date));?></td>
                       </tr>
                       <?php 
                     }
                   }
                   ?>
                 </tbody>
                 <tfoot>
                  <tr class="let-text-center ">
                    <th colspan="2" ><?php _e('Total Commission','BMW');?></th>
                    <th ><?php  echo bmw_price($amount);?></th>
                    <th></th>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>

  <?php 
}
endif;

if(!function_exists('bmw_leadership_details_display_function')):
  function bmw_leadership_details_display_function($user_id,$user_key,$payout_id=NULL)
  {
    $commissions=bmw_user_leader_bonus_details_by_user_key($user_key);
    ?>
    <div class="let-col-md-12 let-col-sm-12 ">
      <div class="let-x_panel">
        <div class="let-x_title">
          <h2><?php _e('Leader Bonus Details','BMW');?> </h2>
          <ul class="let-nav let-navbar-right let-panel_toolbox">
            <li><a class="let-collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
            <li><a class="let-close-link"><i class="fa fa-close"></i></a>
            </li>
          </ul>
          <div class="let-clearfix"></div>
        </div>
        <div class="let-x_content">
          <div class="let-row">
            <div class="let-col-sm-12">
              <div class="let-card-box let-table-responsive">
                <table class="let-table let-table-sm lets-datatable let-table-bordered dt-responsive" cellspacing="0" width="100%">
                  <thead>
                    <tr class="let-text-center">
                      <th><small><?php _e('Payout id','BMW');?></small></th>
                      <th><small><?php _e('Leader Bonus Type','BMW');?></small></th>
                      <th><small><?php _e('Company Volume','BMW');?></small></th>
                      <th><small><?php _e('Amount','BMW');?></small></th>
                      <th><small><?php _e('Date','BMW');?></small></th>

                    </tr>
                  </thead>
                  <tbody>
                    <?php  
                    $amount=0;
                    if(!empty($commissions)){
                      foreach ($commissions as $key => $commission) {
                        $amount+=$commission->leadership_bonus;
                        ?>
                        <tr class="let-text-center ">
                         <td class="let-align-middle"><?php echo $commission->payout_id;?></td>
                         <td class="let-align-middle"><?php echo get_leadership_bonus_name_leader_id($commission->bonus_type);?></td>
                         <td class="let-align-middle"><?php echo bmw_price($commission->amount);?></td>
                         <td class="let-align-middle"><?php echo bmw_price($commission->leadership_bonus);?></td>
                         <td class="let-align-middle"><?php echo date('d-M-Y',strtotime($commission->insert_date));?></td>
                       </tr>
                       <?php 
                     }
                   }
                   ?>
                 </tbody>
                 <tfoot>
                  <tr class="let-text-center ">
                    <th colspan="2" ><?php _e('Total Commission','BMW');?></th>
                    <th ><?php  echo bmw_price($amount);?></th>
                    <th></th>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>

  <?php 
}
endif;

if(!function_exists('bmw_faststart_commission_display_function')):
  function bmw_faststart_commission_display_function($user_id,$user_key,$payout_id=NULL)
  {
    $commissions=bmw_user_faststart_bonus_details_by_user_key($user_key);
    ?>
    <div class="let-col-md-12 let-col-sm-12 ">
      <div class="let-x_panel">
        <div class="let-x_title">
          <h2><?php _e('FastStart Bonus Details','BMW');?> </h2>
          <ul class="let-nav let-navbar-right let-panel_toolbox">
            <li><a class="let-collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
            <li><a class="let-close-link"><i class="fa fa-close"></i></a>
            </li>
          </ul>
          <div class="let-clearfix"></div>
        </div>
        <div class="let-x_content">
          <div class="let-row">
            <div class="let-col-sm-12">
              <div class="let-card-box let-table-responsive">
                <table class="let-table let-table-sm lets-datatable let-table-bordered dt-responsive" cellspacing="0" width="100%">
                  <thead>
                    <tr class="let-text-center">
                      <th><small><?php _e('Payout id','BMW');?></small></th>
                      <th><small><?php _e('total Volume','BMW');?></small></th>
                      <th><small><?php _e('Amount','BMW');?></small></th>
                      <th><small><?php _e('Date','BMW');?></small></th>

                    </tr>
                  </thead>
                  <tbody>
                    <?php  
                    $amount=0;
                    if(!empty($commissions)){
                      foreach ($commissions as $key => $commission) {
                        $amount+=$commission->bonus_amount;
                        ?>
                        <tr class="let-text-center ">
                         <td class="let-align-middle"><?php echo $commission->payout_id;?></td>
                         <td class="let-align-middle"><?php echo bmw_price($commission->amount);?></td>
                         <td class="let-align-middle"><?php echo bmw_price($commission->bonus_amount);?></td>
                         <td class="let-align-middle"><?php echo date('d-M-Y',strtotime($commission->insert_date));?></td>
                       </tr>
                       <?php 
                     }
                   }
                   ?>
                 </tbody>
                 <tfoot>
                  <tr class="let-text-center ">
                    <th colspan="2" ><?php _e('Total Commission','BMW');?></th>
                    <th ><?php  echo bmw_price($amount);?></th>
                    <th></th>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>

  <?php 
}
endif;



if(!function_exists('bmw_withdrawal_display_function')):
  function bmw_withdrawal_display_function()
  {
    global $wpdb,$current_user;
    $user_key=bmw_get_current_user_key();
    $settings=get_option('bmw_manage_general');
    $requested=bmw_get_requested_balance_by_user_id($current_user->ID);
    $current=bmw_get_current_balance_by_user_id($current_user->ID);
    $pending=bmw_get_pending_balance_by_user_id($current_user->ID);
    $remaining_balance=$current-$pending;
    ?>
    <div class="let-col-md-12 let-col-sm-12 ">
      <div class="let-x_panel">
        <div class="let-x_title">
          <h2><?php _e('Withdrawal Amount','BMW');?> </h2>
          <ul class="let-nav let-navbar-right let-panel_toolbox">
            <li><a class="let-collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
            <li><a class="let-close-link"><i class="fa fa-close"></i></a>
            </li>
          </ul>
          <div class="let-clearfix"></div>
        </div>
        <div class="let-x_content">

          <div class="let-col-md-12 let-row let-col-sm-12  let-col-xs-12  let-m-0 let-p-0">
            <div class="let-col-md-6 let-col-xs-6 let-col-sm-12  let-col-xs-12  let-m-0 let-p-1">
              <div class="let-x_panel">
                <div class="let-x_title">
                  <h2><?php _e('Account Details','BMW');?> </h2>
                  <ul class="let-nav let-navbar-right let-panel_toolbox">
                    <li><a class="let-collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                    <li><a class="let-close-link"><i class="fa fa-close"></i></a>
                    </li>
                  </ul>
                  <div class="let-clearfix"></div>
                </div>
                <div class="let-x_content">
                  <table class="let-table let-table-bordered">
                    <tbody class="let-text-center">
                      <tr>
                        <th class="let-w-50"><?php _e('Current Balance','BMW');?></th>
                        <td class="let-w-50"><?php echo bmw_price($current);?></td>
                      </tr>
                      <tr>
                        <th class="let-w-50"><?php _e('Requested Balance','BMW');?></th>
                        <td class="let-w-50"><?php echo bmw_price($requested);?></td>
                      </tr>
                      <tr>
                        <th class="let-w-50"><?php _e('Pending Balance','BMW');?></th>
                        <td class="let-w-50"><?php echo bmw_price($pending);?></td>
                      </tr>
                    </tbody>
                  </table>

                </div>
              </div>
            </div>
            <div class="let-col-md-6 let-col-xs-6 let-col-sm-12  let-col-xs-12  let-m-0 let-p-1 ">
              <div class="let-x_panel">
               <div class="let-loader-layer">
                <div class="let-loader"></div>
              </div>
              <div class="let-x_title">
                <h2><?php _e('Withdraw Amount','BMW');?> </h2>
                <ul class="let-nav let-navbar-right let-panel_toolbox">
                  <li><a class="let-collapse-link"><i class="fa fa-chevron-up"></i></a>
                  </li>
                  <li><a class="let-close-link"><i class="fa fa-close"></i></a>
                  </li>
                </ul>
                <div class="let-clearfix"></div>
              </div>
              <div class="let-x_content ">

                <div class="let-col-md-12 let-col-xs-12 let-p-0">

                  <div class="let-col-md-6 let-col-xs-12">
                    <p> <?php _e('Withdrawal Limit','BMW');?></p>
                  </div>
                  <div class="let-col-md-6 let-col-xs-12">
                   <?php echo bmw_price($settings['bmw_withdrawal_limit_min']);?> ~ <?php echo bmw_price($settings['bmw_withdrawal_limit_max']);?>
                 </div>

               </div>
               <div class="let-col-md-12 let-col-xs-12 let-p-0">

                <div class="let-col-md-6 let-col-xs-12">
                 <p> <?php _e('Enter Amount','BMW');?></p>
               </div>
               <div class="let-col-md-6 let-col-xs-12">
                 <input name="bmw_withdrawal_amount" id="withdrwal_amount"  type="number" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" class="let-form-control let-rounded-0" placeholder="<?php esc_html_e('Enter Numeric Value','BMW');?>" min="<?php echo $settings['bmw_withdrawal_limit_min'];?>" max="<?php if($current>=$settings['bmw_withdrawal_limit_max'] ){echo $settings['bmw_withdrawal_limit_max'];}else{echo $current;}?>">
               </div>
               <div id="withdrwal_amount_message" class="let-small let-col-md-12   let-text-center"></div>

             </div>
             <div class="let-clearfix"></div>

             <div class="let-separator let-text-center">
              <div class="let-col-md-12 let-col-xs-12 let-p-0  let-text-center ">
                <button class="let-btn let-btn-info let-rounded-0" onclick="bmw_withdrwal_request()" type="button"><?php _e('Request Now','BMW');?></button>

              </div>
            </div>

          </div>
        </div>
      </div>
    </div>

  </div>
</div>
</div>

<?php 
}
endif;


if(!function_exists('bmw_withdrawal_reports_display_function')):
  function bmw_withdrawal_reports_display_function($user_id)
  {
    global $wpdb;
    $withdrawals=bmw_get_withdrawal_data_by_user_id($user_id);
    ?>
    <div class="let-col-md-12 let-col-sm-12 ">
      <div class="let-x_panel">
        <div class="let-x_title">
          <h2><?php _e('Withdrawal List','BMW');?> </h2>
          <ul class="let-nav let-navbar-right let-panel_toolbox">
            <li><a class="let-collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
            <li><a class="let-close-link"><i class="fa fa-close"></i></a>
            </li>
          </ul>
          <div class="let-clearfix"></div>
        </div>
        <div class="let-x_content">
          <div class="let-row">
            <div class="let-col-sm-12">
              <div class="let-card-box let-table-responsive">
                <table class="let-table let-table-sm lets-datatable let-table-bordered dt-responsive" cellspacing="0" width="100%">
                  <thead>
                    <tr class="let-text-center">
                      <th><small><?php _e('#Id','BMW');?></small></th>
                      <th><small><?php _e('Transaction Id','BMW');?></small></th>
                      <th><small><?php _e('Amount','BMW');?></small></th>
                      <th><small><?php _e('Status','BMW');?></small></th>
                      <th><small><?php _e('Mode','BMW');?></small></th>
                      <th><small><?php _e('Init Date','BMW');?></small></th>
                      <th><small><?php _e('Process Date','BMW');?></small></th>

                    </tr>
                  </thead>
                  <tbody>
                    <?php  
                    $amount=0;
                    if(!empty($withdrawals)){
                      foreach ($withdrawals as $key => $withdrawal) {
                        $amount+=$withdrawal->amount;
                        ?>
                        <tr class="let-text-center ">
                         <td class="let-align-middle"><?php echo $key+1;?></td>
                         <td class="let-align-middle"><?php echo $withdrawal->transaction_id;?></td>
                         <td class="let-align-middle"><?php echo bmw_price($withdrawal->amount);?></td>
                         <td class="let-align-middle"><?php echo ($withdrawal->payment_processed==0)?'<span class="let-badge let-btn-sm let-p-1 let-btn-warning let-rounded-0">'.__('Initiated','BMW').'</span>':'<span class="let-badge let-btn-sm  let-p-1 let-btn-success let-rounded-0">'.__('Processed','BMW').'</span>';?></td>
                         <td class="let-align-middle"><?php echo ucwords(str_replace('_', ' ', $withdrawal->withdrawal_mode));?></td>
                         <td class="let-align-middle"><?php echo date('d-M-Y',strtotime($withdrawal->withdrawal_initiated_date));?></td>
                         <td class="let-align-middle"><?php echo ($withdrawal->payment_processed_date!='0000-00-00')?date('d-M-Y',strtotime($withdrawal->payment_processed_date)):'---';?></td>
                       </tr>
                       <?php 
                     }
                   }
                   ?>
                 </tbody>
                 <tfoot>
                  <tr class="let-text-center ">
                    <th colspan="2" ><?php _e('Total','BMW');?></th>
                    <th ><?php  echo bmw_price($amount);?></th>
                    <th colspan="4"></th>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php 
}
endif;


if(!function_exists('bmw_send_invitation_display_function')):
  function bmw_send_invitation_display_function()
  {
    global $wpdb,$current_user;
    $user_key=bmw_get_current_user_key();
    ?>
    <div class="let-col-md-12 let-col-sm-12 ">
      <div class="let-x_panel">
        <div class="let-x_title">
          <h2><?php _e('Invite By e-Mail','BMW');?> </h2>
          <ul class="let-nav let-navbar-right let-panel_toolbox">
            <li><a class="let-collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
            <li><a class="let-close-link"><i class="fa fa-close"></i></a>
            </li>
          </ul>
          <div class="let-clearfix"></div>
        </div>
        <div class="let-x_content">
          <div class="let-col-md-12 let-col-xs-12 let-row">
            <div class="let-col-md-6 let-col-xs-12">
              <p class="let-text-center"><?php _e('You can invite any one just need to place the email and trigger invite button. Make sure email address is correct.','BMW');?></p>
            </div>
            <div class="let-col-md-6 let-col-xs-12">
              <form id="bmw_invitation_form">
               <input  id="bmw_email" name="bmw_invite_email" type="text" class="let-form-control let-rounded-0" placeholder="<?php esc_html_e('Please Enter e-Mail *','BMW');?>" value="">
               <div  class=" let-small bmw_email_message let-col-md-12 let-m-2"></div>
               <div class="let-col-md-12 let-m-2 let-text-center">
                <button type="submit" class="let-btn let-btn-success let-btn-sm let-rounded-0" ><?php _e('Invite','BMW');?></button>
              </div>
            </form>
          </div>
        </div>

      </div>
    </div>
  </div>

  <?php 
}
endif;
if(!function_exists('bmw_display_member_data_function')):
  function bmw_display_member_data_function($user_id,$user_key)
  {
    global $wpdb;
    $user=get_user_by('ID',$user_id);
    ?>
    <div class="let-col-md-12 let-col-sm-12 ">
      <div class="let-x_panel">
        <div class="let-x_title">
          <h2><?php _e('Your Profile','BMW');?> </h2>
          <ul class="let-nav let-navbar-right let-panel_toolbox">
            <li><a class="let-collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
            <li><a class="let-close-link"><i class="fa fa-close"></i></a>
            </li>
          </ul>
          <div class="let-clearfix"></div>
        </div>
        <div class="let-x_content">

          <div class="let-flex let-text-center">
            <img src="<?php echo bmw_get_profile_picture($user_id);?>" class="let-img-circle profile_img" width="220px" height="220px" style="height:220px;width:220px;margin: auto;">
          </div>

          <h3 class="let-name let-text-center"><?php echo $user->first_name.'&nbsp;'.$user->last_name;?></h3>

          <div class="let-row let-border ">
            <div class="let-col-md-4 let-col-xs-12 let-text-center let-p-2">
              <h3><?php echo bmw_price(bmw_get_current_balance_by_user_id($user_id));?></h3>
              <span><?php _e('Current Balance','BMW');?></span>
            </div>
            <div class="let-col-md-4 let-col-xs-12 let-text-center let-p-2">
              <h3><?php echo  bmw_get_downlines_count($user_key);?></h3>
              <span><?php _e('Downlines','BMW');?></span>
            </div>
            <div class="let-col-md-4 let-col-xs-12 let-text-center let-p-2">
              <h3><?php echo  bmw_get_referrals_count($user_key);?></h3>
              <span><?php _e('Referrals','BMW');?></span>
            </div>
          </div>

        </div>
      </div>
    </div>

    <?php 
  }
endif;

if(!function_exists('bmw_user_withdrawal_request_display_function')):
  function bmw_user_withdrawal_request_display_function($user_id,$id)
  {
    $withdrawal=bmw_get_withdrawal_detail_by_wid($user_id,$id);
    ?>
    <div class="let-col-md-12 let-col-sm-12 ">
      <div class="let-x_panel">
        <div class="let-x_title">
          <h2><?php _e('Withdrawal Details','BMW');?> </h2>
          <ul class="let-nav let-navbar-right let-panel_toolbox">
            <li><a class="let-collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
            <li><a class="let-close-link"><i class="fa fa-close"></i></a>
            </li>
          </ul>
          <div class="let-clearfix"></div>
        </div>
        <div class="let-x_content">
          <div class="let-row">
            <div class="let-col-sm-12">
              <div class="let-card-box let-table-responsive">
                <table class="let-table let-table-sm lets-datatable let-table-bordered dt-responsive" cellspacing="0" width="100%">
                  <thead>
                    <tr class="let-text-center">
                     <th><?php _e('User Name','BMW');?></th>
                     <th><?php _e('Amount','BMW');?></th>
                     <th><?php _e('Withdrawal fee','BMW');?></th>
                     <th><?php _e('Status','BMW');?></th>
                     <th><?php _e('Request Date','BMW');?></th>

                   </tr>
                 </thead>
                 <tbody> 
                   <?php if(isset($withdrawal) && !empty($withdrawal)){
                    ?>
                    <tr  class="let-text-center ">
                      <td><?php echo bmw_get_username_by_user_id($withdrawal->user_id);?></td>
                      <td><?php echo bmw_price($withdrawal->amount);?></td>
                      <td><?php echo bmw_price($withdrawal->withdrawal_fee);?></td>
                      <td><?php echo ($withdrawal->payment_processed==0)?'<span class="let-badge let-btn-sm let-p-2 let-btn-warning  let-rounded-0">'.__('Initiated','BMW').'</span>':'<span class="let-badge let-btn-sm  let-p-2 let-btn-success let-rounded-0">'.__('Processed','BMW').'</span>'?></td>
                      <td><?php echo date('d-M-Y',strtotime($withdrawal->withdrawal_initiated_date));?></td>
                    </tr>
                    <?php 

                  }

                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>

  <?php 
}
endif;


if(!function_exists('bmw_withdrawal_pay_form_function')):
  function bmw_withdrawal_pay_form_function($user_id,$id)
  {
    $withdrawal=bmw_get_withdrawal_detail_by_wid($user_id,$id);
    $user_key=bmw_get_user_key_by_user_id($user_id);
    $bank_details=bmw_get_bank_info($user_key);
    $error=array();
    if(isset($_REQUEST['payment']) && !empty($_REQUEST['payment']))
    {
      $payment=$_REQUEST['payment'];
      if(empty($payment['bmw_withdrawal_pay_amount']) && $payment['bmw_withdrawal_pay_amount']!=$withdrawal->amount)
      {
        $error['amount']=__('Request amount is incorrect please check!!');
      }
      if(empty($payment['bmw_withdrawal_payment_mode']))
      {
        $error['mode']=__('Please choose payment Mode!!');  
      }
      if(empty($payment['bmw_withdrawal_transaction_id']))
      {
        $error['transaction']=__("Transaction Id can't be Blank!!");  
      }
      if(empty($error))
      {
        $status=bmw_update_withdrawal_request((object)$payment,$bank_details,$user_id,$id);
      }
    }
    ?>
    <div class="let-col-md-12 let-col-sm-12 ">
      <div class="let-x_panel">
        <div class="let-x_content">

          <div class="let-col-md-12 let-row let-col-sm-12  let-col-xs-12  let-m-0 let-p-0">
            <div class="let-col-md-6 let-col-xs-6 let-col-sm-12  let-col-xs-12  let-m-0 let-p-1">
              <div class="let-x_panel">
                <div class="let-x_title">
                  <h2><?php _e('Bank Details','BMW');?> </h2>
                  <ul class="let-nav let-navbar-right let-panel_toolbox">
                    <li><a class="let-collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                    <li><a class="let-close-link"><i class="fa fa-close"></i></a>
                    </li>
                  </ul>
                  <div class="let-clearfix"></div>
                </div>
                <div class="let-x_content">
                  <table class="let-table let-table-bordered">
                    <tbody class="let-text-center">
                      <tr>
                        <th class="let-w-50"><?php _e('A/c Holder','BMW');?></th>
                        <td class="let-w-50"><?php echo $bank_details->account_holder;?></td>
                      </tr>
                      <tr>
                        <th class="let-w-50"><?php _e('A/c Number','BMW');?></th>
                        <td class="let-w-50"><?php echo $bank_details->account_number;?></td>
                      </tr>
                      <tr>
                        <th class="let-w-50"><?php _e('Bank Name','BMW');?></th>
                        <td class="let-w-50"><?php echo $bank_details->bank_name;?></td>
                      </tr>
                      <tr>
                        <th class="let-w-50"><?php _e('Branch','BMW');?></th>
                        <td class="let-w-50"><?php echo $bank_details->branch;?></td>
                      </tr>
                      <tr>
                        <th class="let-w-50"><?php _e('IFSC Code','BMW');?></th>
                        <td class="let-w-50"><?php echo $bank_details->ifsc_code;?></td>
                      </tr>
                      <tr>
                        <th class="let-w-50"><?php _e('Mob. Number','BMW');?></th>
                        <td class="let-w-50"><?php echo $bank_details->contact_number;?></td>
                      </tr>

                    </tbody>
                  </table>

                </div>
              </div>
            </div>
            <div class="let-col-md-6 let-col-xs-6 let-col-sm-12  let-col-xs-12  let-m-0 let-p-1 ">
              <div class="let-x_panel">
               <div class="let-loader-layer">
                <div class="let-loader"></div>
              </div>
              <div class="let-x_title">
                <h2><?php _e('Withdraw Amount','BMW');?> </h2>
                <ul class="let-nav let-navbar-right let-panel_toolbox">
                  <li><a class="let-collapse-link"><i class="fa fa-chevron-up"></i></a>
                  </li>
                  <li><a class="let-close-link"><i class="fa fa-close"></i></a>
                  </li>
                </ul>
                <div class="let-clearfix"></div>
              </div>
              <div class="let-x_content ">
                <form method="POST" action="" id="bmw_payment_form">
                  <table class="let-table let-table-bordered">
                    <tbody>
                      <tr>
                        <th class="let-align-middle let-text-center">
                          <?php _e('Request Amount','BMW');?>
                        </th>
                        <td>
                          <input type="number" value="<?php echo $withdrawal->amount;?>" name="payment[bmw_withdrawal_pay_amount]" class="let-form-control let-rounded-0">
                          <?php if(!empty($error) && !empty($error['amount'])){
                            echo "<span class='let-text-danger let-small'>".$error['amount']."</span>";
                          } ?>
                        </td>
                      </tr>
                      <tr>
                        <th class="let-align-middle let-text-center">
                          <?php _e('Payment Mode','BMW');?>
                        </th>
                        <td>
                          <select class="let-form-control let-rounded-0" name="payment[bmw_withdrawal_payment_mode]">
                            <option value=""><?php _e('Choose Mode','BMW');?></option>
                            <option value="paypal" <?php echo (!empty($withdrawal->payment_mode) && $withdrawal->payment_mode=='paypal')?'selected':'';?>><?php _e('Paypal','BMW');?></option>
                            <option value="bank_transfer" <?php echo (!empty($withdrawal->payment_mode) && $withdrawal->payment_mode=='bank_transfer')?'selected':'';?>><?php _e('Bank Transfer','BMW');?></option>
                          </select>
                          <?php if(!empty($error) && !empty($error['mode'])){
                            echo "<span class='let-text-danger let-small'>".$error['mode']."</span>";
                          } ?>
                        </td>
                      </tr>
                      <tr>
                        <th class="let-align-middle let-text-center">
                          <?php _e('Transaction id','BMW');?>
                        </th>
                        <td>
                          <input type="text" name="payment[bmw_withdrawal_transaction_id]" placeholder="<?php _e('Enter Transaction Id','BMW');?>" class="let-form-control let-rounded-0" value="<?php echo (!empty($withdrawal->transaction_id))?$withdrawal->transaction_id:'';?>">
                          <?php if(!empty($error) && !empty($error['transaction'])){
                            echo "<span class='let-text-danger let-small'>".$error['transaction']."</span>";
                          } ?>
                        </td>
                      </tr>
                      <tr class="let-alert-success">
                        <td colspan="2" >
                          <div class="let-text-center">
                            <?php echo sprintf(__('Here you can only update the transaction Details %s(You need to do transaction manually).','BMW'),'<br/>');?>
                          </div>
                        </td>
                      </tr>

                    </tbody>
                    <tfoot>
                      <?php if(!empty($withdrawal->transaction_id) && $withdrawal->payment_processed=='1'){ ?>
                        <tr>
                          <td colspan="2" class="let-text-center">
                            <span class="let-alert let-alert-success let-rounded-0"> <?php _e('Payment already Updated!!','BMW')?></span>
                          </td>
                        </tr>
                      <?php } else {?>
                        <tr>
                          <td colspan="2" class="let-text-center">
                            <button type="submit" class="let-btn let-btn-success let-rounded-0 "><?php _e('Submit','BMW');?></button>
                            <br/>
                            <?php echo @$status;?>
                          </td>
                        </tr>
                      <?php  }  ?> 
                    </tfoot>
                  </table>
                </form>
                
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>

  <?php 
}
endif;

function bmw_mail_configurations_function()
{

  $mail_name='registration_mail';
  if(isset($_REQUEST['bmw_mail_name']) && !empty($_REQUEST['bmw_mail_name']))
  {
   $mail_name=$_REQUEST['bmw_mail_name'];

 }
 $mail_settings=bmw_get_mail_settings_by_name($mail_name);
 ?>

 <div class="let-col-md-12 let-col-sm-12 ">
  <div class="let-x_panel">
   <div class="let-loader-layer">
    <div class="let-loader"></div>
  </div>
  <div class="let-x_title">
    <h2><?php _e('Mail Settings','BMW');?> </h2>
    <ul class="let-nav let-navbar-right let-panel_toolbox">
      <li>
        <form id="ChangeMailForm" method="POST" action="">
          <select class="let-form-control let-rounded-0" name="bmw_mail_name" onchange="ChangeMailForm();">
            <option><?php _e('Choose Configuration','BMW');?></option>
            <option value="registration_mail" <?php echo ($mail_name=='registration_mail')?'selected':'';?>><?php _e('Registration Mail','BMW');?></option>
            <option value="withdrawal_request" <?php echo  ($mail_name=='withdrawal_request')?'selected':'';?>><?php _e('Withdrawal Request Mail','BMW');?></option>
            <option value="withdrawal_pay" <?php echo ($mail_name=='withdrawal_pay')?'selected':'';?>><?php _e('Withdrawal Pay Mail','BMW');?></option>
            <option value="payout_mail" <?php echo  ($mail_name=='payout_mail')?'selected':'';?>><?php _e('Payout Mail','BMW');?></option>
          </select>
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

    <div class="let-col-md-12 let-row let-col-sm-12  let-col-xs-12  let-m-0 let-p-0">
      <div class="let-col-md-8 let-col-xs-8 let-col-sm-12  let-col-xs-12  let-m-0 let-p-1">
        <div class="let-x_panel">
          <div class="let-x_title">
            <h2><?php _e(($mail_name)?ucwords(str_replace('_', ' ', $mail_name)):'Registration Mail','BMW');?> </h2>
            <ul class="let-nav let-navbar-right let-panel_toolbox">
              <li><a class="let-collapse-link"><i class="fa fa-chevron-up"></i></a>
              </li>
              <li><a class="let-close-link"><i class="fa fa-close"></i></a>
              </li>
            </ul>
            <div class="let-clearfix"></div>
          </div>
          <div class="let-x_content">
            <form id="submit_mail_setting" method="POST" action="">
              <div class="let-form-group let-p-3">
               <input type="hidden" name="bmw_mail_name" value="<?php echo $mail_name;?>">
               <input type="hidden" name="action" value="bmw_mail_settings_post">
               <div class="let-col-md-2">
                <label for="bmw_mail_user" ><?php _e('Mail to','BMW');?></label>
              </div>
              <div class="let-col-md-10">
               <select class="let-form-control let-rounded-0" name="bmw_mail_to" id="bmw_mail_user">
                <option value=""><?php _e('Select Receiver','BMW');?></option>
                <option value="admin" <?php echo (isset($mail_settings) && $mail_settings->mail_to=='admin')?'selected':'';?>><?php _e('Admin','BMW');?></option>
                <option value="user" <?php echo (isset($mail_settings) && $mail_settings->mail_to=='user')?'selected':'';?>><?php _e('User','BMW');?></option>
                <option value="both" <?php echo (isset($mail_settings) && $mail_settings->mail_to=='both')?'selected':'';?>><?php _e('Both(Admin & User)','BMW');?></option>
              </select>
              <div class="let-text-danger let-small" id="bmw_mail_to"></div>
            </div>
          </div>
          <div class="let-form-group let-p-3">
            <div class="let-col-md-2">
              <label for="bmw_mail_to" ><?php _e('Subject','BMW');?></label>
            </div>
            <div class="let-col-md-10">
             <input type="text" name="bmw_mail_subject" class="let-form-control let-rounded-0" value="<?php echo (isset($mail_settings))?$mail_settings->mail_subject:'';?>">
             <div class="let-text-danger let-small" id="bmw_mail_subject"></div>
           </div>
         </div>
         <div class="let-form-group  let-p-3">
          <div class="let-col-md-2">
            <label for="bmw_mail_to" ><?php _e('Message','BMW');?></label>
          </div>
          <div class="let-col-md-10">
            <textarea name="bmw_mail_message" class="let-form-control let-rounded-0" rows="8" cols="8" id="bmw_text_editor"><?php echo (isset($mail_settings))?$mail_settings->mail_message:'';?></textarea> 
            <div class="let-text-danger let-small" id="bmw_mail_message"></div>
          </div>
        </div>
        <div class="let-form-group  let-p-3">
          <div class="let-col-md-12 let-text-center let-p-2">
            <button type="submit" class="let-btn let-btn-success let-rounded-0"><?php _e('Submit','BMW');?></button>           
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<div class="let-col-md-4 let-col-xs-12 let-col-sm-4   let-m-0 let-p-1 ">
  <div class="let-x_panel">
   <div class="let-loader-layer">
    <div class="let-loader"></div>
  </div>
  <div class="let-x_title">
    <h2><?php _e('Click and use in Message','BMW');?> </h2>
    <ul class="let-nav let-navbar-right let-panel_toolbox">
      <li><a class="let-collapse-link"><i class="fa fa-chevron-up"></i></a>
      </li>
      <li><a class="let-close-link"><i class="fa fa-close"></i></a>
      </li>
    </ul>
    <div class="let-clearfix"></div>
  </div>
  <div class="let-x_content ">
   <table class="let-table let-table-bordered let-border let-table-sm">
    <tbody class="let-text-center">
      <tr>

        <td><a href="javascript:void(0)" class="let-btn let-btn-info let-btn-sm bmw_help_words let-m-0 let-rounded-0 let-pt-0 let-pb-0 let-w-100" data-keyword="[site_name]"><?php _e('Site Name','BMW');?></a></td>
        <td><a href="javascript:void(0)" class="let-btn let-btn-info let-btn-sm bmw_help_words let-m-0 let-rounded-0 let-pt-0 let-pb-0 let-w-100" data-keyword="[site_url]"><?php _e('Site URL','BMW');?></a></td>
        <td><a href="javascript:void(0)" class="let-btn let-btn-info let-btn-sm bmw_help_words let-m-0 let-rounded-0 let-pt-0 let-pb-0 let-w-100" data-keyword="[site_language]"><?php _e('Site Lang','BMW');?></a></td>
      </tr>
      <tr>
        <td><a href="javascript:void(0)" class="let-btn let-btn-info let-btn-sm bmw_help_words let-m-0 let-rounded-0 let-pt-0 let-pb-0 let-w-100" data-keyword="[admin_email]"><?php _e('Admin Email','BMW');?></a></td>
        <td><a href="javascript:void(0)" class="let-btn let-btn-info let-btn-sm bmw_help_words let-m-0 let-rounded-0 let-pt-0 let-pb-0 let-w-100" data-keyword="[admin_name]"><?php _e('Admin Name','BMW');?></a></td>
        <td><a href="javascript:void(0)" class="let-btn let-btn-info let-btn-sm bmw_help_words let-m-0 let-rounded-0 let-pt-0 let-pb-0 let-w-100" data-keyword="[date]"><?php _e('Date','BMW');?></a></td>
      </tr>
      <tr>
        <td colspan="3" class="let-p-0 let-m-0 let-text-secondary let-small" >
          <?php _e('User Data','BMW');?>
        </td>
      </tr>
      <tr>
        <td><a href="javascript:void(0)" class="let-btn let-btn-warning let-btn-sm bmw_help_words let-m-0 let-rounded-0 let-pt-0 let-pb-0 let-w-100" data-keyword="[user_name]"><?php _e('Name','BMW');?></a></td>
        <td><a href="javascript:void(0)" class="let-btn let-btn-warning let-btn-sm bmw_help_words let-m-0 let-rounded-0 let-pt-0 let-pb-0 let-w-100" data-keyword="[user_key]"><?php _e('key','BMW');?></a></td>
        <td><a href="javascript:void(0)" class="let-btn let-btn-warning let-btn-sm bmw_help_words let-m-0 let-rounded-0 let-pt-0 let-pb-0 let-w-100" data-keyword="[user_email]"><?php _e('Email','BMW');?></a></td>
      </tr>
      <tr>
        <td><a href="javascript:void(0)" class="let-btn let-btn-warning let-btn-sm bmw_help_words let-m-0 let-rounded-0 let-pt-0 let-pb-0 let-w-100" data-keyword="[user_id]"><?php _e('User id','BMW');?></a></td>
        <td><a href="javascript:void(0)" class="let-btn let-btn-warning let-btn-sm bmw_help_words let-m-0 let-rounded-0 let-pt-0 let-pb-0 let-w-100" data-keyword="[user_level]"><?php _e('Level','BMW');?></a></td>
        <td><a href="javascript:void(0)" class="let-btn let-btn-warning let-btn-sm bmw_help_words let-m-0 let-rounded-0 let-pt-0 let-pb-0 let-w-100" data-keyword="[user_creation_date]"><?php _e('Join Date','BMW');?></a></td>
      </tr>
      <tr>
        <td colspan="3" class="let-p-0 let-m-0 let-text-secondary let-small" >
          <?php _e('Sponsor Data','BMW');?>
        </td>
      </tr>
      <tr>
        <td><a href="javascript:void(0)" class="let-btn let-btn-warning let-btn-sm bmw_help_words let-m-0 let-rounded-0 let-pt-0 let-pb-0 let-w-100" data-keyword="[sponsor_name]"><?php _e('Name','BMW');?></a></td>
        <td ><a href="javascript:void(0)" class="let-btn let-btn-warning let-btn-sm bmw_help_words let-m-0 let-rounded-0 let-pt-0 let-pb-0 let-w-100" data-keyword="[sponsor_key]"><?php _e('Key','BMW');?></a></td>
        <td ><a href="javascript:void(0)" class="let-btn let-btn-warning let-btn-sm bmw_help_words let-m-0 let-rounded-0 let-pt-0 let-pb-0 let-w-100" data-keyword="[sponsor_mail]"><?php _e('E-Mail','BMW');?></a></td>

      </tr>
      <tr>
        <td colspan="3" class="let-p-0 let-m-0 let-text-secondary let-small" >
          <?php _e('Parent Data','BMW');?>
        </td>
      </tr>
      <tr>
        <td><a href="javascript:void(0)" class="let-btn let-btn-warning let-btn-sm bmw_help_words let-m-0 let-rounded-0 let-pt-0 let-pb-0 let-w-100" data-keyword="[parent_name]"><?php _e('Name','BMW');?></a></td>
        <td ><a href="javascript:void(0)" class="let-btn let-btn-warning let-btn-sm bmw_help_words let-m-0 let-rounded-0 let-pt-0 let-pb-0 let-w-100" data-keyword="[parent_key]"><?php _e('Key','BMW');?></a></td>
        <td ><a href="javascript:void(0)" class="let-btn let-btn-warning let-btn-sm bmw_help_words let-m-0 let-rounded-0 let-pt-0 let-pb-0 let-w-100" data-keyword="[parent_mail]"><?php _e('E-Mail','BMW');?></a></td>

      </tr>
      <tr>
        <td colspan="3" class="let-p-0 let-m-0 let-text-secondary let-small" >
          <?php _e('User Total Amounts','BMW');?>
        </td>
      </tr>
      <tr>
        <td><a href="javascript:void(0)" class="let-btn let-btn-primary let-btn-sm bmw_help_words let-m-0 let-rounded-0 let-pt-0 let-pb-0 let-w-100 <?php echo ($mail_name!='registration_mail')?'':'let-disabled let-not-allowed';?>" data-keyword="[withdrawal_balance]"><?php _e('Withdrawal','BMW');?></a></td>
        <td><a href="javascript:void(0)" class="let-btn let-btn-primary let-btn-sm bmw_help_words let-m-0 let-rounded-0 let-pt-0 let-pb-0 let-w-100 <?php echo ($mail_name!='registration_mail')?'':'let-disabled let-not-allowed';?>" data-keyword="[referral_balance]"><?php _e('Referral','BMW');?></a></td>
        <td><a href="javascript:void(0)" class="let-btn let-btn-primary let-btn-sm bmw_help_words let-m-0 let-rounded-0 let-pt-0 let-pb-0 let-w-100 <?php echo ($mail_name!='registration_mail')?'':'let-disabled let-not-allowed';?>" data-keyword="[join_balance]"><?php _e('Join','BMW');?></a></td>
      </tr>
      <tr>
        <td><a href="javascript:void(0)" class="let-btn let-btn-primary let-btn-sm bmw_help_words let-m-0 let-rounded-0 let-pt-0 let-pb-0 let-w-100 <?php echo ($mail_name!='registration_mail')?'':'let-disabled let-not-allowed';?>" data-keyword="[current_balance]"><?php _e('Current','BMW');?></a></td>
        <td ><a href="javascript:void(0)" class="let-btn let-btn-primary let-btn-sm bmw_help_words let-m-0 let-rounded-0 let-pt-0 let-pb-0 let-w-100 <?php echo ($mail_name!='registration_mail')?'':'let-disabled let-not-allowed';?>" data-keyword="[total_bonus_amount]"><?php _e('Bonus','BMW');?></a></td>
        <td ><a href="javascript:void(0)" class="let-btn let-btn-primary let-btn-sm bmw_help_words let-m-0 let-rounded-0 let-pt-0 let-pb-0 let-w-100 <?php echo ($mail_name!='registration_mail')?'':'let-disabled let-not-allowed';?>" data-keyword="[total_level_amount]"><?php _e('Level','BMW');?></a></td>
      </tr>
      <tr>
        <td>
          <a href="javascript:void(0)" class="let-btn let-btn-primary let-btn-sm bmw_help_words let-m-0 let-rounded-0 let-pt-0 let-pb-0 let-w-100 <?php echo ($mail_name!='registration_mail')?'':'let-disabled let-not-allowed';?>" data-keyword="[total_shopping]"><?php _e('Shopping','BMW');?></a>
        </td>
        <td ><a href="javascript:void(0)" class="let-btn let-btn-primary let-btn-sm bmw_help_words let-m-0 let-rounded-0 let-pt-0 let-pb-0 let-w-100 <?php echo ($mail_name!='registration_mail')?'':'let-disabled let-not-allowed';?>" data-keyword="[total_orders]"><?php _e('Orders','BMW');?></a></td>
        <td ><a href="javascript:void(0)" class="let-btn let-btn-primary let-btn-sm bmw_help_words let-m-0 let-rounded-0 let-pt-0 let-pb-0 let-w-100 <?php echo ($mail_name!='registration_mail')?'':'let-disabled let-not-allowed';?>" data-keyword="[total_downliners]"><?php _e('Downliners','BMW');?></a></td>
      </tr>
      <tr>
        <td colspan="3" class="let-p-0 let-m-0 let-text-secondary let-small" >
          <?php _e('User Bank Details','BMW');?>
        </td>
      </tr>
      <tr>
        <td ><a href="javascript:void(0)" class="let-btn let-btn-success let-btn-sm bmw_help_words let-m-0 let-rounded-0 let-pt-0 let-pb-0 let-w-100 <?php echo ($mail_name!='registration_mail')?'':'let-disabled let-not-allowed';?>" data-keyword="[bank_name]"><?php _e('Bank Name','BMW');?></a></td>
        <td ><a href="javascript:void(0)" class="let-btn let-btn-success let-btn-sm bmw_help_words let-m-0 let-rounded-0 let-pt-0 let-pb-0 let-w-100 <?php echo ($mail_name!='registration_mail')?'':'let-disabled let-not-allowed';?>" data-keyword="[account_holder]"><?php _e('A/c Holder','BMW');?></a></td>
        <td ><a href="javascript:void(0)" class="let-btn let-btn-success let-btn-sm bmw_help_words let-m-0 let-rounded-0 let-pt-0 let-pb-0 let-w-100 <?php echo ($mail_name!='registration_mail')?'':'let-disabled let-not-allowed';?>" data-keyword="[account_number]"><?php _e('A/c Number','BMW');?></a></td>
      </tr>
      <tr>
        <td ><a href="javascript:void(0)" class="let-btn let-btn-success let-btn-sm bmw_help_words let-m-0 let-rounded-0 let-pt-0 let-pb-0 let-w-100 <?php echo ($mail_name!='registration_mail')?'':'let-disabled let-not-allowed';?>" data-keyword="[branch_name]"><?php _e('Branch','BMW');?></a></td>
        <td ><a href="javascript:void(0)" class="let-btn let-btn-success let-btn-sm bmw_help_words let-m-0 let-rounded-0 let-pt-0 let-pb-0 let-w-100 <?php echo ($mail_name!='registration_mail')?'':'let-disabled let-not-allowed';?>" data-keyword="[ifsc_code]"><?php _e('IFSC','BMW');?></a></td>
        <td ><a href="javascript:void(0)" class="let-btn let-btn-success let-btn-sm bmw_help_words let-m-0 let-rounded-0 let-pt-0 let-pb-0 let-w-100 <?php echo ($mail_name!='registration_mail')?'':'let-disabled let-not-allowed';?>" data-keyword="[contact_number]"><?php _e('Mobile','BMW');?></a></td>
      </tr>
      <tr>
        <td colspan="3" class="let-p-0 let-m-0 let-text-secondary let-small" >
          <?php _e('Payout Details','BMW');?>
        </td>
      </tr>
      <tr>
        <td ><a href="javascript:void(0)" class="let-btn let-btn-danger let-btn-sm bmw_help_words let-m-0 let-rounded-0 let-pt-0 let-pb-0 let-w-100 <?php echo ($mail_name=='payout_mail')?'':'let-disabled let-not-allowed';?>" data-keyword="[payout_id]"><?php _e('Payout id','BMW');?></a></td>
        <td ><a href="javascript:void(0)" class="let-btn let-btn-danger let-btn-sm bmw_help_words let-m-0 let-rounded-0 let-pt-0 let-pb-0 let-w-100 <?php echo ($mail_name=='payout_mail')?'':'let-disabled let-not-allowed';?>" data-keyword="[payout_total]"><?php _e('Payout Total','BMW');?></a></td>
        <td ><a href="javascript:void(0)" class="let-btn let-btn-danger let-btn-sm bmw_help_words let-m-0 let-rounded-0 let-pt-0 let-pb-0 let-w-100 <?php echo ($mail_name=='payout_mail')?'':'let-disabled let-not-allowed';?>" data-keyword="[payout_date]"><?php _e('Payout Date','BMW');?></a></td>
      </tr>
      <tr>
        <td colspan="3" class="let-p-0 let-m-0 let-text-secondary let-small" >
          <?php _e('Tables','BMW');?>
        </td>
      </tr>
        <tr>
          <td colspan=""><a href="javascript:void(0)" class="let-btn let-btn-danger let-btn-sm bmw_help_words let-m-0 let-rounded-0 let-pt-0 let-pb-0 let-w-100 <?php echo ($mail_name=='payout_mail')?'':'let-disabled let-not-allowed';?>" data-keyword="[payout_table]"><?php _e('Payout','BMW');?></a></td>
          <td colspan=""><a href="javascript:void(0)" class="let-btn let-btn-danger let-btn-sm bmw_help_words let-m-0 let-rounded-0 let-pt-0 let-pb-0 let-w-100 <?php echo ($mail_name=='withdrawal_request')?'':'let-disabled let-not-allowed';?>" data-keyword="[withdrawal_req_table]"><?php _e('W- Req.','BMW');?></a></td>
          <td colspan=""><a href="javascript:void(0)" class="let-btn let-btn-danger let-btn-sm bmw_help_words let-m-0 let-rounded-0 let-pt-0 let-pb-0 let-w-100 <?php echo ($mail_name=='withdrawal_pay')?'':'let-disabled let-not-allowed';?>" data-keyword="[withdrawal_pay_table]"><?php _e('W- Pay');?></a></td>
          
        </tr>
      </tbody>
    </table>

  </div>
</div>
</div>
</div>

</div>
</div>
</div>
<?php 

}
function bmw_sms_configurations_function()
{

  $sms_name='registration_sms';
  if(isset($_REQUEST['bmw_sms_name']) && !empty($_REQUEST['bmw_sms_name']))
  {
   $sms_name=$_REQUEST['bmw_sms_name'];

 }
 $sms_settings=bmw_get_mail_settings_by_name($sms_name);
 ?>

 <div class="let-col-md-12 let-col-sm-12 ">
  <div class="let-x_panel">
   <div class="let-loader-layer">
    <div class="let-loader"></div>
  </div>
  <div class="let-x_title">
    <h2><?php _e('SMS Settings','BMW');?> </h2>
    <ul class="let-nav let-navbar-right let-panel_toolbox">
      <li>
        <form id="ChangesmsForm" method="POST" action="">
          <select class="let-form-control let-rounded-0" name="bmw_sms_name" onchange="ChangesmsForm();">
            <option><?php _e('Choose Configuration','BMW');?></option>
            <option value="registration_sms" <?php echo ($sms_name=='registration_sms')?'selected':'';?>><?php _e('Registration sms','BMW');?></option>
            <option value="withdrawal_request_sms" <?php echo  ($sms_name=='withdrawal_request_sms')?'selected':'';?>><?php _e('Withdrawal Request sms','BMW');?></option>
            <option value="withdrawal_pay_sms" <?php echo ($sms_name=='withdrawal_pay_sms')?'selected':'';?>><?php _e('Withdrawal Pay sms','BMW');?></option>
            <option value="payout_sms" <?php echo  ($sms_name=='payout_sms')?'selected':'';?>><?php _e('Payout sms','BMW');?></option>
          </select>
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

    <div class="let-col-md-12 let-row let-col-sm-12  let-col-xs-12  let-m-0 let-p-0">
      <div class="let-col-md-8 let-col-xs-8 let-col-sm-12  let-col-xs-12  let-m-0 let-p-1">
        <div class="let-x_panel">
          <div class="let-x_title">
            <h2><?php _e(($sms_name)?ucwords(str_replace('_', ' ', $sms_name)):'Registration sms','BMW');?> </h2>
            <ul class="let-nav let-navbar-right let-panel_toolbox">
              <li><a class="let-collapse-link"><i class="fa fa-chevron-up"></i></a>
              </li>
              <li><a class="let-close-link"><i class="fa fa-close"></i></a>
              </li>
            </ul>
            <div class="let-clearfix"></div>
          </div>
          <div class="let-x_content">
            <form id="submit_sms_setting" method="POST" action="">
              <div class="let-form-group let-p-3">
               <input type="hidden" name="bmw_sms_name" value="<?php echo $sms_name;?>">
               <input type="hidden" name="action" value="bmw_sms_settings_post">
               <div class="let-col-md-2">
                <label for="bmw_sms_user" ><?php _e('sms to','BMW');?></label>
              </div>
              <div class="let-col-md-10">
               <select class="let-form-control let-rounded-0" name="bmw_sms_to" id="bmw_sms_user">
                <option value=""><?php _e('Select Receiver','BMW');?></option>
                <option value="user" <?php echo (isset($sms_settings) && $sms_settings->mail_to=='user')?'selected':'';?>><?php _e('User','BMW');?></option>
              </select>
              <div class="let-text-danger let-small" id="bmw_sms_to"></div>
            </div>
          </div>
         <div class="let-form-group  let-p-3">
          <div class="let-col-md-2">
            <label for="bmw_sms_to" ><?php _e('Message','BMW');?></label>
          </div>
          <div class="let-col-md-10">
            <textarea name="bmw_sms_message" class="let-form-control let-rounded-0" rows="8" cols="8" id="bmw_text_editor"><?php echo (isset($sms_settings))?$sms_settings->mail_message:'';?></textarea> 
            <div class="let-text-danger let-small" id="bmw_sms_message"></div>
          </div>
        </div>
        <div class="let-form-group  let-p-3">
          <div class="let-col-md-12 let-text-center let-p-2">
            <button type="submit" class="let-btn let-btn-success let-rounded-0"><?php _e('Submit','BMW');?></button>           
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<div class="let-col-md-4 let-col-xs-12 let-col-sm-4   let-m-0 let-p-1 ">
  <div class="let-x_panel">
   <div class="let-loader-layer">
    <div class="let-loader"></div>
  </div>
  <div class="let-x_title">
    <h2><?php _e('Click and use in Message','BMW');?> </h2>
    <ul class="let-nav let-navbar-right let-panel_toolbox">
      <li><a class="let-collapse-link"><i class="fa fa-chevron-up"></i></a>
      </li>
      <li><a class="let-close-link"><i class="fa fa-close"></i></a>
      </li>
    </ul>
    <div class="let-clearfix"></div>
  </div>
  <div class="let-x_content ">
   <table class="let-table let-table-bordered let-border let-table-sm">
    <tbody class="let-text-center">
      <tr>

        <td><a href="javascript:void(0)" class="let-btn let-btn-info let-btn-sm bmw_help_words let-m-0 let-rounded-0 let-pt-0 let-pb-0 let-w-100" data-keyword="[site_name]"><?php _e('Site Name','BMW');?></a></td>
        <td><a href="javascript:void(0)" class="let-btn let-btn-info let-btn-sm bmw_help_words let-m-0 let-rounded-0 let-pt-0 let-pb-0 let-w-100" data-keyword="[site_url]"><?php _e('Site URL','BMW');?></a></td>
        <td><a href="javascript:void(0)" class="let-btn let-btn-info let-btn-sm bmw_help_words let-m-0 let-rounded-0 let-pt-0 let-pb-0 let-w-100" data-keyword="[site_language]"><?php _e('Site Lang','BMW');?></a></td>
      </tr>
      <tr>
        <td><a href="javascript:void(0)" class="let-btn let-btn-info let-btn-sm bmw_help_words let-m-0 let-rounded-0 let-pt-0 let-pb-0 let-w-100" data-keyword="[admin_sms]"><?php _e('Admin sms','BMW');?></a></td>
        <td><a href="javascript:void(0)" class="let-btn let-btn-info let-btn-sm bmw_help_words let-m-0 let-rounded-0 let-pt-0 let-pb-0 let-w-100" data-keyword="[admin_name]"><?php _e('Admin Name','BMW');?></a></td>
        <td><a href="javascript:void(0)" class="let-btn let-btn-info let-btn-sm bmw_help_words let-m-0 let-rounded-0 let-pt-0 let-pb-0 let-w-100" data-keyword="[date]"><?php _e('Date','BMW');?></a></td>
      </tr>
      <tr>
        <td colspan="3" class="let-p-0 let-m-0 let-text-secondary let-small" >
          <?php _e('User Data','BMW');?>
        </td>
      </tr>
      <tr>
        <td><a href="javascript:void(0)" class="let-btn let-btn-warning let-btn-sm bmw_help_words let-m-0 let-rounded-0 let-pt-0 let-pb-0 let-w-100" data-keyword="[user_name]"><?php _e('Name','BMW');?></a></td>
        <td><a href="javascript:void(0)" class="let-btn let-btn-warning let-btn-sm bmw_help_words let-m-0 let-rounded-0 let-pt-0 let-pb-0 let-w-100" data-keyword="[user_key]"><?php _e('key','BMW');?></a></td>
        <td><a href="javascript:void(0)" class="let-btn let-btn-warning let-btn-sm bmw_help_words let-m-0 let-rounded-0 let-pt-0 let-pb-0 let-w-100" data-keyword="[user_sms]"><?php _e('sms','BMW');?></a></td>
      </tr>
      <tr>
        <td><a href="javascript:void(0)" class="let-btn let-btn-warning let-btn-sm bmw_help_words let-m-0 let-rounded-0 let-pt-0 let-pb-0 let-w-100" data-keyword="[user_id]"><?php _e('User id','BMW');?></a></td>
        <td><a href="javascript:void(0)" class="let-btn let-btn-warning let-btn-sm bmw_help_words let-m-0 let-rounded-0 let-pt-0 let-pb-0 let-w-100" data-keyword="[user_level]"><?php _e('Level','BMW');?></a></td>
        <td><a href="javascript:void(0)" class="let-btn let-btn-warning let-btn-sm bmw_help_words let-m-0 let-rounded-0 let-pt-0 let-pb-0 let-w-100" data-keyword="[user_creation_date]"><?php _e('Join Date','BMW');?></a></td>
      </tr>
      <tr>
        <td colspan="3" class="let-p-0 let-m-0 let-text-secondary let-small" >
          <?php _e('Sponsor Data','BMW');?>
        </td>
      </tr>
      <tr>
        <td><a href="javascript:void(0)" class="let-btn let-btn-warning let-btn-sm bmw_help_words let-m-0 let-rounded-0 let-pt-0 let-pb-0 let-w-100" data-keyword="[sponsor_name]"><?php _e('Name','BMW');?></a></td>
        <td ><a href="javascript:void(0)" class="let-btn let-btn-warning let-btn-sm bmw_help_words let-m-0 let-rounded-0 let-pt-0 let-pb-0 let-w-100" data-keyword="[sponsor_key]"><?php _e('Key','BMW');?></a></td>
        <td ><a href="javascript:void(0)" class="let-btn let-btn-warning let-btn-sm bmw_help_words let-m-0 let-rounded-0 let-pt-0 let-pb-0 let-w-100" data-keyword="[sponsor_sms]"><?php _e('E-sms','BMW');?></a></td>

      </tr>
      <tr>
        <td colspan="3" class="let-p-0 let-m-0 let-text-secondary let-small" >
          <?php _e('Parent Data','BMW');?>
        </td>
      </tr>
      <tr>
        <td><a href="javascript:void(0)" class="let-btn let-btn-warning let-btn-sm bmw_help_words let-m-0 let-rounded-0 let-pt-0 let-pb-0 let-w-100" data-keyword="[parent_name]"><?php _e('Name','BMW');?></a></td>
        <td ><a href="javascript:void(0)" class="let-btn let-btn-warning let-btn-sm bmw_help_words let-m-0 let-rounded-0 let-pt-0 let-pb-0 let-w-100" data-keyword="[parent_key]"><?php _e('Key','BMW');?></a></td>
        <td ><a href="javascript:void(0)" class="let-btn let-btn-warning let-btn-sm bmw_help_words let-m-0 let-rounded-0 let-pt-0 let-pb-0 let-w-100" data-keyword="[parent_sms]"><?php _e('E-sms','BMW');?></a></td>

      </tr>
      <tr>
        <td colspan="3" class="let-p-0 let-m-0 let-text-secondary let-small" >
          <?php _e('User Total Amounts','BMW');?>
        </td>
      </tr>
      <tr>
        <td><a href="javascript:void(0)" class="let-btn let-btn-primary let-btn-sm bmw_help_words let-m-0 let-rounded-0 let-pt-0 let-pb-0 let-w-100 <?php echo ($sms_name!='registration_sms')?'':'let-disabled let-not-allowed';?>" data-keyword="[withdrawal_balance]"><?php _e('Withdrawal','BMW');?></a></td>
        <td><a href="javascript:void(0)" class="let-btn let-btn-primary let-btn-sm bmw_help_words let-m-0 let-rounded-0 let-pt-0 let-pb-0 let-w-100 <?php echo ($sms_name!='registration_sms')?'':'let-disabled let-not-allowed';?>" data-keyword="[referral_balance]"><?php _e('Referral','BMW');?></a></td>
        <td><a href="javascript:void(0)" class="let-btn let-btn-primary let-btn-sm bmw_help_words let-m-0 let-rounded-0 let-pt-0 let-pb-0 let-w-100 <?php echo ($sms_name!='registration_sms')?'':'let-disabled let-not-allowed';?>" data-keyword="[join_balance]"><?php _e('Join','BMW');?></a></td>
      </tr>
      <tr>
        <td><a href="javascript:void(0)" class="let-btn let-btn-primary let-btn-sm bmw_help_words let-m-0 let-rounded-0 let-pt-0 let-pb-0 let-w-100 <?php echo ($sms_name!='registration_sms')?'':'let-disabled let-not-allowed';?>" data-keyword="[current_balance]"><?php _e('Current','BMW');?></a></td>
        <td ><a href="javascript:void(0)" class="let-btn let-btn-primary let-btn-sm bmw_help_words let-m-0 let-rounded-0 let-pt-0 let-pb-0 let-w-100 <?php echo ($sms_name!='registration_sms')?'':'let-disabled let-not-allowed';?>" data-keyword="[total_bonus_amount]"><?php _e('Bonus','BMW');?></a></td>
        <td ><a href="javascript:void(0)" class="let-btn let-btn-primary let-btn-sm bmw_help_words let-m-0 let-rounded-0 let-pt-0 let-pb-0 let-w-100 <?php echo ($sms_name!='registration_sms')?'':'let-disabled let-not-allowed';?>" data-keyword="[total_level_amount]"><?php _e('Level','BMW');?></a></td>
      </tr>
      <tr>
        <td>
          <a href="javascript:void(0)" class="let-btn let-btn-primary let-btn-sm bmw_help_words let-m-0 let-rounded-0 let-pt-0 let-pb-0 let-w-100 <?php echo ($sms_name!='registration_sms')?'':'let-disabled let-not-allowed';?>" data-keyword="[total_shopping]"><?php _e('Shopping','BMW');?></a>
        </td>
        <td ><a href="javascript:void(0)" class="let-btn let-btn-primary let-btn-sm bmw_help_words let-m-0 let-rounded-0 let-pt-0 let-pb-0 let-w-100 <?php echo ($sms_name!='registration_sms')?'':'let-disabled let-not-allowed';?>" data-keyword="[total_orders]"><?php _e('Orders','BMW');?></a></td>
        <td ><a href="javascript:void(0)" class="let-btn let-btn-primary let-btn-sm bmw_help_words let-m-0 let-rounded-0 let-pt-0 let-pb-0 let-w-100 <?php echo ($sms_name!='registration_sms')?'':'let-disabled let-not-allowed';?>" data-keyword="[total_downliners]"><?php _e('Downliners','BMW');?></a></td>
      </tr>
      <tr>
        <td colspan="3" class="let-p-0 let-m-0 let-text-secondary let-small" >
          <?php _e('User Bank Details','BMW');?>
        </td>
      </tr>
      <tr>
        <td ><a href="javascript:void(0)" class="let-btn let-btn-success let-btn-sm bmw_help_words let-m-0 let-rounded-0 let-pt-0 let-pb-0 let-w-100 <?php echo ($sms_name!='registration_sms')?'':'let-disabled let-not-allowed';?>" data-keyword="[bank_name]"><?php _e('Bank Name','BMW');?></a></td>
        <td ><a href="javascript:void(0)" class="let-btn let-btn-success let-btn-sm bmw_help_words let-m-0 let-rounded-0 let-pt-0 let-pb-0 let-w-100 <?php echo ($sms_name!='registration_sms')?'':'let-disabled let-not-allowed';?>" data-keyword="[account_holder]"><?php _e('A/c Holder','BMW');?></a></td>
        <td ><a href="javascript:void(0)" class="let-btn let-btn-success let-btn-sm bmw_help_words let-m-0 let-rounded-0 let-pt-0 let-pb-0 let-w-100 <?php echo ($sms_name!='registration_sms')?'':'let-disabled let-not-allowed';?>" data-keyword="[account_number]"><?php _e('A/c Number','BMW');?></a></td>
      </tr>
      <tr>
        <td ><a href="javascript:void(0)" class="let-btn let-btn-success let-btn-sm bmw_help_words let-m-0 let-rounded-0 let-pt-0 let-pb-0 let-w-100 <?php echo ($sms_name!='registration_sms')?'':'let-disabled let-not-allowed';?>" data-keyword="[branch_name]"><?php _e('Branch','BMW');?></a></td>
        <td ><a href="javascript:void(0)" class="let-btn let-btn-success let-btn-sm bmw_help_words let-m-0 let-rounded-0 let-pt-0 let-pb-0 let-w-100 <?php echo ($sms_name!='registration_sms')?'':'let-disabled let-not-allowed';?>" data-keyword="[ifsc_code]"><?php _e('IFSC','BMW');?></a></td>
        <td ><a href="javascript:void(0)" class="let-btn let-btn-success let-btn-sm bmw_help_words let-m-0 let-rounded-0 let-pt-0 let-pb-0 let-w-100 <?php echo ($sms_name!='registration_sms')?'':'let-disabled let-not-allowed';?>" data-keyword="[contact_number]"><?php _e('Mobile','BMW');?></a></td>
      </tr>
      <tr>
        <td colspan="3" class="let-p-0 let-m-0 let-text-secondary let-small" >
          <?php _e('Payout Details','BMW');?>
        </td>
      </tr>
      <tr>
        <td ><a href="javascript:void(0)" class="let-btn let-btn-danger let-btn-sm bmw_help_words let-m-0 let-rounded-0 let-pt-0 let-pb-0 let-w-100 <?php echo ($sms_name=='payout_sms')?'':'let-disabled let-not-allowed';?>" data-keyword="[payout_id]"><?php _e('Payout id','BMW');?></a></td>
        <td ><a href="javascript:void(0)" class="let-btn let-btn-danger let-btn-sm bmw_help_words let-m-0 let-rounded-0 let-pt-0 let-pb-0 let-w-100 <?php echo ($sms_name=='payout_sms')?'':'let-disabled let-not-allowed';?>" data-keyword="[payout_total]"><?php _e('Payout Total','BMW');?></a></td>
        <td ><a href="javascript:void(0)" class="let-btn let-btn-danger let-btn-sm bmw_help_words let-m-0 let-rounded-0 let-pt-0 let-pb-0 let-w-100 <?php echo ($sms_name=='payout_sms')?'':'let-disabled let-not-allowed';?>" data-keyword="[payout_date]"><?php _e('Payout Date','BMW');?></a></td>
      </tr>
      <tr>
        <td colspan="3" class="let-p-0 let-m-0 let-text-secondary let-small" >
          <?php _e('Data','BMW');?>
        </td>
      </tr>
        <tr>
          <td colspan=""><a href="javascript:void(0)" class="let-btn let-btn-danger let-btn-sm bmw_help_words let-m-0 let-rounded-0 let-pt-0 let-pb-0 let-w-100 <?php echo ($sms_name=='payout_sms')?'':'let-disabled let-not-allowed';?>" data-keyword="[payout_data]"><?php _e('Payout','BMW');?></a></td>
          <td colspan=""><a href="javascript:void(0)" class="let-btn let-btn-danger let-btn-sm bmw_help_words let-m-0 let-rounded-0 let-pt-0 let-pb-0 let-w-100 <?php echo ($sms_name=='withdrawal_request_sms')?'':'let-disabled let-not-allowed';?>" data-keyword="[withdrawal_req_data]"><?php _e('W- Req.','BMW');?></a></td>
          <td colspan=""><a href="javascript:void(0)" class="let-btn let-btn-danger let-btn-sm bmw_help_words let-m-0 let-rounded-0 let-pt-0 let-pb-0 let-w-100 <?php echo ($sms_name=='withdrawal_pay_sms')?'':'let-disabled let-not-allowed';?>" data-keyword="[withdrawal_pay_data]"><?php _e('W- Pay','BMW');?></a></td>
          
        </tr>
    </tbody>
  </table>

</div>
</div>
</div>
</div>

</div>
</div>
</div>
<?php 

}


if(!function_exists('bmw_addons_installable_template_function')):
  function bmw_addons_installable_template_function()
  {
    $plugins=array();
    $plugins['mycred']=array(
      'title'       => 'myCred – Points, Rewards, Gamification, Ranks, Badges & Loyalty Plugin',
      'description' => __('myCred is an intelligent and adaptive points management system that allows you to build and manage a broad range of digital rewards including points, ranks and, badges on your WordPress/WooCommerce powered website','BMW'),
      'developer'   => 'myCred',
      'image'       => 'mycred.png',
      'slug'       => 'mycred/mycred.php',
      'url'         => 'https://downloads.wordpress.org/plugin/mycred.latest-stable.zip'
    );
    $plugins['terawallet']=array(
      'title'       => 'TeraWallet – For WooCommerce',
      'description' => __('TeraWallet allows customers to store their money in a digital wallet. The customers can use the wallet money for purchasing products from the store. The customers can add money to their wallet using various payment methods set by the admin. The admin can set cashback rules according to cart price or product. The customers will receive their cashback amount in their wallet account. The admin can process refund to customer wallet.','BMW'),
      'developer'   => 'WCBeginner',
      'image'       => 'terawallet.png',
      'slug'       => 'woo-wallet/woo-wallet.php',
      'url'         => 'https://downloads.wordpress.org/plugin/woo-wallet.latest-stable.zip'
    );

    if(!empty( $plugins)):
      foreach ($plugins as $slug => $plugin):
       ?>
       <div class="let-col-md-12 let-col-sm-12 ">
        <div class="let-x_panel">
          <div class="let-loader-layer <?php echo 'bmw_'.$slug;?>">
          <div class="let-loader"></div>
        </div>
          <div class="let-x_content">
            <div class="let-row">
              <div class="let-col-md-2 let-m-auto">
                <div class="let-plugin-image">
                  <img src="<?php echo BMW()->plugin_url().'/image/'.$plugin['image'];?>" >
                </div>
              </div>
              <div class="let-col-md-8">
                <div class="let-plugin-title">
                  <?php echo $plugin['title'];?>
                </div>
                <div class="let-plugin-dev">
                 <?php echo   sprintf(__('BY %s','BMW'),$plugin['developer']);?>
               </div>
               <div class="let-plugin-desc">
                <?php echo $plugin['description'];?>
              </div>
            </div>
            <div class="let-col-md-2 let-m-auto">
              <div class="let-plugin-install">
                <?php if(is_plugin_active( $plugin['slug'] )): ?>
             <button class="let-btn let-btn-success let-btn-sm let-rounded-0 install_bmw_addon" data-plugin-slug="<?php echo $slug;?>"><?php _e('Upgrade','BMW');?></button>
             <a class="let-btn let-btn-success let-btn-sm let-rounded-0" href="<?php echo admin_url().'admin.php?page=bmw-settings&setting=addons&addon-setting='.$slug;?>"><?php _e('Settings','BMW');?></a>
             <?php else: ?>
             <button class="let-btn let-btn-success let-btn-sm let-rounded-0 install_bmw_addon" data-plugin-slug="<?php echo $slug;?>"><?php _e('Get it Now','BMW');?></button>
           <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    </div>

    <?php 
  endforeach;
endif;
}
endif;
  // 
  // .