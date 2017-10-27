<?php
/**
 * SiteEditor Shop WooCommerce class
 *
 * @package SiteEditor
 * @subpackage theme
 * @since 1.0.0
 */

/**
 * SiteEditor Shop WooCommerce class.
 *
 * SiteEditor Shop WooCommerce is for sync with WooCommerce Plugin & their Extensions
 *
 * @since 1.0.0
 */

class SedShopWooCommerce{

    /**
     * @since 1.0.0
     * @var array
     * @access protected
     */
    //protected $theme_options = array();

    /**
     * SedShopWooCommerce constructor.
     */
    public function __construct(  ) { 

        $this->remove_breadcrumb();

        add_filter( 'woocommerce_variable_free_price_html', array( __CLASS__ , 'hide_free_price_notice' ) );

        add_filter( 'woocommerce_free_price_html', array( __CLASS__ , 'hide_free_price_notice' ) );

        add_filter( 'woocommerce_variation_free_price_html', array( __CLASS__ , 'hide_free_price_notice' ) );

    }

    public static function hide_free_price_notice(){

        return "Free";

    }

    public function remove_breadcrumb(){

        remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );

    }


}

new SedShopWooCommerce();

/**
 * Woocommerce Single Product Module class.
 *
 * Add Options
 *
 * @since 1.0.0
 */

class SedShopWoocommerceSingleProductModule{

    /**
     * SedShopWoocommerceSingleProduct constructor.
     */
    public function __construct(){

        $this->remove_default_hooks();

        $this->add_heading_part();

        $this->add_summary_part();

        $this->add_price_part();

        $this->remove_details_products();

        add_filter( "woocommerce_product_thumbnails_columns" , array( __CLASS__ , "get_thumbnails_columns" ) );

        add_filter( "woocommerce_format_sale_price" , array( __CLASS__ , "format_sale_price" ) , 100 , 3 );

        add_filter( "woocommerce_variable_price_html" , array( __CLASS__ , "variable_price_html" ) , 100 , 2 );

        add_filter( "woocommerce_get_price_html" , array( __CLASS__ , "get_price_html" ) , 100 , 2 );

        add_filter( "woocommerce_product_single_add_to_cart_text" , array( __CLASS__ , "add_to_cart_text" ) , 100 , 1 );

        add_filter( "woocommerce_output_related_products_args" , array( __CLASS__ , "related_products_args" ) , 100 , 1 );

        add_action( "wp" , array( __CLASS__ , "remove_related_prouducts_gift_cards_wrapping" ) , 100 );

    }

    public static function related_products_args( $args ){

        $args['posts_per_page'] = 12;

        return $args;

    }

    public static function add_to_cart_text( $text ){

        $text = __( 'Add to bag', 'woocommerce' );

        return $text;

    }

