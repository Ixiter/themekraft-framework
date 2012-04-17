<?php

class TK_Form_Element extends TK_HTML{
	
	var $value;
	var $multi_index;
	
	/**
	 * PHP 4 constructor
	 *
	 * @package Themekraft Framework
	 * @since 0.1.0
	 * 
	 * @param array $args Array of [ $id Id, $name Name, $value Value ]
	 */
	function tk_form_element( $args = array() ){
		$this->__construct( $args );
	}
	
	/**
	 * PHP 5 constructor
	 *
	 * @package Themekraft Framework
	 * @since 0.1.0
	 * 
	 * @param array $args Array of [ $id Id, $name Name, $value Value ]
	 */
	function __construct( $args = array() ){
		
		$defaults = array(
			'id' => $this->get_id(),
			'name' => $this->get_id(),
			'css_classes' => '',
			'value' => '',
			'extra' => '',
			'multi_index' => FALSE,
			'before_element' => '',
			'after_element' => ''
		);
		
		extract( wp_parse_args( $args, $defaults ), EXTR_SKIP );
		
		parent::__construct( $id, $name, $css_classes, $extra, $before_element, $after_element );
		
		$this->value = $value;
		$this->multi_index = $multi_index;
		
		// Creating form lement name with Multiindex
		if( $multi_index != '' && $multi_index != FALSE ):
			if( is_array( $multi_index ) ):
				foreach( $multi_index AS $index ):
					$this->name.= '[' . $index . ']';
 				endforeach;
			else:
				$this->name.= '[' . $multi_index . ']';
			endif;
		endif;
				
		if( $this->value != '' ) $this->str_value = ' value="' . $this->value . '"';
	}
}