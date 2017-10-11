<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.2
 */

$service_sub_title = get_post_meta( get_the_ID(), 'wpcf-service-sub-title', true );

$service_link = get_post_meta( get_the_ID(), 'wpcf-service-link', true );

?>

<div id="post-<?php the_ID(); ?>" <?php post_class( 'service' ); ?>>

	<div class="custom-post-type-single">
	    <div class="single-wrapper">
	        <div class="single-img">        	
	        	<?php if ( '' !== get_the_post_thumbnail() ) : ?>
	                <?php the_post_thumbnail( 'twentyseventeen-featured-image' ); ?>
	            <?php endif; ?>
	        </div>
	        <div class="service-sub-title">
	            <h4><span class="text-second-main"><?php echo $service_sub_title; ?></span></h4>
	        </div>
	        <div class="single-content">
	            <div class="single-content-inner">
					<div>  
						<?php
							/* translators: %s: Name of current post */
							the_content( sprintf(
								__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'twentyseventeen' ),
								get_the_title()
							) );
						?>
					</div><!-- the_content -->   
					<br>
		            <div class="text-uppercase">
		                <a href="<?php echo esc_attr(esc_url($service_link)); ?>" title="<?php the_title(); ?>" class="button text-first-main"><?php _e("Enter","twentyseventeen") ?></a>
		            </div>  
	            </div>
	        </div>
	    </div>  
	</div>  

</div><!-- #post-## -->         