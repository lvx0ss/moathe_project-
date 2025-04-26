
	<style>
img{
max-width: 80px;; 
max-height:80px;;
border-radius: 50%;
  
	    border: 2px solid #ccc;

}
tr,td,th{width: 8%;text-align: center}
</style>

<?php
include_once __DIR__ . '/../config.php';

require_once './conn/conn.php';
 include_once "header.php";  

session_start();
if(!isset($_SESSION["id"]) || $_SESSION["id"] == '') 
{
	header('location: index.php');
}
?>
<body>
	<center>
	
		<?php include('teacher_header.php');?>
	
	
        <table class="table table-responsive table-lg table-md 
		table-sm  table-hover   table-bordered">
         <thead>
		 <tr>
               <th>الرقم المدرسي</th>
			   <th>الاسم</th>
			   <th>اللقب</th>
                <th>رقم الموبايل</th>
				<th>اسم ولي الامر</th>
				<th>هاتف ولي الامر</th>
				<th>السكن</th>
				<th>حلقة التحفيظ </th>
				<th>كلمة سر الطالب</th>
			   <th>الدرجة</th>
			   <th>النتيجة</th>
			   <th>الصوره</th>
             <th>إضافه الدرجات</th>
               <th>تعديل</th>
               <th>حذف</th>
            </tr>
			</thead>
						<?php
				
                            
      $sql = "SELECT * FROM  info_student where teacher_number = '".$_SESSION["id"]."'  ";
            
    $query = mysqli_query($conn, $sql); 
          
    while ($row = mysqli_fetch_array($query)){

				$id = $row['id'];
                $id_school = $row['id_school'];
				$firstname = $row['firstname']; 
				$lastname = $row['lastname'];
                $phone = $row['phone'];
				$first_mark = $row['first_mark']; 
				$final_mark  = ($first_mark);
				$given_name=$row['given_name'];
				$guardian_name=$row['guardian_name'];
				$guardian_phone=$row['guardian_phone'];
				$stu_pass=$row['stu_pass'];
				$place_of_residence=$row['place_of_residence'];
        
				if(($final_mark >=90) &&($final_mark <=100)){
					$remarks = "ممتاز";	
				}
                else if(($final_mark >=80) &&($final_mark <90)){
					$remarks = "جيد جدا";
                }
               else if (($final_mark >=70) &&($final_mark <80)){
					$remarks = "جيد";	
				}
                    else if(($final_mark >=50) &&($final_mark <70)){
					$remarks = "مقبول";	
                    }else {
					$remarks = "راسب";
				}
				$picture = $row['picture'];
							?>
					
						<tr>

                            <td><?php echo "$id";?></td>
							<td><?php echo "$firstname $lastname";?></td>
							<td><?php echo "$given_name";?></td>
                            <td><?php echo "$phone";?></td>
							<td><?php echo "$guardian_name";?></td>
							<td><?php echo "$guardian_phone";?></td>
							<td><?php echo "$place_of_residence";?></td>
							<td><?php echo $row ['class'];?></td>
							<td ><?php echo "$stu_pass";?></td>
							<td ><?php echo "$first_mark";?></td>
                   
							<td style="background-color: #6fca5f;"><?php echo "$remarks";?></td>
							<td><img src="images/<?php echo "$picture";?>"></td>

  
                            	<td>
							
                             <a class="btn btn-outline-info btn-md" 
							 href="st_add.php?id=<?php echo $row['id'];?>"role="button">إضافه الدرجات</a>
                                
							</td>
                             
            
							<td>
						
                             <a class="btn btn-outline-warning btn-lg" 
							 href="st_edit.php?id=<?php echo $row['id'];?>"role="button">تعديل</a>
                                
							</td>
							<td>
							
                      
                             <a class="btn btn-outline-danger btn-lg" 
							 href="st_delete.php?id=<?php echo $row['id'];?>" role="button">حذف</a>
							</td>
                          

						</tr>
						
						<?php }?>
					</table>
    </center>

</body>
</html>