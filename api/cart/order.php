<?php
header( 'Content-type: text/plain; charset=utf-8' );
header( 'Access-Control-Allow-Origin:*' );
header( 'Content-Type: application/json' );

include_once( '../../config/db.php' );
include_once( '../../model/order.php' );

$db = new db();
$connect = $db->connect();

if ( isset( $_GET[ 'getIDUser' ] ) ) {
    $id = $_GET[ 'getIDUser' ];

    $order = new Order( $connect );
    $read = $order->read( $id );

    $num = $read->rowCount();

    if ( $num > 0 ) {
        $products_array = [];
        $products_array[ 'data' ] = [];

        while ( $row = $read->fetch( PDO::FETCH_ASSOC ) ) {
            extract( $row );

            $products_item = array(
                'id' => $id,
                'id_user' => $id_user,
                'name_brand' => $name_brand,
                'name' => $name,
                'img' => $img,
                'price' => $price,
                'color' => $color,
                'session' => $session,
                'size' => $size,
                'amount' => $amount,
            );

            array_push( $products_array[ 'data' ], $products_item );
        }

        echo json_encode( $products_array, JSON_UNESCAPED_UNICODE );
    } else {
        echo json_encode( array( 'message' => 'No products found.' ) );
    }
} else {
    echo json_encode( array( 'message' => 'getIDUser parameter is missing.' ) );
}
?>
