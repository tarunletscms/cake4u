<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; 
}

use Twilio\Rest\Client;
use Plivo\RestClient;

///////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////// Some important Functions /////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////// 
function is_lic_validate()
    {
         return true;
        $url = 'https://mlmtrees.com/wp-json/letscms/v1/licence';
        //$website=str_replace(array('http://','https://','www.','/'),array('','','',''),get_site_url());
        $website=str_replace(array('http://','https://','www.','/'),array('','','',''),  'mlmforest.com');
        $licence_key=get_option('bmw_licence_key');
        echo $expiry=get_option('bmw_licence_expiry');die;

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
        return true;
        }else{
            error_message($data->message);
        return false;
        }
    }
     function get_licence_expiry()
        {
           $licence_key=get_option('bmw_licence_key');
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
            if( !empty($data) && $data->success==true)
            {
               return $data->expiry;
            }

        }

function sanitize_text_array($array) {
   foreach ( (array) $array as $k => $v ) {
      if ( is_array( $v ) ) {
          $array[$k] =  sanitize_text_array( $v );
      } else {
          $array[$k] = sanitize_text_field( $v );
      }
   }

  return $array;                                                       
}

function error_message($message)
{
?>
    <div class="col-md-12 text-center">
            <strong><?php echo $message;?></strong>
            <br/><span class=""><?php echo __('or','BMW');?></span><br/> <a href="https://bmptrees.com"  class="btn btn-success" target="_blank"><?php echo __('Purchase Licence','BMW');?></a>
            </div>
    <?php die;
}
function get_url_bmw($string)
{
    global $wpdb;
   $result=$wpdb->get_var("SELECT ID FROM {$wpdb->prefix}posts As post INNER JOIN {$wpdb->prefix}postmeta AS postmeta ON post.ID=postmeta.post_id WHERE post_name='".$string."'");
   $url=get_permalink($result);
   return $url;
}
function bmw_price($price,$type=NULL)
{ 
  global $wpdb;
  $price=floatval($price);
 $setting = get_option('bmw_manage_general');
 if(!is_null($type) && $type=='PV'){
 return number_format($price,3);
 }else{
   return wc_price($price,array('decimals'=>3));
  }
}



function bmw_email_check_function()
{
    $json=array();
    $error =array();
    $email=$_POST['email'];
    if(empty($email)){
        $error['err_mail']= __('Please enter Email Address','BMW');
      } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $error['err_mail']= __('E-mail address is invalid.','BMW');
    }

     if(empty($error)){
        $json['status']=true;
        $json['message']='E-mail address is valid.';
        echo json_encode($json);
        wp_die();
     }else{
    $json['status']=false;
    $json['error']=$error;
      echo json_encode($json);
      wp_die(); 
  }

}


function bmw_generateKey()
{
	$characters = ["0","1","2","3","4","5","6","7","8","9"];

	$keys = array();

	$length = 9;

	while(count($keys) < $length)
	{
		$x = mt_rand(0, count($characters)-1);
		if(!in_array($x, $keys))
       		$keys[] = $x;
	}
	// extract each key from array
	$random_chars='';
	foreach($keys as $key)
   		$random_chars .= $characters[$key];
        
	// display random key
	return $random_chars;
}

function bmw_generateOTP()
{
  $characters = ["0","1","2","3","4","5","6","7","8","9"];

  $keys = array();

  $length = 4;

  while(count($keys) < $length)
  {
    $x = mt_rand(0, count($characters)-1);
    if(!in_array($x, $keys))
          $keys[] = $x;
  }
  // extract each key from array
  $random_chars='';
  foreach($keys as $key)
      $random_chars .= $characters[$key];
        
  // display random key
  return $random_chars;
}


function bmw_user_check_validate_function()
{ 
  global $wpdb;
    $user = wp_get_current_user();
  if(isset($user) && !empty($user) && is_user_logged_in())
     {

        $roles = ( array ) $user->roles;
        if(!in_array('bmw_user',$roles))
        {
         become_bmw_user_box();
          return false;
        }else{
          return true;
        }
    }else{
    bmw_login_function();
     return false;
    }
}


function bmw_account_details_update_function()
{ 
  global $wpdb;
  unset($_POST['action']);
  $return=array();
  $return['status'] = false;
  $postdata=sanitize_text_array($_POST);
  if(!empty($postdata))
  {
    foreach ($postdata as $key => $post) {
      if(empty($post)){
           $return['error'][$key]=ucwords(str_replace('_', ' ', $key)).' '.__('Could Not Empty!!!','BMW');
        }
    }
  }
      if(empty($return['error'])){
        $user_key=bmw_get_current_user_key();
        $wpdb->query("DELETE FROM {$wpdb->prefix}bmw_bank_details WHERE user_key='".$user_key."'");
        $wpdb->query("INSERT INTO {$wpdb->prefix}bmw_bank_details SET user_key='".$user_key."', account_holder='".$postdata['account_holder_name']."', account_number  ='".$postdata['account_number']."', bank_name='".$postdata['bank_name']."', branch='".$postdata['branch']."', ifsc_code='".$postdata['ifsc_code']."', contact_number ='".$postdata['contact_number']."', insert_date='".date_i18n('Y-m-d H:i:s')."'");
        $return['status'] = true;
        $return['message']= __('Your Bank has been updated successfully','BMW');
        echo json_encode($return);
        wp_die();
      }else{
      $return['status']=false;
      $return['message']= __('Something going wrong please Check','BMW');
      }
      echo json_encode($return);
      wp_die();
}


function get_time_ago( $time )
{
    $time_difference = time() - strtotime($time);

    if( $time_difference < 1 ) { return __('less than 1 second ago','BMW'); }
    $condition = array( 12 * 30 * 24 * 60 * 60 =>  __('year','BMW'),
                30 * 24 * 60 * 60       =>  __('month','BMW'),
                24 * 60 * 60            =>  __('day','BMW'),
                60 * 60                 =>  __('hour','BMW'),
                60                      =>  __('minute','BMW'),
                1                       =>  __('second','BMW')
    );

    foreach( $condition as $secs => $str )
    {
        $d = $time_difference / $secs;

        if( $d >= 1 )
        {
            $t = round( $d );
            return __('about','BMW') .'&nbsp;'. $t . ' ' . $str . ( $t > 1 ? __('s','BMW') : '' ) .'&nbsp;'. __('ago','BMW');
        }
    }
}
function bmw_affiliate_url_function(){
    global $wpdb, $current_user;
        $url=get_url_bmw('register');
        if(strpos($url,"&")){
        $affiliateURL = $url . '&sp=' . $current_user->user_login;
        }else{
        $affiliateURL = $url . '?sp=' . $current_user->user_login;
        }
        return $affiliateURL; 
}


function bmw_login_form_function()
{
 global $wpdb;$return=array();
  $post_data=sanitize_text_array($_POST);
  unset($post_data['action']);
  $return['status'] =false;
  if(!isset($post_data['username']) || empty($post_data['username']))
  {
    $return['error']['username_error'] = __('Username could not be empty!!!','BMW');
  }else if(!username_exists($post_data['username']))
  {
    $return['error']['username_error'] = __('Username not exist, please register your account!!!','BMW');
  }

  if(!isset($post_data['password']) || empty($post_data['password']))
  {
    $return['error']['password_error'] = __('Password could not be empty!!!','BMW');
  }
  if(empty($return['error']))
  {
    $return['status']=true;
    $user = array('user_login' => $post_data['username'],'user_password'=> $post_data['password']);
    $user_login=wp_signon($user);
    if(empty($user_login))
    {
      $return['error']['incorrect_credentials'] =__('Please Provide Valid Credentials!!!','BMW');
      $return['status']=false;
    }
  }

  echo json_encode($return);
  wp_die();

}



function bmw_base_name_information(){
    echo '<meta name="bmw_adminajax" content="'.admin_url('admin-ajax.php').'" />';
    echo '<meta name="bmw_base_url" content="'.site_url().'" />';
    echo '<meta name="bmw_author_url" content="https://www.letscms.com" />';
}



function bmw_add_query_vars($aVars) {
  $aVars[] = "key";
  $aVars[] = "parent_key";
  $aVars[] = "position";
  return $aVars;
}
 
add_filter('query_vars', 'bmw_add_query_vars');

function bmw_add_rewrite_rules($aRules) {
$newrules = array();
$newrules['/downlines/([^/]+)/?$'] = 'index.php?pagename=downlines&key=$matches[1]';
$newrules['/register/([^/]+)/([^/]+)/?$'] = 'index.php?pagename=register&parent_key=$matches[1]&position=$matches[2]';

$finalrules = $newrules + $aRules;
return $finalrules;

}
 
add_filter('rewrite_rules_array', 'bmw_add_rewrite_rules'); 

function bmw_get_page_id( $page ) {
	$page = apply_filters( 'bmw_get_' . $page . '_page_id', get_option( 'bmw_' . $page . '_page_id' ) );
	return $page ? absint( $page ) : -1;
}


















///////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////  Basic   Functions ///////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////

function bmw_get_client_ip() {
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if(isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

// function get_user_display_referral_commission($user_key)
// {
//   global $wpdb;
//  return $wpdb->get_results("SELECT * FROM {$wpdb->prefix}bmw_referral_commission WHERE status='0' AND user_key='".$user_key."'");
// }
function get_user_display_referral_commission($user_key)
{
  global $wpdb;
  $users=array();
  $amount=0;
  $payout_setting=get_option('bmw_manage_payout');
  $data= $wpdb->get_results("SELECT * FROM {$wpdb->prefix}bmw_referral_commission WHERE user_key='".$user_key."'");
  if(!empty($data)){
  foreach($data as $result){
    $amount+=$result->amount;
    $users['users']['childs'][]=$result->child_key;
    }
  $users['users']['amount']=$amount;
  }
  $childs=serialize($users['users']['childs']);
  $insert_date=date("Y-m-d h:i:s");
  if(!empty($users) && empty(existDirectbonus($user_key,$childs))){
     if(!empty($payout_setting)){ 
        $direct_bonus=($users['users']['amount']*$payout_setting['bmw_week_provenue']/100)*$payout_setting['bmw_referral_commission_amount']/100;
       }
    $wpdb->query("INSERT INTO {$wpdb->prefix}bmw_direct_commission (user_key,childs,total_amount,direct_bonus_amount,insert_date) values('".$user_key."','".$childs."',".$users['users']['amount'].",".$direct_bonus.",'$insert_date' ) ");
  }
  return $users;
    
}

function existDirectbonus($user_key,$childs){
    global $wpdb;
    return $wpdb->get_var("SELECT * FROM {$wpdb->prefix}bmw_direct_commission WHERE user_key='".$user_key."' AND childs='".$childs."' AND payout_id='0'");
}
function get_user_display_one_time_leadership_commission($user_key)
{
  global $wpdb;
  return $wpdb->get_results("SELECT * FROM {$wpdb->prefix}bmw_leader_one_time_bonus WHERE status='0' AND user_key='".$user_key."'");
    
}

function checkPayoutRunDay($field,$userkey,$tablename){
      global $wpdb;
      $current_date=date("y-m-d h:i:s");
      $general_setting=get_option('bmw_manage_general');
     if(!empty($field) && !empty($userkey) && !empty($tablename) && !empty($general_setting['bmw_payoutrun_day'])) {
        $get_last_pay_date=$wpdb->get_var("SELECT ".$field." FROM {$wpdb->prefix}".$tablename." WHERE user_key='".$userkey."' order by id DESC ");
        // echo '<pre>';print_r($get_last_pay_date);die;
        $last_date_str=strtotime($get_last_pay_date);
        $current_pay_date_str=strtotime($current_date);
        if(!empty($get_last_pay_date)){
            $diff=$current_pay_date_str-$last_date_str;
            $days = round($diff/ (60*60*24));
            if($general_setting['bmw_payoutrun_day']<=$days){
                return true;
            }else{
                return false;
            }
        }else{
            return true;
        }
     }else{
        return false;
     }
}

function get_user_display_faststart_commission($user_key)
{
      global $wpdb;
      
      $purchase_amount=0;
      $direct_sponsor=0;
      $childs=array();
      $eligibility_setting=get_option('bmw_manage_eligibility');
      $payout_setting=get_option('bmw_manage_payout');
      $user=bmw_get_user_info_by_userkey($user_key);
      $registration_date=strtotime($user->creation_date);
      $current_date=strtotime(date("Y-m-d h:i:s"));

  if(!empty($registration_date)){
      $diff=$current_date-$registration_date;
      $days = round($diff/ (60*60*24));

      $Query = $wpdb->get_results("SELECT `bh`.`user_key` FROM {$wpdb->prefix}bmw_hierarchy as `bh` JOIN {$wpdb->prefix}bmw_users as  `u` ON `u`.`user_key`=`bh`.`user_key`  WHERE   `bh`.parent_key='".$user_key."' AND `bh`.sponsor_key='".$user_key."'  AND `bh`.commission_status = '0' AND `u`.payment_status='1' ORDER BY `bh`.id ASC ");


        if(!empty($Query))
        {  
              foreach ($Query as $child) {
                 
                $cid=bmw_get_user_id_by_userkey($child->user_key);
                $purchase_amount+=bmw_get_total_purchase_by_user_id($cid);
              }
                $direct_sponsor=count($Query);
          }
        // echo '<pre>'.$days.'//'.$eligibility_setting['bmw_cake4u_faststart_day_limit'].'//'.$eligibility_setting['bmw_cake4u_faststart_volume_limit'].'//'.$purchase_amount.'//'.$eligibility_setting['bmw_cake4u_faststart_sponsor_limit'].'//'.$direct_sponsor.'//'.checkPayoutRunDay('insert_date',$user_key,'bmw_faststart_bonus_commission');
          $insert_date=date('y-m-d h:i:s');
          if($days<=$eligibility_setting['bmw_cake4u_faststart_day_limit'] && $eligibility_setting['bmw_cake4u_faststart_volume_limit']<=$purchase_amount && $eligibility_setting['bmw_cake4u_faststart_sponsor_limit']<=$direct_sponsor && checkPayoutRunDay('insert_date',$user_key,'bmw_faststart_bonus_commission') ){ 
              $bonus_amount=($purchase_amount*$payout_setting['bmw_week_provenue']/100)*$payout_setting['bmw_faststart_amount']/100;
              $wpdb->query("INSERT INTO {$wpdb->prefix}bmw_faststart_bonus_commission  SET user_key='".$user_key."',  amount='".$purchase_amount."',bonus_amount='".$bonus_amount."',insert_date='".$insert_date."'");
              
          }elseif(!empty(exist_faststart_bonus($user_key)) && checkPayoutRunDay('insert_date',$user_key,'bmw_faststart_bonus_commission')){
              $bonus_amount=($purchase_amount*$payout_setting['bmw_week_provenue']/100)*$payout_setting['bmw_faststart_amount']/100;
              $wpdb->query("INSERT INTO {$wpdb->prefix}bmw_faststart_bonus_commission  SET user_key='".$user_key."',  amount='".$purchase_amount."',bonus_amount='".$bonus_amount."',insert_date='".$insert_date."'");
          }
    
     }
     return $wpdb->get_results("SELECT * FROM {$wpdb->prefix}bmw_faststart_bonus_commission WHERE user_key='".$user_key."' AND status='0'");
}

function exist_faststart_bonus($user_key){
    global $wpdb;
    return $wpdb->get_var("SELECT user_key FROM {$wpdb->prefix}bmw_faststart_bonus_commission WHERE user_key='".$user_key."'");
}
  
    

function get_user_display_level_commission($user_key)
{
  global $wpdb;
  return $wpdb->get_results("SELECT * FROM {$wpdb->prefix}bmw_level_commission WHERE status='0' AND sponsor_key='".$user_key."'");
}


function bmw_get_user_id_by_username($username) {
    global $wpdb;
   return $wpdb->get_var("SELECT user_id  FROM {$wpdb->prefix}bmw_users  WHERE user_name = '".$username."' ");
}
function bmw_get_userkey_by_username($username) {
    global $wpdb;
    return  $wpdb->get_var("SELECT user_key  FROM {$wpdb->prefix}bmw_users  WHERE user_name = '".$username."' ");
   
}

function bmw_get_user_id_by_userkey($key)
{
    global $wpdb;
    return $wpdb->get_var("SELECT user_id FROM {$wpdb->prefix}bmw_users WHERE `user_key` = '".$key."'");
}

function bmw_get_user_key_by_user_id($user_id){
    global $wpdb;
    return $wpdb->get_var("SELECT user_key FROM {$wpdb->prefix}bmw_users WHERE user_id='".$user_id."'");
}

function bmw_get_username_by_user_id($user_id)
{
    global $wpdb;
   return $wpdb->get_var( "SELECT user_name FROM {$wpdb->prefix}bmw_users WHERE user_id = '".$user_id."'");
}

function bmw_get_username_by_userkey($key)
{
    global $wpdb;
    return $wpdb->get_var("SELECT user_name FROM {$wpdb->prefix}bmw_users WHERE user_key = '".$key."'");
}

function bmw_get_user_info_by_userkey($key)
{
    global $wpdb;
   return  $wpdb->get_row("SELECT * FROM {$wpdb->prefix}bmw_users WHERE user_key = '".$key."'");
}

function bmw_get_user_info_by_user_id($user_id)
{
     global $wpdb;
    $results=$wpdb->get_row("SELECT * FROM {$wpdb->prefix}bmw_users where user_id=".$user_id);

    return $results;
}

function bmw_get_current_user_key()
{
    global $current_user, $wpdb;
    return $wpdb->get_var("SELECT user_key FROM {$wpdb->prefix}bmw_users WHERE user_name = '".$current_user->user_login."'");
}

function bmw_get_product_price_by_user_id($user_id) {
    global $wpdb;
   return $wpdb->get_var("SELECT product_price FROM {$wpdb->prefix}bmw_users WHERE user_id='".$user_id."'");
}
function bmw_get_total_purchase_by_user_id($user_id) {
    global $wpdb;
   $settings=get_option('bmw_manage_general');
     if(isset( $settings['bmw_plan_base']) &&  $settings['bmw_plan_base']=='points'){
        return $wpdb->get_var("SELECT SUM(total_points) FROM {$wpdb->prefix}bmw_orders WHERE user_id='".$user_id."'");
    }else{
        return $wpdb->get_var("SELECT SUM(total_amount) FROM {$wpdb->prefix}bmw_orders WHERE user_id='".$user_id."'");
    }
}

function bmw_get_parent_key_by_userid($user_id){
    global $wpdb;
    return $wpdb->get_var("SELECT parent_key FROM {$wpdb->prefix}bmw_users WHERE user_id='$user_id'");
}

function bmw_get_sponsor_key_by_userid($user_id){
    global $wpdb;
   return $wpdb->get_var("SELECT sponsor_key FROM {$wpdb->prefix}bmw_users WHERE user_id='".$user_id."'");
}
function bmw_get_sponsor_key_by_userkey($user_key){
    global $wpdb;
    return $wpdb->get_var("SELECT sponsor_key FROM {$wpdb->prefix}bmw_users WHERE user_key='".$user_key."'");
}


function bmw_user_pair_commission_sum($user_key){
    global $wpdb;
    $pair_commission=$wpdb->get_var("SELECT SUM(amount) as total FROM {$wpdb->prefix}bmw_pair_commission WHERE user_key='".$user_key."' AND payout_id!='0'");
    return ($pair_commission>0)?$pair_commission:'0';
}
function bmw_user_leadership_commission_sum($user_key){
    global $wpdb;
    $pair_commission=$wpdb->get_var("SELECT SUM(leadership_bonus) as total FROM {$wpdb->prefix}bmw_leadership_bonus_commission WHERE user_key='".$user_key."' AND payout_id!='0'");
    return ($pair_commission>0)?$pair_commission:'0';
}

function bmw_user_leader_commission_sum($user_key){
    global $wpdb;
    $bonus_commission=$wpdb->get_var("SELECT SUM(amount) as total FROM {$wpdb->prefix}bmw_bonus_commission WHERE user_key='".$user_key."' AND payout_id!='0'");
    return ($bonus_commission>0)?$bonus_commission:'0';
}

function bmw_user_referral_commission_sum($user_key){
    global $wpdb;
    $referral_commission=$wpdb->get_var("SELECT SUM(amount) as total FROM {$wpdb->prefix}bmw_referral_commission WHERE user_key='".$user_key."' AND payout_id!='0'");
    return ($referral_commission>0)?$referral_commission:'0';
}
function bmw_user_faststart_commission_sum($user_key){
    global $wpdb;
    $faststart_commission=$wpdb->get_var("SELECT SUM(bonus_amount) as total FROM {$wpdb->prefix}bmw_faststart_bonus_commission WHERE user_key='".$user_key."' AND payout_id!='0'");
    return ($faststart_commission>0)?$faststart_commission:'0';
}
function bmw_user_onetime_bonus_sum($user_key){
    global $wpdb;
    $onetime_commission=$wpdb->get_var("SELECT SUM(amount) as total FROM {$wpdb->prefix}bmw_leader_one_time_bonus WHERE user_key='".$user_key."' AND payout_id!='0'");
    return ($onetime_commission>0)?$onetime_commission:'0';
}


function bmw_get_top_user_key()
{
    global $wpdb;
    return $wpdb->get_var("SELECT user_key FROM {$wpdb->prefix}bmw_users WHERE parent_key = 0 AND sponsor_key=0");
}


function bmw_payout_list_by_user_key($user_key,$payout_id=NULL)
{
    global $wpdb;
    $query="SELECT * FROM {$wpdb->prefix}bmw_payout WHERE user_key='".$user_key."'";
    if(!is_null($payout_id))
    {
    $query.="AND payout_id='".$payout_id."'";
    }
    return $wpdb->get_results($query);
}

function bmw_user_pair_commission_by_user_key($key,$payout_id=NULL)
{
    global $wpdb;
    $query="SELECT * FROM {$wpdb->prefix}bmw_pair_commission WHERE user_key='".$key."'";
     if(!is_null($payout_id))
    {
    $query.="AND payout_id='".$payout_id."'";
    }else{
    $query.="AND payout_id!=0";
    }
   return $wpdb->get_results($query);
}

function bmw_user_referral_commission_by_user_key($user_key,$payout_id=NULL){
    global $wpdb;
    $query="SELECT * FROM {$wpdb->prefix}bmw_direct_commission WHERE user_key='".$user_key."'";
     if(!is_null($payout_id))
    {
    $query.="AND payout_id='".$payout_id."'";
    }else{
    $query.="AND payout_id!=0";
    }
   return $wpdb->get_results($query);
}


function bmw_user_level_commission_by_user_key($user_key,$payout_id=NULL)
{
    global $wpdb;
    $query="SELECT * FROM {$wpdb->prefix}bmw_level_commission WHERE sponsor_key='".$user_key."'";
     if(!is_null($payout_id))
    {
    $query.="AND payout_id='".$payout_id."'";
    }else{
    $query.="AND payout_id!=0";
    }
 return $wpdb->get_results($query);
}

function bmw_user_bonus_details_by_user_key($user_key,$payout_id=NULL)
{
    global $wpdb;
   $query="SELECT * FROM {$wpdb->prefix}bmw_bonus_commission WHERE user_key='".$user_key."'";
     if(!is_null($payout_id))
    {
    $query.="AND payout_id='".$payout_id."'";
    }else{
    $query.="AND payout_id!=0";
    }
   return $wpdb->get_results($query);
}
function bmw_user_leader_bonus_details_by_user_key($user_key,$payout_id=NULL)
{
    global $wpdb;
   $query="SELECT * FROM {$wpdb->prefix}bmw_leadership_bonus_commission WHERE user_key='".$user_key."'";
     if(!is_null($payout_id))
    {
    $query.="AND payout_id='".$payout_id."'";
    }else{
    $query.="AND payout_id!=0";
    }
   return $wpdb->get_results($query);
}

function bmw_user_faststart_bonus_details_by_user_key($user_key,$payout_id=NULL)
{
    global $wpdb;
   $query="SELECT * FROM {$wpdb->prefix}bmw_faststart_bonus_commission WHERE user_key='".$user_key."'";
     if(!is_null($payout_id))
    {
    $query.="AND payout_id='".$payout_id."'";
    }else{
    $query.="AND payout_id!=0";
    }
   return $wpdb->get_results($query);
}

function bmw_user_total_earnings_by_user_key($user_key){
    global $wpdb;
     return $wpdb->get_row("SELECT SUM(pair_commission) as pair_commission, SUM(referral_commission) as referral_commission, SUM(leadership_commission) as leadership_commission,SUM(faststart_commission) as faststart_commission,SUM(one_time_bonus) as one_time_bonus, SUM(total_bonus) as total_bonus, SUM(total_amount) as total_amount, SUM(total_points) as total_points, SUM(tax) as tax, SUM(service_charge) as service_charge FROM {$wpdb->prefix}bmw_payout WHERE user_key='".$user_key."'",ARRAY_A);
}

function bmw_get_earning_sum_by_user_key($user_key){
    global $wpdb;
   return $wpdb->get_var("SELECT SUM(total_amount) FROM {$wpdb->prefix}bmw_payout WHERE user_key='".$user_key."'");
}


function get_network_row_by_key($user_key)
{
  global $wpdb;
  return $wpdb->get_var("SELECT network_row FROM {$wpdb->prefix}bmw_users WHERE user_key='".$user_key."'");
}

function bmw_get_bank_info($user_key)
{
  global $wpdb;
  return  $wpdb->get_row("SELECT * FROM {$wpdb->prefix}bmw_bank_details WHERE user_key='".$user_key."'");
}


function bmw_get_current_balance_by_user_id($user_id)
{
    global $wpdb;
    $user_key=bmw_get_user_key_by_user_id($user_id);
    $total_amount= $wpdb->get_var("SELECT SUM(total_amount) AS total FROM {$wpdb->prefix}bmw_payout WHERE user_key ='".$user_key."'");
    $requested_amount = $wpdb->get_var("SELECT SUM(amount) AS total FROM {$wpdb->prefix}bmw_withdrawal WHERE user_id='".$user_id."'"); 
    $remain_amount=$total_amount-$requested_amount;
    return $remain_amount;
}

function bmw_get_requested_balance_by_user_id($user_id)
{
    global $wpdb;
   return $wpdb->get_var("SELECT SUM(amount) AS total FROM {$wpdb->prefix}bmw_withdrawal WHERE user_id='".$user_id."' AND payment_processed!='0'"); 
}

function bmw_get_pending_balance_by_user_id($user_id)
{
    global $wpdb;
   return $wpdb->get_var("SELECT SUM(amount) AS total FROM {$wpdb->prefix}bmw_withdrawal WHERE user_id='".$user_id."' AND payment_processed='0'"); 
}

function bmw_get_withdrawal_data_by_user_id($user_id)
{
    global $wpdb;
   return $wpdb->get_results("SELECT * FROM {$wpdb->prefix}bmw_withdrawal WHERE user_id='".$user_id."'"); 
}

function bmw_get_downlines_count($user_key)
{
  global $wpdb;
  return $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}bmw_hierarchy WHERE parent_key='".$user_key."'");
}
function bmw_get_referrals_count($user_key)
{
  global $wpdb;
  return $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}bmw_users WHERE sponsor_key='".$user_key."'");
}

