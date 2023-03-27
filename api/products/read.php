<?php
header( 'Content-type: text/plain; charset=utf-8' );
header( 'Access-Control-Allow-Origin:*' );
header( 'Content-Type: application/json' );

include_once( '../../config/db.php' );
include_once( '../../model/products.php' );

$db = new db();
$connect = $db->connect();

$products = new Products( $connect );
$read = $products->read();

$num  = $read->rowCount();

if ( $num>0 ) {
    $products_array = [];
    $products_array[ 'data' ] = [];

    while( $row = $read->fetch( PDO::FETCH_ASSOC ) ) {
        extract( $row );

        $products_item = array(

            'id'=> $id,
            'name_brand'=> $name_brand,
            'name'=> $name,
            'img'=> $img,
            'img2'=> $img2,
            'img3'=> $img3,
            'price'=> $price,
            'sex'=> $sex,
            'type'=> $type,
            'color'=> $color,
            'addreas'=> $addreas,
            'session'=> $session,
            'amount'=> $amount,

        );
        array_push( $products_array[ 'data' ], $products_item );
    }
    echo json_encode( $products_array, JSON_UNESCAPED_UNICODE );
}

?>