<?php

namespace Tests\Feature;

use App\Artist;
use App\Genre;
use App\Track;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TrackFeatureTest extends TestCase
{
    use RefreshDatabase;


    /** @test */
    public function can_list_tracks_on_the_homepage()
    {
      $track = factory(Track::class)->create();

      $response = $this->get(route("track.index"));
      $response->assertStatus(200);
      $response->assertSee($track->title);
      $response->assertSee($track->artist->name);
      $response->assertSee($track->genre->name);
    }


    /** @test */
    public function test_can_add_a_new_track_with_valid_data()
    {
        $user = factory(User::class)->create();

        $artist = factory(Artist::class)->create(["stage_name" => "Profite"]);
        $genre = factory(Genre::class)->create();


        $this->withoutExceptionHandling()
            ->actingAs($user)
            ->post(route("track.store"), [
                "artist_id" => $artist->id,
                "genre_id" => $genre->id,
                "title" => "Legends",
                "source_url" => "https://www.youtube.com/watch?v=gnXrcpUScTg",
                "source_description" => "Teaser video",
            ])
            ->assertStatus(302)
            ->assertRedirect('/')
            ->assertSessionHas('success', 'Your track has been added successfully.');

        $this->assertCount(1, Track::all());

    }

    public function test_track_must_have_a_title()
    {
      $user = factory(User::class)->create();
      $track = factory(Track::class)->make();
      $this->actingAs($user)
          ->post(route("track.store"), [
          "artist_id" => $track->artist->id,
          "genre_id" => $track->genre->id,
          "source_url" => $track->source_url,
          "source_description" => $track->source_description
      ])->assertSessionHasErrors('title');
    }

    public function test_track_must_have_an_artist()
    {
      $user = factory(User::class)->create();
      $track = factory(Track::class)->make();
      $this->actingAs($user)
          ->post(route("track.store"), [
          "genre_id" => $track->genre->id,
          "title" => $track->title,
          "source_url" => $track->source_url,
          "source_description" => $track->source_description
      ])->assertSessionHasErrors('artist_id');
    }

    public function test_track_must_have_a_genre()
    {
      $user = factory(User::class)->create();
      $track = factory(Track::class)->make();
      $this->actingAs($user)
          ->post(route("track.store"), [
          "artist_id" => $track->artist->id,
          "title" => $track->title,
          "source_url" => $track->source_url,
          "source_description" => $track->source_description
      ])->assertSessionHasErrors('genre_id');
    }

    public function test_track_must_have_a_source_url()
    {
      $user = factory(User::class)->create();
      $track = factory(Track::class)->make();
      $this->actingAs($user)
          ->post(route("track.store"), [
          "artist_id" => $track->artist->id,
          "genre_id" => $track->genre->id,
          "title" => $track->title,
          "source_description" => $track->source_description
      ])->assertSessionHasErrors('source_url');
    }

    public function test_track_must_have_a_source_url_that_is_actually_a_url()
    {
      $user = factory(User::class)->create();
      $track = factory(Track::class)->make();
      $this->actingAs($user)
          ->post(route("track.store"), [
          "artist_id" => $track->artist->id,
          "genre_id" => $track->genre->id,
          "title" => $track->title,
          "source_url" => "NOT_A_URL",
          "source_description" => $track->source_description
      ])->assertSessionHasErrors('source_url');
    }

    public function test_track_must_have_a_source_description()
    {
      $user = factory(User::class)->create();
      $track = factory(Track::class)->make();
      $this->actingAs($user)
          ->post(route("track.store"), [
          "artist_id" => $track->artist->id,
          "genre_id" => $track->genre->id,
          "title" => $track->title,
          "source_url" => $track->source_url,
      ])->assertSessionHasErrors('source_description');
    }

    public function test_can_edit_a_track()
    {
      $user = factory(User::class)->create();
      $track = factory(Track::class)->create();
      $track2 = factory(Track::class)->make();
      $this->assertDatabaseHas('tracks', [
        "artist_id" => $track->artist_id,
        "genre_id" => $track->genre_id,
        "title" => $track->title,
        "source_url" => $track->source_url,
        "source_description" => $track->source_description,
      ]);


      $this->withoutExceptionHandling()
          ->actingAs($user)
          ->post(route("track.update", $track->id), [
              "artist_id" => $track2->artist_id,
              "genre_id" => $track2->genre_id,
              "title" => $track2->title,
              "source_url" => $track2->source_url,
              "source_description" => $track2->source_description,
          ])
          ->assertStatus(302)
          ->assertRedirect('/')
          ->assertSessionHas('success', 'The track has been updated successfully.');

      $this->assertCount(1, Track::all());
      $this->assertDatabaseHas('tracks', [
        "artist_id" => $track2->artist_id,
        "genre_id" => $track2->genre_id,
        "title" => $track2->title,
        "source_url" => $track2->source_url,
        "source_description" => $track2->source_description,
      ]);
      $this->assertDatabaseMissing('tracks', [
        "artist_id" => $track->artist_id,
        "genre_id" => $track->genre_id,
        "title" => $track->title,
        "source_url" => $track->source_url,
        "source_description" => $track->source_description,
      ]);

    }
}
