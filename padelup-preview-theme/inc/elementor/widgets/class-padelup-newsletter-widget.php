<?php
/**
 * Newsletter Widget for Elementor
 *
 * @package PadelUp
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class PadelUp_Newsletter_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'padelup-newsletter';
    }

    public function get_title() {
        return __( 'PadelUp Newsletter', 'padelup' );
    }

    public function get_icon() {
        return 'eicon-envelope';
    }

    public function get_categories() {
        return [ 'padelup' ];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __( 'Рассылка', 'padelup' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'title',
            [
                'label'   => __( 'Заголовок', 'padelup' ),
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => 'Получай первым',
            ]
        );

        $this->add_control(
            'description',
            [
                'label'   => __( 'Описание', 'padelup' ),
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => 'Новости и специальные предложения',
            ]
        );

        $this->add_control(
            'placeholder',
            [
                'label'   => __( 'Placeholder', 'padelup' ),
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => 'Введите ваш e-mail',
            ]
        );

        $this->add_control(
            'button_text',
            [
                'label'   => __( 'Текст кнопки', 'padelup' ),
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => '→',
            ]
        );

        $this->add_control(
            'form_action',
            [
                'label'   => __( 'Обработчик формы', 'padelup' ),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 'default',
                'options' => [
                    'default' => __( 'Стандартный', 'padelup' ),
                    'mc4wp'   => __( 'MailChimp', 'padelup' ),
                    'mailpoet'=> __( 'MailPoet', 'padelup' ),
                ],
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
            'background_color',
            [
                'label'     => __( 'Фон', 'padelup' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#1a1a1a',
                'selectors' => [
                    '{{WRAPPER}} .newsletter' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'text_color',
            [
                'label'     => __( 'Цвет текста', 'padelup' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .newsletter' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .newsletter__title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $title = $settings['title'] ?? '';
        $description = $settings['description'] ?? '';
        $placeholder = $settings['placeholder'] ?? '';
        $button_text = $settings['button_text'] ?? '';
        $form_action = $settings['form_action'] ?? 'default';
        ?>
        <section class="newsletter">
            <div class="container">
                <div>
                    <?php if ( $title ) : ?>
                        <div class="newsletter__title"><?php echo esc_html( $title ); ?></div>
                    <?php endif; ?>
                    <?php if ( $description ) : ?>
                        <div class="newsletter__desc"><?php echo esc_html( $description ); ?></div>
                    <?php endif; ?>
                </div>
                <?php if ( $form_action === 'mc4wp' && function_exists( 'mc4wp_form' ) ) : ?>
                    <?php echo mc4wp_form( [ 'id' => '' ] ); ?>
                <?php else : ?>
                    <form class="newsletter__form" action="#" method="post">
                        <input type="email" class="newsletter__input" placeholder="<?php echo esc_attr( $placeholder ); ?>" required>
                        <button type="submit" class="newsletter__btn"><?php echo esc_html( $button_text ); ?></button>
                    </form>
                <?php endif; ?>
            </div>
        </section>
        <?php
    }
}