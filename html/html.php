<?php
class TK_HTML{
	
	var $id;
	var $name;
	var $css_classes;
	var $elements;
	var $before_element;
	var $after_element;
	
	var $str_id;
	var $str_name;
	
	/**
	 * PHP 4 constructor
	 *
	 * @package Themekraft Framework
	 * @since 0.1.0
	 */
	function tk_html( $id = '', $name = '' ){
		$this->__construct( $id, $name );
	}
	
	/**
	 * PHP 5 constructor
	 *
	 * @package Themekraft Framework
	 * @since 0.1.0
	 */
	function __construct( $id = '', $name = '', $css_classes = '', $extra = '', $before_element = '', $after_element = '' ){
		$this->id = $id;
		$this->name = $name;
		$this->css_classes = $css_classes;
		$this->extra = $extra;
		$this->before_element = $before_element;
		$this->after_element = $after_element;
		
		if( $this->id != '' ) $this->str_id = ' id="' . $this->id . '"';
		if( $this->name != '' ) $this->str_name = ' name="' . $this->name . '"';
		if( $this->css_classes != '' ) $this->str_css_classes = ' class="' . $this->css_classes . '"';
		
		$this->elements = array();
	}
	
	/**
	 * Returns the id for a element
	 *
	 * @package Themekraft Framework
	 * @since 0.1.0
	 */
	function get_id(){
		global $tkf_element_nr;
		
		if( $this->id == '' ):
			// Getting the element number
			if( !isset( $tkf_element_nr ) ):
				$tkf_element_nr = 0;
			else:
				$tkf_element_nr++;
			endif;
			
			return 'tkf_element_id_' . $tkf_element_nr;
			
		else:
			return $this->id;
		endif;
	}
	
	/**
	 * Adding elements to content
	 *
	 * @package Themekraft Framework
	 * @since 0.1.0
	 * 
	 * @param string $element Element which have to be added to content
	 * 
	 */
	function add_element( $element ){
		array_push( $this->elements, $element  );
	}
	
	/**
	 * Getting the content
	 *
	 * @package Themekraft Framework
	 * @since 0.1.0
	 * 
	 * @return string $html The whole content
	 * 
	 */
	function get_html(){
		
		$html = $this->before_element;
		if( count( $this->elements ) > 0 ){
			foreach( $this->elements AS $element ){
				$html.= $element;
			}
		}
		$html.= $this->after_element;
		
		return $html;
	}
	
	/**
	 * Echo the content
	 *
	 * @package Themekraft Framework
	 * @since 0.1.0
	 * 
	 */
	function write_html(){
		echo $this->get_html();	
	}
}