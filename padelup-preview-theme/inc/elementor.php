<?php
/**
 * Elementor Integration for PadelUp Theme
 *
 * @package PadelUp
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Check if Elementor is active
 */
function padelup_is_elementor() {
    return did_action( 'elementor/loaded' );
}

/**
 * Check if current page is built with Elementor
 */
function padelup_is_elementor_page() {
    if ( ! padelup_is_elementor() ) {
        return false;
    }

    if ( ! class_exists( '\Elementor\Plugin' ) ) {
        return false;
    }

    $post_id = get_the_ID();
    if ( ! $post_id ) {
        return false;
    }

    return \Elementor\Plugin::$instance->db->is_built_with_elementor( $post_id );
}

/**
 * Add Elementor Theme Locations
 */
function padelup_elementor_locations( $manager ) {
    if ( method_exists( $manager, 'register_all_core_locations' ) ) {
        $manager->register_all_core_locations();
    }
}
add_action( 'elementor/theme/register_locations', 'padelup_elementor_locations' );

/**
 * Register Elementor Category
 */
function padelup_elementor_category( $elements_manager ) {
    $elements_manager->add_category(
        'padelup',
        array(
            'title' => __( 'PadelUp', 'padelup' ),
            'icon'  => 'eicon-cart',
        )
    );
}
add_action( 'elementor/elements/categories_registered', 'padelup_elementor_category' );

/**
 * Register Custom Elementor Widgets
 */
function padelup_elementor_widgets( $widgets_manager ) {
    $widget_dir = PADELUP_DIR . '/inc/elementor/widgets';

    $widgets = array(
        'class-padelup-hero-widget.php'      => 'PadelUp_Hero_Widget',
        'class-padelup-products-widget.php'  => 'PadelUp_Products_Widget',
        'class-padelup-categories-widget.php'=> 'PadelUp_Categories_Widget',
        'class-padelup-brands-widget.php'    => 'PadelUp_Brands_Widget',
        'class-padelup-benefits-widget.php'  => 'PadelUp_Benefits_Widget',
        'class-padelup-newsletter-widget.php'=> 'PadelUp_Newsletter_Widget',
        'class-padelup-instagram-widget.php' => 'PadelUp_Instagram_Widget',
        'class-padelup-promo-widget.php'     => 'PadelUp_Promo_Widget',
    );

    foreach ( $widgets as $file => $class ) {
        $filepath = $widget_dir . '/' . $file;
        if ( file_exists( $filepath ) ) {
            require_once $filepath;
            if ( class_exists( $class ) ) {
                $widgets_manager->register( new $class() );
            }
        }
    }
}
add_action( 'elementor/widgets/register', 'padelup_elementor_widgets' );

/**
 * Enqueue Elementor styles
 */
function padelup_elementor_styles() {
    if ( padelup_is_elementor() ) {
        wp_enqueue_style( 'padelup-elementor', PADELUP_URI . '/css/elementor.css', array(), PADELUP_VERSION );
    }
}
add_action( 'wp_enqueue_scripts', 'padelup_elementor_styles', 20 );

/**
 * Add Elementor content width
 */
function padelup_elementor_content_width() {
    if ( padelup_is_elementor() ) {
        return 1280;
    }
}
add_filter( 'elementor/content_width', 'padelup_elementor_content_width' );

/**
 * Elementor icons
 */
function padelup_elementor_icon_manager( $icon_manager ) {
    $icon_manager->register( array(
        'padelup-cart' => array(
            'name'  => 'padelup-cart',
            'label' => __( 'Cart', 'padelup' ),
            'svg'   => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zM1 2v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25l.03-.12.9-1.63h7.45c.75 0 1.41-.41 1.75-1.03l3.58-6.49c.08-.14.12-.31.12-.48 0-.55-.45-1-1-1H5.21l-.94-2H1zm16 16c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z"/></svg>',
        ),
        'padelup-heart' => array(
            'name'  => 'padelup-heart',
            'label' => __( 'Heart', 'padelup' ),
            'svg'   => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>',
        ),
        'padelup-shield' => array(
            'name'  => 'padelup-shield',
            'label' => __( 'Shield', 'padelup' ),
            'svg'   => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm-2 16l-4-4 1.41-1.41L10 14.17l6.59-6.59L18 9l-8 8z"/></svg>',
        ),
    ) );
}
add_action( 'elementor/icons_manager/render', 'padelup_elementor_icon_manager' );