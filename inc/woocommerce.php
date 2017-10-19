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

        global $woocommerce_product_options_checkout;

        remove_action( 'woocommerce_add_order_item_meta', array( $woocommerce_product_options_checkout, 'woocommerce_add_order_item_meta' ), 10 );

        add_action( 'woocommerce_new_order_item ' , array( $woocommerce_product_options_checkout, 'woocommerce_add_order_item_meta' ) , 10 , 3 );

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

        $columns = 4;

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

        //add_filter( 'sed_shop_show_login_form_account_page' , array( __CLASS__ , 'show_login_form' ) , 100 , 1 );

        //add_filter( "sed_theme_options_panels_filter" , array( $this , 'register_theme_panels' ) , 100 );

        //add_filter( "sed_theme_options_fields_filter" , array( $this , 'register_theme_fields' ) );

        //add_filter( "woocommerce_process_registration_errors" , array( $this , "validation_error" ) , 100 , 1 );

        add_filter( 'woocommerce_account_menu_items', array( $this , 'account_navigation_tems' ) , 100 , 1 );

        add_filter( 'woocommerce_my_account_edit_address_title', array( $this , 'edit_address_page_title' ) , 100 , 2 );

        add_action( 'woocommerce_add_to_cart', array( $this, 'direct_order' ), 1000, 6 );

        add_action( 'wp_loaded', array( __CLASS__, 'add_to_cart_action' ), 19 );

    }

    public static function add_to_cart_action(){

        if ( empty( $_REQUEST['add-to-cart'] ) || ! is_numeric( $_REQUEST['add-to-cart'] ) ) {
            return;
        }

        if ( empty( $_REQUEST['add-to-cart-direct-order'] ) || $_REQUEST['add-to-cart-direct-order'] != "yes" ) {
            return;
        }

        //Empty Cart before add reservation product to cart
        WC()->cart->empty_cart();

    }

    public function direct_order( $cart_item_key, $product_id, $quantity, $variation_id, $variation, $cart_item_data  ){

        if ( empty( $_REQUEST['add-to-cart'] ) || ! is_numeric( $_REQUEST['add-to-cart'] ) ) {
            return;
        }

        if ( empty( $_REQUEST['add-to-cart-direct-order'] ) || $_REQUEST['add-to-cart-direct-order'] != "yes" ) {
            return;
        }

        if( !is_user_logged_in() ){
            return;
        }

        //var_dump( $cart_item_data );

        //exit();

        $current_user = wp_get_current_user();

        $customer_id  = $current_user->ID;//new WC_Customer( $current_user->ID );

        $address = apply_filters( 'woocommerce_my_account_my_address_formatted_address', array(
            'first_name'  => get_user_meta( $customer_id, 'billing_first_name', true ),
            'last_name'   => get_user_meta( $customer_id, 'billing_last_name', true ),
            'company'     => get_user_meta( $customer_id, 'billing_company', true ),
            'address_1'   => get_user_meta( $customer_id, 'billing_address_1', true ),
            'address_2'   => get_user_meta( $customer_id, 'billing_address_2', true ),
            'city'        => get_user_meta( $customer_id, 'billing_city', true ),
            'state'       => get_user_meta( $customer_id, 'billing_state', true ),
            'postcode'    => get_user_meta( $customer_id, 'billing_postcode', true ),
            'country'     => get_user_meta( $customer_id, 'billing_country', true ),
        ), $customer_id, 'billing' );

        // Now we create the order
        $order = wc_create_order(array(
            'customer_id'   => $customer_id,
        ));


        $item_id = $order->add_product( wc_get_product( $product_id ), $quantity ,
            array(
                'product_id'    => $product_id,
                'variation_id'  => $variation_id,
                'variation'     => $variation,
                'quantity'      => $quantity,
                'data'          => $cart_item_data
            )
            /*array_merge( $cart_item_data , array(
                    'product_id'   => $product_id,
                    'variation_id' => $variation_id,
                    'variation'    => $variation,
                    'quantity'     => $quantity,
                )
            )*/
        );

        //add Item Meta to order
        $this->woocommerce_add_order_item_meta_action( $item_id, $cart_item_data );

        // Set addresses
        $order->set_address( $address, 'billing' );
        //$order->set_address( $address, 'shipping' );

        // Set payment gateway
        $payment_gateways = WC()->payment_gateways->payment_gateways();

        $order->set_payment_method( $payment_gateways['cod'] );

        // Calculate totals
        $order->calculate_totals();

        //$order->update_status( 'pending' , 'Order created dynamically - ', TRUE);

        WC()->cart->empty_cart();

        wp_safe_redirect( $order->get_view_order_url() );

        exit;
        
    }

    /**
     * Adds data to the order
     */
    public function woocommerce_add_order_item_meta_action( $item_id, $cart_item ) {
        if ( !empty( $cart_item[ '_product_options' ] ) ) {
            foreach ( $cart_item[ '_product_options' ] as $product_option_id =>
                      $name_and_value ) {
                $name = $name_and_value[ 'name' ];
                $value = $name_and_value[ 'value' ];
                wc_add_order_item_meta( $item_id, $name, $value );
            }
        }
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

    public static function show_login_form( $show ){

        $show = false;

        return $show;

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

    public function validation_error( $validation_error ){

        if ( $validation_error->get_error_code() ) {

            return $validation_error;

        }

        if( !isset( $_POST['terms'] ) || $_POST['terms'] != "on" ) {

            return new WP_Error( 'signup_terms_error' , __( 'You must accept term of services if you want to join us.' , 'sed-shop' ) );

        }


        return $validation_error;

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

if( class_exists( 'WooCommerce_Product_Options' ) ){

    class TaninProductOptionsGroup extends Woocommerce_Product_Options_Product_Option_Group{


        function print_options( $position ) {
            global $wpdb;
            $sql = "SELECT ID, menu_order FROM {$wpdb->prefix}posts WHERE post_type='product_option_group' AND post_status='publish' ORDER BY menu_order ASC;";
            $results = $wpdb->get_results( $sql );
            global $post;
            $product_post_id = $post->ID;
            if ( !empty( $results ) ) {
                foreach ( $results as $result ) {
                    $product_option_group_id = $result->ID;
                    $meta = get_post_meta( $product_option_group_id, 'group_options', true );
                    $print_options = false;
                    if ( !empty( $meta[ 'any_product' ] ) ) {
                        $print_options = true;
                        $product_group_post_id = $product_option_group_id;
                    } else {
                        if ( !empty( $meta[ 'categories' ] ) ) {
                            $categories = $meta[ 'categories' ];
                            $product_categories = get_the_terms( $product_post_id, 'product_cat' );
                            if ( !empty( $product_categories ) ) {
                                foreach ( $product_categories as $product_category ) {
                                    if ( in_array( $product_category->name, $categories ) ) {
                                        $print_options = true;
                                        $product_group_post_id = $product_option_group_id;
                                        break;
                                    }
                                }
                            }
                        }
                        if ( !$print_options && !empty( $meta[ 'query' ] ) ) {
                            $product_group_post_id = $product_option_group_id;
                            $product_query = new WP_Query( $meta[ 'query' ] );
                            if ( $product_query->have_posts() ) {
                                while ( $product_query->have_posts() ) {
                                    $product_query->the_post();
                                    $test_id = get_the_id();
                                    if ( $test_id === $product_post_id ) {
                                        $print_options = true;
                                        break;
                                    }
                                }
                            }
                            wp_reset_postdata();
                        }
                    }
                    if ( $print_options ) {
                        $settings = get_post_meta( $product_group_post_id, 'product-options-settings', true );
                        $above_add_to_cart = value( $settings, 'above_add_to_cart', '' );
                        $in_variations_add_to_cart = value( $settings, 'in_variations_add_to_cart', '' );
                        if ( ( $position == 'show_in_list' && !empty( $settings[ 'show_in_list' ] ) ) || empty( $position ) || ( $position == value( $settings, 'location_of_options' ) ) || ( $position == 'above_add_to_cart' && !empty( $above_add_to_cart ) ) || ( $position == 'below_add_to_cart' && empty( $above_add_to_cart ) && empty( $in_variations_add_to_cart ) && empty( $settings[ 'location_of_options' ] ) ) || ( $position == 'in_variations_add_to_cart' && !empty( $in_variations_add_to_cart ) ) ) {
                            $options = get_post_meta( $product_group_post_id, 'backend-product-options' );
                            if ( isset( $options[ 0 ] ) && !isset( $options[ 0 ][ 'type' ] ) ) {
                                $options = $options[ 0 ];
                            }
                            print '<div class="product-option-groups">';
                            do_action( "tanin_start_product_option_groups" , $this );
                            $this->_print_options( $options, $product_group_post_id, $product_post_id );
                            print '</div>';
                        }
                    }
                }
            }
        }

        function _print_options( $options, $product_option_post_id, $post_id ) {

            //Add the legend
            $meta = get_post_meta( $product_option_post_id, 'group_options', true );
            $legend = value( $meta, 'legend' );
            //Add the accordion
            $accordion = value( $meta, 'accordion' );
            $accordion_html = '';
            $accordion_title_class = '';
            $accordion_content_class = '';
            if ( !empty( $accordion ) ) {
                $accordion_html = ' <span class="accordion-group-expand">+</span> ';
                $accordion_content_class = 'product-option-accordion-group-content';
                $accordion_title_class = 'accordion-group';
            }
            print '<div class="product-option-group">';
            if ( !empty( $legend ) ) {
                print '<fieldset><legend class="' . $accordion_title_class . '">' . get_the_title( $product_option_post_id ) . $accordion_html . '</legend>';
            } else {
                //print '<h2 class="' . $accordion_title_class . ' product-option-group-title">' . get_the_title( $product_option_post_id ) . $accordion_html . '</h2>';
            }
            print '<div class="' . $accordion_content_class . '">';

            //Add the options
            global $woocommerce_product_options_product_frontend;
            $woocommerce_product_options_product_frontend->_print_options( $options, $product_option_post_id, $post_id );

            if ( !empty( $legend ) ) {
                print '</fieldset>';
            }
            print '</div>';
            print '</div>';
        }

        /*function __construct() {

            global $woocommerce_product_options_product_frontend;

            remove_action( 'woocommerce_single_variation', array( $woocommerce_product_options_product_frontend, 'woocommerce_before_single_variation' ), 15 );
            remove_action( 'woocommerce_single_product_summary', array( $woocommerce_product_options_product_frontend, 'woocommerce_single_product_summary_end' ), 60 );
            remove_action( 'woocommerce_single_product_summary', array( $woocommerce_product_options_product_frontend, 'woocommerce_single_product_summary_before_add_to_cart' ), 25 );
            remove_action( 'woocommerce_before_single_product_summary', array( $woocommerce_product_options_product_frontend, 'move_price_above_add_to_cart' ) );

            add_action( 'woocommerce_single_product_summary', array( $this, 'woocommerce_single_product_summary_end' ), 60 );
            add_action( 'woocommerce_single_product_summary', array( $this, 'woocommerce_single_product_summary_before_add_to_cart' ), 25 );

        }

        /**
         * Displays options after summary
         */ /*
        function woocommerce_single_product_summary_before_add_to_cart() {
            global $post;
            $settings = get_post_meta( $post->ID, 'product-options-settings', true );
            $above_add_to_cart = value( $settings, 'above_add_to_cart', '' );
            if ( !empty( $above_add_to_cart ) || value( $settings, 'location_of_options' ) == 'above_add_to_cart' ) {
                $this->print_options( 'above_add_to_cart' );
            }
            $settings = get_option( 'woocommerce_product_options_settings', array() );
            if ( empty( $settings[ 'position' ] ) ) {
                global $woocommerce_product_options_product_option_group;
                $woocommerce_product_options_product_option_group->print_options( 'above_add_to_cart' );
            }
        }

        /**
         * Displays options after summary
         */ /*
        function woocommerce_single_product_summary_end() {
            global $post;
            $settings = get_post_meta( $post->ID, 'product-options-settings', true );
            $above_add_to_cart = value( $settings, 'above_add_to_cart', '' );
            $in_variations_add_to_cart = value( $settings, 'in_variations_add_to_cart', '' );
            if ( ( empty( $above_add_to_cart ) && empty( $in_variations_add_to_cart ) && empty( $settings[ 'location_of_options' ] ) ) || value( $settings, 'location_of_options' ) == 'below_add_to_cart' ) {
                $this->print_options( 'below_add_to_cart' );
            }
            $settings = get_option( 'woocommerce_product_options_settings', array() );
            if ( empty( $settings[ 'position' ] ) ) {
                global $woocommerce_product_options_product_option_group;
                $woocommerce_product_options_product_option_group->print_options( 'below_add_to_cart' );
            }
        } */

    }

    global $woocommerce_product_options_product_option_group;

    $woocommerce_product_options_product_option_group = new TaninProductOptionsGroup();

}

/*class SedAdminProductAttrsSettings{

    public function __construct(){

        add_action( 'admin_footer', array( $this, 'admin_footer' ) );

        // do_action( 'woocommerce_attribute_added', $wpdb->insert_id, $attribute );
        add_action( 'woocommerce_attribute_added', array( $this, 'woocommerce_attribute_added'), 10, 2 );

        // do_action( 'woocommerce_attribute_updated', $attribute_id, $attribute, $old_attribute_name );
        add_action( 'woocommerce_attribute_updated', array( $this, 'woocommerce_attribute_updated'), 10, 3 );

    }

    /**
     * Get attribute setting
     * @param  int $attribute_id
     * @param  string $key
     * @return mixed
     */ /*
    public static function get_attr_setting($attribute_id, $key = null){

        $settings = get_option("_sed_tanin_attr_settings_{$attribute_id}" );

        if($settings && isset($settings[$key])){
            return $settings[$key];
        }elseif($settings && $key == null){
            return $settings;
        }

        return false;
    }

    public function woocommerce_attribute_added($attribute_id, $attribute){

        $sed_tanin_attribute_type = isset($_POST['sed_tanin_attribute_type']) ? esc_attr( $_POST['sed_tanin_attribute_type'] ) : false;
        $sed_tanin_attribute_always_show= isset($_POST['sed_tanin_attribute_always_show']) ? 'yes' : 'no';

        $attr_settings = array(
            'sed_tanin_attribute_type' => $sed_tanin_attribute_type,
            'sed_tanin_attribute_always_show' => $sed_tanin_attribute_always_show,
        );

        update_option( "_sed_tanin_attr_settings_{$attribute_id}", $attr_settings );
    }

    public function woocommerce_attribute_updated($attribute_id, $attribute, $old_attribute_name){

        $this->woocommerce_attribute_added($attribute_id, $attribute);
    }

    /**
     * Attribute Parent Fields
     */ /*

    public function admin_footer(){

        // temp find page
        $page = isset($_GET['page']) ? $_GET['page'] : false;
        $edit = isset($_GET['edit']) ? $_GET['edit'] : false;
        $taxonomy = isset($_GET['taxonomy']) ? $_GET['taxonomy'] : false;

        if($page !== 'product_attributes' || $taxonomy !== false){
            return;
        }

        if(!$edit) {

            // add screen
            ob_start();
            ?>

            <div class="form-field">
                <h3><?php _e('Advanced Attributes Settings', 'tanin'); ?></h3>
            </div>

            <div class="form-field">
                <label for="sed_tanin_attribute_type"><?php _e( 'Display Type', 'tanin' ); ?></label>
                <select name="sed_tanin_attribute_type" id="sed_tanin_attribute_type">
                    <option value="default"><?php _e( 'Default', 'tanin' ); ?></option>
                    <option value="date"><?php _e( 'Date', 'tanin' ); ?></option>
                    <option value="textarea"><?php _e( 'Textarea', 'tanin' ); ?></option>
                    <option value="text"><?php _e( 'Text', 'tanin' ); ?></option>
                </select>
                <p class="description"><?php _e( 'Type of the attribute output (shown on the front-end variation form).', 'tanin' ); ?></p>
            </div>

            <div class="form-field">
                <label for="sed_tanin_attribute_always_show"><?php _e( 'Display always on the front-end', 'tanin' ); ?></label>
                <select name="sed_tanin_attribute_always_show" id="sed_tanin_attribute_always_show">
                    <option value="no"><?php _e( 'No', 'tanin' ); ?></option>
                    <option value="above_btn"><?php _e( 'Yes', 'tanin' ); ?></option>
                </select>
                <p class="description"><?php _e( 'Display this attribute always on the single product page.', 'tanin' ); ?></p>
            </div>

            <?php
            $contents = ob_get_clean();
            $contents = preg_replace( "/\r|\n/", "", $contents );
            $contents = preg_replace( "/'/", "\'", $contents );
            ?>
            <script type="text/javascript">
                jQuery(function($){
                    // insert at bottom of form
                    $('.form-wrap .form-field:last').after('<?php echo $contents; ?>');
                });
            </script>
            <?php
        }else{

            $sed_attribute_type = self::get_attr_setting($edit, 'sed_tanin_attribute_type');
            $sed_attribute_always_show = self::get_attr_setting($edit, 'sed_tanin_attribute_always_show');

            // edit screen
            ob_start();
            ?>

            <tr>
                <td colspan="2"><h3><?php _e( 'Advanced Attributes Settings', 'jcaa' ); ?></h3></td>
            </tr>

            <tr class="form-field form-required"">

                <th scope="row" valign="top">
                    <label for="sed_tanin_attribute_type"><?php _e( 'Display Type', 'tanin' ); ?></label>
                </th>

                <td>
                    <select name="sed_tanin_attribute_type" id="sed_tanin_attribute_type">
                        <option value="default" <?php selected( 'default', $sed_attribute_type, true ); ?>><?php _e( 'Default', 'tanin' ); ?></option>
                        <option value="date" <?php selected( 'date', $sed_attribute_type, true ); ?>><?php _e( 'Date', 'tanin' ); ?></option>
                        <option value="textarea" <?php selected( 'textarea', $sed_attribute_type, true ); ?>><?php _e( 'Textarea', 'tanin' ); ?></option>
                        <option value="text" <?php selected( 'text', $sed_attribute_type, true ); ?>><?php _e( 'Text', 'tanin' ); ?></option>
                    </select>
                    <p class="description"><?php _e( 'Type of the attribute output (shown on the front-end variation form).', 'tanin' ); ?></p>
                </td>

            </tr>

            <tr class="form-field form-required"">

                <th scope="row" valign="top">
                    <label for="sed_tanin_attribute_always_show"><?php _e( 'Display always on the front-end', 'tanin' ); ?></label>
                </th>

                <td>
                    <select name="sed_tanin_attribute_always_show" id="sed_tanin_attribute_always_show">
                        <option value="no" <?php selected( 'no', $sed_attribute_always_show, true ); ?>><?php _e( 'No', 'tanin' ); ?></option>
                        <option value="yes" <?php selected( 'yes', $sed_attribute_always_show, true ); ?>><?php _e( 'Yes', 'tanin' ); ?></option>
                    </select>
                    <p class="description"><?php _e( 'Display this attribute always on the single product page.', 'tanin' ); ?></p>
                </td>

            </tr>


            <?php
            $contents = ob_get_clean();
            $contents = preg_replace( "/\r|\n/", "", $contents );
            $contents = preg_replace( "/'/", "\'", $contents );
            ?>

            <script type="text/javascript">
                jQuery(function($){
                    // insert at bottom of form
                    $('.form-table tr:last').after('<?php echo $contents; ?>');
                });
            </script>
            <?php

        }

    }

}

function tanin_woo_get_attr_setting($attribute_id, $key = null){

    return SedAdminProductAttrsSettings::get_attr_setting( $attribute_id , $key );

}

new SedAdminProductAttrsSettings(); */
