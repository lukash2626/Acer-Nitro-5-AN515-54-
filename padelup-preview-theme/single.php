<?php
/**
 * Single Post Template
 *
 * @package PadelUp
 */

get_header();
?>

<main class="main">
    <div class="container" style="padding: 40px 20px; max-width: 800px;">
        <?php while ( have_posts() ) : the_post(); ?>
            <article class="single-post">
                <div class="post-meta" style="font-size: 0.85rem; color: var(--color-gray-light); margin-bottom: 16px;">
                    <span><?php echo get_the_date(); ?></span>
                    <span style="margin: 0 8px;">·</span>
                    <span><?php the_category( ', ' ); ?></span>
                </div>

                <h1 class="single-post__title" style="font-size: 2.2rem; font-weight: 800; margin-bottom: 30px; line-height: 1.2;">
                    <?php the_title(); ?>
                </h1>

                <?php if ( has_post_thumbnail() ) : ?>
                    <div class="single-post__image" style="margin-bottom: 30px; border-radius: 12px; overflow: hidden;">
                        <?php the_post_thumbnail( 'large' ); ?>
                    </div>
                <?php endif; ?>

                <div class="single-post__content" style="line-height: 1.8; font-size: 1.05rem;">
                    <?php the_content(); ?>
                </div>

                <div class="single-post__tags" style="margin-top: 40px; padding-top: 20px; border-top: 1px solid #eee;">
                    <?php the_tags( '<span style="font-weight: 600;">Теги:</span> ', ', ' ); ?>
                </div>

                <div class="single-post__nav" style="display: flex; justify-content: space-between; margin-top: 40px;">
                    <?php
                    $prev = get_previous_post();
                    $next = get_next_post();
                    ?>
                    <?php if ( $prev ) : ?>
                        <a href="<?php echo esc_url( get_permalink( $prev ) ); ?>" style="font-weight: 600;">
                            ← <?php echo esc_html( get_the_title( $prev ) ); ?>
                        </a>
                    <?php endif; ?>
                    <?php if ( $next ) : ?>
                        <a href="<?php echo esc_url( get_permalink( $next ) ); ?>" style="font-weight: 600; margin-left: auto;">
                            <?php echo esc_html( get_the_title( $next ) ); ?> →
                        </a>
                    <?php endif; ?>
                </div>
            </article>

            <?php if ( comments_open() || get_comments_number() ) : ?>
                <div style="margin-top: 60px;">
                    <?php comments_template(); ?>
                </div>
            <?php endif; ?>
        <?php endwhile; ?>
    </div>
</main>

<?php get_footer(); ?>