<?php
/**
 * My Account Page Template
 *
 * WooCommerce использует этот файл как шаблон страницы «Мой аккаунт».
 * Override: woocommerce/templates/myaccount.php
 *
 * @package PadelUp
 */

defined( 'ABSPATH' ) || exit;

get_header(); ?>

<main class="main">
    <div class="container myaccount-container">
        <?php wc_print_notices(); ?>
        <?php
        wc_get_template( 'myaccount/my-account.php' );
        ?>
    </div>
</main>

<?php get_footer(); ?>