<?php

class TK_Import_Button extends TK_WP_Fileuploader{
	
	var $done_import;
	var $wp_name;
	
	/**
	 * PHP 4 constructor
	 *
	 * @package Themekraft Framework
	 * @since 0.1.0
	 * 
	 * @param string $name Name of colorfield
	 * @param array $args 
	 */
	function tk_import_button( $value, $args = array() ){
		$this->__construct( $value, $args );
	}
	
	/**
	 * PHP 5 constructor
	 *
	 * @package Themekraft Framework
	 * @since 0.1.0
	 * 
	 * @param string $name Name of colorfield
	 * @param array $args Array of [ $id , $extra Extra colorfield code, option_groupOption group to save data, $before_textfield Code before colorfield, $after_textfield Code after colorfield   ]
	 */
	function __construct( $value, $args = array() ){
		global $post, $tk_form_instance_option_group;
		
		$defaults = array(
			'option_group' => $tk_form_instance_option_group,
			'id' => $this->get_id(),
			'name' => $this->get_id(),
			'css_classes' => '',
			'extra' => '',
			'uploader' => 'file',
			'multi_index' => '',
			'before_element' => '',
			'after_element' => ''
		);
		
		$parsed_args = wp_parse_args( $args, $defaults );
		extract( $parsed_args , EXTR_SKIP );
		
		// Putting Args to parent
		$args = array(
			'option_group' => $option_group,
			'id' => $id,
			'name' => $name,
			'value' => $value,
			'css_classes' => $css_classes,
			'submit' => TRUE,
			'extra' => $extra,
			'uploader' => 'wp', // wp or file
			'multi_index' => $multi_index,
			'before_element' => $before_element,
			'after_element' => $after_element,
			'insert_as_attachement' => FALSE,
			'delete' => TRUE
		);
		parent::__construct( $value, $args );
		
		$this->done_import = FALSE;
		$this->wp_name = $name;
	}
	
	function validate_actions( $input ){
		global $tk_form_instance_option_group;
		
		// If error occured
		if( $_FILES[ $tk_form_instance_option_group . '_values' ][ 'error' ][ $this->wp_name ] != 0  ){
			$input[ $this->wp_name ] = $this->value;
			
		}else{
			$file[ 'tmp_name' ] = $_FILES[ $tk_form_instance_option_group . '_values' ][ 'tmp_name' ][ $this->wp_name ];
			$input = tk_import_values( $tk_form_instance_option_group, $file[ 'tmp_name' ] );			
		}
		
		return $input;
	}

	function get_html(){
		$import_button = tk_form_button( __( 'Import settings', 'tkf' ), array( 'name' => 'import_settings' ) ); 
		$this->after_element = $import_button . $this->after_element;
		$html = parent::get_html();
		
		return $html;
	}
}
function tk_import_values( $option_group, $file_name ){
	
	if( !file_exists( $file_name ) )
		return FALSE;
	
	$file_data = implode ( '', file ( $file_name ) );
	
	$values = unserialize( $file_data );
	
	return $values;
}
function tk_import_button( $name, $args, $return_object = FALSE ){
	$import_button = new TK_Import_Button( $name, $args );
	
	if( TRUE == $return_object ){
		return $import_button;
	}else{
		return $import_button->get_html();
	}
}
