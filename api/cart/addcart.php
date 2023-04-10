<?php
header( 'Access-Control-Allow-Origin: *' );
header( 'Content-Type: application/json' );
header( 'Access-Control-Allow-Methods: POST' );
header( 'Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With' );

include_once( '../../config/db.php' );

$db = new db();
$connect = $db->connect();

// Process image upload
$id_user = $_POST[ 'id_user' ];
$name_brand = $_POST[ 'name_brand' ];
$name = $_POST[ 'name' ];
$img = $_POST[ 'img' ];
$price = $_POST[ 'price' ];
$color = $_POST[ 'color' ];
$session = $_POST[ 'session' ];
$size = $_POST[ 'size' ];
$amount = $_POST[ 'amount' ];

if ( $size == null ) {
    echo json_encode( array( 'error' => 'Vui lòng chọn SIZE' ) );
    exit();
}
if ( $amount == null ) {
    echo json_encode( array( 'error' => 'Vui lòng thêm số lượng' ) );
    exit();
}

// Insert data into database
$stmt = $connect->prepare( 'INSERT INTO orders (id_user, name_brand,name,img,price,color,session,size,amount) 
VALUES (:id_user, :name_brand,:name,:img,:price,:color,:session,:size,:amount)' );
$stmt->bindParam( ':id_user', $_POST[ 'id_user' ] );
$stmt->bindParam( ':name_brand', $_POST[ 'name' ] );
$stmt->bindParam( ':name', $name );
$stmt->bindParam( ':img', $_POST[ 'img' ] );
$stmt->bindParam( ':price', $_POST[ 'price' ] );
$stmt->bindParam( ':color', $_POST[ 'color' ] );
$stmt->bindParam( ':session', $_POST[ 'session' ] );
$stmt->bindParam( ':size', $_POST[ 'size' ] );
$stmt->bindParam( ':amount', $_POST[ 'amount' ] );

if ( $stmt->execute() ) {
    http_response_code( 200 );
    echo json_encode( [ 'success' => 'Thêm giỏ hàng thành công' ] );
} else {
    http_response_code( 400 );
    echo json_encode( [ 'error' => 'Thêm giỏ hàng thất bại' ] );
}
