<?php
/**
 * PadelUp Theme Functions
 *
 * @package PadelUp
 * @version 1.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'PADELUP_VERSION', '1.3.0' );
define( 'PADELUP_DIR', get_template_directory() );
define( 'PADELUP_URI', get_template_directory_uri() );

if ( file_exists( PADELUP_DIR . '/inc/customizer.php' ) ) {
    require_once PADELUP_DIR . '/inc/customizer.php';
}

if ( file_exists( PADELUP_DIR . '/inc/template-functions.php' ) ) {
    require_once PADELUP_DIR . '/inc/template-functions.php';
}

if ( file_exists( PADELUP_DIR . '/inc/elementor.php' ) ) {
    require_once PADELUP_DIR . '/inc/elementor.php';
}

/**
 * Theme Setup
 */
function padelup_setup() {
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'html5', array(
        'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script',
    ) );
    add_theme_support( 'customize-selective-refresh-widgets' );
    add_theme_support( 'custom-logo', array(
        'height'      => 60,
        'width'       => 200,
        'flex-height' => true,
        'flex-width'  => true,
    ) );

    add_image_size( 'padelup-product', 400, 400, true );
    add_image_size( 'padelup-category', 600, 600, true );
    add_image_size( 'padelup-hero', 1200, 600, true );
    add_image_size( 'padelup-instagram', 400, 400, true );

    register_nav_menus( array(
        'primary' => __( 'Основное меню', 'padelup' ),
        'footer'  => __( 'Подвал меню', 'padelup' ),
    ) );

    load_theme_textdomain( 'padelup', PADELUP_DIR . '/languages' );
}
add_action( 'after_setup_theme', 'padelup_setup' );

/**
 * Enqueue Styles & Scripts
 */
function padelup_scripts() {
    wp_enqueue_style( 'padelup-style', get_stylesheet_uri(), array(), PADELUP_VERSION );
    wp_enqueue_style( 'padelup-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap', array(), null );
    wp_enqueue_script( 'padelup-main', PADELUP_URI . '/js/main.js', array(), PADELUP_VERSION, true );
    wp_localize_script( 'padelup-main', 'padelupData', array(
        'ajaxurl'      => admin_url( 'admin-ajax.php' ),
        'nonce'        => wp_create_nonce( 'padelup_nonce' ),
        'accountUrl'   => function_exists( 'wc_get_page_permalink' ) ? esc_url( wc_get_page_permalink( 'myaccount' ) ) : '',
        'wishlistUrl'  => esc_url( home_url( '/izbrannoe/' ) ),
        'shopUrl'      => function_exists( 'wc_get_page_permalink' ) ? esc_url( wc_get_page_permalink( 'shop' ) ) : '',
    ) );
}
add_action( 'wp_enqueue_scripts', 'padelup_scripts' );

/**
 * Widgets Registration
 */
