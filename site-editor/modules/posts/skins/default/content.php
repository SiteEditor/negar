<li class="entry-item collage-item clearfix post item">

    <?php

    $post_link = apply_filters( "sed_posts_modules_post_permalink" , get_permalink() );

    ?>

    <a href="<?php echo esc_attr( $post_link );?>">

        <?php the_title();?>

    </a>

</li>