    /**
     * Remove WooCommerce Default Hooks
     */
    public function remove_default_hooks(){

        //remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
        remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
        //remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
        //remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
        remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
        remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );
        //remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );

    }

    public function add_heading_part(){

        add_action( 'woocommerce_single_product_summary', array( __CLASS__ , 'start_heading' ), 4 );

        add_action( 'woocommerce_single_product_summary', array( __CLASS__ , 'sub_title' ), 7 );

        add_action( 'woocommerce_single_product_summary', array( __CLASS__ , 'end_heading' ), 11 );

        add_action( 'woocommerce_single_product_summary', array( __CLASS__ , 'add_wishlist' ), 10 );

        //add_action( 'sed_shop_single_product_heading_right', 'woocommerce_template_single_rating', 10 );

    }

    public static function product_content(){

        global $post;

        if ( $post->post_content ) {

            woocommerce_product_description_tab(  );

        }

    }

    public static function add_wishlist(  ){

        echo do_shortcode( '[yith_wcwl_add_to_wishlist icon="fa fa-heart"]' );

    }

    public static function start_heading(){
        ?>
            <div class="hide"><?php the_content();?></div>
            <div class="product-heading-wrap">
        <?php
    }

    public static function sub_title(){

        $second_title = get_post_meta( get_the_ID() , 'wpcf-product-second-title' , true );

        $second_title = trim( $second_title );

        if( !empty( $second_title ) ) {
            ?>

            <h4 class="product-second-title"><?php echo $second_title; ?></h4>

            <?php
        }

    }

    public static function end_heading(){
        ?>
            </div>
        <?php
    }

    public static function format_sale_price( $price, $regular_price, $sale_price ){

        $price  = '<div class="product-main-price">';

        $price .= '<ins>' . ( is_numeric( $sale_price ) ? wc_price( $sale_price ) : $sale_price ) . '</ins> <del>' . ( is_numeric( $regular_price ) ? wc_price( $regular_price ) : $regular_price ) . '</del>';

        $price .= '</div>';

        return $price;

    }

    public static function get_price_html( $price , $obj ){

        if ( $obj->is_on_sale() && "variable" != $obj->get_type() ) {

            $regular_price = wc_get_price_to_display( $obj, array( 'price' => $obj->get_regular_price() ) );

            $sale_price = wc_get_price_to_display( $obj );

            $price .= self::sale_discount_price( $regular_price , $sale_price );

        }


        if( !$obj->get_regular_price() ) {
            $price = '<span class="woocs_price_code free-product" data-product-id="392">' . __("Free Packaging", "negar") . '</span>';
        }

        return $price;

    }

    public static function variable_price_html( $price , $obj ){

        $prices = $obj->get_variation_prices( true );

        $min_price     = current( $prices['price'] );
        $min_reg_price = current( $prices['regular_price'] );
        $max_reg_price = end( $prices['regular_price'] );

        if ( $obj->is_on_sale() && $min_reg_price === $max_reg_price ) {

            $regular_price = $max_reg_price;

            $sale_price = $min_price;

            $price .= self::sale_discount_price( $regular_price , $sale_price );

        }

        return $price;

    }

    public static function sale_discount_price( $from , $to ){

        $discount = '';

        if( is_singular( 'product' ) ){

            $discount .= '<div class="product-discount-price">';

            $discount .= round( ( ($from - $to)/$from ) * 100 ) . "% OFF" ;

            $discount .= '</div>';

        }

        return $discount;

    }

    public function add_summary_part(){

        //add_action( 'woocommerce_after_single_product_summary', 'woocommerce_template_single_excerpt' , 4 );

    }

    public function add_price_part(){

        //add_action( 'sed_shop_single_product_price', 'woocommerce_template_single_price' , 10 );

        //add_action( 'sed_shop_single_product_price', 'woocommerce_template_single_add_to_cart' , 15 );

    }

    public static function get_thumbnails_columns( $columns ){

        return 4;

    }

    public function remove_details_products(){

        //remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

        remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );

        remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );

        add_action( 'woocommerce_after_single_product_summary', array( __CLASS__ , 'product_content' ), 10 );

    }

    public static function remove_related_prouducts_gift_cards_wrapping(){

        $queried_object = get_queried_object();

        if( is_singular('product') ){

            $terms = wp_get_post_terms( $queried_object->ID, 'product_cat' , array( "fields" => "slugs" ) );

            if( in_array( 'gift-cards' , $terms ) || in_array( 'occesions' , $terms )  ) {

                remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);

            }

        }

    }

}

new SedShopWoocommerceSingleProductModule();

/**
 * Woocommerce Single Product Module class.
 *
 * Add Options
 *
 * @since 1.0.0
 */

class SedShopWoocommerceArchiveModule{

