<?php
//
// Recommended way to include parent theme styles.
//  (Please see http://codex.wordpress.org/Child_Themes#How_to_Create_a_Child_Theme)
//

function negar_enqueue_styles() {

    wp_enqueue_style( 'negar-parent-style', get_template_directory_uri() . '/style.css' );

    wp_enqueue_style( 'negar-style',
        get_stylesheet_directory_uri() . '/style.css',
        array('parent-style')
    );
    /**
     * Theme Front end main js
     */
    wp_enqueue_script( "negar-script" , get_stylesheet_directory_uri() . '/assets/js/script.js' , array( 'jquery', 'carousel' , 'sed-livequery' , 'jquery-ui-accordion' , 'jquery-ui-tabs' ) , "1.0.0" , true );

    //wp_enqueue_script('sed-masonry');

    wp_enqueue_script('lightbox');

    wp_enqueue_script('jquery-scrollbar');

    wp_enqueue_style('custom-scrollbar');

    wp_enqueue_style("carousel");

    wp_enqueue_style("lightbox");

}

add_action( 'wp_enqueue_scripts', 'negar_enqueue_styles' , 0 );

add_action( 'after_setup_theme', 'sed_negar_theme_setup' );

function sed_negar_theme_setup() {

    load_child_theme_textdomain( 'negar', get_stylesheet_directory() . '/languages' );

    remove_filter( 'excerpt_more', 'twentyseventeen_excerpt_more' );

    /**
     * Short Description (excerpt).
     */
    add_filter( 'negar_short_description', 'wptexturize' );
    add_filter( 'negar_short_description', 'convert_smilies' );
    add_filter( 'negar_short_description', 'convert_chars' );
    add_filter( 'negar_short_description', 'wpautop' );
    add_filter( 'negar_short_description', 'shortcode_unautop' );
    add_filter( 'negar_short_description', 'prepend_attachment' );
    add_filter( 'negar_short_description', 'do_shortcode', 11 ); // AFTER wpautop()

    // This theme uses wp_nav_menu() in two locations.
    register_nav_menus( array(
        'services'    => __( 'Services Menu', 'twentyseventeen' ),
    ) );

}

function negar_excerpt_more( $link ) {
    if ( is_admin() ) {
        return $link;
    }

    return ' &hellip; ';
}
add_filter( 'excerpt_more', 'negar_excerpt_more' );

function negar_excerpt_length( $length ) {
    return 650;
}

add_filter( 'excerpt_length', 'negar_excerpt_length', 999 );

/**
 * Add Site Editor Modules
 *
 * @param $modules
 * @return mixed
 */
function sed_negar_add_modules( $modules ){

    global $sed_pb_modules;

    $module_name = "themes/tanin/site-editor/modules/posts/posts.php";
    $modules[$module_name] = $sed_pb_modules->get_module_data(get_stylesheet_directory() . '/site-editor/modules/posts/posts.php', true, true);

    //$module_name = "themes/tanin/site-editor/modules/terms/terms.php";
    //$modules[$module_name] = $sed_pb_modules->get_module_data(get_stylesheet_directory() . '/site-editor/modules/terms/terms.php', true, true);

    $module_name = "themes/tanin/site-editor/modules/negar-products/negar-products.php";
    $modules[$module_name] = $sed_pb_modules->get_module_data(get_stylesheet_directory() . '/site-editor/modules/negar-products/negar-products.php', true, true);
    
    $module_name = "themes/tanin/site-editor/modules/in-btn-back/in-btn-back.php";
    $modules[$module_name ] = $sed_pb_modules->get_module_data(get_stylesheet_directory() . '/site-editor/modules/in-btn-back/in-btn-back.php', true, true);
    
    
    //$module_name = "themes/tanin/site-editor/modules/vertical-header/vertical-header.php";
    //$modules[$module_name ] = $sed_pb_modules->get_module_data(get_stylesheet_directory() . '/site-editor/modules/vertical-header/vertical-header.php', true, true);

    
    //$module_name = "themes/tanin/site-editor/modules/subscription/subscription.php";
    //$modules[$module_name ] = $sed_pb_modules->get_module_data(get_stylesheet_directory() . '/site-editor/modules/subscription/subscription.php', true, true);
    
    return $modules;

}

