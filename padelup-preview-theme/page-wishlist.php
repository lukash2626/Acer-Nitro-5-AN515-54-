<?php
/**
 * Template Name: Избранное
 * Template Post Type: page
 *
 * @package PadelUp
 */

get_header();
?>

<main class="main">
    <div class="container" style="padding: 40px 20px; max-width: 1200px; margin: 0 auto;">
        <h1 style="font-size: 2rem; font-weight: 800; margin-bottom: 30px;">Избранное</h1>

        <?php if ( ! is_user_logged_in() ) : ?>
            <div style="text-align: center; padding: 80px 0;">
                <p style="font-size: 1.1rem; color: var(--color-gray-light); margin-bottom: 24px;">Войдите, чтобы видеть избранные товары</p>
                <a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="btn btn--primary">Войти</a>
            </div>
        <?php else : ?>
            <?php
            $user_id = get_current_user_id();
            $wishlist = get_user_meta( $user_id, 'padelup_wishlist', true );
            if ( ! is_array( $wishlist ) ) {
                $wishlist = array();
            }

            if ( empty( $wishlist ) ) :
            ?>
                <div style="text-align: center; padding: 80px 0;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#ccc" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom: 16px;">
                        <path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"></path>
                    </svg>
                    <p style="font-size: 1.1rem; color: var(--color-gray-light); margin-bottom: 24px;">Список избранного пуст</p>
                    <a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="btn btn--primary">Перейти в каталог</a>
                </div>
            <?php else : ?>
                <?php
                $products = new WP_Query( array(
                    'post_type'      => 'product',
                    'post__in'       => $wishlist,
                    'posts_per_page' => -1,
                    'post_status'    => 'publish',
                ) );

                if ( $products->have_posts() ) :
                ?>
                    <div class="products__grid">
                        <?php
                        while ( $products->have_posts() ) {
                            $products->the_post();
                            wc_get_template_part( 'content', 'product' );
                        }
                        wp_reset_postdata();
                        ?>
                    </div>
                <?php else : ?>
                    <div style="text-align: center; padding: 80px 0;">
                        <p style="font-size: 1.1rem; color: var(--color-gray-light);">Избранные товары больше не доступны</p>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</main>

<?php get_footer(); ?>
