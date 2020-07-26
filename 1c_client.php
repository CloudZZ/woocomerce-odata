<?php if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
use OData\Client\ConnectionFactory;
use Kily\Tools1C\OData\Client;


require __DIR__ . '/vendor/autoload.php';
class One_c_client extends Client
{
    function custom_get($request, $options = array()){
        $this->requested[] = '(' . $request . ')';
        return $this->request('GET', $options);
    }
}