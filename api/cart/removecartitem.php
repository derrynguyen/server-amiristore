<?php
header( 'Access-Control-Allow-Origin: *' );
header( 'Content-Type: application/json' );
header( 'Access-Control-Allow-Methods: DELETE' );
header( 'Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With' );

include_once( '../../config/db.php' );

$db = new db();
$connect = $db->connect();

$id = $_GET[ 'id' ];

$sql = 'DELETE FROM orders WHERE id = :id';
$stmt = $connect->prepare( $sql );
$stmt->bindValue( ':id', $id, PDO::PARAM_INT );

if ( $stmt->execute() ) {
    http_response_code( 200 );
    echo json_encode( [ 'success' => 'Xóa sản phẩm ra khỏi giỏ hàng thành công' ] );
} else {
    http_response_code( 400 );
    echo json_encode( [ 'error' => 'Xóa sản phẩm ra khỏi giỏ hàng thất bại.' ] );
}

