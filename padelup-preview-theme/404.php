<?php
/**
 * 404 Template
 *
 * @package PadelUp
 */

get_header();
?>

<main class="main">
    <div class="container" style="padding: 80px 20px; text-align: center;">
        <div style="font-size: 8rem; font-weight: 900; color: var(--color-primary); line-height: 1; margin-bottom: 20px;">404</div>
        <h1 style="font-size: 2rem; font-weight: 800; margin-bottom: 16px;">Страница не найдена</h1>
        <p style="color: var(--color-gray-light); margin-bottom: 40px; max-width: 400px; margin-left: auto; margin-right: auto;">
            Похоже, эта страница была перемещена или удалена. Попробуйте вернуться на главную.
        </p>
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn--primary">На главную</a>
    </div>
</main>

<?php get_footer(); ?>