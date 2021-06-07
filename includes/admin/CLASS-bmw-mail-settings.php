<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'BMW_MAIL_SETTINGS', false ) ) :

	class BMW_MAIL_SETTINGS {
		
	public static function bmw_get_mail_settings(){
						do_action('bmw_mail_configurations');
			?>
			   <script type="text/javascript">
 jQuery(document).ready(function() {
jQuery('#bmw_text_editor').richText({
  bold:true,
  italic:true,
  underline:false,
  // text alignment
  leftAlign:true,
  centerAlign:true,
  rightAlign:true,
  ol:true,
  ul:true,
  heading:true,
  fonts:false,
  fontList: ["Arial",
    "Arial Black",
    "Comic Sans MS",
    "Courier New",
    "Geneva",
    "Georgia",
    "Helvetica",
    "Impact",
    "Lucida Console",
    "Tahoma",
    "Times New Roman",
    "Verdana"
    ],
  fontColor:true,
  fontSize:true,
  // uploads
  imageUpload:false,
  fileUpload:false,
  videoEmbed: false,

  urls:true,
  removeStyles: false,
  // tables
  table:true,
  removeStyles:false,
  code:true,
  // colors
  colors: [],
  // dropdowns
  fileHTML:'',
  imageHTML:'',

  useSingleQuotes: false,
  height: 250,
  heightPercentage: 0,
  id: "",
  class: "",
  useParagraph: false,
  maxlength: 600
});

jQuery(".bmw_help_words").on('click', function() {
        var txtarea = jQuery(".richText-editor").focus();
         var text = $(this).attr('data-keyword');
         
  var sel, range;
  if (window.getSelection) {
      sel = window.getSelection();
      if (sel.getRangeAt && sel.rangeCount) {
          range = sel.getRangeAt(0);
          range.deleteContents();
          
          var lines = text.replace("\r\n", "\n").split("\n");
          var frag = document.createDocumentFragment();
          for (var i = 0, len = lines.length; i < len; ++i) {
              if (i > 0) {
                  frag.appendChild( document.createElement("br") );
              }
              frag.appendChild( document.createTextNode(lines[i]) );
          }

          range.insertNode(frag);
      }
  } else if (document.selection && document.selection.createRange) {
      document.selection.createRange().text = text;
  }
    });



});
</script>
<?php
	}

	 }
endif;
