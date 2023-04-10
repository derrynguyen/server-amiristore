<?php

class Products {
    private $conn;

    ///////Products Properties
    public $id;
    public $id_brand;
    public $name;
    public $img;
    public $img2;
    public $img3;
    public $price;
    public $sex;
    public $type;
    public $color;
    public $addreas;
    public $session;
    public $amount;

    ///////Connect DB

    public function __construct( $db ) {
        $this->conn = $db;
    }

    ///Read Data

    public function read() {
        $query = 'SELECT *FROM products';
        $stmt = $this->conn->prepare( $query );

        $stmt->execute();
        return $stmt;
    }

    public function detail() {
        $query = 'SELECT *FROM products where id =? LIMIT 1';
        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam( 1, $this->id );
        $stmt->execute();

        $row = $stmt->fetch( PDO::FETCH_ASSOC );

        $this->id = $row[ 'id' ];
        $this->name_brand = $row[ 'name_brand' ];
        $this->name = $row[ 'name' ];
        $this->img = $row[ 'img' ];
        $this->img2 = $row[ 'img2' ];
        $this->img3 = $row[ 'img3' ];
        $this->price = $row[ 'price' ];
        $this->sex = $row[ 'sex' ];
        $this->type = $row[ 'type' ];
        $this->color = $row[ 'color' ];
        $this->addreas = $row[ 'addreas' ];
        $this->session = $row[ 'session' ];
        $this->amount = $row[ 'amount' ];
    }

}
?>