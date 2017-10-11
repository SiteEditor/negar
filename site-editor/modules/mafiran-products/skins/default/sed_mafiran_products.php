<div <?php echo $sed_attrs; ?> class="module module-mafiran-products module-mafiran-products-default <?php echo $class; ?> ">

    <div class="sliders-img">

        <div class="row">

            <div class="col-sm-1 text-right wow bounceInUp" data-wow-delay="800ms" data-wow-iteration="1" data-wow-duration="2000ms" data-sed-animation="bounceInUp" data-wow-offset="0">
                <div class="black-box">&nbsp;</div>         
            </div>

            <div class="clear"></div>   

            <div class="col-sm-1">&nbsp;</div>  

            <?php

            $timber = get_term_by( 'slug' , 'timber' , 'product-category' );

            $timber_link = get_term_link( $timber , 'product-category' );

            $wooden_logs = get_term_by( 'slug' , 'wooden-logs' , 'product-category' );

            $wooden_logs_link = get_term_link( $wooden_logs , 'product-category' );

            $timber_gallery = get_term_meta( $timber->term_id , 'wpcf-product-category-images' , false );

            $wooden_logs_gallery = get_term_meta( $wooden_logs->term_id , 'wpcf-product-category-images' , false );

            $products_description = get_theme_mod( 'mafiran_home_page_products_description' , '' );

            ?>

            <div class="col-sm-11">
                <div class="row">
                    <div class="col-sm-6 wow bounceInUp" data-wow-delay="1000ms" data-wow-iteration="1" data-wow-duration="2000ms" data-sed-animation="bounceInUp" data-wow-offset="0">
                        <div class="slide-container slide-first sed-mafiran-slider" data-slider-nav=".sed-mafiran-slider.slide-second">

                            <?php

                            $lightbox_id = 'timber_cat_gallery_images';

                            foreach ( $timber_gallery As $image_url ) {

                                $attachment_id = mafiran_get_attachment_id_by_url( $image_url );

                                $img = get_sed_attachment_image_html( $attachment_id , '' , '640X640' );

                                if ( ! $img ) {
                                    $img = array();
                                    $img['thumbnail'] = '<img class="sed-image-placeholder sed-image" src="' . sed_placeholder_img_src() . '" />';
                                }

                                ?>
                                <div class="slide-item">
                                    <?php echo $img['thumbnail'];?>
                                    <div class="info">
                                        <div class="info-inner">
                                            <a class="img info-icons" href="<?php echo $image_url;?>" data-lightbox="<?php if( !empty($lightbox_id) ) echo $lightbox_id;else echo "sed-lightbox";?>">
                                                <i class="fa fa-search"></i>
                                            </a>
                                            <a href="<?php echo $timber_link;?>" class="info-icons"><i class="fa fa-link"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <?php

                            }
                            ?>

                        </div>
                    </div>

                    <div class="clear"></div>   

                    <div class="col-sm-6 text-left">

                        <div class="text-left wow bounceInUp" data-wow-delay="1200ms" data-wow-iteration="1" data-wow-duration="2000ms" data-sed-animation="bounceInUp" data-wow-offset="0">
                            <div class="arrows-box mafiran-next-prev-controler">
                                <span class="arrow previous"><i class="fa fa-angle-left"></i></span>
                                <span class="arrow next"><i class="fa fa-angle-right"></i></span>
                            </div>
                            <div class="title-general right"><h5><?php echo $timber->name;?></h5></div>
                        </div>

                        <div class="content-container text-right wow bounceInUp" data-wow-delay="1400ms" data-wow-iteration="1" data-wow-duration="2000ms" data-sed-animation="bounceInUp" data-wow-offset="0">
                            <div class="punchline">
                                <div class="title"><h3><?php _e("Products...","mafiran");?></h3></div>
                                <div class="spr-general"></div>
                                <p class="desc"><?php echo $products_description;?></p>
                                <div class="spr-general"></div>
                            </div>
                        </div>

                    </div>

                    <div class="col-sm-6 margin-top-box wow bounceInUp" data-wow-delay="1200ms" data-wow-iteration="1" data-wow-duration="2000ms" data-sed-animation="bounceInUp" data-wow-offset="0">

                        <div class="text-right">
                            <div class="title-general left"><h5><?php echo $wooden_logs->name;?></h5></div>
                            <div class="logo-box">&nbsp;</div>
                        </div>

                        <div class="slide-container slide-second sed-mafiran-slider" data-slider-nav=".sed-mafiran-slider.slide-first">

                            <?php

                            $lightbox_id = 'wooden_logs_cat_gallery_images';

                            foreach ( $wooden_logs_gallery As $image_url ) {

                                $attachment_id = mafiran_get_attachment_id_by_url( $image_url );

                                $img = get_sed_attachment_image_html( $attachment_id , '' , '640X640' );

                                if ( ! $img ) {
                                    $img = array();
                                    $img['thumbnail'] = '<img class="sed-image-placeholder sed-image" src="' . sed_placeholder_img_src() . '" />';
                                }

                                ?>
                                <div class="slide-item">
                                    <?php echo $img['thumbnail'];?>
                                    <div class="info">
                                        <div class="info-inner">
                                            <a class="img info-icons" href="<?php echo $image_url;?>" data-lightbox="<?php if( !empty($lightbox_id) ) echo $lightbox_id;else echo "sed-lightbox";?>">
                                                <i class="fa fa-search"></i>
                                            </a>
                                            <a href="<?php echo $wooden_logs_link;?>" class="info-icons"><i class="fa fa-link"></i></a>
                                        </div>
                                    </div>
                                </div>
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