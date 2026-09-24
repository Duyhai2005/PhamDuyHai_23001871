<?php

require_once __DIR__ . '/Student.php';
require_once __DIR__ . '/functions.php';

$student1 = new Student('Nguyen Van An', 20, 8.5);
$student2 = new Student('Tran Thi Binh', 21, 6.5);
$student3 = new Student('Le Van Cuong', 19, 4.5);
$student4 = new Student('Pham Thi Dung', 20, 7.5);

$students = [$student1, $student2, $student3, $student4];

echo '<!DOCTYPE html>';
echo '<html lang="vi">';
echo '<head><meta charset="UTF-8"><title>Buổi 1 - Bài 4</title></head>';
echo '<body>';
echo '<h1>Bài 4 - Quản lý sinh viên bằng OOP</h1>';
echo '<table border="1" cellpadding="8" cellspacing="0">';
echo '<tr><th>Họ tên</th><th>Tuổi</th><th>Điểm</th><th>Xếp loại</th><th>Trạng thái</th></tr>';

foreach ($students as $student) {
    $student->display();
}

echo '</table>';

$bestStudent = findBestStudent($students);
echo '<p>Sinh viên có điểm cao nhất: ' . htmlspecialchars($bestStudent->name) . ' - ' . $bestStudent->score . ' điểm.</p>';
echo '<p>Số sinh viên đạt: ' . countPassedStudents($students) . '</p>';
echo '<p>Điểm trung bình của lớp: ' . calculateAverageScore($students) . '</p>';

echo '</body>';
echo '</html>';
