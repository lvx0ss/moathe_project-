<!DOCTYPE html>
<html>
<head>

    <meta charset="UTF-8">
    <style>
        /* تنسيق الشريط العلوي */
        #datetime-bar {
            background-color: #2c3e50;
            color: white;
            padding: 10px 0;
            position: fixed;
            top: 0;
            width: 100%;
            text-align: center;
            font-family: Arial, sans-serif;
            font-size: 16px;
            z-index: 1000;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }
        
        /* تعديل المحتوى ليتناسب مع الشريط الثابت */
        body {
            padding-top: 50px;
            margin: 0;
            font-family: Arial, sans-serif;
        }
        
        .content {
            padding: 20px;
        }
        
        /* تنسيق النص في الشريط */
        .datetime-text {
            display: inline-block;
            margin: 0 15px;
        }
    </style>
</head>
<body>
    <!-- الشريط العلوي -->
    <div id="datetime-bar">
        <?php
include_once __DIR__ . '/../config.php';

        // تحديد المنطقة الزمنية
        date_default_timezone_set('Asia/Riyadh');
        
        // التاريخ الميلادي
        $gregorian = date('d/m/Y');
        
        // الوقت
        $time = date('H:i:s');
        
        // تحويل التاريخ إلى هجري (بدون مكتبات)
        $hijri = gregorianToHijriSimple(date('Y'), date('m'), date('d'));
        
        echo '<span class="datetime-text">التاريخ الميلادي: '.$gregorian.'</span>';
        echo '<span class="datetime-text">التاريخ الهجري: '.$hijri.'</span>';
        echo '<span class="datetime-text">الوقت: '.$time.'</span>';
        
        /**
         * تحويل تاريخ ميلادي إلى هجري (طريقة تقريبية)
         */
        function gregorianToHijriSimple($gYear, $gMonth, $gDay) {
            // معادلة تقريبية للتحويل
            $hijriYear = round(($gYear - 622) * (33 / 32));
            
            // يمكن إضافة المزيد من الدقة هنا إذا لزم الأمر
            return $gDay.'/'.$gMonth.'/'.$hijriYear.' هـ';
        }
        ?>
    </div>
    

    
    <script>
        // تحديث الوقت كل ثانية
        function updateTime() {
            fetch('get_time.php')
                .then(response => response.text())
                .then(data => {
                    document.getElementById('datetime-bar').innerHTML = data;
                })
                .catch(error => console.error('Error:', error));
        }
        
        // تحديث كل ثانية
        setInterval(updateTime, 1000);
    </script>
</body>
</html>