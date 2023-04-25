<?php
header( 'Access-Control-Allow-Origin: *' );
header( 'Content-Type: application/json' );
header( 'Access-Control-Allow-Methods: POST' );
header( 'Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With' );

include_once( '../../config/db.php' );

$db = new db();
$connect = $db->connect();

// Process image upload
$name_brand = $_POST[ 'name_brand' ];
$name = $_POST[ 'name' ];
$img2 = $_POST[ 'img2' ];
$img3 = $_POST[ 'img3' ];
$price = $_POST[ 'price' ];
$sex = $_POST[ 'sex' ];
$type = $_POST[ 'type' ];
$color = $_POST[ 'color' ];
$addreas = $_POST[ 'addreas' ];
$session = $_POST[ 'session' ];
$amount = $_POST[ 'amount' ];
$rate = $_POST[ 'rate' ];

if ( empty( $name ) ) {
    echo json_encode( array( 'error' => 'Vui lòng nhập tên sản phẩm' ) );
    exit();
}
if ( empty( $name_brand ) ) {
    echo json_encode( array( 'error' => 'Vui lòng nhập tên thương hiệu' ) );
    exit();
}
if ( empty( $price ) ) {
    echo json_encode( array( 'error' => 'Vui lòng nhập giá' ) );
    exit();
}
if ( empty( $sex ) ) {
    echo json_encode( array( 'error' => 'Vui lòng thêm giới tính' ) );
    exit();
}
if ( empty( $type ) ) {
    echo json_encode( array( 'error' => 'Vui lòng thêm loại quần áo' ) );
    exit();
}
if ( empty( $color ) ) {
    echo json_encode( array( 'error' => 'Vui lòng thêm màu sắc' ) );
    exit();
}
if ( empty( $addreas ) ) {
    echo json_encode( array( 'error' => 'Vui lòng thêm nơi sản xuất' ) );
    exit();
}
if ( empty( $session ) ) {
    echo json_encode( array( 'error' => 'Vui lòng thêm phiên bản' ) );
    exit();
}
if ( empty( $amount ) ) {
    echo json_encode( array( 'error' => 'Vui lòng thêm số lượng' ) );
    exit();
}
$upload_dir = 'D:/xampp/htdocs/inc/src/images/items/';
$image_name = $_FILES[ 'img' ][ 'name' ];
$image_temp = $_FILES[ 'img' ][ 'tmp_name' ];
$image_type = $_FILES[ 'img' ][ 'type' ];
$image_size = $_FILES['img']['size'];

if ( $image_type !== 'image/jpeg' && $image_type !== 'image/png' ) {
    http_response_code( 400 );
    die( json_encode( [ 'error' => 'Chỉ cho phép dạng .png và .jpeg.' ] ) );
}
if ($image_size > 1000000) {
    echo json_encode(['error' => 'Kích thước ảnh vượt quá giới hạn cho phép.']);
    exit();
}
if ( !move_uploaded_file( $image_temp, $upload_dir . $image_name ) ) {
    http_response_code( 400 );
    die( json_encode( [ 'error' => 'Upload ảnh thất bại.' ] ) );
}

// Insert data into database
$stmt = $connect->prepare( 'INSERT INTO products (name_brand, name,img,img2,img3,price,sex,type,color,addreas,session,amount,rate) 
VALUES (:name_brand, :name,:img,:img2,:img3,:price,:sex,:type,:color,:addreas,:session,:amount,:rate)' );
$stmt->bindParam( ':name_brand', $_POST[ 'name_brand' ] );
$stmt->bindParam( ':name', $_POST[ 'name' ] );
$stmt->bindParam( ':img', $image_name );
$stmt->bindParam( ':img2', $_POST[ 'img2' ] );
$stmt->bindParam( ':img3', $_POST[ 'img3' ] );
$stmt->bindParam( ':price', $_POST[ 'price' ] );
$stmt->bindParam( ':sex', $_POST[ 'sex' ] );
$stmt->bindParam( ':type', $_POST[ 'type' ] );
$stmt->bindParam( ':color', $_POST[ 'color' ] );
$stmt->bindParam( ':addreas', $_POST[ 'addreas' ] );
$stmt->bindParam( ':session', $_POST[ 'session' ] );
$stmt->bindParam( ':amount', $_POST[ 'amount' ] );
$stmt->bindParam( ':rate', $_POST[ 'rate' ] );

if ( $stmt->execute() ) {
    http_response_code( 200 );
    echo json_encode( [ 'success' => 'Thêm sản phẩm mới thành công.' ] );
} else {
    http_response_code( 400 );
    echo json_encode( [ 'error' => 'Thêm sản phẩm mới thất bại' ] );
}