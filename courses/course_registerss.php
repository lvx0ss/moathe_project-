<?php
include_once __DIR__ . '/../config.php';

session_start();
require_once 'conn.php';

if (!isset($_GET['course_id'])) {
    header("location: courses.php");
    exit();
}

$course_id = intval($_GET['course_id']);

// جلب معلومات الدورة
$course = mysqli_query($conn, "SELECT * FROM courses WHERE id = $course_id");
if (mysqli_num_rows($course) == 0) {
    header("location: courses.php");
    exit();
}
$course_data = mysqli_fetch_assoc($course);

// تسجيل الطالب في الدورة
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_SESSION["student_id"])) {
        header("location: st_login.php?redirect=course_register.php?course_id=$course_id");
        exit();
    }

    $student_id = $_SESSION["student_id"];
    
    // جلب بيانات الطالب من قاعدة البيانات
    $student_query = mysqli_query($conn, "SELECT * FROM info_student WHERE id = $student_id");
    if (mysqli_num_rows($student_query) == 0) {
        $error = "لم يتم العثور على بيانات الطالب.";
    } else {
        $student_data = mysqli_fetch_assoc($student_query);
        
        // التحقق من عدم تسجيل الطالب مسبقاً
        $check = mysqli_query($conn, "SELECT * FROM course_registrations WHERE student_id = $student_id AND course_id = $course_id");
        
        if (mysqli_num_rows($check) == 0) {
            mysqli_query($conn, "INSERT INTO course_registrations (student_id, course_id, student_name, student_phone, guardian_name, guardian_phone) 
                               VALUES ($student_id, $course_id, '{$student_data['firstname']} {$student_data['lastname']}', 
                               '{$student_data['phone']}', '{$student_data['guardian_name']}', '{$student_data['guardian_phone']}')");
            $success = "تم تسجيلك في الدورة بنجاح!";
        } else {
            $error = "أنت مسجل بالفعل في هذه الدورة.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تسجيل في الدورة</title>
    <style>
        body {
            font-family: 'Tahoma', Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
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
        .course-info, .student-info {
            text-align: center;
            margin-bottom: 20px;
            padding: 15px;
            border: 1px solid #eee;
            border-radius: 8px;
        }
        .course-info img {
            max-width: 200px;
            border-radius: 10px;
        }
        .student-info img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
        }
        .info-table {
            width: 100%;
            margin: 20px 0;
            border-collapse: collapse;
        }
        .info-table th, .info-table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: right;
        }
        .info-table th {
            background-color: #f2f2f2;
        }
        .success {
            color: green;
            text-align: center;
            font-weight: bold;
            padding: 10px;
        }
        .error {
            color: red;
            text-align: center;
            font-weight: bold;
            padding: 10px;
        }
        button {
            background-color: #076177;
            color: white;
            padding: 12px;
            margin-top: 20px;
            border: none;
            width: 100%;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover { 
            opacity: 0.9; 
            transform: translateY(-2px);
        }
        .back-link {
            display: block;
            margin-top: 20px;
            text-align: center;
            color: #076177;
            text-decoration: none;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>تسجيل في الدورة</h2>
    
    <div class="course-info">
        <img src="<?= htmlspecialchars($course_data['image']) ?>" alt="صورة الدورة">
        <h3><?= htmlspecialchars($course_data['name']) ?></h3>
        <p><?= htmlspecialchars($course_data['description']) ?></p>
    </div>

    <?php if (isset($_SESSION["id"])): ?>
        <?php 
        // جلب بيانات الطالب من الجلسة
        $student_id = $_SESSION["id"];
        $student_query = mysqli_query($conn, "SELECT * FROM info_student WHERE id = $student_id");
        $student_data = mysqli_fetch_assoc($student_query);
        ?>
        
        <div class="student-info">
            <h3>بيانات الطالب</h3>
            <img src="images/<?= htmlspecialchars($student_data['picture']) ?>" alt="صورة الطالب">
            
            <table class="info-table">
                <tr>
                    <th>الرقم المدرسي</th>
                    <td><?= htmlspecialchars($student_data['id']) ?></td>
                </tr>
                <tr>
                    <th>اسم الطالب</th>
                    <td><?= htmlspecialchars($student_data['firstname'] . ' ' . $student_data['lastname']) ?></td>
                </tr>
                <tr>
                    <th>رقم الهاتف</th>
                    <td><?= htmlspecialchars($student_data['phone']) ?></td>
                </tr>
                <tr>
                    <th>اسم ولي الأمر</th>
                    <td><?= htmlspecialchars($student_data['guardian_name']) ?></td>
                </tr>
                <tr>
                    <th>هاتف ولي الأمر</th>
                    <td><?= htmlspecialchars($student_data['guardian_phone']) ?></td>
                </tr>
                <tr>
                    <th>حلقة التحفيظ</th>
                    <td><?= htmlspecialchars($student_data['class']) ?></td>
                </tr>
            </table>
        </div>

        <?php if (isset($success)): ?>
            <p class="success"><?= $success ?></p>
            <a href="courses.php" class="back-link">عودة إلى قائمة الدورات</a>
        <?php elseif (isset($error)): ?>
            <p class="error"><?= $error ?></p>
            <a href="courses.php" class="back-link">عودة إلى قائمة الدورات</a>
        <?php else: ?>
            <form method="POST">
                <p style="text-align: center; font-weight: bold;">أنت على وشك التسجيل في هذه الدورة. الرجاء تأكيد:</p>
                <button type="submit">تأكيد التسجيل</button>
            </form>
        <?php endif; ?>
    <?php else: ?>
        <p style="text-align: center; font-size: 18px;">يجب تسجيل الدخول أولاً للتسجيل في الدورة.</p>
        <a href="st_login.php?redirect=course_register.php?course_id=<?= $course_id ?>">
            <button>تسجيل الدخول</button>
        </a>
    <?php endif; ?>
</div>

</body>
</html>