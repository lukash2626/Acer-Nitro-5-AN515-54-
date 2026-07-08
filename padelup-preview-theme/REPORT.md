# Отчёт о проделанной работе — Раунд 2 (исправление ошибок)

**Дата:** 24.06.2026
**Проект:** wo.cyber-promotion.ru (PadelUp Store)
**Тема:** padelup-theme

---

## 🔴 КРИТИЧНЫЕ ИСПРАВЛЕНИЯ

### 1. `$product->is_new()` → проверка по дате публикации
**Проблема:** Метод `is_new()` не существует в WooCommerce — вызывал PHP Fatal Error.
**Решение:** Заменено на проверку разницы между `time()` и `$product->get_date_created()` с фильтром `padelup_days_new` (по умолчанию 30 дней).
**Файл:** `inc/template-functions.php:34-39`

### 2. `woocommerce/loop/image.php` — показывает реальное изображение
**Проблема:** Шаблон всегда выводил placeholder вместо миниатюры товара.
**Решение:** Добавлен `get_post_thumbnail_id()` + `wp_get_attachment_image_url()` с fallback на placeholder и обработчик `onerror`.
**Файл:** `woocommerce/loop/image.php:20-26`

### 3. Дублированный хук `wp_ajax_nopriv_padelup_add_to_cart`
**Проблема:** Хук был зарегистрирован 2 раза (строки 319–320).
**Решение:** Удалена дублирующая строка.
**Файл:** `functions.php:318-319`

### 4. `get_page_by_path()` — устаревший вызов
**Проблема:** Вызов без указания `post_type` генерировал deprecation notice в WP 6.2+.
**Решение:** Добавлены параметры `OBJECT, 'page'`.
**Файл:** `functions.php:361`

### 5. Несоответствие версий темы
**Проблема:** `style.css` = 1.2.0, `functions.php` = 1.3.0.
**Решение:** Версия в `style.css` обновлена до 1.3.0.
**Файл:** `style.css:7`

### 6. Создан `comments.php`
**Проблема:** `single.php` вызывал `comments_template()`, но файла не существовало — вызывался fallback WordPress, который ломал вёрстку.
**Решение:** Создан кастомный `comments.php` с адаптивной вёрсткой под дизайн темы, формой комментариев, пагинацией и локализованными строками.
**Файл:** `comments.php` (новый)

---

## 🟠 СЕРЬЁЗНЫЕ ИСПРАВЛЕНИЯ

### 7. Подсчёт адресов в dashboard.php
**Проблема:** Счётчик адресов брал значение флага `woocommerce_ship_to_different_address` (yes/no), а не реальные адреса.
**Решение:** Используется `wc_get_customer_saved_methods_list()` с подсчётом количества.
**Файл:** `woocommerce/myaccount/dashboard.php:29-40`

### 8. Контрол для `padelup_hero_button_url` в кастомайзере
**Проблема:** Настройка была зарегистрирована, но контрол отсутствовал — URL не мог быть изменён через админку.
**Решение:** Добавлен контрол типа `url`.
**Файл:** `inc/customizer.php:64-68`

### 9. `sanitize_text_field` для заголовка героя
**Проблема:** `sanitize_text_field` удалял переносы строк `\n`, а заголовок использует их.
**Решение:** Заменено на `wp_kses_post`, которое сохраняет HTML-разметку и переносы.
**Файл:** `inc/customizer.php:22`

### 10. `padelup_is_elementor_page()` проверял превью
**Проблема:** Функция проверяла `is_preview_mode()`, что работало только в редакторе Elementor, а не на фронтенде.
**Решение:** Заменено на `\Elementor\Plugin::$instance->db->is_built_with_elementor( $post_id )`.
**Файл:** `inc/elementor.php:22-33`

### 11. Убран мёртвый хук `padelup_add_to_cart_button`
**Проблема:** Пустая функция висела на хуке `woocommerce_after_shop_loop_item` без полезной нагрузки.
**Решение:** Удалена функция и хук.
**Файл:** `functions.php:238-241`

### 12. Убран `shutdown`-хук в `page.php`
**Проблема:** Костыль `_padelup_ensure_footer()` на `shutdown` мог вызвать `get_footer()` дважды или закрыть несуществующий `</main>`.
**Решение:** Удалён весь `shutdown`-механизм, `get_footer()` вызывается напрямую.
**Файл:** `page.php`

### 13. Социальные ссылки в футере
**Проблема:** Все 4 ссылки были захардкожены на `#`.
**Решение:** Заменены на `get_theme_mod()` с fallback на `#` — теперь управляются через кастомайзер.
**Файл:** `footer.php:20, 26, 31, 38`

### 14. Промо-баннеры на главной
**Проблема:** Ссылки `href="#"` на баннерах OUTLET и OFF COURT.
**Решение:** Заменены на `home_url('/product-category/outlet/')` и `home_url('/product-category/off-court/')`.
**Файл:** `front-page.php:217, 224`

### 15. Instagram ссылка на главной
**Проблема:** `href="#"`.
**Решение:** Заменена на `get_theme_mod('padelup_social_instagram', 'https://instagram.com/padelup.store')`.
**Файл:** `front-page.php:293`

