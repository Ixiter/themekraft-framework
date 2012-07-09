<?php
class TK_WP_Form_Textarea extends TK_Form_Textarea{		var $option_group;		/**	 * PHP 4 constructor	 *	 * @package Themekraft Framework	 * @since 0.1.0	 * 	 * @param string $name Name of textarea	 * @param array $args Array of [ $id Id, $name Name, $extra Extra textarea code, $rows Number of rows in textarea, $cols Number of columns in textarea, $before_textarea Code before textarea, $after_textarea Code after textarea ]	 */	function tk_wp_form_textarea( $name, $args = array() ){		$this->__construct( $name, $args );	}
	/**	 * PHP 5 constructor	 *	 * @package Themekraft Framework	 * @since 0.1.0	 * 	 * @param string $name Name of textfield	 * @param array $args Array of [ $id Id, $name Name, $value Value, $extra Extra textarea code, $rows Number of rows in textarea, $cols Number of columns in textarea, $before_textarea Code before textarea, $after_textarea Code after textarea ]	 */	function __construct( $name, $args = array() ){		global $post, $tk_form_instance_option_group;				$defaults = array(			'id' => '',			'extra' => '',			'rows' => '',			'cols' => '',			'multi_index' => '',			'option_group' => $tk_form_instance_option_group		);				$args = wp_parse_args( $args, $defaults );		extract( $args , EXTR_SKIP );		$field_name = tk_get_field_name( $name, array( 'option_group' => $option_group, 'multi_index' => $multi_index ) );			$value = tk_get_value( $name, array( 'option_group' => $option_group, 'multi_index' => $multi_index, 'default_value' => $default_value ) );
		$args['name'] = $field_name;		$args['value'] = $value;				parent::__construct( $args );	}}
function tk_form_textarea( $name, $args = array(), $return_object = FALSE ){	$textarea = new TK_WP_Form_Textarea( $name, $args );
	if( TRUE == $return_object ){		return $textarea;	}else{		return $textarea->get_html();	}}