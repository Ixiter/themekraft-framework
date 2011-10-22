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
		$this->includes();
	}
	
	/**
	 * Includes files for framework
	 *
	 * @package Themekraft Framework
	 * @since 0.1.0
	 */	
	function includes(){
		
		require_once( 'display-builder.php' );

		require_once( 'html/html.php' );
		require_once( 'html/form.php' );
		require_once( 'html/form-element.php' );
		require_once( 'html/form-textfield.php' );
		require_once( 'html/form-textarea.php' );
		require_once( 'html/form-checkbox.php' );
		require_once( 'html/form-radiobutton.php' );
		require_once( 'html/form-select.php' );
		require_once( 'html/form-button.php' );
		
		require_once( 'wp/admin-page.php' );
		
		require_once( 'wp/tabs.php' );
		require_once( 'wp/accordion.php' );
		
		require_once( 'wp/form.php' );
		require_once( 'wp/form-textfield.php' );
		require_once( 'wp/form-textarea.php' );
		require_once( 'wp/form-checkbox.php' );
		require_once( 'wp/form-radiobutton.php' );
		require_once( 'wp/form-select.php' );
		require_once( 'wp/form-button.php' );
		require_once( 'wp/form-colorpicker.php' );
		require_once( 'wp/form-fileuploader.php' );
		
		// require_once( 'wp/autocomplete.php' );
		
		require_once( 'wp/metabox.php' );

		require_once( 'includes/jqueryui.php' );
		
	}
}

function tk_load_framework(){
	$tkf = new TK_Framework();
}

?>