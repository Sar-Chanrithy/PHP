<?php

$text = "The quick brown fox jumps over the lazy dog.";

if (preg_match("/fox/", $text)) {
  echo "Found 'fox' in the text.";
}

$newText = preg_replace("/dog/", "cat", $text);
echo "New Text: " . $newText;