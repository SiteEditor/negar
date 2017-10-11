<?php

$active = $is_tax && $current_term_id == $term->term_id ? "active": "";

?><div class="entry-item collage-item clearfix post item <?php echo esc_attr( $active );?>">

    <?php
    $term_link = get_term_link( $term );

    // If there was an error, continue to the next term.
    if ( is_wp_error( $term_link ) ) {
        $term_link = "#";
    }

    ?>

    <a href="<?php echo esc_attr( esc_url( $term_link ) );?>">

        <?php echo $term->name;?>

    </a>

</div>

