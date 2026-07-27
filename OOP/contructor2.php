<?php

class product{
    public $name;
    public $price;
    public $qty;
    public $total;
    public $discount;

    public function __construct( $name, $price, $qty ){
        $this->name = $name;
        $this->price = $price;
        $this->qty = $qty;

        $this->total = $this->qty * $this->price;

        if ($this->total > 50) {
            $this->discount = $this->total * 0.30;
        } elseif ($this->total > 20) {
            $this->discount = $this->total * 0.20;
        } elseif ($this->total > 10) {
            $this->discount = $this->total * 0.10;
        }

    }
    public function display(){
        echo "Name :".$this->name."<br>";
        echo "Total :".$this->total."<br>";
        echo "QTY :".$this->qty."<br>";
        echo "Price :".$this->price."<br>";
        echo "Discount :".$this->discount."<br>";
        echo "Final Total :".($this->total - $this->discount )."<br>";
    }
}

$op = new product("rithy",30,2);
$op->display();