<?php
class TK_WP_Fileuploader extends TK_Fileuploader{		var $uploader;	var $delete;	var $wp_name;		/**	 * PHP 4 constructor	 *	 * @package Themekraft Framework	 * @since 0.1.0	 * 	 * @param string $name Name of colorfield	 * @param array $args Array of [ $id , $extra Extra colorfield code, option_groupOption group to save data, $before_textfield Code before colorfield, $after_textfield Code after colorfield   ]	 */	function tk_wp_fileuploader( $name, $args = array() ){		$this->__construct( $name, $args );	}		/**	 * PHP 5 constructor	 *	 * @package Themekraft Framework	 * @since 0.1.0	 * 	 * @param string $name Name of colorfield	 * @param array $args Array of [ $id , $extra Extra colorfield code, option_groupOption group to save data, $before_textfield Code before colorfield, $after_textfield Code after colorfield   ]	 */	function __construct( $name, $args = array() ){		global $post, $tk_form_instance_option_group;				$defaults = array(			'option_group' => $tk_form_instance_option_group,			'id' => $this->get_id(),			'extra' => '',			'uploader' => 'wp', // wp or file			'multi_index' => '',			'before_element' => '',			'after_element' => '',			'insert_as_attachement' => FALSE,			'delete' => FALSE		);				$parsed_args = wp_parse_args( $args, $defaults );		extract( $parsed_args , EXTR_SKIP );				// Putting Args to parent		$args = array(			'id' => $id,			'name' => $name,			'css_classes' => $css_classes,			'extra' => $extra,			'multi_index' => $multi_index,			'before_element' => $before_element,			'after_element' => $after_element		);		parent::__construct( $args );				$this->wp_name = $name;				// Rewriting Fieldname and Input Field String for WP Savings		$name = tk_get_field_name( $name, array( 'option_group' => $option_group, 'multi_index' => $multi_index ) );		$this->str_name = ' name="' . $name . '"';				$this->uploader = $uploader;		$this->delete = $delete;		$this->insert_attachement = $insert_attachement;				if( $this->uploader == 'file' ):			add_filter( 'sanitize_option_' . $tk_form_instance_option_group . '_values', array( &$this , 'validate_actions' ), 9999 );		endif;	}		function validate_actions( $input ){		global $tk_form_instance_option_group;				// If error occured		if( $_FILES[ $tk_form_instance_option_group . '_values' ][ 'error' ][ $this->wp_name ] != 0  ){			$input[ $this->wp_name ] = $this->value;					}else{			// Storing new file			$file[ 'name' ] = $_FILES[ $tk_form_instance_option_group . '_values' ][ 'name' ][ $this->wp_name ];			$file[ 'type' ] = $_FILES[ $tk_form_instance_option_group . '_values' ][ 'type' ][ $this->wp_name ];			$file[ 'tmp_name' ] = $_FILES[ $tk_form_instance_option_group . '_values' ][ 'tmp_name' ][ $this->wp_name ];			$file[ 'error' ] = $_FILES[ $tk_form_instance_option_group . '_values' ][ 'error' ][ $this->wp_name ];			$file[ 'size' ] = $_FILES[ $tk_form_instance_option_group . '_values' ][ 'size' ][ $this->wp_name ];						// Deleting old file			if( !empty( $this->value['file'] ) ){				@unlink( $this->value['file'] );			}						$file = apply_filters( 'tk_fileupload_' . $this->id, $file, $input );						// If file saving should be dismissed			if( $this->delete ){				@unlink( $file[ 'tmp_name' ] );							}else{				$override = array(						'test_form' => false,						'action' => 'update'					);										$wp_file = wp_handle_upload( $file, $override );								@unlink( $file[ 'tmp_name' ] );								$input[ $this->wp_name ] = $wp_file;			}					}				return $input;	}		function get_html(){				if( $this->uploader == 'file'):					if( isset( $this->value[ 'url' ] ) ){				$file_url = $this->value[ 'url' ];				$file_path = $this->value[ 'file' ];				$file_name = basename( $file_path );								$url_box = '<div class="tkf_file"><a href="' . $file_url . '">' . $file_name . '</a></div>';								$this->before_element = $this->before_element .  $url_box ;			}					$html = parent::get_html();					elseif( $this->uploader == 'wp' || $this->uploader == '' ):			$args = array( 				'id' => $this->id ,				'option_group' => $this->option_group,				'multi_index' => $this->multi_index			);						$form_field = new TK_WP_Form_Textfield( $this->wp_name, $args );			$html = $this->before_element . $form_field->get_html() . '<input class="tk_fileuploader" type="button" value="' . __( 'Browse ...' ) . '" /><br /><img class="tk_image_preview" id="image_' . $this->id . '" />' . $this->after_element; 		endif;					return $html;	}}
function tk_form_fileuploader( $name, $args = array(), $return_object = FALSE ){	$fileuploader = new TK_WP_Fileuploader( $name, $args );		if( TRUE == $return_object ){		return $fileuploader;	}else{		return $fileuploader->get_html();	}}