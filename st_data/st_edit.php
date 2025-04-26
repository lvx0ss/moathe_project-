<?php
include_once __DIR__ . '/../config.php';

require_once './conn/conn.php';
include_once "header.php";
session_start();
$dir = "images/";

// التحقق من تسجيل الدخول
if (!isset($_SESSION["id"]) || $_SESSION["id"] == '') {
    header('location: index.php');
    exit; // إنهاء التنفيذ بعد إعادة التوجيه
}

// استرجاع بيانات الطالب من قاعدة البيانات
$id = $_GET['id'];
$sql = "SELECT * FROM info_student WHERE id = '$id'";
$result = mysqli_query($conn, $sql);

if ($row = mysqli_fetch_assoc($result)) {
    $upfirstname = $row['firstname'];
    $uplastname = $row['lastname'];
    $upfirst = $row['first_mark'];
    $upgiven_name = $row['given_name'];
    $upphone = $row['phone'];
    $update_of_birth = $row['date_of_birth'];
    $upplace_of_birth = $row['place_of_birth'];
    $upacademic_stage = $row['academic_stage'];
    $upjoining_date = $row['joining_date'];
    $upplace_of_residence = $row['place_of_residence'];
    $upguardian_name = $row['guardian_name'];
    $uprelationship = $row['relationship'];
    $upguardian_phone = $row['guardian_phone'];
    $upstu_pass = $row['stu_pass'];
    $upclass = $row['class'];
    $upimage = $row['picture']; // اسم الصورة الحالية
} else {
    // التعامل مع حالة عدم وجود الطالب
    echo "<script>alert('الطالب غير موجود')</script>";
    echo '<script>window.location="st_view.php"</script>';
    exit;
}

// معالجة تحديث بيانات الطالب
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $upfirstname = $_POST['firstname'];
    $uplastname = $_POST['lastname'];
    $upfirst = $_POST['first'];
    $upgiven_name = $_POST['given_name'];
    $upphone = $_POST['phone'];
    $update_of_birth = $_POST['date_of_birth'];
    $upplace_of_birth = $_POST['place_of_birth'];
    $upacademic_stage = $_POST['academic_stage'];
    $upjoining_date = $_POST['joining_date'];
    $upplace_of_residence = $_POST['place_of_residence'];
    $upguardian_name = $_POST['guardian_name'];
    $uprelationship = $_POST['relationship'];
    $upguardian_phone = $_POST['guardian_phone'];
    $upstu_pass = $_POST['stu_pass'];
    $upclass = $_POST['class'];

    // التحقق من رفع صورة جديدة
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image_name = time() . "_" . $_FILES['image']['name']; // اسم الصورة الجديد
        $image_tmp = $_FILES['image']['tmp_name'];
        $image_path = $dir . $image_name;

        // التحقق من نوع الصورة
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        if (in_array($_FILES['image']['type'], $allowed_types)) {
            move_uploaded_file($image_tmp, $image_path); // رفع الصورة
        } else {
            echo "<script>alert('يرجى رفع صورة بصيغة JPG أو PNG أو GIF فقط.')</script>";
            exit;
        }
    } else {
        // إذا لم يتم رفع صورة جديدة، نحتفظ بالصورة القديمة
        $image_name = $upimage;
    }

    // تحديث البيانات مع الحفاظ على الصورة الحالية أو رفع صورة جديدة
    $query = "UPDATE info_student SET 
        firstname='$upfirstname', 
        lastname='$uplastname', 
        first_mark='$upfirst', 
        phone='$upphone', 
        given_name='$upgiven_name', 
        date_of_birth='$update_of_birth', 
        place_of_birth='$upplace_of_birth', 
        academic_stage='$upacademic_stage', 
        joining_date='$upjoining_date', 
        place_of_residence='$upplace_of_residence', 
        guardian_name='$upguardian_name', 
        relationship='$uprelationship', 
        guardian_phone='$upguardian_phone', 
        class='$upclass',
        stu_pass='$upstu_pass',
        picture='$image_name'  -- تحديث اسم الصورة
        WHERE id='" . $id . "'";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('تم تعديل بيانات الطالب بنجاح')</script>";
        echo '<script>window.location="st_view.php"</script>';
    } else {
        echo "<script>alert('حدث خطأ أثناء تعديل بيانات الطالب: " . mysqli_error($conn) . "')</script>";
        echo '<script>window.location="st_add.php?id=' . $id . '"</script>';
    }
    exit; // إنهاء التنفيذ بعد المعالجة
}
?>

