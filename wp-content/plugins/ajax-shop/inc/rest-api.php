<?php
if (!defined('ABSPATH')) {
    exit;
}

function cas_get_products(WP_REST_Request $request) {
    $args = [
        'post_type'      => 'product',
        'posts_per_page' => 6,
        'paged'          => $request->get_param('page') ?: 1,
        'orderby'        => $request->get_param('orderby') ?: 'date',
        'order'          => $request->get_param('order') ?: 'DESC',
        's'              => $request->get_param('search') ?: '',
    ];

    if ($request->get_param('category')) {
        $args['tax_query'] = [
            [
                'taxonomy' => 'product_cat',
                'field'    => 'slug',
                'terms'    => sanitize_text_field($request->get_param('category')),
                'operator' => 'IN',
                'include_children' => false,
            ]
        ];
    }

    $query = new WP_Query($args);
    $products = [];

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            global $product;
            $products[] = [
                'id'        => get_the_ID(),
                'title'     => get_the_title(),
                'price'     => $product->get_price(),
                'thumbnail' => get_the_post_thumbnail_url(get_the_ID(), 'medium'),
                'link'      => get_permalink(),
                'categories' => wp_get_post_terms(get_the_ID(), 'product_cat', ['fields' => 'names']),
                'currency'   => get_woocommerce_currency_symbol(),
            ];
        }
    }
    wp_reset_postdata();

    return rest_ensure_response([
        'products' => $products,
        'max_page' => $query->max_num_pages
    ]);
}

function cas_get_categories() {
    $categories = get_terms([
        'taxonomy'   => 'product_cat',
        'hide_empty' => true,
    ]);

    $result = [];

    if (!empty($categories) && !is_wp_error($categories)) {
        foreach ($categories as $category) {
            $result[] = [
                'id'    => $category->term_id,
                'name'  => $category->name,
                'slug'  => $category->slug,
            ];
        }
    }

    return rest_ensure_response($result);
}

// Регистрация маршрутов API
add_action('rest_api_init', function () {
    register_rest_route('api/v1', '/products/', [
        'methods'  => 'GET',
        'callback' => 'cas_get_products',
        'permission_callback' => '__return_true',
    ]);

    register_rest_route('api/v1', '/categories/', [
        'methods'  => 'GET',
        'callback' => 'cas_get_categories',
        'permission_callback' => '__return_true',
    ]);
});