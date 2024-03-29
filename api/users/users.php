<?php
header( 'Content-type: text/plain; charset=utf-8' );
header('Access-Control-Allow-Origin: http://localhost:3000');
header('Access-Control-Allow-Headers: Authorization, Content-Type');

header( 'Content-Type: text/html; charset=UTF-8' );

include_once( '../../config/db.php' );
include_once( '../../model/users.php' );

$db = new db();
$connect = $db->connect();

$users = new Users( $connect );
$read = $users->read();

$num  = $read->rowCount();

if ( $num>0 ) {
    $users_array = [];
    $users_array[ 'data' ] = [];

    while( $row = $read->fetch( PDO::FETCH_ASSOC ) ) {
        extract( $row );

        $users_item = array(

            'id'=> $id,
            'fullname'=> $fullname,
            'email'=> $email,
            'password'=> $password,
            'avatar'=> $avatar,
            'phone'=> $phone,
            'addreas'=> $addreas,
            'sex'=> $sex,
            'point'=> $point,
            'role'=> $role,

        );
        array_push( $users_array[ 'data' ], $users_item );
    }
    header( 'Content-Type: application/json' );

    echo json_encode( $users_array );
}

?>