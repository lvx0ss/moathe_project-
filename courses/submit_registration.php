<?php
include_once __DIR__ . '/../config.php';

session_start();
require_once "conn.php";

if (!isset($_SESSION['student'])) {
    echo "حدث خطأ: لا توجد بيانات الطالب في الجلسة.";
    exit();
}

$student = $_SESSION['student'];
$course_id = $_POST['course_id'] ?? 0;

$id = $student['id'];
$firstname = $student['firstname'];
$lastname = $student['lastname'];
$phone = $student['phone'] ?? '';
$guardian_name = $student['guardian_name'] ?? '';
$guardian_phone = $student['guardian_phone'] ?? '';

$check_sql = "SELECT * FROM courses_registrations 
              WHERE student_id = '$id' AND course_id = '$course_id'";
$result = mysqli_query($conn, $check_sql);

if (mysqli_num_rows($result) > 0) {
    echo "<h3 style='color:red;'>أنت مسجل بالفعل في هذه الدورة!</h3>";
} else {
    $sql = "INSERT INTO courses_registrations 
            (student_id, firstname, lastname, phone, guardian_name, guardian_phone, course_id)
            VALUES 
            ('$id', '$firstname', '$lastname', '$phone', '$guardian_name', '$guardian_phone', '$course_id')";

    if (mysqli_query($conn, $sql)) {
        echo "<h3 style='color:green;'>تم تسجيلك في الدورة بنجاح!</h3>";
    } else {
        echo "حدث خطأ أثناء التسجيل: " . mysqli_error($conn);
    }
}
?>

<br><br>
<a href="courses.php" class="submit-btn">رجوع</a>