<!DOCTYPE html>
<?php
include_once __DIR__ . '/../config.php';

	require './conn/conn.php';
?>
<html dir="rtl">
	<head>
		<style>	
		.table {
			width: 100%;
			margin-bottom: 20px;
		}	
		
		.table-striped tbody > tr:nth-child(odd) > td,
		.table-striped tbody > tr:nth-child(odd) > th {
			background-color: #f9f9f9;
		}
		
		@media print{
			#print {
				display:none;
			}
		}
		@media print {
			#PrintButton {
				display: none;
			}
		}
		
		@page {
			size: auto;   /* auto is the initial value */
			margin: 0;  /* this affects the margin in the printer settings */
		}
	</style>
	</head>
<body>
	
	<br /> <br /> <br /> <br />
	<b style="color:blue;">نتيجه الطالب</b>

	<?php
		$date = date("Y-m-d", strtotime("+6 HOURS"));
		echo $date;
		
	?>
	<br /><br />
	<td><img src="images/<?php echo $picture; ?>" width="80" height="80" alt="صورة الطالب"></td>
	<table   border="1" class="table table-striped">
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
			</tr>
		</thead>
		<tbody>
			<?php
				require './conn/conn.php';		
				$id = $_GET['id'];
	$query = $conn->query ("SELECT * FROM  info_student WHERE id = '$id'");
			
				while($row = $query->fetch_array()){
					
			?>
			                <?php
             $id_school = $row['id'];
			 $firstname = $row['firstname'];
			 $lastname = $row['lastname'];
			 $phone = $row['phone'];
			 $first_mark = $row['first_mark'];
			 $final_mark = $first_mark; // هنا تم تصحيح حساب الدرجة النهائية
			 $given_name = $row['given_name'];
			 $guardian_name = $row['guardian_name'];
			 $guardian_phone = $row['guardian_phone'];
			 $place_of_residence = $row['place_of_residence'];
			 $class = $row['class'];
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

							<td style="text-align:center;"><?php echo $id_school; ?></td>
							<td style="text-align:center;"><?php echo $firstname . ' ' . $lastname; ?></td>
                            <td style="text-align:center;"><?php echo $given_name; ?></td>
                            <td style="text-align:center;"><?php echo $phone; ?></td>
                            <td style="text-align:center;"><?php echo $guardian_name; ?></td>
                            <td style="text-align:center;"><?php echo $guardian_phone; ?></td>
                            <td style="text-align:center;"><?php echo $place_of_residence; ?></td>
                            <td style="text-align:center;"><?php echo $class; ?></td>
                            <td style="text-align:center;"><?php echo $first_mark; ?></td>
                            <td style="background-color: #6fca5f;text-align:center"><?php echo $remarks; ?></td>
                            <td>
			</tr>
			
			<?php
				}
			?>
		</tbody>
	</table>
</body>
<script type="text/javascript">
	function PrintPage() {
		window.print();
	}
	document.loaded = function(){
		
	}
	window.addEventListener('DOMContentLoaded', (event) => {
   		PrintPage()
		setTimeout(function(){ window.close() },750)
	});
</script>
</html>


