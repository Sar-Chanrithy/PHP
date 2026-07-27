<?php

// Switch Example 1: Using Conditions
$score = 85;

switch (true) {
    case ($score >= 90):
        echo "Grade: A";
        break;
    case ($score >= 80):
        echo "Grade: B";
        break;
    case ($score >= 70):
        echo "Grade: C";
        break;
    default:
        echo "Grade: D";
}