<?php

function findBestStudent($students)
{
    $bestStudent = null;

    foreach ($students as $student) {
        if (!($student instanceof Student)) {
            continue;
        }

        if ($bestStudent === null || $student->score > $bestStudent->score) {
            $bestStudent = $student;
        }
    }

    return $bestStudent;
}

function countPassedStudents($students)
{
    $passedStudents = 0;

    foreach ($students as $student) {
        if ($student instanceof Student && $student->isPassed()) {
            $passedStudents++;
        }
    }

    return $passedStudents;
}

function calculateAverageScore($students)
{
    $totalScore = 0;
    $studentCount = 0;

    foreach ($students as $student) {
        if ($student instanceof Student) {
            $totalScore += $student->score;
            $studentCount++;
        }
    }

    if ($studentCount === 0) {
        return 0;
    }

    return $totalScore / $studentCount;
}
