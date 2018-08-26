<?php

namespace App\Http\Controllers;

use App\Genre;
use App\Track;
use App\Artist;
use App\Repositories\GenreRepository;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    public function index()
    {
        return view("genres.index", [
            "genres" => Genre::all()
        ]);
    }

    public function show($id) {
      return view('genres.show', [
          'genre' => Genre::findOrFail($id),
          'tracks' => Track::whereGenreId($id)->get()->groupBy('artist_id')
      ]);
    }
}
