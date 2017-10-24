<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">

	<?php
	// You can start editing here -- including this comment!
	if ( have_comments() ) : ?>
		<h2 class="comments-title">
			<?php
				$comments_number = get_comments_number();
				if ( '1' === $comments_number ) {
					/* translators: %s: post title */
					echo __( 'One Comment', 'twentyseventeen' ) ;
				} else {
					printf(
						/* translators: 1: number of comments, 2: post title */
						_x(
							'%1$s Comments',
							$comments_number,
							'twentyseventeen'
						),
						number_format_i18n( $comments_number )
					);
				}
			?>
		</h2>

		<ol class="comment-list">
			<?php

				//wp_list_comments( 'type=comment&callback=mytheme_comment' );

				wp_list_comments( array(
					'avatar_size' => 100,
					'style'       => 'ol',
					'short_ping'  => true,
					//'reply_text'  => twentyseventeen_get_svg( array( 'icon' => 'mail-reply' ) ) . __( 'Reply', 'twentyseventeen' ),
					'callback'	  => 'negar_comment' ,
					'type'		  => 'comment'
				) );

			?>
		</ol>

		<?php the_comments_pagination( array(
			'prev_text' => twentyseventeen_get_svg( array( 'icon' => 'arrow-left' ) ) . '<span class="screen-reader-text">' . __( 'Previous', 'twentyseventeen' ) . '</span>',
			'next_text' => '<span class="screen-reader-text">' . __( 'Next', 'twentyseventeen' ) . '</span>' . twentyseventeen_get_svg( array( 'icon' => 'arrow-right' ) ),
		) );

	endif; // Check for have_comments().

	// If comments are closed and there are comments, let's leave a little note, shall we?
	if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>

		<p class="no-comments"><?php _e( 'Comments are closed.', 'twentyseventeen' ); ?></p>
	<?php
	endif;

	$commenter = wp_get_current_commenter();
	$req = get_option( 'require_name_email' );
	$aria_req = ( $req ? " aria-required='true'" : '' );

	$fields =  array(

		'author' =>
			'<p class="comment-form-author"><input id="author" name="author" placeholder="' . __( 'Name', 'twentyseventeen' ) . ( $req ? '*' : '' ) . '" type="text" value="' . esc_attr( $commenter['comment_author'] ) .
			'" size="30"' . $aria_req . ' /></p>',

		'email' =>
			'<p class="comment-form-email"><input id="email" name="email"  placeholder="' . __( 'Email', 'twentyseventeen' ) . ( $req ? '*' : '' ) . '" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) .
			'" size="30"' . $aria_req . ' /></p>'
	);

	comment_form(
		array(
			'fields' 			=> $fields ,
			'comment_field' 	=>  '<p class="comment-form-comment"><textarea id="comment" name="comment" placeholder="' . __( 'Comment', 'twentyseventeen' ) . '*" cols="45" rows="8" aria-required="true">' .
				'</textarea></p>',
		)
	);
	?>

</div><!-- #comments -->
