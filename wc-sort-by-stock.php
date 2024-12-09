<?php
/**
 * Plugin Name: WooCommerce Sort by Stock
 * Plugin URI: https://github.com/mohamedyussry/wc-sort-by-stock
 * Description: A WooCommerce plugin that adds the ability to sort products by their stock quantity
 * Version: 1.0.0
 * Author: Mohamed Yussry
 * Author URI: https://github.com/mohamedyussry
 * Text Domain: wc-sort-by-stock
 * Requires at least: 5.0
 * Requires PHP: 7.2
 * WC requires at least: 3.0
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Check if WooCommerce is active
if (!in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
    return;
}

// Add new sorting option to WooCommerce
function add_stock_quantity_sorting_option($sorting_options) {
    $sorting_options['stock_quantity'] = __('Sort by stock quantity', 'wc-sort-by-stock');
    return $sorting_options;
}
add_filter('woocommerce_catalog_orderby', 'add_stock_quantity_sorting_option');

// Add new sorting parameters
function add_stock_quantity_sorting_args($args) {
    if (isset($_GET['orderby'])) {
        if ('stock_quantity' === $_GET['orderby']) {
            $args['orderby'] = 'meta_value_num';
            $args['meta_key'] = '_stock';
            $args['order'] = 'DESC';
        }
    }
    return $args;
}
add_filter('woocommerce_get_catalog_ordering_args', 'add_stock_quantity_sorting_args');
