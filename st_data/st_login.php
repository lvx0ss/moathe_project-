
<?php
include_once __DIR__ . '/../config.php';

session_start();
require_once './conn/conn.php'; // تأكد من أن هذا المسار صحيح

if (isset($_POST['submit'])) { // تحقق من إرسال النموذج
    $id = stripslashes($_POST['id']);
    $id = mysqli_real_escape_string($conn, $id);
    $stu_pass = stripslashes($_POST['stu_pass']);
    $stu_pass = mysqli_real_escape_string($conn, $stu_pass);

    $query = "SELECT * FROM `info_student` WHERE id='$id' AND stu_pass='$stu_pass'";
    $result = mysqli_query($conn, $query);

    if ($result) { // تحقق من نجاح الاستعلام
        $rows = mysqli_num_rows($result);
        if ($rows == 1) {
            $_SESSION['id'] = $id;
            // عرض بيانات الطالب بعد تسجيل الدخول
            $query_run = mysqli_query($conn, "SELECT * FROM info_student WHERE id = '$id'");
            if ($query_run && mysqli_num_rows($query_run) > 0) {
                $row = mysqli_fetch_assoc($query_run); // استخدم mysqli_fetch_assoc للحصول على مصفوفة ارتباطية
                ?>
                <!DOCTYPE html>
                <html>
                <head>
                    <meta charset="utf-8"/>
                    <title>بيانات الطالب</title>
                    <link rel="stylesheet" href="css/bootstrap.min.css"/>
                </head>
                <body>
                    <table class="table table-responsive table-lg table-md table-sm table-hover table-bordered" dir='rtl'>
                        <thead>
                            <tr>
                                <th>الصورة</th>
                                <th>الرقم المدرسي</th>
                                <th>الاسم</th>
                                <th>اللقب</th>
                                <th>رقم الموبايل</th>
                                <th>اسم ولي الامر</th>
                                <th>هاتف ولي الامر</th>
                                <th>السكن</th>
                                <th>حلقة التحفيظ</th>
                                <th>الدرجة</th>
                                <th>النتيجة</th>
                                <th>طباعة</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $final_mark = $row['first_mark']; // هنا تم تصحيح حساب الدرجة النهائية
                            $remarks = "";
                            $picture = $row['picture'];

                            if ($final_mark >= 90 && $final_mark <= 100) {
                                $remarks = "ممتاز";
                            } elseif ($final_mark >= 80 && $final_mark < 90) {
                                $remarks = "جيد جدا";
                            } elseif ($final_mark >= 70 && $final_mark < 80) {
                                $remarks = "جيد";
                            } elseif ($final_mark >= 60 && $final_mark < 70) {
                                $remarks = "مقبول";
                            } else {
                                $remarks = "راسب";
                            }
                            ?>
                            <tr>
                            <td><img src="images/<?php echo $picture; ?>" style="width: 80px; height: 80px ;text-align:center" alt="صورة الطالب"></td>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo $row['firstname'] . ' ' . $row['lastname']; ?></td>
                                <td><?php echo $row['given_name']; ?></td>
                                <td><?php echo $row['phone']; ?></td>
                                <td><?php echo $row['guardian_name']; ?></td>
                                <td><?php echo $row['guardian_phone']; ?></td>
                                <td><?php echo $row['place_of_residence']; ?></td>
                                <td><?php echo $row['class']; ?></td>
                                <td><?php echo $row['first_mark']; ?></td>
                                <td style="background-color: #6fca5f;"><?php echo $remarks; ?></td>
                                <td>
                                    <a class="btn btn-outline-success btn-lg" href="print_pdf.php?id=<?php echo $id; ?>" role="button">PDF and print</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <a href="index.php">
                        <button class="w-20 btn btn-lg btn-primary" type="button">خروج</button>
                    </a>
                </body>
                </html>
                <?php
            } else {
                echo "<div class='form alert alert-danger'>فشل في جلب بيانات الطالب.</div>";
            }
        } else {
            echo "<div class='form alert alert-info'>الاسم اوكلمه المرور غير صحيحه<br/><p class='link'>اضغط هنا <a href='st_login.php'>سجل مره اخرى</a> </p></div>";
        }
    } else {
        echo "<div class='form alert alert-danger'>خطأ في الاستعلام: " . mysqli_error($conn) . "</div>";
    }
} else {
    ?>
    <!DOCTYPE html>
    <html dir="rtl">
    <head>
        <meta charset="utf-8"/>
        <title>صفحة تسجيل الدخول</title>
        <link rel="stylesheet" href="css/bootstrap.min.css"/>
        <link rel="stylesheet" href="css/login.css"/>
        <style>
                        body{
                           background-color:white;
                           color:#076177;"
                        }
                    </style>
    </head>
    <body>
        <main class="form-signin">
            <form class="form" method="post" name="login">
            <img class="mb-4" src="logo/student.jpg" alt="" width="100" height="100">
                <h1 class="h3 mb-3 fw-normal">سجل دخولك</h1>
                <div class="form-floating">
                    <input type="number" class="form-control" name="id" placeholder="ادخل الرقم المدرسي" required>
                    <label for="floatingInput">ادخل الرقم المدرسي</label>
                </div>
                <div class="form-floating">
                    <input type="password" name="stu_pass" class="form-control" id="floatingPassword" placeholder="ادخل كلمه المرور" required>
                    <label for="floatingPassword">كلمة المرور</label>
                </div>
                <button class="w-100 btn btn-lg " name="submit" type="submit" style="background-color:#076177;color:white;">سجل الان</button>
            </form>
        </main>
    </body>
    </html>
    <?php
}
?>