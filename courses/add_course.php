<?php
include_once __DIR__ . '/../config.php';

session_start();
require_once 'conn.php';

if (!isset($_SESSION["id"]) || $_SESSION["usertype"] !== 'ADMIN') {
    header("location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["name"]);
    $description = trim($_POST["description"]);

    // تحميل الملفات
    $image_path = '';
    $pdf_path = '';

    if (!empty($_FILES['image']['name'])) {
        $image_name = time() . '_' . basename($_FILES['image']['name']);
        $image_path = 'uploads/uploads/images/' . $image_name;
        move_uploaded_file($_FILES['image']['tmp_name'], $image_path);
    }


    if (!empty($name) && !empty($description)) {
        $stmt = $conn->prepare("INSERT INTO courses (name, description, image) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $description, $image_path);
        $stmt->execute();
        $stmt->close();
        header("Location: mang_courses.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>إضافة دورة جديدة</title>
    <style>
        body {
            font-family: 'Tahoma', Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            background-color: white;
            margin: 40px auto;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        h2 {
            color: #076177;
            text-align: center;
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
        }
        input[type="text"], textarea, input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-top: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        textarea {
            height: 100px;
        }
        button {
            background-color: #076177;
            color: white;
            padding: 10px;
            margin-top: 20px;
            border: none;
            width: 100%;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover { opacity: 0.9; }
        .back-link {
            display: block;
            margin-top: 20px;
            text-align: center;
            color: #076177;
            text-decoration: none;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>إضافة دورة جديدة</h2>
    <form method="POST" enctype="multipart/form-data">
        <label for="name">اسم الدورة:</label>
        <input type="text" name="name" id="name" required>

        <label for="description">وصف الدورة:</label>
        <textarea name="description" id="description" required></textarea>

        <label for="image">الصورة:</label>
        <input type="file" name="image" id="image" accept="image/*" required>

       
        <button type="submit">إضافة الدورة</button>
    </form>

    <a href="mang_courses.php" class="back-link">عودة إلى قائمة الدورات</a>
</div>

</body>
</html>