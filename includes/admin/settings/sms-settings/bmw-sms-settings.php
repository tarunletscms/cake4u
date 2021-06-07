<?php 
if(!class_exists('BMW_SMS_TEMPLATE_SETTINGS'))
{
class BMW_SMS_TEMPLATE_SETTINGS {
	public static function bmw_sms_template_settings_function(){
		$gateway=get_option('bmw_sms_gateway_settings');
						if(isset($gateway) && !empty($gateway)){
					
						do_action('bmw_sms_configurations');
						}else{
							echo '<div class="has_error let-alert let-alert-danger let-rounded-0 let-text-center">'.__('Please Setup SMS Gateway before settings.','BMW').'</div>';
						}
						?>
						   <script type="text/javascript">
 jQuery(document).ready(function() {
  jQuery(".bmw_help_words").on('click', function() {
    var text        = $(this).attr('data-keyword');
    var txtarea     = document.getElementById('bmw_text_editor');
    var scrollPos   = txtarea.scrollTop;
    var caretPos    = txtarea.selectionStart;
    var front       = (txtarea.value).substring(0, caretPos);
    var back        = (txtarea.value).substring(txtarea.selectionEnd, txtarea.value.length);
    txtarea.value   = front + text + back;
    caretPos        = caretPos + text.length;
    txtarea.selectionStart  = caretPos;
    txtarea.selectionEnd    = caretPos;
    txtarea.focus();
    txtarea.scrollTop       = scrollPos;
    });
});
</script>
<?php 
						
	}
}

}