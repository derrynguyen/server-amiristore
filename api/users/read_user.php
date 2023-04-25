<?php

header( 'Access-Control-Allow-Origin:*' );
header( 'Content-Type: application/json' );

include_once( '../../config/db.php' );
include_once( '../../model/users.php' );

$db = new db();
$connect = $db->connect();

$account = new Users( $connect );
$account->id = isset( $_GET[ 'getIDUser' ] )? $_GET[ 'getIDUser' ]:die();

$account->detailProfile();

$account_detail = array(

    'id'=> $account->id,
    'fullname'=> $account->fullname,
    'email'=> $account->email,
    'avatar'=> $account->avatar,
    'phone'=> $account->phone,
    'addreas'=> $account->addreas,
    'sex'=> $account->sex,
    'point'=> $account->point,
    'role'=> $account->role,
);
print_r( json_encode( $account_detail ) );

?>