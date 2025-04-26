<?php 
    $localhost = "localhost"; // سيتم استبداله لاحقاً ببيانات الاستضافة
    $user_name = "root";       // اسم المستخدم الخاص بك في الاستضافة
    $pass = "";                // كلمة مرور قاعدة البيانات
    $db = "sy_student";        // اسم قاعدة البيانات

    $conn = mysqli_connect($localhost, $user_name, $pass, $db);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
?>