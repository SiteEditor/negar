<?php
/**
 * Login Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>

<?php wc_print_notices(); ?>

<?php do_action( 'woocommerce_before_customer_login_form' ); ?>

<?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) : ?>

<div class="" id="customer_login">

	<div class="sed-shop-register">

		<header class="heading">

			<h2><?php _e( 'Join Us', 'woocommerce' ); ?></h2>

			<div class="general-separator"> </div>

		</header>

		<form method="post" class="register woo-box-wrapper">

			<?php do_action( 'woocommerce_register_form_start' ); ?>

			<div class="row">

				<div class="col-sm-6">

					<?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>

						<div class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide row sed-shop-register-form-row">

							<div class="col-sm-3">
								<label class="login-form-label" for="reg_username"><?php _e( 'Username:', 'woocommerce' ); ?> <span class="required">*</span></label>
							</div>

							<div class="col-sm-9">
								<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="reg_username" value="<?php if ( ! empty( $_POST['username'] ) ) echo esc_attr( $_POST['username'] ); ?>" />
							</div>

						</div>

					<?php endif; ?>


					<div class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide row sed-shop-register-form-row">

						<div class="col-sm-3">
							<label class="login-form-label" for="reg_email"><?php _e( 'E-mail:', 'woocommerce' ); ?> <span class="required">*</span></label>
						</div>

						<div class="col-sm-9">
							<input type="email" class="woocommerce-Input woocommerce-Input--text input-text" name="email" id="reg_email" value="<?php if ( ! empty( $_POST['email'] ) ) echo esc_attr( $_POST['email'] ); ?>" />
						</div>

					</div>

					<?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>

						<div class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide row sed-shop-register-form-row">

							<div class="col-sm-3">
								<label class="login-form-label" for="reg_password"><?php _e( 'Password:', 'woocommerce' ); ?> <span class="required">*</span></label>
							</div>

							<div class="col-sm-9">
								<input type="password" class="woocommerce-Input woocommerce-Input--text input-text" name="password" id="reg_password" />
							</div>

						</div>

					<?php endif; ?>

				</div>

				<div class="col-sm-6">

					<?php

					if ( wc_get_page_id( 'terms' ) > 0 ) :
						//woocommerce_terms_is_checked_default
						$terms = isset( $_POST['terms'] ) ? $_POST['terms'] : "off";
						?>

						<div class="sed-shop-register-form-row">

							<div class="woocommerce-form-row form-row terms wc-terms-and-conditions row">
								<div class="col-sm-12">
									<label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
										<input type="checkbox" class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" name="terms" value="on" <?php checked( $terms , "on" ); ?> id="terms" /> <span><?php printf( __( 'I&rsquo;ve read and accept the <a href="%s" target="_blank">terms &amp; conditions</a>', 'woocommerce' ), esc_url( wc_get_page_permalink( 'terms' ) ) ); ?></span> <span class="required">*</span>
									</label>
								</div>
							</div>

						</div>

					<?php endif; ?>

					<div class="sed-shop-register-form-row">

						<?php if( function_exists('mailster') ): ?>

							<?php
							$mymail_subscribe = isset( $_POST['mymail_subscribe'] ) ? $_POST['mymail_subscribe'] : "off";
							?>

							<label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
								<input type="checkbox" class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" name="mymail_subscribe" id="mymail_subscribe" value="on" <?php checked( $mymail_subscribe , "on" ); ?> /> <span><?php _e( 'I would like to receive newsletter', 'sed-shop' ) ; ?></span>
							</label>

						<?php endif; ?>

					</div>

				</div>

			</div>

			<div class="sed-shop-register-form-row" >

				<?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>

				<button type="submit" class="custom-btn custom-btn-primary register-button" name="register" value="<?php esc_attr_e( 'Register', 'woocommerce' ); ?>">
					<?php esc_attr_e( 'Register', 'woocommerce' ); ?>
				</button>

			</div>

			<!-- Spam Trap -->
			<div style="<?php echo ( ( is_rtl() ) ? 'right' : 'left' ); ?>: -999em; position: absolute;"><label for="trap"><?php _e( 'Anti-spam', 'woocommerce' ); ?></label><input type="text" name="email_2" id="trap" tabindex="-1" autocomplete="off" /></div>

			<?php do_action( 'woocommerce_register_form' ); ?>


			<?php do_action( 'woocommerce_register_form_end' ); ?>

		</form>

	</div>

<?php endif; ?>

	<div class="sed-shop-login">

		<header class="heading">

			<h2><?php _e( 'Log In', 'woocommerce' ); ?></h2>

			<div class="general-separator"> </div>

		</header>

		<form class="woocomerce-form woocommerce-form-login login woo-box-wrapper" method="post">

			<?php do_action( 'woocommerce_login_form_start' ); ?>

			<div class="u-columns col2-set">

				<div class="u-column1 col-1">
					<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
						<!--<label for="username"><span class="required">*</span></label>-->
						<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" placeholder="<?php _e( 'Username or email address', 'woocommerce' ); ?> " name="username" id="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( $_POST['username'] ) : ''; ?>" />
					</p>
				</div>	

				<div class="u-column2 col-2">
					<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
						<!--<label for="password"> <span class="required">*</span></label>-->
						<input class="woocommerce-Input woocommerce-Input--text input-text" placeholder="<?php _e( 'Password', 'woocommerce' ); ?>" type="password" name="password" id="password" />
					</p>
				</div>	

				<?php do_action( 'woocommerce_login_form' ); ?>

				<div class="u-column1 col-1">
					<p class="form-row">
						<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
						<input type="submit" class="button" name="login" value="<?php esc_attr_e( 'Login', 'woocommerce' ); ?>" />
					</p>
				</div>	

				<div class="u-column2 col-2">
					<p class="woocommerce-LostPassword lost_password text-right">
						<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php _e( 'Lost your password?', 'woocommerce' ); ?></a>
					</p>
				</div>	

				<div class="u-column1 col-1 clear">
					<p class="form-row">
						<label class="woocommerce-form__label woocommerce-form__label-for-checkbox inline">
							<input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" /> <span><?php _e( 'Remember me', 'woocommerce' ); ?></span>
						</label>
					</p>
				</div>	

			</div>

			<?php do_action( 'woocommerce_login_form_end' ); ?>

		</form>

	</div>

<?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) : ?>

</div>

<?php endif; ?>

<?php do_action( 'woocommerce_after_customer_login_form' ); ?>