function bmw_get_withdrawal_detail_by_wid($user_id,$id)
{
  global $wpdb;
  return $wpdb->get_row("SELECT * FROM {$wpdb->prefix}bmw_withdrawal WHERE user_id='".$user_id."' AND id='".$id."'");
}


function bmw_get_payout_data_by_payout_id($payout_id,$user_key)
{
  global $wpdb;
  return $wpdb->get_row("SELECT * FROM {$wpdb->prefix}bmw_payout WHERE user_key='".$user_key."' AND payout_id='".$payout_id."'");
}


function bmw_get_phone_codes()
{
  global $wpdb;
  return $wpdb->get_results("SELECT * FROM {$wpdb->prefix}bmw_phone_codes ORDER BY phonecode ASC");
}








///////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////Reset   Functions ///////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////


function bmw_admin_reset_data_function()
{
   global $wpdb;
        $tables = array(
            "{$wpdb->prefix}bmw_users",
            "{$wpdb->prefix}bmw_leftposition",
            "{$wpdb->prefix}bmw_rightposition",
            "{$wpdb->prefix}bmw_commission",
            "{$wpdb->prefix}bmw_bonus_commission",
            "{$wpdb->prefix}bmw_payout_master",
            "{$wpdb->prefix}bmw_payout",
            "{$wpdb->prefix}bmw_referral_commission",
            "{$wpdb->prefix}bmw_product_price",
            "{$wpdb->prefix}bmw_epins",
            "{$wpdb->prefix}bmw_royalty",
        );
        
        
    foreach ( $tables as $table ) {
        $wpdb->query( "TRUNCATE {$table}" ); 
    }
return true;
}











///////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////Side Menu   Functions ///////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////


function get_menu_array()
{
  $menu_array=array();
  $menu_array[]=array(
        'icon'  => 'fa fa-dashboard',
        'title' => __('Dashboard','BMW'),
        'link'  => get_url_bmw('dashboard'),
        );
  $menu_array[]=array(
        'icon'=> '',
        'svg'=> '<svg xmlns="http://www.w3.org/2000/svg" id="Layer_1" enable-background="new 0 0 512 512" height="24px" viewBox="0 0 512 512" width="24px"><g><g><path d="m105 151c-57.897 0-105 47.103-105 105 0 30.364 12.96 57.754 33.634 76.943 10.732-18.652 28.275-32.275 48.534-38.188-13.255-7.839-22.168-22.272-22.168-38.755 0-24.813 20.187-45 45-45s45 20.187 45 45c0 16.483-8.913 30.916-22.168 38.755 20.259 5.913 37.802 19.536 48.534 38.188 20.674-19.189 33.634-46.579 33.634-76.943 0-57.897-47.103-105-105-105z" data-original="#000000" class="active-path" data-old_color="#000000" fill="#FFFFFF"/><path d="m105 321.479c-19.577 0-37.624 11.16-46.578 28.606 14.044 6.98 29.859 10.915 46.578 10.915s32.533-3.934 46.578-10.915c-8.954-17.447-27.002-28.606-46.578-28.606z" data-original="#000000" class="active-path" data-old_color="#000000" fill="#FFFFFF"/><circle cx="105" cy="256" r="15" data-original="#000000" class="active-path" data-old_color="#000000" fill="#FFFFFF"/><path d="m335.634 181.943c10.732-18.652 28.275-32.275 48.534-38.188-13.255-7.839-22.168-22.272-22.168-38.755 0-24.813 20.187-45 45-45s45 20.187 45 45c0 16.483-8.913 30.916-22.167 38.755 20.259 5.913 37.802 19.536 48.534 38.188 20.673-19.189 33.633-46.578 33.633-76.943 0-57.897-47.103-105-105-105s-105 47.103-105 105c0 30.365 12.96 57.754 33.634 76.943z" data-original="#000000" class="active-path" data-old_color="#000000" fill="#FFFFFF"/><path d="m360.422 199.084c14.044 6.982 29.859 10.916 46.578 10.916s32.533-3.934 46.578-10.915c-8.953-17.447-27.001-28.606-46.578-28.606s-37.625 11.16-46.578 28.605z" data-original="#000000" class="active-path" data-old_color="#000000" fill="#FFFFFF"/><circle cx="407" cy="105" r="15" data-original="#000000" class="active-path" data-old_color="#000000" fill="#FFFFFF"/><path d="m407 302c-57.897 0-105 47.103-105 105 0 30.364 12.96 57.754 33.634 76.943 10.732-18.652 28.275-32.275 48.534-38.188-13.255-7.839-22.168-22.272-22.168-38.755 0-24.813 20.187-45 45-45s45 20.187 45 45c0 16.483-8.913 30.916-22.167 38.755 20.259 5.913 37.802 19.536 48.534 38.188 20.673-19.189 33.633-46.579 33.633-76.943 0-57.898-47.103-105-105-105z" data-original="#000000" class="active-path" data-old_color="#000000" fill="#FFFFFF"/><path d="m407 472.478c-19.576 0-37.624 11.16-46.578 28.606 14.044 6.981 29.859 10.916 46.578 10.916s32.533-3.934 46.578-10.915c-8.954-17.447-27.002-28.607-46.578-28.607z" data-original="#000000" class="active-path" data-old_color="#000000" fill="#FFFFFF"/><circle cx="407" cy="407" r="15" data-original="#000000" class="active-path" data-old_color="#000000" fill="#FFFFFF"/><path d="m213.64 175.956c5.926 8.022 10.984 16.722 15.039 25.958l58.905-34.008c-4.697-8.881-8.433-18.343-11.066-28.251z" data-original="#000000" class="active-path" data-old_color="#000000" fill="#FFFFFF"/><path d="m213.64 336.044 62.877 36.302c2.634-9.908 6.369-19.371 11.066-28.251l-58.905-34.009c-4.054 9.237-9.112 17.936-15.038 25.958z" data-original="#000000" class="active-path" data-old_color="#000000" fill="#FFFFFF"/></g></g> </svg>
',
        'title'=> __('Genealogy','BMW'),
        'link'=>get_url_bmw('genealogy'),
        );
  $menu_array[]=array(
        'icon'=> 'fa fa-money',
        'title'=> __('Payout Details','BMW'),
        'link'=>'',
        'sub-list'=> array(
                            array(
                            'title'=> __('Payout List','BMW'),
                            'link'=>get_url_bmw('payout_list'),
                            ),
                           array(
                            'title'=> __('Pair Commission','BMW'),
                            'link'=>get_url_bmw('payout_list').'?section=pair_commission',
                            // 'sub-sub-list'=>  array( 
                            //                       array(
                            //                             'title'=> __('Dashboard-1','BMW'),
                            //                             'link'=>'',
                            //                             ),
                            //                         array(
                            //                         'title'=> __('Dashboard-2','BMW'),
                            //                         'link'=>''
                            //                         )
                            //                     )
                             ),
                            array(
                            'title'=> __('Referral Commission','BMW'),
                            'link'=> get_url_bmw('payout_list').'?section=ref_commission'
                            ),
                            array(
                            'title'=> __('Leadership Commission','BMW'),
                            'link'=> get_url_bmw('payout_list').'?section=leadership_commission'
                            ),
                            array(
                            'title'=> __('FastStart Details','BMW'),
                            'link'=>get_url_bmw('payout_list').'?section=faststart_commision'
                            ),
                          )
        );

  $menu_array[]=array(
        'icon'=> 'fa fa-user',
        'title'=> __('Acount Details','BMW'),
        'link'=> '',
        'sub-list'=> array(
                            array(
                            'title'=> __('Personal Info','BMW'),
                            'link'=>get_url_bmw('personal_info')
                            ),
                            array(
                            'title'=> __('Bank Details','BMW'),
                            'link'=>get_url_bmw('bank_details')
                            ),
                          )
      );
  $menu_array[]=array(
        'icon'=> 'fa fa-bank',
        'title'=> __('Withdraw Amount','BMW'),
        'link'=> get_url_bmw('withdrawal_amount'),
      );
  $woosetting=get_option('bmw_woo_wallet_setting');
  if(isset($woosetting['bmw_woo_wallet_status']) && $woosetting['bmw_woo_wallet_status']==1 && isset($woosetting['bmw_woo_wallet_show_menu']) && $woosetting['bmw_woo_wallet_show_menu']==1)
  {
    $menu_array[]=array(
        'icon'=> '',
        'svg' =>'<svg xmlns="http://www.w3.org/2000/svg" height="18px" viewBox="0 0 512 512" width="18px" class=""><g><g><g><g><path d="m432 328v48h32v112h-408a40 40 0 0 1 -40-40v-272a40 40 0 0 0 40 40h408v112z" fill="#57565c" data-original="#57565C" class="active-path" style="fill:#E3E9ED" data-old_color="#57565c"/><path d="m432 136v80h-376a40 40 0 0 1 0-80z" fill="#2d2d30" data-original="#2D2D30" class="" style="fill:#838383" data-old_color="#2d2d30"/><path d="m496 344v16a16 16 0 0 1 -16 16h-48v-48h48a16 16 0 0 1 16 16z" fill="#ffda44" data-original="#FFDA44" class=""/></g><path d="m128 24h192v192h-192z" fill="#91cc04" data-original="#91CC04" class=""/><path d="m320 24h48v192h-48z" fill="#4e901e" data-original="#4E901E" class=""/><path d="m296 72v144h-144v-144a24.006 24.006 0 0 0 24-24h96a24.006 24.006 0 0 0 24 24z" fill="#4e901e" data-original="#4E901E" class=""/><circle cx="224" cy="104" fill="#ffda44" r="24" data-original="#FFDA44" class=""/><path d="m184 152h80v64h-80z" fill="#ffda44" data-original="#FFDA44" class=""/><circle cx="244" cy="348" fill="#ff9811" r="100" data-original="#FF9811" class=""/><circle cx="244" cy="348" fill="#ffda44" r="76" data-original="#FFDA44" class=""/></g><g><path d="m480 320h-8v-104a8 8 0 0 0 -8-8h-24v-72a8 8 0 0 0 -8-8h-56v-104a8 8 0 0 0 -8-8h-240a8 8 0 0 0 -8 8v104h-64a48.051 48.051 0 0 0 -48 48v272a48.051 48.051 0 0 0 48 48h408a8 8 0 0 0 8-8v-104h8a24.032 24.032 0 0 0 24-24v-16a24.032 24.032 0 0 0 -24-24zm-104-176h48v64h-48zm-48-112h8v128a8 8 0 0 0 16 0v-128h8v176h-32zm-192 0h176v176h-8v-136a8 8 0 0 0 -8-8 16.021 16.021 0 0 1 -16-16 8 8 0 0 0 -8-8h-96a8 8 0 0 0 -8 8 16.021 16.021 0 0 1 -16 16 8 8 0 0 0 -8 8v136h-8zm128 112h-80a8 8 0 0 0 -8 8v56h-16v-129.01a32.12 32.12 0 0 0 22.99-22.99h82.02a32.12 32.12 0 0 0 22.99 22.99v129.01h-16v-56a8 8 0 0 0 -8-8zm-8 16v48h-64v-48zm-200-16h64v64h-64a32 32 0 0 1 0-64zm400 336h-400a32.03 32.03 0 0 1 -32-32v-236.26a47.8 47.8 0 0 0 32 12.26h400v96h-24a8 8 0 0 0 -8 8v48a8 8 0 0 0 8 8h24zm32-120a8.011 8.011 0 0 1 -8 8h-40v-32h40a8.011 8.011 0 0 1 8 8z" data-original="#000000" class="" style="fill:#FFFFFF" data-old_color="#000000"/><path d="m432 448h-120a8 8 0 0 0 0 16h120a8 8 0 0 0 0-16z" data-original="#000000" class="" style="fill:#FFFFFF" data-old_color="#000000"/><path d="m400 424a8 8 0 0 0 0 16h32a8 8 0 0 0 0-16z" data-original="#000000" class="" style="fill:#FFFFFF" data-old_color="#000000"/><path d="m224 72a32 32 0 1 0 32 32 32.036 32.036 0 0 0 -32-32zm0 48a16 16 0 1 1 16-16 16.019 16.019 0 0 1 -16 16z" data-original="#000000" class="" style="fill:#FFFFFF" data-old_color="#000000"/><path d="m244 264a84 84 0 1 0 84 84 84.092 84.092 0 0 0 -84-84zm0 152a68 68 0 1 1 68-68 68.071 68.071 0 0 1 -68 68z" data-original="#000000" class="" style="fill:#FFFFFF" data-old_color="#000000"/><path d="m244 240a108 108 0 1 0 108 108 108.124 108.124 0 0 0 -108-108zm0 200a92 92 0 1 1 92-92 92.1 92.1 0 0 1 -92 92z" data-original="#000000" class="" style="fill:#FFFFFF" data-old_color="#000000"/><path d="m268.9 339.78a23.986 23.986 0 0 0 -20.9-35.78h-24a8 8 0 0 0 0 16v16a8 8 0 0 0 0 16v24a8 8 0 0 0 0 16h32a24.032 24.032 0 0 0 24-24v-8a23.985 23.985 0 0 0 -11.1-20.22zm-28.9-19.78h8a8 8 0 0 1 0 16h-8zm24 48a8.011 8.011 0 0 1 -8 8h-16v-24h16a8.011 8.011 0 0 1 8 8z" data-original="#000000" class="" style="fill:#FFFFFF" data-old_color="#000000"/><path d="m344 176a8 8 0 0 0 -8 8v8a8 8 0 0 0 16 0v-8a8 8 0 0 0 -8-8z" data-original="#000000" class="" style="fill:#FFFFFF" data-old_color="#000000"/></g></g></g> </svg>',
        'title'=> __('Woo Wallet','BMW'),
        'link'=> get_url_bmw('tera_wallet'),
      );
  }

  $mycredsetting=get_option('bmw_mycred_setting');
  if(isset($mycredsetting['bmw_mycred_status']) && $mycredsetting['bmw_mycred_status']==1 && isset($mycredsetting['bmw_mycred_show_menu']) && $mycredsetting['bmw_mycred_show_menu']==1)
  {
    $menu_array[]=array(
        'icon'=> '',
        'svg' =>'<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve" width="18px" height="18px" class=""><g><path style="fill:#EB7D16" d="M403.525,216.949H65.085c-14.379,0-26.034-11.655-26.034-26.034  c0-14.379,11.655-26.034,26.034-26.034h338.441V216.949z" data-original="#0071BC" class="active-path" data-old_color="#0071BC"/><circle style="fill:#FED856;" cx="247.322" cy="173.559" r="95.458" data-original="#FED856" class=""/><path style="fill:#FFFFFF" d="M39.051,269.017v216.949c0,14.379,11.655,26.034,26.034,26.034l0,0h381.831V216.949H65.085  c-14.379,0-26.034-11.655-26.034-26.034V269.017z" data-original="#29ABE2" class="" data-old_color="#29ABE2"/><g><path style="fill:#CD9829;" d="M238.644,17.356H256v52.068h-17.356V17.356z" data-original="#CD9829" class=""/><path style="fill:#CD9829;" d="M273.356,52.068h17.356V84.61h-17.356V52.068z" data-original="#CD9829" class=""/><path style="fill:#CD9829;" d="M203.932,34.712h17.356V84.61h-17.356V34.712z" data-original="#CD9829" class=""/></g><path style="fill:#EB7D16" d="M420.881,312.407h34.712c9.589,0,17.356,7.767,17.356,17.356v69.424  c0,9.589-7.767,17.356-17.356,17.356H325.424c-28.759,0-52.068-23.309-52.068-52.068c0-28.759,23.309-52.068,52.068-52.068H420.881z  " data-original="#0071BC" class="active-path" data-old_color="#0071BC"/><path style="fill:#FFE529" d="M65.085,216.949h17.356V512H65.085V216.949z" data-original="#FBB03B" class="" data-old_color="#FBB03B"/><g><path style="fill:#CD9829;" d="M273.356,17.356h17.356v17.356h-17.356V17.356z" data-original="#CD9829" class=""/><path style="fill:#CD9829;" d="M203.932,0h17.356v17.356h-17.356V0z" data-original="#CD9829" class=""/></g><circle style="fill:#FFE529" cx="325.424" cy="364.475" r="17.356" data-original="#FBB03B" class="" data-old_color="#FBB03B"/><g><path style="fill:#CD9829;" d="M256,131.428v-9.936h-17.356v9.936c-13.017,4.053-20.28,17.885-16.236,30.894   c2.005,6.43,6.543,11.767,12.574,14.77l16.913,8.461c3.662,1.831,5.146,6.283,3.315,9.945c-1.25,2.508-3.818,4.096-6.621,4.096   h-2.534c-4.087-0.009-7.402-3.324-7.411-7.411v-1.267h-17.356v1.267c0.017,13.676,11.09,24.75,24.767,24.767h2.534   c13.676,0,24.767-11.09,24.767-24.767c0-9.381-5.302-17.963-13.694-22.155l-16.913-8.461c-3.662-1.831-5.146-6.283-3.315-9.945   c1.25-2.508,3.818-4.096,6.621-4.096h2.534c4.087,0.009,7.402,3.324,7.411,7.411v1.267h17.356v-1.267   C273.313,144.15,266.292,134.639,256,131.428z" data-original="#CD9829" class=""/><path style="fill:#CD9829;" d="M290.712,164.881h17.356v17.356h-17.356V164.881z" data-original="#CD9829" class=""/><path style="fill:#CD9829;" d="M186.576,164.881h17.356v17.356h-17.356V164.881z" data-original="#CD9829" class=""/></g></g></svg>',
        'title'=> __('MyCred Wallet','BMW'),
        'link'=> get_url_bmw('mycred_wallet'),
        
        );
  }
  $menu_array[]=array(
        'icon'=> 'fa fa-sign-in',
        'title'=> __('Registration','BMW'),
        'link'=> get_url_bmw('register'),
      );
  $menu_array[]=array(
        'icon'=> 'fa fa-thumbs-o-up',
        'title'=> __('Join Us','BMW'),
        'link'=> get_url_bmw('join_network'),
      );
  $menu_array[]=array(
        'icon'=> 'fa fa-share',
        'title'=> __('Send Invitation','BMW'),
        'link'=>  get_url_bmw('invitation'),
      );
  $menu_array[]=array(
    'icon'=> '',
    'svg'=> '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 480 480" style="enable-background:new 0 0 480 480;" xml:space="preserve" width="18px" height="18px" class="hovered-paths"><g><path style="fill:#FFFFFF" d="M264,468h208V4H264v120" data-original="#006E34" class="" data-old_color="#006E34"/><path style="fill:#FFFFFF" d="M277.896,234.656c-4.796-9.832-16.654-13.915-26.487-9.12c-0.07,0.034-0.14,0.069-0.209,0.104  l-35.28,17.864l-2.264,0.176l-19.904-33.6c25.877,0.228,47.039-20.564,47.268-46.441s-20.564-47.039-46.441-47.268  s-47.039,20.564-47.268,46.441c-0.107,12.164,4.52,23.894,12.905,32.708l-12.904-5.6l-66.848,28.216  c-6.076,2.391-10.611,7.585-12.16,13.928l-13.272,53.76c-2.703,10.743,3.76,21.656,14.48,24.448  c10.649,2.654,21.434-3.827,24.088-14.476c0.016-0.065,0.032-0.131,0.048-0.196l10.76-43.6l36.272-15.048l-13.264,73.92  L80.072,363.92l-39.064-34.616c-8.13-7.24-20.59-6.52-27.83,1.61c-0.084,0.094-0.167,0.19-0.25,0.286  c-7.24,8.406-6.407,21.063,1.872,28.448l53.072,47.04c7.859,7.002,19.832,6.597,27.2-0.92l55.328-56.072l48.048,29.208  l30.576,61.944c3.327,6.809,10.237,11.135,17.816,11.152c3.09-0.002,6.135-0.734,8.888-2.136c9.856-5.072,13.82-17.113,8.904-27.048  l-33.176-67.2c-1.686-3.418-4.307-6.286-7.56-8.272l-54.04-32.8L181.12,263.2l8.096,16.408c3.33,6.807,10.238,11.131,17.816,11.152  c3.09-0.001,6.135-0.733,8.888-2.136l53.072-26.88C278.875,256.674,282.843,244.6,277.896,234.656L277.896,234.656z" data-original="#009245" class="" data-old_color="#009245"/><path style="fill:#000000;" d="M423.384,247.056c0.809-1.957,0.809-4.155,0-6.112c-0.399-0.976-0.989-1.863-1.736-2.608l-32-32  c-3.178-3.07-8.242-2.982-11.312,0.196c-2.994,3.1-2.994,8.015,0,11.116L396.688,236H312c-4.418,0-8,3.582-8,8s3.582,8,8,8h84.688  l-18.344,18.344c-3.178,3.07-3.266,8.134-0.196,11.312c3.07,3.178,8.134,3.266,11.312,0.196c0.066-0.064,0.132-0.129,0.196-0.196  l32-32C422.399,248.913,422.986,248.029,423.384,247.056z" data-original="#F2F2F2" class=""/><path style="fill:#FFFFFF" d="M472,476H8c-4.418,0-8-3.582-8-8s3.582-8,8-8h464c4.418,0,8,3.582,8,8S476.418,476,472,476z" data-original="#333333" class="hovered-path active-path" data-old_color="#333333"/></g> </svg>',
    'title'=> __('Log-out','BMW'),
    'link'=>  wp_logout_url(),
  );
  return $menu_array;
}

