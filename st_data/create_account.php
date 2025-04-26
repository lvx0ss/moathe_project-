<?php
include_once __DIR__ . '/../config.php';

require_once './conn/conn.php';
include_once "header.php";
session_start();
if (!isset($_SESSION["id"]) || $_SESSION["id"] == '') {
    header('location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save'])) {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $username = $_POST['username'];
    $password = $_POST['password']; // تشفير MD5 هنا
    $usertype = "te";

    // استخدم Prepared Statements لمنع حقن SQL
    $query = "INSERT INTO admin_accounts (firstname, lastname, username, password, usertype) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "sssss", $firstname, $lastname, $username, $password, $usertype);
        
        if (mysqli_stmt_execute($stmt)) {
            echo "<script>alert('تم الحفظ')</script>";
            echo '<script>window.location="mang_accounts.php"</script>';
            exit;
        } else {
            echo "<script>alert('حدث خطأ: " . mysqli_error($conn) . "')</script>";
        }
        
        mysqli_stmt_close($stmt);
    } else {
        echo "<script>alert('حدث خطأ في إعداد الاستعلام')</script>";
    }
}
?>


<?php include('admin_header.php'); ?>
<br>

<div class="container">
    <div class="mb-6 g-3 row justify-content-center">
        <div class="col-lg-8">
            <strong style="text-align:center">LOGIN FORM</strong>
            <div class="container">
                <form action="" method="post" enctype="multipart/form-data">

                    <div class="form-group">
                        <label for="Title" class="col-sm-2 control-label">الاسم الاول</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="firstname" placeholder="الاسم الاول" value="" required>
                        </div>
                    </div>

                    <div class="form-group col-lg-12 col-sm-8">
                        <label for="Author" class="col-sm-2 control-label">الاسم الاخير</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="lastname" placeholder="الاسم الاخير" value="" required>
                        </div>
                    </div>

                    <div class="form-group col-lg-12 col-sm-8">
                        <label for="Publisher" class="col-sm-2 control-label">اسم المستخدم</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="username" placeholder="اسم المستخدم" value="" required>
                        </div>
                    </div>

                    <div class="form-group col-lg-12 col-sm-8">
                        <label for="Publisher" class="col-sm-2 control-label">كلمه المرور</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" name="password" placeholder="كلمة المرور" value="" required>
                        </div>
                    </div>

                    <br>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button name="save" class="btn btn-info col-lg-12" data-toggle="modal">
                                إضافه معلم
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

</body>
</html>