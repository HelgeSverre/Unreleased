<?php

namespace Tests\Feature;

use App\Artist;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ArtistApiFeatureTest extends TestCase
{
    use RefreshDatabase;


    /** @test */
    public function can_fetch_artists_from_api()
    {
        factory(Artist::class)->times(10)->create();


        $this->json("get", "/api/artists")
            ->assertStatus(200)
            ->assertJsonCount(10);
    }


    /** @test */
    public function can_filter_out_artists_by_stage_name()
    {
        factory(Artist::class)->create(["stage_name" => "Adaro"]);
        factory(Artist::class)->create(["stage_name" => "E-Force"]);
        factory(Artist::class)->create(["stage_name" => "E-Frontliner"]);
        factory(Artist::class)->create(["stage_name" => "Headhunterz"]);
        factory(Artist::class)->create(["stage_name" => "Headhaters"]);
        factory(Artist::class)->create(["stage_name" => "Headbangerz"]);


        $this->json("get", "/api/artists", ["q" => "head"])
            ->assertStatus(200)
            ->assertJsonCount(3);
    }


    /** @test */
    public function can_create_artist_with_stage_name_from_api()
    {
      $this->withoutEvents();

        $this->json("post", "/api/artists", [
            "stage_name" => "Headhunterz"
        ])
            ->assertStatus(201)
            ->assertJsonStructure([
                "id",
                "stage_name",
            ]);
        $this->assertDatabaseHas('artists', [
          'stage_name' => 'Headhunterz'
        ]);
    }

    /** @test */
    public function stage_name_must_be_unique() // At least for now
    {
      $this->withoutEvents();

        factory(Artist::class)->create(["stage_name" => "Headhunterz"]);

        $this->json("post", "/api/artists", [
            "stage_name" => "Headhunterz"
        ])
            ->assertStatus(422)
            ->assertJsonValidationErrors("stage_name");
    }
}
