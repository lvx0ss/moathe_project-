<?php
include_once __DIR__ . '/../config.php';

require_once './conn/conn.php';
include_once "header.php";
session_start();

// تأكد من تسجيل الدخول
if (!isset($_SESSION["id"]) || $_SESSION["id"] == '') {
    header('location: index.php');
    exit;
}

$teacher_id = $_SESSION["id"];
$dir = "images/"; // مجلد رفع الصور

// عند إرسال النموذج
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['image']['tmp_name'])) {

    // تحقق من تعبئة جميع الحقول المطلوبة
    $required_fields = ['firstname', 'lastname', 'given_name', 'phone', 'class', 'date_of_birth',
                        'place_of_birth', 'academic_stage', 'joining_date', 'place_of_residence',
                        'guardian_name', 'relationship', 'guardian_phone', 'stu_pass'];

    $all_filled = true;
    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            $all_filled = false;
            break;
        }
    }

    if ($all_filled) {
        // تنقية البيانات
        $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
        $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
        $given_name = mysqli_real_escape_string($conn, $_POST['given_name']);
        $phone = mysqli_real_escape_string($conn, $_POST['phone']);
        $class = mysqli_real_escape_string($conn, $_POST['class']);
        $date_of_birth = mysqli_real_escape_string($conn, $_POST['date_of_birth']);
        $place_of_birth = mysqli_real_escape_string($conn, $_POST['place_of_birth']);
        $academic_stage = mysqli_real_escape_string($conn, $_POST['academic_stage']);
        $joining_date = mysqli_real_escape_string($conn, $_POST['joining_date']);
        $place_of_residence = mysqli_real_escape_string($conn, $_POST['place_of_residence']);
        $guardian_name = mysqli_real_escape_string($conn, $_POST['guardian_name']);
        $relationship = mysqli_real_escape_string($conn, $_POST['relationship']);
        $guardian_phone = mysqli_real_escape_string($conn, $_POST['guardian_phone']);
        $stu_pass = mysqli_real_escape_string($conn, $_POST['stu_pass']);

        // معالجة الصورة
        $picture = $_FILES['image']['name'];
        $target_file = $dir . basename($picture);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // تحقق من الامتدادات المسموح بها
        $allowed = ['jpg', 'jpeg', 'png'];
        if (!in_array($imageFileType, $allowed)) {
            echo "<script>alert('الرجاء اختيار صورة بصيغة JPG أو JPEG أو PNG')</script>";
        } else {
            // رفع الصورة
            if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                $query = "INSERT INTO info_student (
                            teacher_number, picture, firstname, lastname, given_name, phone, class,
                            date_of_birth, place_of_birth, academic_stage, joining_date,
                            place_of_residence, guardian_name, relationship, stu_pass, guardian_phone
                          ) VALUES (
                            '$teacher_id', '$picture', '$firstname', '$lastname', '$given_name', '$phone', '$class',
                            '$date_of_birth', '$place_of_birth', '$academic_stage', '$joining_date',
                            '$place_of_residence', '$guardian_name', '$relationship', '$stu_pass', '$guardian_phone'
                          )";

                if (mysqli_query($conn, $query)) {
                    $last_id = mysqli_insert_id($conn);
                    echo "<script>alert('تم حفظ الطالب بنجاح. رقم الطالب: $last_id')</script>";
                    echo '<script>window.location="st_view.php"</script>';
                    exit;
                } else {
                    echo "<script>alert('حدث خطأ أثناء الحفظ: " . mysqli_error($conn) . "')</script>";
                }
            } else {
                echo "<script>alert('فشل في رفع الصورة')</script>";
            }
        }
    } else {
        echo "<script>alert('الرجاء ملء جميع الحقول المطلوبة')</script>";
    }
}
?>
<body>
<center>
    <?php include('teacher_header.php'); ?>
    <br>
    <div class="container">
        <form action="" method="post" enctype="multipart/form-data">

            <div class="form-group">
                <label>الصورة</label>
                <input type="file" class="form-control" name="image" required>
            </div>

            <div class="form-group">
                <label>الاسم الأول</label>
                <input type="text" class="form-control" name="firstname" required>
            </div>

            <div class="form-group">
                <label>الاسم الثاني</label>
                <input type="text" class="form-control" name="lastname" required>
            </div>

            <div class="form-group">
                <label>اللقب</label>
                <input type="text" class="form-control" name="given_name" required>
            </div>

            <div class="form-group">
                <label>رقم الهاتف</label>
                <input type="number" class="form-control" name="phone" required maxlength="9">
            </div>

            <div class="form-group">
                <label>تاريخ الميلاد</label>
                <input type="date" class="form-control" name="date_of_birth" required>
            </div>

            <div class="form-group">
                <label>مكان الميلاد</label>
                <input type="text" class="form-control" name="place_of_birth" required>
            </div>

            <div class="form-group">
                <label>المرحلة الدراسية</label>
                <input type="text" class="form-control" name="academic_stage" required>
            </div>

            <div class="form-group">
                <label>تاريخ الانضمام</label>
                <input type="date" class="form-control" name="joining_date" required>
            </div>

            <div class="form-group">
                <label>مكان السكن</label>
                <input type="text" class="form-control" name="place_of_residence" required>
            </div>

            <div class="form-group">
                <label>اسم ولي الأمر</label>
                <input type="text" class="form-control" name="guardian_name" required>
            </div>

            <div class="form-group">
                <label>صلة القرابة </label>
                <input type="text" class="form-control" name="relationship" required>
            </div>

            <div class="form-group">
                <label>رقم هاتف ولي الأمر</label>
                <input type="number" class="form-control" name="guardian_phone" required maxlength="9">
            </div>

            <div class="form-group">
                <label>كلمة السر للطالب</label>
                <input type="number" class="form-control" name="stu_pass" required>
            </div>

            <div class="form-group">
                <label>اسم الحلقة</label>
                <select class="form-select form-control" name="class" required>
                    <option value="مصعب بن عمير">مصعب بن عمير</option>
                    <option value="طلحة بن عبيد الله">طلحة بن عبيد الله</option>
                    <option value="سعد بن معاذ">سعد بن معاذ</option>
                    <option value="حمزة بن عبدالمطلب">حمزة بن عبدالمطلب</option>
                    <option value="سعد بن ابي وقاص">سعد بن أبي وقاص</option>
                    <option value="ابو عبيدة بن الجراح">أبو عبيدة بن الجراح</option>
                </select>
            </div>

            <br>
            <div class="form-group">
                <button class="btn btn-info btn-block">حفـــــــظ</button>
            </div>
        </form>
    </div>
</center>
</body>
