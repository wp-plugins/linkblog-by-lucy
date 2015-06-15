<?php
/**
Plugin Name: LinkBlog by Lucy
Description: Convert your WordPress blog into a LinkBlog
Version: 	 1.0
Author: 	 Lucy Tomás
Author URI:  http://wptips.me
License: 	 GPLv2
*/
 
 /* Copyright 2014 Lucy Tomás (email: lucy@wptips.me)
  
    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

 // If this file is called directly, exit.
if ( !defined( 'ABSPATH' ) ) exit;

if( !class_exists('LBBYLU') ) {
	
	/**
	 * Main class
	 * @since   1.0
	 */
	
final class LBBYLU {

	private static $instance = null;

	/**
	 * vars
	 */	
	
	public $default_options = array();
	public static $options = null;
		
	/**
	 * Instance
	 * This functions returns the only one true instance of the plugin main class
	 * 
	 * @return object instance
	 * @since  1.0
	 */
		
	public static function instance (){
			
		if( self::$instance == null ){
					
			self::$instance = new LBBYLU;
			self::$instance->constants();
			self::$instance->includes();
			self::$instance->load_textdomain();
				
		}
			
			return self::$instance;
	}
		
	/**
	 * Class Contructor
	 * 
	 * @since 1.0
	 */

	private function __construct () {
		add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), array( $this, 'add_action_links') );
	}

	/**
	 * constants
	 * @since 1.0
	 */
		  
	private function constants() {
		  	
		if( !defined('LBBYLU_PLUGIN_DIR') )  	{ define('LBBYLU_PLUGIN_DIR', plugin_dir_path( __FILE__ )); }
		if( !defined('LBBYLU_PLUGIN_URL') )  	{ define('LBBYLU_PLUGIN_URL', plugin_dir_url( __FILE__ ));  }
		if( !defined('LBBYLU_PLUGIN_FILE') ) 	{ define('LBBYLU_PLUGIN_FILE',  __FILE__ );  }
		if( !defined('LBBYLU_PLUGIN_VERSION') ) { define('LBBYLU_PLUGIN_VERSION', '1.0');  } 
			
	}

	/**
	 * includes
	 * @since 1.0
	 */
		  
	private function includes () {
		  	
		require_once( LBBYLU_PLUGIN_DIR . 'includes/settings.php');
		require_once( LBBYLU_PLUGIN_DIR . 'includes/metabox.php');
		require_once( LBBYLU_PLUGIN_DIR . 'includes/front.php');

		new LBBYLU_Settings();
		new LBBYLU_Metabox();

		$options = get_option( 'lbbylu_settings' );
		if( ! is_admin() && (! isset($options['not_override_permalink']) || $options['not_override_permalink'] != 1) ) {
			new LBBYLU_Front();
		}
	}

	 /**
	  * add_action_links
	  * @since 1.0
	  */

	 public function add_action_links( $links ) {
 
	    $url = get_admin_url(null, 'options-general.php?page=lbbylu-options');
	 
	    $links[] = '<a href="'. $url .'">Settings</a>';
	    return $links;
	}
 
	/**
	 * load_textdomain
	 * @since 1.0
	 */
	public function load_textdomain() {
			
		load_plugin_textdomain('lbbylu', false,  dirname( plugin_basename( LBBYLU_PLUGIN_FILE ) ) . '/languages/' );	
	 }

}// class
	
}// if !class_exists


LBBYLU::instance();