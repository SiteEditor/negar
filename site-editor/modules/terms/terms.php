<?php
/*
Module Name: Terms
Module URI: http://www.siteeditor.org/modules/terms
Description: Module Terms For Page Builder Application
Author: Site Editor Team
Author URI: http://www.siteeditor.org
Version: 1.0.0
*/

/**
 * Class PBTermsShortcode
 */
class PBTermsShortcode extends PBShortcodeClass{

    /**
     * Register module with siteeditor.
     */
    function __construct() {

        parent::__construct( array(
                "name"        => "sed_terms",                               //*require
                "title"       => __("Terms","site-editor"),                 //*require for toolbar
                "description" => __("List of terms for built-in and custom taxonomies","site-editor"),
                "icon"        => "icon-terms",                               //*require for icon toolbar
                "module"      =>  "terms"         //*require
                //"is_child"    =>  "false"       //for childe shortcodes like sed_tr , sed_td for table module
            ) // Args
        );

    }

    function get_atts(){

        $atts = array(
            'show_title'                => true,
            'title'                     => '',
            "taxonomy"                  => '',
            'post_type'                 => 'post'
        );

        return $atts;

    }

    function add_shortcode( $atts , $content = null ){

        extract( $atts );

        $terms = array(); 

        $is_tax = $taxonomy && ( is_tax( $taxonomy ) || ( $taxonomy == "category" && is_category() ) );

        $is_post_type_archive = $post_type && is_post_type_archive( $post_type );

        $product_has_child = false;

        if( $post_type == "product" && $taxonomy == "product_cat" && is_tax( $taxonomy ) ){

            $sed_tax_id = get_queried_object()->term_id;

            $term_children = get_term_children( $sed_tax_id , $taxonomy );

            if( !empty( $term_children ) && ! is_wp_error( $term_children ) ){

                $product_has_child = true;

            }

        }

        if( $post_type == "post" && ! is_front_page() && is_home() ) {

            $is_post_type_archive = true;

        }

        $fiter_title = $title;

        if( ( $is_tax || $is_post_type_archive ) && $taxonomy && ! $product_has_child ){

            if( $is_tax ) {

                $sed_tax_id = get_queried_object()->term_id;

                $current_term = get_term( $sed_tax_id );

                $args = array(
                    'taxonomy'          => $taxonomy,
                    'hide_empty'        => false ,
                    'hierarchical'      => false,
                    'child_of'          => $current_term->parent
                );

                if( $current_term->parent > 0 && $parent_term = get_term( $current_term->parent) ) {

                    $fiter_title = $parent_term->name;

                }


            }else{

                $args = array(
                    'taxonomy'          => $taxonomy,
                    'hide_empty'        => false,
                    'hierarchical'      => false,
                    'child_of'          => 0
                );

            }

            $terms = get_terms( $args );

        }

        /*
        if( $is_tax && count( $terms ) == 1 ){

            $terms = array();

        }*/

        $vars = array();

        if( $is_tax ){

            $vars["current_term_id"] = $sed_tax_id ;

        }

        $vars["is_tax"] = $is_tax ;

        $vars["terms"] = $terms ;

        $vars["fiter_title"] = $fiter_title;

        $this->set_vars( $vars );

    }
    
    function styles(){
        return array(
            //array('terms-skin-default', get_stylesheet_directory_uri().'/site-editor/modules/terms/skins/default/css/style.css' ,'1.0.0' ) ,
        );
    }

    function shortcode_settings(){

        $this->add_panel( 'terms_settings_panel' , array(
            'title'               =>  __('Terms Settings',"site-editor")  ,
            'capability'          => 'edit_theme_options' ,
            'type'                => 'inner_box' ,
            'priority'            => 9 ,
            'btn_style'           => 'menu' ,
            'has_border_box'      => false ,
            'icon'                => 'sedico-setting' ,
            'field_spacing'       => 'sm'
        ) );

        $params = array();


        $params['show_title'] = array(
            'label'             => __('Show Title', 'site-editor'),
            'type'              => 'switch',
            'choices'           => array(
                "on"       =>    "ON" ,
                "off"      =>    "OFF" ,
            ),
            "panel"         => "terms_settings_panel" ,
        );

        $params['title'] = array(
            "type"              => "text" ,
            "label"             => __("Title", "site-editor"),
            "description"       => __("Module Title", "site-editor"),
            "placeholder"       => __("Enter Module Title", "site-editor"),
            "panel"             => "terms_settings_panel",
            'dependency'    => array(
                'queries'  =>  array(
                    array(
                        "key"       => "show_title" ,
                        "value"     => true ,
                        "compare"   => "==="
                    )
                )
            )
        );

        $args = array(
            'public'   => true,
            //'_builtin' => true
        );

        $output = 'objects';
        $taxonomies = get_taxonomies( $args, $output );

        $taxonomies_choices = array( '' => __("Select Taxonomy" , "site-editor") );

        foreach ( $taxonomies  as $taxonomy ) {

            $taxonomies_choices[$taxonomy->name] = $taxonomy->labels->name;

        }

        $params['taxonomy'] = array(
            "type"          => "select" ,
            "label"         => __("Select Taxonomy", "site-editor"),
            "description"   => __("Select Taxonomy", "site-editor"),
            "choices"       => $taxonomies_choices,
            "panel"         => "terms_settings_panel" ,
        );

        $post_types = get_post_types( array( 'show_in_nav_menus' => true , 'public' => true ), 'object' );

        $post_types_choices = array();

        foreach ($post_types AS $post_type_name => $post_type) {

            $post_types_choices[$post_type_name] = $post_type->name;

        }

        $params['post_type'] = array(
            "type"          => "select" ,
            "label"         => __("Select Post Type", "site-editor"),
            "description"   => __("Select Type of Posts", "site-editor"),
            "choices"       =>  $post_types_choices,
            "panel"         => "terms_settings_panel" ,
        );

        $params['skin'] = array(
            "type"                => "skin" ,
            "label"               => __("Change skin", "site-editor"),
            'button_style'        => 'menu' ,
            'has_border_box'      => false ,
            'icon'                => 'sedico-change-skin' ,
            'field_spacing'       => 'sm' ,
            'priority'            => 540
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

}

new PBTermsShortcode();

global $sed_pb_app;                      

$sed_pb_app->register_module(array(
    "group"                 =>  "basic" ,
    "name"                  =>  "terms",
    "title"                 =>  __("Terms","site-editor"),
    "description"           =>  __("List of terms for built-in and custom taxonomies","site-editor"),
    "icon"                  =>  "icon-terms",
    "type_icon"             =>  "font",
    "shortcode"             =>  "sed_terms",
    //"priority"              =>  10 ,
    "transport"             =>  "ajax" ,
));


