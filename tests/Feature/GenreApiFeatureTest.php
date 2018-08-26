<?php

namespace Tests\Feature;

use App\Genre;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GenreApiFeatureTest extends TestCase
{
    use RefreshDatabase;


    /** @test */
    public function can_fetch_genre_from_api()
    {
        factory(Genre::class)->times(10)->create();


        $this->json("get", "/api/genres")
            ->assertStatus(200)
            ->assertJsonCount(10);
    }


    /** @test */
    public function can_filter_out_genre_by_name()
    {
        factory(Genre::class)->create(["name" => "Hardcore"]);
        factory(Genre::class)->create(["name" => "Gore"]);
        factory(Genre::class)->create(["name" => "K-pop"]);
        factory(Genre::class)->create(["name" => "Speed Metal"]);
        factory(Genre::class)->create(["name" => "Speed Gore"]);
        factory(Genre::class)->create(["name" => "Speed Party"]);


        $this->json("get", "/api/genres", ["q" => "speed"])
            ->assertStatus(200)
            ->assertJsonCount(3);
    }


    /** @test */
    public function can_create_genres_with_name_from_api()
    {

        $this->json("post", "/api/genres", [
            "name" => "Hardcore"
        ])
            ->assertStatus(201)
            ->assertJsonStructure([
                "id",
                "name",
            ]);
        $this->assertDatabaseHas('genres', [
          'name' => 'Hardcore'
        ]);
    }

    /** @test */
    public function name_must_be_unique() // At least for now
    {
        factory(Genre::class)->create(["name" => "Hardcore"]);

        $this->json("post", "/api/genres", [
            "name" => "Hardcore"
        ])
            ->assertStatus(422)
            ->assertJsonValidationErrors("name");
    }
}
