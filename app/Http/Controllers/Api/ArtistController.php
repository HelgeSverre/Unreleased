<?php

namespace App\Http\Controllers\Api;

use App\Artist;
use App\Events\ArtistCreated;
use App\Http\Resources\ArtistResource;
use App\Repositories\ArtistRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArtistController extends Controller
{
    public function index()
    {
        $artists = Artist::query()
            ->when(request("q"), function ($query) {
                $query->where("stage_name", "like", request("q") . "%");
                $query->orWhere("real_name", "like", request("q") . "%");
            })->orderBy('stage_name', 'asc')
            ->get();

        return ArtistResource::collection($artists);
    }

    public function store(Request $request)
    {

        $this->validate($request, ["stage_name" => "unique:artists,stage_name"]);

        $artist = Artist::create([
            "stage_name" => $request->input("stage_name")
        ]);


        event(new ArtistCreated($artist));

        return new ArtistResource($artist);

    }
}
