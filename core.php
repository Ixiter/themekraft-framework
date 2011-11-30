<?php

class TK_Framework{
	
	/**
	 * PHP 4 constructor
	 *
	 * @package Themekraft Framework
	 * @since 0.1.0
	 */
	function tk_framework() {
		$this->__construct();
	}
	
	/**
	 * PHP 5 constructor
	 *
	 * @package Themekraft Framework
	 * @since 0.1.0
	 */
	function __construct(){
		global $tk_hidden_elements;
		$tk_hidden_elements = array();		
		
		$this->constants();
		$this->includes();
	}
	
	/**
	 * Setting constants
	 *
	 * @package Themekraft Framework
	 * @since 0.1.0
	 */
	function constants(){
		define ( 'TKF_URL', tk_get_framework_path() );
		define ( 'TKF_PATH', dirname(__FILE__ ) );
	}
	
	/**
	 * Includes files for framework
	 *
	 * @package Themekraft Framework
	 * @since 0.1.0
	 */	
	function includes(){
		
		// error_reporting(E_ALL);
		
		require_once( dirname(__FILE__) . '/display.php' );
		require_once( dirname(__FILE__) . '/wml-parser.php' );
		require_once( dirname(__FILE__) . '/values.php' );

		require_once( dirname(__FILE__) . '/html/html.php' );
		
		require_once( dirname(__FILE__) . '/html/form.php' );
		
		require_once( dirname(__FILE__) . '/html/form-element.php' );
		require_once( dirname(__FILE__) . '/html/form-textfield.php' );
		require_once( dirname(__FILE__) . '/html/form-textarea.php' );
		require_once( dirname(__FILE__) . '/html/form-checkbox.php' );
		require_once( dirname(__FILE__) . '/html/form-radiobutton.php' );
		require_once( dirname(__FILE__) . '/html/form-select.php' );
		require_once( dirname(__FILE__) . '/html/form-button.php' );
		
		require_once( dirname(__FILE__) . '/wp/detect.php' );
		
		require_once( dirname(__FILE__) . '/wp/admin-page.php' );
		
		require_once( dirname(__FILE__) . '/wp/tabs.php' );
		require_once( dirname(__FILE__) . '/wp/accordion.php' );
		
		require_once( dirname(__FILE__) . '/wp/form.php' );
		require_once( dirname(__FILE__) . '/wp/form-textfield.php' );
		require_once( dirname(__FILE__) . '/wp/form-textarea.php' );
		require_once( dirname(__FILE__) . '/wp/form-checkbox.php' );
		require_once( dirname(__FILE__) . '/wp/form-radiobutton.php' );
		require_once( dirname(__FILE__) . '/wp/form-select.php' );
		require_once( dirname(__FILE__) . '/wp/form-button.php' );
		require_once( dirname(__FILE__) . '/wp/form-colorpicker.php' );
		require_once( dirname(__FILE__) . '/wp/form-fileuploader.php' );
		
		require_once( dirname(__FILE__) . '/wp/form-autocomplete.php' );
		
		require_once( dirname(__FILE__) . '/wp/metabox.php' );
		
		require_once( dirname(__FILE__) . '/wp/shortcodes.php' );
		
		require_once( dirname(__FILE__) . '/includes/jqueryui.php' );
	}
}

function tk_get_framework_path(){
	$wp_content_start = strpos( WP_CONTENT_URL, 'wp-content' );
	$tk_content_start = strpos( dirname(__FILE__), 'wp-content' ) + 10; // 10 is length of wp-content
	$wp_url = substr( WP_CONTENT_URL, 0, $wp_content_start + 10 );
	$file_url = substr( dirname(__FILE__), $tk_content_start, strlen( dirname(__FILE__) ) );
	
	return $wp_url . $file_url;	
}

function tk_hide_element( $id ){
	global $tk_hidden_elements;
	if( !in_array( $id, $tk_hidden_elements ) )
		array_push( $tk_hidden_elements, $id );
}

function tk_load_framework(){
	$tkf = new TK_Framework();
}