function side_menu_dynamic_html($menu_array)
{
  $menu_html='';
  if(!empty($menu_array))
  {
    foreach ($menu_array as $key => $menu_item) {
      if(isset($menu_item['link']) && !empty($menu_item['link'])) { $menu_link=$menu_item['link'];  }else{ $menu_link='javascript:void(0)';  }
      if(isset($menu_item['title']) && !empty($menu_item['title'])) { $menu_title=$menu_item['title'];  }else{ $menu_title='';  }
      if(isset($menu_item['icon']) && !empty($menu_item['icon'])) { $menu_icon='<i class="'.$menu_item['icon'].'"></i>&nbsp;';  }else  if(isset($menu_item['svg']) && !empty($menu_item['svg'])) { $menu_icon=$menu_item['svg'].'&nbsp;';  }else{ $menu_icon=''; }
  
    $menu_html.='<li><a href="'.$menu_link.'">'.$menu_icon.$menu_title;
    if(isset($menu_item['sub-list']) &&  !empty($menu_item['sub-list']))
    {
      $menu_html.='<span class="fa fa-chevron-down"></span></a><ul class="let-nav let-child_menu">';
      foreach ($menu_item['sub-list'] as $key => $sub_item) { 
      if(isset($sub_item['link']) && !empty($sub_item['link'])) { $sub_link=$sub_item['link'];  }else{ $sub_link='javascript:void(0)';  }
      if(isset($sub_item['title']) && !empty($sub_item['title'])) { $sub_title=$sub_item['title'];  }else{ $sub_title='';  }
        $menu_html.='<li><a href="'.$sub_link.'">'.$sub_title;
              if(isset($sub_item['sub-sub-list']) && !empty($sub_item['sub-sub-list'])){
              $menu_html.='<span class="fa fa-chevron-down"></span></a><ul class="let-nav let-child_menu">';
              foreach ($sub_item['sub-sub-list'] as $key => $child_sub_item) {
                if(isset($child_sub_item['link']) && !empty($child_sub_item['link'])) { $sub_sub_link=$child_sub_item['link'];  }else{ $sub_sub_link='javascript:void(0)';  }
                if(isset($child_sub_item['title']) && !empty($child_sub_item['title'])) { $sub_sub_title=$child_sub_item['title'];  }else{ $sub_sub_title='';  }
                $menu_html.='<li><a href="'.$sub_sub_link.'">'.$sub_sub_title.'</a></li>';
              }
              $menu_html.='</ul></li>';
              }else{
              $menu_html.='</a></li>';
              }
        }
        $menu_html.='</ul></li>';
      }else{

        $menu_html.='</a>';
      }
        $menu_html.='</li>';
    
    }
  }
  return $menu_html;
}












///////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////Profile   Functions ///////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////




function bmw_update_profile_picture_function()
{
  global $wpdb,$current_user;
  $return=array();
  $return['status']=false;
   add_filter( 'upload_dir', 'bmw_change_files_dir' );     
    if( isset($_FILES['profile_picture']) && $_FILES['profile_picture'] ) {
      $profile=$_FILES['profile_picture'];
      $picture_name=bmw_get_user_key_by_user_id($current_user->ID).'-'.date_i18n('dmY-his').'.'.pathinfo($profile['name'], PATHINFO_EXTENSION);
        $profile['name'] = $picture_name;
        $upload_overrides = array( 'test_form' => false );
        $upload_result = wp_handle_upload($profile, $upload_overrides);
        if(file_exists($upload_result['file']))
        {
          $exist_file=get_user_meta($current_user->ID,'profile_picture_file',true);
          if(isset($exist_file) && !empty($exist_file))
          {
            wp_delete_file( ABSPATH.'wp-content/uploads/bmp-uploads/'.$exist_file);
          }
          update_user_meta($current_user->ID,'profile_picture_file',$picture_name);
          $pic=ABSPATH.'wp-content/uploads/bmp-uploads/'.$picture_name;
          $image = wp_get_image_editor($pic);
          if ( ! is_wp_error( $image ) ) {
              $image->resize( 300, 300, true );
              $image->save($pic);
          }

          remove_filter( 'upload_dir', 'bmw_change_files_dir' );
         $return['profile']=bmw_uploads_dir().$picture_name;
         $return['status']=true;
        }else{
          remove_filter( 'upload_dir', 'bmw_change_files_dir' );
        }
       }
      echo json_encode($return);
      wp_die();
}

 function bmw_change_files_dir( $dirs ) {
      if (!file_exists(ABSPATH.'wp-content/uploads/bmw-uploads')) {
            mkdir(ABSPATH.'wp-content/uploads/bmw-uploads', 0777, true);
        }
        $dirs['subdir']   =  ABSPATH.'wp-content/uploads/bmw-uploads';
        $dirs['path']     =  ABSPATH.'wp-content/uploads/bmw-uploads';
        $dirs['url']      =  ABSPATH.'wp-content/uploads/bmw-uploads';
        $dirs['basedir']  =  ABSPATH.'wp-content/uploads/bmw-uploads';
        $dirs['baseurl']  =  ABSPATH.'wp-content/uploads/bmw-uploads';
        return $dirs;
}
function bmw_uploads_dir()
{
  return wp_upload_dir()['baseurl'].'/bmw-uploads/';
}
function bmw_get_profile_picture($user_id)
{
  global $wpdb;
  $profile_picture=get_user_meta($user_id,'profile_picture_file',true);
  if(isset($profile_picture) && !empty($profile_picture))
  {
  return wp_upload_dir()['baseurl'].'/bmw-uploads/'.$profile_picture;
  }else{
    $status=$wpdb->get_var("SELECT payment_status FROM {$wpdb->prefix}bmw_users WHERE user_id='".$user_id."'");
    if($status==1){
    return BMW()->plugin_url().'/image/user_paid.png';
    }else{
    return BMW()->plugin_url().'/image/user.png';
    }
  }
}










///////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////Genealogy   Functions ///////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////





function bmw_get_all_members_array()
{
  global $wpdb,$current_user;
  $members=array();
  $childs_array=array();
  $is_admin=false;
  if(isset($current_user->caps['bmw_user']) && $current_user->caps['bmw_user']==1) {
  $user_key=bmw_get_current_user_key();
  $root_user=$wpdb->get_row("SELECT *,(SELECT up.user_name FROM {$wpdb->prefix}bmw_users up WHERE u.parent_key=up.user_key) as parent,(SELECT us.user_name FROM {$wpdb->prefix}bmw_users as us WHERE u.sponsor_key=us.user_key) as sponsor, (SELECT SUM(p.total_amount) FROM {$wpdb->prefix}bmw_payout as p WHERE p.user_key=u.user_key) as total_earning, (SELECT SUM(w.amount) FROM {$wpdb->prefix}bmw_withdrawal as w WHERE w.user_id=u.user_id) as total_with,(SELECT COUNT(*) FROM {$wpdb->prefix}bmw_users as ur WHERE ur.sponsor_key=u.user_key and u.user_key='".$user_key."') as downlines  FROM {$wpdb->prefix}bmw_users as u WHERE u.user_key='".$user_key."' ORDER BY u.position DESC LIMIT 1");
   
}else if(isset($current_user->caps['administrator']) && $current_user->caps['administrator']==1) {
  $is_admin=true;
  $root_key=bmw_get_top_user_key();
   $root_user=$wpdb->get_row("SELECT *,(SELECT up.user_name FROM {$wpdb->prefix}bmw_users up WHERE u.parent_key=up.user_key) as parent,(SELECT us.user_name FROM {$wpdb->prefix}bmw_users as us WHERE u.sponsor_key=us.user_key) as sponsor, (SELECT SUM(p.total_amount) FROM {$wpdb->prefix}bmw_payout as p WHERE p.user_key=u.user_key) as total_earning, (SELECT SUM(w.amount) FROM {$wpdb->prefix}bmw_withdrawal as w WHERE w.user_id=u.user_id) as total_with,(SELECT COUNT(*) FROM {$wpdb->prefix}bmw_users as ur WHERE ur.sponsor_key=u.user_key AND u.user_key='".$root_key."') as downlines  FROM {$wpdb->prefix}bmw_users as u WHERE  u.parent_key='0' AND u.sponsor_key='0' LIMIT 1");
   
}
   $earning=$root_user->total_earning-$root_user->total_with;
     $links= bmw_get_user_add_link($root_user->user_id,$root_user->user_key);
  $members=array(
            "name"=>$root_user->user_name,
            "imageUrl"=> bmw_get_profile_picture($root_user->user_id),
            "userData"=>array(
                      'sponsor'       =>  ($root_user->sponsor)?ucwords($root_user->sponsor):__('No','BMW'),
                      'parent'        =>  ($root_user->parent)?ucwords($root_user->parent):__('No','BMW'),
                      'position'      =>  ucwords($root_user->position),
                      'total_earning' =>  ($earning)?str_replace('.00','',bmw_price(round($earning))).'<sup>+</sup>':bmw_price(0),
                      'total_widral'  =>  ($root_user->total_with)?str_replace('.00','',bmw_price(round($root_user->total_with))).'<sup>+</sup>':bmw_price(0),
                      'downlines'     =>  $root_user->downlines,
                      'is_admin'      =>  $is_admin,
                      'left_link'      =>  $links->left_link,
                      'right_link'      => $links->right_link
                      ),
            "profileUrl"=>admin_url().'admin.php?page=bmp-user-reports&user_id='.$root_user->user_id.'&user_key='.$root_user->user_key,
            "isLoggedUser"=>($current_user->ID==$root_user->user_id)?true:false,
            "userKey"=>$root_user->user_key,
            "children"=>bmw_get_childs_data($root_user->user_key,$childs_array, $is_admin)
          );
return $members;
}

function bmw_get_childs_data($user_key,$childs_array=array(),$is_admin=NULL)
{

  global $wpdb;

  $user_childs=$wpdb->get_results("SELECT *,(SELECT up.user_name FROM {$wpdb->prefix}bmw_users up WHERE u.parent_key=up.user_key) as parent,(SELECT us.user_name FROM {$wpdb->prefix}bmw_users as us WHERE u.sponsor_key=us.user_key) as sponsor, (SELECT SUM(p.total_amount) FROM {$wpdb->prefix}bmw_payout as p WHERE p.user_key=u.user_key) as total_earning, (SELECT SUM(w.amount) FROM {$wpdb->prefix}bmw_withdrawal as w WHERE w.user_id=u.user_id) as total_with,(SELECT COUNT(*) FROM {$wpdb->prefix}bmw_users as ur WHERE ur.sponsor_key=u.user_key) as downlines  FROM {$wpdb->prefix}bmw_users as u WHERE u.parent_key='".$user_key."' ORDER BY u.position DESC");
  if(!empty($user_childs))
  {
    foreach ($user_childs as $keys => $child) {
      $earning=$child->total_earning-$child->total_with;
      $links= bmw_get_user_add_link($child->user_id,$child->user_key);
        $childs_array[$keys]=array("name"=>$child->user_name,
                "imageUrl"=> bmw_get_profile_picture($child->user_id),
                "userData"=>array(
                            'sponsor'       =>  ucwords($child->sponsor),
                            'parent'        =>  ucwords($child->parent),
                            'position'      =>  ucwords($child->position),
                            'total_earning' =>  ($earning)?str_replace('.00','',bmw_price(round($earning))).'<sup>+</sup>':bmw_price(0),
                            'total_widral'  =>  ($child->total_with)?str_replace('.00','',bmw_price(round($child->total_with))).'<sup>+</sup>':bmw_price(0),
                            'downlines'     =>  $child->downlines,
                            'is_admin'      =>   $is_admin,
                            'left_link'      =>  $links->left_link,
                            'right_link'      =>  $links->right_link
                ),
                "profileUrl"=>admin_url().'admin.php?page=bmp-user-reports&user_id='.$child->user_id.'&user_key='.$child->user_key,
                "isLoggedUser"=>false,
                "userKey"=>$child->user_key,
                "children"=>bmw_get_childs_data($child->user_key,$childs_array,$is_admin)
              );
        }
  }else{
    $childs_array='';
  }
return $childs_array;
}

function bmw_get_user_add_link($user_id,$user_key)
{
  global $wpdb;
  $links=array();
  $positions=$wpdb->get_results("SELECT position FROM {$wpdb->prefix}bmw_users WHERE parent_key='".$user_key."'");
  if(empty($positions))
  {
    $links['left_link']=get_url_bmw('register').'?parent='.$user_id.'&leg=left';
    $links['right_link']=get_url_bmw('register').'?parent='.$user_id.'&leg=right';
  }else if(COUNT($positions)==1)
  {
    foreach ($positions as $key => $position) {
     if($position->position=='left')
     {
      $links['left_link']=false;
      $links['right_link']=get_url_bmw('register').'?parent='.$user_id.'&leg=right';
     }else{
      $links['left_link']=get_url_bmw('register').'?parent='.$user_id.'&leg=left';
      $links['right_link']=false;
     }
    }
    
  }else{
    $links['left_link']=false;
    $links['right_link']=false;
  }
 return (object)$links;

}