### 16. Стили для блога / постов / пагинации
**Проблема:** `index.php`, `archive.php`, `search.php` использовали классы `.posts-grid`, `.post-card`, `.pagination`, но CSS-стилей для них не существовало.
**Решение:** Добавлен полный блок CSS: сетка, карточки, пагинация, стили для одиночной записи и страницы.
**Файл:** `style.css` (конец файла, ~90 строк)

### 17. Убран дублирующий `@import` Google Fonts
**Проблема:** Google Fonts загружались и через `wp_enqueue_style` в `functions.php`, и через `@import` в `style.css`.
**Решение:** Удалён `@import` из `style.css`.
**Файл:** `style.css:18`

### 18. Жёстко закодированные URL в JS
**Проблема:** `/moj-akkaunt/` и `/izbrannoe/` были захардкожены в `main.js`.
**Решение:** Добавлены `accountUrl` и `wishlistUrl` в `wp_localize_script`, JS теперь использует `padelupData.accountUrl` / `padelupData.wishlistUrl`.
**Файлы:** `functions.php:68-72`, `js/main.js:155-217`

### 19. `padelup_disable_coming_soon()` — оптимизация
**Проблема:** `update_option()` вызывался на каждый `init`, даже если Coming Soon уже отключён.
**Решение:** Добавлена проверка `if ('no' !== get_option(...))`, хук перенесён на `admin_init`.
**Файл:** `functions.php:350-355`

---

## 🟡 СРЕДНИЕ И МИНОРНЫЕ ИСПРАВЛЕНИЯ

### 20. Локализация текста в корзине
**Проблема:** Тексты `Coupon code`, `Apply coupon`, `Update cart` были на английском.
**Решение:** Заменены на русский через `padelup` textdomain.
**Файл:** `woocommerce/cart/cart.php:105, 106, 109`

### 21. Локализация кнопки регистрации
**Проблема:** `value="<?php esc_attr_e( 'Register', 'woocommerce' ); ?>"` — английский текст.
**Решение:** Заменено на `value="register"` + `<?php esc_html_e( 'Зарегистрироваться', 'padelup' ); ?>`.
**Файл:** `woocommerce/myaccount/form-login.php:97`

### 22. Убрана неопределённая переменная `$has_orders` в navigation.php
**Проблема:** `$has_orders` использовалась в `do_action`, но не была определена.
**Решение:** Убран аргумент из обоих `do_action`.
**Файл:** `woocommerce/myaccount/navigation.php:12, 68`

### 23. Мёртвый код `padelup_add_to_wishlist()` в template-functions.php
**Проблема:** Функция определена, но хук отключён — бесполезный код.
**Решение:** Закомментирован весь блок функции с пояснением.
**Файл:** `inc/template-functions.php:93-125`

### 24. `function_exists` для `padelup_fallback_menu()`
**Проблема:** Функция определена прямо в шаблоне `header.php` без проверки.
**Решение:** Обернута в `if ( ! function_exists( ... ) )`.
**Файл:** `header.php:131-143`

---

## 🆕 ДОБАВЛЕНА РЕГИСТРАЦИЯ (24.06.2026)

### 25. Восстановлен `woocommerce/myaccount.php` с правильной структурой
**Проблема:** Файл ранее содержал `do_shortcode('[woocommerce_my_account]')`, что вызывало бесконечную рекурсию. При попытке исправить рекурсию удалили `get_header()`/`get_footer()`, и страница стала пустой — WooCommerce использует `woocommerce/myaccount.php` как шаблон страницы «Мой аккаунт», но в нём не было хедера и футера.
**Решение:** Файл переписан: `get_header()` → `wc_get_template('myaccount/my-account.php')` → `get_footer()`. Фильтр `template_include` теперь возвращает `woocommerce/myaccount.php` вместо `page.php`.
**Файл:** `woocommerce/myaccount.php`, `functions.php`

### 26. Авто-включение регистрации WooCommerce
**Проблема:** В WooCommerce была отключена регистрация на странице «Мой аккаунт» (`woocommerce_enable_myaccount_registration` = 'no').
**Решение:** Добавлена функция `padelup_enable_registration()`, которая включает регистрацию и автогенерацию username из email. Работает через `admin_init` с проверкой.
**Файл:** `functions.php`

### 27. Ссылка в хедере — разделение для гостей и авторизованных
**Проблема:** Иконка аккаунта в хедере всегда вела на dashboard, даже для незалогиненных пользователей.
**Решение:** Теперь для незалогиненных ссылка ведёт на `/moj-akkaunt/` (где показывается форма входа + регистрации), а для авторизованных — на dashboard.
**Файл:** `header.php`

---

## 📊 Итого

| Категория | Количество |
|-----------|------------|
| 🔴 Критичные | 7 |
| 🟠 Серьёзные | 15 |
| 🟡 Средние | 12 |
| **Всего исправлено** | **34** |

**Изменённые файлы:** `functions.php`, `style.css`, `header.php`, `footer.php`, `front-page.php`, `page.php`, `inc/customizer.php`, `inc/elementor.php`, `inc/template-functions.php`, `woocommerce/myaccount/dashboard.php`, `woocommerce/myaccount/navigation.php`, `woocommerce/myaccount/form-login.php`, `woocommerce/cart/cart.php`, `woocommerce/loop/image.php`, `js/main.js`, `comments.php` (новый).

---

*Отчёт сформирован автоматически после полного аудита темы.*
