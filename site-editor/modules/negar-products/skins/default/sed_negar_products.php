<div <?php echo $sed_attrs; ?> class="module module-mafiran-products module-negar-products-default <?php echo $class; ?> ">

    <?php

    $product_category_terms = is_string( $product_category_terms ) ? explode( "," , $product_category_terms ) : $product_category_terms;

    //var_dump( $product_category_terms );

    if( !empty( $product_category_terms ) && is_array( $product_category_terms ) ) {

        if( isset( $product_category_terms[0] ) && $product_category_terms[0] ) {

            $term = get_term( $product_category_terms[0] , 'product_cat' );

            if( !$term ){
                return ;
            }

            $term_link = get_term_link( $term , 'product-category' );

            $first_cat = get_term_meta($product_category_terms[0], 'wpcf-product-category-images', false);

            if( !$first_cat || empty( $first_cat ) ){
                return ;
            }

            $first_cat_g1 = array();

            $first_cat_g2 = array();

            $first_cat_g3 = array();

            foreach ($first_cat AS $key => $img) {

                if ($key % 3 == 1) {
                    $first_cat_g1[] = $img;
                } elseif ($key % 3 == 2) {
                    $first_cat_g2[] = $img;
                } else {
                    $first_cat_g3[] = $img;
                }

            }

            $products_description = get_theme_mod( 'mafiran_home_page_products_description' , '' );

            ?>

            <div class="sliders-img negar-sliders-img">

                <div class="row">

                    <div class="col-sm-6 margin-top-box">

                        <div class="row">

                            <div class="col-sm-11">

                                <div class="slide-container sed-negar-slider slide-first g1" data-slider-nav=".sed-negar-slider.slide-second.g1">

                                    <?php

                                    $lightbox_id = 'first_cat_g1_images';

                                    foreach ( $first_cat_g1 As $image_url ) {

                                        $attachment_id = negar_get_attachment_id_by_url( $image_url );

                                        $img = get_sed_attachment_image_html( $attachment_id , '' , '640X640' );

                                        if ( ! $img ) {
                                            $img = array();
                                            $img['thumbnail'] = '<img class="sed-image-placeholder sed-image" src="' . sed_placeholder_img_src() . '" />';
                                        }

                                        ?>
                                        <div class="slide-item">
                                            <?php echo $img['thumbnail'];?>
                                            <!--<div class="info">
                                                <div class="info-inner">
                                                    <a class="img info-icons" href="<?php echo $image_url;?>" data-lightbox="<?php if( !empty($lightbox_id) ) echo $lightbox_id;else echo "sed-lightbox";?>">
                                                        <i class="fa fa-search"></i>
                                                    </a>
                                                    <a href="<?php echo $term_link;?>" class="info-icons"><i class="fa fa-link"></i></a>
                                                </div>
                                            </div>-->
                                        </div>
                                        <?php

                                    }
                                    ?>

                                </div>

                            </div>

                            <div class="clear"></div>

                            <div class="col-sm-6">&nbsp;</div>

                            <div class="col-sm-5">

                                <!--<div class="image-container">
                                    <img src="http://localhost/mafir/wp-content/uploads/2017/07/2-1-640x640.jpg">
                                </div> -->

                                <div class="slide-container sed-negar-slider slide-third g1" data-slider-nav=".sed-negar-slider.slide-first.g1">

                                    <?php

                                    $lightbox_id = 'first_cat_g2_images';

                                    if( !empty( $first_cat_g2 ) ) {

                                        foreach ($first_cat_g2 As $image_url) {

                                            $attachment_id = negar_get_attachment_id_by_url($image_url);

                                            $img = get_sed_attachment_image_html($attachment_id, '', '300X300');

                                            if (!$img) {
                                                $img = array();
                                                $img['thumbnail'] = '<img class="sed-image-placeholder sed-image" src="' . sed_placeholder_img_src() . '" />';
                                            }

                                            ?>
                                            <div class="slide-item">
                                                <?php echo $img['thumbnail']; ?>
                                                <!--<div class="info">
                                                        <div class="info-inner">
                                                            <a class="img info-icons" href="<?php echo $image_url; ?>"
                                                               data-lightbox="<?php if (!empty($lightbox_id)) echo $lightbox_id; else echo "sed-lightbox"; ?>">
                                                                <i class="fa fa-search"></i>
                                                            </a>
                                                            <a href="<?php echo $term_link; ?>" class="info-icons"><i
                                                                    class="fa fa-link"></i></a>
                                                        </div>
                                                    </div>-->
                                            </div>
                                            <?php

                                        }

                                    }
                                    ?>

                                </div>

                            </div>

                            <div class="col-sm-1">&nbsp;</div>

                        </div>

                    </div>

                    <div class="col-sm-6">
                        <div class="row">

                            <div class="col-sm-12">

                                <div class="content-container">
                                    <div class="punchline">
                                        <div class="title"><h3><a href="<?php echo $term_link;?>"><?php echo $term->name;?></h3></a></div>
                                        <div class="desc"><?php echo $term->description;?></div>
                                    </div>
                                </div>

                            </div>

                            <div class="col-sm-12">&nbsp;</div>

                            <div class="col-sm-12">&nbsp;</div>

                            <div class="col-sm-12">&nbsp;</div>

                            <div class="clear"></div>

                            <div class="col-sm-12">

                                <div class="margin-left-box">
                                    <div class="arrows-box negar-next-prev-controler">
                                        <span class="arrow previous"><i class="fa fa-angle-left"></i></span>
                                        <span class="arrow next"><i class="fa fa-angle-right"></i></span>
                                    </div>
                                </div>

                            </div>

                            <div class="clear"></div>

                            <div class="col-sm-1">&nbsp;</div>

                            <div class="col-sm-11">

                                <div class="text-left">

                                    <div class="slide-container sed-negar-slider slide-second g1" data-slider-nav=".sed-negar-slider.slide-first.g1">

                                        <?php

                                        $lightbox_id = 'first_cat_g3_images';

                                        if( !empty( $first_cat_g3 ) ) {

                                            foreach ($first_cat_g3 As $image_url) {

                                                $attachment_id = negar_get_attachment_id_by_url($image_url);

                                                $img = get_sed_attachment_image_html($attachment_id, '', '640X640');

                                                if (!$img) {
                                                    $img = array();
                                                    $img['thumbnail'] = '<img class="sed-image-placeholder sed-image" src="' . sed_placeholder_img_src() . '" />';
                                                }

                                                ?>
                                                <div class="slide-item">
                                                    <?php echo $img['thumbnail']; ?>
                                                    <!--<div class="info">
                                                        <div class="info-inner">
                                                            <a class="img info-icons" href="<?php echo $image_url; ?>"
                                                               data-lightbox="<?php if (!empty($lightbox_id)) echo $lightbox_id; else echo "sed-lightbox"; ?>">
                                                                <i class="fa fa-search"></i>
                                                            </a>
                                                            <a href="<?php echo $term_link; ?>" class="info-icons"><i
                                                                    class="fa fa-link"></i></a>
                                                        </div>
                                                    </div>-->
                                                </div>
                                                <?php

                                            }

                                        }
                                        ?>

                                    </div>

                                </div>

                            </div>

                        </div>
                    </div>

                </div>

            </div>

        <?php

        }

        if( isset( $product_category_terms[1] ) && $product_category_terms[1] ) {

            $term = get_term( $product_category_terms[1] , 'product_cat' );

            if( !$term ){
                return ;
            }

            $term_link = get_term_link( $term , 'product-category' );

            $second_cat = get_term_meta($product_category_terms[1], 'wpcf-product-category-images', false);

            if( !$second_cat || empty( $second_cat ) ){
                return ;
            }

            $second_cat_g1 = array();

            $second_cat_g2 = array();

            foreach ($second_cat AS $key => $img) {

                if ($key % 2 == 1) {
                    $second_cat_g1[] = $img;
                } else {
                    $second_cat_g2[] = $img;
                }

            }

        ?>
            <!--============================================-->


            <div class="sliders-img negar-sliders-img">

                <div class="row">

                    <div class="col-sm-7 margin-top-box-2">

                        <div class="row">

                            <div class="col-sm-10">

                                <div class="content-container">
                                    <div class="punchline">
                                        <div class="title"><h3><a href="<?php echo $term_link;?>"><?php echo $term->name;?></a></h3></div>
                                        <div class="desc"><?php echo $term->description;?></div>
                                    </div>
                                </div>

                            </div>

                            <div class="col-sm-12">&nbsp;</div>
                            <div class="col-sm-12">&nbsp;</div>
                            <div class="col-sm-12">&nbsp;</div>
                            <div class="col-sm-12">&nbsp;</div>

                            <div class="col-sm-12">

                                <div class="slide-container sed-negar-slider slide-first g2" data-slider-nav=".sed-negar-slider.slide-second.g2">


                                    <?php

                                    $lightbox_id = 'second_cat_g1_images';

                                    foreach ( $second_cat_g1 As $image_url ) {

                                        $attachment_id = negar_get_attachment_id_by_url( $image_url );

                                        $img = get_sed_attachment_image_html( $attachment_id , '' , '700X640' );

                                        if ( ! $img ) {
                                            $img = array();
                                            $img['thumbnail'] = '<img class="sed-image-placeholder sed-image" src="' . sed_placeholder_img_src() . '" />';
                                        }

                                        ?>
                                        <div class="slide-item">
                                            <?php echo $img['thumbnail'];?>
                                            <!--<div class="info">
                                                <div class="info-inner">
                                                    <a class="img info-icons" href="<?php echo $image_url;?>" data-lightbox="<?php if( !empty($lightbox_id) ) echo $lightbox_id;else echo "sed-lightbox";?>">
                                                        <i class="fa fa-search"></i>
                                                    </a>
                                                    <a href="<?php echo $term_link;?>" class="info-icons"><i class="fa fa-link"></i></a>
                                                </div>
                                            </div>-->
                                        </div>
                                        <?php

                                    }
                                    ?>

                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="col-sm-5">&nbsp;</div>

                    <div class="col-sm-7">

                        <div class="text-right">
                            <div class="arrows-box arrows-box-2 negar-next-prev-controler">
                                <span class="arrow previous"><i class="fa fa-angle-left"></i></span>
                                <span class="arrow next"><i class="fa fa-angle-right"></i></span>
                            </div>
                        </div>

                    </div>

                    <div class="col-sm-5 margin-top-box-2">

                        <div class="text-left">

                            <div class="slide-container sed-negar-slider slide-second g2" data-slider-nav=".sed-negar-slider.slide-first.g2">


                                <?php

                                if( !empty( $second_cat_g2 ) ) {
                                    $lightbox_id = 'second_cat_g2_images';

                                    foreach ($second_cat_g2 As $image_url) {

                                        $attachment_id = negar_get_attachment_id_by_url($image_url);

                                        $img = get_sed_attachment_image_html($attachment_id, '', '500X500');

                                        if (!$img) {
                                            $img = array();
                                            $img['thumbnail'] = '<img class="sed-image-placeholder sed-image" src="' . sed_placeholder_img_src() . '" />';
                                        }

                                        ?>
                                        <div class="slide-item">
                                            <?php echo $img['thumbnail']; ?>
                                            <!--<div class="info">
                                                <div class="info-inner">
                                                    <a class="img info-icons" href="<?php echo $image_url; ?>"
                                                       data-lightbox="<?php if (!empty($lightbox_id)) echo $lightbox_id; else echo "sed-lightbox"; ?>">
                                                        <i class="fa fa-search"></i>
                                                    </a>
                                                    <a href="<?php echo $term_link; ?>" class="info-icons"><i
                                                            class="fa fa-link"></i></a>
                                                </div>
                                            </div>-->
                                        </div>
                                        <?php

                                    }
                                }
                                ?>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        <?php

        }
    }else{
        echo __("Empty Negar Products Module","negar");
    }
    ?>
    
</div>