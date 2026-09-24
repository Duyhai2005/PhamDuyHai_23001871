<?php

class Student
{
    public $name;
    public $age;
    public $score;

    public function __construct($name, $age, $score)
    {
        $this->name = $name;
        $this->age = $age;
        $this->score = $score;
    }

    public function getRank()
    {
        if ($this->score >= 8) {
            return 'Giỏi';
        }

        if ($this->score >= 6.5) {
            return 'Khá';
        }

        if ($this->score >= 5) {
            return 'Trung bình';
        }

        return 'Yếu';
    }

    public function isPassed()
    {
        return $this->score >= 5;
    }

    public function display()
    {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($this->name) . '</td>';
        echo '<td>' . $this->age . '</td>';
        echo '<td>' . $this->score . '</td>';
        echo '<td>' . $this->getRank() . '</td>';
        echo '<td>' . ($this->isPassed() ? 'Đạt' : 'Không đạt') . '</td>';
        echo '</tr>';
    }
}
