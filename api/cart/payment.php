<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once('../../config/db.php');

$db = new db();
$connect = $db->connect();

$data = json_decode(file_get_contents("php://input"), true);

$id_user = $data['getIDUser'];
$total = 0;
$orders = json_decode($data['orders'], true);

$status = 'Đang chờ xác nhận';

if (empty($id_user) || empty($orders)) {
    echo json_encode(array('error' => 'ID user rỗng hoặc không có sản phẩm trong giỏ hàng'));
    exit();
}

try {
    $connect->beginTransaction();

    $stmt = $connect->prepare('INSERT INTO payment (id_user, name_brand, name, img, price, color, session, size, amount, total, status) 
    VALUES (:id_user, :name_brand, :name, :img, :price, :color, :session, :size, :amount, :total, :status)');

    foreach ($orders as $order) {
        $total = $order['amount'] * $order['price'];

        $stmt->bindParam(':id_user', $id_user);
        $stmt->bindParam(':name_brand', $order['name_brand']);
        $stmt->bindParam(':name', $order['name']);
        $stmt->bindParam(':img', $order['img']);
        $stmt->bindParam(':price', $order['price']);
        $stmt->bindParam(':color', $order['color']);
        $stmt->bindParam(':session', $order['session']);
        $stmt->bindParam(':size', $order['size']);
        $stmt->bindParam(':amount', $order['amount']);
        $stmt->bindParam(':total',   $total);
        $stmt->bindParam(':status', $status);
        $stmt->execute();

    }

    $sql = 'DELETE FROM orders WHERE id_user = :id_user';
    $stmt = $connect->prepare($sql);
    $stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);
    $stmt->execute();

    $connect->commit();

    http_response_code(200);
    echo json_encode(array('success' => 'Mua hàng thành công. Tổng tiền: ' .number_format($total, 0, ',', '.') . ' VNĐ'));
} catch (PDOException $e) {
    $connect->rollBack();
    http_response_code(400);
    echo json_encode(array('error' => 'Mua hàng thất bại. Lỗi: ' . $e->getMessage()));
}