<?php

class TK_Fileuploader extends TK_Form_Element{
	
	/**
	 * PHP 4 constructor
	 *
	 * @package Themekraft Framework
	 * @since 0.1.0
	 * 
	 * @param string $name Name of colorfield
	 * @param array $args Array of [ $id , $extra Extra colorfield code, option_groupOption group to save data, $before_textfield Code before colorfield, $after_textfield Code after colorfield   ]
	 */
	function tk_fileuploader( $args = array() ){
		$this->__construct( $args );
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
	function __construct( $args = array() ){
		$defaults = array(
			'id' => $this->get_id(),
			'name' => $this->get_id(),
			'css_classes' => '',
			'extra' => '',
			'multi_index' => FALSE,
			'before_element' => '',
			'after_element' => '',
		);
		
		$parsed_args = wp_parse_args( $args, $defaults );
		extract( $parsed_args , EXTR_SKIP );
		
		// Putting Args to parent
		$args = array(
			'id' => $id,
			'name' => $name,
			'css_classes' => $css_classes,
			'extra' => $extra,
			'multi_index' => $multi_index,
			'before_element' => $before_element,
			'after_element' => $after_element
		);
		parent::__construct( $args );
	}
	
	function get_html(){
		
		$html = $this->before_element;
		$html.= '<input' . $this->str_id . $this->str_name . $this->extra . ' type="file" />';
		$html.= $this->after_element;
		
		return $html;
	}
}