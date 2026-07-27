<?php

// Switch Example 2: Using Score Ranges
$score = 85;
$gradeRange = (int)($score / 10);

switch ($gradeRange) {
    case 10:
    case 9:
        echo "Grade: A";
        break;
    case 8:
        echo "Grade: B";
        break;
    case 7:
        echo "Grade: C";
        break;
    default:
        echo "Grade: D";
}