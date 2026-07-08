<?php
/**
 * PadelUp Theme - Customizer Settings
 *
 * @package PadelUp
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function padelup_customize_register( $wp_customize ) {

    // ===== HERO SECTION =====
    $wp_customize->add_section( 'padelup_hero', array(
        'title'    => __( 'Главный баннер', 'padelup' ),
        'priority' => 30,
    ) );

    $wp_customize->add_setting( 'padelup_hero_title', array(
        'default'           => "ИГРАЙ\nЛУЧШЕ.\nПОБЕЖДАЙ.",
        'sanitize_callback' => 'wp_kses_post',
    ) );

    $wp_customize->add_control( 'padelup_hero_title', array(
        'label'   => __( 'Заголовок баннера', 'padelup' ),
        'section' => 'padelup_hero',
        'type'    => 'textarea',
    ) );

    $wp_customize->add_setting( 'padelup_hero_subtitle', array(
        'default'           => 'Премиальная экипировка для падела',
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'padelup_hero_subtitle', array(
        'label'   => __( 'Подзаголовок', 'padelup' ),
        'section' => 'padelup_hero',
        'type'    => 'text',
    ) );

    $wp_customize->add_setting( 'padelup_hero_badge', array(
        'default'           => 'PREMIUM PADEL GEAR',
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'padelup_hero_badge', array(
        'label'   => __( 'Бейдж', 'padelup' ),
        'section' => 'padelup_hero',
        'type'    => 'text',
    ) );

    $wp_customize->add_setting( 'padelup_hero_button_text', array(
        'default'           => 'СМОТРЕТЬ КАТАЛОГ',
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'padelup_hero_button_text', array(
        'label'   => __( 'Текст кнопки', 'padelup' ),
        'section' => 'padelup_hero',
        'type'    => 'text',
    ) );

    $wp_customize->add_setting( 'padelup_hero_button_url', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ) );

    $wp_customize->add_control( 'padelup_hero_button_url', array(
        'label'   => __( 'URL кнопки', 'padelup' ),
        'section' => 'padelup_hero',
        'type'    => 'url',
    ) );

    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'padelup_hero_image', array(
        'label'   => __( 'Изображение баннера', 'padelup' ),
        'section' => 'padelup_hero',
    ) ) );

    // ===== CONTACT INFO =====
    $wp_customize->add_section( 'padelup_contact', array(
        'title'    => __( 'Контактная информация', 'padelup' ),
        'priority' => 35,
    ) );

    $wp_customize->add_setting( 'padelup_phone', array(
        'default'           => '8 (800) 555-45-45',
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'padelup_phone', array(
        'label'   => __( 'Телефон', 'padelup' ),
        'section' => 'padelup_contact',
        'type'    => 'text',
    ) );

    $wp_customize->add_setting( 'padelup_email', array(
        'default'           => 'info@padelup.store',
        'sanitize_callback' => 'sanitize_email',
    ) );

    $wp_customize->add_control( 'padelup_email', array(
        'label'   => __( 'Email', 'padelup' ),
        'section' => 'padelup_contact',
        'type'    => 'email',
    ) );

    $wp_customize->add_setting( 'padelup_address', array(
        'default'           => 'Москва, ул. Спортивная, 15',
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'padelup_address', array(
        'label'   => __( 'Адрес', 'padelup' ),
        'section' => 'padelup_contact',
        'type'    => 'text',
    ) );

    // ===== SOCIAL LINKS =====
    $wp_customize->add_section( 'padelup_social', array(
        'title'    => __( 'Ссылки на соцсети', 'padelup' ),
        'priority' => 40,
    ) );

    $social_networks = array( 'telegram', 'whatsapp', 'instagram', 'youtube' );

    foreach ( $social_networks as $network ) {
        $wp_customize->add_setting( 'padelup_social_' . $network, array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ) );

        $wp_customize->add_control( 'padelup_social_' . $network, array(
            'label'   => ucfirst( $network ) . ' URL',
            'section' => 'padelup_social',
            'type'    => 'url',
        ) );
    }

    // ===== NEWSLETTER =====
    $wp_customize->add_section( 'padelup_newsletter', array(
        'title'    => __( 'Рассылка', 'padelup' ),
        'priority' => 45,
    ) );

    $wp_customize->add_setting( 'padelup_newsletter_title', array(
        'default'           => 'Получай первым',
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'padelup_newsletter_title', array(
        'label'   => __( 'Заголовок рассылки', 'padelup' ),
        'section' => 'padelup_newsletter',
        'type'    => 'text',
    ) );

    $wp_customize->add_setting( 'padelup_newsletter_desc', array(
        'default'           => 'Новости и специальные предложения',
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'padelup_newsletter_desc', array(
        'label'   => __( 'Описание рассылки', 'padelup' ),
        'section' => 'padelup_newsletter',
        'type'    => 'text',
    ) );

    // ===== COLORS =====
    $wp_customize->add_setting( 'padelup_color_primary', array(
        'default'           => '#c8ff00',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'padelup_color_primary', array(
        'label'   => __( 'Основной цвет', 'padelup' ),
        'section' => 'colors',
    ) ) );

    $wp_customize->add_setting( 'padelup_color_dark', array(
        'default'           => '#1a1a1a',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'padelup_color_dark', array(
        'label'   => __( 'Тёмный цвет', 'padelup' ),
        'section' => 'colors',
    ) ) );
}
add_action( 'customize_register', 'padelup_customize_register' );

/**
 * Output customizer CSS
 */
function padelup_customizer_css() {
    $primary_color = get_theme_mod( 'padelup_color_primary', '#c8ff00' );
    $dark_color = get_theme_mod( 'padelup_color_dark', '#1a1a1a' );

    if ( '#c8ff00' === $primary_color && '#1a1a1a' === $dark_color ) {
        return;
    }

    $css = ':root {';
    if ( '#c8ff00' !== $primary_color ) {
        $css .= '--color-primary: ' . esc_attr( $primary_color ) . ';';
    }
    if ( '#1a1a1a' !== $dark_color ) {
        $css .= '--color-dark: ' . esc_attr( $dark_color ) . ';';
    }
    $css .= '}';

    wp_add_inline_style( 'padelup-style', $css );
}
add_action( 'wp_enqueue_scripts', 'padelup_customizer_css', 20 );