<?php

namespace Tests\Feature\Api;

use App\Album;
use App\Reciter;
use App\User;
use Faker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use Tests\TestCase;

class AlbumsApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testGetAlbumByYear()
    {
        /** @var Album $album */
        $user = factory(User::class)->create();
        $reciter = factory(Reciter::class)->create(['created_by' => $user->id]);
        $album = factory(Album::class)->create(['created_by' => $user->id, 'reciter_id' => $reciter->id]);
        $this->get('/api/reciters/' . $album->reciter_id . '/albums/' . $album->year)->assertStatus(200)->assertJsonStructure([
            'data' => [
                'id', 'reciter_id', 'name', 'year', 'artwork', 'created_at', 'updated_at',
            ]
        ]);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCreateAlbum()
    {
        $user = factory(User::class)->create();
        Passport::actingAs($user);

        $faker = Faker\Factory::create();
        $reciter = factory(Reciter::class)->create(['created_by' => $user->id]);

        $this->postJson('/api/reciters/' . $reciter->id . '/albums', $data = [
            'name' => $faker->name,
            'reciter_id' => $reciter->id,
            'year' => $faker->year(),
            'artwork' => $faker->imageUrl(640, 480, 'people'),
        ])->assertStatus(200)->assertJsonStructure([
            'data' => [
                'id', 'reciter_id', 'name', 'year', 'artwork',
                'created_at', 'updated_at',
            ]
        ]);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testUpdateAlbum()
    {
        $user = factory(User::class)->create();
        Passport::actingAs($user);

        /** @var Reciter $reciter */
        $reciter = factory(Reciter::class)->create(['created_by' => $user->id]);
        $album = factory(Album::class)->create(['created_by' => $user->id, 'reciter_id' => $reciter->id]);
        $faker = Faker\Factory::create();

        $this->putJson('/api/reciters/' . $album->reciter_id . '/albums/' . $album->year, $data = [
            'name' => $faker->name,
            'year' => $faker->year(),
            'artwork' => $faker->imageUrl(640, 480, 'people'),
        ])->assertStatus(200)->assertJsonStructure([
            'data' => [
                'id', 'reciter_id', 'name', 'year', 'artwork',
                'created_at', 'updated_at',
            ]
        ]);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testDeleteAlbum()
    {
        $user = factory(User::class)->create();
        Passport::actingAs($user);

        /** @var Reciter $reciter */
        $reciter = factory(Reciter::class)->create(['created_by' => $user->id]);
        $album = factory(Album::class)->create(['created_by' => $user->id, 'reciter_id' => $reciter->id]);

        $this->delete('/api/reciters/' . $album->reciter_id . '/albums/' . $album->year)
            ->assertStatus(204);
    }
}
