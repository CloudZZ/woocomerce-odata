<?php
/*
Plugin Name: 1C Sync
Description: 1C synchronization
Version: 1.0
Author: Eugene Bolikhov
*/


if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


register_activation_hook(__FILE__, 'one_c_sync_activation');

function one_c_sync_activation() {
    if (! wp_next_scheduled ( '1c_sync' )) {
        wp_schedule_event(time(), 'daily', 'one_c_cron_event');
    }

}

add_action('one_c_cron_event', 'one_c_cron');

function one_c_cron(){
    require_once('cron.php');
}

if ( is_admin() ) {
    add_action('admin_menu', 'one_c_plugin_menu');
    add_action('admin_init', 'one_c_register_settings' );
}
function one_c_plugin_menu() {
    add_options_page('1C Settings', '1C Settings', 'manage_options', 'one-c-settings', 'one_c_plugin_page');
}

function one_c_register_settings() { // whitelist options
    register_setting( '1c-option-group', '1c_url' );
    register_setting( '1c-option-group', '1c_login' );
    register_setting( '1c-option-group', '1c_pass' );
}

function one_c_plugin_page(){
    require_once('options_page.php');
}
/*
add_action('woocommerce_product_options_general_product_data', 'one_c_woocommerce_product_fields');
// Save Fields
add_action('woocommerce_process_product_meta', 'one_c_woocommerce_product_fields_save');

function one_c_woocommerce_product_fields()
{
    global $woocommerce, $post;
    echo '<div class="product_custom_field">';
    // Custom Product Text Field
    woocommerce_wp_text_input(
        array(
            'id' => '1c_uuid',
            'placeholder' => 'fab61b12-a6c7-11e9-8c06-5cf9dd7159f8',
            'label' => __('1C Sync UUID', 'woocommerce'),
            'desc_tip' => 'true'
        )
    );
    //Custom Product Number Field
    echo '</div>';
}

function one_c_woocommerce_product_fields_save($post_id)
{
    // Custom Product Text Field
    $woocommerce_custom_product_text_field = $_POST['1c_uuid'];
    if (!empty($woocommerce_custom_product_text_field)) {
        update_post_meta($post_id, '1c_uuid', esc_attr($woocommerce_custom_product_text_field));
    }

}
*/
