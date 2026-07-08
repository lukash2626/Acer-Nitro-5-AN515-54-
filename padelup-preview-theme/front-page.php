<?php
/**
 * Front Page Template
 *
 * @package PadelUp
 */

get_header();

function padelup_get_shop_url() {
    if ( function_exists( 'wc_get_page_permalink' ) ) {
        return wc_get_page_permalink( 'shop' );
    }
    return home_url( '/shop/' );
}
?>

<?php if ( padelup_is_elementor() && class_exists( '\Elementor\Plugin' ) ) : ?>
    <?php
    $post_id = get_the_ID();
    $content = \Elementor\Plugin::$instance->frontend->get_builder_content_for_display( $post_id, true );
    echo $content;
    ?>
<?php else : ?>

<!-- HERO SLIDER -->
<section class="hero">
    <div class="container">
        <div class="hero__slide">
            <div class="hero__content animate-fade-in">
                <div class="hero__badge">PREMIUM PADEL GEAR</div>
                <h1 class="hero__title">ИГРАЙ<br>ЛУЧШЕ.<br><span>ПОБЕЖДАЙ.</span></h1>
                <p class="hero__desc">Премиальная экипировка для падела</p>
                <a href="<?php echo esc_url( padelup_get_shop_url() ); ?>" class="btn btn--primary">
                    СМОТРЕТЬ КАТАЛОГ
                    <span class="btn__arrow">→</span>
                </a>
                <div class="hero__dots">
                    <div class="hero__dot active" data-slide="0"></div>
                    <div class="hero__dot" data-slide="1"></div>
                    <div class="hero__dot" data-slide="2"></div>
                </div>
            </div>
            <div class="hero__image">
                <?php
                $hero_image = get_theme_mod( 'padelup_hero_image', PADELUP_URI . '/assets/images/hero-racket.png' );
                ?>
                <img src="<?php echo esc_url( $hero_image ); ?>" alt="Padel Racket" onerror="this.style.display='none'">
            </div>
        </div>
    </div>
    <button class="hero__arrow hero__arrow--prev" aria-label="Предыдущий слайд">‹</button>
    <button class="hero__arrow hero__arrow--next" aria-label="Следующий слайд">›</button>
</section>

<!-- CATEGORIES -->
<section class="categories">
    <div class="container">
        <div class="categories__grid">
            <?php
            $categories = array(
                array( 'name' => 'Новинки', 'slug' => 'new', 'badge' => 'NEW', 'image' => 'new' ),
                array( 'name' => 'Ракетки', 'slug' => 'rackets', 'badge' => '', 'image' => 'rackets' ),
                array( 'name' => 'Одежда', 'slug' => 'clothing', 'badge' => '', 'image' => 'clothing' ),
                array( 'name' => 'Обувь', 'slug' => 'shoes', 'badge' => '', 'image' => 'shoes' ),
                array( 'name' => 'Аксессуары', 'slug' => 'accessories', 'badge' => '', 'image' => 'accessories' ),
                array( 'name' => 'Off Court', 'slug' => 'off-court', 'badge' => '', 'image' => 'offcourt' ),
            );

            foreach ( $categories as $cat ) :
                $link = get_term_link( $cat['slug'], 'product_cat' );
                if ( is_wp_error( $link ) ) {
                    $link = padelup_get_shop_url();
                }
            ?>
                <a href="<?php echo esc_url( $link ); ?>" class="category-card">
                    <img src="<?php echo esc_url( PADELUP_URI . '/assets/images/cat-' . $cat['image'] . '.jpg' ); ?>" 
                         alt="<?php echo esc_attr( $cat['name'] ); ?>" 
                         class="category-card__image"
                         onerror="this.parentElement.style.background='#2a2a2a'">
                    <div class="category-card__overlay">
                        <?php if ( $cat['badge'] ) : ?>
                            <div class="category-card__badge"><?php echo esc_html( $cat['badge'] ); ?></div>
                        <?php endif; ?>
                        <div class="category-card__title"><?php echo esc_html( $cat['name'] ); ?></div>
                        <div class="category-card__link">
                            Смотреть все →
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- HIT PRODUCTS -->
<section class="products-section">
    <div class="container">
        <div class="section-title">
            <h2 class="section-title__text">Хиты продаж</h2>
            <a href="<?php echo esc_url( padelup_get_shop_url() ); ?>" class="section-title__link">
                Смотреть все →
            </a>
        </div>
        <?php
        echo do_shortcode( '[products limit="6" columns="6" orderby="popularity" order="DESC"]' );
        ?>
    </div>
