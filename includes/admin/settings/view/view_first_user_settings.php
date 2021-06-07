<?php
class BMW_First_Registration {
	public function bmw_register_first_user(){
		global $wpdb;
		$error= array();
		
if(isset($_REQUEST['first_user']) && !empty($_REQUEST['first_user']))
{
	$data=sanitize_text_array($_REQUEST['first_user']);

	$username = sanitize_user( $data['username'] );

	if(empty($username)){
		$error[] = __("Username could not be empty.",'BMW');
	}else if ( username_exists( $username ) ){
		$error[] = __("Username already exists.",'BMW');
	}

	if (empty($data['password']))
			$error[] = __("Please enter your password.",'BMW');

	if ( $data['password']!=$data['confirm_password'] )
			$error[] = __("Please confirm your password.",'BMW');

	//Do e-mail address validation
	if ( !is_email( $data['email'] ) ){
		$error[] = __("E-mail address is invalid.",'BMW');
	} else if (email_exists($data['email'])){
		$error[] = __("E-mail address is already in use.",'BMW');
	}

	if(empty($error))
		{
				$user = array
				(
					'user_login' 	=> $username,
					'user_pass' 	=> $data['password'],
					'user_email' 	=> $data['email'],
					'role'			=>'bmw_user'
				);

				$user_id = wp_insert_user($user);
				$user_key = bmw_generateKey();
				
				$wpdb->query("INSERT INTO {$wpdb->prefix}bmw_users SET user_id='".$user_id."', user_name='".$username."', user_key='".$user_key."', parent_key='0', sponsor_key='0', position='left', payment_status='1',creation_date='".date('Y-m-d H:i:s')."', payment_date='".date('Y-m-d H:i:s')."'");

				if($wpdb->insert_id)
				{
				  	update_user_meta( $user_id, 'bmw_first_name', $data['first_name'] );
				  	update_user_meta( $user_id, 'billing_first_name', $data['first_name'] );
					update_user_meta( $user_id, 'bmw_last_name', $data['last_name'] );
					update_user_meta( $user_id, 'billing_last_name', $data['last_name'] );
				  	echo "<script type='text/javascript'>location.reload(true);</script>";
				}
		}//end outer if condition
}

?>

 <div class="let-col-md-12 let-col-sm-12 ">
              <div class="let-x_panel">
                <div class="let-x_title">
                  <h2><?php _e('Register First User','BMW');?> </h2>
                  <ul class="let-nav let-navbar-right let-panel_toolbox">
                    <li><a class="let-collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                    <li><a class="let-close-link"><i class="fa fa-close"></i></a>
                    </li>
                  </ul>
                  <div class="let-clearfix"></div>
                </div>
                <div class="let-x_content">
	<form method="POST">
		<?php if(!empty($error)) :?>
			<div class="let-error settings-error notice is-dismissible">
				<p> <strong><?php _e('Please Correct the following Error(s):','BMW'); ?><br/></strong>
			       <?php foreach($error as $er){
			         echo $er."</br>";
			       } ?></p>
			</div>

<?php endif?>
		<table class="let-table let-table-bordered">
		 <tbody class="let-text-center">
		 <tr>
			<th ><?php echo __('User Name','BMW');?> :<span style="color:red">&nbsp;*</span></th>
			<td><input name="first_user[username]" class="let-regular-text let-rounded-0" id="username" type="text" placeholder="<?php _e('Enter User Name','BMW');?>" /><div id="check_user"></div></td>
		  </tr>
		  <tr>
			<th><?php echo __('Password','BMW');?> :<span style="color:red">&nbsp;*</span></th>
			<td><input name="first_user[password]" class="let-regular-text let-rounded-0" type="password" id="letscms_password" placeholder="<?php _e('Enter Password','BMW');?>" /></td>
		  </tr>
		  <tr>
			<th ><?php echo __('Confirm Password','BMW');?> :<span style="color:red">&nbsp;*</span></th>
			<td><input name="first_user[confirm_password]" class="let-regular-text let-rounded-0" type="password" id="letscms_confirm_password" placeholder="<?php _e('Enter Confirm Password','BMW');?>"/><span id="message1"></span></td>
		  </tr>
		   <tr>
			<th ><?php echo __('Email Id','BMW');?> :<span style="color:red">&nbsp;*</span></th>
			<td><input name="first_user[email]" type="email" class="let-regular-text let-rounded-0" placeholder="<?php _e('Enter Email Address','BMW');?>"/>
            <div id="check_email"></div>
            </td>
		  </tr>
		  <tr>
			<th ><?php echo __('First Name','BMW');?> :</th>
			<td><input name="first_user[first_name]" type="text" class="let-regular-text let-rounded-0" placeholder="<?php _e('Enter First Name','BMW');?>"/></td>
		  </tr>
		   <tr>
			<th><?php echo __('Last Name','BMW');?> :</th>
			<td><input name="first_user[last_name]" type="text" class="let-regular-text let-rounded-0" placeholder="<?php _e('Enter Last Name','BMW');?>"/>
			</td>
		  </tr>

		  
		</tbody>
		<tfoot >
			<tr class="let-text-center">
		  	<td colspan="2">
			<button type="submit" class='let-btn-success let-btn let-btn-sm'><?php echo __('Submit', 'BMW')?></button>
			</td>
		  </tr>
		  </tfoot>
		</table>
	</form>
	</div>
</div>
</div>
<?php
	}
}
