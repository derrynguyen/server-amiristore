<?php
header( 'Access-Control-Allow-Origin: *' );
header( 'Content-Type: application/json' );
header( 'Access-Control-Allow-Methods: POST' );
header( 'Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With' );

include_once( '../../config/db.php' );

$db = new db();
$connect = $db->connect();

// Get the product data from the request body
$id = $_GET[ 'id' ];
$amount = $_POST[ 'amount' ];

$sql = 'UPDATE orders SET amount = :amount WHERE id = :id';
$stmt = $connect->prepare( $sql );
$stmt->bindParam( ':id', $id, PDO::PARAM_INT );
$stmt->bindParam( ':amount', $amount, PDO::PARAM_STR );

if ( $stmt->execute() ) {
    http_response_code( 200 );
} else {
    http_response_code( 400 );
}