add_filter("sed_modules" , "sed_negar_add_modules" );



function negar_register_theme_fields( $fields ){

    /*$fields['products_archive_description'] = array(
        'type'              => 'textarea',
        'label'             => __('Product Archive Description', 'site-editor'),
        //'description'       => '',
        'transport'         => 'postMessage' ,
        'setting_id'        => 'negar_products_archive_description',
        'default'           => '',
        "panel"             => "general_settings" ,
    );

    $fields['home_page_products_description'] = array(
        'type'              => 'textarea',
        'label'             => __('Home Page Product Description', 'site-editor'),
        //'description'       => '',
        'transport'         => 'postMessage' ,
        'setting_id'        => 'negar_home_page_products_description',
        'default'           => '',
        "panel"             => "general_settings" ,
    );

    $locale = get_locale();

    if( $locale == 'fa_IR' ) {

        $fields['english_site_url'] = array(
            'type' => 'text',
            'label' => __('English Site Url', 'site-editor'),
            //'description'       => '',
            'transport' => 'postMessage',
            'setting_id' => 'negar_english_site_url',
            'default' => 'http://eng.tanin.com',
            "panel" => "general_settings",
        );

    }

    $fields[ 'intro_logo' ] = array(
        'setting_id'        => 'negar_intro_logo',
        'label'             => __('Intro Logo', 'translation_domain'),
        'type'              => 'image',
        //'priority'          => 10,
        'default'           => '',
        'transport'         => 'postMessage' ,
        'panel'             =>  'general_settings'
    );*/

    return $fields;

}

//add_filter( "sed_theme_options_fields_filter" , 'negar_register_theme_fields' , 10000 );


add_action( 'pre_get_posts', 'negar_per_page_query' );
/**
 * Customize category query using pre_get_posts.
 *
 * @author     FAT Media <http://youneedfat.com>
 * @copyright  Copyright (c) 2013, FAT Media, LLC
 * @license    GPL-2.0+
 * @todo       Change prefix to theme or plugin prefix
 *
 */
function negar_per_page_query( $query ) {

    $is_blog = ( is_home() && is_front_page() ) || ( is_home() && !is_front_page() );

    if ( $query->is_main_query() && ! $query->is_feed() && ! is_admin() && ( is_category() || is_tag() || $is_blog )  ) {
        $query->set( 'posts_per_page', '2' ); //Change this number to anything you like.
    }

    /*$taxonomy = is_tax() ? get_queried_object()->taxonomy:"";

    $is_taxonomy = in_array( $taxonomy , array( 'product-category'  ) );

    if ( $query->is_main_query() && ! $query->is_feed() && ! is_admin() && $is_taxonomy  ) {
        $query->set( 'posts_per_page', '6' ); //Change this number to anything you like.
    }*/

    $post_type = $query->get('post_type');

    $is_post_type = in_array( $post_type , array( 'press_media' ) );

    if ( $query->is_main_query() && ! $query->is_feed() && ! is_admin() && $is_post_type && is_post_type_archive() ) {
        $query->set( 'posts_per_page', '2' ); //Change this number to anything you like.
    }

    /*
    $is_post_type = in_array( $post_type , array( 'service' ) );

    if ( $query->is_main_query() && ! $query->is_feed() && ! is_admin() && $is_post_type && is_post_type_archive() ) {
        $query->set( 'posts_per_page', '80' ); //Change this number to anything you like.
    }*/

}


function negar_add_google_font( $google_fonts ){

    $google_fonts["David Libre"] = "David Libre";

    return $google_fonts;

}

//add_filter( 'sed_google_fonts_filter' , 'negar_add_google_font' );

function negar_check_exist_parent_term( $term , $list ){

    if( !$term->parent ){

        return false;

    }

    if( in_array( $term->parent , $list ) ){

        return $term->parent;

    }

    return negar_check_exist_parent_term( get_term( $term->parent ) , $list );

}


add_shortcode( 'negar_header_group_icon', 'negar_add_header_group_icon' );

