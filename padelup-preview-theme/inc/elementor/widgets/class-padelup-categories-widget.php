<?php
/**
 * Categories Widget for Elementor
 *
 * @package PadelUp
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class PadelUp_Categories_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'padelup-categories';
    }

    public function get_title() {
        return __( 'PadelUp Categories', 'padelup' );
    }

    public function get_icon() {
        return 'eicon-posts-grid';
    }

    public function get_categories() {
        return [ 'padelup' ];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __( 'Категории', 'padelup' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'title',
            [
                'label'   => __( 'Название', 'padelup' ),
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => 'Категория',
            ]
        );

        $repeater->add_control(
            'link',
            [
                'label' => __( 'Ссылка', 'padelup' ),
                'type'  => \Elementor\Controls_Manager::URL,
            ]
        );

        $repeater->add_control(
            'image',
            [
                'label'   => __( 'Изображение', 'padelup' ),
                'type'    => \Elementor\Controls_Manager::MEDIA,
            ]
        );

        $repeater->add_control(
            'badge',
            [
                'label'   => __( 'Бейдж', 'padelup' ),
                'type'    => \Elementor\Controls_Manager::TEXT,
            ]
        );

        $this->add_control(
            'categories',
            [
                'label'       => __( 'Категории', 'padelup' ),
                'type'        => \Elementor\Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'default'     => [
                    [ 'title' => 'Новинки', 'badge' => 'NEW' ],
                    [ 'title' => 'Ракетки' ],
                    [ 'title' => 'Одежда' ],
                    [ 'title' => 'Обувь' ],
                    [ 'title' => 'Аксессуары' ],
                    [ 'title' => 'Off Court' ],
                ],
                'title_field' => '{{{ title }}}',
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
        $categories = $settings['categories'] ?? [];
        $columns = $settings['columns'] ?? '6';
        ?>
        <section class="categories">
            <div class="categories__grid" style="grid-template-columns: repeat(<?php echo esc_attr( $columns ); ?>, 1fr);">
                <?php foreach ( $categories as $cat ) :
                    $title = $cat['title'] ?? '';
                    $link = $cat['link']['url'] ?? '#';
                    $image = $cat['image']['url'] ?? '';
                    $badge = $cat['badge'] ?? '';
                ?>
                    <a href="<?php echo esc_url( $link ); ?>" class="category-card">
                        <?php if ( $image ) : ?>
                            <img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( $title ); ?>" class="category-card__image">
                        <?php endif; ?>
                        <div class="category-card__overlay">
                            <?php if ( $badge ) : ?>
                                <div class="category-card__badge"><?php echo esc_html( $badge ); ?></div>
                            <?php endif; ?>
                            <div class="category-card__title"><?php echo esc_html( $title ); ?></div>
                            <div class="category-card__link">Смотреть все →</div>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </section>
        <?php
    }
}