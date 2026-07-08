<?php
/**
 * Brands Widget for Elementor
 *
 * @package PadelUp
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class PadelUp_Brands_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'padelup-brands';
    }

    public function get_title() {
        return __( 'PadelUp Brands', 'padelup' );
    }

    public function get_icon() {
        return 'eicon-typography';
    }

    public function get_categories() {
        return [ 'padelup' ];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __( 'Бренды', 'padelup' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'name',
            [
                'label'   => __( 'Название', 'padelup' ),
                'type'    => \Elementor\Controls_Manager::TEXT,
            ]
        );

        $repeater->add_control(
            'logo',
            [
                'label'   => __( 'Логотип', 'padelup' ),
                'type'    => \Elementor\Controls_Manager::MEDIA,
            ]
        );

        $this->add_control(
            'brands',
            [
                'label'       => __( 'Бренды', 'padelup' ),
                'type'        => \Elementor\Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'default'     => [
                    [ 'name' => 'Nox' ],
                    [ 'name' => 'Bullpadel' ],
                    [ 'name' => 'Head' ],
                    [ 'name' => 'Adidas' ],
                    [ 'name' => 'Wilson' ],
                    [ 'name' => 'Nike' ],
                ],
                'title_field' => '{{{ name }}}',
            ]
        );

        $this->add_control(
            'title',
            [
                'label'   => __( 'Заголовок', 'padelup' ),
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => 'Популярные бренды',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $brands = $settings['brands'] ?? [];
        $title = $settings['title'] ?? '';
        ?>
        <section class="brands-section">
            <div class="container">
                <?php if ( $title ) : ?>
                    <h3 class="brands__title"><?php echo esc_html( $title ); ?></h3>
                <?php endif; ?>
                <div class="brands__list">
                    <?php foreach ( $brands as $brand ) :
                        $name = $brand['name'] ?? '';
                        $logo = $brand['logo']['url'] ?? '';
                    ?>
                        <div class="brands__item">
                            <?php if ( $logo ) : ?>
                                <img src="<?php echo esc_url( $logo ); ?>" alt="<?php echo esc_attr( $name ); ?>" style="height: 30px; object-fit: contain;">
                            <?php else : ?>
                                <span style="font-size: 1rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1px;"><?php echo esc_html( $name ); ?></span>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php
    }
}