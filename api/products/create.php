<?php
header('Access-Control-Allow-Origin:*');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods:POST');
header('Access-Control-Allow-Headers:Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Request-With');

include_once('../../config/db.php');
include_once('../../model/products.php');

$db = new db();
$connect = $db->connect();

$products = new Products($connect);


$data =json_decode(file_get_contents("php//input"));

$products->type= $data->type;
$products->name= $data->name;
$products->price= $data->price;
$products->img= $data->img;
$products->engine= $data->engine;
$products->fuel_type= $data->fuel_type;
$products->gear= $data->gear;
$products->width= $data->width;
$products->length= $data->length;
$products->height= $data->height;
$products->weight= $data->weight;
$products->door= $data->door;
$products->max_speed= $data->max_speed;
$products->slot= $data->slot;
$products->background= $data->background;
$products->background_int= $data->background_int;

if($products->create()){
    echo json_encode(array('message','Tạo phương tiện thành công'));
}
else{
    echo json_encode(array('message','Tạo phương tiện không thành công'));

}






?>