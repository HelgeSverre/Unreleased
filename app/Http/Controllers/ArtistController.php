<?php

namespace App\Http\Controllers;

use App\Artist;
use App\Repositories\ArtistRepository;
use Illuminate\Http\Request;
use Discogs;
use Jolita\DiscogsApi\SearchParameters;
use App\Events\ArtistCreated;



class ArtistController extends Controller
{
    public function index()
    {
        return view("artists.index");
    }

    public function show($id){
      return view("artists.show", [
          "artist" => Artist::findOrFail($id)
      ]);
    }

    public function create()
    {
      if (\Auth::guest()) {
          flash("You must be logged in to create new artists");
          return redirect()->route("register");
      }

      return view("artists.create");
    }

    public function store(Request $request)
    {
      if (\Auth::guest()) {
          flash("You must be logged in to create new artists");
          return redirect()->route("register");
      }
      $this->validate(request(), [
        'stage_name' => 'required|unique:artists',
        'real_name' => 'required',
      ]);

      $artist = Artist::create([
          "stage_name" => $request->input("stage_name"),
          "real_name" => $request->input("real_name"),
          "bio" => $request->input("bio"),
      ]);

      event(new ArtistCreated($artist));

      session()->flash('success', 'Your artist has been added successfully.');
      return redirect()->route("artist.index");
    }

    public function edit($id)
    {
      return view("artists.edit", [
          "artist" => Artist::findOrFail($id)
      ]);
    }

    public function update(Request $request, $id)
    {
      if (\Auth::guest()) {
          flash("You must be logged in to post new tracks");
          return redirect()->route("register");
      }

      $this->validate(request(), [
        'real_name' => 'required',
      ]);
    $artist = Artist::findOrFail($id);
    $artist->real_name = $request->input('real_name');
    $artist->bio = $request->input('bio');
    $artist->save();

    session()->flash('success', $artist->stage_name.' has been updated successfully.');
    return redirect()->route("artist.show", [$id]);

    }
}