function padelup_widgets_init() {
    register_sidebar( array(
        'name'          => __( 'Боковая колонка', 'padelup' ),
        'id'            => 'sidebar-1',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );

    register_sidebar( array(
        'name'          => __( 'Футер - Колонка 1', 'padelup' ),
        'id'            => 'footer-1',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ) );

    register_sidebar( array(
        'name'          => __( 'Футер - Колонка 2', 'padelup' ),
        'id'            => 'footer-2',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ) );

    register_sidebar( array(
        'name'          => __( 'Футер - Колонка 3', 'padelup' ),
        'id'            => 'footer-3',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ) );
}
add_action( 'widgets_init', 'padelup_widgets_init' );

/**
 * WooCommerce Support
 */
function padelup_woocommerce_support() {
    if ( ! class_exists( 'WooCommerce' ) ) {
        return;
    }
    add_theme_support( 'woocommerce', array(
        'thumbnail_image_width'    => 400,
        'gallery_thumbnail_image_width' => 300,
        'single_image_width'       => 600,
        'product_grid'             => array(
            'default_rows'    => 3,
            'min_rows'        => 1,
            'default_columns' => 4,
            'min_columns'     => 1,
            'max_columns'     => 6,
        ),
    ) );
    add_theme_support( 'wc-product-gallery-zoom' );
    add_theme_support( 'wc-product-gallery-lightbox' );
    add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'padelup_woocommerce_support' );

/**
 * WooCommerce Product Loop
 */
function padelup_loop_columns() {
    return 4;
}
add_filter( 'loop_shop_columns', 'padelup_loop_columns' );

function padelup_loop_wrapper_start() {
    echo '<div class="products__grid">';
}
add_action( 'woocommerce_before_shop_loop', 'padelup_loop_wrapper_start', 5 );

function padelup_loop_wrapper_end() {
    echo '</div>';
}
add_action( 'woocommerce_after_shop_loop', 'padelup_loop_wrapper_end', 5 );

/**
 * Custom Product Card
 */
function padelup_custom_add_to_cart_loop_button() {
    global $product;
    if ( ! $product ) {
        return;
    }
    echo '<button type="submit" name="add-to-cart" value="' . esc_attr( $product->get_id() ) . '" class="product-card__cart-btn">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="9" cy="21" r="1"></circle>
            <circle cx="20" cy="21" r="1"></circle>
            <path d="m1 1 4 0 2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
        </svg>
    </button>';
}
add_action( 'woocommerce_after_shop_loop_item', 'padelup_custom_add_to_cart_loop_button', 20 );

/**
 * Custom Product Card Layout
 */
if ( function_exists( 'WC' ) ) {
    remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
    remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
    remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
    remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
    remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
    remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
}

function padelup_loop_product_image() {
    global $product;
    ?>
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
        <button class="product-card__wishlist" aria-label="В избранное">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"></path>
            </svg>
        </button>
    </div>
    <?php
}
add_action( 'woocommerce_before_shop_loop_item_title', 'padelup_loop_product_image', 5 );

function padelup_loop_product_title() {
    global $product;
    if ( ! $product ) {
        return;
    }
    $brand = get_the_terms( $product->get_id(), 'product_brand' );
    ?>
    <div class="product-card__info">
        <?php if ( $brand && ! is_wp_error( $brand ) ) : ?>
            <div class="product-card__brand"><?php echo esc_html( $brand[0]->name ); ?></div>
        <?php endif; ?>
        <h3 class="product-card__name">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h3>
        <div class="product-card__bottom">
            <div class="product-card__price">
                <?php echo wp_kses_post( $product->get_price_html() ); ?>
            </div>
            <?php padelup_custom_add_to_cart_loop_button(); ?>
        </div>
    </div>
    <?php
}
add_action( 'woocommerce_after_shop_loop_item_title', 'padelup_loop_product_title', 5 );

// Remove default add to cart button wrapper (handled in content-product.php)
// add_action( 'woocommerce_after_shop_loop_item', 'padelup_add_to_cart_button', 1 );

/**
 * Remove Default WooCommerce Styles
 */
function padelup_remove_default_styles() {
    wp_dequeue_style( 'woocommerce-general' );
    wp_dequeue_style( 'woocommerce-layout' );
    wp_dequeue_style( 'woocommerce-smallscreen' );
}
add_action( 'wp_enqueue_scripts', 'padelup_remove_default_styles', 99 );

/**
 * Custom Excerpt Length
 */
function padelup_excerpt_length( $length ) {
    return 20;
}
add_filter( 'excerpt_length', 'padelup_excerpt_length' );

/**
 * Custom Excerpt More
 */
function padelup_excerpt_more( $more ) {
    return '...';
}
add_filter( 'excerpt_more', 'padelup_excerpt_more' );

/**
 * Body Classes
 */
function padelup_body_classes( $classes ) {
    if ( is_singular() ) {
        $classes[] = 'singular';
    }
    if ( is_front_page() ) {
        $classes[] = 'front-page';
    }
    if ( function_exists( 'is_product' ) && is_product() ) {
        $classes[] = 'single-product';
    }
    if ( function_exists( 'is_shop' ) && is_shop() ) {
        $classes[] = 'shop-page';
    }
    if ( function_exists( 'padelup_is_elementor' ) && padelup_is_elementor() ) {
        $classes[] = 'padelup-elementor-active';
    }
    return $classes;
}
add_filter( 'body_class', 'padelup_body_classes' );

/**
 * AJAX Add to Cart
 */
function padelup_ajax_add_to_cart() {
    if ( ! function_exists( 'WC' ) || ! WC()->cart ) {
        wp_send_json_error( array( 'message' => 'WooCommerce not available' ) );
    }

    check_ajax_referer( 'padelup_nonce', 'nonce' );

    $product_id = isset( $_POST['product_id'] ) ? absint( $_POST['product_id'] ) : 0;
    $quantity   = isset( $_POST['quantity'] ) ? absint( $_POST['quantity'] ) : 1;

    if ( $product_id > 0 ) {
        $cart_item_key = WC()->cart->add_to_cart( $product_id, $quantity );
        if ( $cart_item_key ) {
            wp_send_json_success( array(
                'fragments' => apply_filters( 'woocommerce_add_to_cart_fragments', array() ),
                'cart_hash' => WC()->cart->get_cart_contents_hash(),
                'count'     => WC()->cart->get_cart_contents_count(),
            ) );
        }
    }

    wp_send_json_error( array( 'message' => 'Could not add product to cart' ) );
}
add_action( 'wp_ajax_padelup_add_to_cart', 'padelup_ajax_add_to_cart' );
add_action( 'wp_ajax_nopriv_padelup_add_to_cart', 'padelup_ajax_add_to_cart' );

/**
 * Get product brands
 */
function padelup_get_product_brands() {
    if ( ! function_exists( 'WC' ) ) {
        return array();
    }
    $brands = get_terms( array(
        'taxonomy'   => 'product_brand',
        'hide_empty' => false,
    ) );
    return ( $brands && ! is_wp_error( $brands ) ) ? $brands : array();
}

/*
 * NOTE: Removed padelup_force_account_template filter.
 * WooCommerce automatically finds woocommerce/myaccount.php for the My Account page.
 * Forcing it via template_include breaks endpoints (logout, orders, edit-address, etc.).
 */

/**
 * Disable WooCommerce Coming Soon mode
 */
function padelup_disable_coming_soon() {
    if ( class_exists( 'WooCommerce' ) ) {
        if ( 'no' !== get_option( 'woocommerce_coming_soon', 'no' ) ) {
            update_option( 'woocommerce_coming_soon', 'no' );
        }
    }
}
add_action( 'admin_init', 'padelup_disable_coming_soon' );

/**
 * Enable WooCommerce registration on My Account page
 */
function padelup_enable_registration() {
    if ( class_exists( 'WooCommerce' ) ) {
        if ( 'yes' !== get_option( 'woocommerce_enable_myaccount_registration' ) ) {
            update_option( 'woocommerce_enable_myaccount_registration', 'yes' );
        }
        if ( 'yes' !== get_option( 'woocommerce_generate_username_from_email' ) ) {
            update_option( 'woocommerce_generate_username_from_email', 'yes' );
        }
    }
}
add_action( 'admin_init', 'padelup_enable_registration' );

/**
 * Auto-create Wishlist page (runs once)
 */
function padelup_create_wishlist_page() {
    if ( get_transient( 'padelup_wishlist_page_check' ) ) {
        return;
    }
    $page = get_page_by_path( 'izbrannoe', OBJECT, 'page' );
    if ( ! $page ) {
        $page_id = wp_insert_post( array(
            'post_title'   => 'Избранное',
            'post_name'    => 'izbrannoe',
            'post_status'  => 'publish',
            'post_type'    => 'page',
            'page_template' => 'page-wishlist.php',
        ) );
    }
    set_transient( 'padelup_wishlist_page_check', true, DAY_IN_SECONDS );
}
add_action( 'init', 'padelup_create_wishlist_page' );

