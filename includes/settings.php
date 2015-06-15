<?php
/** 
 * @package    LinkBlog by Lucy
 * @subpackage Settings
 * @author     Lucy Tomás
 * @since 	   1.0
 */
 
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;


if( !class_exists( 'LBBYLU_Settings' )){
 
class LBBYLU_Settings {
	
	/**
	 * contructor 
	 * @since 1.0
	 */
	
	public function __construct (){

		add_action( 'admin_init', 			 array( $this, 'register_settings' ));
		add_action( 'admin_menu', 			 array( $this, 'set_settings_link' ));
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ));
	}

	/**
	 * register_settings
	 * @since 1.0
	 */
	 
	 public function register_settings (){
	 		
	 	register_setting('lbbylu_settings_group', 'lbbylu_settings', array( $this, 'sanitize_options') );
	 	
	 }

	/**
	 * set_settings_link
	 * @since 1.0
	 */
	 
	 public function set_settings_link (){
	 		
	 	add_options_page('LinkBlog', 'LinkkBlog', 'manage_options', 'lbbylu-options', array(  $this, 'settings_page'));
		
	 }
	 
	/**
	 * settings_page
	 * @since 1.0
	 */
	
	public function settings_page() {
		
		$options = get_option( 'lbbylu_settings' );
		require_once( LBBYLU_PLUGIN_DIR . 'includes/settings-form.php' );
	
	}
	
	/**
	 * enqueue_scripts
	 * @since 1.0
	 */
	 
	 public function enqueue_scripts (){
	 	
			wp_enqueue_style('lbbylu-settings', LBBYLU_PLUGIN_URL . 'assets/settings.css', array(), LBBYLU_PLUGIN_VERSION);
	 }

	/**
	 * sanitize_options
	 * @since 1.0
	 */

	public function sanitize_options( $options ){

		$options['not_override_permalink'] = absint( $options['not_override_permalink'] );

		return $options;

	}

}// class
}// if


	