<?php
/**
 * Checkout Page Template
 *
 * @package PadelUp
 */

get_header();
?>

<main class="main">
    <div class="container" style="padding: 40px 20px;">
        <h1 style="font-size: 2rem; font-weight: 800; margin-bottom: 30px;">Оформление заказа</h1>
        <?php woocommerce_checkout(); ?>
    </div>
</main>

<?php get_footer(); ?>