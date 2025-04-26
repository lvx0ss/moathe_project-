<?php
include_once __DIR__ . '/../config.php';

require_once './conn/conn.php';
include_once "header.php";

session_start();
if(!isset($_SESSION["id"]) || $_SESSION["usertype"] != 'ADMIN') {
    header('location: index.php');
    exit();
}

// معالجة حذف البرنامج إذا تم الضغط على زر الحذف
if(isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    $delete_query = "DELETE FROM programs WHERE id = $id";
    if(mysqli_query($conn, $delete_query)) {
        header('location: delete_programs.php?deleted=1');
        exit();
    }
}

// جلب جميع البرامج من قاعدة البيانات
$programs_query = "SELECT * FROM programs ORDER BY id DESC";
$programs_result = mysqli_query($conn, $programs_query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>حذف البرامج</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .program-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }
        .program-card {
            border: 1px solid #ddd;
            padding: 15px;
            width: 300px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .program-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .program-actions {
            margin-top: 10px;
            display: flex;
            gap: 10px;
        }
        .delete-btn {
            background-color: #f44336;
            color: white;
            padding: 8px 15px;
            text-decoration: none;
            border-radius: 4px;
        }
        .back-btn {
            display: inline-block;
            margin-bottom: 20px;
            background-color: #076177;
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 4px;
        }
        .alert {
            padding: 10px;
            margin-bottom: 15px;
            background-color: #dff0d8;
            color: #3c763d;
            border-radius: 4px;
        }
    </style>
    <script>
        function confirmDelete(programTitle) {
            return confirm(`هل أنت متأكد من حذف البرنامج: ${programTitle}؟`);
        }
    </script>
</head>
<body>
    <a href="mang_accounts.php" class="back-btn">العودة إلى لوحة التحكم</a>
    <h2>حذف البرامج</h2>
    
    <?php if(isset($_GET['deleted'])): ?>
        <div class="alert">تم حذف البرنامج بنجاح</div>
    <?php endif; ?>
    
    <div class="program-container">
        <?php if(mysqli_num_rows($programs_result) > 0): ?>
            <?php while($program = mysqli_fetch_assoc($programs_result)): ?>
                <div class="program-card">
                    <img src="photo/<?php echo htmlspecialchars($program['image_path']); ?>" 
                         class="program-image" 
                         alt="<?php echo htmlspecialchars($program['title']); ?>">
                    <h3><?php echo htmlspecialchars($program['title']); ?></h3>
                    <p><?php echo htmlspecialchars($program['description']); ?></p>
                    <div class="program-actions">
                        <a href="delete_programs.php?delete_id=<?php echo $program['id']; ?>" 
                           class="delete-btn"
                           onclick="return confirmDelete('<?php echo htmlspecialchars($program['title']); ?>')">
                            حذف هذا البرنامج
                        </a>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>لا توجد برامج متاحة للحذف</p>
        <?php endif; ?>
    </div>
</body>
</html>