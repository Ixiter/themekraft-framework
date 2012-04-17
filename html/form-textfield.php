<?php

class TK_Form_Textfield extends TK_Form_Element{
	
	/**
	 * PHP 4 constructor
	 *
	 * @package Themekraft Framework
	 * @since 0.1.0
	 * 
	 * @param array $args Array of [ $id Id, $name Name, $value Value, $extra Extra textfield code ]
	 */
	function tk_form_textfield( $args = array() ){
		$this->__construct( $args );		
	}
	
	/**
	 * PHP 5 constructor
	 *
	 * @package Themekraft Framework
	 * @since 0.1.0
	 * 
	 * @param array $args Array of [ $id Id, $name Name, $value Value, $extra Extra textfield code ]
	 */
	function __construct( $args = array() ){
		$defaults = array(
			'id' => $this->get_id(),
			'name' => $this->get_id(),
			'value' => '',
			'css_classes' => '',
			'extra' => '',
			'multi_index' => FALSE,
			'before_element' => '',
			'after_element' => ''
		);
		
		$parsed_args = wp_parse_args( $args, $defaults );
		extract( $parsed_args , EXTR_SKIP );
		
		// Putting Args to parent
		$args = array(
			'id' => $id,
			'name' => $name,
			'css_classes' => $css_classes,
			'value' => $value,
			'extra' => $extra,
			'multi_index' => $multi_index,
			'before_element' => $before_element,
			'after_element' => $after_element
		);
		parent::__construct( $args );
	}
	
	/**
	 * Getting HTML of textfield
	 *
	 * @package Themekraft Framework
	 * @since 0.1.0
	 * 
	 * @return string $html The html of the textfield
	 */
	function get_html(){
		
		$html = $this->before_element;
		$html.= '<input' . $this->str_id . $this->str_name. $this->str_value . $this->str_css_classes . $this->extra . ' type="text" />';
		$html.= $this->after_element;
		
		return $html;
	}
}

function tk_textfield( $name, $args = array(), $return_object = FALSE ){
	$textfield = new TK_Form_Textfield( $name, $args );

	if( TRUE == $return_object ){
		return $textfield;
	}else{
		return $textfield->get_html();
	}	
}