///////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////Registration  Functions ///////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////


function bmw_front_register_function()
{
  global $wpdb;
  $bmw_general_setting=get_option('bmw_manage_general');
  $jsonarray=array();
  $jsonarray['status']=true;
  $firstname = sanitize_text_field( $_POST['bmw_first_name'] );
    $lastname = sanitize_text_field( $_POST['bmw_last_name'] );
    $username = sanitize_text_field( $_POST['bmw_username'] );
    $password = sanitize_text_field( $_POST['bmw_password'] );
    $confirm_password = sanitize_text_field( $_POST['bmw_confirm_password'] );
    $email = sanitize_text_field( $_POST['bmw_email'] );
    $sponsor = sanitize_text_field( $_POST['bmw_sponsor_id'] );
    $telephone = sanitize_text_field( $_POST['bmw_phone'] );
    $position = sanitize_text_field( $_POST['bmw_position'] );
    $parent = sanitize_text_field( $_POST['bmw_parent'] );
    if(empty($firstname)){
      $jsonarray['error']['bmw_first_name_message']= __('First Name could Not be empty','BMW');
      $jsonarray['status']=false;
    }
    if(empty($lastname)){
      $jsonarray['error']['bmw_last_name_message']= __('Last Name could Not be empty','BMW');
      $jsonarray['status']=false;
    }

    if(empty($username)){
      $jsonarray['error']['bmw_username_message']= __('Userame could Not be empty','BMW');
      $jsonarray['status']=false;
    }

    if($password!=$confirm_password){
      $jsonarray['error']['bmw_confirm_password_message']= __('Sorry Password does not match.','BMW');
      $jsonarray['status']=false;
    }

    if(empty($email)){
      $jsonarray['error']['bmw_email_message']= __('Email could Not be empty','BMW');
      $jsonarray['status']=false;
    } else if (!is_email($email)){
          $jsonarray['error']['bmw_email_message'] = __("E-mail address is invalid.",'BMW');
          $jsonarray['status']=false;
    } else if (email_exists($email)){
          $jsonarray['error']['bmw_email_message'] = __("E-mail address is already in use.",'BMW');
          $jsonarray['status']=false;
    }

    if(empty($sponsor)){
      $jsonarray['error']['bmw_sponsor_message']= __('Sponsor could Not be empty','BMW');
      $jsonarray['status']=false;
    }
    if(empty($parent)){
      $jsonarray['error']['bmw_parent_message']= __('Parent could Not be empty','BMW');
      $jsonarray['status']=false;
    }

    if(empty($telephone)){
      $jsonarray['error']['bmw_phone_message']= __('Phone could Not be empty','BMW');
      $jsonarray['status']=false;
    }else  if(isset($bmw_general_setting['bmw_otp_verification']) && $bmw_general_setting['bmw_otp_verification']==1){
     if(!isset($_SESSION['number_verified']) || $_SESSION['number_verified']!=true || !isset($_SESSION['usr_phone']) ||  $_SESSION['usr_phone']!=$telephone)
    {
      $jsonarray['error']['bmw_phone_message']= __('Phone number is not verified','BMW');
      $jsonarray['status']=false;
    }
}
    if(!isset($position) || empty($position)){
      $jsonarray['error']['bmw_position_message']= __('Position could Not be empty','BMW');
      $jsonarray['status']=false;
    }



   if(!empty($sponsor) && !empty($parent))
    {
      $parent_key=bmw_get_userkey_by_username($parent);
      $sponsor_key=bmw_get_userkey_by_username($sponsor);
      $childs=$wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}bmw_users WHERE parent_key = '".$parent_key."'");
      if(!check_parent_network($parent_key,$sponsor_key,$childs))
      {
        $jsonarray['error']['bmw_position_message']= __('Something going wrong please check!!!','BMW');
        $jsonarray['status']=false;
      }
      
    }

    if(empty($jsonarray['error'])){

      $user_key=bmw_generateKey();
      $user = array
          (
            'user_login' => $username,
            'user_pass' => $password,
            'first_name' => $firstname,
            'last_name' => $lastname,
            'user_email' => $email
          );

          $user_id = wp_insert_user($user);
          $user = new WP_User( $user_id );
          $user->set_role( 'bmw_user' );
          add_user_meta( $user_id, 'bmw_first_name', $firstname );
          add_user_meta( $user_id, 'billing_first_name', $firstname );
          add_user_meta( $user_id, 'bmw_last_name', $lastname );
          add_user_meta( $user_id, 'billing_last_name', $lastname );
          add_user_meta( $user_id, 'bmw_phone', $telephone );
          add_user_meta( $user_id, 'billing_phone', $telephone );

          //wp_new_user_notification($user_id, $password);
  
  //  $sponsor_key=bmw_get_user_key_by_user_id($sponsor);
    $levels=get_option('bmw_level_settings');
    $parent_row=get_network_row_by_key($parent_key);
    $n_row=$parent_row+1;
      //insert the data into wp_bmw_user table
          $insert = "INSERT INTO {$wpdb->prefix}bmw_users (user_id, user_name, user_key, parent_key, sponsor_key, position,creation_date,network_row)
          VALUES('".$user_id."','".$username."', '".$user_key."', '".$parent_key."', '".$sponsor_key."', '".$position."', '".date_i18n('Y-m-d H:i:s')."','".$n_row."')";
          if($wpdb->query($insert))
          {
            //entry on Left and Right Leg tables
            if($position=='left')
            {
              $wpdb->query("INSERT INTO {$wpdb->prefix}bmw_hierarchy SET user_key='".$user_key."', parent_key='".$parent_key."', sponsor_key='".$sponsor_key."',position='0', n_row='".$n_row."'");
            }
            else if($position=='right')
            {
             $wpdb->query("INSERT INTO {$wpdb->prefix}bmw_hierarchy SET user_key='".$user_key."', parent_key='".$parent_key."', sponsor_key='".$sponsor_key."',position='1', n_row='".$n_row."'");
            }
      
      while($parent_key!='0')
            {
              $result = $wpdb->get_row("SELECT COUNT(*) as num, parent_key, position FROM {$wpdb->prefix}bmw_users WHERE user_key = '".$parent_key."'");
              if($result->num==1)
              {
                if($result->parent_key!='0')
                {
                  if($result->position=='right')
                  {
                     $wpdb->query("INSERT INTO {$wpdb->prefix}bmw_hierarchy SET user_key='".$user_key."', parent_key='".$result->parent_key."', sponsor_key='".$sponsor_key."',position='1',  n_row='".$n_row."'");
                  }
                  else
                  {
                    $wpdb->query("INSERT INTO {$wpdb->prefix}bmw_hierarchy SET user_key='".$user_key."', parent_key='".$result->parent_key."', sponsor_key='".$sponsor_key."',position='0',  n_row='".$n_row."'");
                  }
                }
                $parent_key = $result->parent_key;
              }
              else
              {
                $parent_key = '0';
              }
            }
            do_action('bmw_after_registration_action',$user_id);
          }
              if (!is_user_logged_in()) {
                  wp_set_current_user($user_id, $username);
                  wp_set_auth_cookie($user_id);
                  // do_action('wp_login', $username);
                  }
          $jsonarray['status']=true;
          $jsonarray['message']=__('Binary User has been created successfully.','BMW');
    }

    echo json_encode($jsonarray);
  wp_die();
}

function bmw_front_join_network_function()
{
global $wpdb,$current_user;
  $bmw_general_setting=get_option('bmw_manage_general');
  $json=array();
  $json['status']=true;


    $sponsor_key  = bmw_get_userkey_by_username(sanitize_text_field( $_POST['bmw_sponsor_id'] ));
    $parent_key   = bmw_get_userkey_by_username(sanitize_text_field( $_POST['bmw_parent']));
    $username=$current_user->user_login;
    $position = sanitize_text_field($_POST['bmw_position']);  

     if(empty($sponsor_key)){
      $json['error']['bmw_sponsor_message']= __('Sponsor could Not be empty','BMW');
      $json['status']=false;
    }
     if(empty($parent_key)){
      $json['error']['bmw_parent_message']= __('Parent could Not be empty','BMW');
      $json['status']=false;
    }
    if(empty($position)){
      $json['error']['bmw_position_message']= __('Position could Not be empty','BMW');
      $json['status']=false;
    }
   

    if(!empty($sponsor_key) && !empty($parent_key))
    {
      $childs=$wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}bmw_users WHERE parent_key = '".$parent_key."'");
         $position_exist=$wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}bmw_users WHERE parent_key = '".$parent_key."' AND position='".$position."'");
      if(!check_parent_network($parent_key,$sponsor_key,$childs) && !empty($position_exist))
      {
        $jsonarray['error']['bmw_position_message']= __('Something going wrong please check!!!','BMW');
        $jsonarray['status']=false;
      }
      
    }
    if(empty($json['error'])){

        $user_id = $current_user->ID;


      $user_key=bmw_generateKey();
     
    $levels=get_option('bmw_level_settings');
    $parent_row=get_network_row_by_key($parent_key);
    $n_row=$parent_row+1;
      //insert the data into wp_bmw_user table
          $insert = "INSERT INTO {$wpdb->prefix}bmw_users (user_id, user_name, user_key, parent_key, sponsor_key, position,payment_date,network_row)
          VALUES('".$user_id."','".$username."', '".$user_key."', '".$parent_key."', '".$sponsor_key."', '".$position."','".date_i18n('Y-m-d H:i:s')."','".$n_row."')";
          
          if($wpdb->query($insert))
          {
            $user=get_user_by('id',$user_id);
            $user->set_role( 'bmw_user' );
           
            //entry on Left and Right Leg tables
            if($position=='left')
            {
              $wpdb->query("INSERT INTO {$wpdb->prefix}bmw_hierarchy SET user_key='".$user_key."', parent_key='".$parent_key."', sponsor_key='".$sponsor_key."',position='0', n_row='".$n_row."'");
            }
            else if($position=='right')
            {
             $wpdb->query("INSERT INTO {$wpdb->prefix}bmw_hierarchy SET user_key='".$user_key."', parent_key='".$parent_key."', sponsor_key='".$sponsor_key."',position='1', n_row='".$n_row."'");
            }
      
      while($parent_key!='0')
            {
              $result = $wpdb->get_row("SELECT COUNT(*) as num, parent_key, position FROM {$wpdb->prefix}bmw_users WHERE user_key = '".$parent_key."'");
              if($result->num==1)
              {
                if($result->parent_key!='0')
                {
                  if($result->position=='right')
                  {
                     $wpdb->query("INSERT INTO {$wpdb->prefix}bmw_hierarchy SET user_key='".$user_key."', parent_key='".$result->parent_key."', sponsor_key='".$sponsor_key."',position='1',  n_row='".$n_row."'");
                  }
                  else
                  {
                    $wpdb->query("INSERT INTO {$wpdb->prefix}bmw_hierarchy SET user_key='".$user_key."', parent_key='".$result->parent_key."', sponsor_key='".$sponsor_key."',position='0',  n_row='".$n_row."'");
                  }
                }
                $parent_key = $result->parent_key;
              }
              else
              {
                $parent_key = '0';
              }
            }
             do_action('bmw_after_join_action',$user_id);
          }
          $json['status']=true;
          $json['message']=__('Binary User has been created successfully.','BMW');
    }
     echo json_encode($json);
     wp_die();
}


//////////////. user name exist ////////////////

function bmw_username_exist_function()
{
  global $wpdb;

  $json=array();
  $json['status']=false;
  $username=sanitize_text_field($_POST['username']);

  $bmw_user=$wpdb->get_row("SELECT * FROM {$wpdb->prefix}bmw_users WHERE user_name='".$username."'");
  
  if(!empty($bmw_user)){
    $json['status']=false;
    $json['message']='<span class="let-text-danger">'.__('User Already Exist. Please try another user','BMW').'</span>';
  } elseif(empty($username)){
    $json['status']=false;
    $json['message']='<span class="let-text-danger">'.__('User Name could not be empty.','BMW').'</span>';
  } 
  else{
    $json['status']=true;
    $json['message']='<span class="let-text-success">'.__('Congratulation!This username is avaiable.','BMW').'</span>';
  }

  echo json_encode($json);

  wp_die();
}


///// user emaik exist /////

function bmw_email_exist_function()
{
  global $wpdb;

  $json=array();
  $json['status']=false;
  $email=sanitize_text_field($_POST['email']);
  
  if(email_exists($email)){
    $json['status']=false;
    $json['message']='<span class="let-text-danger">'.__('Email Already Used by someone. Please try another Email','BMW').'</span>';
  } else{
    if(!is_email($email)){
    $json['status']=false;
    $json['message']='<span class="let-text-danger">'.__('Email is invalid.','BMW').'</span>';
  }else
    if(empty($email)){
    $json['status']=false;
    $json['message']='<span class="let-text-danger">'.__('Email could not be empty.','BMW').'</span>';
  } else{

    $json['status']=true;
    $json['message']='<span class="let-text-success">'.__('Congratulation!This Email is avaiable.','BMW').'</span>';
    }
  }

  echo json_encode($json);

  wp_die();


}
function bmw_sponsor_exist_function()
{
  global $wpdb;

  $json=array();
  $json['status']=false;
  $sponsor=sanitize_text_field($_POST['sponsor']);
  $sponsor_id=bmw_get_user_id_by_username($sponsor);
  
  if(isset($sponsor_id) && !empty($sponsor_id)){
    $json['status']=true;
    $json['message']='<span class="let-text-success">'.__('Congratulation!This Sponsor is avaiable.','BMW').'</span>';
  } else{
    $json['status']=false;
    $json['message']='<span class="let-text-danger">'.__('Sponsor Not Valid. Please try another Sponsor','BMW').'</span>';
    
    }

  echo json_encode($json);

  wp_die();


}

function bmw_parent_exist_function()
{
  global $wpdb;

  $json=array();
  $json['status']=false;
  $sponsor=sanitize_text_field($_POST['sponsor']);
  $parent=sanitize_text_field($_POST['parent']);
  $sponsor_key=bmw_get_userkey_by_username($sponsor);
  $parent_key=bmw_get_userkey_by_username($parent);
  
    if(!isset($sponsor_key) || empty($sponsor_key)){
      $json['status']=false;
      $json['message']='<span class="let-text-danger">'.__('Please choose Fill Sponsor Name','BMW').'</span>';
    } else if(empty($parent_key)){
    $json['status']=false;
    $json['message']='<span class="let-text-danger">'.__('Parent Not Valid. Please check','BMW').'</span>';
    } else {
      
      $childs=$wpdb->get_results("SELECT position FROM {$wpdb->prefix}bmw_users WHERE parent_key='".$parent_key."'");
// print_r($childs);die;
      if(!check_parent_network($parent_key,$sponsor_key,COUNT($childs)))
      {
        $json['status']=false;
        $json['message']='<span class="let-text-danger">'.__('Parent Not Valid. Please check','BMW').'</span>';
      } 
      else if(count($childs) == 2)
      {
        $json['status']=false;
        $json['message']='<span class="let-text-danger">'.__('Parent Not Valid. because both position is full','BMW').'</span>';
      }
      else{
      $json['status']=true;
      $json['message']='<span class="let-text-success">'.__('Congratulation! This parent is avaiable.','BMW').'</span>';
        if(!empty($childs) && COUNT($childs)<2)
      {
        foreach ($childs as $key => $child) {
          $json['position']=$child->position;
          break;
        }
      }
      }

    
    }

  echo json_encode($json);

  wp_die();


}
function check_parent_network($pkey,$skey,$ref)
{
  
    global $wpdb;
    $root=bmw_get_top_user_key();
    if(($root==$skey && $ref<2) || ($pkey==$skey && $ref<2)){
        return true;}else {
            $paresents=$wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}bmw_hierarchy WHERE parent_key='".$skey."' AND user_key='".$pkey."'");
            if($paresents)
            {
              return true;
            }else{
              return false;
            }
          }
    }

//////// user password validate //////

function bmw_password_validation_function()
{

  global $wpdb;

  $json=array();
  $json['status']=false;
  $password=sanitize_text_field($_POST['password']);
  $confirm_password=sanitize_text_field($_POST['confirm_password']);
  
  if(empty($confirm_password)){
    $json['status']=true;
    $json['message']='<span class="let-text-danger">'.__('Password is valid.','BMW').'</span>';
    
  }else
  if($password==$confirm_password){
    $json['status']=true;
    $json['message']='<span class="let-text-success">'.__('Congratulation! Password is valid.','BMW').'</span>';
    
  } else{
    $json['status']=false;
    $json['message']='<span class="let-text-danger">'.__('Sorry Password does not match.','BMW').'</span>';
  }

  echo json_encode($json);

  wp_die();

}



function bmw_autofill_position_parent_key(){
  global $wpdb;
            $sql = "SELECT * FROM {$wpdb->prefix}bmw_users ORDER BY id DESC LIMIT 1";
            $user = $wpdb->get_row($sql);
        
        if($user->sponsor_key==0 && $user->parent_key==0){
        $sql = "SELECT * FROM {$wpdb->prefix}bmw_users WHERE parent_key=$user->user_key";
        $childs = $wpdb->get_results($sql);
        if(count($childs)==0){
          return array('position'=>'left','parent_key'=>$user->user_key, 'sponsor_key'=>$user->user_key);
        } else if(count($childs)==1){
          
          if($childs[0]->position=='left'){
            $position='right';
          } else {
            $position='left';
          }
          return array('position'=>$position,'parent_key'=>$user->user_key, 'sponsor_key'=>$user->user_key);
        } 
        }
        else{
 
          $sql = "SELECT * FROM {$wpdb->prefix}bmw_users WHERE user_key=$user->parent_key";
          $parent = $wpdb->get_row($sql);

          $sql = "SELECT * FROM {$wpdb->prefix}bmw_users WHERE parent_key=$parent->user_key";
          $childs = $wpdb->get_results($sql);

          if(count($childs)==0){
            return array('position'=>'left','parent_key'=>$parent->user_key, 'sponsor_key'=>$parent->user_key);
          } else if(count($childs)==1){
            
            if($childs[0]->position=='left'){
              $position='right';
            } else {
              $position='left';
            }
            return array('position'=>$position,'parent_key'=>$parent->user_key, 'sponsor_key'=>$parent->user_key);
          } else if(count($childs)==2){
              $sql = "SELECT * FROM {$wpdb->prefix}bmw_users WHERE id>$parent->id";
              $parent_sub = $wpdb->get_row($sql);
              return array('position'=>'left','parent_key'=>$parent_sub->user_key, 'sponsor_key'=>$parent_sub->user_key);
          }

        }

}













///////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////Transaction  Functions ////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////



function bmw_insert_point_transaction_entry($user_key,$details,$do,$dl,$dr,$co,$cl,$cr,$type)
{
  global $wpdb;
  if(($do+$dl+$dr+$co+$cl+$cr)>0 && $user_key!=0)
  {
  $wpdb->query("INSERT INTO {$wpdb->prefix}bmw_point_transaction SET `user_key`='".$user_key."', `details`='".$details."', `debit_own`='".$do."', `debit_left`='".$dl."', `debit_right`='".$dr."', `credit_own`='".$co."', `credit_left`='".$cl."', `credit_right`='".$cr."', `type`='".$type."',`date`='".date_i18n('Y-m-d H:i:s')."'");
  }

}









///////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////Withdrawal  Functions /////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////

function bmw_get_withdrawal_data_by_id($user_id,$id)
{
  global $wpdb;
  return $wpdb->get_row("SELECT * FROM {$wpdb->prefix}bmw_withdrawal WHERE id='".$id."' AND user_id='".$user_id."'");
}



function bmw_get_total_withdrawal($user_id)
{
  global $wpdb;
  return $wpdb->get_var("SELECT SUM(amount) FROM {$wpdb->prefix}bmw_withdrawal WHERE user_id='".$user_id."'");
}

