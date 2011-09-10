<?php

class TK_Form_Radiobutton extends TK_Form_Element{
	
	var $checked;
	var $extra;
	var $before_radiobutton;
	var $after_radiobutton;
	
	/**
	 * PHP 4 constructor
	 *
	 * @package Themekraft Framework
	 * @since 0.1.0
	 * 
	 * @param array $args Array of [ $id Id, $name Name, $value Value, $extra Extra textfield code ]
	 */
	function tk_form_radiobutton( $args ){
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
	function __construct( $args ){
		$defaults = array(
			'id' => '',
			'name' => '',
			'value' => '',
			'checked' => false,
			'extra' => '',
			'before_radiobutton' => '',
			'after_radiobutton' => ''
		);
		
		$args = wp_parse_args($args, $defaults);
		extract( $args , EXTR_SKIP );
		
		parent::__construct( $args );
		
		$this->checked = $checked;
		$this->extra = $extra;
		
		$this->before_radiobutton = $before_radiobutton;
		$this->after_radiobutton = $after_radiobutton;		
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
		if( $this->id != '' ) $id = ' id="' . $this->id . '"';
		if( $this->name != '' ) $name = ' name="' . $this->name . '"';
		if( $this->value != '' ) $value = ' value="' . $this->value . '"';
		if( $this->checked == TRUE ) $checked = ' checked';
		if( $this->extra != '' ) $extra = $this->extra;
		
		$html = $this->before_radiobutton;
		$html.= '<input' . $id . $name . $value . $extra . $checked .  ' type="radio" />';
		$html.= $this->after_radiobutton;
		
		return $html;
	}
}

function tk_radiobutton( $args ){
	$radiobutton = new TK_Form_Radiobutton( $args );
	return $radiobutton->get_html();
}

?>