<?php

class TK_WP_Form_Checkbox extends TK_Form_Checkbox{
	
	var $option_group;
	
	/**
	 * PHP 4 constructor
	 *
	 * @package Themekraft Framework
	 * @since 0.1.0
	 * 
	 * @param string $name Name of checkbox
	 * @param array $args Array of [ $id Id, $extra Extra checkbox code   ]
	 */
	function tk_wp_form_checkbox( $name, $args = array()){
		$this->__construct( $name, $args );
	}
	
	/**
	 * PHP 5 constructor
	 *
	 * @package Themekraft Framework
	 * @since 0.1.0
	 * 
	 * @param string $name Name of checkbox
	 * @param array $args Array of [ $id Id, $extra Extra checkbox code, $option_group Name of optiongroup where checkbox have to be saved ]
	 */
	function __construct( $name, $args = array() ){
		global $tk_hidden_elements, $post, $tk_form_instance_option_group;
		
		$defaults = array(
			'option_group' => $tk_form_instance_option_group,
			'id' => '',
			'default_value' => '',
			'css_classes' => '',
			'extra' => '',
			'multi_index' => '',
			'before_element' => '',
			'after_element' => ''
		);
		
		$args = wp_parse_args($args, $defaults);
		extract( $args , EXTR_SKIP );
		
		$field_name = tk_get_field_name( $name, array( 'option_group' => $option_group, 'multi_index' => $multi_index ) );
		$value = tk_get_value( $name, array( 'option_group' => $option_group, 'multi_index' => $multi_index, 'default_value' => $default_value ) );
		
		$checked = FALSE;
		
		if( $value != '' ){
			$checked = TRUE;
		}
		
		// Putting Args to parent
		$args = array(
			'id' => $id,
			'name' => $name,
			'value' => $value,
			'checked' => $checked,
			'css_classes' => $css_classes,
			'extra' => $extra,
			'multi_index' => $multi_index,
			'before_element' => $before_element,
			'after_element' => $after_element
		);
		parent::__construct( $args );
		
		// Rewriting Fieldname and Input Field String for WP Savings
		$name = tk_get_field_name( $name, array( 'option_group' => $option_group, 'multi_index' => $multi_index ) );
		$this->str_name = ' name="' . $name . '"';
	}		
}
function tk_form_checkbox( $name, $args = array(), $return_object = FALSE ){
	$checkbox = new TK_WP_Form_Checkbox( $name, $args  );
	
	if( TRUE == $return_object ){
		return $checkbox;
	}else{
		return $checkbox->get_html();
	}
}