<?php
include_once __DIR__ . '/../config.php';

session_start();
require_once './conn/conn.php';

if (!isset($_SESSION["id"]) || $_SESSION["usertype"] !== 'ADMIN') {
    header("location: index.php");
    exit();
}

$accounts = mysqli_query($conn, "SELECT * FROM admin_accounts ORDER BY id ASC");
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>لوحة التحكم - إدارة الحسابات</title>
    <style>
        body {
            font-family: 'Tahoma', Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        .content {
            padding: 20px;
        }

        .header {
            background-color: #076177;
            color: white;
            padding: 15px;
            text-align: center;
        }

        .action-buttons {
            margin: 20px 0;
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        .action-btn {
            padding: 10px 20px;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            background-color: #076177;
            transition: all 0.3s;
        }

        .action-btn:hover {
            opacity: 0.9;
            transform: translateY(-2px);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        th, td {
            padding: 12px;
            text-align: center;
            border: 1px solid #ddd;
        }

        th {
            padding: 12px;
            text-align: center;
            background-color: #076177;
            color: white;
        }
        tr{
            padding: 12px;
            text-align: center; 
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }
    </style>
</head>
<body>

<?php include('admin_header.php'); ?>

<div class="content">
    <h1 style="color: #076177;">لوحة التحكم - الحسابات</h1>

    <div class="action-buttons">
        <a href="../service/mang_programs.php" class="action-btn">إدارة البرامج</a>
    <a href="../courses/mang_courses.php" class="action-btn">إدارة الدورات</a>
</div>
        <!-- يمكنك إضافة زر "إضافة حساب" هنا مستقبلاً -->
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>الاسم الأول</th>
                <th>الاسم الأخير</th>
                <th>اسم المستخدم</th>
                <th>كلمة المرور</th>
                <th>نوع الحساب</th>
                <th>تعديل </th>
                <th>حذف</th>
            </tr>
        </thead>
        <tbody>
            <?php if (mysqli_num_rows($accounts) > 0): ?>
                <?php while($row = mysqli_fetch_assoc($accounts)): ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= htmlspecialchars($row['firstname']) ?></td>
                        <td><?= htmlspecialchars($row['lastname']) ?></td>
                        <td><?= htmlspecialchars($row['username']) ?></td>
                        <td><?php echo $row['password']; ?></td>
                        <td><?= htmlspecialchars($row['usertype']) ?></td>
                        <td>
                        <a class="btn btn-outline-info btn-lg" 
							href="edit_account.php?id=<?php echo $row['id'];?>">تعديل</a>
							</td>

							<td>
							<a class="btn btn-outline-danger btn-lg"
							 href="delete_account.php?id=<?php echo $row['id'];?>" >حذف</a>
							</td>
                    </tr>
                <?php endwhile ?>
            <?php else: ?>
                <tr><td colspan="5">لا توجد حسابات.</td></tr>
            <?php endif ?>
        </tbody>
    </table>
</div>

</body>
</html>
