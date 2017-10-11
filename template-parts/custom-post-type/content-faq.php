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


$classes = array(
    'faq-item-heading'
);

$excerpt_length = 800;

$content_post = apply_filters('the_excerpt', get_the_excerpt()); //var_dump($content_post);

# FILTER EXCERPT LENGTH
if( strlen( $content_post ) > $excerpt_length )
    $content_post = mb_substr( $content_post , 0 , $excerpt_length - 3 ) . '...';

?>

    <div id="post-<?php the_ID(); ?>" <?php post_class( $classes ); ?>>
        <div class="faq-heading-inner">
            <h5><?php the_title(); ?></h5>
        </div>
    </div>

    <div class="faq-item-content">
        <div class="faq-content-inner">
            <div><?php echo $content_post; ?></div>
            <div class="text-right text-uppercase">
                <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="button text-second-main"><?php _e("Read More","twentyseventeen") ?></a>
            </div>
        </div>
    </div><!-- #post-## -->