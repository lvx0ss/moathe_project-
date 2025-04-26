<?php
include_once __DIR__ . '/../config.php';

require_once 'conn.php';
include_once "C:/xampp/htdocs/project/bar/index.php";
// جلب الدورات
$courses = mysqli_query($conn, "SELECT * FROM courses ORDER BY id ASC");
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>الدورات التعليمية</title>
    <link rel="stylesheet" href="style2.css">
    <link rel="stylesheet" href="style.css">
    <style>
        .container {
            border: 1px solid #ccc;
            border-radius: 10px;
            background: #fff;
            padding: 20px;
            margin: 20px;
            width: 300px;
            float: right;
            text-align: center;
            box-shadow: 0 0 5px rgba(0,0,0,0.1);
        }
        .container img {
            max-width: 100%;
            border-radius: 10px;
        }
        .container p {
            margin: 10px 0;
        }
        .container button {
            background-color: #076177;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }
        .register-btn {
            background-color: #4CAF50;
            margin-top: 10px;
        }
        h2 {
            clear: both;
            padding-top: 20px;
            color: white;
            margin: 0 0 0 5;
        }
    </style>
</head>
<body>

<h2>الدورات التعليمية</h2>

<?php if (mysqli_num_rows($courses) > 0): ?>
    <?php while($course = mysqli_fetch_assoc($courses)): ?>
        <div class="container">
            <img src="<?= htmlspecialchars($course['image']) ?>" alt="صورة الدورة">
            <h3><?= htmlspecialchars($course['name']) ?></h3>
            <p><?= htmlspecialchars($course['description']) ?></p>
      
            </a>
            <a href="st_login.php?course_id=<?= $course['id'] ?>">
                <button class="register-btn">تسجيل في الدورة</button>
            </a>
        </div>
    <?php endwhile; ?>
<?php else: ?>
    <p>لا توجد دورات متاحة حالياً.</p>
<?php endif; ?>

</body>
</html>