<?php


namespace App\Repositories;


use App\Track;

class TrackRepository
{

    public function getAll()
    {
        return Track::all();
    }
}
