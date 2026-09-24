<?php

$students = require_once __DIR__ . '/../data/students.php';
require_once __DIR__ . '/functions.php';

function displayStudentResult($student)
{
    if ($student === null) {
        echo '<p>Không tìm thấy sinh viên.</p>';
        return;
    }

    echo '<p>' . htmlspecialchars($student['name']) . ' - Điểm: ' . $student['score'] . '</p>';
}

echo '<!DOCTYPE html>';
echo '<html lang="vi">';
echo '<head><meta charset="UTF-8"><title>Buổi 1 - Bài 3</title></head>';
echo '<body>';
echo '<h1>Bài 3 - Xử lý danh sách sinh viên</h1>';

echo '<h2>Sinh viên có điểm cao nhất</h2>';
displayStudentResult(findBestStudent($students));

echo '<h2>Sinh viên có điểm thấp nhất</h2>';
displayStudentResult(findWorstStudent($students));

echo '<p>Số sinh viên đạt: ' . countPassedStudents($students) . '</p>';

echo '<h2>Tìm sinh viên theo tên</h2>';
displayStudentResult(findStudentByName($students, 'Tran Thi Binh'));

echo '<h2>Tìm sinh viên không tồn tại</h2>';
displayStudentResult(findStudentByName($students, 'Nguyen Van X'));

echo '</body>';
echo '</html>';
