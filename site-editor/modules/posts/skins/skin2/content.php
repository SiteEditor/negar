<div class="image-content-box col-sm-3">

    <?php

    $our_team_sub_title = get_post_meta( get_the_ID(), 'wpcf-our-team-sub-title', true );

    $wpcf_social_icon = get_post_meta( get_the_ID(), 'wpcf-social-icon', false );

    $wpcf_social_link = get_post_meta( get_the_ID(), 'wpcf-social-link', false );


    $post_link = apply_filters( "sed_posts_modules_post_permalink" , get_permalink() );

    $post_type_link = get_post_type_archive_link( $post_type );

    $attachment_id   = get_post_thumbnail_id();

	$img = get_sed_attachment_image_html( $attachment_id , "" , $images_size );

	$attachment_full_src = wp_get_attachment_image_src( $attachment_id, 'full' ); 

	$attachment_full_src = $attachment_full_src[0];

	//$excerpt_length = 50;

    $content_post = apply_filters('the_excerpt', get_the_excerpt());

    # FILTER EXCERPT LENGTH
    if( strlen( $content_post ) > $excerpt_length )
        $content_post = mb_substr( $content_post , 0 , $excerpt_length - 3 ) . '...';

    ?>


    <div class="image-content-box-skin2">
        <div class="icb-wrapper">
            <div class="icb-img">
                <?php 
                    if ( $img ) {
                        echo $img['thumbnail'];
                    }
                ?>
                <div class="info">
                    <div class="info-inner">    
                        <div class="info-heading">
                            <h4><?php the_title();?></h4>  
                            <span><?php echo $our_team_sub_title; ?></span>
                        </div>  
                        <div class="info-spr"></div>
                        <div class="info-content">
                            <div><?php echo $content_post; ?></div>
                            <div class="info-social-bar">
                                <?php

                                    foreach ($wpcf_social_icon as $key => $value) {

                                        $link = (isset($wpcf_social_link[$key])) ? $wpcf_social_link[$key] : "javascript:void(0);";

                                        ?>

                                        <a href="<?php echo $link; ?>" class="social-bar-item fa fa-<?php echo esc_attr($value); ?>"></a>

                                        <?php
                                    }
                                ?>    
                            </div>
                        </div>
                    </div>                  
                </div>
            </div>
        </div>  
    </div> 


</div> 