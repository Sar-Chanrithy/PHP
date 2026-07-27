<?php

interface School{
    public function sc();
}

class Circle implements School{
    public function sc(){
        echo "Sc the Circle";
    }
}

class ll implements School{
    public function sc(){
        echo "Sc the ll";
    }
}

function render (School $school){
    echo $school->sc();
}
render(new Circle());