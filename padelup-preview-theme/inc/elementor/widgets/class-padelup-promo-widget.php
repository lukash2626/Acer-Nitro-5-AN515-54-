<?php
/**
 * Promo Banner Widget for Elementor
 *
 * @package PadelUp
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class PadelUp_Promo_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'padelup-promo';
    }

    public function get_title() {
        return __( 'PadelUp Promo Banner', 'padelup' );
    }

    public function get_icon() {
        return 'eicon-banner';
    }

    public function get_categories() {
        return [ 'padelup' ];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __( 'Настройки баннеров', 'padelup' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'subtitle',
            [
                'label'   => __( 'Подзаголовок', 'padelup' ),
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => 'OUTLET',
            ]
        );

        $repeater->add_control(
            'title',
            [
                'label'       => __( 'Заголовок', 'padelup' ),
                'type'        => \Elementor\Controls_Manager::TEXTAREA,
                'default'     => 'ДО -50%',
                'description' => __( 'Используйте &lt;span&gt;для&lt;/span&gt; выделения цветом', 'padelup' ),
            ]
        );

        $repeater->add_control(
            'description',
            [
                'label'   => __( 'Описание', 'padelup' ),
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => 'На прошлые коллекции',
            ]
        );

        $repeater->add_control(
            'button_text',
            [
                'label'   => __( 'Текст кнопки', 'padelup' ),
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => 'СМОТРЕТЬ',
            ]
        );

        $repeater->add_control(
            'button_url',
            [
                'label' => __( 'Ссылка кнопки', 'padelup' ),
                'type'  => \Elementor\Controls_Manager::URL,
            ]
        );

        $repeater->add_control(
            'background_type',
            [
                'label'   => __( 'Тип фона', 'padelup' ),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 'dark',
                'options' => [
                    'dark'  => __( 'Тёмный', 'padelup' ),
                    'gray'  => __( 'Серый', 'padelup' ),
                ],
            ]
        );

        $repeater->add_control(
            'image',
            [
                'label'   => __( 'Изображение', 'padelup' ),
                'type'    => \Elementor\Controls_Manager::MEDIA,
            ]
        );

        $this->add_control(
            'banners',
            [
                'label'       => __( 'Баннеры', 'padelup' ),
                'type'        => \Elementor\Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'default'     => [
                    [
                        'subtitle' => 'OUTLET',
                        'title'    => 'ДО <span>-50%</span>',
                        'description' => 'На прошлые коллекции',
                    ],
                    [
                        'subtitle' => 'OFF COURT COLLECTION',
                        'title'    => 'Стиль за пределами корта',
                    ],
                ],
                'title_field' => '{{{ subtitle }}}',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $banners = $settings['banners'] ?? [];
        ?>
        <section class="promo-banners">
            <div class="container">
                <div class="promo-banners__grid">
                    <?php foreach ( $banners as $banner ) :
                        $subtitle = $banner['subtitle'] ?? '';
                        $title = $banner['title'] ?? '';
                        $description = $banner['description'] ?? '';
                        $button_text = $banner['button_text'] ?? '';
                        $button_url = $banner['button_url']['url'] ?? '#';
                        $background_type = $banner['background_type'] ?? 'dark';
                        $image = $banner['image']['url'] ?? '';

                        $class = $background_type === 'dark' ? 'promo-banner--dark' : 'promo-banner--gray';

                        $title = str_replace( '<span>', '<span style="color: var(--color-primary);">', $title );
                    ?>
                        <div class="promo-banner <?php echo esc_attr( $class ); ?>">
                            <div class="promo-banner__content">
                                <?php if ( $subtitle ) : ?>
                                    <div class="promo-banner__subtitle"><?php echo esc_html( $subtitle ); ?></div>
                                <?php endif; ?>
                                <?php if ( $title ) : ?>
                                    <div class="promo-banner__title"><?php echo wp_kses_post( $title ); ?></div>
                                <?php endif; ?>
                                <?php if ( $description ) : ?>
                                    <div class="promo-banner__desc"><?php echo esc_html( $description ); ?></div>
                                <?php endif; ?>
                                <?php if ( $button_text ) : ?>
                                    <a href="<?php echo esc_url( $button_url ); ?>" class="btn btn--primary">
                                        <?php echo esc_html( $button_text ); ?> →
                                    </a>
                                <?php endif; ?>
                            </div>
                            <?php if ( $image ) : ?>
                                <img src="<?php echo esc_url( $image ); ?>" class="promo-banner__image" alt="">
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php
    }
}