function get_total_payout_amounts($user_key)
{
  global $wpdb;
  return $wpdb->get_row("SELECT SUM(pair_commission) as pair_commission,SUM(referral_commission) as referral_commission,SUM(faststart_commission) as faststart_commission,SUM(leadership_commission) as leadership_commission,SUM(one_time_bonus) as one_time_bonus,SUM(total_amount) as total_amount,SUM(total_points) as total_points FROM {$wpdb->prefix}bmw_payout WHERE user_key='".$user_key."'");
}
function bmw_user_downlines_by_key($user_key)
{
  global $wpdb;
  return $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}bmw_hierarchy WHERE parent_key='".$user_key."'");
}
function bmw_get_total_orders($user_id)
{
  global $wpdb; 
  return $wpdb->get_row("SELECT COUNT(*) as total_orders, SUM(total_amount) as total_shopping FROM {$wpdb->prefix}bmw_orders WHERE user_id='".$user_id."'");
}
function bmw_withdraw_data_update_function()
{

    global $wpdb;
    $error=array();

    $user_id=sanitize_text_field($_POST['user_id']);
    $transaction_id=sanitize_text_field($_POST['transaction_id']);
    $method=sanitize_text_field($_POST['method']);
    $row_id=sanitize_text_field($_POST['row_id']);
        if(empty($transaction_id)){
            $error['status']=false;
            $error['transaction_id_err']=__('Transaction ID Could not be empty','ump');
        }
    
    if(empty($error)){
    $wpdb->query("UPDATE {$wpdb->prefix}bmw_withdrawal SET payment_processed='1',payment_processed_date='".current_time('mysql')."',withdrawal_mode='".$method."',transaction_id='".$transaction_id."' WHERE user_id='".$user_id."' and id='".$row_id."'");
            $error['status']=true;
    }
     echo json_encode($error);
      wp_die();
}


function bmw_withdrwal_amount_request_function()
{
      global $wpdb,$current_user;
      $json=array();
      $json['status']=true;
      $user_id = $current_user->ID;
      $user_key=bmw_get_user_key_by_user_id($user_id);
      $settings=get_option('bmw_manage_general');

        $current_balance = bmw_get_current_balance_by_user_id($user_id);
        $pending_amount=bmw_get_pending_balance_by_user_id($user_id);
        $min_limit=$settings['bmw_withdrawal_limit_min'];
        $max_limit=$settings['bmw_withdrawal_limit_max'];
        $amount=sanitize_text_field($_POST['amount']);
        $remaining_balance=$current_balance-$amount;

        if(empty($amount))
        {
          $json['message'] = __("Please Enter Withdrawal Amount",'BMW');
          $json['status']=false;
        }else
        if(empty(bmw_get_bank_info($user_key)))
        {
          $json['message'] = __("Please Update Your Bank details, then withdraw",'BMW');
          $json['status']=false;
        }
        else{
        if (($amount<=$max_limit && $amount>=$min_limit) && $amount <= $current_balance && $json['status']==true) {
            bmw_withdrawal_process($amount,$current_balance,$remaining_balance,$user_id,$user_key);
            $json['message'] = __("your request is submitted successfully",'BMW');
            $json['status']  =true;
        } else {
            $json['message'] = __("Sorry you entered wrong Amount please check",'BMW');
            $json['status']  =false;
       }
     }
       echo json_encode($json);
       wp_die();
      
}



 function bmw_update_withdrawal_request($payment,$bank,$user_id,$id)
    {
        global $wpdb;
        if(!empty($payment))
        {
           $sql="UPDATE {$wpdb->prefix}bmw_withdrawal SET transaction_id='".$payment->bmw_withdrawal_transaction_id."', payment_mode='".$payment->bmw_withdrawal_payment_mode."', withdrawal_mode='".$payment->bmw_withdrawal_payment_mode."', user_bank_name='".$bank->bank_name."', user_bank_account_no='".$bank->account_number."', payment_processed='1', payment_processed_date='".date_i18n('Y-m-d H:i:s')."' WHERE user_id='".$user_id."' AND id='".$id."'";

           if($wpdb->query($sql)){
            bmw_payment_processed_mail($user_id,$id);
            return '<span class="let-alert let-alert-success let-w-100 let-p-1">'.__('Payment successfully updated!!!','BMW').'</span>';

           }else
           {
            return '<span class="let-alert let-alert-danger let-w-100 let-p-1">'.__('An error occured in payment update!!!','BMW').'</span>';
           }

        }

    }






///////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////  SMS  Functions ///////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////

function bmw_get_otp_action_function()
{
  global $wpdb;
  $return=array();
  $return['status']=false;
  $post_data=sanitize_text_array($_POST);
  if(!empty($post_data['phone']) && !empty($post_data['country_code']))
  {
    if( !session_id() )
      { 
        session_start();
      } 
      $otp=bmw_generateOTP();
      $_SESSION['usr_otp']=$otp;
        $phone          = '+'.$post_data['country_code'].$post_data['phone'];
        $sms_settings   = get_option('bmw_sms_gateway_settings',true);
        $numbers        = array();
        $message        = sprintf(__('Your OTP for %s is: %s','BMW'),get_bloginfo('name'),$otp); 
        $numbers[]      = $phone;
      if(isset($sms_settings['text_local_check']) && $sms_settings['text_local_check']=='on'){

       $status= bmw_send_text_local_sms($numbers,$message);
      }else if(isset($sms_settings['twilio_check']) && $sms_settings['twilio_check']=='on'){
       $status= bmw_send_twilio_sms($numbers,$message);
      }else if(isset($sms_settings['plivo_check']) && $sms_settings['plivo_check']=='on'){
       $status= bmw_send_plivo_sms($numbers,$message);
      }
      if($status==true){
        $_SESSION['usr_phone']=$phone;
        $return['status']=true;
        $return['message']=__('OTP sent successfully','BMW');
      }else{
        $return['status']=false;
        $return['message']=__('Something going wrong! please check','BMW');
      }
  }else{
        $return['status']=false;
        $return['message']=__('Something going wrong! please check','BMW');
  }
   // $return['otp']=$otp;
  echo json_encode($return);
  wp_die();
}
function bmw_verify_otp_action_function()
{
  $return=array();
  $otp=sanitize_text_field($_POST['otp']);
  if($otp==$_SESSION['usr_otp'])
  {     $_SESSION['number_verified']=true;
        $return['status']=true;
        $return['message']=__('Number Verified','BMW');
      }else{
        $return['status']=false;
        $return['message']=__('Incorrect OTP, Please make valid request','BMW');
      }
 echo json_encode($return);
 wp_die();
}
function bmw_send_text_local_sms($numbers,$message)
{
  global $wpdb;
$sms_settings=get_option('bmw_sms_gateway_settings',true);
$apiKey = urlencode($sms_settings['text_local_api_key']);
$sender = urlencode('TXTLCL');
$message = rawurlencode($message);
$numbers=implode(',', $numbers);
$data = array('apikey' => $apiKey, 'numbers' => $numbers, 'sender' => $sender, 'message' => $message);
            try {
                    $ch = curl_init('https://api.textlocal.in/send/');
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $result = curl_exec($ch);
                    curl_close($ch);
                    $data=json_decode($result);

                    if($data->status=='success')
                    {
                      throw new Exception(true); 
                    }else
                    {
                      throw new Exception(false); 
                    }
              } catch (\Exception $e) {
            return  $e->getMessage();
            }
}
function bmw_send_twilio_sms($numbers,$message)
{

  $sms_settings=get_option('bmw_sms_gateway_settings',true);
  $account_sid = $sms_settings['twilio_sid'];
  $auth_token = $sms_settings['twilio_token'];
  $client = new Client($account_sid, $auth_token);
        if(!empty($numbers))
        {
          foreach ($numbers as $key => $number) {
            try {
            $response= $client->messages->create(
                        $number,array(
                                      'from' => $sms_settings['twilio_phone'],
                                      'body' => $message
                                  )
                      );
             throw new Exception(true); 
               } catch (\Exception $e) {
           if($e->getMessage()==1){
            return true;
           }else{ return false;}
               
              }
            }
        }
}

function bmw_send_plivo_sms($numbers,$message){
 $sms_settings=get_option('bmw_sms_gateway_settings',true);
 $auth_id=$sms_settings['plivo_auth_id'];
 $auth_token=$sms_settings['plivo_token'];
  $client = new RestClient( $auth_id, $auth_token);
 if(!empty($numbers))
        {
          foreach ($numbers as $key => $number) {
            try {
                    $response = $client->messages->create($sms_settings['plivo_phone'], [$number], $message );
                    throw new Exception(true); 
            }catch (\Exception $e) {
             if($e->getMessage()==1){
            return true;
           }else{ return false;}
        }
      }
    }
  }

function bmw_register_sms_function($user_id)
{
    global $wpdb;
    $sms_settings=get_option('bmw_sms_gateway_settings',true);
    $numbers=array();
    $user_info      = get_userdata($user_id);
    $text_settings  = bmw_get_mail_settings_by_name('registration_sms');
    $message        = $text_settings->mail_message; 
    $phone          = get_user_meta($user_id,'bmw_phone',true);
    $numbers[]      = $phone;
    $message        = bmw_filter_message($message,$text_settings->mail_name,$user_id);

      if(isset($sms_settings['text_local_check']) && $sms_settings['text_local_check']=='on'){
        bmw_send_text_local_sms($numbers,$message);
      }else if(isset($sms_settings['twilio_check']) && $sms_settings['twilio_check']=='on'){
        bmw_send_twilio_sms($numbers,$message);
      }else if(isset($sms_settings['plivo_check']) && $sms_settings['plivo_check']=='on'){
        bmw_send_plivo_sms($numbers,$message);
      }
}

function bmw_send_payout_sms_function($payout,$payout_id){
    global $wpdb;
    $numbers=array();
    $sms_settings=get_option('bmw_sms_gateway_settings',true);
    $text_settings = bmw_get_mail_settings_by_name('payout_sms');
    $message      = $text_settings->mail_message;
    $message      = bmw_filter_message($message,$text_settings->mail_name,$payout['user_id'],$payout_id,NULL,NULL);
    $phone        = get_user_meta($payout['user_id'],'bmw_phone',true);
    $numbers[]    = $phone;

      if(isset($sms_settings['text_local_check']) && $sms_settings['text_local_check']=='on'){
        bmw_send_text_local_sms($numbers,$message);
      }else if(isset($sms_settings['twilio_check']) && $sms_settings['twilio_check']=='on'){
        bmw_send_twilio_sms($numbers,$message);
      }else if(isset($sms_settings['plivo_check']) && $sms_settings['plivo_check']=='on'){
        bmw_send_plivo_sms($numbers,$message);
      }
}

function bmw_send_waithdrwal_init_sms_function($user_id,$req){
  global $wpdb;
  $numbers=array();
  $sms_settings=get_option('bmw_sms_gateway_settings',true);
  $text_settings=bmw_get_mail_settings_by_name('withdrawal_request_sms');
  $message        = $text_settings->mail_message;
  $message        = bmw_filter_message($message,$text_settings->mail_name,$user_id,NULL,NULL,$req);
  $phone          = get_user_meta($user_id,'bmw_phone',true);
  $numbers[]      = $phone;

      if(isset($sms_settings['text_local_check']) && $sms_settings['text_local_check']=='on'){
        bmw_send_text_local_sms($numbers,$message);
      }else if(isset($sms_settings['twilio_check']) && $sms_settings['twilio_check']=='on'){
        bmw_send_twilio_sms($numbers,$message);
      }else if(isset($sms_settings['plivo_check']) && $sms_settings['plivo_check']=='on'){
        bmw_send_plivo_sms($numbers,$message);
      }
}
function bmw_send_waithdrwal_process_sms_function($user_id,$pay){
  global $wpdb;
  $numbers=array();
  $sms_settings=get_option('bmw_sms_gateway_settings',true);
  $text_settings=bmw_get_mail_settings_by_name('withdrawal_pay_sms');
  $message        = $text_settings->mail_message;
  $message        = bmw_filter_message($message,$text_settings->mail_name,$user_id,NULL,$pay);
  $phone          = get_user_meta($user_id,'bmw_phone',true);
  $numbers[]      = $phone;

      if(isset($sms_settings['text_local_check']) && $sms_settings['text_local_check']=='on'){
      bmw_send_text_local_sms($numbers,$message);
      }else if(isset($sms_settings['twilio_check']) && $sms_settings['twilio_check']=='on'){
      bmw_send_twilio_sms($numbers,$message);
      }else if(isset($sms_settings['plivo_check']) && $sms_settings['plivo_check']=='on'){
      bmw_send_plivo_sms($numbers,$message);
      }
}
///////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////Mail  Functions /////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////