    /**
     * SedShopWoocommerceSingleProduct constructor.
     */
    public function __construct(){

        add_filter( 'loop_shop_per_page'                , array( __CLASS__ , 'loop_shop_per_page' ) , 9999 );

        add_filter( 'loop_shop_columns'                 , array( __CLASS__ , 'loop_columns' ) , 9999 );

        add_filter( 'woocommerce_show_page_title'       , array( __CLASS__ , 'remove_page_title' ) , 9999  );

        remove_action( 'woocommerce_before_shop_loop' , 'woocommerce_result_count' , 20 );

        remove_action( 'woocommerce_before_shop_loop' , 'woocommerce_catalog_ordering' , 30 );

        //add_filter( 'sed_shop_before_shop_loop'         , 'woocommerce_pagination' , 10  );

        $this->set_content_product();

    }


    public static function loop_shop_per_page( $per_page ) {

        $per_page = 12;

        return $per_page;
    }

    public static function loop_columns( $columns ) {

        if( is_product_category('gift-cards') ) {

            $columns = 3;

        }else{

            $columns = 4;

        }

        return $columns;
    }

    public static function remove_page_title( $show_title ){

        $show_title = !$show_title ? $show_title : false;

        return $show_title;

    }

    public function set_content_product(){ //

        remove_action( 'woocommerce_after_shop_loop_item_title' , 'woocommerce_template_loop_rating' , 5 );

        //remove_action( 'woocommerce_after_shop_loop_item_title' , 'woocommerce_template_loop_price' , 10 );

        //remove_action( 'woocommerce_after_shop_loop_item' , 'woocommerce_template_loop_add_to_cart' , 10 );

        //add_action( 'woocommerce_after_shop_loop_item' , array( __CLASS__ , 'add_more_detail' ) , 10 );

        add_action( 'woocommerce_before_shop_loop_item_title' , array( __CLASS__ , 'start_before_item_title' ) , 0  );

        add_action( 'woocommerce_before_shop_loop_item_title' , array( __CLASS__ , 'add_wishlist' ) , 20  );

        add_action( 'woocommerce_before_shop_loop_item_title' , array( __CLASS__ , 'end_before_item_title' ) , 100  );

        remove_action( 'woocommerce_before_shop_loop_item' , 'woocommerce_template_loop_product_link_open' , 10 );

        add_action( 'woocommerce_shop_loop_item_title' , 'woocommerce_template_loop_product_link_open' , 0 );

        add_action( 'woocommerce_shop_loop_item_title' , array( __CLASS__ , 'add_product_sub_title' ) , 15 );

        add_action( 'woocommerce_after_subcategory' , array( __CLASS__ , 'enter_to_product' ) , 20 , 1 );

        add_action( 'woocommerce_after_subcategory_title' , array( __CLASS__ , 'add_cat_sub_title' ) , 10 , 1 );

        add_filter( 'woocommerce_product_add_to_cart_text' , array( __CLASS__ , 'simple_product_add_to_cart_text' ) , 100 , 2 );

    }

    public static function simple_product_add_to_cart_text( $text , $product ){

        if( $product->get_type() == "simple" ) {

            $text = $product->is_purchasable() && $product->is_in_stock() ? __('Shop', 'woocommerce') : __('Read more', 'woocommerce');
        }

        return $text;

    }

    public static function add_wishlist(){

        echo do_shortcode( '[yith_wcwl_add_to_wishlist icon="fa fa-heart"]' );

    }

    public static function add_product_sub_title(){

        $second_title = get_post_meta( get_the_ID() , 'wpcf-product-second-title' , true );
        ?>

        <span class="product-second-title"><?php echo $second_title; ?></span>

        <?php

    }

    public static function start_before_item_title(){

        ?>
        <div class="negar-product-archive-thumbnail">
        <?php

    }

    public static function end_before_item_title(){

        ?>
        </div>
        <?php

    }

    public static function add_more_detail(){

        ?>

        <a rel="nofollow" href="<?php echo get_permalink();?>" class="button tanin-more-details-button">
            <?php echo __("More Details" , "tanin" );?>
        </a>

        <?php

    }

