<?php
/**
 * WooCommerce Add to Cart Button Template
 *
 * @package PadelUp
 */

defined( 'ABSPATH' ) || exit;

global $product;

echo apply_filters( 'woocommerce_loop_add_to_cart_link',
    sprintf( '<a href="%s" data-product_id="%d" data-quantity="%s" class="button %s product_type_%s %s">%s</a>',
        esc_url( $product->add_to_cart_url() ),
        esc_attr( $product->get_id() ),
        esc_attr( isset( $args['quantity'] ) ? $args['quantity'] : 1 ),
        esc_attr( $product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button ajax_add_to_cart' : '' ),
        esc_attr( $product->get_type() ),
        esc_attr( isset( $args['class'] ) ? $args['class'] : '' ),
        esc_html( $product->add_to_cart_text() )
    ),
$args );