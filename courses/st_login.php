<?php
include_once __DIR__ . '/../config.php';

session_start();
require_once 'conn.php';

if (isset($_GET['course_id'])) {
    $_SESSION['course_id'] = intval($_GET['course_id']);
}

if (isset($_POST['submit'])) {
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $stu_pass = mysqli_real_escape_string($conn, $_POST['stu_pass']);

    $query = "SELECT * FROM info_student WHERE id='$id' AND stu_pass='$stu_pass'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) == 1) {
        $student = mysqli_fetch_assoc($result);
        $_SESSION['student'] = $student;
        header("Location: course_register.php");
        exit();
    } else {
        echo "<div class='alert alert-danger'>رقم الطالب أو كلمة المرور غير صحيحة</div>";
    }
}
?>

<!DOCTYPE html>
<html dir="rtl">
<head>
    <meta charset="utf-8"/>
    <title>صفحة تسجيل الدخول</title>
    <link rel="stylesheet" href="css/bootstrap.min.css"/>
    <link rel="stylesheet" href="login.css"/>
</head>
<body>
    <main class="form-signin">
        <form method="post" name="login">
            <img class="mb-4" src="student.jpg" alt="" width="100" height="100">
            <h1 class="h3 mb-3 fw-normal">سجل دخولك</h1>

            <div class="form-floating">
                <input type="number" class="form-control" name="id" placeholder="ادخل الرقم المدرسي" required>
                <label for="id">ادخل الرقم المدرسي</label>
            </div>
            <div class="form-floating">
                <input type="password" name="stu_pass" class="form-control" placeholder="ادخل كلمة المرور" required>
                <label for="stu_pass">كلمة المرور</label>
            </div>

            <button class="w-100 btn btn-lg mt-3" name="submit" type="submit" style="background-color:#076177; color:white;">سجل الآن</button>
        </form>
    </main>
</body>
</html>