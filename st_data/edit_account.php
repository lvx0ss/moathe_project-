<?php
include_once __DIR__ . '/../config.php';

require_once './conn/conn.php';
include_once "header.php";
session_start();
if (!isset($_SESSION["id"]) || $_SESSION["id"] == '') {
    header('location: index.php');
    exit;
}

$id = $_GET['id'];
$sql = "SELECT * FROM admin_accounts WHERE id = '$id'";
$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_array($result)) {
    $upfirstname = $row['firstname'];
    $uplastname = $row['lastname'];
    $upusername = $row['username'];
    $uppassword = $row['password'];
    $upusertype = $row['usertype'];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "UPDATE admin_accounts SET firstname='$firstname', lastname='$lastname', username='$username', password='$password' WHERE id='$id'";
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('تم التعديل بنجاح')</script>";
        echo '<script>window.location="mang_accounts.php"</script>';
        exit;
    } else {
        echo "<script>alert('حدث خطأ: " . mysqli_error($conn) . "')</script>";
        echo '<script>window.location="edit_account.php?id=' . $id . '"</script>';
        exit;
    }
}
?>

<body>
    <?php include('admin_header.php'); ?>
    <br>

    <div class="container">
        <div class="mb-6 g-3 row justify-content-center">
            <div class="col-lg-8">
                <strong style="text-align:center">LOGIN FORM</strong>
                <div class="container">
                    <form action="" method="post">
                        <div class="form-group">
                            <label for="Title" class="col-sm-2 control-label">الاسم الاول</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="firstname" placeholder="الاسم الاول" value="<?php echo $upfirstname; ?>" required>
                            </div>
                        </div>

                        <div class="form-group col-lg-12 col-sm-8">
                            <label for="Author" class="col-sm-2 control-label">الاسم الاخير</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="lastname" placeholder="الاسم الاخير" value="<?php echo $uplastname; ?>" required>
                            </div>
                        </div>

                        <div class="form-group col-lg-12 col-sm-8">
                            <label for="Publisher" class="col-sm-2 control-label">اسم المستخدم</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="username" placeholder="اسم المستخدم" value="<?php echo $upusername; ?>" required>
                            </div>
                        </div>

                        <div class="form-group col-lg-12 col-sm-8">
                            <label for="Publisher" class="col-sm-2 control-label">كلمه المرور</label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control" name="password" placeholder="كلمة المرور" value="<?php echo $uppassword; ?>" required>
                            </div>
                        </div>

                        <br>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button name="update" class="btn btn-secondary col-lg-12" data-toggle="modal">
                                    تعديل
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