    public static function enter_to_product( $category ){

        $term_link = get_term_link( $category );

        // If there was an error, continue to the next term.
        if ( is_wp_error( $term_link ) ) {
            $term_link = "#";
        }
        ?>

        <a rel="nofollow" href="<?php echo esc_attr( esc_url( $term_link ) );?>" class="button tanin-more-details-button">
            <?php echo __("Enter" , "tanin" );?>
        </a>

        <?php

    }

    public static function add_cat_sub_title( $category ){

        $second_title = get_term_meta( $category->term_id , 'wpcf-product-cat-second-title' , true );

        ?>

        <span class="product-cat-second-title"><?php echo $second_title; ?></span>

        <?php

    }

}

new SedShopWoocommerceArchiveModule();

/**
 * Woocommerce My Account Module class.
 *
 * Add Options
 *
 * @since 1.0.0
 */
class sedShopWoocommerceMyAccountModule{

    /**
     * sedShopWoocommerceMyAccountModule constructor.
     */
    function __construct(){

        //remove_action( 'woocommerce_account_navigation', 'woocommerce_account_navigation' );

        //add_filter( "sed_theme_options_panels_filter" , array( $this , 'register_theme_panels' ) , 100 );

        //add_filter( "sed_theme_options_fields_filter" , array( $this , 'register_theme_fields' ) );

        add_filter( 'woocommerce_account_menu_items', array( $this , 'account_navigation_tems' ) , 100 , 1 );

        add_filter( 'woocommerce_my_account_edit_address_title', array( $this , 'edit_address_page_title' ) , 100 , 2 );

    }

    public function edit_address_page_title( $page_title, $load_address ){

        if( $load_address == "billing" ){
            $page_title = __('Edit Account Info', 'tanin');
        }

        return $page_title;

    }

    public function account_navigation_tems( $items ){

        unset( $items['downloads'] );

        $items['edit-account'] = __("Change Password" , "tanin");

        $items['edit-address'] = __( 'Edit Account Info', 'tanin' );

        return $items;

    }

    public function register_theme_panels( $panels ){

        $panels['woocommerce_settings'] =  array(
            'type'                  => 'inner_box',
            'title'                 => __('Woocommerce Settings', 'site-editor'),
            'capability'            => 'edit_theme_options' ,
            'priority'              => 50 ,
            'btn_style'             => 'menu' ,
            'has_border_box'        => false ,
            'icon'                  => 'sedico-current-post-customize' ,
            'field_spacing'         => 'sm'
        );

        return $panels;

    }

    /**
     * Register Theme Fields
     */
    public function register_theme_fields( $fields ){

        $fields['woocommerce_user_register_messages'] = array(
            'setting_id'        => 'sed_woocommerce_user_register_messages',
            'label'             => __('User Register Messages', 'site-editor'),
            'description'       => __( 'Show guide Message for users in register form.' , 'site-editor' ),
            'type'              => 'wp-editor',
            'default'           => '',
            'option_type'       => 'theme_mod',
            'transport'         => 'postMessage' ,
            'panel'             => 'woocommerce_settings',
        );

        return $fields;

    }


}

new sedShopWoocommerceMyAccountModule();

/**
 * Woocommerce New Shortcodes
 *
 * Add New Shortcodes For WooCommerce
 *
 * @since 1.0.0
 */

class SedShopWoocommerceShortcodes{

    /**
     * SedShopWoocommerceShortcodes constructor.
     */
    public function __construct(){

        add_shortcode( 'sed_woocommerce_login', array( __CLASS__ , 'login' ) );

        add_shortcode( 'sed_woo_cart_icon', array( __CLASS__ , 'cart_icon' ) );

        add_shortcode( 'sed_woo_user_profile', array( __CLASS__ , 'user_profile' ) );
        
    }

