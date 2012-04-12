<?php

class TK_WP_Form_Textfield extends TK_Form_Textfield{
	
	var $option_group;
	
	/**
	 * PHP 4 constructor
	 *
	 * @package Themekraft Framework
	 * @since 0.1.0
	 * 
	 * @param string $name Name of textfield
	 * @param array $args Array of [ $id , $value,  $extra Extra textfield code   ]
	 */
	function tk_wp_form_textfield( $name, $args = array() ){
		$this->__construct( $name, $args );
	}
	
	/**
	 * PHP 5 constructor
	 *
	 * @package Themekraft Framework
	 * @since 0.1.0
	 * 
	 * @param string $name Name of textfield
	 * @param array $args Array of [ $id,  $extra Extra textfield code, $option_group Name of optiongroup where textfield have to be saved   ]
	 */
	function __construct( $name, $args = array() ){
		global $post, $tk_form_instance_option_group;
		
		$defaults = array(
			'id' => '',
			'extra' => '',
			'default_value' => '',
			'option_group' => $tk_form_instance_option_group,
			'multi_index' => '',
			'before_element' => '',
			'after_element' => ''
		);
		
		$parsed_args = wp_parse_args( $args, $defaults );
		extract( $parsed_args , EXTR_SKIP );
		
		if( $post != '' ){

			$option_group_value = get_post_meta( $post->ID , $option_group , true );
			
			if( is_array( $multi_index ) ):
				$field_name = $option_group . '[' . $name . ']';
				
				foreach ( $multi_index as $index ) {
					$field_name .= '[' . $index . ']';
				}
			else:
				$field_name = $option_group . '[' . $name . ']';
			endif;
			
			if( $multi_index != '' )
				if( is_array( $multi_index ) ):
					// Getting values of multiindex array
					$value = tk_get_multiindex_value( $value[ $name ], $multi_index );
				else:
					$value = $value[ $name ][ $multi_index ];
				endif;
			else
				$value = $option_group_value[ $name ];

		}else{
			$value = get_option( $option_group  . '_values' );
			
			$this->option_group = $option_group;
			
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
		
		$args['name'] = $field_name;
		$args['value'] = $value;

		parent::__construct( $args );
	}

	function get_html(){
		$this->field_name_set = TRUE;
		return parent::get_html();
	}

}

function tk_form_textfield( $name, $args = array(), $return_object = FALSE ){
	$textfield = new TK_WP_Form_Textfield( $name, $args );
		
	if( TRUE == $return_object ){
		return $textfield;
	}else{
		return $textfield->get_html();
	}
}