<?php
/** 
 * @package    LinkBlog by Lucy
 * @subpackage Metabox
 * @author     Lucy Tomás
 * @since 	   1.0
 */
 
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;


if( !class_exists( 'LBBYLU_Metabox' )){
 
class LBBYLU_Metabox {
	
	/**
	 * contructor 
	 * @since 1.0
	 */
	
	public function __construct (){
		
		add_action( 'add_meta_boxes', 		 array( $this, 'add_metabox' ) );
		add_action( 'edit_form_after_title', array( $this, 'move_metabox' ) );
		add_action( 'save_post', 	  		 array( $this, 'save_metadata' ) );
	}

	/**
	 * add_metabox
	 * 
	 * @since 1.0
	 */

	public function add_metabox(){

		global $_wp_post_type_features;
		
		add_meta_box(
			       'lbbylu_url', 
			        __( 'LinkBlog Link', 'lbbylu' ), 
			       array( $this, 'metabox_form'), 
			       'post', 
			       'lbbylu_advanced', 
			       'high');
	}

	/**
	 * move_metabox
	 * Moves metabox after title and before content editor. 
	 * Outputs the advanced metaboxes and unsets the metaboxes so they wont duplicated.
	 * @since 1.0
	 */

	public function move_metabox(){
		
		global $post, $wp_meta_boxes;
		
		do_meta_boxes(get_current_screen(), 'lbbylu_advanced', $post);
		unset($wp_meta_boxes['post']['lbbylu_advanced']);
		
	}

	/**
	 * metabox_form
	 * 
	 * @since 1.0
	 */

	public function metabox_form( $post ){

		wp_nonce_field( 'lbbylu_linkblog', 'lbbylu_linkblog_nonce' );

		$value = get_post_meta( $post->ID, 'linkblog_external_link', true );

		echo '<input style="width:100%;" type="text" name="linkblog_external_link" value="' . esc_url($value) . '" />';
	}

	/**
	 * save_metadata
	 * 
	 * @since 1.0
	 */

	public function save_metadata( $post_id ){

		/* **** Security checks */	

			// Check if our nonce is set.
			if ( ! isset( $_POST['lbbylu_linkblog_nonce'] ) ) {
				return;
			}

			// Verify that the nonce is valid.
			if ( ! wp_verify_nonce( $_POST['lbbylu_linkblog_nonce'], 'lbbylu_linkblog' ) ) {
				return;
			}

			// If this is an autosave, our form has not been submitted, so we don't want to do anything.
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
				return;
			}

			// Check the user's permissions.
			if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {

				if ( ! current_user_can( 'edit_page', $post_id ) ) {
					return;
				}

			} else {

				if ( ! current_user_can( 'edit_post', $post_id ) ) {
					return;
				}
			}

		/* **** End Scurity check */	
		
		if ( ! isset( $_POST['linkblog_external_link'] ) ) {
			return;
		}

		$data = sanitize_text_field( $_POST['linkblog_external_link'] );

		
		if( $data != '' ) {
			update_post_meta( $post_id, 'linkblog_external_link', esc_url($data) );
		}
	}

	
}// class
}// if


	