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

// Add new sorting options to WooCommerce
function add_stock_quantity_sorting_options($sorting_options) {
    $new_options = array(
        'stock_quantity_desc' => __('Sort by stock: High to Low', 'wc-sort-by-stock'),
        'stock_quantity_asc' => __('Sort by stock: Low to High', 'wc-sort-by-stock')
    );
    
    // Get the 'menu_order' option if it exists
    $menu_order = array();
    if (isset($sorting_options['menu_order'])) {
        $menu_order = array('menu_order' => $sorting_options['menu_order']);
        unset($sorting_options['menu_order']);
    }
    
    // Add new options at the end
    return array_merge(
        $menu_order,
        $sorting_options,
        $new_options
    );
}
add_filter('woocommerce_catalog_orderby', 'add_stock_quantity_sorting_options');

// Add new sorting parameters
function add_stock_quantity_sorting_args($args) {
    if (isset($_GET['orderby'])) {
        switch ($_GET['orderby']) {
            case 'stock_quantity_desc':
                $args['orderby'] = 'meta_value_num';
                $args['meta_key'] = '_stock';
                $args['order'] = 'DESC';
                break;
            case 'stock_quantity_asc':
                $args['orderby'] = 'meta_value_num';
                $args['meta_key'] = '_stock';
                $args['order'] = 'ASC';
                break;
        }
    }
    return $args;
}
add_filter('woocommerce_get_catalog_ordering_args', 'add_stock_quantity_sorting_args');
