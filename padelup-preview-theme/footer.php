<?php
/**
 * Footer Template
 *
 * @package PadelUp
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>

<footer class="footer">
    <div class="container">
        <div class="footer__grid">
            <div>
                <div class="footer__logo">Padel<span>Up</span></div>
                <p class="footer__desc">Премиальная экипировка для падела. Оригинальные товары от ведущих мировых брендов с доставкой по всей России.</p>
                <div class="footer__social">
                    <a href="<?php echo esc_url( get_theme_mod( 'padelup_social_telegram', '#' ) ); ?>" aria-label="Telegram">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m22 2-7 20-4-9-9-4Z"></path>
                            <path d="M22 2 11 13"></path>
                        </svg>
                    </a>
                    <a href="<?php echo esc_url( get_theme_mod( 'padelup_social_whatsapp', '#' ) ); ?>" aria-label="WhatsApp">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path>
                        </svg>
                    </a>
                    <a href="<?php echo esc_url( get_theme_mod( 'padelup_social_instagram', '#' ) ); ?>" aria-label="Instagram">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect width="20" height="20" x="2" y="2" rx="5" ry="5"></rect>
                            <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                            <line x1="17.5" x2="17.51" y1="6.5" y2="6.5"></line>
                        </svg>
                    </a>
                    <a href="<?php echo esc_url( get_theme_mod( 'padelup_social_youtube', '#' ) ); ?>" aria-label="YouTube">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M2.5 17a24.12 24.12 0 0 1 0-10 2 2 0 0 1 1.4-1.4 49.56 49.56 0 0 1 16.2 0A2 2 0 0 1 21.5 7a24.12 24.12 0 0 1 0 10 2 2 0 0 1-1.4 1.4 49.55 49.55 0 0 1-16.2 0A2 2 0 0 1 2.5 17"></path>
                            <path d="m10 15 5-3-5-3z"></path>
                        </svg>
                    </a>
                </div>
            </div>

            <div>
                <h4 class="footer__heading">Каталог</h4>
                <div class="footer__links">
                    <a href="<?php echo esc_url( home_url( '/product-category/new/' ) ); ?>">Новинки</a>
                    <a href="<?php echo esc_url( home_url( '/product-category/rackets/' ) ); ?>">Ракетки</a>
                    <a href="<?php echo esc_url( home_url( '/product-category/clothing/' ) ); ?>">Одежда</a>
                    <a href="<?php echo esc_url( home_url( '/product-category/shoes/' ) ); ?>">Обувь</a>
                    <a href="<?php echo esc_url( home_url( '/product-category/accessories/' ) ); ?>">Аксессуары</a>
                    <a href="<?php echo esc_url( home_url( '/product-category/outlet/' ) ); ?>">Outlet</a>
                    <a href="<?php echo esc_url( home_url( '/product-category/off-court/' ) ); ?>">Off Court</a>
                </div>
            </div>

            <div>
                <h4 class="footer__heading">Покупателям</h4>
                <div class="footer__links">
                    <a href="<?php echo esc_url( home_url( '/delivery/' ) ); ?>">Доставка и оплата</a>
                    <a href="<?php echo esc_url( home_url( '/delivery/#return' ) ); ?>">Возврат и обмен</a>
                    <a href="#">Таблица размеров</a>
                    <a href="#">Гарантия</a>
                    <a href="#">Часто задаваемые вопросы</a>
                </div>
            </div>

            <div>
                <h4 class="footer__heading">О нас</h4>
                <div class="footer__links">
                    <a href="<?php echo esc_url( home_url( '/about/' ) ); ?>">О нас</a>
                    <a href="<?php echo esc_url( home_url( '/contacts/' ) ); ?>">Контакты</a>
                    <a href="#">Магазины</a>
                    <a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>">Блог</a>
                    <a href="#">Партнерам</a>
                </div>
            </div>

            <div>
                <h4 class="footer__heading">Контакты</h4>
                <div class="footer__contact-item">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                    </svg>
                    <div>
                        <p class="footer__phone">8 (800) 555-45-45</p>
                        <p>Ежедневно с 9:00 до 21:00</p>
                    </div>
                </div>
                <div class="footer__contact-item">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                        <polyline points="22,6 12,13 2,6"></polyline>
                    </svg>
                    <p>info@padelup.store</p>
                </div>
                <div class="footer__contact-item">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"></path>
                        <circle cx="12" cy="10" r="3"></circle>
                    </svg>
                    <p>Москва, ул. Спортивная, 15</p>
                </div>
            </div>
        </div>

        <div class="footer__bottom">
            <span>© 2024 PadelUp. Все права защищены.</span>
            <div class="footer__bottom-links">
                <a href="#">Политика конфиденциальности</a>
                <a href="#">Пользовательское соглашение</a>
            </div>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>