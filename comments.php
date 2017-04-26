<?php
/**
 * The template for displaying comments.
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package RTCORE
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
		<h3 class="comments-title">
			<?php printf( // WPCS: XSS OK.
				esc_html( _nx( 'Bình luận (1)', 'Bình luận (%s)', get_comments_number(), 'comments title', 'rt-theme' ) ),
				number_format_i18n( get_comments_number() )
			); ?>
		</h3>

		<ol class="comment-list ncn-comment ncn-comment__list">
			<?php
				wp_list_comments( array(
					'style'       => 'ol',
					'short_ping'  => true,
					'avatar_size' => 72,
					'callback'    => 'rt_html5_comment',
				) );
			?>
		</ol><!-- .ncn-comment__list -->

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
		<nav id="comment-nav-below" class="navigation comment-navigation" role="navigation">
			<h2 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'rt-theme' ); ?></h2>
			<div class="nav-links">

				<div class="nav-previous"><?php previous_comments_link( esc_html__( 'Bình luận cũ hơn', 'rt-theme' ) ); ?></div>
				<div class="nav-next"><?php next_comments_link( esc_html__( 'Bình luận mới hơn', 'rt-theme' ) ); ?></div>

			</div><!-- .nav-links -->
		</nav><!-- #comment-nav-below -->
		<?php
		endif; // Check for comment navigation.

	endif; // Check for have_comments().

	// If comments are closed and there are comments, let's leave a little note, shall we?
	if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
		<p class="no-comments"><?php esc_html_e( 'Đã đóng bình luận.', 'rt-theme' ); ?></p>
	<?php endif; ?>

	<?php
	// Comment form.
	comment_form( array(
		'class_form'    => 'row comment-form',
		'class_submit'  => 'btn btn-lg btn-primary',
		'submit_button' => '<button name="%1$s" type="submit" id="%2$s" class="%3$s">%4$s</button>',
		'comment_field' => '<div class="form-group comment-form-comment col-md-10"><label class="screen-reader-text" for="comment">' . esc_html__( 'Bình luận', 'rt-theme' ) . '</label> <textarea id="comment" name="comment" rows="8" required="required" placeholder="' .  esc_html__( 'Bình luận', 'rt-theme' ) . '"></textarea></div>',

		'comment_notes_before' => '',
		'title_reply_before'   => '<h3 id="reply-title" class="comment-reply-title text-uppercase h4">',
		'title_reply_after'    => '</h3>',

		'fields' => array(
			'author' => '<div class="form-group comment-form-author col-md-4"> <label class="screen-reader-text" for="author">' . esc_html__( 'Tên', 'rt-theme' ) . '</label> <input id="author" name="author" type="text" placeholder="' .  esc_html__( 'Tên', 'rt-theme' ) . '" value="' . esc_attr( $commenter['comment_author'] ) . '" required="required"></div>',
			'email'  => '<div class="form-group comment-form-email col-md-3"><label class="screen-reader-text" for="email">' . esc_html__( 'Email', 'rt-theme' ) . '</label> <input id="email" name="email" type="email" placeholder="' .  esc_html__( 'Email', 'rt-theme' ) . '" value="' . esc_attr( $commenter['comment_author_email'] ) . '" required="required"></div>',
			'url'    => '<div class="form-group comment-form-url col-md-3"><label class="screen-reader-text" for="url">' . esc_html__( 'Website', 'rt-theme' ) . '</label> <input id="url" name="url" type="url" placeholder="' .  esc_html__( 'Website', 'rt-theme' ) . '" value="' . esc_attr( $commenter['comment_author_url'] ) . '" required="required"></div>',
		),
		'submit_field'         => '<p class="form-submit col-md-10">%1$s %2$s</p>',
		/** This filter is documented in wp-includes/link-template.php */
		'logged_in_as'         => '<p class="logged-in-as col-md-10">' . sprintf(
		                              /* translators: 1: edit user link, 2: accessibility text, 3: user name, 4: logout URL */
		                              wp_kses( '<a href="%1$s" aria-label="%2$s">%5$s: %3$s</a> <a href="%4$s">Log out?</a>', array( 'a' => array( 'href' => array(), 'aria-label' => array() ) ) ),
		                              get_edit_user_link(),
		                              /* translators: %s: user name */
		                              esc_attr( sprintf( esc_html__( 'Đăng nhập với nick: %s. Chỉnh sửa tài khoản.', 'rt-theme' ), $user_identity ) ),
		                              $user_identity,
		                              wp_logout_url( apply_filters( 'the_permalink', get_permalink( get_the_ID() ) ) ),
		                              esc_html__( 'Đăng nhập với nick', 'rt-theme' )
		                          ) . '</p>',
	) );
	?>

</div><!-- #comments -->
