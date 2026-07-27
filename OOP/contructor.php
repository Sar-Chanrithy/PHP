<?php

class category{
    public $name;
    public $price;
    public $des;
    public $total;
    public $qty;

    public function __construct($namecate, $price, $des, $total, $qty){
        $this->name = $namecate;//Drink
        $this->price = $price;
        $this->des = $des;
        $this->total = $total;
        $this->qty = $qty;
    }

    public function display(){
        echo "Category Name : ".$this->name."<br>";
        echo "Price : ".$this->price."<br>";
        echo "Description : ".$this->des."<br>";
        echo "Total : ".$this->total."<br>";
        echo "Qty : ".$this->qty."<br>";
    }
}

$p = new category("Drink", 2.5, "Cold Drink", 100, 20);
$p->display();

?>