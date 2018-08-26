<?php

namespace App\Http\Controllers\Api;

use App\Track;
use App\Http\Resources\TrackResource;
use App\Repositories\TrackRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TrackController extends Controller
{
    public function index()
    {
        $tracks = Track::query()
            ->when(request("q"), function ($query) {
                $query->where("title", "like", request("q") . "%");
            })->orderBy('title', 'asc')
            ->get();

        return TrackResource::collection($tracks);
    }
}
