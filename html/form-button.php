<?php

class TK_Form_Button extends TK_Form_Element{

	var $submit;
	
	/**
	 * PHP 4 constructor
	 *
	 * @package Themekraft Framework
	 * @since 0.1.0
	 * 
	 * @param array $args Array of [ $id Id, $name Name, $value Value, $submit use submit, $extra Extra checkbox code   ]
	 */
	function tk_form_button( $args = array() ){
		$this->__construct( $args );
	}
	
	/**
	 * PHP 5 constructor
	 *
	 * @package Themekraft Framework
	 * @since 0.1.0
	 * 
	 * @param array $args Array of [ $id Id, $name Name, $value Value, $submit use submit, $extra Extra checkbox code   ]
	 */
	function __construct( $args = array() ){
		$defaults = array(
			'id' => '',
			'name' => '',
			'value' => '',
			'css_classes' => '',
			'submit' => TRUE,
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
		parent::__construct( $args );
		
		$this->submit = $submit;
	}
	
	/**
	 * Getting HTML of button
	 *
	 * @package Themekraft Framework
	 * @since 0.1.0
	 * 
	 * @return string $html The HTML of button
	 */
	function get_html(){

		$html = $this->before_element;
		if( $this->submit ){
			$html.= '<input type="submit"' . $this->str_id . $this->str_name . $this->str_value . $this->str_css_classes . $this->extra . ' />';
		}else{
			$html.= '<input type="button"' . $this->str_id . $this->str_name . $this->str_value . $this->str_css_classes . $this->extra . ' />';
		}
		$html.= $this->after_element;
		
		return $html;
	}
}

function tk_button( $args = array(), $return_object = FALSE ){
	$button = new TK_Form_Button( $args );
	
	if( TRUE == $return_object ){
		return $button;
	}else{
		return $button->get_html();
	}
}