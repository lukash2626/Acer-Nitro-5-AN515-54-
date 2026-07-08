<?php
/**
 * Comments Template
 *
 * @package PadelUp
 */

if ( post_password_required() ) {
    return;
}
?>

<div id="comments" class="comments-area" style="margin-top: 60px; padding-top: 40px; border-top: 1px solid #eee;">

    <?php if ( have_comments() ) : ?>
        <h3 class="comments-title" style="font-size: 1.3rem; font-weight: 700; margin-bottom: 24px;">
            <?php
            $comments_number = get_comments_number();
            if ( '1' === $comments_number ) {
                printf( _x( 'One Comment', 'comments title', 'padelup' ) );
            } else {
                printf(
                    _nx(
                        '%1$s Comment',
                        '%1$s Comments',
                        $comments_number,
                        'comments title',
                        'padelup'
                    ),
                    number_format_i18n( $comments_number )
                );
            }
            ?>
        </h3>

        <ol class="comment-list" style="list-style: none; padding: 0; margin: 0;">
            <?php
            wp_list_comments( array(
                'style'       => 'ol',
                'short_ping'  => true,
                'avatar_size' => 48,
                'callback'    => 'padelup_comment',
            ) );
            ?>
        </ol>

        <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
            <nav class="comment-navigation" style="display: flex; justify-content: space-between; margin-top: 30px; padding-top: 20px; border-top: 1px solid #eee;">
                <div class="nav-previous"><?php previous_comments_link( __( '← Previous Comments', 'padelup' ) ); ?></div>
                <div class="nav-next"><?php next_comments_link( __( 'Next Comments →', 'padelup' ) ); ?></div>
            </nav>
        <?php endif; ?>

    <?php endif; ?>

    <?php if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
        <p class="no-comments" style="color: var(--color-gray-light); font-style: italic;"><?php _e( 'Comments are closed.', 'padelup' ); ?></p>
    <?php endif; ?>

    <?php
    comment_form( array(
        'title_reply'          => __( 'Leave a Comment', 'padelup' ),
        'title_reply_to'       => __( 'Leave a Reply to %s', 'padelup' ),
        'cancel_reply_link'    => __( 'Cancel Reply', 'padelup' ),
        'label_submit'         => __( 'Submit Comment', 'padelup' ),
        'comment_field'        => '<p class="comment-form-comment"><label for="comment">' . _x( 'Comment', 'noun', 'padelup' ) . '</label><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; font-family: inherit; resize: vertical;"></textarea></p>',
        'fields'               => array(
            'author' => '<p class="comment-form-author"><label for="author">' . __( 'Name', 'padelup' ) . ' <span class="required">*</span></label><input id="author" name="author" type="text" value="" size="30" aria-required="true" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px;" /></p>',
            'email'  => '<p class="comment-form-email"><label for="email">' . __( 'Email', 'padelup' ) . ' <span class="required">*</span></label><input id="email" name="email" type="email" value="" size="30" aria-required="true" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px;" /></p>',
            'url'    => '<p class="comment-form-url"><label for="url">' . __( 'Website', 'padelup' ) . '</label><input id="url" name="url" type="url" value="" size="30" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px;" /></p>',
        ),
        'submit_button'        => '<button type="submit" class="btn btn--primary" style="padding: 12px 28px;">%4$s</button>',
        'submit_field'         => '<p class="form-submit">%1$s %2$s</p>',
        'logged_in_as'         => '<p class="logged-in-as" style="color: var(--color-gray-light); font-size: 0.9rem; margin-bottom: 16px;">' . sprintf( __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>', 'padelup' ), esc_url( get_edit_user_link() ), $user_identity, esc_url( wp_logout_url( apply_filters( 'the_permalink', get_permalink( get_the_ID() ) ) ) ) ) . '</p>',
    ) );
    ?>

</div>

<?php
/**
 * Custom comment callback
 */
if ( ! function_exists( 'padelup_comment' ) ) {
    function padelup_comment( $comment, $args, $depth ) {
        $tag = ( 'div' === $args['style'] ) ? 'div' : 'li';
        ?>
        <<?php echo $tag; ?> id="comment-<?php comment_ID(); ?>" <?php comment_class( 'comment', $comment ); ?> style="padding: 20px 0; border-bottom: 1px solid #eee;">
            <article class="comment-body" style="display: flex; gap: 16px;">
                <div class="comment-avatar" style="flex-shrink: 0;">
                    <?php echo get_avatar( $comment, $args['avatar_size'] ); ?>
                </div>
                <div class="comment-content" style="flex: 1;">
                    <div class="comment-meta" style="margin-bottom: 8px; font-size: 0.85rem; color: var(--color-gray-light);">
                        <span class="comment-author" style="font-weight: 700; color: var(--color-dark);"><?php echo get_comment_author_link(); ?></span>
                        <span style="margin: 0 8px;">·</span>
                        <time datetime="<?php comment_time( 'c' ); ?>"><?php echo get_comment_date(); ?></time>
                    </div>
                    <div class="comment-text" style="font-size: 0.95rem; line-height: 1.7; color: var(--color-gray);">
                        <?php comment_text(); ?>
                    </div>
                    <?php if ( '0' === $comment->comment_approved ) : ?>
                        <p class="comment-awaiting-moderation" style="color: var(--color-gray-light); font-size: 0.85rem; font-style: italic; margin-top: 8px;"><?php _e( 'Your comment is awaiting moderation.', 'padelup' ); ?></p>
                    <?php endif; ?>
                    <?php
                    comment_reply_link( array_merge( $args, array(
                        'reply_text' => __( 'Reply', 'padelup' ),
                        'depth'      => $depth,
                        'max_depth'  => $args['max_depth'],
                    ) ) );
                    ?>
                </div>
            </article>
        <?php
    }
}
