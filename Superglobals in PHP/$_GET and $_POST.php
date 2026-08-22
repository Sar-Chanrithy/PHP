<?php

// ឧទាហរណ៍៖ $_GET
// URL: http://example.com?name=John&age=25
echo "Name: " . $_GET['name']; // John
echo "Age: " . $_GET['age']; // 25

// ឧទាហរណ៍៖ $_POST
// ទម្រង់ HTML ដែលប្រើ method="POST"
echo "Name: " . $_POST['name'];
echo "Age: " . $_POST['age'];