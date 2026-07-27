<?php

$x = 10; 

function test() {
  global $x; 
  echo "Value of x: $x";
}

test();