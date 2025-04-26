
<?php
include_once __DIR__ . '/../config.php';

session_start();
require_once 'conn.php';

if (!isset($_SESSION["id"]) || $_SESSION["usertype"] !== 'ADMIN') {
    header("location: index.php");
    exit();
}

// حذف البرنامج
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $get = mysqli_query($conn, "SELECT image, pdf FROM programs WHERE id = $id");
    $row = mysqli_fetch_assoc($get);
    if ($row) {
        if (!empty($row['image'])) unlink("../uploads/" . $row['image']);
        if (!empty($row['pdf'])) unlink("../uploads/" . $row['pdf']);
    }
    mysqli_query($conn, "DELETE FROM programs WHERE id = $id");
    header("Location: mang_programs.php");
    exit();
}

// تعديل البرنامج
if (isset($_POST['edit_program'])) {
    $id = intval($_POST['id']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $type = mysqli_real_escape_string($conn, $_POST['type']);

    $image = '';
    if (!empty($_FILES['image']['name'])) {
        $image = time() . '_' . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], "uploads/$image");
        mysqli_query($conn, "UPDATE programs SET image='$image' WHERE id = $id");
    }

    $pdf = '';
    if (!empty($_FILES['pdf']['name'])) {
        $pdf = time() . '_' . $_FILES['pdf']['name'];
        move_uploaded_file($_FILES['pdf']['tmp_name'], "uploads/$pdf");
        mysqli_query($conn, "UPDATE programs SET pdf='$pdf' WHERE id = $id");
    }

    mysqli_query($conn, "UPDATE programs SET name='$name', type='$type' WHERE id = $id");
    header("Location: mang_programs.php");
    exit();
}

// جلب البرامج
$programs = [];
$result = mysqli_query($conn, "SELECT * FROM programs ORDER BY type, id ASC");
while ($row = mysqli_fetch_assoc($result)) {
    $programs[$row['type']][] = $row;
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>إدارة البرامج</title>
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
        .form-edit input, .form-edit select {
            width: 100%;
            padding: 8px;
            margin-top: 6px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
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

<h2>إدارة البرامج</h2>

<a href="add_program.php" class="add-btn">➕ إضافة برنامج</a>
<a href="../st_data/mang_accounts.php" class="add-btn">خروج</a>
<?php foreach ($programs as $type => $list): ?>
    <h3><?= htmlspecialchars($type) ?></h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>اسم البرنامج</th>
                <th>الصورة</th>
                <th>الملف</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($list as $program): ?>
            <tr>
                <td><?= $program['id'] ?></td>
                <td><?= htmlspecialchars($program['name']) ?></td>
                <td><img src="uploads/<?= htmlspecialchars($program['image']) ?>" alt="صورة البرنامج"></td>
                <td><a href="uploads/<?= htmlspecialchars($program['pdf']) ?>" target="_blank">📄 عرض الملف</a></td>
                <td class="action-buttons">
                    <a href="?edit=<?= $program['id'] ?>" class="edit-btn">تعديل</a>
                    <a href="?delete=<?= $program['id'] ?>" class="delete-btn" onclick="return confirm('هل أنت متأكد من الحذف؟')">حذف</a>
                </td>
            </tr>

            <?php if (isset($_GET['edit']) && $_GET['edit'] == $program['id']): ?>
            <tr>
                <td colspan="5">
                    <form method="post" enctype="multipart/form-data" class="form-edit">
                        <input type="hidden" name="id" value="<?= $program['id'] ?>">

                        <label for="name">اسم البرنامج:</label>
                        <input type="text" name="name" value="<?= htmlspecialchars($program['name']) ?>" required>

                        <label for="type">نوع البرنامج:</label>
                        <select name="type" required>
                            <option value="بداية من الناس" <?= $program['type'] == 'الناس' ? 'selected' : '' ?>>برامج الحفظ بداية من سورة الناس</option>
                            <option value="البقرة" <?= $program['type'] == 'البقرة' ? 'selected' : '' ?>>برامج الحفظ بداية من سورة البقرة</option>
                            <option value="مبتدئين" <?= $program['type'] == 'مبتدئين' ? 'selected' : '' ?>>برامج الحفظ للمبتدئين   </option>
                            <option value="اخرى" <?= $program['type'] == 'اخرى' ? 'selected' : '' ?>>برامج اخرى </option>
                          
                        </select>

                        <label>الصورة الحالية:</label><br>
                        <img src="uploads/<?= htmlspecialchars($program['image']) ?>" style="max-width: 100px;"><br>
                        <label for="image">تحديث الصورة:</label>
                        <input type="file" name="image" accept="image/*">

                        <label>الملف الحالي:</label><br>
                        <a href="uploads/<?= htmlspecialchars($program['pdf']) ?>" target="_blank">📄 عرض الملف</a><br>
                        <label for="pdf">تحديث الملف (PDF):</label>
                        <input type="file" name="pdf" accept="application/pdf">

                        <button type="submit" name="edit_program">💾 حفظ التعديلات</button>
                    </form>
                </td>
            </tr>
            <?php endif; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endforeach; ?>

</body>
</html>
