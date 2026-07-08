<?php
/**
 * WooCommerce Product Content Template
 *
 * @package PadelUp
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( empty( $product ) || ! $product->is_visible() ) {
    return;
}
?>

<li <?php wc_product_class( 'product-card', $product ); ?>>
    <div class="product-card__image-wrapper">
        <a href="<?php the_permalink(); ?>">
            <?php
            if ( has_post_thumbnail() ) {
                the_post_thumbnail( 'padelup-product', array( 'class' => 'product-card__image' ) );
            } else {
                wc_placeholder_img( 'padelup-product', array( 'class' => 'product-card__image' ) );
            }
            ?>
        </a>
        <?php if ( $product->is_on_sale() ) : ?>
            <div class="category-card__badge" style="position: absolute; top: 12px; left: 12px;">
                <?php echo esc_html( 'SALE' ); ?>
            </div>
        <?php endif; ?>
        <?php
        $wl_active = false;
        if ( is_user_logged_in() ) {
            $wl = get_user_meta( get_current_user_id(), 'padelup_wishlist', true );
            if ( is_array( $wl ) ) {
                $wl_active = in_array( $product->get_id(), $wl );
            }
        }
        ?>
        <button class="product-card__wishlist<?php echo $wl_active ? ' active' : ''; ?>" data-product-id="<?php echo esc_attr( $product->get_id() ); ?>" aria-label="В избранное">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="<?php echo $wl_active ? 'var(--color-primary)' : 'none'; ?>" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"></path>
            </svg>
        </button>
    </div>

    <div class="product-card__info">
        <?php
        $brands = get_the_terms( $product->get_id(), 'product_brand' );
        if ( $brands && ! is_wp_error( $brands ) ) :
        ?>
            <div class="product-card__brand"><?php echo esc_html( $brands[0]->name ); ?></div>
        <?php endif; ?>

        <h3 class="product-card__name">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h3>

        <div class="product-card__bottom">
            <div class="product-card__price">
                <?php echo $product->get_price_html(); ?>
            </div>
            <button type="button" class="product-card__cart-btn" data-product-id="<?php echo esc_attr( $product->get_id() ); ?>">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="9" cy="21" r="1"></circle>
                    <circle cx="20" cy="21" r="1"></circle>
                    <path d="m1 1 4 0 2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                </svg>
            </button>
        </div>
    </div>
</li>