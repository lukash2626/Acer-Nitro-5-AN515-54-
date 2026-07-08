<?php
/**
 * Page Template
 *
 * @package PadelUp
 */

get_header();
$is_account = function_exists( 'is_account_page' ) && is_account_page();
?>

<main class="main">
    <div class="container" style="padding: 40px 20px; max-width: <?php echo $is_account ? '1200px' : '800px'; ?>;">
        <?php while ( have_posts() ) : the_post(); ?>
            <article class="page-content">
                <?php if ( ! $is_account ) : ?>
                    <h1 class="page-title" style="font-size: 2rem; font-weight: 800; margin-bottom: 30px;"><?php the_title(); ?></h1>
                <?php endif; ?>
                <div class="page-body" style="line-height: 1.8;">
                    <?php the_content(); ?>
                </div>
            </article>
        <?php endwhile; ?>
    </div>
</main>

<?php
get_footer();