function negar_add_header_group_icon( $atts = null ){

    ob_start();

   ?>
    <div class="row negar-header-group-icons">

        <div class="col-xs-4">
            <div class="negar-header-icon user">
                <a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>"><?php echo __("My Account" , "negar");?></a>
            </div>
        </div>

        <div class="col-xs-4">
            <div class="negar-header-icon ncart">
               <?php echo do_shortcode( '[sed_woo_cart_icon]' );?>
            </div>

            <div class="negar-header-icon ncart responsive-cart">

                <?php
                global $woocommerce;
                $cart_url = $woocommerce->cart->get_cart_url();
                ?>

                <a class="cart-contents" href="<?php echo esc_attr( esc_url( $cart_url ) );?>" title="View your shopping cart">

                </a>

            </div>

        </div>

        <div class="col-xs-4">
            <div class="negar-header-icon wishlist">
                <a href="<?php echo esc_url( YITH_WCWL()->get_wishlist_url() ); ?>"><?php echo __("Wishlist" , "negar");?></a>
            </div>
        </div>

    </div>
    <?php

    return ob_get_clean();

}


function negar_comment($comment, $args, $depth) {
    $tag = ( 'div' === $args['style'] ) ? 'div' : 'li';
    ?>
    <<?php echo $tag; ?> id="comment-<?php comment_ID(); ?>" <?php comment_class( $args['has_children'] ? 'parent' : '', $comment ); ?>>
    <article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
        <footer class="comment-meta">
            <div class="comment-author vcard">
                <?php if ( 0 != $args['avatar_size'] ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
                <?php
                /* translators: %s: comment author link */
                printf( __( '%s <span class="says">says:</span>' ),
                    sprintf( '<b class="fn">%s</b>', get_comment_author_link( $comment ) )
                );
                ?>
            </div><!-- .comment-author -->

            <div class="comment-metadata">

                <a class="comment-time" href="<?php echo esc_url( get_comment_link( $comment, $args ) ); ?>">
                    <time datetime="<?php comment_time( 'c' ); ?>">
                        <?php
                        /* translators: 1: comment date, 2: comment time */
                        printf( __( '%1$s at %2$s' ), get_comment_date( '', $comment ), get_comment_time() );
                        ?>
                    </time>
                </a>

                <?php
                comment_reply_link( array_merge( $args, array(
                    'add_below' => 'div-comment',
                    'depth'     => $depth,
                    'max_depth' => $args['max_depth'],
                    'before'    => '<div class="reply">',
                    'after'     => '</div>'
                ) ) );
                ?>

                <?php edit_comment_link( __( 'Edit' ), '<span class="edit-link">', '</span>' ); ?>
            </div><!-- .comment-metadata -->

            <?php if ( '0' == $comment->comment_approved ) : ?>
                <p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.' ); ?></p>
            <?php endif; ?>
        </footer><!-- .comment-meta -->

        <div class="comment-content">
            <?php comment_text(); ?>
        </div><!-- .comment-content -->

    </article><!-- .comment-body -->
    <?php
}

/**
 * Get an attachment ID given a URL.
 *
 * @param string $url
 *
 * @return int Attachment ID on success, 0 on failure
 */
function negar_get_attachment_id_by_url( $url ) {
    $attachment_id = 0;
    $dir = wp_upload_dir();
    if ( false !== strpos( $url, $dir['baseurl'] . '/' ) ) { // Is URL in uploads directory?
        $file = basename( $url );
        $query_args = array(
            'post_type'   => 'attachment',
            'post_status' => 'inherit',
            'fields'      => 'ids',
            'meta_query'  => array(
                array(
                    'value'   => $file,
                    'compare' => 'LIKE',
                    'key'     => '_wp_attachment_metadata',
                ),
            )
        );
        $query = new WP_Query( $query_args );
        if ( $query->have_posts() ) {
            foreach ( $query->posts as $post_id ) {
                $meta = wp_get_attachment_metadata( $post_id );
                $original_file       = basename( $meta['file'] );
                $cropped_image_files = wp_list_pluck( $meta['sizes'], 'file' );
                if ( $original_file === $file || in_array( $file, $cropped_image_files ) ) {
                    $attachment_id = $post_id;
                    break;
                }
            }
        }
    }
    return $attachment_id;
}

/**
 * Site Editor Shop WooCommerce
 */
require dirname(__FILE__) . '/inc/woocommerce.php';



