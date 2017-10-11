<?php
/**
 * Simple product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/simple.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;

if ( ! $product->is_purchasable() ) {
	return;
}

echo wc_get_stock_html( $product );

if ( $product->is_in_stock() ) : ?>

	<?php do_action( 'woocommerce_before_add_to_cart_form' ); ?>

	<?php

	$tanin_product_type = get_post_meta( $product->get_id() , 'wpcf-sed-product-tanin-type' , true );

	$tanin_product_type = !$tanin_product_type ? "online" : $tanin_product_type;

	if( in_array( $tanin_product_type , array( 'online' , 'reservation' ) ) ) {
		?>

		<button type="button" name="open-add-to-cart-button" value="<?php echo esc_attr($product->get_id()); ?>"
				class="single_open_add_to_cart_dialog button alt">
			<?php
			//reservation
			//online
			if ($tanin_product_type == "online") {
				echo __("Add To Basket", "tanin");
			} else {
				echo __("Send", "tanin");
			}
			?>
		</button>

		<div id="sed-add-to-cart-dialog" class="add-to-cart-dialog">

			<div class="add-to-cart-dialog-inner">

				<header class="add-to-cart-dialog-header">

					<div class="add-to-cart-dialog-close"></div>
					
				</header>

				<div class="add-to-cart-dialog-content-wrap">

					<?php
					if (!is_user_logged_in()) {

						?>

						<div class="add-to-cart-user-login add-to-cart-dialog-content">

							<?php echo do_shortcode('[sed_woocommerce_login]'); ?>

						</div>

						<?php

					} else if (!tanin_is_user_subscription()) {

						?>

						<div class="add-to-cart-dialog-content">

							<div class="add-to-cart-user_subscription-error">

								<h4><?php echo __('For use our Site Features you need to buy a subscription', 'tanin'); ?></h4>

								<button type="button" class="button"> <a href="<?php echo esc_url( site_url( '/#subscription-wrap-module' ) );?>"> <?php echo __('Register', 'tanin'); ?> </a></button>

							</div>

						</div>

						<?php

					} else {

						$attachment_id   = get_post_thumbnail_id();

						$img = get_sed_attachment_image_html( $attachment_id , "" , "500×500" );

						?>
						<div class="add-to-cart-dialog-content">

							<div class="row">	

								<div class="col-sm-5">
									
							        <div class="thumbnail-wrap">
							        <?php 

							            if ( $img ) {
							                echo $img['thumbnail'];
							            }

							        ?>
							        </div>

								</div>

								<div class="col-sm-7">

									<?php

									the_title( '<h1 class="product_title entry-title">', '</h1>' );

									$second_title = get_post_meta( get_the_ID() , 'wpcf-product-second-title' , true );

									$second_title = trim( $second_title );


									if( !empty( $second_title ) ) {
										?>

										<h4 class="product-second-title"><?php echo $second_title; ?></h4>

										<?php
									}
									
									?>
									
									<div class="add-to-cart-dialog-form-conetnt">
										
									</div>

									<form class="cart tanin-main-form-cart" method="post" enctype='multipart/form-data'>
										<?php
										/**
										 * @since 2.1.0.
										 */
										do_action('woocommerce_before_add_to_cart_button');

										/**
										 * @since 3.0.0.
										 */
										do_action('woocommerce_before_add_to_cart_quantity');

										woocommerce_quantity_input(array(
											'min_value' => apply_filters('woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product),
											'max_value' => apply_filters('woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product),
											'input_value' => isset($_POST['quantity']) ? wc_stock_amount($_POST['quantity']) : $product->get_min_purchase_quantity(),
										));

										/**
										 * @since 3.0.0.
										 */
										do_action('woocommerce_after_add_to_cart_quantity');

										if ($tanin_product_type == "reservation") {

											?>
											<input type="hidden" name="add-to-cart-direct-order" value="yes">
											<?php

										}
										?>

										<button type="submit" name="add-to-cart" value="<?php echo esc_attr($product->get_id()); ?>"
												class="single_add_to_cart_button button alt secondary"><?php echo esc_html__("Confirm" , "tanin"); ?></button>

										<?php
										/**
										 * @since 2.1.0.
										 */
										do_action('woocommerce_after_add_to_cart_button');
										?>
									</form>

								</div>
									
							</div>

						</div>

						<?php

					}
					?>

				</div>

			</div>

		</div>

		<?php

	}else {

		?>

		<form class="cart" method="post" enctype='multipart/form-data'>
			<?php
			/**
			 * @since 2.1.0.
			 */
			do_action('woocommerce_before_add_to_cart_button');

			/**
			 * @since 3.0.0.
			 */
			do_action('woocommerce_before_add_to_cart_quantity');

			woocommerce_quantity_input(array(
				'min_value' => apply_filters('woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product),
				'max_value' => apply_filters('woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product),
				'input_value' => isset($_POST['quantity']) ? wc_stock_amount($_POST['quantity']) : $product->get_min_purchase_quantity(),
			));

			/**
			 * @since 3.0.0.
			 */
			do_action('woocommerce_after_add_to_cart_quantity');
			?>

			<button type="submit" name="add-to-cart" value="<?php echo esc_attr($product->get_id()); ?>"
					class="single_add_to_cart_button button alt"><?php echo esc_html($product->single_add_to_cart_text()); ?></button>

			<?php
			/**
			 * @since 2.1.0.
			 */
			do_action('woocommerce_after_add_to_cart_button');
			?>
		</form>

		<?php
	}
	?>

	<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>

<?php endif; ?>
