<?php
class student{
    public $name;
    public $gender;
    public $age;
    public $grade;

    public function output(){
        echo "name :".$this->name;
        echo '<br>';
        echo "gender :".$this->gender;
        echo '<br>';
        echo "age :".$this->age;
        echo '<br>';
        echo "grade :".$this->grade;
    }

}

$op = new student;
$op->name = "rithy";
$op->gender = "Male";
$op->age = 20;
$op->grade = "10E";
// echo "name :". $op->name;
$op->output();

?>