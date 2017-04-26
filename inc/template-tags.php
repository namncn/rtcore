<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Raothue
 * @subpackage RT_Theme
 * @since 1.0
 */

if ( ! function_exists( 'rt_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function rt_posted_on() {

	// Get the author name; wrap it in a link.
	$byline = sprintf(
		/* translators: %s: post author */
		__( 'by %s', 'rt-theme' ),
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . get_the_author() . '</a></span>'
	);

	// Finally, let's write all of this to the page.
	echo '<span class="posted-on">' . rt_time_link() . '</span><span class="byline"> ' . $byline . '</span>';
}
endif;


if ( ! function_exists( 'rt_time_link' ) ) :
/**
 * Gets a nicely formatted string for the published date.
 */
function rt_time_link() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		get_the_date( DATE_W3C ),
		get_the_date(),
		get_the_modified_date( DATE_W3C ),
		get_the_modified_date()
	);

	// Wrap the time string in a link, and preface it with 'Posted on'.
	return sprintf(
		/* translators: %s: post date */
		__( '<span class="screen-reader-text">Posted on</span> %s', 'rt-theme' ),
		'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
	);
}
endif;


if ( ! function_exists( 'rt_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function rt_entry_footer() {

	/* translators: used between list items, there is a space after the comma */
	$separate_meta = __( ', ', 'rt-theme' );

	// Get Categories for posts.
	$categories_list = get_the_category_list( $separate_meta );

	// Get Tags for posts.
	$tags_list = get_the_tag_list( '', $separate_meta );

	// We don't want to output .entry-footer if it will be empty, so make sure its not.
	if ( ( ( rt_categorized_blog() && $categories_list ) || $tags_list ) || get_edit_post_link() ) {

		echo '<footer class="entry-footer">';

			if ( 'post' === get_post_type() ) {
				if ( ( $categories_list && rt_categorized_blog() ) || $tags_list ) {
					echo '<span class="cat-tags-links">';

						// Make sure there's more than one category before displaying.
						if ( $categories_list && rt_categorized_blog() ) {
							echo '<span class="cat-links"><span class="screen-reader-text">' . __( 'Categories', 'rt-theme' ) . '</span>' . $categories_list . '</span>';
						}

						if ( $tags_list ) {
							echo '<span class="tags-links"><span class="screen-reader-text">' . __( 'Tags', 'rt-theme' ) . '</span>' . $tags_list . '</span>';
						}

					echo '</span>';
				}
			}

			rt_edit_link();

		echo '</footer> <!-- .entry-footer -->';
	}
}
endif;


if ( ! function_exists( 'rt_edit_link' ) ) :
/**
 * Returns an accessibility-friendly link to edit a post or page.
 *
 * This also gives us a little context about what exactly we're editing
 * (post or page?) so that users understand a bit more where they are in terms
 * of the template hierarchy and their content. Helpful when/if the single-page
 * layout with multiple posts/pages shown gets confusing.
 */
function rt_edit_link() {

	$link = edit_post_link(
		sprintf(
			/* translators: %s: Name of current post */
			__( 'Edit<span class="screen-reader-text"> "%s"</span>', 'rt-theme' ),
			get_the_title()
		),
		'<span class="edit-link">',
		'</span>'
	);

	return $link;
}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function rt_categorized_blog() {
	$category_count = get_transient( 'rt_categories' );

	if ( false === $category_count ) {
		// Create an array of all the categories that are attached to posts.
		$categories = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,
			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$category_count = count( $categories );

		set_transient( 'rt_categories', $category_count );
	}

	return $category_count > 1;
}

/**
 * Output a comment in the HTML5 format.
 *
 * @param object $comment Comment to display.
 * @param array  $args    An array of arguments.
 * @param int    $depth   Depth of comment.
 */
function rt_html5_comment( $comment, $args, $depth ) {
	global $post;
	$tag = ( 'div' === $args['style'] ) ? 'div' : 'li'; ?>

	<<?php echo esc_html( $tag ); ?> id="comment-<?php comment_ID(); ?>" <?php comment_class( 'ncn-comment__item' ); ?>>

	<article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
		<?php if ( 0 != $args['avatar_size'] ) : ?>
			<div class="ncn-comment__left">
				<div class="ncn-comment__thumb"><?php echo get_avatar( $comment, $args['avatar_size'] ); ?></div>
			</div><!-- .ncn-comments__left -->
		<?php endif ?>

		<div class="ncn-comment__body">
			<?php if ( $comment->user_id === $post->post_author ) : ?>
				<span class="author-label"><?php esc_html_e( 'Tác giả', 'rt-theme' ); ?></span>
			<?php endif; ?>
			<div class="ncn-comment__action">
				<?php comment_reply_link( array_merge( $args, array(
					'depth'     => $depth,
					'max_depth' => $args['max_depth'],
					'add_below' => 'div-comment',
				) ) ); ?>

				<?php edit_comment_link( esc_html__( 'Chỉnh sửa', 'rt-theme' ) ); ?>
			</div>

			<div class="comment-metadata ncn-comments__meta">
				<span class="comment-author ncn-comment__name h6">
					<?php echo get_comment_author_link(); ?>
				</span><!-- .comment-author -->

				<span class="ncn-comment__time">
					<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID, $args ) ); ?>">
						<time datetime="<?php comment_time( 'c' ); ?>">
							<?php printf( esc_html__( '%1$s lúc %2$s', 'rt-theme' ), get_comment_date( '', $comment ), get_comment_time() ); ?>
						</time>
					</a>
				</span>

				<?php if ( '0' == $comment->comment_approved ) : ?>
					<p class="comment-awaiting-moderation"><?php esc_html_e( 'Bình luận của bạn đang đợi duyệt.', 'rt-theme' ); ?></p>
				<?php endif; ?>
			</div><!-- .comment-metadata -->

			<div class="ncn-comment__content">
				<?php comment_text(); ?>
			</div><!-- .comment-content -->
		</div>

	</article><!-- .comment-body --><?php
	// Note: No close tag is here.
}

/**
 * Set post view.
 *
 * @param int $postID Post ID.
 */
function rt_postview_set( $postID ) {
	$count_key = 'postview_number';
	$count = get_post_meta( $postID, $count_key, true );

	if ( ! $count ) {
		$count = 0;
		delete_post_meta( $postID, $count_key );
		add_post_meta( $postID, $count_key, '0' );
	} else {
		$count++;
		update_post_meta( $postID, $count_key, $count );
	}
}

/**
 * Get post view.
 *
 * @param int $postID Post ID.
 */
function rt_postview_get( $postID ){
	$count_key = 'postview_number';
	$count = get_post_meta( $postID, $count_key, true );

	if( ! $count ){
		delete_post_meta( $postID, $count_key );
		add_post_meta( $postID, $count_key, '0' );

		return '0';
	}

	return $count;
}


/**
 * Flush out the transients used in rt-theme_categorized_blog.
 */
function rt_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'rt_categories' );
}
add_action( 'edit_category', 'rt_category_transient_flusher' );
add_action( 'save_post',     'rt_category_transient_flusher' );