function bmw_filter_message($message=NULL,$mail_name=NULL,$user_id=NULL,$payout_id=NULL,$withdrawal_pay=NULL,$withdrawal_req=NULL)
{
  global $wpdb;
  // if($user_id==NULL)
  // {
  //   $user_id=$current_user->ID;
  // }
  $site_name=get_bloginfo('name');
  $site_url=get_bloginfo('url');
  $site_language=get_bloginfo('language');

  $admin_email=get_option('admin_email');
  $admin=get_user_by( 'email', $admin_email );
  $admin_name=ucwords($admin->user_nicename);
  $date=date_i18n('d M Y H:i:s');

  $user=get_user_by( 'id', $user_id );
  $user_info=bmw_get_user_info_by_user_id($user_id);
  // [site_name]
  // [site_url]
  // [site_language]
  // [admin_email]
  // [admin_name]
  // [date]
  
  $message=str_replace(
    array(
      '[site_name]',
      '[site_url]',
      '[site_language]',
      '[admin_email]',
      '[admin_name]',
      '[date]'
    ),
    array(
      $site_name,
      $site_url,
      $site_language,
      $admin_email,
      $admin_name,
      $date
    ), $message);

  if(isset($user_info) && !empty($user_info)){
  $user_name=$user->user_nicename;
  $user_key=$user_info->user_key;
  $user_email=$user->user_email;
  $user_level=$user_info->network_row;
  $user_creation_date=date_i18n('d M Y H:i:s',strtotime($user_info->creation_date));

  // [user_name]
  // [user_key]
  // [user_email]
  // [user_id]
  // [user_level]
  // [user_creation_date]
$message=str_replace(
    array(
      '[user_name]',
      '[user_key]',
      '[user_level]',
      '[user_id]',
      '[user_email]',
      '[user_creation_date]'
    ),
    array(
      $user_name,
      $user_key,
      $user_level,
      $user_id,
      $user_email,
      $user_creation_date
    ), $message);

  $sponsor_key=$user_info->sponsor_key;
  $parent_key=$user_info->parent_key;
  }

  if(isset($sponsor_key) && $sponsor_key!=0){
  $sponsor = bmw_get_user_info_by_userkey($sponsor_key);
  $sponsor_name = $sponsor->user_name;
  $sponsor_info = get_userdata( $sponsor->user_id);
  $sponsor_mail = $sponsor_info->user_email;

  // [sponsor_name]
  // [sponsor_key]
  // [sponsor_mail]
  $message=str_replace(
    array(
      '[sponsor_name]',
      '[sponsor_key]',
      '[sponsor_mail]'
    ),
    array(
      $sponsor_name,
      $sponsor_key,
      $sponsor_mail
    ), $message);
  }

   if(isset($parent_key) && $parent_key!=0){
  $parent = bmw_get_user_info_by_userkey($parent_key);
  $parent_name=$sponsor->user_name;
  $parent_info = get_userdata( $parent->user_id);
  $parent_mail = $parent_info->user_email;

  // [parent_name]
  // [parent_key]
  // [parent_mail]
    $message=str_replace(
    array(
      '[parent_name]',
      '[parent_key]',
      '[parent_mail]'
    ),
    array(
      $parent_name,
      $parent_key,
      $parent_mail
    ), $message);
  }

  if($mail_name!='registration_mail' && $mail_name!='registration_sms' && isset($user_key))
{
  $withdrawal_balance=bmw_get_total_withdrawal($user_id);
  $current_balance=bmw_get_current_balance_by_user_id($user_id);
  $payout_total=get_total_payout_amounts($user_key);
  // echo '<pre>'; print_r($payout_total);die;
  $referral_balance=$payout_total->referral_commission;
  $join_balance=$payout_total->pair_commission;
  $one_time_bonus_amount=$payout_total->one_time_bonus;
  $total_leadership_amount=$payout_total->leadership_commission;
  $total_faststart_amount=$payout_total->faststart_commission;

  $orders=bmw_get_total_orders($user_id);
  $total_shopping=$orders->total_shopping;
  $total_orders=$orders->total_orders;
  $total_downliners=bmw_user_downlines_by_key($user_key);

  $bank=bmw_get_bank_info($user_key);

  // [withdrawal_balance]
  // [referral_balance]
  // [join_balance]
  // [current_balance]
  // [total_bonus_amount]
  // [total_level_amount]
  // [total_shopping]
  // [total_orders]
  // [total_downliners]
  $message=str_replace(
    array(
      '[withdrawal_balance]',
      '[referral_balance]',
      '[join_balance]',
      '[current_balance]',
      '[one_time_bonus_amount]',
      '[total_leadership_amount]',
      '[total_faststart_amount]',
      '[total_shopping]',
      '[total_orders]',
      '[total_downliners]'
    ),
    array(
      $withdrawal_balance,
      $referral_balance,
      $join_balance,
      $current_balance,
      $one_time_bonus_amount,
      $total_leadership_amount,
      $total_faststart_amount,
      $total_shopping,
      $total_orders,
      $total_downliners
    ), $message);

  if(!empty($bank)){
  $bank_name=$bank->bank_name;
  $account_holder=$bank->account_holder;
  $account_number=$bank->account_number;
  $branch_name=$bank->branch;
  $ifsc_code=$bank->ifsc_code;
  $contact_number=$bank->contact_number;
  // [bank_name]
  // [account_holder]
  // [account_number]
  // [branch_name]
  // [ifsc_code]
  // [contact_number]
  $message=str_replace(
    array(
      '[bank_name]',
      '[account_holder]',
      '[account_number]',
      '[branch_name]',
      '[ifsc_code]',
      '[contact_number]'
    ),
    array(
      $bank_name,
      $account_holder,
      $account_number,
      $branch_name,
      $ifsc_code,
      $contact_number
    ), $message);

  }
if($payout_id!=NULL)
{
    $payout=bmw_get_payout_data_by_payout_id($payout_id,$user_key);
    $payout_total= bmw_price($payout->total_amount);
    $payout_date= date('d M Y h:i:s',strtotime($payout->insert_date));
    $payout_table= '<table style="border:2px solid #696969;width:100%;border-collapse: collapse;">
    <thead>
    <tr style="background-color: #dddddd;padding: 8px;border: 2px solid #696969;">
    <th style="border: 2px solid #696969;width: 50%;padding: 8px;">'.__('Name','BMW').'</th>
    <th style="border: 2px solid #696969;width: 50%;padding: 8px;">'.__('Value','BMW').'</th>
    </tr>
    </thead><tbody style="text-center"><tr>
    <th style="border: 1px solid #ddd;padding: 8px;">'.__('Payout Id','BMW').'</th>
    <td style="border: 1px solid #ddd;padding: 8px;">'.$payout->payout_id.'</td>
    </tr><tr>
    <th style="border: 1px solid #ddd;padding: 8px;">'.__('Pair Commission','BMW').'</th>
     <td style="border: 1px solid #ddd;padding: 8px;">'.$payout->pair_commission.'</td>
    </tr><tr>
    <th style="border: 1px solid #ddd;padding: 8px;">'.__('Referral Commission','BMW').'</th>
     <td style="border: 1px solid #ddd;padding: 8px;">'.$payout->referral_commission.'</td>
    </tr><tr>
    <th style="border: 1px solid #ddd;padding: 8px;">'.__('Leadership Commission','BMW').'</th>
     <td style="border: 1px solid #ddd;padding: 8px;"> '.$payout->leadership_commission.'</td>
    </tr><tr>
    <th style="border: 1px solid #ddd;padding: 8px;">'.__('One time Bonus Amount','BMW').'</th>
     <td style="border: 1px solid #ddd;padding: 8px;">'.$payout->one_time_bonus.'</td>
    </tr><tr> 
     <th style="border: 1px solid #ddd;padding: 8px;">'.__('Faststart Bonus Amount','BMW').'</th>
     <td style="border: 1px solid #ddd;padding: 8px;">'.$payout->faststart_commission.'</td>
    </tr><tr>
    <th style="border: 1px solid #ddd;padding: 8px;">'.__('Tax','BMW').'</th>
     <td style="border: 1px solid #ddd;padding: 8px;">'.bmw_price($payout->tax).'</td>
    </tr><tr>
    <th style="border: 1px solid #ddd;padding: 8px;">'.__('Service Charge','BMW').'</th>
     <td style="border: 1px solid #ddd;padding: 8px;">'.bmw_price($payout->service_charge).'</td>
    </tr><tr>
    <th style="border: 1px solid #ddd;padding: 8px;">'.__('Total Points','BMW').'</th>
     <td style="border: 1px solid #ddd;padding: 8px;">'.$payout->total_points.'</td>
    </tr><tr>
    <th style="border: 1px solid #ddd;padding: 8px;">'.__('Total Amount','BMW').'</th>
     <td style="border: 1px solid #ddd;padding: 8px;">'.$payout_total.'</td>
    </tr><tr>
    <th style="border: 1px solid #ddd;padding: 8px;">'.__('Payout Date','BMW').'</th>
    <td style="border: 1px solid #ddd;padding: 8px;">'.date('d M Y h:i:s',strtotime($payout->insert_date)).'</td>
    </tr></tbody>
    </table>';

  // [payout_id]
  // [payout_total]
  // [payout_date]
  // [payout_table]

      $message=str_replace(
    array(
      '[payout_id]',
      '[payout_total]',
      '[payout_date]',
      '[payout_table]'
    ),
    array(
      $payout_id,
      $payout_total,
      $payout_date,
      $payout_table
    ), $message);
}
if($withdrawal_pay!=NULL && !empty($withdrawal_pay))
{


  $withdrawal_pay_table = '<table style="border:2px solid #696969;width:100%;border-collapse: collapse;">
    <tr style="background-color: #dddddd;padding: 8px;border: 2px solid #696969;">
    <th style="border: 1px solid #ddd;padding: 8px;">'.__('Name','BMW').'</th>
    <th style="border: 1px solid #ddd;padding: 8px;">'.__('Value','BMW').'</th>
    </tr><tr>
    <th style="border: 1px solid #ddd;padding: 8px;">'.__('User Name','BMW').'</th>
    <td style="border: 1px solid #ddd;padding: 8px;">'.$user_name.'</td>
    </tr> <tr>
    <th style="border: 1px solid #ddd;padding: 8px;">'.__('Request Amount','BMW').'</th>
    <td style="border: 1px solid #ddd;padding: 8px;">'.bmw_price($withdrawal_pay->amount).'</td>
    </tr> <tr>
    <th style="border: 1px solid #ddd;padding: 8px;">'.__('Payment Mode','BMW').'</th>
    <td style="border: 1px solid #ddd;padding: 8px;">'.$withdrawal_pay->payment_mode.'</td>
    </tr> <tr>
    <th style="border: 1px solid #ddd;padding: 8px;">'.__('Transaction Id','BMW').'</th>
    <td style="border: 1px solid #ddd;padding: 8px;">'.$withdrawal_pay->transaction_id.'</td>
    </tr> <tr>
    <th style="border: 1px solid #ddd;padding: 8px;">'.__('Initiated Date','BMW').'</th>
    <td style="border: 1px solid #ddd;padding: 8px;">'.date('d M Y h:i:s',strtotime($withdrawal_pay->initiated)).'</td>
    </tr> <tr>
    <th style="border: 1px solid #ddd;padding: 8px;">'.__('Processed Date','BMW').'</th>
    <td style="border: 1px solid #ddd;padding: 8px;">'.date('d M Y h:i:s',strtotime($withdrawal_pay->date)).'</td>
    </tr></table>';

     $withdrawal_pay_data =      __('Request Amount','BMW').':'.bmw_price($withdrawal_pay->amount).
                            ', '.__('Payment Mode','BMW').':'.$withdrawal_pay->payment_mode.
                            ', '.__('Transaction Id','BMW').':'.$withdrawal_pay->transaction_id.
                            ', '.__('Processed Date','BMW').':'.date('d M Y h:i:s',strtotime($withdrawal_pay->date));


// [withdrawal_pay_table]
 $message=str_replace('[withdrawal_pay_table]',  $withdrawal_pay_table, $message);
// [withdrawal_pay_data]
 $message=str_replace('[withdrawal_pay_data]',  $withdrawal_pay_data, $message);
}
if($withdrawal_req!=NULL)
{
   
    $withdrawal_req_table = '<table style="border:2px solid #696969;width:100%;border-collapse: collapse;">
    <tr style="background-color: #dddddd;padding: 8px; border: 2px solid #696969;">
    <th style="border: 1px solid #ddd;padding: 8px;">'.__('Name','BMW').'</th>
    <th style="border: 1px solid #ddd;padding: 8px;">'.__('Value','BMW').'</th>
    </tr><tr>
    <tr>
    <th style="border: 1px solid #ddd;padding: 8px;">'.__('User Name','BMW').'</th>
    <td style="border: 1px solid #ddd;padding: 8px;">'.$user_name.'</td>
    </tr> <tr>
    <th style="border: 1px solid #ddd;padding: 8px;">'.__('Request Amount','BMW').'</th>
    <td style="border: 1px solid #ddd;padding: 8px;">'.bmw_price($withdrawal_req->requested_amount).'</td>
    </tr> <tr>
    <th style="border: 1px solid #ddd;padding: 8px;">'.__('Current Balance','BMW').'</th>
    <td style="border: 1px solid #ddd;padding: 8px;">'.bmw_price($withdrawal_req->current_balance).'</td>
    </tr> <tr>
    <th style="border: 1px solid #ddd;padding: 8px;">'.__('Remaining Balance','BMW').'</th>
    <td style="border: 1px solid #ddd;padding: 8px;">'.bmw_price($withdrawal_req->remaining_balance).'</td>
    </tr> <tr>
    <th style="border: 1px solid #ddd;padding: 8px;">'.__('Initiated Date','BMW').'</th>
    <td style="border: 1px solid #ddd;padding: 8px;">'.date('d M Y h:i:s',strtotime($withdrawal_req->initiated)).'</td>
    </tr></table>';

  $withdrawal_req_data =     __('Request Amount','BMW').':'.bmw_price($withdrawal_req->requested_amount).
                        ', '.__('Current Balance','BMW').':'.bmw_price($withdrawal_req->current_balance).
                        ', '.__('Remaining Balance','BMW').':'.bmw_price($withdrawal_req->remaining_balance).
                        ', '.__('Initiated Date','BMW').':'.date('d M Y h:i:s',strtotime($withdrawal_req->initiated));
// [withdrawal_req_table]
    $message=str_replace('[withdrawal_req_table]',  $withdrawal_req_table, $message);
// [withdrawal_req_data]
    $message=str_replace('[withdrawal_req_data]',  $withdrawal_req_data, $message);
}

}

 return $message;

}
function bmw_get_mail_settings_by_name($mail_name)
{
   global $wpdb;
  return  $wpdb->get_row("SELECT * FROM {$wpdb->prefix}bmw_mail_settings WHERE mail_name='".$mail_name."'");
}
function bmw_mail_settings_post_function()
{
    global $wpdb;
  $json=array();
  $json['status']=false;
  $data=sanitize_text_array($_POST);
  $bmw_mail_name    = sanitize_text_field($_POST['bmw_mail_name']);
  $bmw_mail_to    = sanitize_text_field($_POST['bmw_mail_to']);
  $bmw_mail_subject   = sanitize_text_field($_POST['bmw_mail_subject']);
  $bmw_mail_message   = $_POST['bmw_mail_message'];
  if(!empty($data)){
  foreach ($data as $key => $value) {
    
    if($value=='')
      {
        $json['error'][$key]=ucwords(str_replace('_',' ',str_replace('bmw_', '', $key))).' Could Not be Empty';
      }
    }
  } 
  
  if(empty($json['error']) && !isset($json['error'])){
    // print_r($_POST);die;

  $get_settings=$wpdb->get_row("SELECT * FROM {$wpdb->prefix}bmw_mail_settings WHERE mail_name='".$bmw_mail_name."'");
  if(isset($get_settings) && !empty($get_settings))
  {
    $wpdb->query("UPDATE {$wpdb->prefix}bmw_mail_settings SET mail_to='".$bmw_mail_to."',mail_subject='".$bmw_mail_subject."',mail_message='".$bmw_mail_message."' WHERE mail_name='".$bmw_mail_name."'");
  }else{
    $wpdb->query("INSERT INTO {$wpdb->prefix}bmw_mail_settings (mail_name, mail_to, mail_from, mail_subject, mail_message) VALUES ('".$bmw_mail_name."', '".$bmw_mail_to."','".get_bloginfo('admin_email')."' , '".$bmw_mail_subject."', '".$bmw_mail_message."')");
  }
  $json['status']=true;
  }else{
    $json['status']=false;
  }
      echo json_encode($json);
      wp_die();
}
function bmw_sms_settings_post_function()
{
    global $wpdb;
  $json=array();
  $json['status']=false;
  $data=sanitize_text_array($_POST);
  $bmw_sms_name    = sanitize_text_field($_POST['bmw_sms_name']);
  $bmw_sms_to    = sanitize_text_field($_POST['bmw_sms_to']);
  $bmw_sms_subject   = sanitize_text_field($_POST['bmw_sms_subject']);
  $bmw_sms_message   = $_POST['bmw_sms_message'];
  if(!empty($data)){
  foreach ($data as $key => $value) {
    
    if($value=='')
      {
        $json['error'][$key]=ucwords(str_replace('_',' ',str_replace('bmw_', '', $key))).__('Could Not be Empty','BMW');
      }
    }
  } 
  
  if(empty($json['error']) && !isset($json['error'])){

  $get_settings=$wpdb->get_row("SELECT * FROM {$wpdb->prefix}bmw_mail_settings WHERE mail_name='".$bmw_sms_name."'");
  if(isset($get_settings) && !empty($get_settings))
  {
    $wpdb->query("UPDATE {$wpdb->prefix}bmw_mail_settings SET mail_to='".$bmw_sms_to."',mail_subject='".$bmw_sms_subject."',mail_message='".$bmw_sms_message."' WHERE mail_name='".$bmw_sms_name."'");
  }else{
    
    $wpdb->query("INSERT INTO {$wpdb->prefix}bmw_mail_settings (mail_name, mail_to, mail_from, mail_subject, mail_message) VALUES ('".$bmw_sms_name."', '".$bmw_sms_to."','".get_bloginfo('admin_email')."' , '".$bmw_sms_subject."', '".$bmw_sms_message."')");
  }
  $json['status']=true;
  }else{
    $json['status']=false;
  }
      echo json_encode($json);
      wp_die();
}

function bmw_message_center_function(){
     global $wpdb;

    $json=array();
      $error =array();
      if(empty($_POST['to'])){
        $error['err_m_c_to']= __('Please enter Email Address','BMW');
      }if(empty($_POST['subject'])){
        $error['err_m_c_subject']= __("Subject can't be blank","BMW");
      }if(empty($_POST['message'])){
        $error['err_m_c_message']= __("Message Body can't be blank","BMW");
      }
      if(empty($error)){
        messgae_center_mail($_POST['to'],$_POST['subject'],$_POST['message']);
        $json['status']=true;
        $json['message']=__('Email has been successfully Sent to ','BMW').$_POST['to'];
        echo json_encode($json);
        wp_die();
      }else{
      $json['status']=false;
      $json['error']=$error;
      echo json_encode($json);
      wp_die();
   }
    
}


function bmw_withdrawal_process($amount,$current_balance,$remaining_balance,$user_id,$user_key){
    global $wpdb;
    $comment = 'Withdrawal Request Initiated';
  $wpdb->query("INSERT INTO {$wpdb->prefix}bmw_withdrawal (user_id, amount, withdrawal_initiated, withdrawal_initiated_comment,withdrawal_initiated_date) VALUES('".$user_id."', '".$amount."', 1, '".$comment."','".date_i18n('Y-m-d H:i:s')."')");
  $id=$wpdb->insert_id;
    bmw_debit_bal_function($user_id,$amount,$id);

    $user_info = get_userdata($user_id);
     $request=bmw_get_withdrawal_data_by_id($user_id,$id);
     $withdrawal_req=(object)array(
      'requested_amount' => $amount,
      'current_balance' => $current_balance,
      'remaining_balance' => $remaining_balance,
      'initiated' => $request->withdrawal_initiated_date,
    );
    do_action('bmw_after_withdrawal_init',$user_id,$withdrawal_req);
    $mail_settings=bmw_get_mail_settings_by_name('withdrawal_request');

    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
    $headers .= "From: " . get_option('admin_email') . "<" . get_option('admin_email') . ">" . "\r\n";
    $subject = $mail_settings->mail_subject;

    add_filter( 'wp_mail_content_type', 'set_html_content_type' );

    $message= "<div style='max-width:100%;margin:4rem;background:#e7eeef;text-align:center;border:1px solid #696969;'><h2 style='padding:2rem;'>".__('Binary MLM Woocommerce','BMW')."<br/>([site_name])</h2><h4 style='padding:1rem;'>".__('Withrawal Requested','BMW')."</h4><hr/>";
    $message.=$mail_settings->mail_message;
    $message.='</div>';
    $message= bmw_filter_message($message,$mail_settings->mail_name,$user_id,NULL,NULL,$withdrawal_req);

      if($mail_settings->mail_to=='user'){
      wp_mail($user_info->user_email, $subject, $message, $headers);
        }else if ($mail_settings->mail_to=='admin') {
            $admin_email=get_option('admin_email');
            wp_mail($admin_email, $subject, $message, $headers);
            }else if($mail_settings->mail_to=='both'){
                  $admin_email=get_option('admin_email');
                  wp_mail($admin_email, $subject, $message, $headers);
                  wp_mail($user_info->user_email, $subject, $message, $headers);
                  }
    }

 function bmw_payment_processed_mail($user_id,$id){
    global $wpdb;
    $payment=bmw_get_withdrawal_data_by_id($user_id,$id);
    $mail_settings=bmw_get_mail_settings_by_name('withdrawal_pay');
    $user_info = get_userdata($user_id);

    $withdrawal_pay=(object)array(
      'payment_mode' => ucwords(str_replace('_', ' ', $payment->payment_mode)),
      'transaction_id' => $payment->transaction_id,
      'amount' => $payment->amount,
      'date' => $payment->payment_processed_date,
      'initiated' => $payment->withdrawal_initiated_date,
    );
    do_action('bmw_after_withdrawal_processed',$user_id,$withdrawal_pay);

    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
    $headers .= "From: " . get_option('admin_email') . "<" . get_option('admin_email') . ">" . "\r\n";
    $subject = $mail_settings->mail_subject;
    add_filter( 'wp_mail_content_type', 'set_html_content_type' );
     $message= "<div style='max-width:100%;margin:4rem;background:#e7eeef;text-align:center;border:1px solid #696969;'><h2 style='padding:2rem;'>".__('Binary MLM Woocommerce','BMW')."<br/>([site_name])</h2><h4 style='padding:1rem;'>".__('Payment Processed','BMW')."</h4><hr/>";
     $message.=$mail_settings->mail_message;
     $message.='</div>';
     $message= bmw_filter_message($message,$mail_settings->mail_name,$user_id,NULL,$withdrawal_pay);

      if($mail_settings->mail_to=='user'){
      wp_mail($user_info->user_email, $subject, $message, $headers);
        }else if ($mail_settings->mail_to=='admin') {
            $admin_email=get_option('admin_email');
            wp_mail($admin_email, $subject, $message, $headers);
            }else if($mail_settings->mail_to=='both'){
                  $admin_email=get_option('admin_email');
                  wp_mail($admin_email, $subject, $message, $headers);
                  wp_mail($user_info->user_email, $subject, $message, $headers);
                  }
}
   function bmw_send_payout_mail($user_id,$payout_id){
    global $wpdb;
    $mail_settings = bmw_get_mail_settings_by_name('payout_mail');
    $user_info = get_userdata($user_id);
    
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
    $headers .= "From: " . get_option('admin_email') . "<" . get_option('admin_email') . ">" . "\r\n";
    $subject = $mail_settings->mail_subject;

    add_filter( 'wp_mail_content_type', 'set_html_content_type' );

    $message= "<div style='max-width:100%;margin:4rem;background:#e7eeef;text-align:center;border:1px solid #696969;'><h2 style='padding:2rem;'>".__('Unilevel Woocommerce','BMW')." <br/>([site_name])</h2><h4 style='padding:1rem;'>".__('Payout Processed','BMW')."</h4><hr/>";
    $message.=$mail_settings->mail_message;
    $message.='</div>';
    $message= bmw_filter_message($message,$mail_settings->mail_name,$user_id,$payout_id,NULL,NULL);

      if($mail_settings->mail_to=='user'){
      wp_mail($user_info->user_email, $subject, $message, $headers);
        }else if ($mail_settings->mail_to=='admin') {
            $admin_email=get_option('admin_email');
            wp_mail($admin_email, $subject, $message, $headers);
            }else if($mail_settings->mail_to=='both'){
                  $admin_email=get_option('admin_email');
                  wp_mail($admin_email, $subject, $message, $headers);
                  wp_mail($user_info->user_email, $subject, $message, $headers);
                  }
}

function bmw_register_mail_function($user_id)
{
      global $wpdb;
    $user_info = get_userdata($user_id);
    $mail_settings=bmw_get_mail_settings_by_name('registration_mail');

    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
    $headers .= "From: " . get_option('admin_email') . "<" . get_option('admin_email') . ">" . "\r\n";
    $subject = $mail_settings->mail_subject;

    $message= "<div style='max-width:100%;margin:4rem;background:#e7eeef;border:1px solid #696969;'><h2 style='padding:2rem;text-align:center;'>".__('Binary MLM Woocommerce','BMW')."<br/>([site_name])</h2><h4 style='padding:1rem;text-align:center;'>".__('Registration Success','BMW')."</h4><hr/>";
    $message.=$mail_settings->mail_message;
    $message.='</div>';
    $message= bmw_filter_message($message,$mail_settings->mail_name,$user_id);
      if($mail_settings->mail_to=='user'){
      wp_mail($user_info->user_email, $subject, $message, $headers);
        }else if ($mail_settings->mail_to=='admin') {
            $admin_email=get_option('admin_email');
            wp_mail($admin_email, $subject, $message, $headers);
            }else if($mail_settings->mail_to=='both'){
                  $admin_email=get_option('admin_email');
                  wp_mail($admin_email, $subject, $message, $headers);
                  wp_mail($user_info->user_email, $subject, $message, $headers);
                  }}
function bmw_send_invitation_hook_function(){

    global $wpdb;
    $return=array();
    $return['status']=false;
    unset($_POST['action']);
    $post=sanitize_text_array($_POST);
    $email=$post['invite_mail'];
    if(!empty($email) && is_email($email))
    {
    $affiliateURL=bmw_affiliate_url_function();
    $mail_settings=$wpdb->get_row("SELECT * FROM {$wpdb->prefix}bmw_mail_settings WHERE mail_name='invitation_mail'");
    $siteownwer = get_bloginfo('name');
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
    $headers .= "From: " . get_option('admin_email') . "<" . get_option('admin_email') . ">" . "\r\n";
    $to = $email; 
    if (empty($mail_settings)) {
       $subject = __('Invitation Link','BMW'); 
    }else{$subject = "$mail_settings->Subject";}
    $subject = "$mail_settings->Subject";
    add_filter( 'wp_mail_content_type', 'set_html_content_type' );
    $message="$mail_settings->message
            <table>
            <tr><td style='color:blue;text-align:center'>".__('Affiliate Link','BMW')."</td>
            </tr><tr><td style='color:red;cursor:pointer;text-align:center'><a href='$affiliateURL'>$affiliateURL</a></td></tr>
            </table>";
   wp_mail($to, $subject, $message, $headers);
   $return['status']=true;
   $return['message']=__('Your invitation send successfully.','BMW');
  }else{
   $return['message']=__('Something went wrong please check...','BMW');
    $return['status']=false;
  }
  echo json_encode($return);
  wp_die();
}
function messgae_center_mail($to,$subject,$message){

    global $wpdb;
    $siteownwer = get_bloginfo('name');
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
    $headers .= "From: " . get_option('admin_email') . "<" . get_option('admin_email') . ">" . "\r\n";
    $subject = "$subject";
    add_filter( 'wp_mail_content_type', 'set_html_content_type' );
    $message="$message";
   wp_mail($to, $subject, $message, $headers);
}
function set_html_content_type() {
return 'text/html';
} 









///////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////Payout Functions /////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////

