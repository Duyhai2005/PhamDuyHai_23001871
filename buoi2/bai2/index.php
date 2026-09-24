<?php

require_once __DIR__ . '/Movie.php';
require_once __DIR__ . '/functions.php';

echo '<!DOCTYPE html>';
echo '<html lang="vi">';
echo '<head><meta charset="UTF-8"><title>Bài 2 - Quản lý vé xem phim</title></head>';
echo '<body>';
echo '<h1>Bài 2 - Quản lý vé xem phim</h1>';

$movies = [
    new Movie(1, 'Avengers', 100000, 100),
    new Movie(2, 'Avatar', 120000, 80),
    new Movie(3, 'Batman', 90000, 120)
];

$avengers = findMovieById($movies, 1);
$avatar = findMovieById($movies, 2);

if ($avengers !== null && $avengers->bookTicket(30)) {
    echo '<p>Đã đặt 30 vé phim Avengers.</p>';
}

if ($avatar !== null && $avatar->bookTicket(20)) {
    echo '<p>Đã đặt 20 vé phim Avatar.</p>';
}

if ($avengers !== null && $avengers->cancelTicket(5)) {
    echo '<p>Đã hủy 5 vé phim Avengers.</p>';
}

echo '<h2>Thông tin các bộ phim</h2>';
echo '<table border="1" cellpadding="8" cellspacing="0">';
echo '<tr><th>Mã phim</th><th>Tên phim</th><th>Giá vé</th><th>Tổng số ghế</th><th>Ghế còn lại</th><th>Vé đã bán</th><th>Doanh thu</th></tr>';

foreach ($movies as $movie) {
    $movie->displayInfo();
}

echo '</table>';
echo '<p>Tổng doanh thu: ' . number_format(getTotalRevenue($movies), 0, ',', '.') . ' đ</p>';

$bestSellingMovie = getBestSellingMovie($movies);
if ($bestSellingMovie === null) {
    echo '<p>Danh sách phim đang trống.</p>';
} else {
    echo '<p>Phim bán được nhiều vé nhất: ' . htmlspecialchars($bestSellingMovie->getTitle()) . '.</p>';
}

$notFoundMovie = findMovieById($movies, 99);
if ($notFoundMovie === null) {
    echo '<p>Không tìm thấy phim có mã 99.</p>';
}

echo '</body>';
echo '</html>';
