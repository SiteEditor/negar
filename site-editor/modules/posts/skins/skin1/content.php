<div class="image-content-box col-sm-4">

    <?php

    $service_sub_title = get_post_meta( get_the_ID(), 'wpcf-service-sub-title', true );

    $post_link = apply_filters( "sed_posts_modules_post_permalink" , get_permalink() );

    $post_type_link = get_post_type_archive_link( $post_type );

    $attachment_id   = get_post_thumbnail_id();

	$img = get_sed_attachment_image_html( $attachment_id , "" , "306X220" );

	$attachment_full_src = wp_get_attachment_image_src( $attachment_id, 'full' ); 

	$attachment_full_src = $attachment_full_src[0];

	//$excerpt_length = 50;

    $content_post = apply_filters('the_excerpt', get_the_excerpt());

    # FILTER EXCERPT LENGTH
    if( strlen( $content_post ) > $excerpt_length )
        $content_post = mb_substr( $content_post , 0 , $excerpt_length - 3 ) . '...';

    ?>

    <div class="image-content-box-skin1">

        <a href="<?php echo esc_attr( $post_link );?>" class="icb-wrapper">
            <div class="icb-img">
                <?php 
                    if ( $img ) {
                        echo $img['thumbnail'];
                    }
                ?>
                <div class="info">
                    <div class="info-inner">
                        <h4><?php the_title();?></h4>   
                    </div>                  
                </div>
            </div>
            <div class="icb-heading">
                <div class="icb-heading-inner">
                    <h4><?php echo $service_sub_title; ?></h4>
                </div>
            </div>
            <div class="general-separator-sm"></div>
            <div class="icb-content">
                <div class="icb-content-inner">
                    <div><?php echo $content_post; ?></div>
                </div>
            </div>
        </a>  

    </div> 

</div> 