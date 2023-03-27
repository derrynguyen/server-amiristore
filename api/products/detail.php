<?php

header( 'Access-Control-Allow-Origin:*' );
header( 'Content-Type: application/json' );

include_once( '../../config/db.php' );
include_once( '../../model/products.php' );

$db = new db();
$connect = $db->connect();

$products = new Products( $connect );
$products->id = isset( $_GET[ 'id' ] )? $_GET[ 'id' ]:die();

$products->detail();

$products_detail = array(

    'id'=> $products->id,
    'name_brand'=> $products->name_brand,
    'name'=> $products->name,
    'img'=> $products->img,
    'img2'=> $products->img2,
    'img3'=> $products->img3,
    'price'=> $products->price,
    'sex'=> $products->sex,
    'type'=> $products->type,
    'color'=> $products->color,
    'addreas'=> $products->addreas,
    'session'=> $products->session,
    'amount'=> $products->amount,
);
print_r( json_encode( $products_detail ) );

?>