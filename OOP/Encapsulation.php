<?php
class bank{
    private $balance = 0;

    public function deposit($amount){
        if($amount>0){
            $this->balance += $amount;
        }
    }
    public function balances(){
        echo "Balance :".$this->balance;
    }
}

$p = new bank();
$p->deposit(90);
$p->balances();