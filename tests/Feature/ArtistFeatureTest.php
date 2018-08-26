<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Artist;
use App\Genre;
use App\Track;
use App\User;

class ArtistFeatureTest extends TestCase
{
  use RefreshDatabase;
  /**
  * A basic test example.
  *
  * @return void
  */
  public function test_can_view_the_page_of_a_single_artist()
  {
    // Need an artist with a track
    $artist = factory(Artist::class)->create();
    $track = factory(Track::class)->create([
      'artist_id' => $artist->id
    ]);

    // Go to the artist spesific URL
    $response = $this->get(route("artist.show", $artist->id))->assertStatus(200);

    // Assert it exists, assert can see the track
    $response->assertSee($track->title);
  }

  public function test_can_create_a_new_artist()
  {
    $artist = factory(Artist::class)->make();
    $user = factory(User::class)->create();
    $this->withoutEvents();

    $this->withoutExceptionHandling()
    ->actingAs($user)
    ->post(route("artist.store"), [
      'stage_name' => $artist->stage_name,
      'real_name' => $artist->real_name,
      'bio' => $artist->bio
    ])
    ->assertStatus(302)
    ->assertRedirect('/artists')
    ->assertSessionHas('success', 'Your artist has been added successfully.');
    $this->assertDatabaseHas('artists', [
      'stage_name' => $artist->stage_name,
      'real_name' => $artist->real_name,
      'bio' => $artist->bio
    ]);
  }

  public function test_can_edit_an_artist() {
    $artist = factory(Artist::class)->create();
    $user = factory(User::class)->create();

    $this->withoutExceptionHandling()
    ->actingAs($user)
    ->post(route("artist.update", $artist->id), [
      'real_name' => 'Anne Stine',
      'bio' => "Yes, I do exist"
    ])
    ->assertStatus(302)
    ->assertRedirect('/artists/1')
    ->assertSessionHas('success', $artist->stage_name.' has been updated successfully.');
    $this->assertDatabaseHas('artists', [
      'stage_name' => $artist->stage_name,
      'real_name' => 'Anne Stine',
      'bio' => "Yes, I do exist"
    ])
    ->assertDatabaseMissing('artists', [
      'real_name' => $artist->real_name,
      'bio' => $artist->bio
    ]);

  }
}
