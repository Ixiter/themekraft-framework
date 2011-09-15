<?php

class TK_WP_Form_Textarea extends TK_Form_Textarea{
	
	var $option_group;
	
	/**
	 * PHP 4 constructor
	 *
	 * @package Themekraft Framework
	 * @since 0.1.0
	 * 
	 * @param string $name Name of textarea
	 * @param array $args Array of [ $id Id, $name Name, $extra Extra textarea code, $rows Number of rows in textarea, $cols Number of columns in textarea, $before_textarea Code before textarea, $after_textarea Code after textarea ]
	 */
	function tk_wp_form_textarea( $name, $args = array() ){
		$this->__construct( $name, $args );
	}
	
	/**
	 * PHP 5 constructor
	 *
	 * @package Themekraft Framework
	 * @since 0.1.0
	 * 
	 * @param string $name Name of textfield
	 * @param array $args Array of [ $id Id, $name Name, $value Value, $extra Extra textarea code, $rows Number of rows in textarea, $cols Number of columns in textarea, $before_textarea Code before textarea, $after_textarea Code after textarea ]
	 */
	function __construct( $name, $args = array() ){
		global $post, $tk_form_instance_option_group;
		
		$defaults = array(
			'id' => '',
			'extra' => '',
			'rows' => '',
			'cols' => '',
			'option_group' => $tk_form_instance_option_group,
			'before_textarea' => '',
			'after_textarea' => ''
		);
		
		$args = wp_parse_args( $args, $defaults );
		extract( $args , EXTR_SKIP );

		if( $post != '' ){

			$option_group_value = get_post_meta( $post->ID , $option_group , true );
			
			$field_name = $option_group . '[' . $name . ']';
			$value = $option_group_value[ $name ];

		}else{
			$value = get_option( $option_group  . '_values' );
			
			$this->option_group = $option_group;
			$field_name = $option_group . '_values[' . $name . ']';	
			
			$value = $value[ $name ];
		} 
		
		$args['name'] = $field_name;
		$args['value'] = $value;
		
		parent::__construct( $args );

	}
		
}

function tk_form_textarea( $name, $args = array(), $return_object = FALSE ){
	$textarea = new TK_WP_Form_Textarea( $name, $args );
	
	if( TRUE == $return_object ){
		return $textarea;
	}else{
		return $textarea->get_html();
	}
}

?>