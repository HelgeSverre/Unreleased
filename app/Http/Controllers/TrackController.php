<?php

namespace App\Http\Controllers;

use App\Genre;
use App\Track;
use Illuminate\Http\Request;

class TrackController extends Controller
{
    public function index()
    {
        return view("tracks.index", [
            "tracks" => Track::orderBy('created_at', 'desc')->take(10)->get()
        ]);
    }


    public function create()
    {
        if (\Auth::guest()) {
            flash("You must be logged in to post new tracks");
            return redirect()->route("register");
        }

        return view("tracks.create", [
            "genres" => Genre::pluck('name', 'id')
        ]);
    }

    public function store(Request $request)
    {
        if (\Auth::guest()) {
            flash("You must be logged in to post new tracks");
            return redirect()->route("register");
        }
        $this->validate(request(), [
          'title' => 'required',
          'artist_id' => 'required',
          'genre_id' => 'required',
          'source_url' => 'required | url',
          'source_description' => 'required',
        ]);

        Track::create([
            "artist_id" => $request->input("artist_id"),
            "genre_id" => $request->input("genre_id"),
            "source_url" => $request->input("source_url"),
            "source_description" => $request->input("source_description"),
            "title" => $request->input("title"),
        ]);

        session()->flash('success', 'Your track has been added successfully.');
        return redirect()->route("track.index");

    }
    public function edit($id)
    {
        return view("tracks.edit", [
            "track" => Track::findOrFail($id),
        ]);
    }

    public function update(Request $request, $id)
    {
      $track = Track::findOrFail($id);

      $track->artist_id = $request->input('artist_id');
      $track->genre_id = $request->input('genre_id');
      $track->source_url = $request->input('source_url');
      $track->source_description = $request->input('source_description');
      $track->title = $request->input('title');
      $track->save();

      session()->flash('success', 'The track has been updated successfully.');

      return redirect()->route('track.index');

    }

}
