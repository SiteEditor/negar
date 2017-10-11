<div <?php echo $sed_attrs; ?> class="module module-subscription module-subscription-default <?php echo $class; ?> ">

    <div class="subscription-wrap">

        <div class="image-content-box row">

            <?php

            $args = array(
                'post_type'         => 'product',
                'posts_per_page'    => -1,
                'post_status'       => 'publish',
                //'orderby'         => 'menu_order',
                //'order'           => 'ASC',
                'meta_query'        => array(
                    array(
                        'key'       => 'wpcf-sed-product-tanin-type',
                        'value'     => 'subscription'
                    ),
                ),
            );
            $query = new WP_Query( $args );

            while ( $query->have_posts() ) {

                $query->the_post();  //var_dump( YWSBS_Subscription()->get_subscription_meta( get_the_ID() ) );

                $attachment_id   = get_post_thumbnail_id();

                $img = get_sed_attachment_image_html( $attachment_id , "" , "144X156" );

                $attachment_full_src = wp_get_attachment_image_src( $attachment_id, 'full' );

                $attachment_full_src = $attachment_full_src[0];

                $excerpt_length = 300;

                $content_post = apply_filters('the_excerpt', get_the_excerpt()); //var_dump($content_post);

                # FILTER EXCERPT LENGTH
                if( strlen( $content_post ) > $excerpt_length )
                    $content_post = mb_substr( $content_post , 0 , $excerpt_length - 3 ) . '...';

                /*$price_is_per = get_post_meta( get_the_ID(), '_ywsbs_price_is_per', true );

                $max_length = get_post_meta( get_the_ID(), '_ywsbs_max_length', true );

                $price_time_option = get_post_meta( get_the_ID(), '_ywsbs_price_time_option', true );

                if( $price_time_option == "months" ){

                    if( $max_length == 12 ){



                    }else if( $max_length == 24 ){



                    }

                }*/

                $_product = wc_get_product( get_the_ID() );

            ?>

            <div class="image-content-box-skin3 col-sm-4">
                <div class="icb-wrapper">
                    <div class="icb-img">
                    <?php
                        if ( $img ) {
                            echo $img['thumbnail'];
                        }
                    ?>
                    </div>
                    <div class="icb-heading">
                        <div class="icb-heading-inner">
                            <h4><?php the_title(); ?></h4>
                        </div>
                    </div>
                    <div class="icb-content">
                        <div class="icb-content-inner">
                            <div><?php echo $content_post; ?></div>
                        </div>
                        <div class="icb-subscribe-plan">
                            <span><?php echo $_product->get_price_html();?></span>
                        </div>
                        <div class="icb-subscribe-btn">
                            <a href="<?php echo site_url( '/?tanin_quick_checkout=1&add_to_cart='. get_the_ID() ); ?>" ><button class="secondary">Subscribe</button></a>
                        </div>
                    </div>
                </div>
            </div>

            <?php

            }

            ?>

        </div>

    </div> 
    
</div>