</section>

<!-- SHOES FOR PADEL -->
<section class="products-section" style="background: var(--color-light); padding: 60px 0;">
    <div class="container">
        <div class="section-title">
            <h2 class="section-title__text">Кроссовки для падела</h2>
            <a href="<?php echo esc_url( padelup_get_shop_url() ); ?>?filter_cat=true&product_cat=shoes" class="section-title__link">
                Смотреть все →
            </a>
        </div>
        <div class="brand-filters">
            <?php
            $shoe_brands = array( 'Asics', 'Bullpadel', 'Head', 'Nox' );
            foreach ( $shoe_brands as $brand ) :
            ?>
                <div class="brand-filter" data-brand="<?php echo esc_attr( strtolower( $brand ) ); ?>">
                    <span style="font-size: 0.7rem; font-weight: 600;"><?php echo esc_html( $brand ); ?></span>
                </div>
            <?php endforeach; ?>
        </div>
        <?php
        echo do_shortcode( '[products limit="4" columns="4" orderby="popularity" order="DESC" category="shoes"]' );
        ?>
    </div>
</section>

<!-- CLOTHING FOR PADEL -->
<section class="products-section">
    <div class="container">
        <div class="section-title">
            <h2 class="section-title__text">Одежда для падела</h2>
            <a href="<?php echo esc_url( padelup_get_shop_url() ); ?>?filter_cat=true&product_cat=clothing" class="section-title__link">
                Смотреть все →
            </a>
        </div>
        <div class="brand-filters">
            <?php
            $clothing_brands = array( 'Bullpadel', 'Nox', 'Adidas', 'Stux' );
            foreach ( $clothing_brands as $brand ) :
            ?>
                <div class="brand-filter" data-brand="<?php echo esc_attr( strtolower( $brand ) ); ?>">
                    <span style="font-size: 0.7rem; font-weight: 600;"><?php echo esc_html( $brand ); ?></span>
                </div>
            <?php endforeach; ?>
        </div>
        <?php
        echo do_shortcode( '[products limit="4" columns="4" orderby="popularity" order="DESC" category="clothing"]' );
        ?>
    </div>
</section>

<!-- ACCESSORIES & BALLS -->
<section class="products-section" style="background: var(--color-light); padding: 60px 0;">
    <div class="container">
        <div class="promo-banners__grid" style="grid-template-columns: 1fr 1fr;">
            <div>
                <div class="section-title">
                    <h2 class="section-title__text">Аксессуары</h2>
                    <a href="<?php echo esc_url( padelup_get_shop_url() ); ?>?filter_cat=true&product_cat=accessories" class="section-title__link">
                        Смотреть все →
                    </a>
                </div>
                <?php
                echo do_shortcode( '[products limit="4" columns="4" orderby="popularity" order="DESC" category="accessories"]' );
                ?>
            </div>
            <div>
                <div class="section-title">
                    <h2 class="section-title__text">Мячи для падела</h2>
                    <a href="<?php echo esc_url( padelup_get_shop_url() ); ?>?filter_cat=true&product_cat=balls" class="section-title__link">
                        Смотреть все →
                    </a>
                </div>
                <?php
                echo do_shortcode( '[products limit="4" columns="4" orderby="popularity" order="DESC" category="balls"]' );
                ?>
            </div>
        </div>
    </div>
</section>

<!-- POPULAR BRANDS -->
<section class="brands-section">
    <div class="container">
        <h3 class="brands__title">Популярные бренды</h3>
        <div class="brands__list">
            <?php
            $brands_list = array( 'Nox', 'Bullpadel', 'Head', 'Oxdog', 'Babolat', 'Wilson', 'Adidas', 'Heroe\'s', 'Nike' );
            foreach ( $brands_list as $brand ) :
            ?>
                <div class="brands__item">
                    <span style="font-size: 1rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1px;"><?php echo esc_html( $brand ); ?></span>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- PROMO BANNERS -->
