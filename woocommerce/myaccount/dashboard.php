<?php
/**
 * My Account Dashboard
 *
 * Shows the first intro screen on the account dashboard.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/dashboard.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @author      WooThemes
 * @package     WooCommerce/Templates
 * @version     2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$current_user = wp_get_current_user();

$user_name = (!empty($current_user->user_firstname) && !empty($current_user->user_lastname)) ? $current_user->user_firstname . " " . $current_user->user_lastname : $current_user->display_name;

$user_name = ( empty( $user_name ) ) ? $current_user->user_login : $user_name;

//var_dump( $current_user );

$customer  = new WC_Customer( $current_user->ID );

//var_dump( $customer );

$gender 	= get_user_meta( $current_user->ID, 'billing_myfield13', true );
$mobile 	= get_user_meta( $current_user->ID, 'billing_myfield12', true );
$birthday 	= get_user_meta( $current_user->ID, 'billing_myfield14', true );

//$subscriber = mailster('subscribers')->get_by_wpid( $current_user->ID );

//$newsletter = $subscriber && $subscriber->status == 1 ? __( "Yes" , "sed-shop" ) : __( "NO" , "sed-shop" );

$current_cc  = WC()->checkout->get_value( 'billing_country' );
$states      = WC()->countries->get_states( $current_cc );

?>

<div class="woocommerce-user-dashboard">
	<div class="woo-box-wrapper">

		<div class="woo-box-heading elements-heading ">

			<span class="woo-box-content">

				<span class="heading-box"><?php _e( "Customer Information" , "sed-shop" );?></span>

				<a class="edit-account" href="<?php echo esc_url( wc_get_endpoint_url( 'edit-address' , 'billing' , wc_get_page_permalink( 'myaccount' ) ) );?>">
					<span><?php _e( "Edit Account Info" , "sed-shop" );?></span>
				</a>

			</span>

		</div>

		<div class="woo-box-heading-elements-content user-info"> 

			<div class="row">

				<div class="col-sm-4">

					<ul>

						<li> <span class="info-label"><?php _e( "Full Name:" , "sed-shop" );?></span> <span class="info-value"><?php echo $customer->get_first_name() . " " . $customer->get_last_name();?></span></li>

						<li> <span class="info-label"><?php _e( "Phone Number:" , "sed-shop" );?></span> <span class="info-value"><?php echo $customer->get_billing_phone();?></span> </li>

						<li> <span class="info-label"><?php _e( "Mobile:" , "sed-shop" );?></span> <span class="info-value"><?php echo esc_html( $mobile );?></span> </li>

					</ul>

				</div>

				<div class="col-sm-4">

					<ul>

						<li> <span class="info-label"><?php _e( "Gender:" , "sed-shop" );?></span> <span class="info-value"><?php echo esc_html( $gender );?></span> </li>

						<li> <span class="info-label"><?php _e( "Email:" , "sed-shop" );?></span> <span class="info-value"><?php echo $customer->get_email();?></span></li>

						<li> <span class="info-label"><?php _e( "User Name:" , "sed-shop" );?></span> <span class="info-value"><?php echo $current_user->user_login;?></span></li>

					</ul>

				</div>

				<div class="col-sm-4">

					<ul>

						<li> <span class="info-label"><?php _e( "Subscription:" , "sed-shop" );?></span> <span class="info-value"><?php //if( tanin_is_user_subscription() ) echo esc_html__( "Yes" , "tanin" ); else echo esc_html__( "No" , "tanin" );?></span> </li>

						<li> <span class="info-label"><?php _e( "Birthday:" , "sed-shop" );?></span> <span class="info-value"><?php echo esc_html( $birthday );?></span> </li>

						<?php
						$address = ( isset( $states[$customer->get_billing_state()] ) ) ? $states[$customer->get_billing_state()] . " - " : "";
						$address .= $customer->get_billing_city ();
						?>

						<li> <span class="info-label"><?php _e( "Address:" , "sed-shop" );?></span> <span class="info-value"><?php echo $customer->get_billing_address();?></span> </li>

					</ul>

				</div>

			</div>

			<div class="user-info-buttons text-right">

				<button class="secondary" type="button"><a class="custom-btn custom-btn-primary" href="<?php echo esc_url( wc_get_endpoint_url( 'edit-address' , 'billing' , wc_get_page_permalink( 'myaccount' ) ) );?>"><?php _e( "Edit Account Info" , "sed-shop" );?></a></button>

				<button class="secondary" type="button"><a class="custom-btn custom-btn-primary" href="<?php echo esc_url( wc_get_endpoint_url( 'edit-account' , '' , wc_get_page_permalink( 'myaccount' ) ) );?>"><?php _e( "Change Password" , "sed-shop" );?></a></button>

			</div>

		</div>

		<?php
			/**
			 * My Account dashboard.
			 *
			 * @since 2.6.0
			 */
			do_action( 'woocommerce_account_dashboard' );

			/**
			 * Deprecated woocommerce_before_my_account action.
			 *
			 * @deprecated 2.6.0
			 */
			do_action( 'woocommerce_before_my_account' );

			/**
			 * Deprecated woocommerce_after_my_account action.
			 *
			 * @deprecated 2.6.0
			 */
			do_action( 'woocommerce_after_my_account' );

		/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
		?>

	</div>
</div>

