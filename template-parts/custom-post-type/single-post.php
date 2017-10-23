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


?>

<div id="post-<?php the_ID(); ?>" <?php post_class( 'post news' ); ?>>

	<div class="custom-post-type-single">
	    <div class="single-wrapper">
	        <div class="single-img-wrap"> 
		        <div class="single-img">    	
		        	<?php if ( '' !== get_the_post_thumbnail() ) : ?>
		                <?php the_post_thumbnail( 'twentyseventeen-featured-image' ); ?>
		            <?php endif; ?>
		        </div> 
	            <div class="single-date-wrap">
	            	<span class="single-date-day">13</span>
	            	<span class="single-date-mounth">SEP</span>
	            </div>   
	        </div> 
	        <div class="single-heading">
	            <div class="single-heading-inner">
	                <h4><?php the_title(); ?></h4>
	                <span class="single-date">2015 London October</span>
	            </div>
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
	            </div>
	        </div>
	    </div>  
	</div>  

</div><!-- #post-## -->         