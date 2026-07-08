<?php
/**
 * My Account Dashboard
 *
 * @package PadelUp
 */

defined( 'ABSPATH' ) || exit;

$customer_orders = wc_get_orders( array(
    'customer_id' => get_current_user_id(),
    'status'      => array( 'wc-completed' ),
    'limit'       => 5,
    'orderby'     => 'date',
    'order'       => 'DESC',
    'return'      => 'objects',
) );

$recently_viewed = ( WC()->session ) ? WC()->session->get( 'woocommerce_recently_viewed', array() ) : array();
?>

<div class="account-welcome">
    <h2>Приветствую, <?php echo esc_html( wp_get_current_user()->display_name ); ?>!</h2>
    <p>Управляйте своими заказами, адресами и данными аккаунта.</p>
</div>

<div class="account-stats">
    <div class="account-stat">
        <div class="account-stat__icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline></svg>
        </div>
        <div class="account-stat__info">
            <span class="account-stat__number"><?php echo esc_html( count( $customer_orders ) ); ?></span>
            <span class="account-stat__label">Заказов</span>
        </div>
        <a href="<?php echo esc_url( wc_get_account_endpoint_url( 'orders' ) ); ?>" class="account-stat__link">Смотреть →</a>
    </div>

    <?php
    $user_id = get_current_user_id();
    $billing  = get_user_meta( $user_id, 'billing_first_name', true );
    $shipping = get_user_meta( $user_id, 'shipping_first_name', true );
    $address_count = ( $billing ? 1 : 0 ) + ( $shipping ? 1 : 0 );
    ?>

    <div class="account-stat">
        <div class="account-stat__icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"></path><circle cx="12" cy="10" r="3"></circle></svg>
        </div>
        <div class="account-stat__info">
            <span class="account-stat__number"><?php echo esc_html( $address_count ); ?></span>
            <span class="account-stat__label">Адресов</span>
        </div>
        <a href="<?php echo esc_url( wc_get_account_endpoint_url( 'edit-address' ) ); ?>" class="account-stat__link">Изменить →</a>
    </div>

    <div class="account-stat">
        <div class="account-stat__icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>
        </div>
        <div class="account-stat__info">
            <?php
            $saved_methods = wc_get_customer_saved_methods_list( get_current_user_id() );
            $payment_count = ! empty( $saved_methods ) ? count( $saved_methods ) : 0;
            ?>
            <span class="account-stat__number"><?php echo esc_html( $payment_count ); ?></span>
            <span class="account-stat__label">Способов оплаты</span>
        </div>
        <a href="<?php echo esc_url( wc_get_account_endpoint_url( 'edit-payment-methods' ) ); ?>" class="account-stat__link">Управить →</a>
    </div>
</div>

<?php if ( ! empty( $customer_orders ) ) : ?>
    <div class="account-section">
        <h3 class="account-section__title">Последние заказы</h3>
        <div class="account-orders">
            <?php foreach ( $customer_orders as $customer_order ) :
                $order = wc_get_order( $customer_order->ID );
                if ( ! $order ) continue;
            ?>
                <div class="account-order">
                    <div class="account-order__info">
                        <span class="account-order__number">#<?php echo esc_html( $order->get_order_number() ); ?></span>
                        <span class="account-order__date"><?php echo esc_html( wc_format_datetime( $order->get_date_created() ) ); ?></span>
                    </div>
                    <div class="account-order__status">
                        <?php
                        $status = $order->get_status();
                        $statuses = wc_get_order_statuses();
                        $label = isset( $statuses[ 'wc-' . $status ] ) ? $statuses[ 'wc-' . $status ] : $status;
                        echo '<span class="order-status order-status--' . esc_attr( $status ) . '">' . esc_html( $label ) . '</span>';
                        ?>
                    </div>
                    <div class="account-order__total">
                        <?php echo wp_kses_post( $order->get_formatted_order_total() ); ?>
                    </div>
                    <a href="<?php echo esc_url( $order->get_view_order_url() ); ?>" class="account-order__link">Подробнее →</a>
                </div>
            <?php endforeach; ?>
        </div>
        <a href="<?php echo esc_url( wc_get_account_endpoint_url( 'orders' ) ); ?>" class="btn btn--outline">Все заказы</a>
    </div>
<?php endif; ?>

<?php do_action( 'woocommerce_account_dashboard' ); ?>
