<?php

class Order {
    private $conn;

    ///////Products Properties
    public $id;
    public $is_user;
    public $name_brand;
    public $name;
    public $img;
    public $price;
    public $color;
    public $session;
    public $size;
    public $amount;

    ///////Connect DB

    public function __construct( $db ) {
        $this->conn = $db;
    }

    ///Read Data

    public function read( $id ) {
        $query = 'SELECT * FROM orders WHERE id_user = :id';
        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam( ':id', $id );
        $stmt->execute();
        return $stmt;
    }
}
?>