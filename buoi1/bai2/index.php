<?php

$students = require_once __DIR__ . '/../data/students.php';
require_once __DIR__ . '/functions.php';

echo '<!DOCTYPE html>';
echo '<html lang="vi">';
echo '<head><meta charset="UTF-8"><title>Buổi 1 - Bài 2</title></head>';
echo '<body>';
echo '<h1>Bài 2 - Tách hàm xử lý sinh viên</h1>';
echo '<table border="1" cellpadding="8" cellspacing="0">';
echo '<tr><th>Họ tên</th><th>Tuổi</th><th>Điểm</th><th>Xếp loại</th></tr>';

foreach ($students as $student) {
    displayStudent($student);
}

echo '</table>';
echo '<p>Điểm trung bình: ' . calculateAverageScore($students) . '</p>';
echo '</body>';
echo '</html>';
