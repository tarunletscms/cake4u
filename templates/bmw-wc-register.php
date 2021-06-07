<?php
class BMW_WOOCOMMERCE_REGISTER{

	public function bmw_register_form()
	{
	

	global $wpdb,$current_user;
	$adminajax=admin_url('admin-ajax.php'); 
	$account=get_option('woocommerce_enable_signup_and_login_from_checkout');
 	if(isset($account) && $account=='yes' )
 { 
 	

?>
<script>
	var $=jQuery.noConflict();
	$(document).ready(function(){
				if($('#createaccount_with_bmw').is(":checked"))
			{
			  $('#createaccount_with_bmw').val(1);
			  $('.woocommerce_bmw_section').css('display','block');
			  $('#createaccount').prop("checked", true);
			  $('.create-account').css('display','block');
			  $('.woocommerce_bmw_parent_section').css('display','block');
			  $('.woocommerce_bmw_position_section').css('display','block');
			} else{
			  $('#createaccount_with_bmw').val(0);
			  $('.woocommerce_bmw_section').css('display','none');
			  $('.woocommerce_bmw_parent_section').css('display','none');
			  $('.woocommerce_bmw_position_section').css('display','none');
			}
		$('#createaccount_with_bmw').click(function(){
			if($('#createaccount_with_bmw').is(":checked"))
			{
			 $('#createaccount').prop("checked", true);
			  $('.create-account').css('display','block');
			  $('#createaccount_with_bmw').val(1);
			  $('.woocommerce_bmw_section').css('display','block');
			  $('.woocommerce_bmw_parent_section').css('display','block');
			  $('.woocommerce_bmw_position_section').css('display','block');
			} else{
				$('#createaccount_with_bmw').val(0);
			  $('.woocommerce_bmw_section').css('display','none');
			  $('.woocommerce_bmw_parent_section').css('display','none');
			  $('.woocommerce_bmw_position_section').css('display','none');
			}
			
		});


//parent check
$('#bmw_parent').blur(function(){
	$.ajax({
	    type: 'POST',
	    url: '<?php echo $adminajax;?>',
	    data: {
	        'action': 'bmw_parent_exist',
	        'parent': $(this).val(),
	        'sponsor': $('#bmw_sponsor_id').val(),
	    },
	    success: function (data) {
	    	$('#bmw_parent').addClass('let-m-0');
	    	$('.bmw_parent_message').html('');
	    	var obj = $.parseJSON(data);
	    	if(obj.status==false){
	    		$('.bmw_parent_message').html(obj.message);
	    		$('#bmw_parent').val('');
	    	} else{
	    		$("input[name=bmw_position][value=left]").removeAttr('disabled', 'disabled');
	    		$("input[name=bmw_position][value=right]").removeAttr('disabled', 'disabled');
	    		$("input[name=bmw_position][value=right]").parent().removeClass('checked');
	    		$("input[name=bmw_position][value=left]").parent().removeClass('checked');
	    		if(obj.position){
	    			if(obj.position=='left')
	    			{
	    			$("input[name=bmw_position][value=right]").parent().addClass('checked');
	    			$("input[name=bmw_position][value=left]").parent().removeClass('checked');
	    			$("input[name=bmw_position][value=right]").attr('checked', 'checked');
	    			$("input[name=bmw_position][value=left]").attr('disabled', 'disabled');
	    			}else if(obj.position=='right'){
	    			$("input[name=bmw_position][value=right]").parent().removeClass('checked');
	    			$("input[name=bmw_position][value=left]").parent().addClass('checked');
	    			$("input[name=bmw_position][value=left]").attr('checked', 'checked');
	    			$("input[name=bmw_position][value=right]").attr('disabled', 'disabled');
	    			}
	    		}
	    		$('.bmw_parent_message').html(obj.message);
	    		
	    	}
	        return false;
	    }
	});

});

$('#bmw_sponsor_id').blur(function(){
	$.ajax({
	    type: 'POST',
	    url: bmwajaxurl,
	    data: {
	        'action': 'bmw_sponsor_exist',
	        'sponsor': $(this).val(),
	    },
	    success: function (data) {
	    	$('#bmw_sponsor_id').addClass('let-m-0');
	    	$('.bmw_sponsor_message').html('');
	    	var obj = $.parseJSON(data);
	    	if(obj.status==false){
	    		$('.bmw_sponsor_message').html(obj.message);
	    		$('#bmw_sponsor_id').val('');
	    	} else{
	    		$('.bmw_sponsor_message').html(obj.message);
	    		
	    	}
	        return false;
	    }
	});

});
	});
</script>
<h3><?php _e('Binary MLM Registration','bmw');?></h3>
<p class="form-row form-row-wide create-account woocommerce-validated">
	<label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
		<input class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" id="createaccount_with_bmw" type="checkbox" name="createaccount_with_bmw" value="0"> <span><?php _e('Create an account With Binary MLM Woocommerce?','bmw');?></span>
	</label>
</p>
<p class="form-row form-row-wide create-bmw-account woocommerce_bmw_section" id="bmw_account_sponsor" style="display:none;">
	<label for="bmw_sponsor_id" class=""><?php _e('Sponsor Name','bmw');?> &nbsp;<abbr class="required" title="required">*</abbr></label>
	<span class="woocommerce-input-wrapper">
		<input type="text" class="input-text " name="bmw_sponsor_id" id="bmw_sponsor_id" placeholder=""  value="<?php if(isset($_SESSION['bmw_sponsor_name'])){echo $_SESSION['bmw_sponsor_name'];}?>"/>
		<div class="bmw_sponsor_message" style="color: red;"></div>
	</span>
</p>

<p class="form-row form-row-wide create-bmw-account woocommerce_bmw_parent_section" id="bmw_account_parent" style="display:none;">
	<label for="bmw_parent_name" class=""><?php _e('Parent Name','bmw');?> &nbsp;<abbr class="required" title="required">*</abbr></label>
	<span class="woocommerce-input-wrapper">
		<input type="text" class="input-text " name="bmw_parent" id="bmw_parent" placeholder=""  value="<?php if(isset($_SESSION['bmw_parent_name'])){echo $_SESSION['bmw_parent_name'];}?>"/>
		<div class="bmw_parent_message"></div>
	</span>
</p>
 <p class="form-row form-row-wide create-bmw-account woocommerce_bmw_position_section" id="bmw_account_position" style="display:none;">
              <?php _e('Position','BMW');?>
           
                <input type="radio" class="input-text" value="left" name="bmw_position"> &nbsp;<?php _e('Left','BMW');?> <input type="radio" class="input-text" value="right" name="bmw_position"> &nbsp;<?php _e('Right','BMW');?>
              <span class=" let-small bmw_position_message let-w-100"></span>
</p>
<?php
}
	
	}
}