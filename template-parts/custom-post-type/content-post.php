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

global $wp_query;

$post_number = $wp_query->current_post + 1; 

$classes = array(
    'image-content-box'
);

$excerpt_length = 300;

$content_post = apply_filters('the_excerpt', get_the_excerpt()); //var_dump($content_post);

# FILTER EXCERPT LENGTH
if( strlen( $content_post ) > $excerpt_length )
    $content_post = mb_substr( $content_post , 0 , $excerpt_length - 3 ) . '...';


ob_start();

$attachment_id   = get_post_thumbnail_id();

$img = get_sed_attachment_image_html( $attachment_id , "" , "800×500" );

?>
    <div class="col-sm-7"> 
        <div class="icb-img">
        <?php 

            if ( $img ) {
                echo $img['thumbnail'];
            }

        ?>

        <div class="video-icon"></div>

        </div>
    </div>

<?php

$image = ob_get_contents();
ob_end_clean();


?>            

<div id="post-<?php the_ID(); ?>" <?php post_class( $classes ); ?>>   

    <div class="image-content-box-skin4">
        <div class="icb-wrapper">
            <div class="row">

            <?php
            if( $post_number % 2 == 1 ){
                echo $image;
            }
            ?>

                <div class="col-sm-5"> 
    	            <div class="icb-heading">
    	                <div class="icb-heading-inner">
    	                    <h4><?php the_title(); ?></h4>
                            <span class="icb-date">2015 London October</span>
    	                </div>
    	            </div>
    	            <div class="icb-content">
    	                <div class="icb-content-inner">
    	                    <div><?php echo $content_post; ?></div>
    			            <div class="text-right text-uppercase">
    			                <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="button text-second-main"><?php _e("Read More","twentyseventeen") ?></a>
    			            </div>
    	                </div>
    	            </div>
                </div>

            <?php
            if( $post_number % 2 == 0 ){
                echo $image;
            }
            ?>
        
            </div> 
        </div>  
    </div> 
  
</div>      
