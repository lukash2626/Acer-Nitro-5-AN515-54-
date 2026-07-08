<?php
/**
 * PadelUp Theme - Template Functions
 *
 * @package PadelUp
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Custom product thumbnail for category pages
 */
function padelup_category_thumbnail( $term ) {
    $thumbnail_id = get_term_meta( $term->term_id, 'thumbnail_id', true );
    if ( $thumbnail_id ) {
        $image = wp_get_attachment_image_url( $thumbnail_id, 'padelup-category' );
        if ( $image ) {
            return '<img src="' . esc_url( $image ) . '" alt="' . esc_attr( $term->name ) . '" class="category-card__image">';
        }
    }
    return '<img src="' . esc_url( wc_placeholder_img_src() ) . '" alt="' . esc_attr( $term->name ) . '" class="category-card__image">';
}

/**
 * Add custom product badges
 */
function padelup_product_badges() {
    global $product;

    $badges = array();

    if ( $product->is_on_sale() ) {
        $badges[] = '<div class="product-badge product-badge--sale">SALE</div>';
    }

    $days_new = apply_filters( 'padelup_days_new', 30 );
    $published = strtotime( $product->get_date_created() );
    if ( $published && ( time() - $published ) < ( $days_new * DAY_IN_SECONDS ) ) {
        $badges[] = '<div class="product-badge product-badge--new">NEW</div>';
    }

    if ( ! empty( $badges ) ) {
        echo '<div class="product-badges">' . implode( '', $badges ) . '</div>';
    }
}

/**
 * Custom product tabs
 */
function padelup_custom_product_tabs( $tabs ) {
    $tabs['specifications'] = array(
        'title'    => __( 'Характеристики', 'padelup' ),
        'priority' => 15,
        'callback' => 'padelup_product_specifications_tab',
    );

    return $tabs;
}
add_filter( 'woocommerce_product_tabs', 'padelup_custom_product_tabs' );

function padelup_product_specifications_tab() {
    global $product;

    $attributes = $product->get_attributes();

    if ( empty( $attributes ) ) {
        echo '<p>' . __( 'Характеристики не указаны', 'padelup' ) . '</p>';
        return;
    }

    echo '<table class="woocommerce-product-attributes" style="width: 100%; border-collapse: collapse;">';

    foreach ( $attributes as $attribute ) {
        $name = wc_attribute_label( $attribute->get_name() );
        $values = $attribute->get_options();

        if ( $attribute->is_taxonomy() ) {
            $terms = wp_get_post_terms( $product->get_id(), $attribute->get_name() );
            $values = wp_list_pluck( $terms, 'name' );
        }

        echo '<tr style="border-bottom: 1px solid #eee;">';
        echo '<th style="padding: 12px 0; font-weight: 600; width: 30%;">' . esc_html( $name ) . '</th>';
        echo '<td style="padding: 12px 0;">' . esc_html( implode( ', ', $values ) ) . '</td>';
        echo '</tr>';
    }

    echo '</table>';
}

/**
 * Add wishlist functionality (moved to content-single-product.php template)
 * Kept for backwards compatibility but not hooked.
 */
/*
function padelup_add_to_wishlist() {
    if ( ! is_user_logged_in() ) {
        return;
    }

    global $product;

    $user_id = get_current_user_id();
    $product_id = $product->get_id();
    $wishlist = get_user_meta( $user_id, 'padelup_wishlist', true );

    if ( ! is_array( $wishlist ) ) {
        $wishlist = array();
    }

    $is_in_wishlist = in_array( $product_id, $wishlist );

    ?>
    <button class="btn <?php echo $is_in_wishlist ? 'btn--dark' : 'btn--outline'; ?> product-wishlist-btn"
            data-product-id="<?php echo esc_attr( $product_id ); ?>"
            style="margin-top: 16px; width: 100%;">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
             fill="<?php echo $is_in_wishlist ? 'currentColor' : 'none'; ?>"
             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"></path>
        </svg>
        <?php echo $is_in_wishlist ? __( 'В избранном', 'padelup' ) : __( 'В избранное', 'padelup' ); ?>
    </button>
    <?php
}
*/

/**
 * AJAX wishlist toggle
 */
function padelup_toggle_wishlist() {
    check_ajax_referer( 'padelup_nonce', 'nonce' );

    if ( ! is_user_logged_in() ) {
        wp_send_json_error( array( 'message' => __( 'Войдите, чтобы добавить в избранное', 'padelup' ) ) );
    }

    $product_id = isset( $_POST['product_id'] ) ? absint( $_POST['product_id'] ) : 0;
    $user_id = get_current_user_id();
    $wishlist = get_user_meta( $user_id, 'padelup_wishlist', true );

    if ( ! is_array( $wishlist ) ) {
        $wishlist = array();
    }

    $index = array_search( $product_id, $wishlist );
    if ( false !== $index ) {
        unset( $wishlist[ $index ] );
        $in_wishlist = false;
    } else {
        $wishlist[] = $product_id;
        $in_wishlist = true;
    }

    update_user_meta( $user_id, 'padelup_wishlist', $wishlist );

    wp_send_json_success( array(
        'in_wishlist' => $in_wishlist,
        'count'       => count( $wishlist ),
    ) );
}
add_action( 'wp_ajax_padelup_toggle_wishlist', 'padelup_toggle_wishlist' );
add_action( 'wp_ajax_nopriv_padelup_toggle_wishlist', 'padelup_toggle_wishlist' );