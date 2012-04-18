<?php

class TK_Jqueryui_Autocomplete extends TK_WP_Form_Textfield{
	
	var $autocomplete_values;
	var $delete_values;
	
	/**
	 * PHP 4 constructor
	 *
	 * @package Themekraft Framework
	 * @since 0.1.0
	 * 
	 * @param string $name Name of autocomplete field
	 * @param array $args Array of [ $id , $extra Extra colorfield code, option_groupOption group to save data, $before_textfield Code before colorfield, $after_textfield Code after colorfield   ]
	 */
	function tk_jqueryui_autocomplete( $name, $args = array() ){
		$this->__construct( $name, $args );
	}
	
	/**
	 * PHP 5 constructor
	 *
	 * @package Themekraft Framework
	 * @since 0.1.0
	 * 
	 * @param string $name Name of autocomplete field
	 * @param array $args Array of [ $id , $extra Extra colorfield code, option_groupOption group to save data, $before_textfield Code before colorfield, $after_textfield Code after colorfield   ]
	 */
	function __construct( $name, $args = array() ){
		global $post, $tk_form_instance_option_group;
		
		$defaults = array(
			'option_group' => $tk_form_instance_option_group,
			'id' => $this->get_id(),
			'default_value' => '',
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
			'option_group' => $option_group,	
			'id' => $id,
			'name' => $name,
			'css_classes' => $css_classes,
			'value' => $value,
			'extra' => $extra,
			'multi_index' => $multi_index,
			'before_element' => $before_element,
			'after_element' => $after_element
		);
		parent::__construct( $name, $args );
		
		$this->autocomplete_values = array();
		$this->delete_values = array();
	}
	
	function add_autocomplete_value( $value ){
		array_push( $this->autocomplete_values, $value ); 
	}
	
	
	function delete_autocomplete_value( $value ){
		$delete_keys = array_keys( $this->autocomplete_values, $value );
		foreach( $delete_keys AS $key ){
			unset( $this->autocomplete_values[ $key ] );
		}
	}
	
	function get_html(){
		$this->merge_autocomplete_elements();
		
		$html = parent::get_html();
		
		$autocomplete_values = array();
		
		foreach( $this->autocomplete_values AS $key => $value )
			array_push( $autocomplete_values, '"' .  $value . '"' );

		$values = implode( ',', $autocomplete_values );
		
		$html .= '
			<script type="text/javascript">
			  	jQuery(document).ready(function($){
				  	$("#' . $this->id . '").autocomplete({ source: [' . $values . '] });
			  	});
	  		</script>
	  	';	
		
	  	return $html;
	  
	}
	
	function merge_autocomplete_elements(){
		global $tk_autocomplete_elements;
		
		if( is_array( $tk_autocomplete_elements[ $this->id ] ) ){
			
			foreach( $tk_autocomplete_elements[ $this->id ] AS $element ){
				
				if( $element[ 'action' ] == 'add' )
					$this->add_autocomplete_value( $element['value'] );
				
				if( $element[ 'action' ] == 'delete' )
					$this->delete_autocomplete_value( $element['value'] );
							
				
			}
		}
	}
}

function tk_jqueryui_autocomplete( $name, $values, $args, $return_object = false ){
	$autocomplete = new TK_Jqueryui_Autocomplete( $name, $args );
	
	foreach ( $values AS $value ){
		$autocomplete->add_autocomplete_value( $value[0] );
	}
	
	if( TRUE == $return_object ){
		return $autocomplete;
	}else{
		return $autocomplete->get_html();
	}
}

function tk_autocomplete_add_value( $autocomplete_id, $value ){
	global $tk_autocomplete_elements;
	
	if( !is_array( $tk_autocomplete_elements[ $autocomplete_id ] ) )
		$tk_autocomplete_elements[ $autocomplete_id ] = array();
		
	array_push( $tk_autocomplete_elements[ $autocomplete_id ], array( 'action' => 'add' , 'value' => $value ) );
}

function tk_autocomplete_delete_value( $autocomplete_id, $value ){
	global $tk_autocomplete_elements;
	
	if( !is_array( $tk_autocomplete_elements[ $autocomplete_id ] ) )
		$tk_autocomplete_elements[ $autocomplete_id ] = array();
		
	array_push( $tk_autocomplete_elements[ $autocomplete_id ], array( 'action' => 'delete' , 'value' => $value ) );	
}