<body>
    <center>
        <?php include('teacher_header.php'); ?>
        <div class="container">
            <form action="" method="post" enctype="multipart/form-data">
                <!-- عرض الصورة الحالية -->
                <div class="form-group">
                    <label>الصورة الحالية:</label><br>
                    <img src="images/<?php echo $upimage; ?>" width="150" height="150" alt="الصورة الحالية"><br><br>
                    <label>رفع صورة جديدة (اختياري):</label>
                    <input type="file" class="form-control" name="image">
                </div>

                <!-- الحقول الأخرى -->

                <div class="form-group">
                    <label for="Title" class="col-sm-2 control-label">الاسم الاول</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="firstname" placeholder="الاسم الاول" value="<?php echo $upfirstname;?>" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="Author" class="col-sm-2 control-label">الاسم الثاني</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="lastname" placeholder="الاسم الثاني" value="<?php echo $uplastname;?>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="Author" class="col-sm-2 control-label">المادة الاولى</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="first" placeholder="المادة الاولى" value="<?php echo $upfirst;?>" >
                    </div>
                </div>

                <div class="form-group">
                    <label for="Author" class="col-sm-2 control-label">اللقب</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="given_name" placeholder="اللقب" value="<?php echo $upgiven_name;?>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="Author" class="col-sm-2 control-label">رقم الموبايل</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" name="phone" placeholder="رقم الموبايل" maxlength="9" value="<?php echo $upphone;?>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="Author" class="col-sm-2 control-label">تاريخ الميلاد</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="date_of_birth" value="<?php echo $update_of_birth;?>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="Author" class="col-sm-2 control-label">مكان الميلاد</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="place_of_birth" placeholder="مكان الميلاد" value="<?php echo $upplace_of_birth;?>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="Author" class="col-sm-2 control-label">المرحلة الدراسية</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="academic_stage" placeholder="المرحلة الدراسية" value="<?php echo $upacademic_stage;?>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="Author" class="col-sm-2 control-label">تاريخ التسجيل</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="joining_date" value="<?php echo $upjoining_date;?>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="Author" class="col-sm-2 control-label">مكان السكن</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="place_of_residence" placeholder="مكان السكن" value="<?php echo $upplace_of_residence;?>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="Author" class="col-sm-2 control-label">اسم ولي الامر</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="guardian_name" placeholder="اسم ولي الامر" value="<?php echo $upguardian_name;?>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="Author" class="col-sm-2 control-label">صلةالقرابة</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="relationship" placeholder="العلاقة" value="<?php echo $uprelationship;?>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="Author" class="col-sm-2 control-label">رقم ولي الامر</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" name="guardian_phone" placeholder="هاتف ولي الامر" maxlength="9" value="<?php echo $upguardian_phone;?>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="Author" class="col-sm-2 control-label">كلمة سر للطالب</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" name="stu_pass" placeholder="كلمة سر الطالب" value="<?php echo $upstu_pass;?>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="Author" class="col-sm-2 control-label">اسم الحلقة</label>
                    <div class="col-sm-10">
                        <select class="form-select form-select-lg" name="class">
                            <option value="مصعب بن عمير" <?php if ($upclass == 'مصعب بن عمير') echo 'selected'; ?>>مصعب بن عمير</option>
                            <option value="طلحة بن عبيد الله" <?php if ($upclass == 'طلحة بن عبيد الله') echo 'selected'; ?>>طلحة بن عبيد الله</option>
                            <option value="سعد بن معاذ" <?php if ($upclass == 'سعد بن معاذ') echo 'selected'; ?>>سعد بن معاذ</option>
                            <option value="حمزة بن عبدالمطلب" <?php if ($upclass == 'حمزة بن عبدالمطلب') echo 'selected'; ?>>حمزة بن عبدالمطلب</option>
                            <option value="سعد بن ابي وقاص" <?php if ($upclass == 'سعد بن ابي وقاص') echo 'selected'; ?>>سعد بن ابي وقاص</option>
                            <option value="ابو عبيدة بن الجراح" <?php if ($upclass == 'ابو عبيدة بن الجراح') echo 'selected'; ?>>ابو عبيدة بن الجراح</option>
                        </select>
                    </div>
                </div>

                <!-- زر التعديل -->
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button name="update" class="btn btn-info col-lg-12">تعديل</button>
                    </div>
                </div>
            </form>
        </div>
    </center>
</body>
</html>
