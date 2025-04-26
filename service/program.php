<?php
include_once __DIR__ . '/../config.php';

include_once "C:/xampp/htdocs/project/bar/index.php";
require_once 'conn.php';

// جلب البرامج مجمعة حسب النوع
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
    <title>البرامج والدورات</title>
    <link rel="stylesheet" href="style2.css">
    <link rel="stylesheet" href="style.css">
    <style>
        .container {
            border: 1px solid #ccc;
            border-radius: 10px;
            background: #fff;
            padding: 20px;
            margin: 20px;
            width: 300px;
            float: right;
            text-align: center;
            box-shadow: 0 0 5px rgba(0,0,0,0.1);
        }
        .container img {
            max-width: 100%;
            border-radius: 10px;
        }
        .container p {
            margin: 10px 0;
        }
        .container button {
            background-color: #076177;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }
        h2 {
            clear: both;
            padding-top: 20px;
            color: white;
            margin: 0 0 0 5;

        }
    </style>
</head>
<body>

<?php foreach ($programs as $type => $list): ?>
    <h2><?= htmlspecialchars($type) ?></h2>
    <?php foreach ($list as $program): ?>
        <div class="container">
            <img src="uploads/<?= htmlspecialchars($program['image']) ?>" alt="صورة البرنامج">
            <p><?= htmlspecialchars($program['name']) ?></p>
            <a href="uploads/<?= htmlspecialchars($program['pdf']) ?>" download>
                <button>تحميل</button>
            </a>
        </div>
    <?php endforeach; ?>
<?php endforeach; ?>

</body>
</html>
