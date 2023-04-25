<?php

class Users {
    private $conn;

    public $id;
    public $fullname;
    public $email;
    public $password;
    public $avatar;
    public $phone;
    public $sex;
    public $point;
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
    public function detailProfile() {
        $query = 'SELECT *FROM account where id =? LIMIT 1';
        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam( 1, $this->id );
        $stmt->execute();

        $row = $stmt->fetch( PDO::FETCH_ASSOC );

        $this->id = $row[ 'id' ];
        $this->fullname = $row[ 'fullname' ];
        $this->email = $row[ 'email' ];
        $this->avatar = $row[ 'avatar' ];
        $this->phone = $row[ 'phone' ];
        $this->addreas = $row[ 'addreas' ];
        $this->sex = $row[ 'sex' ];
        $this->point = $row[ 'point' ];
        $this->role = $row[ 'role' ];
    }
}

?>