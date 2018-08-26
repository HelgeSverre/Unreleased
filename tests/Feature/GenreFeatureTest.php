<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Genre;
use App\Artist;
use App\Track;

class GenreFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_view_the_page_of_a_single_genre(){
      // Need an track (auto-makes a genre)
      $this->withoutExceptionHandling();
      $track = factory(Track::class)->create();

      // Go to the artist spesific URL
      $response = $this->get(route("genre.show", $track->genre_id))->assertStatus(200);

      // Assert it exists, assert can see the track
      $response->assertSee($track->genre->name);
    }

    public function test_the_artists_that_use_this_genre_is_displaying_on_the_genre_page(){
      $this->withoutExceptionHandling();
      $track = factory(Track::class)->create();
      $response = $this->get(route("genre.show", $track->genre_id))->assertStatus(200);

      $response->assertSee($track->artist->stage_name);

    }
}
