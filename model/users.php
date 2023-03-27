<?php

class Users {
    private $conn;

    public $id;
    public $name;
    public $email;
    public $password;
    public $avatar;
    public $phone;
    public $sex;
    public $point;
    public $amount_order;
    public $role;

    public function __construct( $db ) {
        $this->conn = $db;
    }

    public function read() {

        $query = 'SELECT *FROM account';
        $stmt = $this->conn->prepare( $query );

        $stmt->execute();
        return $stmt;
    }
}

?>