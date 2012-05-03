<?php

class TK_Form_Checkbox extends TK_Form_Element{

	var $checked;
	
	/**
	 * PHP 4 constructor
	 *
	 * @package Themekraft Framework
	 * @since 0.1.0
	 * 
	 * @param array $args Array of [ $id Id, $name Name, $value Value, $checked Checked value, $extra Extra checkbox code   ]
	 */
	function tk_form_checkbox( $args = array() ){
		$this->__construct( $args );
	}
	
	/**
	 * PHP 5 constructor
	 *
	 * @package Themekraft Framework
	 * @since 0.1.0
	 * 
	 * @param array $args Array of [ $id Id, $name Name, $value Value, $checked Checked value, $extra Extra checkbox code   ]
	 */
	function __construct( $args = array() ){
		$defaults = array(
			'id' => '',
			'name' => '',
			'value' => '',
			'checked' => FALSE,
			'css_classes' => '',
			'extra' => '',
			'multi_index' => '',
			'before_element' => '',
			'after_element' => ''
		);
		
		$parsed_args = wp_parse_args( $args, $defaults );
		extract( $parsed_args , EXTR_SKIP );
		
		// Putting Args to parent
		$args = array(
			'id' => $id,
			'name' => $name,
			'value' => $value,
			'css_classes' => $css_classes,
			'extra' => $extra,
			'multi_index' => $multi_index,
			'before_element' => $before_element,
			'after_element' => $after_element
		);
		parent::__construct( $parsed_args );
		
		$this->checked = $checked;
		if( $this->checked == TRUE ) $this->str_checked = ' checked';
	}
	
	/**
	 * Getting HTML of checkbox
	 *
	 * @package Themekraft Framework
	 * @since 0.1.0
	 * 
	 * @return string $html The HTML of checkbox
	 */
	function get_html(){
		
		$html = $this->before_element;
		$html.= '<input type="checkbox" ' . $this->str_id . $this->str_name . $this->str_value . $this->str_extra . $this->str_checked . ' />';
		$html.= $this->after_element;
		
		return $html;
	}
}
function tk_checkbox( $args, $return_object = FALSE ){
	$checkbox = new TK_Form_Checkbox( $args );
	
	if( TRUE == $return_object ){
		return $checkbox;
	}else{
		return $checkbox->get_html();
	}
}