<?php

class Payment {
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
    public $total;
    public $status;

    ///////Connect DB

    public function __construct( $db ) {
        $this->conn = $db;
    }

    ///Read Data

    public function read( $id ) {
        $query = 'SELECT * FROM payment WHERE id_user = :id';
        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam( ':id', $id );
        $stmt->execute();
        return $stmt;
    }
    public function readAdmin() {
        $query = 'SELECT account.fullname, payment.id,payment.id_user, payment.name, payment.name_brand, payment.img, payment.price, payment.color, payment.session, payment.size, payment.amount, payment.total, payment.status
            FROM payment
            LEFT JOIN account ON payment.id_user = account.id';
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    public function detail() {
        $query = 'SELECT account.fullname, payment.id, payment.id_user, payment.name, payment.name_brand, payment.img, payment.price, payment.color, payment.session, payment.size, payment.amount, payment.total, payment.status
        FROM payment
        LEFT JOIN account ON payment.id_user = account.id 
        WHERE payment.id = ? LIMIT 1';
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->fullname = $row['fullname'];
        $this->id = $row['id'];
        $this->id_user = $row['id_user'];
        $this->name_brand = $row['name_brand'];
        $this->name = $row['name'];
        $this->img = $row['img'];
        $this->price = $row['price'];
        $this->color = $row['color'];
        $this->session = $row['session'];
        $this->size = $row['size'];
        $this->amount = $row['amount'];
        $this->total = $row['total'];
        $this->status = $row['status'];
                     
    }
}
?>