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
                                <p>${product.categories.join(', ')}</p>
                                <p>${product.price} ${product.currency}</p>
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

    $(document).on('click', '.category-filter', function () {
        $('.category-filter').removeClass('category-active');
        $(this).addClass('category-active');
        selectedCategory = $(this).data('category');

        $('#search').val('');
        $('#sort').val('date');
        $('#sort-order').val('DESC');

        loadProducts(true);
    });

    $('#sort, #sort-order, #search').on('change keyup', function () {
        loadProducts(true);
    });

    $(window).on('scroll', function () {
        if ($(window).scrollTop() + $(window).height() >= $(document).height() - 100) {
            loadProducts();
        }

        if ($(window).scrollTop() > 500) {
            $('#scroll-top').fadeIn();
        } else {
            $('#scroll-top').fadeOut();
        }
    });

    $('#scroll-top').on('click', function () {
        $('html, body').animate({ scrollTop: 0 }, 'fast');
    });

    loadCategories();
    loadProducts();
});