<?php
ini_set('memory_limit','-1');
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'BMW_GENEALOGY', false ) ) :
	class BMW_GENEALOGY {
		public static function bmw_get_geneology()
		{
      add_action('in_admin_header', function () {
          remove_all_actions('admin_notices');
          remove_all_actions('all_admin_notices');
          add_action('admin_notices', function () {}); }, 1000);
      ?>
      <div id="full-container" class="let-container" >
        <button class="btn-action btn-fullscreen let-text-success" onclick="params.funcs.toggleFullScreen()"><i class="fa fa-arrows-alt" aria-hidden="true"></i></button>
        <button class=" btn-action btn-search let-text-success" onclick="params.funcs.search()"><i class="fa fa-search" aria-hidden="true"></i></button>
        <button class="btn-action btn-show-my-self let-text-success" onclick="params.funcs.showMySelf()"><span class='icon'> <i class="fa fa-user" aria-hidden="true"></i></span></button>
        <button class="btn-action let-text-success" onclick="params.funcs.expandAll()"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>
        <button class="btn-action let-text-success" onclick="params.funcs.collapseAll()"><i class="fa fa-minus-circle" aria-hidden="true"></i>
        </button>
        <button class=" btn-action btn-back let-text-success" onclick="params.funcs.back()"> <?php _e('Back','bmp');?><i class="fa fa-arrow-left" aria-hidden="true"></i></button>


        <div class="user-search-box">
          <div class="input-box">
            <div class="close-button-wrapper"><i onclick="params.funcs.closeSearchBox()" class="fa fa-times" aria-hidden="true"></i></div>
            <div class="input-wrapper">
              <input type="text" class="search-input" placeholder="<?php _e('Search','BMW');?>" />
              <div class="input-bottom-placeholder"><?php _e('By Username, Sponsor, userkey, position','BMW');?></div>
            </div>
            <div>
            </div>
          </div>
          <div class="result-box">
            <div class="result-header"><?php _e('RESULTS','BMW');?> </div>
            <div class="result-list">
              <div class="buffer"></div>
            </div>
          </div>
        </div>
        <div id="svgChart" class="let-container let-col-md-12"></div>
      </div>
    <?php } }


  endif;