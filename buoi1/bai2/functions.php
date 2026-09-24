<?php

function calculateAverageScore($students)
{
    if (count($students) === 0) {
        return 0;
    }

    $totalScore = 0;

    foreach ($students as $student) {
        $totalScore += $student['score'];
    }

    return $totalScore / count($students);
}

function getRank($score)
{
    if ($score >= 8) {
        return 'Giỏi';
    }

    if ($score >= 6.5) {
        return 'Khá';
    }

    if ($score >= 5) {
        return 'Trung bình';
    }

    return 'Yếu';
}

function displayStudent($student)
{
    echo '<tr>';
    echo '<td>' . htmlspecialchars($student['name']) . '</td>';
    echo '<td>' . $student['age'] . '</td>';
    echo '<td>' . $student['score'] . '</td>';
    echo '<td>' . getRank($student['score']) . '</td>';
    echo '</tr>';
}
