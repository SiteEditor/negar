<?php
/**
 * Orders
 *
 * Shows orders on the account page.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/orders.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'woocommerce_before_account_orders', $has_orders ); ?>

<?php if ( $has_orders ) : ?>

	<div class="sed-shop-cart-table-header">

		<span> <?php echo __( 'Orders History', 'woocommerce' );?> </span>

	</div>

	<table class="woocommerce-orders-table woocommerce-MyAccount-orders shop_table shop_table_responsive my_account_orders account-orders-table">

		<thead>
			<tr>
				<!--<th class="woocommerce-orders-table__header woocommerce-orders-table__header-0"><span class="nobr"><?php //echo __( 'NO.', 'woocommerce' ); ?></span></th> -->
				<?php foreach ( wc_get_account_orders_columns() as $column_id => $column_name ) : ?>
					<th class="woocommerce-orders-table__header woocommerce-orders-table__header-<?php echo esc_attr( $column_id ); ?>"><span class="nobr"><?php echo esc_html( $column_name ); ?></span></th>
				<?php endforeach; ?>
			</tr>
		</thead>

		<tbody>
			<?php

			$num = 1;
			$total_orders_num = count( $customer_orders->orders );
			foreach ( $customer_orders->orders as $customer_order ) :
				$order      = wc_get_order( $customer_order );
				$item_count = $order->get_item_count();
				$order_status = wc_get_order_status_name( $order->get_status() );
				?>
				<tr class="woocommerce-orders-table__row woocommerce-orders-table__row--status-<?php echo esc_attr( $order->get_status() ); ?> order <?php if($num == $total_orders_num) echo 'last-order-item';?>">
					<?php foreach ( wc_get_account_orders_columns() as $column_id => $column_name ) : ?>
						<td class="woocommerce-orders-table__cell woocommerce-orders-table__cell-<?php echo esc_attr( $column_id ); ?>" data-title="<?php echo esc_attr( $column_name ); ?>">
							<?php if ( has_action( 'woocommerce_my_account_my_orders_column_' . $column_id ) ) : ?>
								<?php do_action( 'woocommerce_my_account_my_orders_column_' . $column_id, $order ); ?>

							<?php elseif ( 'order-number' === $column_id ) : ?>
								<a href="<?php echo esc_url( $order->get_view_order_url() ); ?>">
									<?php echo _x( '#', 'hash before order number', 'woocommerce' ) . $order->get_order_number(); ?>
								</a>

							<?php elseif ( 'order-date' === $column_id ) : ?>
								<time datetime="<?php echo esc_attr( $order->get_date_created()->date( 'c' ) ); ?>"><?php echo esc_html( wc_format_datetime( $order->get_date_created() ) ); ?></time>

							<?php elseif ( 'order-status' === $column_id ) : ?>
								<?php echo esc_html( $order_status ); ?>

							<?php elseif ( 'order-total' === $column_id ) : ?>
								<?php
								/* translators: 1: formatted order total 2: total order items */
								printf( _n( '%1$s for %2$s item', '%1$s for %2$s items', $item_count, 'woocommerce' ), $order->get_formatted_order_total(), $item_count );
								?>

							<?php elseif ( 'order-actions' === $column_id ) : ?>

								<a href="#" class="woocommerce-button button view-details"><?php echo __( 'View', 'woocommerce' );?></a>

							<?php endif; ?>
						</td>
					<?php endforeach; ?>
				</tr>

				<tr class="woocommerce-orders-table__row order-explain">

					<td colspan="5">

						<div class="row bs-wizard" style="border-bottom:0;">

							<div class="col-xs-3 bs-wizard-step <?php if( in_array( $order->get_status() , array( "processing" , "shipping" , "completed" , "confirm-order" ) ) ) echo "complete";?>">
								<div class="text-center bs-wizard-stepnum"> <?php echo __( 'Confirm Order', 'woocommerce' );?> </div>
								<div class="progress"><div class="progress-bar"></div></div>
								<a href="#" class="bs-wizard-dot step1"></a>
								<!--<div class="bs-wizard-info text-center">Lorem ipsum</div>-->
							</div>

							<div class="col-xs-3 bs-wizard-step <?php if( in_array( $order->get_status() , array( "processing" , "shipping" , "completed" ) ) ) echo "complete";?>"><!-- complete -->
								<div class="text-center bs-wizard-stepnum"> <?php echo __( 'Processing', 'woocommerce' );?> </div>
								<div class="progress"><div class="progress-bar"></div></div>
								<a href="#" class="bs-wizard-dot step2"></a>
								<!--<div class="bs-wizard-info text-center">Nam mollis</div>-->
							</div>

							<div class="col-xs-3 bs-wizard-step <?php if( in_array( $order->get_status() , array( "shipping" , "completed" ) ) ) echo "complete";?>"><!-- complete -->
								<div class="text-center bs-wizard-stepnum"> <?php echo __( 'Shipping', 'woocommerce' );?> </div>
								<div class="progress"><div class="progress-bar"></div></div>
								<a href="#" class="bs-wizard-dot step3"></a>
								<!--<div class="bs-wizard-info text-center">Integer semper</div>-->
							</div>

							<div class="col-xs-3 bs-wizard-step <?php if( $order->get_status() == "completed" ) echo "complete";?>"><!-- active -->
								<div class="text-center bs-wizard-stepnum"> <?php echo __( 'Delivered', 'woocommerce' );?> </div>
								<div class="progress"><div class="progress-bar"></div></div>
								<a href="#" class="bs-wizard-dot step4"></a>
								<!--<div class="bs-wizard-info text-center"> Curabitur mollis</div>-->
							</div>

						</div>

						<div class="products-information">

							<?php
							foreach ( $order->get_items() as $item_id => $item ) {

								$product = apply_filters('woocommerce_order_item_product', $item->get_product(), $item);

								$purchase_note = $product ? $product->get_purchase_note() : '';

								$is_visible = $product && $product->is_visible();
								$product_permalink = apply_filters('woocommerce_order_item_permalink', $is_visible ? $product->get_permalink($item) : '', $item, $order);

								?>

								<div class="product-info">

									<div class="product-thumbnail">
										<?php
										$thumbnail = $product ? $product->get_image() : sprintf( '<img src="%s">', esc_url( sed_placeholder_img_src() ) );

										if ( ! $product_permalink ) {
											echo $thumbnail;
										} else {
											printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail );
										}
										?>
									</div>

									<div class="product-name">

										<div class="product-name-part">
											<?php

											echo apply_filters('woocommerce_order_item_name', $product_permalink ? sprintf('<a class="product-title" href="%s">%s</a>', $product_permalink, $item->get_name()) : $item->get_name(), $item, $is_visible);
											echo apply_filters('woocommerce_order_item_quantity_html', ' <div class="product-quantity">' . __( 'Number:', 'woocommerce' ) . '&nbsp;' . $item->get_quantity() . '</div>', $item);

											?>
											<div class="product-total-part">
												<?php echo __( 'Price:', 'woocommerce' ) . '&nbsp;' . $order->get_formatted_line_subtotal($item); ?>
											</div>
											<div class="product-meta-part">
											<?php

											do_action('woocommerce_order_item_meta_start', $item_id, $item, $order);

											wc_display_item_meta($item);
											wc_display_item_downloads($item);

											do_action('woocommerce_order_item_meta_end', $item_id, $item, $order);

											?>
											</div>
										</div>

									</div>

								</div>

								<?php

							}
							?>

						</div>

						<div class="order-actions">
							<?php
							$actions = array(
								'pay'    => array(
									'url'  => $order->get_checkout_payment_url(),
									'name' => __( 'Pay', 'woocommerce' ),
								),
								'view'   => array(
									'url'  => $order->get_view_order_url(),
									'name' => __( 'View Details', 'woocommerce' ),
								),
								'cancel' => array(
									'url'  => $order->get_cancel_order_url( wc_get_page_permalink( 'myaccount' ) ),
									'name' => __( 'Cancel', 'woocommerce' ),
								),
							);

							if ( ! $order->needs_payment() ) {
								unset( $actions['pay'] );
							}

							if ( ! in_array( $order->get_status(), apply_filters( 'woocommerce_valid_order_statuses_for_cancel', array( 'pending', 'failed' ), $order ) ) ) {
								unset( $actions['cancel'] );
							}

							if ( $actions = apply_filters( 'woocommerce_my_account_my_orders_actions', $actions, $order ) ) {
								foreach ( $actions as $key => $action ) {
									echo '<a href="' . esc_url( $action['url'] ) . '" class="woocommerce-button button ' . sanitize_html_class( $key ) . '">' . esc_html( $action['name'] ) . '</a>';
								}
							}
							?>
						</div>

					</td>

				</tr>

			<?php
			$num++;
			endforeach; ?>
		</tbody>
	</table>

	<?php do_action( 'woocommerce_before_account_orders_pagination' ); ?>

	<?php if ( 1 < $customer_orders->max_num_pages ) : ?>
		<div class="woocommerce-pagination woocommerce-pagination--without-numbers woocommerce-Pagination">
			<?php if ( 1 !== $current_page ) : ?>
				<a class="woocommerce-button woocommerce-button--previous woocommerce-Button woocommerce-Button--previous button" href="<?php echo esc_url( wc_get_endpoint_url( 'orders', $current_page - 1 ) ); ?>"><?php _e( 'Previous', 'woocommerce' ); ?></a>
			<?php endif; ?>

			<?php if ( intval( $customer_orders->max_num_pages ) !== $current_page ) : ?>
				<a class="woocommerce-button woocommerce-button--next woocommerce-Button woocommerce-Button--next button" href="<?php echo esc_url( wc_get_endpoint_url( 'orders', $current_page + 1 ) ); ?>"><?php _e( 'Next', 'woocommerce' ); ?></a>
			<?php endif; ?>
		</div>
	<?php endif; ?>

<?php else : ?>
	<div class="woocommerce-message woocommerce-message--info woocommerce-Message woocommerce-Message--info woocommerce-info">
		<a class="woocommerce-Button button" href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>">
			<?php _e( 'Go shop', 'woocommerce' ) ?>
		</a>
		<?php _e( 'No order has been made yet.', 'woocommerce' ); ?>
	</div>
<?php endif; ?>

<?php do_action( 'woocommerce_after_account_orders', $has_orders ); ?>
