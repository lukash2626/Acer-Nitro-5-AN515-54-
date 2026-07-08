<?php
/**
 * WooCommerce Shop/Archive Template
 *
 * @package PadelUp
 */

get_header();
?>

<main class="main">
    <div class="container" style="padding: 40px 20px;">
        <?php woocommerce_output_all_notices(); ?>

        <div class="section-title" style="margin-bottom: 40px;">
            <h2 class="section-title__text">
                <?php
                if ( is_product_category() ) {
                    single_cat_title();
                } elseif ( is_product_tag() ) {
                    single_tag_title();
                } else {
                    echo 'Каталог';
                }
                ?>
            </h2>
            <div style="display: flex; align-items: center; gap: 16px;">
                <?php woocommerce_result_count(); ?>
                <?php woocommerce_catalog_ordering(); ?>
            </div>
        </div>

        <?php if ( is_product_category() ) : ?>
            <?php
            $current_category = get_queried_object();
            $subcategories = get_terms( array(
                'taxonomy'   => 'product_cat',
                'parent'     => $current_category->term_id,
                'hide_empty' => false,
            ) );

            if ( ! empty( $subcategories ) && ! is_wp_error( $subcategories ) ) :
            ?>
                <div class="categories__grid" style="margin-bottom: 40px; grid-template-columns: repeat(4, 1fr);">
                    <?php foreach ( $subcategories as $subcat ) : ?>
                        <a href="<?php echo esc_url( get_term_link( $subcat ) ); ?>" class="category-card">
                            <?php
                            $thumb_id = get_term_meta( $subcat->term_id, 'thumbnail_id', true );
                            if ( $thumb_id ) {
                                $image = wp_get_attachment_image_url( $thumb_id, 'padelup-category' );
                                if ( $image ) {
                                    echo '<img src="' . esc_url( $image ) . '" alt="' . esc_attr( $subcat->name ) . '" class="category-card__image">';
                                }
                            }
                            ?>
                            <div class="category-card__overlay">
                                <div class="category-card__title"><?php echo esc_html( $subcat->name ); ?></div>
                                <div class="category-card__link">Смотреть все →</div>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <?php if ( have_posts() ) : ?>
            <div class="products__grid">
                <?php
                while ( have_posts() ) {
                    the_post();
                    wc_get_template_part( 'content', 'product' );
                }
                ?>
            </div>

            <?php woocommerce_pagination(); ?>
        <?php else : ?>
            <div style="text-align: center; padding: 80px 0;">
                <h2 style="font-size: 2rem; font-weight: 800; margin-bottom: 16px;">Товары не найдены</h2>
                <p style="color: var(--color-gray-light); margin-bottom: 30px;">В данной категории пока нет товаров</p>
                <a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="btn btn--primary">Вернуться в каталог</a>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php get_footer(); ?>