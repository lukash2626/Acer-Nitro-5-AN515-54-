<?php
/**
 * Instagram Widget for Elementor
 *
 * @package PadelUp
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class PadelUp_Instagram_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'padelup-instagram';
    }

    public function get_title() {
        return __( 'PadelUp Instagram', 'padelup' );
    }

    public function get_icon() {
        return 'eicon-instagram';
    }

    public function get_categories() {
        return [ 'padelup' ];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __( 'Instagram', 'padelup' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'image',
            [
                'label'   => __( 'Изображение', 'padelup' ),
                'type'    => \Elementor\Controls_Manager::MEDIA,
            ]
        );

        $repeater->add_control(
            'link',
            [
                'label' => __( 'Ссылка', 'padelup' ),
                'type'  => \Elementor\Controls_Manager::URL,
            ]
        );

        $this->add_control(
            'images',
            [
                'label'       => __( 'Изображения', 'padelup' ),
                'type'        => \Elementor\Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'title_field' => __( 'Изображение', 'padelup' ),
            ]
        );

        $this->add_control(
            'username',
            [
                'label'   => __( 'Имя пользователя', 'padelup' ),
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => '@padelup.store',
            ]
        );

        $this->add_control(
            'follow_button_text',
            [
                'label'   => __( 'Текст кнопки', 'padelup' ),
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => 'Подписаться',
            ]
        );

        $this->add_control(
            'columns',
            [
                'label'   => __( 'Колонки', 'padelup' ),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => '6',
                'options' => [
                    '3' => '3',
                    '4' => '4',
                    '6' => '6',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $images = $settings['images'] ?? [];
        $username = $settings['username'] ?? '';
        $follow_button_text = $settings['follow_button_text'] ?? '';
        $columns = $settings['columns'] ?? '6';

        if ( empty( $images ) ) {
            return;
        }
        ?>
        <section class="instagram">
            <div class="container">
                <div class="instagram__header">
                    <div>
                        <div class="instagram__title">Будь в игре</div>
                        <div class="instagram__subtitle">Следи за нами в Instagram</div>
                    </div>
                    <?php if ( $username ) : ?>
                        <a href="https://instagram.com/<?php echo esc_attr( str_replace( '@', '', $username ) ); ?>" class="instagram__follow" target="_blank">
                            <?php echo esc_html( $username ); ?>
                            <?php if ( $follow_button_text ) : ?>
                                <span><?php echo esc_html( $follow_button_text ); ?></span>
                            <?php endif; ?>
                        </a>
                    <?php endif; ?>
                </div>
                <div class="instagram__grid" style="grid-template-columns: repeat(<?php echo esc_attr( $columns ); ?>, 1fr);">
                    <?php foreach ( $images as $item ) :
                        $image = $item['image']['url'] ?? '';
                        $link = $item['link']['url'] ?? '#';
                    ?>
                        <a href="<?php echo esc_url( $link ); ?>" class="instagram__item" target="_blank">
                            <?php if ( $image ) : ?>
                                <img src="<?php echo esc_url( $image ); ?>" alt="">
                            <?php endif; ?>
                            <div class="instagram__item-overlay">
                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect width="20" height="20" x="2" y="2" rx="5" ry="5"></rect>
                                    <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                                    <line x1="17.5" x2="17.51" y1="6.5" y2="6.5"></line>
                                </svg>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php
    }
}