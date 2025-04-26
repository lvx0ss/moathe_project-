<?php
include_once __DIR__ . '/../config.php';

session_start();
require_once 'conn.php';

if (!isset($_SESSION["id"]) || $_SESSION["usertype"] !== 'ADMIN') {
    header("location: index.php");
    exit();
}

// حذف الدورة
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $get = mysqli_query($conn, "SELECT image, pdf FROM courses WHERE id = $id");
    $row = mysqli_fetch_assoc($get);
    if ($row) {
        if (!empty($row['image'])) unlink($row['image']);
        if (!empty($row['pdf'])) unlink($row['pdf']);
    }
    mysqli_query($conn, "DELETE FROM courses WHERE id = $id");
    header("Location: mang_courses.php");
    exit();
}

// تعديل الدورة
if (isset($_POST['edit_course'])) {
    $id = intval($_POST['id']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    $image = '';
    if (!empty($_FILES['image']['name'])) {
        $image = time() . '_' . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], "uploads/$image");
        mysqli_query($conn, "UPDATE courses SET image='$image' WHERE id = $id");
    }

    $pdf = '';
    if (!empty($_FILES['pdf']['name'])) {
        $pdf = time() . '_' . $_FILES['pdf']['name'];
        move_uploaded_file($_FILES['pdf']['tmp_name'], "uploads/$pdf");
        mysqli_query($conn, "UPDATE courses SET pdf='$pdf' WHERE id = $id");
    }

    mysqli_query($conn, "UPDATE courses SET name='$name', description='$description' WHERE id = $id");
    header("Location: mang_courses.php");
    exit();
}

// جلب الدورات
$courses = mysqli_query($conn, "SELECT * FROM courses ORDER BY id ASC");
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>إدارة الدورات</title>
    <style>
        body {
            font-family: Tahoma, Arial;
            background-color: #f5f5f5;
            padding: 20px;
        }
        table {
            width: 100%;
            background: white;
            border-collapse: collapse;
            margin-bottom: 40px;
            box-shadow: 0 0 5px rgba(0,0,0,0.1);
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: center;
        }
        th {
            background-color: #076177;
            color: white;
        }
        img {
            width: 100px;
            height: auto;
        }
        .action-buttons a {
            padding: 6px 12px;
            color: white;
            text-decoration: none;
            margin: 2px;
            border-radius: 4px;
        }
        .edit-btn { background-color: #4CAF50; }
        .delete-btn { background-color: #f44336; }
        .show-btn { background-color:rgb(89, 54, 244); }
        .add-btn {
            display: inline-block;
            margin-bottom: 20px;
            background-color: #076177;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
        }
        .form-edit {
            background-color: #fdfdfd;
            border: 1px solid #ccc;
            padding: 20px;
            margin-top: 10px;
            border-radius: 8px;
        }
        .form-edit input, .form-edit textarea, .form-edit select {
            width: 100%;
            padding: 8px;
            margin-top: 6px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .form-edit textarea {
            height: 100px;
        }
        .form-edit label {
            font-weight: bold;
        }
        .form-edit button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 18px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .form-edit button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<h2>إدارة الدورات</h2>

<a href="add_course.php" class="add-btn">➕ إضافة دورة</a>
<a href="/project/st_data/mang_accounts.php" class="add-btn">عودة</a>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>اسم الدورة</th>
            <th>الوصف</th>
            <th>الصورة</th>
            <th>الإجراءات</th>
        </tr>
    </thead>
    <tbody>
        <?php if (mysqli_num_rows($courses) > 0): ?>
            <?php while($course = mysqli_fetch_assoc($courses)): ?>
            <tr>
                <td><?= $course['id'] ?></td>
                <td><?= htmlspecialchars($course['name']) ?></td>
                <td><?= htmlspecialchars($course['description']) ?></td>
                <td><img src="<?= htmlspecialchars($course['image']) ?>" alt="صورة الدورة"></td>
                <td class="action-buttons">
                    <a href="show_participants.php?course_id=<?= $course['id'] ?>" class="show-btn">المشتركين</a>
                    <a href="?edit=<?= $course['id'] ?>" class="edit-btn">تعديل</a>
                    <a href="?delete=<?= $course['id'] ?>" class="delete-btn" onclick="return confirm('هل أنت متأكد من الحذف؟')">حذف</a>
                </td>
            </tr>

            <?php if (isset($_GET['edit']) && $_GET['edit'] == $course['id']): ?>
            <tr>
                <td colspan="6">
                    <form method="post" enctype="multipart/form-data" class="form-edit">
                        <input type="hidden" name="id" value="<?= $course['id'] ?>">

                        <label for="name">اسم الدورة:</label>
                        <input type="text" name="name" value="<?= htmlspecialchars($course['name']) ?>" required>

                        <label for="description">وصف الدورة:</label>
                        <textarea name="description" required><?= htmlspecialchars($course['description']) ?></textarea>

                        <label>الصورة الحالية:</label><br>
                        <img src="<?= htmlspecialchars($course['image']) ?>" style="max-width: 100px;"><br>
                        <label for="image">تحديث الصورة:</label>
                        <input type="file" name="image" accept="image/*">

                    

                        <button type="submit" name="edit_course">💾 حفظ التعديلات</button>
                    </form>
                </td>
            </tr>
            <?php endif; ?>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="6">لا توجد دورات.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

</body>
</html>