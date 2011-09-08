<?php

class TK_FORM extends TK_HTML{
	
	var $form;
	var $id;
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
	function tk_form( $id, $args ){
		$this->__construct( $action, $args );
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
	function __construct( $id, $args ){
		parent::__construct();
		
		$defaults = array(
			'method' => 'post',
			'action' => esc_url( $_SERVER['REQUEST_URI'] )
		);
		$args = wp_parse_args($args, $defaults);
		extract( $args, EXTR_SKIP );
		
		$this->action = $action;
		$this->method = $method;
		
		$this->id = $id;
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
		// Adding id to the form
		$id = ' id="' . $this->id . '"';
		
		// Adding method to the form
		$method = ' method="' . $this->method . '"';
		
		$html = '<form' . $id . $method . ' action="' . $this->action . '">';
		
		$html = apply_filters( 'tk_form_start_' . $id, $html );
		
		// Adding elements to form
		foreach( $this->elements AS $element ){
			$html.= $element;
		}
		
		$html = apply_filters( 'tk_form_end_' . $id, $html );
				
		$html.='</form>';
		
		return $html;
	}
}

?>