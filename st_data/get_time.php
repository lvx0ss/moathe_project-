<?php
include_once __DIR__ . '/../config.php';

date_default_timezone_set('Asia/Riyadh');

// التاريخ الميلادي
$gregorian = date('d/m/Y');

// الوقت
$time = date('H:i:s');

// التاريخ الهجري (تقريبي)
$hijri = gregorianToHijriSimple(date('Y'), date('m'), date('d'));

echo '<span class="datetime-text">التاريخ الميلادي: '.$gregorian.'</span>';
echo '<span class="datetime-text">التاريخ الهجري: '.$hijri.'</span>';
echo '<span class="datetime-text">الوقت: '.$time.'</span>';

/**
 * تحويل تاريخ ميلادي إلى هجري (تقريبي)
 */
function gregorianToHijriSimple($gYear, $gMonth, $gDay) {
    $hijriYear = round(($gYear - 622) * (33 / 32));
    return $gDay.'/'.$gMonth.'/'.$hijriYear.' هـ';
}
?>
