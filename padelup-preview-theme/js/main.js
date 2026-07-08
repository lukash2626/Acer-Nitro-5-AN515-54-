/**
 * PadelUp Theme Main JavaScript
 *
 * @package PadelUp
 */

(function() {
    'use strict';

    // Mobile Menu Toggle
    const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
    const mobileMenu = document.getElementById('mobile-menu');
    const mobileMenuClose = document.getElementById('mobile-menu-close');

    if (mobileMenuToggle && mobileMenu) {
        mobileMenuToggle.addEventListener('click', function() {
            mobileMenu.classList.add('active');
            document.body.style.overflow = 'hidden';
        });
    }

    if (mobileMenuClose && mobileMenu) {
        mobileMenuClose.addEventListener('click', function() {
            mobileMenu.classList.remove('active');
            document.body.style.overflow = '';
        });
    }

    // Close mobile menu on link click
    if (mobileMenu) {
        const menuLinks = mobileMenu.querySelectorAll('a');
        menuLinks.forEach(function(link) {
            link.addEventListener('click', function() {
                mobileMenu.classList.remove('active');
                document.body.style.overflow = '';
            });
        });
    }

    // Hero Slider
    const heroDots = document.querySelectorAll('.hero__dot');
    const heroPrev = document.querySelector('.hero__arrow--prev');
    const heroNext = document.querySelector('.hero__arrow--next');
    let currentSlide = 0;

    function updateSlider(index) {
        heroDots.forEach(function(dot, i) {
            dot.classList.toggle('active', i === index);
        });
        currentSlide = index;
    }

    heroDots.forEach(function(dot) {
        dot.addEventListener('click', function() {
            const slideIndex = parseInt(this.dataset.slide);
            updateSlider(slideIndex);
        });
    });

    if (heroNext) {
        heroNext.addEventListener('click', function() {
            updateSlider((currentSlide + 1) % heroDots.length);
        });
    }

    if (heroPrev) {
        heroPrev.addEventListener('click', function() {
            updateSlider((currentSlide - 1 + heroDots.length) % heroDots.length);
        });
    }

    // Auto-slide (only if hero exists)
    var heroInterval = null;
    if (heroDots.length > 0) {
        heroInterval = setInterval(function() {
            updateSlider((currentSlide + 1) % heroDots.length);
        }, 5000);
    }

    // Header scroll effect
    const header = document.getElementById('header');
    let lastScroll = 0;

    if (header) {
        window.addEventListener('scroll', function() {
            const currentScroll = window.pageYOffset;

            if (currentScroll > 100) {
                header.style.boxShadow = '0 2px 20px rgba(0,0,0,0.1)';
            } else {
                header.style.boxShadow = 'none';
            }

            lastScroll = currentScroll;
        });
    }

    // Brand filter toggle
    const brandFilters = document.querySelectorAll('.brand-filter');
    brandFilters.forEach(function(filter) {
        filter.addEventListener('click', function() {
            this.classList.toggle('active');
        });
    });

    // Search toggle
    const searchToggle = document.getElementById('search-toggle');
    if (searchToggle) {
        searchToggle.addEventListener('click', function() {
            const searchForm = document.querySelector('.search-form');
            if (searchForm) {
                searchForm.classList.toggle('active');
            }
        });
    }

    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(function(anchor) {
        anchor.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            if (href !== '#') {
                e.preventDefault();
                const target = document.querySelector(href);
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            }
        });
    });

    // Product card hover effect (handled by CSS)

    // Wishlist button click
    document.addEventListener('click', function(e) {
        var wishlistBtn = e.target.closest('.product-card__wishlist, .single-product__wishlist');
        if (!wishlistBtn) return;

        e.preventDefault();
        e.stopPropagation();

        var productId = wishlistBtn.dataset.productId;
        if (!productId) return;

        if (typeof padelupData === 'undefined') {
            window.location.href = '/moj-akkaunt/';
            return;
        }

        var formData = new FormData();
        formData.append('action', 'padelup_toggle_wishlist');
        formData.append('product_id', productId);
        formData.append('nonce', padelupData.nonce);

        fetch(padelupData.ajaxurl, {
            method: 'POST',
            body: formData
        })
        .then(function(response) { return response.json(); })
        .then(function(data) {
            if (data.success) {
                var isActive = data.data.in_wishlist;
                var newCount = data.data.count;

                if (wishlistBtn.classList.contains('single-product__wishlist')) {
                    if (isActive) {
                        wishlistBtn.classList.add('active');
                        wishlistBtn.querySelector('span').textContent = 'В избранном';
                    } else {
                        wishlistBtn.classList.remove('active');
                        wishlistBtn.querySelector('span').textContent = 'В избранное';
                    }
                } else {
                    if (isActive) {
                        wishlistBtn.classList.add('active');
                        var svg = wishlistBtn.querySelector('svg');
                        if (svg) svg.setAttribute('fill', 'var(--color-primary)');
                    } else {
                        wishlistBtn.classList.remove('active');
                        var svg = wishlistBtn.querySelector('svg');
                        if (svg) svg.setAttribute('fill', 'none');
                    }
                }

                // Update wishlist count badge in header
                var wishlistLink = document.getElementById('header-wishlist');
                if (wishlistLink) {
                    var badge = wishlistLink.querySelector('.header__wishlist-count');
                    if (newCount > 0) {
                        if (badge) {
                            badge.textContent = newCount;
                        } else {
                            var countEl = document.createElement('span');
                            countEl.className = 'header__wishlist-count';
                            countEl.textContent = newCount;
                            wishlistLink.appendChild(countEl);
                        }
                    } else {
                        if (badge) badge.remove();
                    }
                }

                setTimeout(function() {
                    window.location.href = padelupData.wishlistUrl ? padelupData.wishlistUrl : '/izbrannoe/';
                }, 500);
            } else {
                window.location.href = padelupData.accountUrl ? padelupData.accountUrl : '/moj-akkaunt/';
            }
        })
        .catch(function() {
            window.location.href = '/moj-akkaunt/';
        });
    });

    // AJAX Add to Cart
    document.addEventListener('click', function(e) {
        var cartBtn = e.target.closest('.product-card__cart-btn');
        if (!cartBtn) return;

        e.preventDefault();
        e.stopPropagation();

        var productId = cartBtn.dataset.productId;
        if (!productId) return;

        var originalHTML = cartBtn.innerHTML;
        cartBtn.innerHTML = '<span style="display:inline-block;width:18px;height:18px;border:2px solid #fff;border-top-color:transparent;border-radius:50%;animation:spin 0.6s linear infinite;"></span>';
        cartBtn.disabled = true;
        cartBtn.style.background = '#999';

        var formData = new FormData();
        formData.append('product_id', productId);
        formData.append('quantity', '1');

        fetch('/?wc-ajax=add_to_cart', {
            method: 'POST',
            body: formData
        })
        .then(function(response) { return response.json(); })
        .then(function(data) {
            if (data.fragments) {
                cartBtn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>';
                cartBtn.style.background = '#4CAF50';

                var cartLink = document.querySelector('a[aria-label="\u041a\u043e\u0440\u0437\u0438\u043d\u0430"]');
                if (cartLink) {
                    var badge = cartLink.querySelector('.header__cart-count');
                    if (badge) {
                        var newCount = (parseInt(badge.textContent) || 0) + 1;
                        badge.textContent = newCount;
                    } else {
                        var countEl = document.createElement('span');
                        countEl.className = 'header__cart-count';
                        countEl.textContent = '1';
                        cartLink.appendChild(countEl);
                    }
                }

                setTimeout(function() {
                    cartBtn.innerHTML = originalHTML;
                    cartBtn.style.background = '';
                    cartBtn.disabled = false;
                }, 2000);
            } else {
                cartBtn.innerHTML = originalHTML;
                cartBtn.style.background = '';
                cartBtn.disabled = false;
            }
        })
        .catch(function() {
            cartBtn.innerHTML = originalHTML;
            cartBtn.style.background = '';
            cartBtn.disabled = false;
        });
    });

    // Newsletter form
    document.addEventListener('submit', function(e) {
        const form = e.target.closest('.newsletter__form');
        if (form) {
            e.preventDefault();
            const input = form.querySelector('.newsletter__input');
            if (input && input.value) {
                const btn = form.querySelector('.newsletter__btn');
                const originalText = btn.textContent;
                btn.textContent = '✓';
                btn.style.background = '#4CAF50';
                input.value = '';

                setTimeout(function() {
                    btn.textContent = originalText;
                    btn.style.background = '';
                }, 2000);
            }
        }
    });

    // Lazy loading images
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    if (img.dataset.src) {
                        img.src = img.dataset.src;
                        img.removeAttribute('data-src');
                    }
                    imageObserver.unobserve(img);
                }
            });
        });

        document.querySelectorAll('img[data-src]').forEach(function(img) {
            imageObserver.observe(img);
        });
    }

    // CART PAGE: Quantity +/- buttons
    document.addEventListener('click', function(e) {
        var btn = e.target.closest('.cart-table__col--quantity .minus, .cart-table__col--quantity .plus');
        if (!btn) return;

        e.preventDefault();
        e.stopPropagation();

        var qtyInput = btn.parentElement.querySelector('.qty');
        if (!qtyInput) return;

        var currentVal = parseInt(qtyInput.value) || 1;
        var min = parseInt(qtyInput.getAttribute('min')) || 1;
        var max = parseInt(qtyInput.getAttribute('max')) || 999;

        if (btn.classList.contains('plus')) {
            if (currentVal < max) qtyInput.value = currentVal + 1;
        } else {
            if (currentVal > min) qtyInput.value = currentVal - 1;
        }

        qtyInput.dispatchEvent(new Event('input', { bubbles: true }));
        qtyInput.dispatchEvent(new Event('change', { bubbles: true }));

        enableUpdateCartButton();
    });

    // CART PAGE: Enable update cart button on any cart change
    function enableUpdateCartButton() {
        var updateBtn = document.querySelector('.update-cart-button');
        if (updateBtn) {
            updateBtn.removeAttribute('disabled');
            updateBtn.style.opacity = '1';
            updateBtn.style.cursor = 'pointer';
        }
    }

    document.addEventListener('change', function(e) {
        if (e.target.closest('.cart-table__col--quantity')) {
            enableUpdateCartButton();
        }
    });

    // Remove WooCommerce disabled on update button
    if (document.querySelector('.update-cart-button')) {
        var observer = new MutationObserver(function() {
            enableUpdateCartButton();
        });
        observer.observe(document.querySelector('.update-cart-button').parentElement, { attributes: true, attributeFilter: ['disabled'] });
        setTimeout(enableUpdateCartButton, 500);
        setTimeout(enableUpdateCartButton, 1500);
    }

    // CART PAGE: Remove item via AJAX
    document.addEventListener('click', function(e) {
        var removeBtn = e.target.closest('.remove_from_cart_button');
        if (!removeBtn) return;

        e.preventDefault();

        var productId = removeBtn.dataset.product_id;
        var cartItemKey = removeBtn.dataset.cart_item_key;
        if (!productId || !cartItemKey) {
            window.location.href = removeBtn.href;
            return;
        }

        var cartItem = removeBtn.closest('.cart-table__item');
        if (cartItem) {
            cartItem.style.opacity = '0.5';
            cartItem.style.pointerEvents = 'none';
        }

        var formData = new FormData();
        formData.append('product_id', productId);
        formData.append('cart_item_key', cartItemKey);

        fetch('/?wc-ajax=remove_from_cart', {
            method: 'POST',
            body: formData
        })
        .then(function(response) { return response.json(); })
        .then(function(data) {
            if (data.fragments) {
                window.location.reload();
            } else {
                window.location.href = removeBtn.href;
            }
        })
        .catch(function() {
            window.location.href = removeBtn.href;
        });
    });

    // Elementor compatibility
    if (typeof jQuery !== 'undefined') {
        jQuery(document).on('elementor/popup/show', function() {
            document.body.classList.add('elementor-popup-active');
        });

        jQuery(document).on('elementor/popup/hide', function() {
            document.body.classList.remove('elementor-popup-active');
        });
    }

})();