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

    public function create() {
        $query = 'INSERT INTO products SET type=:type,name=:name, price=:price, img=:img,engine=:engine, fuel_type=:fuel_type, gear=:gear,width=:width, length=:length, height=:height,weight=:weight,door=:door,max_speed=:max_speed, slot=:slot, background=:background,background_int=:background_int';

        $stmt = $this->conn->prepare( $query );
        ///Clean data
        $this->type = htmlspecialchars( strip_tags( $this->type ) );
        $this->name = htmlspecialchars( strip_tags( $this->name ) );
        $this->price = htmlspecialchars( strip_tags( $this->price ) );
        $this->img = htmlspecialchars( strip_tags( $this->img ) );
        $this->engine = htmlspecialchars( strip_tags( $this->engine ) );
        $this->fuel_type = htmlspecialchars( strip_tags( $this->fuel_type ) );
        $this->gear = htmlspecialchars( strip_tags( $this->gear ) );
        $this->width = htmlspecialchars( strip_tags( $this->width ) );
        $this->length = htmlspecialchars( strip_tags( $this->length ) );
        $this->height = htmlspecialchars( strip_tags( $this->height ) );
        $this->weight = htmlspecialchars( strip_tags( $this->weight ) );
        $this->door = htmlspecialchars( strip_tags( $this->door ) );
        $this->max_speed = htmlspecialchars( strip_tags( $this->max_speed ) );
        $this->slot = htmlspecialchars( strip_tags( $this->slot ) );
        $this->background = htmlspecialchars( strip_tags( $this->background ) );
        $this->background_int = htmlspecialchars( strip_tags( $this->background_int ) );

        ///Bind data
        $stmt ->bindParam( ':type', $this->type );
        $stmt ->bindParam( ':name', $this->name );
        $stmt ->bindParam( ':price', $this->price );
        $stmt ->bindParam( ':img', $this->img );
        $stmt ->bindParam( ':engine', $this->engine );
        $stmt ->bindParam( ':fuel_type', $this->fuel_type );
        $stmt ->bindParam( ':gear', $this->gear );
        $stmt ->bindParam( ':width', $this->width );
        $stmt ->bindParam( ':length', $this->length );
        $stmt ->bindParam( ':height', $this->height );
        $stmt ->bindParam( ':weight', $this->weight );
        $stmt ->bindParam( ':door', $this->door );
        $stmt ->bindParam( ':max_speed', $this->max_speed );
        $stmt ->bindParam( ':slot', $this->slot );
        $stmt ->bindParam( ':background', $this->background );
        $stmt ->bindParam( ':background_int', $this->background_int );

        if ( $stmt->execute() ) {
            return true;
        }
        printf( 'Error %s.\n', $stmt->error );
        return false;
    }
}
?>