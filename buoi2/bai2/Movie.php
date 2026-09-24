<?php

class Movie
{
    private $id;
    private $title;
    private $price;
    private $totalSeats;
    private $availableSeats;

    public function __construct($id, $title, $price, $totalSeats)
    {
        $this->id = $id;
        $this->title = $title;
        $this->price = $price;
        $this->totalSeats = $totalSeats;
        $this->availableSeats = $totalSeats;
    }

    public function bookTicket($quantity)
    {
        if ($quantity <= 0) {
            echo '<p>Không thể đặt số vé nhỏ hơn hoặc bằng 0.</p>';
            return false;
        }

        if ($quantity > $this->availableSeats) {
            echo '<p>Không đủ ghế trống cho phim ' . htmlspecialchars($this->title) . '.</p>';
            return false;
        }

        $this->availableSeats -= $quantity;
        return true;
    }

    public function cancelTicket($quantity)
    {
        if ($quantity <= 0) {
            echo '<p>Không thể hủy số vé nhỏ hơn hoặc bằng 0.</p>';
            return false;
        }

        if ($quantity > $this->getSoldSeats()) {
            echo '<p>Không thể hủy nhiều hơn số vé đã bán của phim ' . htmlspecialchars($this->title) . '.</p>';
            return false;
        }

        $this->availableSeats += $quantity;
        return true;
    }

    public function getSoldSeats()
    {
        return $this->totalSeats - $this->availableSeats;
    }

    public function getRevenue()
    {
        return $this->getSoldSeats() * $this->price;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function displayInfo()
    {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($this->id) . '</td>';
        echo '<td>' . htmlspecialchars($this->title) . '</td>';
        echo '<td>' . number_format($this->price, 0, ',', '.') . ' đ</td>';
        echo '<td>' . $this->totalSeats . '</td>';
        echo '<td>' . $this->availableSeats . '</td>';
        echo '<td>' . $this->getSoldSeats() . '</td>';
        echo '<td>' . number_format($this->getRevenue(), 0, ',', '.') . ' đ</td>';
        echo '</tr>';
    }
}
