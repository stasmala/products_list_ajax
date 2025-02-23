<?php
/**
 * Plugin Name: AJAX Shop
 * Description: Плагин для AJAX-подгрузки товаров, сортировки, поиска и корзины.
 * Version: 1.0
 * Author: rabotasmala
 */

if (!defined('ABSPATH')) {
    exit; // Защита от прямого доступа
}

// Подключаем скрипты
function cas_enqueue_scripts() {
    wp_enqueue_script('ajax-shop', plugin_dir_url(__FILE__) . 'assets/js/ajax-shop.js', ['jquery'], null, true);
    wp_localize_script('ajax-shop', 'cas_ajax', ['ajax_url' => rest_url('api/v1/products')]);

    wp_enqueue_style('ajax-shop-style', plugin_dir_url(__FILE__) . 'assets/css/ajax-shop.css');
}
add_action('wp_enqueue_scripts', 'cas_enqueue_scripts');

// Подключаем API маршруты
include_once plugin_dir_path(__FILE__) . 'inc/rest-api.php';
