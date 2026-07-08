<?php
/**
 * WooCommerce Product Loop Image Template
 *
 * @package PadelUp
 */

defined( 'ABSPATH' ) || exit;

global $product;

$placeholder = apply_filters( 'woocommerce_placeholder_image_src',
    wc_placeholder_img_src(),
    wc_get_product_placeholder_id()
);
$image_link = get_the_permalink();
$image_title = get_the_title();
$image_alt = get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true );

$image_size = apply_filters( 'woocommerce_gallery_image_size', 'padelup-product' );
$main_image_size = apply_filters( 'woocommerce_gallery_image_size', $image_size );

$attachment_id = get_post_thumbnail_id();
$image_url = $attachment_id ? wp_get_attachment_image_url( $attachment_id, $image_size ) : $placeholder;

echo '<div class="product-card__image-wrapper">';
echo '<a href="' . esc_url( $image_link ) . '">';
echo '<img src="' . esc_url( $image_url ) . '" class="product-card__image" alt="' . esc_attr( $image_alt ) . '" onerror="this.src=\'' . esc_url( $placeholder ) . '\';">';
echo '</a>';
echo '</div>';