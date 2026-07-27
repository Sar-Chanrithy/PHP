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
    public $grade;
    public $class;
    public function student(){

        echo "Grade :".$this->grade."<br>";
        echo "Class :".$this->class."<br>";

    }
}

class Student1 extends Student{
    public $name1;
    public $grade1;
    public $class1;
    public function student1(){
        echo "Name1 :".$this->name1."<br>";
        echo "Grade1 :".$this->grade1."<br>";
        echo "Class1 :".$this->class1."<br>";

    }
}

class Student2 extends Student1{
    public $name2;
    public $grade2;
    public $class2;
    public function student2(){
        echo "Name2 :".$this->name2."<br>";
        echo "Grade2 :".$this->grade2."<br>";
        echo "Class2 :".$this->class2."<br>";

    }
}

$stu = new Student2();
$stu->name = "rithy";
$stu->grade = "A";
$stu->age = "20";
$stu->salary = "700";
$stu->class = "12G1";

$stu->name1 = "Sem Somnea";
$stu->grade1 = "B";
$stu->class1 = "12G1";
$stu->name2 = "Sem Soksheng";
$stu->grade2 = "C";
$stu->class2 = "12G1";






$stu->teacher();
echo "<hr>";
$stu->student();
echo "<hr>";
$stu->student1();
echo "<hr>";
$stu->student2();