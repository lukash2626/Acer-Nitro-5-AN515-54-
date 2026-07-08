<?php
/**
 * My Account Login/Register Form
 *
 * @package PadelUp
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_customer_login_form' );
?>

<?php if ( 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) ) : ?>

<div class="woocommerce-form-wrapper">
    <div class="woocommerce-form-login-wrap">
        <h2>Вход</h2>
        <p class="woocommerce-form-login__description">Добро пожаловать! Войдите в свой аккаунт.</p>
        
        <form class="woocommerce-form woocommerce-form-login" method="post">

            <?php do_action( 'woocommerce_login_form_start' ); ?>

            <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                <label for="username">Email или имя пользователя <span class="required">*</span></label>
                <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" />
            </p>

            <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                <label for="password">Пароль <span class="required">*</span></label>
                <input class="woocommerce-Input woocommerce-Input--text input-text" type="password" name="password" id="password" autocomplete="current-password" />
            </p>

            <?php do_action( 'woocommerce_login_form' ); ?>

            <p class="form-row">
                <label class="woocommerce-form__label woocommerce-form__label-for-checkbox woocommerce-form-login__rememberme">
                    <input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" />
                    <span>Запомнить меня</span>
                </label>
                <a href="<?php echo esc_url( wc_lostpassword_url() ); ?>" class="woocommerce-lost-password">Забыли пароль?</a>
            </p>

            <?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>

            <p class="form-row">
                <button type="submit" class="woocommerce-button button woocommerce-form-login__submit" name="login" value="Войти">Войти</button>
            </p>

            <?php do_action( 'woocommerce_login_form_end' ); ?>

        </form>
    </div>

    <div class="woocommerce-form-divider">
        <span>или</span>
    </div>

    <div class="woocommerce-form-register-wrap">
        <h2>Регистрация</h2>
        <p class="woocommerce-form-register__description">Создайте аккаунт для быстрого оформления заказов.</p>
        
        <form method="post" class="woocommerce-form woocommerce-form-register" <?php do_action( 'woocommerce_register_form_tag' ); ?>>

            <?php do_action( 'woocommerce_register_form_start' ); ?>

            <?php if ( 'yes' === get_option( 'woocommerce_generate_username_from_email' ) ) : ?>

                <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                    <label for="reg_email">Email адрес <span class="required">*</span></label>
                    <input type="email" class="woocommerce-Input woocommerce-Input--text input-text" name="email" id="reg_email" autocomplete="email" value="<?php echo ( ! empty( $_POST['email'] ) ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : ''; ?>" />
                </p>

            <?php else : ?>

                <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                    <label for="reg_username">Имя пользователя <span class="required">*</span></label>
                    <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="reg_username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" />
                </p>

                <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                    <label for="reg_email">Email адрес <span class="required">*</span></label>
                    <input type="email" class="woocommerce-Input woocommerce-Input--text input-text" name="email" id="reg_email" autocomplete="email" value="<?php echo ( ! empty( $_POST['email'] ) ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : ''; ?>" />
                </p>

            <?php endif; ?>

            <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                <label for="reg_password">Пароль <span class="required">*</span></label>
                <input type="password" class="woocommerce-Input woocommerce-Input--text input-text" name="password" id="reg_password" autocomplete="new-password" />
            </p>

            <?php do_action( 'woocommerce_register_form' ); ?>

            <p class="woocommerce-form-row form-row">
                <?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
                <button type="submit" class="woocommerce-Button woocommerce-button button woocommerce-form-register__submit" name="register" value="register"><?php esc_html_e( 'Зарегистрироваться', 'padelup' ); ?></button>
            </p>

            <?php do_action( 'woocommerce_register_form_end' ); ?>

        </form>
    </div>
</div>

<?php else : ?>

<div class="woocommerce-form-wrapper">
    <div class="woocommerce-form-login-wrap" style="max-width: 100%;">
        <h2>Вход</h2>
        <p class="woocommerce-form-login__description">Добро пожаловать! Войдите в свой аккаунт.</p>
        
        <form class="woocommerce-form woocommerce-form-login" method="post">

            <?php do_action( 'woocommerce_login_form_start' ); ?>

            <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                <label for="username">Email или имя пользователя <span class="required">*</span></label>
                <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" />
            </p>

            <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                <label for="password">Пароль <span class="required">*</span></label>
                <input class="woocommerce-Input woocommerce-Input--text input-text" type="password" name="password" id="password" autocomplete="current-password" />
            </p>

            <?php do_action( 'woocommerce_login_form' ); ?>

            <p class="form-row">
                <label class="woocommerce-form__label woocommerce-form__label-for-checkbox woocommerce-form-login__rememberme">
                    <input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" />
                    <span>Запомнить меня</span>
                </label>
                <a href="<?php echo esc_url( wc_lostpassword_url() ); ?>" class="woocommerce-lost-password">Забыли пароль?</a>
            </p>

            <?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>

            <p class="form-row">
                <button type="submit" class="woocommerce-button button woocommerce-form-login__submit" name="login" value="Войти">Войти</button>
            </p>

            <?php do_action( 'woocommerce_login_form_end' ); ?>

        </form>
    </div>
</div>

<?php endif; ?>

<?php do_action( 'woocommerce_after_customer_login_form' ); ?>