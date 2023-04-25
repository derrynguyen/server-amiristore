<?php
header( 'Access-Control-Allow-Origin:*' );
header( 'Content-Type: application/json' );
header( 'Access-Control-Allow-Methods:POST' );
header( 'Access-Control-Allow-Headers:Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Request-With' );

include_once( '../../config/db.php' );

$db = new db();

$connect = $db->connect();

// Parse the request body as JSON
$data = json_decode( file_get_contents( 'php://input' ), true );

$fullname = $data[ 'username' ];
$email = $data[ 'email' ];
$password = $data[ 'password' ];
$phone = $data[ 'phone' ];
$addreas = $data[ 'addreas' ];
$sex = $data[ 'sex' ];
$role = $data[ 'role' ];
$avatar = $data[ 'avatar' ];
$point = $data[ 'point' ];
// $check = $data[ 'checked' ];

///Hàm kiểm tra tồn tại
if ( empty( $fullname ) ) {
    header( 'Content-Type: application/json' );
    echo json_encode( array( 'error' => 'Vui lòng điền đầy đủ tên tài khoản' ) );
    exit();
}
if ( empty( $email ) ) {
    header( 'Content-Type: application/json' );
    echo json_encode( array( 'error' => 'Vui lòng điền đầy đủ email của bạn' ) );
    exit();
}
if ( empty( $password ) ) {
    header( 'Content-Type: application/json' );
    echo json_encode( array( 'error' => 'Vui lòng điền đầy đủ mật khẩu' ) );
    exit();
}
if ( empty( $phone ) ) {
    header( 'Content-Type: application/json' );
    echo json_encode( array( 'error' => 'Vui lòng điền đầy đủ số điện thoại' ) );
    exit();
}
if ( empty( $addreas ) ) {
    header( 'Content-Type: application/json' );
    echo json_encode( array( 'error' => 'Vui lòng điền đầy đủ đỉa chỉ giao hàng' ) );
    exit();
}
if ( empty( $sex ) ) {
    header( 'Content-Type: application/json' );
    echo json_encode( array( 'error' => 'Vui lòng chọn giới tính' ) );
    exit();
}
// if ( empty( $check ) ) {
//     header( 'Content-Type: application/json' );
//     echo json_encode( array( 'error' => 'Bạn vui lòng đồng ý với các điều khoảng của cửa hàng' ) );
//     exit();
// }
///Hàm kiểm tra địa chỉ email có tồn tại hay không
$stmt = $connect->prepare( 'SELECT COUNT(*) FROM account WHERE email = ?' );
$stmt->execute( [ $email ] );
$count = $stmt->fetchColumn();
if ( $count > 0 ) {
    header( 'Content-Type: application/json' );
    echo json_encode( array( 'error' => 'Địa chỉ email của bạn đã tồn tại' ) );
    exit();
}

///Hàm kiểm tra SDT
$stmt = $connect->prepare( 'SELECT COUNT(*) FROM account WHERE phone = ?' );
$stmt->execute( [ $phone ] );
$count = $stmt->fetchColumn();
if ( $count > 0 ) {
    header( 'Content-Type: application/json' );
    echo json_encode( array( 'error' => 'Số điện thoại của bạn đã tồn tại' ) );
    exit();
}

///Hàm hash mã password
$hashed_password = password_hash( $password, PASSWORD_DEFAULT );

///Hảm tạo tài khoản
$stmt = $connect->prepare( 'INSERT INTO account (fullname, email, password,phone,addreas,sex,role,avatar,point) VALUES (:fullname, :email, :password,:phone,:addreas,:sex,:role, :avatar,:point )' );
$stmt->execute( array(
    ':fullname' => $fullname,
    ':email' => $email,
    ':password' => $hashed_password,
    ':phone' => $phone,
    ':addreas' => $addreas,
    ':sex' => $sex,
    ':role' => $role,
    ':avatar' => $avatar,
    ':point' => $point,

) );

header( 'Content-Type: application/json' );
echo json_encode( array( 'success' => 'Tạo tài khoản thành công. Bây giờ bạn hãy đăng nhập' ) );
exit();