    public static function cart_icon(){

        ob_start();
        ?>

        <div class="navigation-wrapper woocommerce-mini-cart-wrapper module module-menu module-menu-skin-defult">
            <div class="navigation-wrapper-inner">

                <div class="navbar-toggle-wrap">
                    <div class="navbar-toggle">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span> 
                        <span class="icon-bar"></span> 
                    </div>
                    <span class="navbar-header-title">Menu</span>
                </div>   

                <div class="navbar-wrap">
                    <nav class="navbar-wrap-inner">
                        <div class="menu-cart-container">
                            <ul id="menu-cart" class="menu">

                            <li class="menu-item menu-item-has-children">         

                                <?php
                                $count = WC()->cart->cart_contents_count;
                                ?>
                                <a class="cart-contents" href="<?php echo WC()->cart->get_cart_url(); ?>" title="<?php _e( 'View your shopping cart' ); ?>">
                                    <?php
                                    if ( $count > 0 ) {
                                        ?>
                                        <span class="cart-contents-count"><?php echo esc_html( $count ); ?></span>
                                        <?php
                                    }
                                    ?>
                                    <!--<span class="fa fa-shopping-cart menu-item-icon"></span>-->
                                </a>

                                <ul class="sub-menu">
                                    <li class="menu-item"> <?php echo woocommerce_mini_cart();?>

                                        <!--<div class="shopping_cart_in_menu">
                                            <div class="hide_cart_widget_if_empty">
                                                <div class="widget_shopping_cart_content">

                                                </div>
                                            </div>
                                        </div>-->

                                    </li>
                                </ul>
                            </li>

                            </ul>
                        </div>         
                    </nav>
                </div>

            </div>
        </div>

        <?php
        $content = ob_get_clean();

        return $content;

    }

    /**
     * Ensure cart contents update when products are added to the cart via AJAX
     *
    function my_header_add_to_cart_fragment( $fragments ) {

        ob_start();
        $count = WC()->cart->cart_contents_count;
        ?><a class="cart-contents" href="<?php echo WC()->cart->get_cart_url(); ?>" title="<?php _e( 'View your shopping cart' ); ?>"><?php
        if ( $count > 0 ) {
            ?>
            <span class="cart-contents-count"><?php echo esc_html( $count ); ?></span>
            <?php
        }
        ?></a><?php

        $fragments['a.cart-contents'] = ob_get_clean();

        return $fragments;
    }
add_filter( 'woocommerce_add_to_cart_fragments', 'my_header_add_to_cart_fragment' );
     */

    public static function login( $atts ) {

        $defaults = array(
            'message'  => '',
            'redirect' => wc_get_page_permalink( 'myaccount' ),
            'hidden'   => false,
        );

        $atts = shortcode_atts( $defaults , $atts );

        ob_start();

        wc_print_notices();

        woocommerce_login_form( $atts );

        return ob_get_clean();

    }

    public static function user_profile( $atts ) {

        $current_user = wp_get_current_user();

        $user_name = (!empty($current_user->user_firstname) && !empty($current_user->user_lastname)) ? $current_user->user_firstname . " " . $current_user->user_lastname : $current_user->display_name;

        $user_name = ( empty( $user_name ) ) ? $current_user->user_login : $user_name;

        ob_start();

        ?>
        <div class="user_profile_info_module">

            <ul>

                <li>

                    <a class="title">
                        <h3><?php echo $user_name;?></h3>
                    </a>

                </li>

                <li>
                    <a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) );?>"><?php echo __("My Profile" , "sed-shop");?></a>
                </li>

                <li>
                    <a href="<?php echo esc_url( wc_get_endpoint_url( 'edit-account' , '' , wc_get_page_permalink( 'myaccount' ) ) );?>"><?php echo __("Change Password" , "sed-shop");?></a>
                </li>

                <li>
                    <a href="<?php echo esc_url( wc_logout_url( wc_get_page_permalink( 'myaccount' ) ) );?>"><?php echo __( 'Logout', 'woocommerce' );?></a>
                </li>

            </ul>

        </div>

        <?php

        return ob_get_clean();

    }

}

new SedShopWoocommerceShortcodes();