<?php
/** 
 * @package    LinkBlog by Lucy
 * @subpackage Front
 * @author     Lucy Tomás
 * @since 	   1.0
 */
 
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;


if( !class_exists( 'LBBYLU_Front' )){
 
class LBBYLU_Front {
	
	/**
	 * contructor 
	 * @since 1.0
	 */
	
	public function __construct (){
		
		add_filter( 'the_permalink_rss', array( $this, 'linkblog_permalink') );
		add_filter( 'post_link', 		 array( $this, 'linkblog_permalink') );
	}

	/**
	 * linkblog_permalink
	 * Returns permalink if external link does not exist as postmeta
	 * @since 1.0
	 */

	public function linkblog_permalink( $permalink ) {

		global $post; 
		
		if( $url = get_post_meta($post->ID, 'linkblog_external_link', true) ) {
			return $url;
		}

		return $permalink;
	}

	
}// class
}// if


	