function bmw_user_pair_commission_sum_for_payout($user_key){
    global $wpdb;
    $commission=$wpdb->get_var("SELECT SUM(amount) as total FROM {$wpdb->prefix}bmw_pair_commission WHERE user_key='".$user_key."' AND payout_id='0' AND status='1'");

    return ($commission>0)?$commission:0;
}
function bmw_user_referral_commission_sum_for_payout($user_key){
    global $wpdb;
    $commission=$wpdb->get_var("SELECT SUM(amount) as total FROM {$wpdb->prefix}bmw_referral_commission  WHERE user_key='".$user_key."'  AND status='0'");

    return ($commission>0)?$commission:0;
}
function bmw_user_faststart_commission_sum_for_payout($user_key){
    global $wpdb;
    $commission=$wpdb->get_var("SELECT SUM(bonus_amount) as total FROM {$wpdb->prefix}bmw_faststart_bonus_commission  WHERE user_key='".$user_key."' AND payout_id='0' AND status='1'");

    return ($commission>0)?$commission:0;
}
function bmw_user_onetime_commission_sum_for_payout($user_key){
    global $wpdb;
    $commission=$wpdb->get_var("SELECT SUM(amount) as total FROM {$wpdb->prefix}bmw_leader_one_time_bonus  WHERE user_key='".$user_key."' AND payout_id='0' AND status='1'");

    return ($commission>0)?$commission:0;
}
function bmw_user_leader_commission_for_payout($user_key){
    global $wpdb;
    $commission=$wpdb->get_var("SELECT SUM(leadership_bonus) as total FROM {$wpdb->prefix}bmw_leadership_bonus_commission  WHERE user_key='".$user_key."' AND payout_id='0' AND status='1'");

    return ($commission>0)?$commission:0;
}
function bmw_user_level_commission_for_payout($user_key){
    global $wpdb;
    $commission=$wpdb->get_var("SELECT SUM(amount) as total FROM {$wpdb->prefix}bmw_level_commission  WHERE sponsor_key='".$user_key."' AND payout_id='0' AND status='1'");

    return ($commission>0)?$commission:0;
}
function bmw_user_regular_bonus_for_payout($user_key){
    global $wpdb;
    $bonus=$wpdb->get_var("SELECT SUM(amount) as total FROM {$wpdb->prefix}bmw_bonus_commission  WHERE user_key='".$user_key."' AND payout_id='0' AND status='0'");

    return ($bonus>0)?$bonus:0;
}


function bmw_eligibility_check_for_commission($user_key){
    global $wpdb;
    //get the eligibility for commission and bonus
    $eligibility = get_option('bmw_manage_eligibility');
    $settings=get_option('bmw_manage_general');
    $leftusers =0;
    $rightusers =0;
    $total_referral =0;
    $personal_points =false;
    $root_key=bmw_get_top_user_key();
    $results =$wpdb->get_results("SELECT user_key,position FROM {$wpdb->prefix}bmw_users WHERE  payment_status = '1' AND sponsor_key = '".$user_key."'");
    $num = $wpdb->num_rows;

    if($num>0 && !empty($eligibility))
    {
        foreach($results as $result)
        {
            if($result->position == 'left') { 
                $leftusers++; 
            }
            if($result->position == 'right') { 
                $rightusers++; 
            }
            $total_referral++;
        } 
    
    if(isset( $settings['bmw_plan_base']) &&  $settings['bmw_plan_base']=='points'){

    if(isset( $eligibility['bmw_minimum_personal_points']) && !empty( $eligibility['bmw_minimum_personal_points']))
    {
       $qpv=$wpdb->get_var("SELECT qualified_points FROM {$wpdb->prefix}bmw_users WHERE  payment_status = '1' AND user_key = '".$user_key."'");
      if($qpv >= $eligibility['bmw_minimum_personal_points'])
      {
        $personal_points=true;
      }
    }
    }else{
      $personal_points=true;
    }
  }

    $user_id=bmw_get_user_id_by_userkey($user_key);
    $self_value_limit=$eligibility['bmw_cake4u_personal_volume'];
    $self_value= bmw_get_total_purchase_by_user_id($user_id);
  if($root_key==$user_key){
    $self_value=1;
  }elseif($self_value_limit<=$self_value){
    $self_value=1;
  }else{
    $self_value=0;
  }
    
    if ($leftusers >= $eligibility['bmw_referral_left'] &&
        $rightusers >= $eligibility['bmw_referral_right'] &&
        $total_referral >= $eligibility['bmw_direct_referrals'] && $self_value && $personal_points==true) { 
      return true;
     } else {
      return false;
  }

}





// function get_user_pair_commission($user_id,$user_key)
// {
//     global $wpdb; 
//     $commission_amount=0;
//     $payout_settings = get_option('bmw_manage_payout');
//     $eligibility_settings = get_option('bmw_manage_eligibility');
//     if(!empty($payout_settings)){
//     do{
//     $childs = array();
//     $commission_count=$wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}bmw_pair_commission WHERE user_key='".$user_key."'");

   
//      $pair1 = $payout_settings['bmw_pair1'];
//      $pair2 = $payout_settings['bmw_pair2'];

  
//     $leftQuery = $wpdb->get_results("SELECT `bh`.`user_key` FROM {$wpdb->prefix}bmw_hierarchy as `bh` JOIN {$wpdb->prefix}bmw_users as  `u` ON `u`.`user_key`=`bh`.`user_key`  WHERE  `bh`.sponsor_key='".$user_key."' AND `bh`.parent_key='".$user_key."'  AND `bh`.commission_status = '0' AND `u`.payment_status='1' AND `bh`.position='0' ORDER BY `bh`.id ASC LIMIT $pair1");
//     $rightQuery = $wpdb->get_results("SELECT `bh`.`user_key` FROM {$wpdb->prefix}bmw_hierarchy as `bh` JOIN {$wpdb->prefix}bmw_users as  `u` ON `u`.`user_key`=`bh`.`user_key`  WHERE  `bh`.sponsor_key='".$user_key."' AND `bh`.parent_key='".$user_key."'  AND `bh`.commission_status = '0' AND `u`.payment_status='1' AND `bh`.position='1'  ORDER BY `bh`.id ASC LIMIT $pair2");

//     $right_amount=0;
//     $left_amount=0;
//     if(COUNT($leftQuery) >= $pair1 && COUNT($rightQuery)>=$pair2)
//     {
//           foreach ($rightQuery as $RQ) {
//            $wpdb->query("UPDATE {$wpdb->prefix}bmw_hierarchy  SET commission_status = '1' WHERE parent_key = '".$user_key."'  AND user_key='".$RQ->user_key."' AND sponsor_key='".$user_key."'  LIMIT 1 ");
//            $rid=bmw_get_user_id_by_userkey($RQ->user_key);
//            $right_amount+=bmw_get_total_purchase_by_user_id($rid);
//               $childs[]=$RQ->user_key;
//           }
          
//           foreach ($leftQuery as $LQ) {
//             $wpdb->query(" UPDATE {$wpdb->prefix}bmw_hierarchy  SET commission_status = '1' WHERE parent_key = '$user_key'  AND user_key='".$LQ->user_key."' AND sponsor_key='".$user_key."' LIMIT 1");
//             $lid=bmw_get_user_id_by_userkey($LQ->user_key);
//             $left_amount+=bmw_get_total_purchase_by_user_id($lid);
//               $childs[]= $LQ->user_key;
//           }
//           $purchase_amount=0;

//           foreach ($childs as $key => $child_key) {
//             $cid=bmw_get_user_id_by_userkey($child_key);
//             $purchase_amount+=bmw_get_total_purchase_by_user_id($cid);
//           }
//             $pair_commission_amount=min($right_amount,$left_amount);
//             echo $right_amount.'//'.$left_amount.'//'.$pair_commission_amount;
//             $week_provanue=$payout_settings['bmw_week_provenue'];
//             $direct_bonus=$payout_settings['bmw_initial_pair_commission_amount'];
//             if(!empty($week_provanue) && !empty($pair_commission_amount)){
//                  if ($payout_settings['bmw_initial_pair_commission_type'] == 'percentage') {
//                      $commission_amount= ($pair_commission_amount*$week_provanue/100)*$direct_bonus/100;
//                   }else{
//                      $commission_amount= ($pair_commission_amount*$week_provanue/100)*$direct_bonus/100;
//                   }
//             }
         
//         if(isset($commission_amount) && !empty($commission_amount)){
//         $wpdb->query("INSERT INTO {$wpdb->prefix}bmw_pair_commission  SET user_key='".$user_key."', childs='".serialize($childs)."', amount='".$commission_amount."', status='0',insert_date='".date_i18n('Y-m-d H:i:s')."',paid_price='".$pair_commission_amount."'");
//         }
//     }

//   }while ((COUNT($leftQuery) >= $pair1 && COUNT($rightQuery)>=$pair2));

//     return $wpdb->get_results("SELECT * FROM {$wpdb->prefix}bmw_pair_commission WHERE user_key='".$user_key."' AND status='0'");
//   }
// }
function get_user_pair_commission($user_id,$user_key,$leader_id)
{
    global $wpdb; 
    $commission_amount=0;
    $binary_bonus_percent=get_binary_bonus_by_leader_id($leader_id);
    $payout_settings = get_option('bmw_manage_payout');
    $eligibility_settings = get_option('bmw_manage_eligibility');
    if(!empty($payout_settings)){
   
    $childs = array();
    $commission_count=$wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}bmw_pair_commission WHERE user_key='".$user_key."'");

   
     $pair1 = $payout_settings['bmw_pair1'];
     $pair2 = $payout_settings['bmw_pair2'];
  
    $leftQuery = $wpdb->get_results("SELECT `bh`.`user_key` FROM {$wpdb->prefix}bmw_hierarchy as `bh` JOIN {$wpdb->prefix}bmw_users as  `u` ON `u`.`user_key`=`bh`.`user_key`  WHERE   `bh`.parent_key='".$user_key."'  AND `bh`.commission_status = '0' AND `u`.payment_status='1' AND `bh`.position='0' ORDER BY `bh`.id ASC ");
    $rightQuery = $wpdb->get_results("SELECT `bh`.`user_key` FROM {$wpdb->prefix}bmw_hierarchy as `bh` JOIN {$wpdb->prefix}bmw_users as  `u` ON `u`.`user_key`=`bh`.`user_key`  WHERE `bh`.parent_key='".$user_key."'  AND `bh`.commission_status = '0' AND `u`.payment_status='1' AND `bh`.position='1'  ORDER BY `bh`.id ASC ");

    $right_amount=0;
    $left_amount=0;
    if(!empty($leftQuery) && !empty($rightQuery))
    {
          foreach ($rightQuery as $RQ) {
           $rid=bmw_get_user_id_by_userkey($RQ->user_key);
           $right_amount+=bmw_get_total_purchase_by_user_id($rid);
              $childs[]=$RQ->user_key;
          }
          
          foreach ($leftQuery as $LQ) {
            $lid=bmw_get_user_id_by_userkey($LQ->user_key);
            $left_amount+=bmw_get_total_purchase_by_user_id($lid);
              $childs[]= $LQ->user_key;
          }
         
          $purchase_amount=0;

          foreach ($childs as $key => $child_key) {
            $cid=bmw_get_user_id_by_userkey($child_key);
            $purchase_amount+=bmw_get_total_purchase_by_user_id($cid);
          }
          
            $pair_commission_amount=min($right_amount,$left_amount);
            $week_provanue=$payout_settings['bmw_week_provenue'];
           
            if(!empty($week_provanue) && !empty($pair_commission_amount)){
                 if ($payout_settings['bmw_initial_pair_commission_type'] == 'percentage') {
                     $commission_amount= ($pair_commission_amount*$week_provanue/100)*$binary_bonus_percent/100;
                  }else{
                     $commission_amount= ($pair_commission_amount*$week_provanue/100)*$binary_bonus_percent/100;
                  }
            }
           
     
        if(isset($commission_amount) && !empty($commission_amount) &&  checkPayoutRunDay('insert_date',$user_key,'bmw_pair_commission')){
        $wpdb->query("INSERT INTO {$wpdb->prefix}bmw_pair_commission  SET user_key='".$user_key."', childs='".serialize($childs)."', amount='".$commission_amount."', status='0',insert_date='".date_i18n('Y-m-d H:i:s')."',paid_price='".$pair_commission_amount."'");
        }
    }

    return $wpdb->get_results("SELECT * FROM {$wpdb->prefix}bmw_pair_commission WHERE user_key='".$user_key."' AND status='0'");
  }
}





function get_user_display_regular_bonus($user_key){

 global $wpdb;
    $bmw_bonuses = get_option('bmw_bonus');
    $payout_settings = get_option('bmw_manage_payout');
    $bmw_bonus_criteria = get_option('bmw_bonus_criteria');
    $bonus_pair=0;
    if($bmw_bonus_criteria == 'personal')
    {
        $bonus_no = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}bmw_users WHERE sponsor_key = '".$user_key."'  AND payment_status = '1'");
        $bonus_pair = $bonus_no;
    }
    else if($bmw_bonus_criteria == 'pair')
    {
    
    $bonus_pair=$wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}bmw_pair_commission WHERE user_key = '".$user_key."'");
    }
    if(!empty($bmw_bonuses)){
    foreach($bmw_bonuses as $bmw_bonus){
        $total = bmw_distributeBonusSlab($user_key);
        if(!empty($bonus_pair) && ($bonus_pair>=$bmw_bonus['pair']) && !is_bonus_exist($user_key,$bmw_bonus['pair'])){
            $wpdb->query("INSERT INTO {$wpdb->prefix}bmw_bonus_commission SET user_key='".$user_key."', amount='".$bmw_bonus['amount']."', bonus_count='".$bmw_bonus['pair']."', insert_date='".date_i18n('Y-m-d H:i:s')."'"); 
        } 
    }
  }

$returndata=$wpdb->get_results("SELECT * FROM {$wpdb->prefix}bmw_bonus_commission WHERE user_key='".$user_key."' AND status='0' AND payout_id='0'");
return $returndata;
}


function bmw_distributeBonusSlab($user_key)
{
    global $wpdb;
    //count how many times bonus have been paid by the system previously
    $sum = $wpdb->get_var("SELECT SUM(bonus_count) FROM {$wpdb->prefix}bmw_bonus_commission WHERE user_key='".$user_key."'");
    return (isset($sum) && !empty($sum))?$sum:0;
}
function is_bonus_exist($user_key,$pair)
{
    global $wpdb;
    $sum = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}bmw_bonus_commission WHERE user_key='".$user_key."' AND bonus_count='".$pair."'");
   return(isset($sum) && !empty($sum))?true:false;
}

function bmw_getPair($leftcount, $rightcount)
{
    $bmw_manage_payout = get_option('bmw_manage_payout');

    $pair1 = $bmw_manage_payout['bmw_pair1'];
    $pair2 = $bmw_manage_payout['bmw_pair2'];

    $leftpair = (int)($leftcount/$pair1);
    $rightpair = (int)($rightcount/$pair2);

    if($leftpair <= $rightpair)
        $pair = $leftpair;
    else
        $pair = $rightpair;

    $leftbalance = $leftcount - ($pair * $pair1);
    $rightbalance = $rightcount - ($pair * $pair2);

    $returnarray['leftbal'] = $leftbalance;
    $returnarray['rightbal'] = $rightbalance;
    $returnarray['pair'] = $pair;

    return $returnarray;
}






function bmw_distribute_commission_function()
{ global $wpdb;
  if(isset($_POST['action']) && $_POST['action']=='bmw_distribute_commission')
  {
     $wpdb->query("UPDATE {$wpdb->prefix}bmw_pair_commission SET status='1' WHERE status='0' AND payout_id='0'");
     $wpdb->query("UPDATE {$wpdb->prefix}bmw_faststart_bonus_commission SET status='1' WHERE status='0' AND payout_id='0'");
     $wpdb->query("UPDATE {$wpdb->prefix}bmw_leadership_bonus_commission SET status='1' WHERE status='0' AND payout_id='0'");
     $wpdb->query("UPDATE {$wpdb->prefix}bmw_leader_one_time_bonus SET status='1' WHERE status='0' AND payout_id='0'");
     $wpdb->query("UPDATE {$wpdb->prefix}bmw_direct_commission SET status='1' WHERE status='0' AND payout_id='0'");
     // $wpdb->query("UPDATE {$wpdb->prefix}bmw_referral_commission SET status='1' WHERE status='0' AND payout_id='0'");
     // $wpdb->query("UPDATE {$wpdb->prefix}bmw_level_commission SET status='1' WHERE status='0' AND payout_id='0'");
     // $wpdb->query("UPDATE {$wpdb->prefix}bmw_bonus_commission SET status='1' WHERE status='0' AND payout_id='0'");

    bmw_run_payout_function();
  }
}


function bmw_payout_display_functions()
    {

    global $wpdb;
    $displayDataArray=array();
    $results = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}bmw_users WHERE payment_status='1'");
    $payout_settings = get_option('bmw_manage_payout',true);
    if(!empty($results))
    {
      foreach($results as $key=>$row)
      {
        $totalamount=0;
        $netAmount=0;
            $user_key = $row->user_key;
            $user_id = $row->user_id;
            $pair_commission=bmw_user_pair_commission_sum_for_payout($user_key);
            $referral_commission=bmw_user_referral_commission_sum_for_payout($user_key);
            $referral_commission=($referral_commission*$payout_settings['bmw_week_provenue']/100)*$payout_settings['bmw_referral_commission_amount']/100;
            $faststart_commission=bmw_user_faststart_commission_sum_for_payout($user_key);
            $one_time_commission=bmw_user_onetime_commission_sum_for_payout($user_key);
            $leadership_commission=bmw_user_leader_commission_for_payout($user_key);
            // $regular_bonus=bmw_user_regular_bonus_for_payout($user_key);
            $totalamount = $pair_commission+$referral_commission+$faststart_commission+$leadership_commission+$one_time_commission;

          $total_points=0;  
          $settings=get_option('bmw_manage_general');
          if(isset($settings['bmw_plan_base']) && $settings['bmw_plan_base']=='points')
          {
            $points_value=@$settings['bmw_points_value'];
            if(isset($points_value))
            {
              $total_points=$totalamount;
              $totalamount=$totalamount/$points_value;
            }else
            {
              if($key<1){
              echo '<span class="let-alert let-alert-danger let-rounded-0 let-p-1 let-w-100">'.__('Please Set Points Value','BMW').'</span>';
              }continue;
            }
          }

        $service_charge=0;
        if(isset($payout_settings['bmw_service_charge_amount']) && !empty($payout_settings['bmw_service_charge_amount'])){
            if ($payout_settings['bmw_service_charge_type']=='fixed' && !empty($payout_settings['bmw_service_charge_type'])) {
                $service_charge=$payout_settings['bmw_service_charge_amount'];
            }else if($payout_settings['bmw_service_charge_type']=='percentage' && !empty($payout_settings['bmw_service_charge_type'])){
                $service_charge=$totalamount*$payout_settings['bmw_service_charge_amount']/100;
                }
              }
        $txamount=0;
        if(isset($payout_settings['bmw_tds']) && !empty($payout_settings['bmw_tds'])){
            if ($payout_settings['bmw_tds_type']=='fixed' && !empty($payout_settings['bmw_tds'])) {
                $txamount=$payout_settings['bmw_tds'];
            } else if($payout_settings['bmw_tds_type']=='percentage' && !empty($payout_settings['bmw_tds'])){
               $txamount=$totalamount*$payout_settings['bmw_tds']/100;
                }
        }
        if($totalamount>0){
          $netAmount = $totalamount-($service_charge+$txamount);
        }

        if ($netAmount!=0) {
    
            $displayDataArray[$key]['user_key'] = $user_key;
            $displayDataArray[$key]['user_id'] = $user_id;
            $displayDataArray[$key]['username'] = $row->user_name;
            $displayDataArray[$key]['pair_commission'] = $pair_commission;
            $displayDataArray[$key]['referral_commission'] = $referral_commission;
            $displayDataArray[$key]['faststart_commission'] = $faststart_commission;
            $displayDataArray[$key]['leadership_commission'] = $leadership_commission;
            $displayDataArray[$key]['one_time_commission'] = $one_time_commission;
            $displayDataArray[$key]['service_charge'] = $service_charge;
            $displayDataArray[$key]['tds'] = $txamount;
            $displayDataArray[$key]['total_commission'] = $totalamount;
            if($total_points>0){
            $displayDataArray[$key]['total_points'] = $total_points;
            }
            $displayDataArray[$key]['net_amount'] = $netAmount;
        }
      }
    }

    return $displayDataArray;
    
    }


