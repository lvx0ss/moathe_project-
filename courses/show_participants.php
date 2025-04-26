<?php
include_once __DIR__ . '/../config.php';

session_start();
require_once 'conn.php';

if (!isset($_SESSION["id"]) || $_SESSION["usertype"] !== 'ADMIN') {
    header("location: index.php");
    exit();
}

$course_id = intval($_GET['course_id']);

//
if (isset($_GET['delete'])) {
    $student_id = intval($_GET['delete']);
    $course_id = intval($_GET['course_id']);
    
    // حذف التسجيل من جدول course_registrations
    mysqli_query($conn, "DELETE FROM courses_registrations WHERE student_id = $student_id and course_id=$course_id");
    
    header("Location: show_participants.php?course_id=$course_id");
    exit();
}
// جلب معلومات الدورة
$course_query = mysqli_query($conn, "SELECT name FROM courses WHERE id = $course_id");
$course = mysqli_fetch_assoc($course_query);

// جلب المشتركين في الدورة
$participants_query = mysqli_query($conn, "
    SELECT s.id, s.firstname, s.lastname, s.phone
    FROM info_student s
    JOIN courses_registrations cr ON s.id = cr.student_id
    where cr.course_id = '$course_id'
    ORDER BY s.firstname
");
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>مشتركي الدورة</title>
    <style>
        body {
            font-family: Tahoma, Arial;
            background-color: #f5f5f5;
            padding: 20px;
        }
        .container {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h2 {
            color: #076177;
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: center;
        }
        th {
            background-color: #076177;
            color: white;
        }
        .back-btn {
            display: inline-block;
            margin-top: 20px;
            background-color: #076177;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
        }
        .count-badge {
            background-color: #4CAF50;
            color: white;
            padding: 3px 8px;
            border-radius: 50%;
            font-size: 0.9em;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>مشتركي دورة: <?= htmlspecialchars($course['name']) ?> 
        <span class="count-badge"><?= mysqli_num_rows($participants_query) ?></span>
    </h2>
    
    <?php if (mysqli_num_rows($participants_query) > 0): ?>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>اسم المستخدم</th>
                <th>رقم الهاتف</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            <?php while($participant = mysqli_fetch_assoc($participants_query)): ?>
            <tr>
                <td><?= $participant['id'] ?></td>
                <td><?= htmlspecialchars($participant['firstname']) ?></td>
                <td><?= htmlspecialchars($participant['phone']) ?></td>
                <td>
                <a href="?delete=<?= $participant['id'] ?>&course_id=<?= $course_id ?>" 
   class="delete-btn" 
   onclick="return confirm('هل أنت متأكد من حذف هذا المشترك من الدورة؟')"
   style="background-color: #f44336; color: white; padding: 5px 10px; text-decoration: none; border-radius: 4px; margin-right: 5px;">
   حذف
</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <?php else: ?>
    <p style="text-align: center; color: #666; margin-top: 20px;">لا يوجد مشتركين في هذه الدورة بعد.</p>
    <?php endif; ?>
    
    <a href="mang_courses.php" class="back-btn">← العودة إلى إدارة الدورات</a>
</div>

</body>
</html>