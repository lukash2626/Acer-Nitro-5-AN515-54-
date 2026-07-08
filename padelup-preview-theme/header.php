<?php
/**
 * Header Template
 *
 * @package PadelUp
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div class="topbar">
    <div class="container">
        <div class="topbar__info">
            <span>Бесплатная доставка от 10 000 ₽</span>
            <span>Оригинальная продукция</span>
            <span>Доставка по всей России</span>
        </div>
        <div class="topbar__links">
            <a href="<?php echo esc_url( home_url( '/about/' ) ); ?>">О нас</a>
            <a href="<?php echo esc_url( home_url( '/contacts/' ) ); ?>">Контакты</a>
            <span class="topbar__lang">RUS ▾</span>
        </div>
    </div>
</div>

<header class="header" id="header">
    <div class="container">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="header__logo">
            <?php if ( has_custom_logo() ) : ?>
                <?php the_custom_logo(); ?>
            <?php else : ?>
                Padel<span>Up</span>
            <?php endif; ?>
        </a>

        <nav class="header__nav">
            <?php
            wp_nav_menu( array(
                'theme_location' => 'primary',
                'container'      => false,
                'menu_class'     => 'header__nav-list',
                'fallback_cb'    => 'padelup_fallback_menu',
                'depth'          => 1,
            ) );
            ?>
        </nav>

        <div class="header__actions">
            <button class="header__action-btn" aria-label="Поиск" id="search-toggle">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"></circle>
                    <path d="m21 21-4.3-4.3"></path>
                </svg>
            </button>
            <a href="<?php echo esc_url( is_user_logged_in() ? ( function_exists( 'wc_get_account_endpoint_url' ) ? wc_get_account_endpoint_url( 'dashboard' ) : home_url( '/moj-akkaunt/' ) ) : ( function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'myaccount' ) : wp_login_url() ) ); ?>" class="header__action-btn" aria-label="<?php echo is_user_logged_in() ? esc_attr__( 'Аккаунт', 'padelup' ) : esc_attr__( 'Войти / Регистрация', 'padelup' ); ?>">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                </svg>
            </a>
            <a href="<?php echo esc_url( home_url( '/izbrannoe/' ) ); ?>" class="header__action-btn" id="header-wishlist" aria-label="Избранное">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"></path>
                </svg>
                <?php if ( is_user_logged_in() ) :
                    $wl = get_user_meta( get_current_user_id(), 'padelup_wishlist', true );
                    $wl_count = is_array( $wl ) ? count( $wl ) : 0;
                    if ( $wl_count > 0 ) : ?>
                        <span class="header__wishlist-count"><?php echo esc_html( $wl_count ); ?></span>
                    <?php endif;
                endif; ?>
            </a>
            <a href="<?php echo esc_url( function_exists( 'wc_get_cart_url' ) ? wc_get_cart_url() : '#' ); ?>" class="header__action-btn" aria-label="Корзина">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="8" cy="21" r="1"></circle>
                    <circle cx="19" cy="21" r="1"></circle>
                    <path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"></path>
                </svg>
                <?php if ( function_exists( 'WC' ) && WC()->cart && WC()->cart->get_cart_contents_count() > 0 ) : ?>
                    <span class="header__cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
                <?php endif; ?>
            </a>
            <button class="header__action-btn mobile-menu-toggle" aria-label="Меню" id="mobile-menu-toggle">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="4" x2="20" y1="12" y2="12"></line>
                    <line x1="4" x2="20" y1="6" y2="6"></line>
                    <line x1="4" x2="20" y1="18" y2="18"></line>
                </svg>
            </button>
        </div>
    </div>
</header>

<div class="mobile-menu" id="mobile-menu">
    <div class="mobile-menu__header">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="header__logo">Padel<span>Up</span></a>
        <button class="mobile-menu__close" id="mobile-menu-close" aria-label="<?php esc_attr_e( 'Закрыть меню', 'padelup' ); ?>">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M18 6 6 18"></path>
                <path d="m6 6 12 12"></path>
            </svg>
        </button>
    </div>
    <nav class="mobile-menu__nav">
        <?php
        wp_nav_menu( array(
            'theme_location' => 'primary',
            'container'      => false,
            'menu_class'     => '',
            'fallback_cb'    => 'padelup_fallback_menu',
            'depth'          => 1,
        ) );
        ?>
    </nav>
</div>

<?php
/**
 * Fallback menu when no menu is assigned
 */
if ( ! function_exists( 'padelup_fallback_menu' ) ) {
    function padelup_fallback_menu() {
    $shop_url = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/shop/' );
    echo '<ul class="header__nav-list">';
    echo '<li><a href="' . esc_url( home_url( '/' ) ) . '">Главная</a></li>';
    echo '<li><a href="' . esc_url( $shop_url ) . '">Каталог</a></li>';
    echo '<li><a href="#">Новинки</a></li>';
    echo '<li><a href="#">Ракетки</a></li>';
    echo '<li><a href="#">Одежда</a></li>';
    echo '<li><a href="#">Обувь</a></li>';
    echo '<li><a href="#">Аксессуары</a></li>';
    echo '</ul>';
    }
}