function bmw_run_payout_function()
{

global $wpdb;
$payouts=bmw_payout_display_functions();
  if(!empty($payouts)){
   $total_payout=0;
   $wpdb->query("INSERT INTO {$wpdb->prefix}bmw_payout_master SET total_payout='0.00', insert_date='".date_i18n('Y-m-d H:i:s')."'");
   $payout_id = $wpdb->insert_id;
   $email_data=array();
   if(isset($payout_id) && !empty($payout_id)){
    foreach($payouts as $row)
    {  

    $wpdb->query("INSERT INTO {$wpdb->prefix}bmw_payout SET user_key='".$row['user_key']."', payout_id='".$payout_id."', pair_commission='".$row['pair_commission']."', referral_commission='".$row['referral_commission']."', one_time_bonus='".$row['one_time_commission']."', faststart_commission='".$row['faststart_commission']."', leadership_commission='".$row['leadership_commission']."', total_points='".$row['total_points']."', total_amount='".$row['net_amount']."', total_bonus='".$row['total_commission']."', tax='".$row['tds']."', service_charge='".$row['service_charge']."',insert_date='".date_i18n('Y-m-d H:i:s')."'");
    $total_payout+=$row['net_amount'];

     $wpdb->query("UPDATE {$wpdb->prefix}bmw_pair_commission SET status='2', payout_id='".$payout_id."' WHERE status='1' AND payout_id='0' AND user_key='".$row['user_key']."'");
     // $wpdb->query("UPDATE {$wpdb->prefix}bmw_referral_commission set status='1', payout_id='".$payout_id."' WHERE  payout_id='0' AND user_key='".$row['user_key']."'");
     $wpdb->query("UPDATE {$wpdb->prefix}bmw_direct_commission set status='2', payout_id='".$payout_id."' WHERE  payout_id='0' AND user_key='".$row['user_key']."'");
     $wpdb->query("UPDATE {$wpdb->prefix}bmw_faststart_bonus_commission SET status='2', payout_id='".$payout_id."' WHERE status='1' AND payout_id='0' AND user_key='".$row['user_key']."'");
     $wpdb->query("UPDATE {$wpdb->prefix}bmw_leader_one_time_bonus SET status='2', payout_id='".$payout_id."' WHERE status='1' AND payout_id='0' AND user_key='".$row['user_key']."'");
     $wpdb->query("UPDATE {$wpdb->prefix}bmw_leadership_bonus_commission SET status='2', payout_id='".$payout_id."' WHERE status='1' AND payout_id='0' AND user_key='".$row['user_key']."'");
     $email_data[]=array('user_id'=>$row['user_id'],'payout_id'=>$payout_id);
     $wpdb->query("UPDATE {$wpdb->prefix}bmw_payout_master SET total_payout='".$total_payout."' WHERE payout_id='".$payout_id."'");
     // $('.let-loader-layer').append('<span style="position:absolute;top:55%;left:45%;color:#fff">Completed 15/50</span>');
   }
      foreach($payouts as $row)
      {  
        do_action('bmw_after_user_payout_insert',$row,$payout_id);
      }
     if(!empty( $email_data))
     {
        foreach ($email_data as $key => $email) {
          bmw_send_payout_mail($email['user_id'], $email['payout_id']);
        }
      }
  }
}
}

function bmw_install_addon_function()
{
  unset($_POST['action']);
  $plugin=sanitize_text_field($_POST['plugin']);
  $plugins=array();
    $plugins['mycred']=array(
      'name'=>'mycred',
      'install'=>'mycred/mycred.php',
      'path'=>'https://downloads.wordpress.org/plugin/mycred.latest-stable.zip'
    );
    $plugins['terawallet']=array(
      'name'=>'woo-wallet',
      'install'=>'woo-wallet/woo-wallet.php',
      'path'=>'https://downloads.wordpress.org/plugin/woo-wallet.latest-stable.zip'
    );
$status=bmw_get_plugins($plugins[$plugin]);
echo $status;
wp_die();
}



function bmw_get_plugins($plugin) {
  $plugin_slug = $plugin['install'];
  $plugin_zip = $plugin['path'];
  if ( bmw_is_plugin_installed( $plugin_slug ) ) {
    bmw_upgrade_plugin( $plugin_slug );
    $installed = true;
  } else {
   $installed =  bmw_install_plugin( $plugin_zip );
  }
  if ($installed) {
    $activate = activate_plugin( $plugin_slug );
  }
  if ( bmw_is_plugin_installed( $plugin_slug ) ) {
    return true;
  }else{
    return false;
  }
}
   
function bmw_is_plugin_installed( $slug ) {
  if ( ! function_exists( 'get_plugins' ) ) {
    require_once ABSPATH . 'wp-admin/includes/plugin.php';
  }
  $all_plugins = get_plugins();
  if ( !empty( $all_plugins[$slug] ) ) {
    return true;
  } else {
    return false;
  }
}
 
function bmw_install_plugin( $plugin_zip ) {
  include_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
  wp_cache_flush();
   
  $upgrader = new Plugin_Upgrader();
  $installed = $upgrader->install( $plugin_zip );
 
  return $installed;
}
 
function bmw_upgrade_plugin( $plugin_slug ) {
  include_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
  wp_cache_flush();
  $upgrader = new Plugin_Upgrader();
  $upgraded = $upgrader->upgrade( $plugin_slug );
 
  return $upgraded;
}


function bmw_after_user_payout_insert_function($payout,$payout_id)
{
  global $wpdb;

if(is_plugin_active('woo-wallet/woo-wallet.php'))
{
  $terasettings=get_option('bmw_woo_wallet_setting');
  if (class_exists('Woo_Wallet_Wallet') && isset($terasettings['bmw_woo_wallet_status']) && $terasettings['bmw_woo_wallet_status']==1) {
        $wallet = new Woo_Wallet_Wallet();
        $wallet->credit($payout['user_id'],$payout['net_amount'],sprintf(__('Payout id %d credits','BMW'),$payout_id));

  }
}

if(is_plugin_active('mycred/mycred.php'))
{ 
  $mycredsettings=get_option('bmw_mycred_setting');
  if(function_exists('mycred_add') && isset($mycredsettings['bmw_woo_wallet_status']) && $mycredsettings['bmw_mycred_status']==1)
  {
    mycred_add(sprintf(__('Payout id %d credits','BMW'),$payout_id), $payout['user_id'], $payout['net_amount'], 'payout_credits', $payout_id, array('ref_type'=>'Payout','link_url'=>'...'));
  }
}

}

function bmw_debit_bal_function($user_id,$amount,$ref_id)
{
  global $wpdb;

if(is_plugin_active('woo-wallet/woo-wallet.php'))
{
  $terasettings=get_option('bmw_woo_wallet_setting');
  if (class_exists('Woo_Wallet_Wallet') && isset($terasettings['bmw_woo_wallet_status']) && $terasettings['bmw_woo_wallet_status']==1) {
        $wallet = new Woo_Wallet_Wallet();
        $wallet->debit($user_id,$amount,sprintf(__('Withdrawal %d Debit','BMW'),$ref_id));
  }
}
if(is_plugin_active('mycred/mycred.php'))
{ 
  $mycredsettings=get_option('bmw_mycred_setting');
  if( isset($mycredsettings['bmw_woo_wallet_status']) && $mycredsettings['bmw_mycred_status']==1)
  {
    mycred_subtract(sprintf(__('Withdrawal id %d credits','BMW'),$ref_id), $user_id, $amount, 'withdrawal_debit', $ref_id, array('ref_type'=>'Withdrawal','link_url'=>'...'));
  }
}

}


 function bmw_register_mlm_user($user_id, $order_id){
        global $wpdb;
        if( !empty(get_post_meta( $order_id, 'bmw_sponsor_id', true ))){
            $general_settings=get_option('umw_general_settings');
            $sponsor_name = get_post_meta( $order_id, 'bmw_sponsor_id', true );
            $parent_name = get_post_meta( $order_id, 'bmw_parent', true );
            $position = get_post_meta( $order_id, 'bmw_position', true );
            $parent_key=bmw_get_userkey_by_username($parent_name);
            $sponsor_key=bmw_get_userkey_by_username($sponsor_name);
            }

            if(!empty($sponsor_key) && !empty($parent_key) && !empty($position))
            {
              $user=get_user_by('ID',$user_id);
              $childs=$wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}bmw_users WHERE parent_key = '".$parent_key."'");
              if(check_parent_network($parent_key,$sponsor_key,$childs))
              {
          $user_key=bmw_generateKey();

          $levels=get_option('bmw_level_settings');
          $parent_row=get_network_row_by_key($parent_key);
          $n_row=$parent_row+1;
          //insert the data into wp_bmw_user table
          $insert = "INSERT INTO {$wpdb->prefix}bmw_users (user_id, user_name, user_key, parent_key, sponsor_key, position,creation_date,network_row)
          VALUES('".$user_id."','".$user->user_login."', '".$user_key."', '".$parent_key."', '".$sponsor_key."', '".$position."', '".date_i18n('Y-m-d h:i:s')."','".$n_row."')";
          if($wpdb->query($insert))
          {
            wp_update_user(array('ID' => $user_id, 'role' => 'bmw_user'));
            //entry on Left and Right Leg tables
            if($position=='left')
            {
              $wpdb->query("INSERT INTO {$wpdb->prefix}bmw_hierarchy SET user_key='".$user_key."', parent_key='".$parent_key."', sponsor_key='".$sponsor_key."',position='0', n_row='".$n_row."'");
            }
            else if($position=='right')
            {
             $wpdb->query("INSERT INTO {$wpdb->prefix}bmw_hierarchy SET user_key='".$user_key."', parent_key='".$parent_key."', sponsor_key='".$sponsor_key."',position='1', n_row='".$n_row."'");
            }
      
      while($parent_key!='0')
            {
              $result = $wpdb->get_row("SELECT COUNT(*) as num, parent_key, position FROM {$wpdb->prefix}bmw_users WHERE user_key = '".$parent_key."'");
              if($result->num==1)
              {
                if($result->parent_key!='0')
                {
                  if($result->position=='right')
                  {
                     $wpdb->query("INSERT INTO {$wpdb->prefix}bmw_hierarchy SET user_key='".$user_key."', parent_key='".$result->parent_key."', sponsor_key='".$sponsor_key."',position='1',  n_row='".$n_row."'");
                  }
                  else
                  {
                    $wpdb->query("INSERT INTO {$wpdb->prefix}bmw_hierarchy SET user_key='".$user_key."', parent_key='".$result->parent_key."', sponsor_key='".$sponsor_key."',position='0',  n_row='".$n_row."'");
                  }
                }
                $parent_key = $result->parent_key;
              }
              else
              {
                $parent_key = '0';
              }
            }
            do_action('bmw_after_registration_action',$user_id);
      }
      
    }
         }  
            }// end of if condition 
       

    function select_payment_status_exist_function(){
  global $wpdb;
   $json=array();
  $json['status']=false;
  $select_payment_status=sanitize_text_field($_POST['select_status']);
  $id=$_POST['id'];
  $before_satatus=$wpdb->get_var("SELECT payment_status FROM {$wpdb->prefix}bmw_users WHERE user_id='$id' ");
  
    $wpdb->query("UPDATE {$wpdb->prefix}bmw_users SET payment_status='$select_payment_status' WHERE user_id='$id'");
     $json['status']=true;
    $json['message']=__("succesfully update","bmw");

 echo json_encode($json);
 wp_die();
}

function get_leadership_bonus_setting(){
  global $wpdb;
  return  $wpdb->get_results("SELECT * FROM {$wpdb->prefix}bmw_leadership_commission_setting"); 
}
function exist_class_id($id){
  global $wpdb;
  return $wpdb->get_var("SELECT `id` FROM {$wpdb->prefix}bmw_leadership_commission_setting WHERE id='$id' ");
}

function first_user_created(){
  global $wpdb;
  return $users=$wpdb->get_var("SELECT * FROM {$wpdb->prefix}bmw_users WHERE parent_key='0' AND sponsor_key='0' ");

}

function bmw_insert_leadership_commission(){
     global $wpdb;
     $setting=get_leadership_bonus_setting();

     $users=$wpdb->get_results("SELECT * FROM {$wpdb->prefix}bmw_users where payment_status='1' order by user_id DESC ");
     
     foreach($users as $user){
         if(!empty($setting)){
            foreach($setting as $l_setting){

               $personal_sponsor=bmw_get_referrals_count($user->user_key);
               
               if($user->sponsor_key==0 && $user->parent_key==0){
                 $personal_volume=$l_setting->personal_volume;
               }else{
                 $personal_volume=bmw_get_total_purchase_by_user_id($user->user_id);
               }

               if(!empty($l_setting->inline_leader_count) && !empty($l_setting->Leader_type)){
                  $inline_leader=check_inline_leader_eligibility($user->user_id,$user->user_key,$l_setting->inline_leader_count,$l_setting->Leader_type);
               }else{
                  $inline_leader=true;
               }

               if(!empty($l_setting->group_volume)){
                 $group_volume=get_user_down_total_volume($user->user_id,$user->user_key,$l_setting->group_volume);
               }else{
                 $group_volume=true;
               }
            
               if($inline_leader && $group_volume && $personal_sponsor>=$l_setting->personal_sponsor && $personal_volume>=$l_setting->personal_volume ){
                  $wpdb->query("UPDATE {$wpdb->prefix}bmw_users SET leader_post='".$l_setting->id."' WHERE user_key='".$user->user_key."'");
               }
            }
         }
     }
}

function check_inline_leader_eligibility($user_id,$user_key,$leader_count,$leader_type){
    global $wpdb;
    $l_setting=get_leadership_bonus_setting();
    $i=1;
    foreach($l_setting as $leader){
        if($i==$leader_type){
            $leader_id=$leader->id;
         }
         $i++;
    }

    $left_side_eligibility=$wpdb->get_results("SELECT bh.user_key FROM {$wpdb->prefix}bmw_hierarchy as bh join {$wpdb->prefix}bmw_users as bu on(bh.user_key=bu.user_key) WHERE bh.parent_key='".$user_key."' AND bh.position='0' AND bu.leader_post='".$leader_id."'");

    $right_side_eligibility=$wpdb->get_results("SELECT bh.user_key FROM {$wpdb->prefix}bmw_hierarchy as bh join {$wpdb->prefix}bmw_users as bu on(bh.user_key=bu.user_key) WHERE bh.parent_key='".$user_key."' AND bh.position='1' AND bu.leader_post='".$leader_id."'");
     
    if($right_side_eligibility>=$leader_count && $left_side_eligibility>=$leader_count){
        return true;
    }else{
        return false;
    }
}
   
function get_user_down_total_volume($user_id,$user_key,$group_volume){
     global $wpdb;
     $down_volume=0;
     $left_side_eligibility=$wpdb->get_results("SELECT bu.user_id,bh.user_key FROM {$wpdb->prefix}bmw_hierarchy as bh join {$wpdb->prefix}bmw_users as bu on(bh.user_key=bu.user_key) WHERE bh.parent_key='".$user_key."' AND bh.position='0' ");

    $right_side_eligibility=$wpdb->get_results("SELECT bu.user_id,bh.user_key FROM {$wpdb->prefix}bmw_hierarchy as bh join {$wpdb->prefix}bmw_users as bu on(bh.user_key=bu.user_key) WHERE bh.parent_key='".$user_key."' AND bh.position='1' ");

     $childs=array_merge($left_side_eligibility,$right_side_eligibility);

     foreach($childs as $child){
       $down_volume+= bmw_get_total_purchase_by_user_id($child->user_id);
     }
     if(!empty($down_volume) && $group_volume<=$down_volume ){
        return true;
     }else{
        return false;
     }
   }
 function get_user_display_leadership_commission($user_key)
    {
      global $wpdb;
      $general_setting=get_option('bmw_manage_general');
      $is_leader =$wpdb->get_var("SELECT leader_post FROM {$wpdb->prefix}bmw_users WHERE user_key='".$user_key."' AND not leader_post='0'");

      if(!empty($is_leader)){
        $bonus_percent=get_leadership_bonus_by_leader_id($is_leader);
        if(!empty($bonus_percent)){
          check_leadership_bonus_time_duration_insert($user_key,$general_setting['bmw_leadership_month'],$is_leader,$bonus_percent);
         }
       }
       return $wpdb->get_results("SELECT * FROM {$wpdb->prefix}bmw_leadership_bonus_commission WHERE user_key='".$user_key."' AND status='0'");
}

 function get_leadership_bonus_by_leader_id($leader_id){
      global $wpdb;
      return $wpdb->get_var("SELECT leadership_bonus FROM {$wpdb->prefix}bmw_leadership_commission_setting WHERE id='".$leader_id."'");
 }
  function get_binary_bonus_by_leader_id($leader_id){
      global $wpdb;
      return $wpdb->get_var("SELECT binary_bonus FROM {$wpdb->prefix}bmw_leadership_commission_setting WHERE id='".$leader_id."'");
 }
 function get_leadership_one_time_bonus_by_leader_id($leader_id){
      global $wpdb;
      return $wpdb->get_var("SELECT one_time_bonus FROM {$wpdb->prefix}bmw_leadership_commission_setting WHERE id='".$leader_id."'");
 }
 function exist_onetime_bonus($user_key){
     global $wpdb;
     return $wpdb->get_var("SELECT id FROM {$wpdb->prefix}bmw_leader_one_time_bonus WHERE user_key='".$user_key."'");
 }

 function check_leadership_bonus_time_duration_insert($user_key,$months,$leader_post_id,$bonus_percent){
    global $wpdb;
    $leadership_bonus=0;
    $payout=get_option('bmw_manage_payout');
    $l_setting=get_leadership_bonus_setting();
    $insert_date=date("Y-m-d h:i:s");
    
    //one time bonus
    $check_eligibal_for_one_time_bonus=get_leadership_one_time_bonus_by_leader_id($leader_post_id);
    if(!empty($check_eligibal_for_one_time_bonus) && $check_eligibal_for_one_time_bonus!=0 && empty(exist_onetime_bonus($user_key))){
       $wpdb->query("INSERT INTO {$wpdb->prefix}bmw_leader_one_time_bonus (user_key,amount,leader_post,insert_date) values('$user_key','$check_eligibal_for_one_time_bonus','$leader_post_id','$insert_date')");
    }

    $record=$wpdb->get_var("SELECT insert_date FROM {$wpdb->prefix}bmw_leadership_bonus_commission WHERE user_key='".$user_key."' ORDER BY insert_date DESC");
    $first_leader_bonus=0;
    $current_date=strtotime(date("Y-m-d h:i:s"));
    $last_leadership_date=strtotime($record);
    $root_user_creation_date=$wpdb->get_var("SELECT creation_date FROM {$wpdb->prefix}bmw_users WHERE parent_key='0' AND sponsor_key='0'");
    $company_volume=$wpdb->get_var("SELECT SUM(total_amount) FROM {$wpdb->prefix}bmw_orders");
    $root_time=strtotime($root_user_creation_date);
    if(!empty($root_time)){
      $first_leader_bonus=($current_date-$root_time)/(30*60*60*24);  
    }

    if(!empty($payout['bmw_week_provenue']) && !empty($company_volume)){
       $leadership_bonus=($company_volume*($payout['bmw_week_provenue']*13)/100)*$bonus_percent/100;
    }
    $insert_date=date("Y-m-d h:i:s");
    if(!empty($last_leadership_date) && !empty($leadership_bonus) && !empty($company_volume)){
        $diff=$current_date-$last_leadership_date;
        $bonus_months=round($diff/(30*60*60*24));
        
        if($bonus_months>=$months){
           $wpdb->query("INSERT INTO {$wpdb->prefix}bmw_leadership_bonus_commission (user_key,amount,leadership_bonus,bonus_type,insert_date) values('$user_key','$company_volume','$leadership_bonus','$leader_post_id',$insert_date)");
        }
    }elseif(!empty($first_leader_bonus) && !empty($leadership_bonus) && !empty($company_volume)){
        if($first_leader_bonus>=$months){
           $wpdb->query("INSERT INTO {$wpdb->prefix}bmw_leadership_bonus_commission (user_key,amount,leadership_bonus,bonus_type,insert_date) values('$user_key','$company_volume','$leadership_bonus','$leader_post_id',$insert_date)");
        }
    }
    
 }

 function get_leadership_bonus_name_leader_id($leader_id){
      global $wpdb;
      return $wpdb->get_var("SELECT leader_name FROM {$wpdb->prefix}bmw_leadership_commission_setting WHERE id='".$leader_id."'");
 }
   
