<?php 
class BMW_SMS_GATEWAY {
	public static function bmw_sms_gateway_settings(){
		$error=array();
			if(isset($_REQUEST['sms_settings']) && !empty($_REQUEST['sms_settings']))
			{
			  $data=sanitize_text_array($_REQUEST['sms_settings']);
			 
			    if(isset($data['text_local_check']) && $data['text_local_check']=='on')
			    {
			    	if(empty($data['text_local_email']) || !is_email($data['text_local_email']) || empty($data['text_local_api_key']))
			    	{
			      	$error['error']=__('Text Local credentials has issue please check...','BMW');
			      	$error['class']='danger';
			    	}

			    	unset($data['twilio_check']);
			    	unset($data['twilio_phone']);
			    	unset($data['twilio_sid']);
			    	unset($data['twilio_token']);
			    	unset($data['plivo_check']);
			    	unset($data['plivo_phone']);
			    	unset($data['plivo_auth_id']);
			    	unset($data['plivo_token']);
			    }
			    if(isset($data['twilio_check']) && $data['twilio_check']=='on')
			    {
			    	if(empty($data['twilio_phone']) 
			    		|| empty($data['twilio_sid']) 
			    		|| empty($data['twilio_token']))
			    	{
			      	$error['error']=__('Twilio credentials has issue please check...','BMW');
			      	$error['class']='danger';
			    	}
			    	
			    	unset($data['text_local_check']);
			    	unset($data['text_local_email']);
			    	unset($data['text_local_api_key']);
			    	unset($data['plivo_check']);
			    	unset($data['plivo_phone']);
			    	unset($data['plivo_auth_id']);
			    	unset($data['plivo_token']);
			    }

			    if(isset($data['plivo_check']) && $data['plivo_check']=='on')
			    {
			    
			    	if(empty($data['plivo_check']) || empty($data['plivo_phone'])  || empty($data['plivo_auth_id']) || empty($data['plivo_token']))
			    	{
			      	$error['error']=__('Plivo credentials has issue please check...','BMW');
			      	$error['class']='danger';
			    	}

			    	unset($data['text_local_check']);
			    	unset($data['text_local_email']);
			    	unset($data['text_local_api_key']);
			    	unset($data['twilio_check']);
			    	unset($data['twilio_phone']);
			    	unset($data['twilio_sid']);
			    	unset($data['twilio_token']);
			    }

			 if(!empty($data) && empty($error))
			  {
			    update_option('bmw_sms_gateway_settings',$data);
			    $error['error']=__('SMS Settings has been saved successfully','BMW');
			    $error['class']='success';
			  }
			}
			$settings=get_option('bmw_sms_gateway_settings',true);
		// $balance=get_total_messages_text_local();
		?>
		<?php if(!empty($error)): ?>
		<div class="let-col-md-12 let-col-xs-12 let-alert let-bg-<?php echo $error['class'];?> let-alert-<?php echo $error['class'];?> let-rounded-0 let-p-3">
			<?php echo $error['error'];?>
		</div>
		<?php endif;?>
			<form id="sms_gateway_form" method="POST">
		<div class="let-col-md-12 let-col-sm-12 let-mt-3">
              <div class="let-x_panel">
                <div class="let-x_title let-p-2">
                	<strong class="let-pl-2"><img src="<?php echo BMW()->plugin_url().'/image/Textlocal_Logo.png';?>" height="25" width="25"> <?php _e('Text Local SMS Gateway','BMW');?></strong>
                   <ul class="let-nav let-navbar-right let-panel_toolbox">
                    <li>
                    	<label data-toggle="collapse" data-target="#collapsetextlocal" aria-expanded="<?php echo (isset($enable_gateway) && $enable_gateway=='text_local')?'true':'false';?>" aria-controls="collapsetextlocal" class="let-switch" for="text_local_check">
				        <input type="checkbox" name="sms_settings[text_local_check]" id="text_local_check" <?php echo (isset($settings['text_local_check']) && $settings['text_local_check']=='on')?'checked':'';?>/>
        					<div class="let-slider"></div>
				      </label>
                    </li>
                  </ul>
                  <div class="let-clearfix"></div>
                </div>
                <div class="let-x_content">
                	<div class="let-col-md-12 let-row let-m-0">
						<div class="let-col-md-3 let-text-center let-p-2">
							<level for="text_local_email"><?php _e('Text Local User Email','BMW');?></level>
						</div>
						<div class="let-col-md-9">
						<input type="text" class="let-form-control let-rounded-0" name="sms_settings[text_local_email]" id="text_local_email" placeholder="<?php _e('User Email');?>" value="<?php echo (isset($settings['text_local_email']))?$settings['text_local_email']:'';?>">
						</div>
						</div>
						<hr/>
						<div class="let-col-md-12 let-row let-m-0 let-mt-3">
						<div class="let-col-md-3 let-text-center let-p-2">
							<level for="text_local_api_key"><?php _e('Text Local Api Key','BMW');?></level>
						</div>
						<div class="let-col-md-9">
						<input type="text" class="let-form-control let-rounded-0" name="sms_settings[text_local_api_key]" id="text_local_api_key" value="<?php echo (isset($settings['text_local_api_key']))?$settings['text_local_api_key']:'';?>"placeholder="<?php _e('Api Key');?>">
						</div>
					</div>

				</div>
			</div>
		</div>

		<div class="let-col-md-12 let-col-sm-12 let-mt-3">
              <div class="let-x_panel">
                <div class="let-x_title let-p-2">
                	<strong class=" pl-2"><img src="<?php echo BMW()->plugin_url().'/image/twilio_logo.png';?>" height="25" width="25"> <?php _e('Twilio SMS Gateway','BMW');?></strong>
                   <ul class="let-nav let-navbar-right let-panel_toolbox">
                    <li>
                    	<label data-toggle="collapse" data-target="#collapsetwilio" aria-expanded="<?php echo (isset($enable_gateway) && $enable_gateway=='twilio')?'true':'false';?>" aria-controls="collapsetwilio" class="let-switch" for="twilio_check">
				        <input type="checkbox" name="sms_settings[twilio_check]" id="twilio_check" <?php echo (isset($settings['twilio_check']) && $settings['twilio_check']=='on')?'checked':'';?>/>
        					<div class="let-slider"></div>
				      </label>
                    </li>
                  </ul>
                  <div class="let-clearfix"></div>
                </div>
                <!-- (678) 831-6212 -->
                <div class="let-x_content">
						<div class="let-col-md-12 let-row let-m-0">
						<div class="let-col-md-3 let-text-center let-p-2">
							<level for="twilio_phone"><?php _e('Twilio Phone Number','BMW');?></level>
						</div>
						<div class="let-col-md-9">
						<input type="text" class="let-form-control let-rounded-0" name="sms_settings[twilio_phone]" id="twilio_phone" placeholder="<?php _e('Twilio Phone Number ex +19876543210');?>" value="<?php echo (isset($settings['twilio_phone']))?$settings['twilio_phone']:'';?>">
						</div>
						</div>
						<div class="let-col-md-12 let-row let-m-0 let-mt-3">
						<div class="let-col-md-3 let-text-center let-p-2">
							<level for="twilio_sid"><?php _e('Twilio ACCOUNT SID','BMW');?></level>
						</div>
						<div class="let-col-md-9">
						<input type="text" class="let-form-control let-rounded-0" name="sms_settings[twilio_sid]" id="twilio_sid" placeholder="<?php _e('Twilio ACCOUNT SID','BMW');?>" value="<?php echo (isset($settings['twilio_sid']))?$settings['twilio_sid']:'';?>">
						</div>
						</div>
						<div class="let-col-md-12 let-row let-mt-3 let-m-0">
						<div class="let-col-md-3 let-text-center let-p-2">
							<level for="twilio_token"><?php _e('Twilio AUTH TOKEN','BMW');?></level>
						</div>
						<div class="let-col-md-9">
						<input type="text" class="let-form-control let-rounded-0" name="sms_settings[twilio_token]" id="twilio_token" placeholder="<?php _e('Twilio AUTH TOKEN','BMW');?>" value="<?php echo (isset($settings['twilio_token']))?$settings['twilio_token']:'';?>">
						</div>
						</div>
						
					</div>
					</div>
					</div>

		<div class="let-col-md-12 let-col-sm-12 let-mt-3">
              <div class="let-x_panel">
                <div class="let-x_title let-p-2">
                	<strong class=" pl-2"><img src="<?php echo BMW()->plugin_url().'/image/plivo.png';?>" height="25" width="25"> <?php _e('Plivo SMS Gateway','BMW');?></strong>
                   <ul class="let-nav let-navbar-right let-panel_toolbox">
                    <li>
                    	<label data-toggle="collapse" data-target="#collapseplivo" aria-expanded="<?php echo (isset($enable_gateway) && $enable_gateway=='plivo')?'true':'false';?>" aria-controls="collapseplivo" class="let-switch" for="plivo_check">
				        <input type="checkbox" name="sms_settings[plivo_check]" id="plivo_check" <?php echo (isset($settings['plivo_check']) && $settings['plivo_check']=='on')?'checked':'';?>/>
        					<div class="let-slider"></div>
				      </label>
                    </li>
                  </ul>
                  <div class="let-clearfix"></div>
                </div>
                <!-- (678) 831-6212 -->
                <div class="let-x_content">
						<div class="let-col-md-12 let-row let-m-0">
						<div class="let-col-md-3 let-text-center let-p-2">
							<level for="twilio_phone"><?php _e('Plivo Phone Number','BMW');?></level>
						</div>
						<div class="let-col-md-9">
						<input type="text" class="let-form-control let-rounded-0" name="sms_settings[plivo_phone]" id="plivo_phone" placeholder="<?php _e('Plivo Phone Number ex +19876543210');?>" value="<?php echo (isset($settings['plivo_phone']))?$settings['plivo_phone']:'';?>">
						</div>
						</div>
						<div class="let-col-md-12 let-row let-m-0 let-mt-3">
						<div class="let-col-md-3 let-text-center let-p-2">
							<level for="plivo_auth_id"><?php _e('Plivo Auth ID','BMW');?></level>
						</div>
						<div class="let-col-md-9">
						<input type="text" class="let-form-control let-rounded-0" name="sms_settings[plivo_auth_id]" id="plivo_auth_id" placeholder="<?php _e('Plivo ACCOUNT SID','BMW');?>" value="<?php echo (isset($settings['plivo_auth_id']))?$settings['plivo_auth_id']:'';?>">
						</div>
						</div>
						<div class="let-col-md-12 let-row let-mt-3 let-m-0">
						<div class="let-col-md-3 let-text-center let-p-2">
							<level for="plivo_token"><?php _e('Plivo Auth Token','BMW');?></level>
						</div>
						<div class="let-col-md-9">
						<input type="text" class="let-form-control let-rounded-0" name="sms_settings[plivo_token]" id="plivo_token" placeholder="<?php _e('Plivo AUTH TOKEN','BMW');?>" value="<?php echo (isset($settings['plivo_token']))?$settings['plivo_token']:'';?>">
						</div>
						</div>
						
					</div>
					</div>
					</div>
					<div class="let-col-md-12  let-text-center">
					<button type="submit" class="let-btn let-btn-success let-btn-sm let-rounded-0"><?php _e('Submit','BMW');?></button>
					</div>
			</form>
		<?php
	}
}

