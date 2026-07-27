<?php

class TV{
    private $channels = 1;
    private $isTVon = false;
    public function btnPower(){
        $this->isTVon = !$this->isTVon;

        if($this->isTVon){
            echo "TV is on<br>";
        } else {
            echo "TV is off<br>";
        }
    }

    public function channel($changechannel){
        if(!$this->isTVon){
            echo "Please turn on TV first<br>";
            return;
        }

        if($changechannel > 0 && $changechannel <= 50){
            $this->channels = $changechannel;
            echo "This is the Channel: " . $this->channels;
        }
    }
}

$op = new TV();
$op->btnPower();
$op->channel(10);

?>