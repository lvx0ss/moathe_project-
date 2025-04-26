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
    $type = trim($_POST["type"]);

    // تحميل الملفات
    $image_path = '';
    $pdf_path = '';

    if (!empty($_FILES['image']['name'])) {
        $image_name = time() . '_' . basename($_FILES['image']['name']);
        $image_path = 'uploads/uploads/images/' . $image_name;
        move_uploaded_file($_FILES['image']['tmp_name'], $image_path);
    }

    if (!empty($_FILES['pdf']['name'])) {
        $pdf_name = time() . '_' . basename($_FILES['pdf']['name']);
        $pdf_path = 'uploads/uploads/pdfs/' . $pdf_name;
        move_uploaded_file($_FILES['pdf']['tmp_name'], $pdf_path);
    }

    if (!empty($name) && !empty($type)) {
        $stmt = $conn->prepare("INSERT INTO programs (name, type, image, pdf) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $type, $image_path, $pdf_path);
        $stmt->execute();
        $stmt->close();
        header("Location: mang_programs.php?show=programs");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>إضافة برنامج</title>
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
        input[type="text"], select, input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-top: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
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
    <h2>إضافة برنامج جديد</h2>
    <form method="POST" enctype="multipart/form-data">
        <label for="name">اسم البرنامج:</label>
        <input type="text" name="name" id="name" required>

        <label for="type">نوع البرنامج:</label>
        <select name="type" id="type" required>
            <option value="">اختر النوع</option>
            <option value="الناس">برامج الحفظ بداية من سورة الناس</option>
            <option value="البقرة">برامج الحفظ بداية من سورة البقرة</option>
            <option value="مبتدئين">برامج الحفظ للمبتدئين</option>
            <option value="أخرى">أخرى</option>
        </select>

        <label for="image">الصورة:</label>
        <input type="file" name="image" id="image" accept="image/*" required>

        <label for="pdf">ملف PDF:</label>
        <input type="file" name="pdf" id="pdf" accept="application/pdf" required>

        <button type="submit">إضافة البرنامج</button>
    </form>

    <a href="mang_accounts.php?show=programs" class="back-link">عودة إلى قائمة البرامج</a>
</div>

</body>
</html>
