<?php
/**
 * Template Name: Отчёт
 * Template Post Type: page
 *
 * @package PadelUp
 */

get_header();
?>

<style>
.report {
    max-width: 960px;
    margin: 0 auto;
    padding: 60px 20px;
}

.report__header {
    margin-bottom: 40px;
    padding-bottom: 24px;
    border-bottom: 2px solid var(--color-primary);
}

.report__title {
    font-size: 2rem;
    font-weight: 800;
    color: var(--color-dark);
    margin-bottom: 8px;
}

.report__date {
    font-size: 0.85rem;
    color: var(--color-gray-light);
    font-weight: 500;
}

.report__section {
    margin-bottom: 32px;
}

.report__section-title {
    font-size: 1.2rem;
    font-weight: 700;
    color: var(--color-dark);
    margin-bottom: 12px;
    padding-bottom: 8px;
    border-bottom: 1px solid #eee;
}

.report__text {
    font-size: 0.95rem;
    line-height: 1.8;
    color: var(--color-text);
    margin-bottom: 12px;
}

.report__code {
    background: var(--color-darkest);
    color: #e0e0e0;
    padding: 20px;
    border-radius: 8px;
    font-family: 'Courier New', monospace;
    font-size: 0.85rem;
    line-height: 1.6;
    overflow-x: auto;
    margin-bottom: 16px;
}

.report__code .keyword { color: #c8ff00; }
.report__code .comment { color: #666; }
.report__code .string { color: #e0aaff; }

.report__list {
    list-style: none;
    padding: 0;
}

.report__list li {
    padding: 8px 0;
    padding-left: 20px;
    position: relative;
    font-size: 0.95rem;
    line-height: 1.6;
}

.report__list li::before {
    content: '';
    position: absolute;
    left: 0;
    top: 16px;
    width: 8px;
    height: 8px;
    background: var(--color-primary);
    border-radius: 50%;
}

.report__badge {
    display: inline-block;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.report__badge--success {
    background: #e8f5e9;
    color: #2e7d32;
}

.report__badge--warning {
    background: #fff3e0;
    color: #ef6c00;
}

.report__table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 16px;
}

.report__table th,
.report__table td {
    padding: 12px 16px;
    text-align: left;
    border-bottom: 1px solid #eee;
    font-size: 0.9rem;
}

.report__table th {
    font-weight: 600;
    color: var(--color-dark);
    background: var(--color-light);
}

.report__file {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 4px 10px;
    background: var(--color-light);
    border-radius: 4px;
    font-family: monospace;
    font-size: 0.85rem;
    color: var(--color-dark);
}

@media (max-width: 768px) {
    .report { padding: 40px 16px; }
    .report__title { font-size: 1.5rem; }
    .report__code { font-size: 0.75rem; padding: 14px; }
}
</style>

<main class="main">
    <div class="report">
        <?php while ( have_posts() ) : the_post(); ?>
            <div class="report__header">
                <h1 class="report__title"><?php the_title(); ?></h1>
                <div class="report__date"><?php echo get_the_date(); ?></div>
            </div>

            <div class="report__body">
                <?php the_content(); ?>
            </div>
        <?php endwhile; ?>
    </div>
</main>

<?php get_footer(); ?>
