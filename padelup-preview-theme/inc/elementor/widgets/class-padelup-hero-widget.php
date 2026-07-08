<?php
/**
 * Hero Widget for Elementor
 *
 * @package PadelUp
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class PadelUp_Hero_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'padelup-hero';
    }

    public function get_title() {
        return __( 'PadelUp Hero', 'padelup' );
    }

    public function get_icon() {
        return 'eicon-slider-3d';
    }

    public function get_categories() {
        return [ 'padelup' ];
    }

    public function get_keywords() {
        return [ 'hero', 'banner', 'slider', 'padelup' ];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __( 'Содержимое', 'padelup' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'badge',
            [
                'label'   => __( 'Бейдж', 'padelup' ),
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => 'PREMIUM PADEL GEAR',
            ]
        );

        $this->add_control(
            'title',
            [
                'label'       => __( 'Заголовок', 'padelup' ),
                'type'        => \Elementor\Controls_Manager::TEXTAREA,
                'default'     => "ИГРАЙ\nЛУЧШЕ.\nПОБЕЖДАЙ.",
                'description' => __( 'Используйте &lt;span&gt;для&lt;/span&gt; выделения цветом', 'padelup' ),
            ]
        );

        $this->add_control(
            'subtitle',
            [
                'label'   => __( 'Подзаголовок', 'padelup' ),
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => 'Премиальная экипировка для падела',
            ]
        );

        $this->add_control(
            'button_text',
            [
                'label'   => __( 'Текст кнопки', 'padelup' ),
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => 'СМОТРЕТЬ КАТАЛОГ',
            ]
        );

        $this->add_control(
            'button_url',
            [
                'label' => __( 'Ссылка кнопки', 'padelup' ),
                'type'  => \Elementor\Controls_Manager::URL,
            ]
        );

        $this->add_control(
            'image',
            [
                'label'   => __( 'Изображение', 'padelup' ),
                'type'    => \Elementor\Controls_Manager::MEDIA,
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'style_section',
            [
                'label' => __( 'Стиль', 'padelup' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label'     => __( 'Цвет заголовка', 'padelup' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .hero__title' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'highlight_color',
            [
                'label'     => __( 'Цвет выделения', 'padelup' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .hero__title span' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        $badge = $settings['badge'] ?? '';
        $title = $settings['title'] ?? '';
        $subtitle = $settings['subtitle'] ?? '';
        $button_text = $settings['button_text'] ?? '';
        $button_url = $settings['button_url']['url'] ?? '#';
        $image = $settings['image']['url'] ?? '';

        $title = str_replace( '<span>', '<span style="color: var(--color-primary);">', $title );
        ?>
        <section class="hero">
            <div class="container">
                <div class="hero__slide">
                    <div class="hero__content">
                        <?php if ( $badge ) : ?>
                            <div class="hero__badge"><?php echo esc_html( $badge ); ?></div>
                        <?php endif; ?>
                        <?php if ( $title ) : ?>
                            <h1 class="hero__title"><?php echo wp_kses_post( nl2br( $title ) ); ?></h1>
                        <?php endif; ?>
                        <?php if ( $subtitle ) : ?>
                            <p class="hero__desc"><?php echo esc_html( $subtitle ); ?></p>
                        <?php endif; ?>
                        <?php if ( $button_text ) : ?>
                            <a href="<?php echo esc_url( $button_url ); ?>" class="btn btn--primary">
                                <?php echo esc_html( $button_text ); ?>
                                <span class="btn__arrow">→</span>
                            </a>
                        <?php endif; ?>
                    </div>
                    <?php if ( $image ) : ?>
                        <div class="hero__image">
                            <img src="<?php echo esc_url( $image ); ?>" alt="">
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>
        <?php
    }
}