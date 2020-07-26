<?php
if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

require_once('1c_client.php');


$products = get_posts(array(
    'numberposts'	=> -1,
    'post_type'		=> 'product',
    'meta_query' => array(
        array(
            'key' => 'id_1c',
            'value'   => array(''),
            'compare' => 'NOT IN'
        )
    )
));
if (empty($products)){
    return ;
}

//error_reporting(E_ALL);

$client = new One_c_client(get_option('1c_url'),[
    'auth' => [
        get_option('1c_login'),
        get_option('1c_pass')
    ],
    'timeout' => 300,
]);

foreach ($products as $key => $product) {
    $uuid = get_field('id_1c', $product->ID);
    $data = $client->{'AccumulationRegister_ТоварыНаСкладах/Balance'}->custom_get("Dimensions='Номенклатура',Condition='Номенклатура_Key eq guid'" . $uuid . "''");

    if (!$client->isOk()) {
        echo '<pre>';
        var_dump('Something went wrong: ', $client->getHttpErrorCode(), $client->getHttpErrorMessage(), $client->getErrorCode(), $client->getErrorMessage(), $data->toArray());
        echo "</pre>";
    } else {
        $values = $data->values();
        if ($values[0]['Номенклатура_Key'] == $uuid) {
            $is_manage = get_post_meta($product->ID, '_manage_stock', 1);
            if (empty($is_manage) || $is_manage == 'no') {
                if ($values[0]['КоличествоBalance'] > 0) {
                    update_post_meta($product->ID, '_stock_status', 'instock');
                } else {
                    update_post_meta($product->ID, '_stock_status', 'outofstock');
                }
            } else {
                update_post_meta($product->ID, '_stock', $values[0]['КоличествоBalance']);
            }
        }
    }
    /*
    echo "<pre>";
    print_r($data->values());
    echo "</pre>";//*/
}
