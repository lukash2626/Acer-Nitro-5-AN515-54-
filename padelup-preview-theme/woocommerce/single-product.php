<?php
/**
 * WooCommerce Single Product Template
 *
 * @package PadelUp
 */

get_header();
?>

<main class="main">
    <div class="container" style="padding: 40px 20px;">
        <?php while ( have_posts() ) : the_post(); ?>
            <?php wc_get_template_part( 'content', 'single-product' ); ?>
        <?php endwhile; ?>

        <?php
        /**
         * Related Products
         */
        $related_ids = wc_get_related_products( get_the_ID(), 6 );

        if ( $related_ids ) :
            $related_query = new WP_Query( array(
                'post_type'      => 'product',
                'post__in'       => $related_ids,
                'posts_per_page' => 6,
                'orderby'        => 'rand',
            ) );

            if ( $related_query->have_posts() ) :
        ?>
            <section class="products-section" style="margin-top: 60px; padding-top: 40px; border-top: 1px solid #eee;">
                <div class="section-title">
                    <h2 class="section-title__text">Похожие товары</h2>
                </div>
                <div class="products__grid">
                    <?php
                    while ( $related_query->have_posts() ) {
                        $related_query->the_post();
                        wc_get_template_part( 'content', 'product' );
                    }
                    wp_reset_postdata();
                    ?>
                </div>
            </section>
        <?php
            endif;
        endif;
        ?>
    </div>
</main>

<?php get_footer(); ?>