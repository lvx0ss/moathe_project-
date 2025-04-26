
<?php
include_once __DIR__ . '/../config.php';

require_once './conn/conn.php';
 include_once "header.php";  
session_start();
if(!isset($_SESSION["id"]) || $_SESSION["id"] == '') 
{
	header('location: index.php');
}

$id = $_GET['id'];
$sql = "SELECT * FROM  info_student WHERE id = '$id'";
$result = mysqli_query($conn,$sql);
while($row = mysqli_fetch_array($result)){
	$upfirstname = $row['firstname']; 
}

if(empty($_POST['firstname']))
{
	echo "";
} else {

	$upfirstname = $_POST['firstname']; 
	$upfirst = $_POST['first']; 
	
			$query = "UPDATE  info_student SET firstname='$upfirstname',first_mark='$upfirst'where id='".$id."'";
    
			if(mysqli_query($conn,$query))
			{	
				echo "<script>alert('تم التحديث')</script>";
				echo '<script>windows: location="st_view.php"</script>';
			}else{
				echo "<script>alert('حدث خطا')</script>";
				echo '<script>windows: location="st_add.php?id='.$id.'"</script>';
			}
			

		
	
}
?>
<body>
	<center>
		
		<?php include('teacher_header.php');?>

    
    
    
    
    
    <div class="container">
      <form action="" method="post" enctype="multipart/form-data">


            <div class="form-group">
               <label for="Title" class="col-sm-2 control-label">الاسم الاول</label>
               <div class="col-sm-10">
                  <input type="text" class="form-control" name="firstname" placeholder="الاسم الاول" value="<?php echo $upfirstname;?>" readonly>
               </div>
            </div>


             
               <div class="form-group col-lg-12 col-sm-8">
               <label for="Author" class="col-sm-2 control-label">الدرجة</label>
               <div class="col-sm-10">
                  <input type="text" class="form-control" name="first" placeholder="الدرجة"   required>
               </div>
            </div>

              
            <br>
            <div class="form-group">
               <div class="col-sm-offset-2 col-sm-10">
                  <button  name="update" class="btn btn-info col-lg-12" data-toggle="modal">
               إضافه
                  </button>
               </div>
             </div>
			 <br>
		

         </form>
		 
      </div>

    </center>
    
    
</body>
</html>