<div <?php echo $sed_attrs; ?> class="module module-terms module-terms-default <?php echo $class; ?> ">

	<?php

	if( $show_title && $fiter_title && !empty( $terms ) ) {

		?>
		<div class="module-title">
			<h4><?php echo $fiter_title;?></h4>
		</div>
		<?php

	}

	if ( !empty( $terms ) ){


		?>

		<div class="negar-shop-filters">

			<select name="negar-filter-by-category">

				<?php

				// Start the Loop.
				foreach( $terms AS $term ){

					$term_link = get_term_link( $term );

					?>
					<option value="<?php echo esc_attr( esc_url( $term_link ) );?>"><?php echo $term->name;?></option>
					<?php

				}

				?>

			</select>

			<select name="negar-filter-by-price">

				<option value="low-to-hight"><?php echo __("Low to Hight","negar");?></option>

				<option value="hight-to-low"><?php echo __("Low to Hight","negar");?></option>

			</select>

		</div>

		<?php

	}

	?>

</div>
