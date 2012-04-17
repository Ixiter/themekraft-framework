<?php

class TK_Form extends TK_HTML{
	
	var $action;
	var $method;
	
	/**
	 * PHP 4 constructor
	 *
	 * @package Themekraft Framework
	 * @since 0.1.0
	 * 
	 * @param string $action The action of the form
	 * @param array $args Array of [ $method form method, $action form action ]
	 */
	function tk_form( $args = array() ){
		$this->__construct( $args );
	}
	
	/**
	 * PHP 5 constructor
	 *
	 * @package Themekraft Framework
	 * @since 0.1.0
	 * 
	 * @param string $action The action of the form
	 * @param array $args Array of [ $method form method, $action form action ]
	 */
	function __construct( $args = array() ){
		$defaults = array(
			'id' => $this->get_id(),
			'name' => $this->get_id(),
			'css_classes' => '',
			'extra' => '',
			'before_element' => '',
			'after_element' => '',
			'method' => 'post',
			'action' => esc_url( $_SERVER['REQUEST_URI'] )
		);
		
		$parsed_args = wp_parse_args( $args, $defaults );
		extract( $parsed_args, EXTR_SKIP );
		
		parent::__construct( $id, $name, $css_classes, $extra, $before_element, $after_element );
		
		$this->action = $action;
		$this->method = $method;
		
		if( $this->action != '' ) $this->str_action = ' action="' . $this->action . '"';
		if( $this->method != '' ) $this->str_method = ' method="' . $this->method . '"';
		
	}
	
	/**
	 * Getting the form html
	 *
	 * @package Themekraft Framework
	 * @since 0.1.0
	 * 
	 * @return string $html The form content
	 * 
	 */
	function get_html(){
		// Adding method to the form
		$html = $this->before_element;
		$html.= '<form' . $this->str_id . $this->str_name . $this->str_css_classes . $this->str_method . $this->str_action . $this->extra . ' enctype="multipart/form-data">';
		
		$html = apply_filters( 'tk_form_start_' . $this->id, $html );
		
		// Adding elements to form
		foreach( $this->elements AS $element ){
			$tkdb = new TK_Display();
			$html.= $tkdb->get_html( $element );
			unset( $tkdb );
		}
		
		$html = apply_filters( 'tk_form_end_' . $this->id, $html );
				
		$html.='</form>';
		
		$html.= $this->after_element;
		
		return $html;
	}
}