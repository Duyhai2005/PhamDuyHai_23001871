<?php

function findMovieById($movies, $id)
{
    foreach ($movies as $movie) {
        if ($movie instanceof Movie && $movie->getId() == $id) {
            return $movie;
        }
    }

    return null;
}

function getTotalRevenue($movies)
{
    $totalRevenue = 0;

    foreach ($movies as $movie) {
        if ($movie instanceof Movie) {
            $totalRevenue += $movie->getRevenue();
        }
    }

    return $totalRevenue;
}

function getBestSellingMovie($movies)
{
    $bestSellingMovie = null;

    foreach ($movies as $movie) {
        if (!($movie instanceof Movie)) {
            continue;
        }

        if ($bestSellingMovie === null || $movie->getSoldSeats() > $bestSellingMovie->getSoldSeats()) {
            $bestSellingMovie = $movie;
        }
    }

    return $bestSellingMovie;
}
