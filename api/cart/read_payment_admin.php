<?php
header('Content-type: text/plain; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once('../../config/db.php');
include_once('../../model/payment.php');

$db = new db();
$connect = $db->connect();

if ($connect) {
    $payment = new Payment($connect);
    $read = $payment->readAdmin();

    $num = $read->rowCount();

    if ($num > 0) {
        $products_array = [];
        $products_array['data'] = [];

        while ($row = $read->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $products_item = array(
                'id' => $id,
                'id_user' => $id_user,
                'name_brand' => $name_brand,
                'fullname' => $fullname,

                'name' => $name,
                'img' => $img,
                'price' => $price,
                'color' => $color,
                'session' => $session,
                'size' => $size,
                'amount' => $amount,
                'total' => $total,
                'status' => $status,
            );

            array_push($products_array['data'], $products_item);
        }

        echo json_encode($products_array, JSON_UNESCAPED_UNICODE);
    } else {
        echo json_encode(array('message' => 'No payment found.'));
    }
} else {
    echo json_encode(array('message' => 'Failed to connect to database.'));
}
?>