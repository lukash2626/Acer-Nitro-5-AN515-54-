<?php
/**
 * WooCommerce Single Product Content Template
 *
 * @package PadelUp
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( empty( $product ) ) {
    return;
}
?>

<div <?php wc_product_class( 'product', $product ); ?>>
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 60px; align-items: start;">
        <div class="product-images">
            <?php
            do_action( 'woocommerce_before_single_product_summary' );

            if ( post_password_required() ) {
                echo get_the_password_form();
                return;
            }
            ?>
        </div>

        <div class="summary entry-summary" style="padding: 20px 0;">
            <?php
            do_action( 'woocommerce_single_product_summary' );
            ?>
            <?php
            $in_wishlist = false;
            if ( is_user_logged_in() ) {
                $user_wishlist = get_user_meta( get_current_user_id(), 'padelup_wishlist', true );
                if ( is_array( $user_wishlist ) ) {
                    $in_wishlist = in_array( $product->get_id(), $user_wishlist );
                }
            }
            ?>
            <button type="button" class="single-product__wishlist<?php echo $in_wishlist ? ' active' : ''; ?>" data-product-id="<?php echo esc_attr( $product->get_id() ); ?>">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="<?php echo $in_wishlist ? 'currentColor' : 'none'; ?>" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"></path>
                </svg>
                <span><?php echo $in_wishlist ? 'В избранном' : 'В избранное'; ?></span>
            </button>
        </div>
    </div>

    <div style="margin-top: 60px;">
        <?php
        do_action( 'woocommerce_after_single_product_summary' );
        ?>
    </div>
</div>

<?php do_action( 'woocommerce_after_single_product' ); ?>