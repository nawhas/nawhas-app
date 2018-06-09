<?php

namespace Tests\Feature\Api;

use App\Lyric;
use App\Track;
use App\Album;
use App\Reciter;
use App\User;
use Faker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use Tests\TestCase;

class LyricsApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testGetLyricById()
    {
        /** @var User $user */
        /** @var Reciter $reciter */
        /** @var Album $album */
        /** @var Track $track */
        /** @var Lyric $lyric $user */
        $user = factory(User::class)->create();
        $reciter = factory(Reciter::class)->create(['created_by' => $user->id]);
        $album = factory(Album::class)->create(['created_by' => $user->id, 'reciter_id' => $reciter->id]);
        $track = factory(Track::class)->create(['created_by' => $user->id, 'reciter_id' => $reciter->id, 'album_id' => $album->id]);
        $lyric = factory(Lyric::class)->create(['created_by' => $user->id, 'track_id' => $track->id]);
        $this->get('/v1/reciters/' . $reciter->id . '/albums/' . $album->year . '/tracks/' . $track->id . '/lyrics/' . $lyric->id)->assertStatus(200)->assertJsonStructure([
            'data' => [
                'id', 'text', 'track_id',
                'created_by', 'created_at', 'updated_at',
            ]
        ]);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCreateLyric()
    {
        $user = factory(User::class)->create();
        Passport::actingAs($user);

        $faker = Faker\Factory::create();
        $reciter = factory(Reciter::class)->create(['created_by' => $user->id]);
        $album = factory(Album::class)->create(['created_by' => $user->id, 'reciter_id' => $reciter->id]);
        $track = factory(Track::class)->create(['created_by' => $user->id, 'reciter_id' => $reciter->id, 'album_id' => $album->id]);
        $this->postJson('/v1/reciters/' . $reciter->id . '/albums/' . $album->year . '/tracks/' . $track->number . '/lyrics', $data = [
            'text' => $faker->text(),
            'track_id' => $track->id,
            'created_by' => $user->id,
        ])->assertStatus(200)->assertJsonStructure([
            'data' => [
                'id', 'text', 'track_id',
                'created_by', 'created_at', 'updated_at',
            ]
        ]);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testUpdateLyric()
    {
        $user = factory(User::class)->create();
        Passport::actingAs($user);

        /** @var Reciter $reciter */
        $reciter = factory(Reciter::class)->create(['created_by' => $user->id]);
        $album = factory(Album::class)->create(['created_by' => $user->id, 'reciter_id' => $reciter->id]);
        $track = factory(Track::class)->create(['created_by' => $user->id, 'reciter_id' => $reciter->id, 'album_id' => $album->id]);
        $lyric = factory(Lyric::class)->create(['created_by' => $user->id, 'track_id' => $track->id]);
        $faker = Faker\Factory::create();

        $this->putJson('/v1/reciters/' . $album->reciter_id . '/albums/' . $album->year . '/tracks/' . $track->number . '/lyrics/' . $lyric->id, $data = [
            'text' => $faker->text(),
        ])->assertStatus(200)->assertJsonStructure([
            'data' => [
                'id', 'text', 'track_id',
                'created_by', 'created_at', 'updated_at',
            ]
        ]);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testDeleteLyric()
    {
        $user = factory(User::class)->create();
        Passport::actingAs($user);

        /** @var Reciter $reciter */
        $reciter = factory(Reciter::class)->create(['created_by' => $user->id]);
        $album = factory(Album::class)->create(['created_by' => $user->id, 'reciter_id' => $reciter->id]);
        $track = factory(Track::class)->create(['created_by' => $user->id, 'reciter_id' => $reciter->id, 'album_id' => $album->id]);
        $lyric = factory(Lyric::class)->create(['created_by' => $user->id, 'track_id' => $track->id]);

        $this->delete('/v1/reciters/' . $album->reciter_id . '/albums/' . $album->year . '/tracks/' . $track->number . '/lyrics/' . $lyric->id)
            ->assertStatus(204);
    }
}
