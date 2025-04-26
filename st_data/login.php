<style>
img{
	width: 20%; 
	height: 20%	;
}
</style>

<?php
include_once __DIR__ . '/../config.php';

require_once './conn/conn.php';
include_once "header.php";  
session_start();
$type = $_GET['usertype'];

// التحقق من وجود كوكي اسم المستخدم وتعيين قيمته للحقل
$cookie_username = isset($_COOKIE['username']) ? $_COOKIE['username'] : '';

$sql = "SELECT * FROM admin_accounts where usertype = '".$type."'";
$query = mysqli_query($conn, $sql); 

if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $remember = isset($_POST['remember']) ? $_POST['remember'] : '';
    
    $query1 = "SELECT * FROM admin_accounts where username='$username' 
    and password = '$password' and usertype = '$type'";

    $result = mysqli_query($conn,$query1);
    $row = mysqli_fetch_array($result);

    if(is_array($row)) {
        $_SESSION["id"] = $row['id'];
        $_SESSION["usertype"] = $row['usertype'];

        // إذا اختار المستخدم تذكر البيانات
        if($remember == '1') {
            // حفظ اسم المستخدم في كوكي لمدة 30 يوم
            setcookie('username', $username, time() + (30 * 24 * 60 * 60), '/');
        } else {
            // إذا لم يختر تذكر البيانات، نحذف الكوكي إن وجد
            setcookie('username', '', time() - 3600, '/');
        }
        
        if($type == "ADMIN"){
            header('location: mang_accounts.php');
        } elseif($type == "te"){
            header('location:st_view.php');
        }
        exit();
    } 
    else {
        echo "<script>alert('اسم المستخدم او كلمه المرور خاطئه')</script>";
    }
}
?>

<div class="container">
<div class="mb-6 g-3 row justify-content-center">
<div class="col-lg-8">
    <br>
	<center>
	  <strong style="text-align:center">نموذج تسجيل</strong>
	
      <div class="container">
         <form role="form" action="" method="post">
		 <strong>(<?php echo $type;?>)</strong>
								<br>
								<?php 
								if($type == "ADMIN"){	           
								?>
		 </center>
								<?php } ?>
             
            <div class="form-group">
               <label for="Title" class="col-sm-2 control-label">اسم المستخدم</label>
               <div class="col-sm-10">
                <input type="text" class="form-control" name="username"
                 placeholder="اسم المستخدم" value="<?php echo htmlspecialchars($cookie_username); ?>" required>
               </div>
            </div>

            <div class="form-group col-lg-12 col-sm-8">
               <label for="Author" class="col-sm-2 control-label">كلمة المرور</label>
               <div class="col-sm-10">
                  <input type="password" class="form-control" name="password"
                   placeholder="كلمة المرور" required>
               </div>
            </div>

            <div class="form-group col-lg-12 col-sm-8">
               <div class="col-sm-10">
                  <label>
                     <input type="checkbox" name="remember" value="1" <?php echo ($cookie_username != '') ? 'checked' : ''; ?>>
                     تذكر اسم المستخدم
                  </label>
               </div>
            </div>
            
            <br>
            <div class="form-group">
               <div class="col-sm-offset-2 col-sm-10">
                  <button name="login" class="btn col-lg-12" data-toggle="modal" style="background-color:076177;color:white;">
                     دخول
                  </button>
               </div>
             </div>
			 <br>

         </form>
		 <div class="form-group">
               <div class="col-sm-offset-2 col-sm-10">
			   <a href="index.php"><button name="login" 
            class="btn col-lg-12" data-toggle="modal"style="background-color:a17e48;color:white;">
               رجوع
                  </button></a>
               </div>
          </div>
        </div>
    </center>
    </div>
    </div>
    </div>
</body>