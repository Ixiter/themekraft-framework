<?php

class TK_Form_select extends TK_Form_element{
	
	var $elements;
	var $size;
	
	/**
	 * PHP 4 constructor
	 *
	 * @package Themekraft Framework
	 * @since 0.1.0
	 * 
	 * @param array $args Array of [ $id Id, $name Name, $value Value, $extra Extra selectfield code ]
	 */
	function tk_form_select( $args = array() ){
		$this->__construct( $args );
	}
	
	/**
	 * PHP 5 constructor
	 *
	 * @package Themekraft Framework
	 * @since 0.1.0
	 * 
	 * @param array $args Array of [ $id Id, $name Name, $value Value, $extra Extra selectfield code ]
	 */
	function __construct( $args = array() ){
		$defaults = array(
			'id' => $this->get_id(),
			'name' => $this->get_id(),
			'value' => '',
			'size' => '',
			'css_classes' => '',
			'extra' => '',
			'multi_index' => FALSE,
			'multi_select' => FALSE,
			'before_element' => '',
			'after_element' => ''
		);
		
		$parsed_args = wp_parse_args($args, $defaults);
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
		
		$this->size = $size;	
		$this->multi_select = $multi_select;	
		
		if( $this->size != '' ) $this->str_size = ' size="' . $this->size . '"';		
	}
	
	/**
	 * Adds an option to the select field
	 *
	 * @package Themekraft Framework
	 * @since 0.1.0
	 * 
	 * @param string $option The option to show in list
	 * @param array $args Array of [ $value Value, $extra Extra option code ]
	 */
	function add_option( $value, $args = array() ){
		$defaults = array(
			'id' => '',
			'option_name' => '',
			'extra' => ''
		);
		
		$parsed_args = wp_parse_args( $args, $defaults );
		extract( $parsed_args , EXTR_SKIP );
		
		$this->elements[ $value ] = array( 'id' => $id, 'value'=> $value, 'option_name' => $option_name, 'extra' => $extra );
	}
	
	/**
	 * Getting HTML of select box
	 *
	 * @package Themekraft Framework
	 * @since 0.1.0
	 * 
	 * @return string $html The HTML of select box
	 */
	function get_html(){
		global $tk_hidden_elements;
		
		// Merging values
		$this->merge_option_elements();
			
		if( $this->multiselect ):
			if( $this->name != '' ) $this->str_name = ' name="' . $this->name . '[]"';
			$multiselect_string = ' multiple="multiple"';
		else:
		
		$html = $this->before_element;
		$html.= '<select' . $this->str_id . $this->str_name . $this->str_size . $this->str_css_classes . $multiselect_string . $this->extra . '>';
		
		// Adding options
		$options = '';

		if( count( $this->elements ) > 0 ):
			
			foreach( $this->elements AS $value => $element ):
				
				if( !in_array( $element['id'], $tk_hidden_elements ) ):
					
					$option_name = $element['option_name'];
					$value_string = ' value="' . $value . '"';
					$extra_string = $element['extra'];
					
					if( $option_name == '' )
						$option_name = $value;
					
					if( is_array( $this->value ) ):
						// If value is from a multiselect box
						if( in_array( $value, $this->value ) ):
							$options .=  '<option' . $value_string . ' selected' . $extra_string . '>' . $option_name . '</option>';
						else:
							$options .=  '<option' . $value_string . $extra_string . '>' . $option_name . '</option>';
						endif;					
						
						
					else:
						// Standard value
						if( $this->value == $value && $value != '' ):
							$options .=  '<option' . $value_string . ' selected' . $extra_string . '>' . $option_name . '</option>';
						else:
							$options .=  '<option' . $value_string . $extra_string . '>' . $option_name . '</option>';
						endif;
						
					endif;
				endif;
				// No else because is only option in it
			endforeach;

		endif;
		
		$options = apply_filters( 'tk_select_options_' . $this->id, $options, $this->id );

		$html.= $options . '</select>';
		$html.= $this->after_element;
		
		return $html;
	}

	function merge_option_elements(){
		
		global $tk_select_option_elements;
		
		if( !isset( $tk_select_option_elements[ $this->id ]  ) )
			return false;
		
		if( is_array( $tk_select_option_elements[ $this->id ] ) ){
			
			foreach( $tk_select_option_elements[ $this->id ] AS $element ){
				
				if( $element[ 'action' ] == 'add' )
					$this->elements[ $element[ 'value' ] ] = array( 'option_name' => $element[ 'option_name' ], 'extra' => $element[ 'extra' ] );
				
				if( $element[ 'action' ] == 'delete' )
					unset ( $this->elements[ $element[ 'value' ]  ] );
					
			}
		}

	}
}

function tk_select_add_option( $select_id, $value, $option_name = '', $extra = '' ){
	global $tk_select_option_elements;
	
	if( $option_name == '' )
		$option_name = $value;
	
	if( !is_array( $tk_select_option_elements[ $select_id ] ) )
		$tk_select_option_elements[ $select_id ] = array();
		
	array_push( $tk_select_option_elements[ $select_id ], array( 'action' => 'add' , 'value' => $value, 'option_name' => $option_name, 'extra' => $extra ) );
}

function tk_select_delete_option( $select_id, $value ){
	global $tk_select_option_elements;
	
	if( !is_array( $tk_select_option_elements[ $select_id ] ) )
		$tk_select_option_elements[ $select_id ] = array();
		
	array_push( $tk_select_option_elements[ $select_id ], array( 'action' => 'delete' , 'value' => $value ) );
}
