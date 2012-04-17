<?php
class TK_WP_Form_Textarea extends TK_Form_Textarea{		var $option_group;		/**	 * PHP 4 constructor	 *	 * @package Themekraft Framework	 * @since 0.1.0	 * 	 * @param string $name Name of textarea	 * @param array $args Array of [ $id Id, $name Name, $extra Extra textarea code, $rows Number of rows in textarea, $cols Number of columns in textarea, $before_textarea Code before textarea, $after_textarea Code after textarea ]	 */	function tk_wp_form_textarea( $name, $args = array() ){		$this->__construct( $name, $args );	}
	/**	 * PHP 5 constructor	 *	 * @package Themekraft Framework	 * @since 0.1.0	 * 	 * @param string $name Name of textfield	 * @param array $args Array of [ $id Id, $name Name, $value Value, $extra Extra textarea code, $rows Number of rows in textarea, $cols Number of columns in textarea, $before_textarea Code before textarea, $after_textarea Code after textarea ]	 */	function __construct( $name, $args = array() ){		global $post, $tk_form_instance_option_group;				$defaults = array(			'option_group' => $tk_form_instance_option_group,			'id' => '',			'default_value' => '',			'css_classes' => '',			'rows' => '',			'cols' => '',			'extra' => '',			'multi_index' => '',			'before_element' => '',			'after_element' => ''		);				$args = wp_parse_args( $args, $defaults );		extract( $args , EXTR_SKIP );		// Getting value		$value = tk_get_value( $name, array( 'option_group' => $option_group, 'multi_index' => $multi_index, 'default_value' => $default_value ) );				// Putting Args to parent		$args = array(			'id' => $id,			'name' => $name,			'value' => $value,			'css_classes' => $css_classes,			'rows' => '',			'cols' => '',			'extra' => $extra,			'multi_index' => $multi_index,			'before_element' => $before_element,			'after_element' => $after_element		);		parent::__construct( $args );				// Rewriting Fieldname and Input Field String for WP Savings		$name = tk_get_field_name( $name, array( 'option_group' => $option_group, 'multi_index' => $multi_index ) );		$this->str_name = ' name="' . $name . '"';	}}
function tk_form_textarea( $name, $args = array(), $return_object = FALSE ){	$textarea = new TK_WP_Form_Textarea( $name, $args );
	if( TRUE == $return_object ){		return $textarea;	}else{		return $textarea->get_html();	}}