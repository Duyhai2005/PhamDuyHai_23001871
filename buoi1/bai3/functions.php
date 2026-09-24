<?php

function findBestStudent($students)
{
    $bestStudent = null;

    foreach ($students as $student) {
        if ($bestStudent === null || $student['score'] > $bestStudent['score']) {
            $bestStudent = $student;
        }
    }

    return $bestStudent;
}

function findWorstStudent($students)
{
    $worstStudent = null;

    foreach ($students as $student) {
        if ($worstStudent === null || $student['score'] < $worstStudent['score']) {
            $worstStudent = $student;
        }
    }

    return $worstStudent;
}

function countPassedStudents($students)
{
    $passedStudents = 0;

    foreach ($students as $student) {
        if ($student['score'] >= 5) {
            $passedStudents++;
        }
    }

    return $passedStudents;
}

function findStudentByName($students, $name)
{
    foreach ($students as $student) {
        if ($student['name'] === $name) {
            return $student;
        }
    }

    return null;
}
