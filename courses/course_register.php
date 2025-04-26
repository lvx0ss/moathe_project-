<?php
include_once __DIR__ . '/../config.php';

session_start();
require_once 'conn.php';

// تحقق من وجود بيانات الطالب في الجلسة
if (!isset($_SESSION['student']) || !isset($_SESSION['course_id'])) {
    header("Location: st_login.php");
    exit();
}

$student = $_SESSION['student'];
$course_id = $_SESSION['course_id']; // رقم الدورة من الجلسة

function getStudentValue($key, $array) {
    return isset($array[$key]) ? htmlspecialchars($array[$key]) : 'غير متوفر';
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تسجيل في الدورة</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Tahoma', sans-serif;
            background-color: #f5f5f5;
            padding: 30px;
        }
        .container {
            max-width: 750px;
            margin: auto;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .title {
            color: #00796b;
            text-align: center;
            margin-bottom: 20px;
        }
        .course-card, .student-card {
            text-align: center;
            padding: 20px;
            margin-bottom: 30px;
            border: 1px solid #ddd;
            border-radius: 8px;
        }
        .student-img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 50%;
            margin-bottom: 15px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            text-align: right;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ccc;
        }
        th {
            background-color: #eee;
            color: #00796b;
        }
        .btn-primary {
            background-color: #00796b;
            border: none;
            padding: 10px 30px;
            border-radius: 5px;
            font-size: 16px;
            color: white;
            cursor: pointer;
        }
        .btn-primary:hover {
            background-color: #005f56;
        }
    </style>
</head>
<body>

<div class="container">
    <h2 class="title">تسجيل في الدورة</h2>

    <div class="course-card">
        <img src="../images/course.png" alt="دورة" style="width: 80px;">
        <h4>دورة تدريبية في التلاوة</h4>
        <p>نساعدك في تحسين تلاوتك للقرآن</p>
    </div>

    <div class="student-card">
        <h5>بيانات الطالب</h5>
        <img src="/project/st_data/images/<?= getStudentValue('picture', $student) ?>" alt="صورة الطالب" class="student-img">

        <table>
            <tr>
                <th>الرقم المدرسي</th>
                <td><?= getStudentValue('id', $student) ?></td>
            </tr>
            <tr>
                <th>اسم الطالب</th>
                <td><?= getStudentValue('firstname', $student) . ' ' . getStudentValue('lastname', $student) ?></td>
            </tr>
            <tr>
                <th>رقم الهاتف</th>
                <td><?= getStudentValue('phone', $student) ?></td>
            </tr>
            <tr>
                <th>اسم ولي الأمر</th>
                <td><?= getStudentValue('guardian_name', $student) ?></td>
            </tr>
            <tr>
                <th>هاتف ولي الأمر</th>
                <td><?= getStudentValue('guardian_phone', $student) ?></td>
            </tr>
        </table>

        <form action="submit_registration.php" method="POST">
            <input type="hidden" name="student_id" value="<?= getStudentValue('id', $student) ?>">
            <input type="hidden" name="course_id" value="<?= $course_id ?>">
            <button type="submit" class="btn btn-primary mt-4">تأكيد التسجيل</button>
        </form>
    </div>
</div>

</body>
</html>
