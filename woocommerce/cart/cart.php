<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
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
 * @version 3.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

wc_print_notices();

do_action( 'woocommerce_before_cart' ); ?>

<form class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
	<?php do_action( 'woocommerce_before_cart_table' ); ?>

	<table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents" cellspacing="0">

		<tbody>
			<?php do_action( 'woocommerce_before_cart_contents' ); ?>

			<?php

			$cart_items = WC()->cart->get_cart();

			$cart_items_group = array();

			$all_terms = array();

			foreach ( $cart_items as $cart_item_key => $cart_item ) {

				$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

				$terms = get_the_terms( $product_id , 'product_cat' );

				if( !empty( $terms ) ){

					$terms_ids = wp_list_pluck( $terms, 'term_id' );

					$parent_terms = array();

					foreach ( $terms AS $term ){

						$parent_term = tanin_check_exist_parent_term( $term , $terms_ids );

						if( $parent_term ){
							array_push( $parent_terms , $parent_term );
						}

					}

					if( !empty( $parent_terms ) ) {

						$new_terms_ids = array();

						foreach ($terms_ids AS $key => $term_id) {

							if ( !in_array($term_id, $parent_terms) ) {

								array_push($new_terms_ids, $term_id);

							}

						}

					}else{

						$new_terms_ids = $terms_ids;

					}

					foreach ( $new_terms_ids AS $term_id ){

						if( !isset( $cart_items_group["term_".$term_id] ) ){
							$cart_items_group["term_".$term_id] = array();
						}

						$cart_items_group["term_".$term_id][$cart_item_key] = $cart_item;

						$all_terms["term_".$term_id] = get_term( $term_id );

					}

				}


			}

			$num = 1;

			$total = count( $cart_items_group );

			foreach ( $cart_items_group AS $term_id => $new_cart_items ) {

				//if( $total != $num ) {
				$this_term = $all_terms[$term_id];
				?>
				<tr class="table-empty-row">
					<td colspan="6">
						<span class="table-empty-row-heading"><?php echo $this_term->name;?></span>
					</td>
				</tr>
				<tr class="table-thead">
					<th class="product-remove">&nbsp;</th>
					<th class="product-thumbnail">&nbsp;</th>
					<th class="product-name"><?php _e('Product', 'woocommerce'); ?></th>
					<th class="product-price"><?php _e('Price', 'woocommerce'); ?></th>
					<th class="product-quantity"><?php _e('Quantity', 'woocommerce'); ?></th>
					<th class="product-subtotal"><?php _e('Total', 'woocommerce'); ?></th>
				</tr>
				<?php
				//}

				foreach ($new_cart_items as $cart_item_key => $cart_item) {
					$_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
					$product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);

					if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_cart_item_visible', true, $cart_item, $cart_item_key)) {
						$product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);
						?>
						<tr class="woocommerce-cart-form__cart-item <?php echo esc_attr(apply_filters('woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key)); ?>">

							<td class="product-remove">
								<?php
								echo apply_filters('woocommerce_cart_item_remove_link', sprintf(
									'<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
									esc_url(WC()->cart->get_remove_url($cart_item_key)),
									__('Remove this item', 'woocommerce'),
									esc_attr($product_id),
									esc_attr($_product->get_sku())
								), $cart_item_key);
								?>
							</td>

							<td class="product-thumbnail">
								<?php
								$thumbnail = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key);

								if (!$product_permalink) {
									echo $thumbnail;
								} else {
									printf('<a href="%s">%s</a>', esc_url($product_permalink), $thumbnail);
								}
								?>
							</td>

							<td class="product-name" data-title="<?php esc_attr_e('Product', 'woocommerce'); ?>">
								<?php
								if (!$product_permalink) {
									echo apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key) . '&nbsp;';
								} else {
									echo apply_filters('woocommerce_cart_item_name', sprintf('<a href="%s">%s</a>', esc_url($product_permalink), $_product->get_name()), $cart_item, $cart_item_key);
								}

								// Meta data
								echo WC()->cart->get_item_data($cart_item);

								// Backorder notification
								if ($_product->backorders_require_notification() && $_product->is_on_backorder($cart_item['quantity'])) {
									echo '<p class="backorder_notification">' . esc_html__('Available on backorder', 'woocommerce') . '</p>';
								}
								?>
							</td>

							<td class="product-price" data-title="<?php esc_attr_e('Price', 'woocommerce'); ?>">
								<?php
								echo apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key);
								?>
							</td>

							<td class="product-quantity" data-title="<?php esc_attr_e('Quantity', 'woocommerce'); ?>">
								<?php
								if ($_product->is_sold_individually()) {
									$product_quantity = sprintf('1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key);
								} else {
									$product_quantity = woocommerce_quantity_input(array(
										'input_name' => "cart[{$cart_item_key}][qty]",
										'input_value' => $cart_item['quantity'],
										'max_value' => $_product->get_max_purchase_quantity(),
										'min_value' => '0',
									), $_product, false);
								}

								echo apply_filters('woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item);
								?>
							</td>

							<td class="product-subtotal" data-title="<?php esc_attr_e('Total', 'woocommerce'); ?>">
								<?php
								echo apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key);
								?>
							</td>
						</tr>
						<?php
					}
				}

				$num++;
			}
			?>

			<?php do_action( 'woocommerce_cart_contents' ); ?>

			<tr class="table-empty-row">
				<td colspan="6">
					
				</td>
			</tr>

			<tr class="table-coupon-row">
				<td colspan="6" class="actions">

					<?php if ( wc_coupons_enabled() ) { ?>
						<div class="coupon">
							<label for="coupon_code"><?php _e( 'Coupon:', 'woocommerce' ); ?></label> <input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php esc_attr_e( 'Coupon code', 'woocommerce' ); ?>" /> <input type="submit" class="button" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?>" />
							<?php do_action( 'woocommerce_cart_coupon' ); ?>
						</div>
					<?php } ?>

					<input type="submit" class="button" name="update_cart" value="<?php esc_attr_e( 'Update cart', 'woocommerce' ); ?>" />

					<?php do_action( 'woocommerce_cart_actions' ); ?>

					<?php wp_nonce_field( 'woocommerce-cart' ); ?>
				</td>
			</tr>

			<?php do_action( 'woocommerce_after_cart_contents' ); ?>
		</tbody>
	</table>
	<?php do_action( 'woocommerce_after_cart_table' ); ?>
</form>

<div class="cart-collaterals">
	<?php
		/**
		 * woocommerce_cart_collaterals hook.
		 *
		 * @hooked woocommerce_cross_sell_display
		 * @hooked woocommerce_cart_totals - 10
		 */
	 	do_action( 'woocommerce_cart_collaterals' );
	?>
</div>

<?php do_action( 'woocommerce_after_cart' ); ?>
