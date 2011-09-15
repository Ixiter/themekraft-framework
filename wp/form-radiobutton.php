<?php

class TK_WP_Form_Radiobutton extends TK_Form_Radiobutton{
	
	var $option_group;
	
	/**
	 * PHP 4 constructor
	 *
	 * @package Themekraft Framework
	 * @since 0.1.0
	 * 
	 * @param string $name Name of radiobutton
	 * @param array $args Array of [ $id,  $extra Extra radiobutton code, $option_group Name of optiongroup where textfield have to be saved, $before_radiobutton Code before radiobutton, $after_radiobutton Code after radiobutton    ]
	 */
	function tk_wp_form_radiobutton( $name, $value, $args = array() ){
		$this->__construct( $name, $value, $args );
	}
	
	/**
	 * PHP 5 constructor
	 *
	 * @package Themekraft Framework
	 * @since 0.1.0
	 * 
	 * @param string $name Name of radiobutton
	 * @param array $args Array of [ $id,  $extra Extra radiobutton code, $option_group Name of optiongroup where textfield have to be saved, $before_radiobutton Code before radiobutton, $after_radiobutton Code after radiobutton    ]
	 */
	function __construct( $name, $value, $args = array() ){
		global $post, $tk_form_instance_option_group;
		
		$defaults = array(
			'id' => '',
			'extra' => '',
			'option_group' => $tk_form_instance_option_group,
			'before_radiobutton' => '',
			'after_radiobutton' => ''
		);
		
		$args = wp_parse_args( $args, $defaults );
		extract( $args , EXTR_SKIP );

		if( $post != '' ){

			$option_group_value = get_post_meta( $post->ID , $option_group , true );
			
			$field_name = $option_group . '[' . $name . ']';
			$field_value = $option_group_value[ $name ];

		}else{
			$field_value = get_option( $option_group  . '_values' );
			
			$this->option_group = $option_group;
			$field_name = $option_group . '_values[' . $name . ']';	
			
			$field_value = $field_value[ $name ];
		}

		if( $field_value == $value ){
			$args['checked'] = TRUE;
		}
	
		$args['name'] = $field_name;
		$args['value'] = $value;
		
		parent::__construct( $args );

	}
		
}

function tk_form_radiobutton( $name, $value,  $args = array(), $return_object = FALSE ){
	$radiobutton = new TK_WP_Form_Radiobutton( $name, $value, $args );
	
	if( TRUE == $return_object ){
		return $radiobutton;
	}else{
		return $radiobutton->get_html();
	}
}

?>