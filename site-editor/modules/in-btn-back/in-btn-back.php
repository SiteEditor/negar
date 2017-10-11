<?php
/*
Module Name:Back To Up
Module URI: http://www.siteeditor.org/modules/in-btn-back
Description: Module Back To Up For Page Builder Application
Author: Site Editor Team
Author URI: http://www.siteeditor.org
Version: 1.0.0
*/

class PBInBtnBackShortcode extends PBShortcodeClass{

	/**
	 * Register module with siteeditor.
	 */
	function __construct() {
		parent::__construct( array(
                "name"        => "sed_in_btn_back",
                "title"       => __("Back To Up","site-editor"),
                "description" => __("Back To Up","site-editor"),
                "icon"        => "icon-portfolio",
                "module"      =>  "in-btn-back"
            ) // Args
		);
	}

    function get_atts(){
        $atts = array(
        );

        return $atts;
    }

    function add_shortcode( $atts , $content = null ){

    }

    function scripts(){
        return array(
            array('modules-btn-back' , get_stylesheet_directory_uri() . "/site-editor/modules/in-btn-back/js/scripts.js",array( 'jquery' ),'1.0.0',true) 
        );
    }
    
    function styles(){
        return array(
            array('modules-btn-back', get_stylesheet_directory_uri().'/site-editor/modules/in-btn-back/css/style.css' ,'1.0.0' ) ,
        );
    }

    function shortcode_settings(){

        $params = array(     

            'row_container' => array(
                'type'          => 'row_container',
                'label'         => __('Module Wrapper Settings', 'site-editor')
            ), 

            "animation"  =>  array(
                "type"                => "animation" ,
                "label"               => __("Animation Settings", "site-editor"),
                'button_style'        => 'menu' ,
                'has_border_box'      => false ,
                'icon'                => 'sedico-animation' ,
                'field_spacing'       => 'sm' ,
                'priority'            => 530 ,
            )
              
        );

        return $params;

    }


    function contextmenu( $context_menu ){
        $in_btn_back_menu = $context_menu->create_menu( "in-btn-back" , __("Back To Up","site-editor") , 'icon-portfolio' , 'class' , 'element' , ''  , "sed_in_btn_back" , array(
            "seperator"    => array(75),
            "change_skin"  =>  false ,
            "edit_style"   =>  false,
            "duplicate"    => false
        ));
    }

}

new PBInBtnBackShortcode();

global $sed_pb_app;

$sed_pb_app->register_module(array(
    "group"       => "content" ,
    "name"        => "in-btn-back",
    "title"       => __("Back To Up","site-editor"),
    "description" => __("Back To Up","site-editor"),
    "icon"        => "icon-portfolio",
    "shortcode"   => "sed_in_btn_back",
));



