<?php
header( 'Access-Control-Allow-Origin:*' );
header( 'Content-Type: application/json' );
header( 'Access-Control-Allow-Methods:POST' );
header( 'Access-Control-Allow-Headers:Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Request-With' );

include_once( '../../config/db.php' );
session_start();

$db = new db();

$connect = $db->connect();

$data = json_decode( file_get_contents( 'php://input' ), true );

$email = $data[ 'email' ];
$password = $data[ 'password' ];

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

///Kiểm tra email co tồn tại hay không
$stmt = $connect->prepare( 'SELECT * FROM account WHERE email = ?' );
$stmt->execute( [ $email ] );
$user = $stmt->fetch();

if ( $user === false ) {
    header( 'Content-Type: application/json' );
    echo json_encode( array( 'error' => 'Email hoặc mật khẩu của bạn vừa nhập không tồn tại' ) );
    exit();
}

///Kiểm tra mật khẩu
if ( password_verify( $password, $user[ 'password' ] ) ) {

    $_SESSION[ 'id' ] = array(
        'id' => $user[ 'id' ],
        'name' => $user[ 'name' ],
        'email' => $user[ 'email' ],
        'phone' => $user[ 'phone' ],
        'addreas' => $user[ 'addreas' ],
        'sex' => $user[ 'sex' ],
        'point' => $user[ 'point' ],
        'amount_order' => $user[ 'amount_order' ],
        'role' => $user[ 'role' ],
        'avatar' => $user[ 'avatar' ],

    );

    echo json_encode( array(
        'success' => 'Đăng nhập thành công',
        'session' => $_SESSION[ 'id' ]
    ) );

    // echo json_encode( array(
    //     'id' => $user[ 'id' ],
    //     'name' => $user[ 'name' ],
    //     'email' => $user[ 'email' ],
    //     'success' => 'Đăng nhập thành công'
    // ) );

} else {
    header( 'Content-Type: application/json' );
    echo json_encode( array( 'error' => 'Email hoặc mật khẩu không tồn tại' ) );
    exit();

}