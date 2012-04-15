<?php

class TK_Values{
	var $option_group;
	
	/**
	 * PHP 4 constructor
	 *
	 * @package Themekraft Framework
	 * @since 0.1.0
	 * 
	 */
	function tk_values( $option_group ){
		$this->__construct( $option_group );
	}
	
	/**
	 * PHP 5 constructor
	 *
	 * @package Themekraft Framework
	 * @since 0.1.0
	 * 
	 */
	function __construct( $option_group ){
		$this->option_group = $option_group;
	}
	
	function get_values(){
		$values = get_option( $this->option_group  . '_values' );
		
		if( $values != '' )
			return (object) $values;
			 
		return FALSE;
	}
	
	function set_values( $values ){
		return update_option( $this->option_group . '_values', $values );
	}
	
	function get_post_values( $postID = FALSE ){
		global $post;
		
		if( $postID != FALSE ){
			return get_post_meta( $postID , $option_group , true );
		}else if( isset( $post ) ){
			return get_post_meta( $post->ID , $option_group , true );
		}else{
			return FALSE;
		}
	}
}

function tk_encrypt_string( $string ){
	for( $i = 0; $i < strlen( $string ) ; $i++ ){
		$string_encrypted.= chr( $string[$i] );
	}
	return $string_encrypted;
}
function tk_decrypt_string( $string ){
	for( $i=0 ; $i < strlen( $string ); $i++ ){
		$string_decrypted.= ord( $string[$i] );
	}
	return $string_decrypted;
}

function tk_get_values( $option_group ){
	$val = new TK_Values( $option_group );
	return $val->get_values();
}

function tk_set_values( $option_group, $values ){
	$val = new TK_Values( $option_group );
	return $val->set_values( $values );
}

// Helper functions
function tk_get_value( $name, $args = array() ){
	global $post, $tk_form_instance_option_group;
	
	$defaults = array(
			'option_group' => $tk_form_instance_option_group,
			'multi_index' => '',
			'default_value' => ''
		);
		
	$parsed_args = wp_parse_args( $args, $defaults );
	extract( $parsed_args , EXTR_SKIP );
	
	// Getting values from post
	if( $post != '' ){

		$value = get_post_meta( $post->ID , $option_group , true );
		
		// Getting field value			
		if( $multi_index != '' )
			if( is_array( $multi_index ) ):
				// Getting values of multiindex array
				$value = tk_get_multiindex_value( $value[ $name ], $multi_index );
			else:
				$value = $value[ $name ][ $multi_index ];
			endif;
		else
			$value = $value[ $name ];
	
	// Getting values from options
	}else{
		$value = get_option( $option_group  . '_values' );
		
		// Setting up value
		if( $multi_index != '' ):
			if( is_array( $multi_index ) ):
				// Getting values of multiindex array
				$value = tk_get_multiindex_value( $value[ $name ], $multi_index );
			else:
				$value = $value[ $name ][ $multi_index ];
			endif;
		else:
			$value = $value[ $name ];
		endif;
	}
	
	// Setting up default value if no value is given
	if( $value == '' )
		$value = $default_value;
	
	return $value;
}
function tk_get_field_name( $name, $args = array() ){
	global $post, $tk_form_instance_option_group;
	
	$defaults = array(
			'option_group' => $tk_form_instance_option_group,
			'multi_index' => ''
		);
		
	$parsed_args = wp_parse_args( $args, $defaults );
	extract( $parsed_args , EXTR_SKIP );
	
	// Getting values from post
	if( $post != '' ){

		// Getting field name
		if( is_array( $multi_index ) ):
			$field_name = $option_group . '[' . $name . ']';
			
			foreach ( $multi_index as $index ) {
				$field_name .= '[' . $index . ']';
			}
		else:
			$field_name = $option_group . '[' . $name . ']';
		endif;
		
	// Getting values from options
	}else{
		// Setting up fieldname
		if( is_array( $multi_index ) ):
			$field_name = $option_group . '_values[' . $name . ']';	
			foreach ( $multi_index as $index ) {
				$field_name .= '[' . $index . ']';
			}
		elseif ( $multi_index != '' ):
			$field_name = $option_group . '_values[' . $name . '][' . $multi_index . ']';	
		else:
			$field_name = $option_group . '_values[' . $name . ']';
		endif;
	}
	
	return $field_name;
}

function tk_get_multiindex_value( $value, $multi_index, $i = 0 ){
    if( count( $multi_index ) >  $i ):
		return tk_get_multiindex_value( $value[$multi_index[$i]], $multi_index, ++$i );
	else:
		return $value;
	endif;
}