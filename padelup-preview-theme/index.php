<?php
/**
 * Main Template
 *
 * @package PadelUp
 */

get_header();
?>

<main class="main">
    <div class="container" style="padding: 40px 20px;">
        <?php if ( have_posts() ) : ?>
            <div class="section-title" style="margin-bottom: 40px;">
                <h2 class="section-title__text">
                    <?php
                    if ( is_search() ) {
                        printf( 'Результаты поиска: %s', get_search_query() );
                    } elseif ( is_category() ) {
                        single_cat_title();
                    } elseif ( is_tag() ) {
                        single_tag_title();
                    } elseif ( is_author() ) {
                        printf( 'Автор: %s', get_the_author() );
                    } elseif ( is_archive() ) {
                        the_archive_title();
                    } else {
                        echo 'Блог';
                    }
                    ?>
                </h2>
            </div>
            <div class="posts-grid">
                <?php while ( have_posts() ) : the_post(); ?>
                    <article class="post-card">
                        <?php if ( has_post_thumbnail() ) : ?>
                            <a href="<?php the_permalink(); ?>" class="post-card__image">
                                <?php the_post_thumbnail( 'medium_large' ); ?>
                            </a>
                        <?php endif; ?>
                        <div class="post-card__content">
                            <div class="post-card__meta">
                                <span><?php echo get_the_date(); ?></span>
                                <span>·</span>
                                <span><?php the_category( ', ' ); ?></span>
                            </div>
                            <h3 class="post-card__title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h3>
                            <p class="post-card__excerpt"><?php echo wp_trim_words( get_the_excerpt(), 20 ); ?></p>
                            <a href="<?php the_permalink(); ?>" class="section-title__link">Читать далее →</a>
                        </div>
                    </article>
                <?php endwhile; ?>
            </div>

            <div class="pagination">
                <?php
                the_posts_pagination( array(
                    'mid_size'  => 2,
                    'prev_text' => '←',
                    'next_text' => '→',
                ) );
                ?>
            </div>
        <?php else : ?>
            <div style="text-align: center; padding: 80px 0;">
                <h2 style="font-size: 2rem; font-weight: 800; margin-bottom: 16px;">Ничего не найдено</h2>
                <p style="color: var(--color-gray-light); margin-bottom: 30px;">По вашему запросу ничего не найдено. Попробуйте изменить параметры поиска.</p>
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn--primary">На главную</a>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php get_footer(); ?>