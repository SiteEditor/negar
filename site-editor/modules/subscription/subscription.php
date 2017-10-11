<?php
/*
Module Name: Subscription
Module URI: http://www.siteeditor.org/modules/subscription
Description: Module Subscription For Page Builder Application
Author: Site Editor Team
Author URI: http://www.siteeditor.org
Version: 1.0.0
*/

/**
 * Class PBSubscriptionShortcode
 */
class PBSubscriptionShortcode extends PBShortcodeClass{

    /**
     * Register module with siteeditor.
     */
    function __construct() {
        parent::__construct( array(
                "name"        => "sed_subscription",                               //*require
                "title"       => __("Subscription","site-editor"),                 //*require for toolbar
                "description" => __("List of subscription for built-in and custom post types","site-editor"),
                "icon"        => "icon-subscription",                               //*require for icon toolbar
                "module"      =>  "subscription"         //*require
                //"is_child"    =>  "false"       //for childe shortcodes like sed_tr , sed_td for table module
            ) // Args
        );

    }

    function get_atts(){

        $atts = array(
            //"product_description"                   => ''
        );

        return $atts;

    }

    function add_shortcode( $atts , $content = null ){



    }
    
    /*function styles(){
        return array(
            array('posts-skin-default', get_stylesheet_directory_uri().'/site-editor/modules/posts/skins/default/css/style.css' ,'1.0.0' ) ,
        );
    }*/

    function shortcode_settings(){

        $this->add_panel( 'subscription_settings_panel' , array(
            'title'               =>  __('Subscription Settings',"site-editor")  ,
            'capability'          => 'edit_theme_options' ,
            'type'                => 'inner_box' ,
            'priority'            => 9 ,
            'btn_style'           => 'menu' ,
            'has_border_box'      => false ,
            'icon'                => 'sedico-setting' ,
            'field_spacing'       => 'sm'
        ) );

        $params = array();

        /*$params['sed_shortcode_content'] = array(
            "label"             => __("Product Description", "site-editor"),
            'type'              => 'textarea',
            'priority'          => 10,
            'default'           => "",
            "panel"             => "subscription_settings_panel",
        );*/

        $params['animation'] =  array(
            "type"                => "animation" ,
            "label"               => __("Animation Settings", "site-editor"),
            'button_style'        => 'menu' ,
            'has_border_box'      => false ,
            'icon'                => 'sedico-animation' ,
            'field_spacing'       => 'sm' ,
            'priority'            => 530 ,
        );

        $params['row_container'] = array(
            'type'          => 'row_container',
            'label'         => __('Module Wrapper Settings', 'site-editor')
        );
       

        return $params;

    }

}

new PBSubscriptionShortcode();

global $sed_pb_app;                      

$sed_pb_app->register_module(array(
    "group"                 =>  "basic" ,
    "name"                  =>  "subscription",
    "title"                 =>  __("Subscription","site-editor"),
    "description"           =>  __("List of subscription for built-in and custom post types","site-editor"),
    "icon"                  =>  "icon-subscription",
    "type_icon"             =>  "font",
    "shortcode"             =>  "sed_subscription",
    //"priority"              =>  10 ,
    "transport"             =>  "ajax" ,
));


