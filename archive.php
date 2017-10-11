<?php
/**
 * The template for displaying archive pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

get_header(); ?>

<div class="wrap">

	<?php if ( have_posts() ) : ?>

		<?php

		$show_blog_archive_title = (bool)get_theme_mod( 'sed_show_blog_archive_title' , '1' );

		$show_blog_archive_description = (bool)get_theme_mod( 'sed_show_blog_archive_description' , '1' );

		if( $show_blog_archive_title === true || $show_blog_archive_description === true || site_editor_app_on() ) {

			$hide_class = ($show_blog_archive_title === false && $show_blog_archive_description === false) ? "hide" : "";
		?>

			<header class="page-header <?php echo esc_attr( $hide_class ) ;?>">

				<?php

				if( $show_blog_archive_title === true || site_editor_app_on() ) {

					$hide_class = ($show_blog_archive_title === false) ? "hide" : "";

					the_archive_title('<h1 class="page-title '. esc_attr( $hide_class ) .'">', '</h1>');

				}

				if( $show_blog_archive_description === true || site_editor_app_on() ) {

					$hide_class = ($show_blog_archive_description === false) ? "hide" : "";

					the_archive_description( '<div class="taxonomy-description '. esc_attr( $hide_class ) .'">', '</div>' );

				}

				?>

			</header><!-- .page-header -->

		<?php } ?>

	<?php endif; ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php
		if ( have_posts() ) : ?>
			<?php
			/* Start the Loop */
			while ( have_posts() ) : the_post();

				/*
				 * Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */
				get_template_part( 'template-parts/custom-post-type/content-post' );

			endwhile;

			the_posts_pagination( array(
				'prev_text' => twentyseventeen_get_svg( array( 'icon' => 'arrow-left' ) ) . '<span class="screen-reader-text">' . __( 'Previous page', 'twentyseventeen' ) . '</span>',
				'next_text' => '<span class="screen-reader-text">' . __( 'Next page', 'twentyseventeen' ) . '</span>' . twentyseventeen_get_svg( array( 'icon' => 'arrow-right' ) ),
				'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'twentyseventeen' ) . ' </span>',
			) );

		else :

			get_template_part( 'template-parts/post/content', 'none' );

		endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->
	<?php get_sidebar(); ?>
</div><!-- .wrap -->

<?php get_footer();
