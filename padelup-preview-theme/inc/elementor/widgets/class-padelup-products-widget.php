<?php
/**
 * Products Widget for Elementor
 *
 * @package PadelUp
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class PadelUp_Products_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'padelup-products';
    }

    public function get_title() {
        return __( 'PadelUp Products', 'padelup' );
    }

    public function get_icon() {
        return 'eicon-product-grid';
    }

    public function get_categories() {
        return [ 'padelup' ];
    }

    public function get_keywords() {
        return [ 'products', 'woocommerce', 'catalog', 'padelup' ];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __( 'Настройки', 'padelup' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'title',
            [
                'label'   => __( 'Заголовок', 'padelup' ),
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => 'Хиты продаж',
            ]
        );

        $this->add_control(
            'products_source',
            [
                'label'   => __( 'Источник товаров', 'padelup' ),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 'popular',
                'options' => [
                    'popular'  => __( 'Популярные', 'padelup' ),
                    'recent'   => __( 'Новинки', 'padelup' ),
                    'sale'     => __( 'Распродажа', 'padelup' ),
                    'featured' => __( 'Избранные', 'padelup' ),
                    'specific' => __( 'Выбранные', 'padelup' ),
                ],
            ]
        );

        $this->add_control(
            'category',
            [
                'label'     => __( 'Категория', 'padelup' ),
                'type'      => \Elementor\Controls_Manager::SELECT2,
                'options'   => padelup_get_product_categories(),
                'multiple'  => true,
            ]
        );

        $this->add_control(
            'limit',
            [
                'label'   => __( 'Количество', 'padelup' ),
                'type'    => \Elementor\Controls_Manager::SLIDER,
                'default' => [
                    'size' => 6,
                ],
                'range' => [
                    'min' => 1,
                    'max' => 24,
                ],
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

        $this->add_control(
            'view_all_link',
            [
                'label' => __( 'Ссылка "Смотреть все"', 'padelup' ),
                'type'  => \Elementor\Controls_Manager::URL,
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        $title = $settings['title'] ?? '';
        $source = $settings['products_source'] ?? 'popular';
        $category = $settings['category'] ?? '';
        $limit = $settings['limit']['size'] ?? 6;
        $columns = $settings['columns'] ?? '6';
        $view_all_url = $settings['view_all_link']['url'] ?? '';

        $args = [
            'post_type'      => 'product',
            'posts_per_page' => $limit,
            'post_status'    => 'publish',
        ];

        if ( $source === 'popular' ) {
            $args['meta_key'] = 'total_sales';
            $args['orderby'] = 'meta_value_num';
            $args['order'] = 'DESC';
        } elseif ( $source === 'recent' ) {
            $args['orderby'] = 'date';
            $args['order'] = 'DESC';
        } elseif ( $source === 'sale' ) {
            $args['meta_query'] = [
                [
                    'key'     => '_sale_price',
                    'value'   => 0,
                    'compare' => '>',
                    'type'    => 'NUMERIC',
                ],
            ];
        } elseif ( $source === 'featured' ) {
            $args['meta_query'] = [
                [
                    'key'     => '_featured',
                    'value'   => 'yes',
                    'compare' => '=',
                ],
            ];
        }

        if ( ! empty( $category ) ) {
            $args['tax_query'] = [
                [
                    'taxonomy' => 'product_cat',
                    'field'    => 'term_id',
                    'terms'    => $category,
                ],
            ];
        }

        $products = new \WP_Query( $args );

        if ( ! $products->have_posts() ) {
            echo '<p>' . __( 'Товары не найдены', 'padelup' ) . '</p>';
            return;
        }
        ?>
        <section class="products-section">
            <div class="section-title">
                <?php if ( $title ) : ?>
                    <h2 class="section-title__text"><?php echo esc_html( $title ); ?></h2>
                <?php endif; ?>
                <?php if ( $view_all_url ) : ?>
                    <a href="<?php echo esc_url( $view_all_url ); ?>" class="section-title__link">
                        Смотреть все →
                    </a>
                <?php endif; ?>
            </div>
            <div class="products__grid" style="grid-template-columns: repeat(<?php echo esc_attr( $columns ); ?>, 1fr);">
                <?php
                while ( $products->have_posts() ) {
                    $products->the_post();
                    global $product;

                    if ( ! $product || ! $product->is_visible() ) {
                        continue;
                    }

                    $brands = get_the_terms( $product->get_id(), 'product_brand' );

                    $wl_active = false;
                    if ( is_user_logged_in() ) {
                        $wl = get_user_meta( get_current_user_id(), 'padelup_wishlist', true );
                        if ( is_array( $wl ) ) {
                            $wl_active = in_array( $product->get_id(), $wl );
                        }
                    }
                    ?>
                    <div class="product-card">
                        <div class="product-card__image-wrapper">
                            <a href="<?php the_permalink(); ?>">
                                <?php if ( has_post_thumbnail() ) : ?>
                                    <?php the_post_thumbnail( 'padelup-product', [ 'class' => 'product-card__image' ] ); ?>
                                <?php else : ?>
                                    <?php echo wc_placeholder_img( 'padelup-product', [ 'class' => 'product-card__image' ] ); ?>
                                <?php endif; ?>
                            </a>
                            <button class="product-card__wishlist<?php echo $wl_active ? ' active' : ''; ?>" data-product-id="<?php echo esc_attr( $product->get_id() ); ?>" aria-label="В избранное">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="<?php echo $wl_active ? 'var(--color-primary)' : 'none'; ?>" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"></path>
                                </svg>
                            </button>
                        </div>
                        <div class="product-card__info">
                            <?php if ( $brands && ! is_wp_error( $brands ) ) : ?>
                                <div class="product-card__brand"><?php echo esc_html( $brands[0]->name ); ?></div>
                            <?php endif; ?>
                            <h3 class="product-card__name">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h3>
                            <div class="product-card__bottom">
                                <div class="product-card__price">
                                    <?php echo $product->get_price_html(); ?>
                                </div>
                                <button type="button" class="product-card__cart-btn" data-product-id="<?php echo esc_attr( $product->get_id() ); ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="9" cy="21" r="1"></circle>
                                        <circle cx="20" cy="21" r="1"></circle>
                                        <path d="m1 1 4 0 2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                wp_reset_postdata();
                ?>
            </div>
        </section>
        <?php
    }
}

function padelup_get_product_categories() {
    $categories = get_terms( [
        'taxonomy'   => 'product_cat',
        'hide_empty' => false,
    ] );

    $options = [];
    if ( ! is_wp_error( $categories ) ) {
        foreach ( $categories as $category ) {
            $options[ $category->term_id ] = $category->name;
        }
    }

    return $options;
}