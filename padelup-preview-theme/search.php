<?php
/**
 * Search Results Template
 *
 * @package PadelUp
 */

get_header();
?>

<main class="main">
    <div class="container" style="padding: 40px 20px;">
        <div class="section-title" style="margin-bottom: 40px;">
            <h2 class="section-title__text">Результаты поиска: "<?php echo esc_html( get_search_query() ); ?>"</h2>
        </div>

        <?php if ( have_posts() ) : ?>
            <div class="posts-grid" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px;">
                <?php while ( have_posts() ) : the_post(); ?>
                    <article class="post-card" style="border-radius: 12px; overflow: hidden; border: 1px solid #eee;">
                        <?php if ( has_post_thumbnail() ) : ?>
                            <a href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail( 'medium_large', array( 'style' => 'width: 100%; aspect-ratio: 16/9; object-fit: cover;' ) ); ?>
                            </a>
                        <?php endif; ?>
                        <div style="padding: 20px;">
                            <div style="font-size: 0.8rem; color: var(--color-gray-light); margin-bottom: 8px;">
                                <?php echo get_the_date(); ?>
                            </div>
                            <h3 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 8px;">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h3>
                            <p style="font-size: 0.9rem; color: var(--color-text-light); line-height: 1.5;">
                                <?php echo wp_trim_words( get_the_excerpt(), 15 ); ?>
                            </p>
                        </div>
                    </article>
                <?php endwhile; ?>
            </div>

            <div class="pagination" style="margin-top: 40px;">
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
                <h2 style="font-size: 2rem; font-weight: 800; margin-bottom: 16px;">Ничего не найдено по запросу "<?php echo esc_html( get_search_query() ); ?>"</h2>
                <p style="color: var(--color-gray-light); margin-bottom: 30px;">Попробуйте изменить параметры поиска</p>
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn--primary">На главную</a>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php get_footer(); ?>