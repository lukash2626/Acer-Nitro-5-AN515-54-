<?php
/**
 * Benefits Widget for Elementor
 *
 * @package PadelUp
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class PadelUp_Benefits_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'padelup-benefits';
    }

    public function get_title() {
        return __( 'PadelUp Benefits', 'padelup' );
    }

    public function get_icon() {
        return 'eicon-check-circle';
    }

    public function get_categories() {
        return [ 'padelup' ];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __( 'Преимущества', 'padelup' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'title',
            [
                'label'   => __( 'Заголовок', 'padelup' ),
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => 'Быстрая доставка',
            ]
        );

        $repeater->add_control(
            'description',
            [
                'label'   => __( 'Описание', 'padelup' ),
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => 'По всей России',
            ]
        );

        $repeater->add_control(
            'icon',
            [
                'label'   => __( 'Иконка', 'padelup' ),
                'type'    => \Elementor\Controls_Manager::ICONS,
            ]
        );

        $this->add_control(
            'benefits',
            [
                'label'       => __( 'Преимущества', 'padelup' ),
                'type'        => \Elementor\Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'default'     => [
                    [
                        'title'       => 'Быстрая доставка',
                        'description' => 'По всей России',
                        'icon'        => [ 'value' => 'eicon-truck', 'library' => 'eicons' ],
                    ],
                    [
                        'title'       => '100% оригинал',
                        'description' => 'Гарантия подлинности',
                        'icon'        => [ 'value' => 'eicon-shield-check', 'library' => 'eicons' ],
                    ],
                    [
                        'title'       => 'Легкий возврат',
                        'description' => '14 дней на возврат',
                        'icon'        => [ 'value' => 'eicon-undo', 'library' => 'eicons' ],
                    ],
                    [
                        'title'       => 'Безопасная оплата',
                        'description' => 'Защищенные платежи',
                        'icon'        => [ 'value' => 'eicon-lock', 'library' => 'eicons' ],
                    ],
                ],
                'title_field' => '{{{ title }}}',
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
            'icon_color',
            [
                'label'     => __( 'Цвет иконки', 'padelup' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#c8ff00',
                'selectors' => [
                    '{{WRAPPER}} .benefit__icon svg' => 'color: {{VALUE}}; fill: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $benefits = $settings['benefits'] ?? [];
        ?>
        <section class="benefits">
            <div class="container">
                <div class="benefits__grid">
                    <?php foreach ( $benefits as $benefit ) :
                        $title = $benefit['title'] ?? '';
                        $description = $benefit['description'] ?? '';
                        $icon = $benefit['icon'] ?? '';
                    ?>
                        <div class="benefit">
                            <div class="benefit__icon">
                                <?php if ( $icon ) : ?>
                                    <?php \Elementor\Icons_Manager::render_icon( $icon ); ?>
                                <?php endif; ?>
                            </div>
                            <div class="benefit__text">
                                <?php echo esc_html( $title ); ?>
                                <?php if ( $description ) : ?>
                                    <span><?php echo esc_html( $description ); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php
    }
}