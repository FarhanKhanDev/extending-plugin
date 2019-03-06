<?php
/**
 * Plugin Name: Option Tree Child
 * Plugin URI:  https://github.com/valendesigns/option-tree/
 * Description: This is an attenpt to extend Theme Options plugin. without touching the code of parent plugin.
 * Version:     2.6.0
 * Author:      Derek Herman
 * Author URI:  http://valendesigns.com
 * License:     GPLv3
 * Text Domain: option-tree-child
 */


add_action('plugins_loaded', 'deactivate_option_tree_child');

function deactivate_option_tree_child(){ 
    if (!is_plugin_active('option-tree/ot-loader.php')) {
        add_action('admin_notices', 'ot_notify'); 
        deactivate_plugins('option-tree-child/option-tree-child.php');
        return;
    }
}


function ot_notify() {

    echo '<div id="message" class="error fade"><p style="line-height: 150%">';

    _e('<strong>Option Tree Child</strong></a> requires Option Tree plugin to be activated. Please <a href="https://wordpress.org/plugins/paid-member-subscriptions/">install / activate </a> first.', 'add-payment-details');

    echo '</p></div>';

}

include_once dirname( dirname(__FILE__) ). '/option-tree/ot-loader.php';

if ( ! class_exists( 'OT_Loader_child' ) ) {

  class OT_Loader_child extends OT_Loader {
    
    /**
     * PHP5 constructor method.
     *
     * This method loads other methods of the class.
     *
     * @return    void
     *
     * @access    public
     * @since     2.0
     */
    public function __construct() {
      
        parent::__construct();
        
    }
    
    /**
     * Adds the global CSS to override parrent class function.
     */
    public function global_admin_css() {
      global $wp_version;
      
      $wp_38plus = version_compare( $wp_version, '3.8', '>=' ) ? true : false;
      $fontsize =  $wp_38plus ? '20px' : '16px';
      $wp_38minus = '';
      
      if ( !$wp_38plus ) {
        $wp_38minus = '
        #adminmenu #toplevel_page_ot-settings .menu-icon-generic div.wp-menu-image {
          background: none;
        }
        #adminmenu #toplevel_page_ot-settings .menu-icon-generic div.wp-menu-image:before {
          padding-left: 6px;
        }';
      }

      echo '
      <style>
        @font-face {
          font-family: "option-tree-font";
          src:url("' . OT_URL . 'assets/fonts/option-tree-font.eot");
          src:url("' . OT_URL . 'assets/fonts/option-tree-font.eot?#iefix") format("embedded-opentype"),
            url("' . OT_URL . 'assets/fonts/option-tree-font.woff") format("woff"),
            url("' . OT_URL . 'assets/fonts/option-tree-font.ttf") format("truetype"),
            url("' . OT_URL . 'assets/fonts/option-tree-font.svg#option-tree-font") format("svg");
          font-weight: normal;
          font-style: normal;
        }
        #adminmenu #toplevel_page_ot-settings .menu-icon-generic div.wp-menu-image:before {
          font: normal ' . $fontsize . '/1 "option-tree-font" !important;
          speak: none;
          padding: 6px 0;
          height: 34px;
          width: 20px;
          display: inline-block;
          -webkit-font-smoothing: antialiased;
          -moz-osx-font-smoothing: grayscale;
          -webkit-transition: all .1s ease-in-out;
          -moz-transition:    all .1s ease-in-out;
          transition:         all .1s ease-in-out;
        }
        .format-setting-inner{
            font-weight: bold;
            font-style: italic;
        }
        #adminmenu #toplevel_page_ot-settings .menu-icon-generic div.wp-menu-image:before {
          content: white;
        }'  . $wp_38minus . '
      </style>
      ';
    }
    

    
    
  }
  
  /**
   * Instantiate the OptionTree loader class.
   *
   * @since     2.0
   */
  $ot_loader = new OT_Loader_child();

}

