jQuery(document).ready(function ($) {
    let page = 1;
    let loading = false;
    let maxPage = 1;
    let selectedCategory = '';

    let urlProducts = '/wp-json/api/v1/products';
    let urlCategories = '/wp-json/api/v1/categories';

    function loadProducts(reset = false) {
        if (reset) {
            page = 1; // Сбрасываем страницу до проверки
            maxPage = 1; // Сбрасываем maxPage
            $('#product-list').empty();
        }

        if (loading || page > maxPage) return;
        loading = true;

        $.ajax({
            url: urlProducts,
            method: 'GET',
            data: {
                page: page,
                orderby: $('#sort').val(),
                order: $('#sort-order').val(),
                search: $('#search').val(),
                category: selectedCategory
            },
            beforeSend: function () {
                $('#loader').show();
            },
            success: function (response) {

                maxPage = response.max_page || 1; // Обновляем maxPage

                if (response.products.length) {
                    response.products.forEach(product => {
                        $('#product-list').append(`
                            <div class="product">
                                <img src="${product.thumbnail}" alt="${product.title}">
                                <h2>${product.title}</h2>
                                <p class="category">${product.categories.join(', ')}</p>
                                <p class="price">${product.price} ${product.currency}</p>
                                <p class="short-desc">${product.short_description}</p>
                                <button class="add-to-cart" data-id="${product.id}">В корзину</button>
                                <br>
                                <a href="${product.link}" class="view-product">Подробнее</a>
                            </div>
                        `);
                    });
                    page++;
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error("Ошибка запроса:", textStatus, errorThrown);
            },
            complete: function () {
                $('#loader').hide();
                loading = false;
            }
        });
    }

    function loadCategories() {
        $.ajax({
            url: urlCategories,
            method: 'GET',
            success: function (categories) {
                let categoryHtml = `<button class="category-filter category-active" data-category="">Все категории</button>`;
                categories.forEach(category => {
                    categoryHtml += `<button class="category-filter" data-category="${category.slug}">${category.name}</button>`;
                });
                $('#categories').html(categoryHtml);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error("Ошибка загрузки категорий:", textStatus, errorThrown);
            }
        });
    }

    function updateCartCount() {
        // Запрос для получения актуального количества товаров в корзине
        $.get('/?wc-ajax=get_refreshed_fragments', function (response) {
            // Извлекаем обновлённое количество товаров
            if (response && response.fragments && response.fragments['div.widget_shopping_cart_content']) {
                var tempDiv = $('<div>').html(response.fragments['div.widget_shopping_cart_content']);
                var count = tempDiv.find('.woocommerce-mini-cart-item').length; // Считаем товары
                //alert(count);
                var cartLink = $('.site-header a[href*="cart"]'); // Ищем ссылку "Корзина"

                if (cartLink.length) {
                    cartLink.find('.cart-count').remove(); // Удаляем старый счетчик

                    if (count > 0) {
                        cartLink.append('<span class="cart-count">' + count + '</span>'); // Добавляем новый
                    }
                }
            }


        });
    }

    $(document).on('click', '.category-filter', function () {
        $('.category-filter').removeClass('category-active');
        $(this).addClass('category-active');
        selectedCategory = $(this).data('category');

        $('#search').val('');
        $('#sort').val('date');
        $('#sort-order').val('DESC');

        loadProducts(true);
    });

    $(document).on('click', '.clear-cart-button', function () {
        // alert('cdcd');
        // clearCart();


        $.ajax({
            url: '/wp-json/api/v1/clear-cart/', // Новый маршрут для очистки корзины
            type: 'POST',
            success: function (response) {
                if (response.success) {
                    location.reload(); // Обновляем страницу для отображения пустой корзины
                }
            },
            error: function () {
                alert('Ошибка при очистке корзины');
            }
        });
    });

    $('#sort, #sort-order, #search').on('change keyup', function () {
        loadProducts(true);
    });

    $(document).on('click', '.add-to-cart', function () {
        var productId = $(this).data('id');
        $.ajax({
            url: '/?wc-ajax=add_to_cart',  // URL для добавления в корзину
            type: 'POST',
            data: {
                product_id: productId,
                quantity: 1,
            },
            beforeSend: function () {
                // Можно добавить обработчик до отправки запроса (например, показать индикатор загрузки)
            },
            success: function (response) {
                // Тут обрабатываем успешный ответ
                console.log('Товар добавлен в корзину!');
                updateCartCount();  // Обновляем количество товаров в корзине
            },
            error: function () {
                alert('Ошибка добавления товара.');
            }
        });
    });

    $(window).on('scroll', function () {
        if ($(window).scrollTop() + $(window).height() >= $(document).height() - 100) {
            loadProducts();
        }
        // if ($(window).scrollTop() > 500) {
        //     $('#scroll-top').fadeIn();
        // } else {
        //     $('#scroll-top').fadeOut();
        // }
    });
    //
    // $('#scroll-top').on('click', function () {
    //     $('html, body').animate({ scrollTop: 0 }, 'fast');
    // });

    updateCartCount();
    loadCategories();
    loadProducts();

    var interval = setInterval(function(){
        if ($('.wc-block-cart__submit').length) {

            clearInterval(interval);

            // 1. Создаем кнопку "Очистить корзину"
            var clearCartButton = $('<a>', {
                text: 'Очистить корзину',
                class: 'clear-cart-button wc-block-components-button__text'
            });

            // 2. Добавляем кнопку под ссылку "Перейти к оформлению заказа"
            $('.wc-block-cart__submit').append(clearCartButton);
        }
    }, 0);


    // Проверяем, была ли уже принята политика куки
    if (!localStorage.getItem('cookie_accepted')) {
        $('#cookie-consent').show();  // Показываем попап
    }

    // Обработчик для кнопки "Принять"
    $('#accept-cookies').on('click', function() {
        // Сохраняем информацию, что пользователь принял куки
        localStorage.setItem('cookie_accepted', 'true');

        // Скрываем попап
        $('#cookie-consent').hide();
    });

});