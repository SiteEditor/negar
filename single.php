<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

get_header(); ?>

<div class="wrap">
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php
				/* Start the Loop */
				while ( have_posts() ) : the_post();

					get_template_part( 'template-parts/custom-post-type/single-post' );

					/**
					 * Comments
					 */
					$disable_comments = (bool)get_theme_mod( 'sed_disable_single_post_comments' , '0' );

					if( $disable_comments === false || site_editor_app_on() ) {

						if( site_editor_app_on() ) {

							$hide_class = ($disable_comments !== false) ? "hide" : "";

							echo "<div class='sed-single-post-comments ". esc_attr( $hide_class ) ."'>";

						}

						// If comments are open or we have at least one comment, load up the comment template.
						if (comments_open() || get_comments_number()) :
							comments_template();
						endif;

						if( site_editor_app_on() ) {

							echo "</div>";

						}

					}

					/**
					 * Post Navigation
					 */
					$disable_post_nav = (bool)get_theme_mod( 'sed_disable_post_nav' , '0' );

					if( $disable_post_nav === false || site_editor_app_on() ) {

						if( site_editor_app_on() ) {

							$hide_class = ($disable_post_nav !== false) ? "hide" : "";

							echo "<div class='sed-single-post-navigation ". esc_attr( $hide_class ) ."'>";

						}

						the_post_navigation(array(
							'prev_text' => '<span class="screen-reader-text">' . __('Previous Post', 'twentyseventeen') . '</span><span aria-hidden="true" class="nav-subtitle">' . __('Previous', 'twentyseventeen') . '</span> <span class="nav-title"><span class="nav-title-icon-wrapper">' . twentyseventeen_get_svg(array('icon' => 'arrow-left')) . '</span>%title</span>',
							'next_text' => '<span class="screen-reader-text">' . __('Next Post', 'twentyseventeen') . '</span><span aria-hidden="true" class="nav-subtitle">' . __('Next', 'twentyseventeen') . '</span> <span class="nav-title">%title<span class="nav-title-icon-wrapper">' . twentyseventeen_get_svg(array('icon' => 'arrow-right')) . '</span></span>',
						));

						if( site_editor_app_on() ) {

							echo "</div>";

						}

					}

				endwhile; // End of the loop.
			?>

		</main><!-- #main -->
	</div><!-- #primary -->
	<?php get_sidebar(); ?>
</div><!-- .wrap -->

<?php get_footer();
