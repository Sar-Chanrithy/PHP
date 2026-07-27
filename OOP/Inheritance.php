<?php

class Teacher{
    public $name;
    public $age;
    public $salary;
    public function teacher(){
        echo "Name:".$this->name."<br>";
        echo "Age :".$this->age."<br>";
        echo "salary :".$this->salary."<br>";

    }
}

class Student extends Teacher{
    public $name;
    public $grade;
    public $class;
    public function student(){

        echo "Grade :".$this->grade."<br>";
        echo "Class :".$this->class."<br>";

    }
}
$stu = new Student ();
$stu->name = "rithy";
$stu->grade = "A";
$stu->age = "20";
$stu->salary = "700";
$stu->class = "12G1";

$stu->teacher();
echo "<br>";
echo "<hr>";
$stu->student();

?>