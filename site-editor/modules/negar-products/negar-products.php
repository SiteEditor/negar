<?php
/*
Module Name: Negar Products
Module URI: http://www.siteeditor.org/modules/negar-products
Description: Module Negar Products For Page Builder Application
Author: Site Editor Team
Author URI: http://www.siteeditor.org
Version: 1.0.0
*/

/**
 * Class PBNegarProductsShortcode
 */
class PBNegarProductsShortcode extends PBShortcodeClass{

    /**
     * Register module with siteeditor.
     */
    function __construct() {
        parent::__construct( array(
                "name"        => "sed_negar_products",                               //*require
                "title"       => __("Negar Products","site-editor"),                 //*require for toolbar
                "description" => __("List of negar products for built-in and custom post types","site-editor"),
                "icon"        => "icon-negar-products",                               //*require for icon toolbar
                "module"      =>  "negar-products"         //*require
                //"is_child"    =>  "false"       //for childe shortcodes like sed_tr , sed_td for table module
            ) // Args
        );

    }

    function get_atts(){

        $atts = array(
            "product_category_terms"                   => ''
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

        $this->add_panel( 'negar_products_settings_panel' , array(
            'title'               =>  __('Negar Products Settings',"site-editor")  ,
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
            "panel"             => "negar_products_settings_panel",
        );*/

        $terms = get_terms( array(
            'taxonomy'      => 'product_cat',
            'hide_empty'    => false
        ) );

        $terms_choices = array();

        if( !empty( $terms ) && is_array( $terms ) ) {

            //$terms_choices[0] = __("Select term" , "site-editor");

            foreach ( $terms as $term ) {

                $terms_choices[$term->term_id] = $term->name;

            }

        }

        $params['product_category_terms'] = array(
            "type"          => "multi-select" ,
            "label"         => __("Select Categories", "site-editor"),
            "description"   => __("Select Product Categories", "site-editor"),
            "choices"       => $terms_choices,
            //"is_attr"       => true ,
            //"attr_name"     => "terms" ,
            "panel"         => "negar_products_settings_panel" ,
        );

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

    function custom_style_settings(){
        return array(

            array(
                'sliders-title' , '.punchline > .title > h3 > a' ,
                array( 'font' ) , __("Sliders Title" , "site-editor")
            ) ,

        );
    }

}

new PBNegarProductsShortcode();

global $sed_pb_app;                      

$sed_pb_app->register_module(array(
    "group"                 =>  "basic" ,
    "name"                  =>  "negar-products",
    "title"                 =>  __("Negar Products","site-editor"),
    "description"           =>  __("List of negar products for built-in and custom post types","site-editor"),
    "icon"                  =>  "icon-negar-products",
    "type_icon"             =>  "font",
    "shortcode"             =>  "sed_negar_products",
    //"priority"              =>  10 ,
    "transport"             =>  "ajax" ,
));


