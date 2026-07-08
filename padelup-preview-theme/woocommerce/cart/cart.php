<?php
/**
 * Custom Cart Template
 *
 * @package PadelUp
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_cart' );
?>

<form class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
    <?php do_action( 'woocommerce_before_cart_table' ); ?>

    <div class="cart-layout">
        <div class="cart-layout__items">
            <div class="cart-table">
                <div class="cart-table__header">
                    <div class="cart-table__col cart-table__col--remove"></div>
                    <div class="cart-table__col cart-table__col--image"></div>
                    <div class="cart-table__col cart-table__col--name">Товар</div>
                    <div class="cart-table__col cart-table__col--price">Цена</div>
                    <div class="cart-table__col cart-table__col--quantity">Количество</div>
                    <div class="cart-table__col cart-table__col--total">Итого</div>
                </div>

                <?php do_action( 'woocommerce_before_cart_contents' ); ?>

                <?php
                foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
                    $_product   = apply_filters( 'woocommerce_cart_item_quantity', $cart_item['data'], $cart_item_key, $cart_item );
                    $product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

                    if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 ) {
                        $product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->get_permalink(), $cart_item, $cart_item_key );
                ?>
                    <div class="cart-table__item" data-cart-item-key="<?php echo esc_attr( $cart_item_key ); ?>">
                        <div class="cart-table__col cart-table__col--remove">
                            <?php echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
                                '<a href="%s" class="remove remove_from_cart_button" aria-label="%s" data-product_id="%s" data-cart_item_key="%s" data-product_sku="%s">&times;</a>',
                                esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
                                esc_attr__( 'Remove this item', 'woocommerce' ),
                                esc_attr( $product_id ),
                                esc_attr( $cart_item_key ),
                                esc_attr( $_product->get_sku() )
                            ), $cart_item_key ); ?>
                        </div>

                        <div class="cart-table__col cart-table__col--image">
                            <?php
                            $thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
                            if ( ! $product_permalink ) {
                                echo $thumbnail;
                            } else {
                                printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail );
                            }
                            ?>
                        </div>

                        <div class="cart-table__col cart-table__col--name">
                            <?php
                            $name = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );
                            if ( ! $product_permalink ) {
                                echo '<span class="product-name">' . wp_kses_post( $name ) . '</span>';
                            } else {
                                printf( '<a href="%s" class="product-name">%s</a>', esc_url( $product_permalink ), wp_kses_post( $name ) );
                            }
                            do_action( 'woocommerce_cart_item_data', $cart_item, $cart_item_key );
                            ?>
                        </div>

                        <div class="cart-table__col cart-table__col--price">
                            <?php
                            echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
                            ?>
                        </div>

                        <div class="cart-table__col cart-table__col--quantity">
                            <?php
                            echo apply_filters( 'woocommerce_cart_item_quantity', sprintf(
                                '<div class="quantity">%s%s%s</div>',
                                '<button type="button" class="minus" aria-label="Уменьшить">−</button>',
                                sprintf( '<input type="number" class="input-text qty text" step="1" min="0" max="%s" name="cart[%s][qty]" value="%s" aria-label="Количество" />', esc_attr( $_product->get_max_purchase_quantity() ), esc_attr( $cart_item_key ), esc_attr( $cart_item['quantity'] ) ),
                                '<button type="button" class="plus" aria-label="Увеличить">+</button>'
                            ), $cart_item_key, $cart_item );
                            ?>
                        </div>

                        <div class="cart-table__col cart-table__col--total">
                            <?php
                            echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key );
                            ?>
                        </div>
                    </div>
                <?php
                    }
                }
                do_action( 'woocommerce_after_cart_contents' );
                ?>
            </div>

            <?php do_action( 'woocommerce_after_cart_table' ); ?>

            <div class="cart-table__actions">
                <div class="coupon">
                    <input type="text" name="coupon_code" id="coupon_code" class="input-text" placeholder="<?php esc_attr_e( 'Код купона', 'padelup' ); ?>" value="" />
                    <button type="submit" class="button" name="apply_coupon" value="<?php esc_attr_e( 'Применить купон', 'padelup' ); ?>"><?php esc_html_e( 'Применить', 'padelup' ); ?></button>
                    <?php do_action( 'woocommerce_after_coupon' ); ?>
                </div>
                <button type="submit" class="button update-cart-button" name="update_cart" value="<?php esc_attr_e( 'Обновить корзину', 'padelup' ); ?>" style="opacity: 1;"><?php esc_html_e( 'Обновить корзину', 'padelup' ); ?></button>
            </div>
        </div>

        <div class="cart-layout__sidebar">
            <?php woocommerce_cart_totals(); ?>
        </div>
    </div>

    <?php do_action( 'woocommerce_cart_after_actions' ); ?>
    <?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
</form>

<?php do_action( 'woocommerce_after_cart' ); ?>
