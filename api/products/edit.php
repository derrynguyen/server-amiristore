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

$upload_dir = 'D:/xampp/htdocs/inc/src/images/items/';
$image_name = $_FILES[ 'img' ][ 'name' ];
$image_temp = $_FILES[ 'img' ][ 'tmp_name' ];
$image_type = $_FILES[ 'img' ][ 'type' ];

if ( $image_type !== 'image/jpeg' && $image_type !== 'image/png' ) {
    http_response_code( 400 );
    die( json_encode( [ 'error' => 'Chỉ cho phép dạng .png và .jpeg.' ] ) );
}

if ( !move_uploaded_file( $image_temp, $upload_dir . $image_name ) ) {
    http_response_code( 400 );
    die( json_encode( [ 'error' => 'Upload ảnh thất bại.' ] ) );
}
$sql = 'UPDATE products SET name_brand=:name_brand, name=:name, img=:img, img2=:img2, img3=:img3, price=:price, sex=:sex, type=:type, color=:color, addreas=:addreas, session=:session, amount=:amount, rate=:rate WHERE id = :id';
$stmt = $connect->prepare( $sql );
$stmt->bindParam( ':id', $id, PDO::PARAM_INT );
$stmt->bindParam( ':name_brand', $name_brand, PDO::PARAM_STR );
$stmt->bindParam( ':name', $name, PDO::PARAM_STR );
$stmt->bindParam( ':img', $image_name, PDO::PARAM_STR );
$stmt->bindParam( ':img2', $img2, PDO::PARAM_STR );
$stmt->bindParam( ':img3', $img3, PDO::PARAM_STR );
$stmt->bindParam( ':price', $price, PDO::PARAM_STR );
$stmt->bindParam( ':sex', $sex, PDO::PARAM_STR );
$stmt->bindParam( ':type', $type, PDO::PARAM_STR );
$stmt->bindParam( ':color', $color, PDO::PARAM_STR );
$stmt->bindParam( ':addreas', $addreas, PDO::PARAM_STR );
$stmt->bindParam( ':session', $session, PDO::PARAM_STR );
$stmt->bindParam( ':amount', $amount, PDO::PARAM_INT );
$stmt->bindParam( ':rate', $rate, PDO::PARAM_INT );

if ( $stmt->execute() ) {
    http_response_code( 200 );
    echo json_encode( [ 'success' => 'Cập nhật sản phẩm mới thành công.' ] );
} else {
    http_response_code( 400 );
    echo json_encode( [ 'error' => 'Cập nhật sản phẩm mới thất bại' ] );
}

// if ( $stmt->execute() ) {
//     http_response_code( 200 );
//     echo json_encode( [ 'success' => 'Xóa sản phẩm thành công.' ] );
// } else {
//     http_response_code( 400 );
//     echo json_encode( [ 'error' => 'Xóa sản phẩm thất bại.' ] );
// }

// if ( empty( $name ) ) {
//     echo json_encode( array( 'error' => 'Vui lòng nhập tên sản phẩm' ) );
//     exit();
// }
// if ( empty( $name_brand ) ) {
//     echo json_encode( array( 'error' => 'Vui lòng nhập tên thương hiệu' ) );
//     exit();
// }
// if ( empty( $price ) ) {
//     echo json_encode( array( 'error' => 'Vui lòng nhập giá' ) );
//     exit();
// }
// if ( empty( $sex ) ) {
//     echo json_encode( array( 'error' => 'Vui lòng thêm giới tính' ) );
//     exit();
// }
// if ( empty( $type ) ) {
//     echo json_encode( array( 'error' => 'Vui lòng thêm loại quần áo' ) );
//     exit();
// }
// if ( empty( $color ) ) {
//     echo json_encode( array( 'error' => 'Vui lòng thêm màu sắc' ) );
//     exit();
// }
// if ( empty( $addreas ) ) {
//     echo json_encode( array( 'error' => 'Vui lòng thêm nơi sản xuất' ) );
//     exit();
// }
// if ( empty( $session ) ) {
//     echo json_encode( array( 'error' => 'Vui lòng thêm phiên bản' ) );
//     exit();
// }
// if ( empty( $amount ) ) {
//     echo json_encode( array( 'error' => 'Vui lòng thêm số lượng' ) );
//     exit();
// }
// $upload_dir = 'D:/xampp/htdocs/inc/src/images/items/';
// $image_name = $_FILES[ 'img' ][ 'name' ];
// $image_temp = $_FILES[ 'img' ][ 'tmp_name' ];
// $image_type = $_FILES[ 'img' ][ 'type' ];

// if ( $image_type !== 'image/jpeg' && $image_type !== 'image/png' ) {
//     http_response_code( 400 );
//     die( json_encode( [ 'error' => 'Chỉ cho phép dạng .png và .jpeg.' ] ) );
// }

// if ( !move_uploaded_file( $image_temp, $upload_dir . $image_name ) ) {
//     http_response_code( 400 );
//     die( json_encode( [ 'error' => 'Upload ảnh thất bại.' ] ) );
// }

// // Insert data into database
// $stmt = $connect->prepare( 'UPDATE products SET name_brand='$name_brand',name='$name',img='$img',img2='$img2',img3='$img3',price='$price',sex='$sex',type='$type',color='$color',addreas='$addreas',session='$session',amount='$amount',rate='$rate' WHERE id = '$id'' );
// $stmt->bindParam( ':name_brand', $_POST[ 'name_brand' ] );
// $stmt->bindParam( ':name', $_POST[ 'name' ] );
// $stmt->bindParam( ':img', $image_name );
// $stmt->bindParam( ':img2', $_POST[ 'img2' ] );
// $stmt->bindParam( ':img3', $_POST[ 'img3' ] );
// $stmt->bindParam( ':price', $_POST[ 'price' ] );
// $stmt->bindParam( ':sex', $_POST[ 'sex' ] );
// $stmt->bindParam( ':type', $_POST[ 'type' ] );
// $stmt->bindParam( ':color', $_POST[ 'color' ] );
// $stmt->bindParam( ':addreas', $_POST[ 'addreas' ] );
// $stmt->bindParam( ':session', $_POST[ 'session' ] );
// $stmt->bindParam( ':amount', $_POST[ 'amount' ] );
// $stmt->bindParam( ':rate', $_POST[ 'rate' ] );

