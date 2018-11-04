<?php

namespace Tests\Feature\Api;

use App\Track;
use App\Album;
use App\Reciter;
use App\User;
use Faker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use Tests\TestCase;

class TracksApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testGetTrackById()
    {
        /** @var User $user */
        /** @var Reciter $reciter */
        /** @var Album $album */
        /** @var Track $track */
        $user = factory(User::class)->create();
        $reciter = factory(Reciter::class)->create(['created_by' => $user->id]);
        $album = factory(Album::class)->create(['created_by' => $user->id, 'reciter_id' => $reciter->id]);
        $track = factory(Track::class)->create(['created_by' => $user->id, 'reciter_id' => $reciter->id, 'album_id' => $album->id]);
        $this->get('/api/reciters/' . $album->reciter_id . '/albums/' . $album->year . '/tracks/' . $track->id)->assertStatus(200)->assertJsonStructure([
            'data' => [
                'id', 'slug', 'reciter_id', 'album_id', 'name', 'audio', 'video', 'number', 'created_by', 'created_at', 'updated_at',
            ]
        ]);
    }

    public function testGetTrackBySlug()
    {
        /** @var User $user */
        /** @var Reciter $reciter */
        /** @var Album $album */
        /** @var Track $track */
        $user = factory(User::class)->create();
        $reciter = factory(Reciter::class)->create(['created_by' => $user->id]);
        $album = factory(Album::class)->create(['created_by' => $user->id, 'reciter_id' => $reciter->id]);
        $track = factory(Track::class)->create(['created_by' => $user->id, 'reciter_id' => $reciter->id, 'album_id' => $album->id]);
        $this->get('/api/reciters/' . $album->reciter_id . '/albums/' . $album->year . '/tracks/' . $track->slug)->assertStatus(200)->assertJsonStructure([
            'data' => [
                'id', 'slug', 'reciter_id', 'album_id', 'name', 'audio', 'video', 'number', 'created_by', 'created_at', 'updated_at',
            ]
        ]);
    }

    public function testGetTrackByNumber()
    {
        /** @var User $user */
        /** @var Reciter $reciter */
        /** @var Album $album */
        /** @var Track $track */
        $user = factory(User::class)->create();
        $reciter = factory(Reciter::class)->create(['created_by' => $user->id]);
        $album = factory(Album::class)->create(['created_by' => $user->id, 'reciter_id' => $reciter->id]);
        $track = factory(Track::class)->create(['created_by' => $user->id, 'reciter_id' => $reciter->id, 'album_id' => $album->id]);
        $this->get('/api/reciters/' . $album->reciter_id . '/albums/' . $album->year . '/tracks/' . $track->number)->assertStatus(200)->assertJsonStructure([
            'data' => [
                'id', 'slug', 'reciter_id', 'album_id', 'name', 'audio', 'video', 'number', 'created_by', 'created_at', 'updated_at',
            ]
        ]);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCreateTrack()
    {
        $user = factory(User::class)->create();
        Passport::actingAs($user);

        $faker = Faker\Factory::create();
        $reciter = factory(Reciter::class)->create(['created_by' => $user->id]);
        $album = factory(Album::class)->create(['created_by' => $user->id, 'reciter_id' => $reciter->id]);
        $this->postJson('/api/reciters/' . $reciter->id . '/albums/' . $album->year . '/tracks', $data = [
            'name' => $name = $faker->name,
            'slug' => str_slug($name),
            'reciter_id' => $reciter->id,
            'album_id' => $album->id,
            'number' => $faker->randomDigit,
            'audio' => $faker->imageUrl(640, 480, 'people'),
            'video' => $faker->imageUrl(640, 480, 'people'),
            'created_by' => $user->id,
        ])->assertStatus(200)->assertJsonStructure([
            'data' => [
                'id', 'slug', 'reciter_id', 'album_id',
                'name', 'audio', 'video', 'number',
                'created_by', 'created_at', 'updated_at',
            ]
        ]);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testUpdateTrack()
    {
        $user = factory(User::class)->create();
        Passport::actingAs($user);

        /** @var Reciter $reciter */
        $reciter = factory(Reciter::class)->create(['created_by' => $user->id]);
        $album = factory(Album::class)->create(['created_by' => $user->id, 'reciter_id' => $reciter->id]);
        $track = factory(Track::class)->create(['created_by' => $user->id, 'reciter_id' => $reciter->id, 'album_id' => $album->id]);
        $faker = Faker\Factory::create();

        $this->putJson('/api/reciters/' . $album->reciter_id . '/albums/' . $album->year . '/tracks/' . $track->number, $data = [
            'name' => $name = $faker->name,
            'slug' => str_slug($name),
            'number' => $faker->randomDigit,
            'audio' => $faker->imageUrl(640, 480, 'people'),
            'video' => $faker->imageUrl(640, 480, 'people'),
        ])->assertStatus(200)->assertJsonStructure([
            'data' => [
                'id', 'slug', 'reciter_id', 'album_id',
                'name', 'audio', 'video', 'number',
                'created_by', 'created_at', 'updated_at',
            ]
        ]);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testDeleteTrack()
    {
        $user = factory(User::class)->create();
        Passport::actingAs($user);

        /** @var Reciter $reciter */
        $reciter = factory(Reciter::class)->create(['created_by' => $user->id]);
        $album = factory(Album::class)->create(['created_by' => $user->id, 'reciter_id' => $reciter->id]);
        $track = factory(Track::class)->create(['created_by' => $user->id, 'reciter_id' => $reciter->id, 'album_id' => $album->id]);

        $this->delete('/api/reciters/' . $album->reciter_id . '/albums/' . $album->year . '/tracks/' . $track->number)
            ->assertStatus(204);
    }
}
