<style>
img {
    max-width: 80px;
    max-height: 80px;
    border-radius: 50%;
    border: 2px solid #ccc;
}

tr, td, th {
    width: 8%;
    text-align: center;
}

table {
    width: 100%;
    border-collapse: collapse;
}

th, td {
    padding: 8px;
    border: 1px solid #ddd;
}

th {
    background-color: #f2f2f2;
}

.table {
    width: 100%;
}
</style>

<?php
include_once __DIR__ . '/../config.php';

require_once './conn/conn.php';
include_once "header.php";

session_start();
?>

<body>
    <center>
        <?php include('admin_header.php'); ?>

        <table class="table table-responsive table-lg table-md table-sm table-hover table-bordered">
            <thead>
                <tr>
                    <th>الرقم المدرسي</th>
                    <th>الاسم</th>
                    <th>اللقب</th>
                    <th>رقم الموبايل</th>
                    <th>اسم ولي الامر</th>
                    <th>هاتف ولي الامر</th>
                    <th>السكن</th>
                    <th>حلقة التحفيظ</th>
                    <th>كلمة سر الطالب</th>
                    <th>الصورة</th>
                    <th>رقم المعلم</th>
                    <th>الدرجة</th>
                    <th>النتيجة</th>
                  

                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM info_student;";
                $query = mysqli_query($conn, $sql);

                if (mysqli_num_rows($query) > 0) {
                    while ($row = mysqli_fetch_array($query)) {
                        $id_school = $row['id'];
                        $firstname = $row['firstname'];
                        $lastname = $row['lastname'];
                        $phone = $row['phone'];
                        $first_mark = $row['first_mark'];
                        $final_mark = $first_mark; // هنا تم تصحيح حساب الدرجة النهائية
                        $given_name = $row['given_name'];
                        $guardian_name = $row['guardian_name'];
                        $guardian_phone = $row['guardian_phone'];
                        $te_id=$row['teacher_number'];
                        $place_of_residence = $row['place_of_residence'];
                        $class = $row['class'];
                        $stu_pass=$row['stu_pass'];
                        $hashed_pass = md5($stu_pass);

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
                        $picture = $row['picture'];
                        ?>

                        <tr>
                            <td><?php echo $id_school; ?></td>
                            <td><?php echo $firstname . ' ' . $lastname; ?></td>
                            <td><?php echo $given_name; ?></td>
                            <td><?php echo $phone; ?></td>
                            <td><?php echo $guardian_name; ?></td>
                            <td><?php echo $guardian_phone; ?></td>
                            <td><?php echo $place_of_residence; ?></td>
                            <td><?php echo $class; ?></td>
                            <td ><?php echo "$stu_pass";?></td>
                            <td><img src="images/<?php echo "$picture";?>"></td>
                            <td><?php echo $te_id; ?></td>
                            <td><?php echo $first_mark; ?></td>

                            <td style="background-color: #6fca5f;"><?php echo $remarks; ?></td>
                        
                        </tr>
                    <?php
                    }
                } else {
                    echo "<tr><td colspan='13'>لا توجد بيانات للطلاب.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </center>
</body>

</html>