<?php

namespace Tests\Feature;

use App\Track;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TrackApiFeatureTest extends TestCase
{
    use RefreshDatabase;


    /** @test */
    public function can_fetch_track_from_api()
    {
        factory(Track::class)->times(10)->create();


        $this->json("get", "/api/tracks")
            ->assertStatus(200)
            ->assertJsonCount(10);
    }


    /** @test */
    public function can_filter_out_track_by_title()
    {
        factory(Track::class)->create(["title" => "Supersong"]);
        factory(Track::class)->create(["title" => "Rave-to-the-grave"]);
        factory(Track::class)->create(["title" => "I will survive"]);
        factory(Track::class)->create(["title" => "Sol i vente"]);
        factory(Track::class)->create(["title" => "Sol i magen"]);
        factory(Track::class)->create(["title" => "Sol er alt jeg vil ha"]);


        $this->json("get", "/api/tracks", ["q" => "sol"])
            ->assertStatus(200)
            ->assertJsonCount(3);
    }
}
