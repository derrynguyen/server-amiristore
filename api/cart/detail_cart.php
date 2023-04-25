<?php
header('Access-Control-Allow-Origin:*');
header('Content-Type: application/json');

include_once('../../config/db.php');
include_once('../../model/payment.php');

$db = new db();
$connect = $db->connect();

$payment = new Payment($connect);
$payment->id = isset($_GET['id']) ? $_GET['id'] : die();

$payment->detail();

$payment_detail = array(
    'id' => $payment->id,
    'fullname' => $payment->fullname,
    'name_brand' => $payment->name_brand,
    'name' => $payment->name,
    'img' => $payment->img,
    'price' => $payment->price,
    'color' => $payment->color,
    'session' => $payment->session,
    'size' => $payment->size,
    'amount' => $payment->amount,
    'total' => $payment->total,
    'status' => $payment->status,
);
print_r(json_encode($payment_detail));