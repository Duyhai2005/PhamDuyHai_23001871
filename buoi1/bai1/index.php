<?php

$students = require_once __DIR__ . '/../data/students.php';

echo '<!DOCTYPE html>';
echo '<html lang="vi">';
echo '<head><meta charset="UTF-8"><title>Buổi 1 - Bài 1</title></head>';
echo '<body>';
echo '<h1>Bài 1 - Danh sách sinh viên</h1>';
echo '<table border="1" cellpadding="8" cellspacing="0">';
echo '<tr><th>Họ tên</th><th>Tuổi</th><th>Điểm</th></tr>';

$totalScore = 0;

foreach ($students as $student) {
    echo '<tr>';
    echo '<td>' . htmlspecialchars($student['name']) . '</td>';
    echo '<td>' . $student['age'] . '</td>';
    echo '<td>' . $student['score'] . '</td>';
    echo '</tr>';
    $totalScore += $student['score'];
}

echo '</table>';
echo '<p>Điểm trung bình: ' . ($totalScore / count($students)) . '</p>';
echo '</body>';
echo '</html>';
