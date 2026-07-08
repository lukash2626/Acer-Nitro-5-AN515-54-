<?php
/**
 * My Account Navigation
 *
 * @package PadelUp
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_account_navigation' );
?>

<nav class="woocommerce-MyAccount-navigation">
    <ul>
        <?php
        foreach ( wc_get_account_menu_items() as $endpoint => $label ) {
            $classes = array();

            if ( wc_is_current_account_menu_item( $endpoint ) ) {
                $classes[] = 'is-active';
            }

            if ( 'customer-logout' === $endpoint ) {
                $classes[] = 'woocommerce-MyAccount-navigation-link--logout';
            }
            ?>
            <li class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
                <?php
                if ( 'customer-logout' === $endpoint ) {
                    $logout_url = function_exists( 'wc_logout_url' ) ? wc_logout_url( home_url() ) : wp_logout_url( home_url() );
                    echo '<a href="' . esc_url( $logout_url ) . '">' . esc_html( $label ) . '</a>';
                } else {
                    echo '<a href="' . esc_url( wc_get_account_endpoint_url( $endpoint ) ) . '">';
                    
                    // Иконки
                    switch ( $endpoint ) {
                        case 'dashboard':
                            echo '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>';
                            break;
                        case 'orders':
                            echo '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line></svg>';
                            break;
                        case 'edit-account':
                            echo '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>';
                            break;
                        case 'edit-address':
                            echo '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"></path><circle cx="12" cy="10" r="3"></circle></svg>';
                            break;
                        case 'edit-payment-methods':
                            echo '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>';
                            break;
                    }
                    
                    echo '<span>' . esc_html( $label ) . '</span></a>';
                }
                ?>
            </li>
            <?php
        }
        ?>
    </ul>
</nav>

<?php do_action( 'woocommerce_after_account_navigation' ); ?>