<section class="promo-banners">
    <div class="container">
        <div class="promo-banners__grid">
            <div class="promo-banner promo-banner--dark">
                <div class="promo-banner__content">
                    <div class="promo-banner__subtitle">OUTLET</div>
                    <div class="promo-banner__title">ДО <span>-50%</span></div>
                    <div class="promo-banner__desc">На прошлые коллекции</div>
                    <a href="<?php echo esc_url( home_url( '/product-category/outlet/' ) ); ?>" class="btn btn--primary">СМОТРЕТЬ →</a>
                </div>
            </div>
            <div class="promo-banner promo-banner--gray">
                <div class="promo-banner__content">
                    <div class="promo-banner__subtitle">OFF COURT COLLECTION</div>
                    <div class="promo-banner__title" style="font-size: 1.8rem;">Стиль за пределами корта</div>
                    <a href="<?php echo esc_url( home_url( '/product-category/off-court/' ) ); ?>" class="btn btn--primary" style="margin-top: 20px;">СМОТРЕТЬ КОЛЛЕКЦИЮ →</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- BENEFITS -->
<section class="benefits">
    <div class="container">
        <div class="benefits__grid">
            <div class="benefit">
                <div class="benefit__icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#c8ff00" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M13 2 3 14h9l-1 8 10-12h-9l1-8z"></path>
                    </svg>
                </div>
                <div class="benefit__text">
                    Быстрая доставка
                    <span>По всей России</span>
                </div>
            </div>
            <div class="benefit">
                <div class="benefit__icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#c8ff00" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                    </svg>
                </div>
                <div class="benefit__text">
                    100% оригинал
                    <span>Гарантия подлинности</span>
                </div>
            </div>
            <div class="benefit">
                <div class="benefit__icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#c8ff00" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="9 14 4 9 9 4"></polyline>
                        <path d="M20 20v-7a4 4 0 0 0-4-4H4"></path>
                    </svg>
                </div>
                <div class="benefit__text">
                    Легкий возврат
                    <span>14 дней на возврат</span>
                </div>
            </div>
            <div class="benefit">
                <div class="benefit__icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#c8ff00" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect width="18" height="11" x="3" y="11" rx="2" ry="2"></rect>
                        <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                    </svg>
                </div>
                <div class="benefit__text">
                    Безопасная оплата
                    <span>Защищенные платежи</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- INSTAGRAM -->
<section class="instagram">
    <div class="container">
        <div class="instagram__header">
            <div>
                <div class="instagram__title">Будь в игре</div>
                <div class="instagram__subtitle">Следи за нами в Instagram</div>
            </div>
            <a href="<?php echo esc_url( get_theme_mod( 'padelup_social_instagram', 'https://instagram.com/padelup.store' ) ); ?>" class="instagram__follow">
                @padelup.store
                <span>ПОДПИСАТЬСЯ</span>
            </a>
        </div>
        <div class="instagram__grid">
            <?php for ( $i = 1; $i <= 6; $i++ ) : ?>
                <div class="instagram__item">
                    <img src="<?php echo esc_url( PADELUP_URI . '/assets/images/insta-' . $i . '.jpg' ); ?>" 
                         alt="Instagram <?php echo $i; ?>"
                         onerror="this.parentElement.style.background='#2a2a2a'">
                    <div class="instagram__item-overlay">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect width="20" height="20" x="2" y="2" rx="5" ry="5"></rect>
                            <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                            <line x1="17.5" x2="17.51" y1="6.5" y2="6.5"></line>
                        </svg>
                    </div>
                </div>
            <?php endfor; ?>
        </div>
    </div>
</section>

<!-- NEWSLETTER -->
<section class="newsletter">
    <div class="container">
        <div>
            <div class="newsletter__title">Получай первым</div>
            <div class="newsletter__desc">Новости и специальные предложения</div>
        </div>
        <form class="newsletter__form" action="#" method="post">
            <input type="email" class="newsletter__input" placeholder="Введите ваш e-mail" required>
            <button type="submit" class="newsletter__btn">→</button>
        </form>
    </div>
</section>

<?php endif; ?>

<?php get_footer(); ?>