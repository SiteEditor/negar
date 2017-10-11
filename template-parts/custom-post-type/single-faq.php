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
<div id="post-<?php the_ID(); ?>" <?php post_class( 'faq-item' ); ?>>
    <div class="sed-shop-faq-single">
        <div class="sed-shop-faq-single-inner">

            <div class="faq-heading">
                <div class="faq-heading-inner">
                    <h5><?php the_title(); ?></h5>
                </div>
            </div>

            <div class="faq-content">
                <div class="faq-content-inner">
                    <?php
                        /* translators: %s: Name of current post */
                        the_content( sprintf(
                            __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'twentyseventeen' ),
                            get_the_title()
                        ) );
                    ?>
                </div>
            </div>

        </div>
    </div>
</div>