<?php

namespace Tests\Feature\Api;

use App\Reciter;
use App\User;
use Faker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use Tests\TestCase;

class RecitersApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testGetReciter()
    {
        /** @var Reciter $reciter */
        $reciter = factory(Reciter::class)->create();

        $this->get('/api/reciters/' . $reciter->id)->assertStatus(200)->assertJsonStructure([
            'data' => [
                'id', 'name', 'slug', 'description', 'avatar',
                'created_by', 'created_at', 'updated_at',
            ]
        ]);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testGetReciterBySlug()
    {
        /** @var Reciter $reciter */
        $reciter = factory(Reciter::class)->create();

        $this->get('/api/reciters/' . $reciter->slug)->assertStatus(200)->assertJsonStructure([
            'data' => [
                'id', 'name', 'slug', 'description', 'avatar',
                'created_by', 'created_at', 'updated_at',
            ]
        ]);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCreateReciter()
    {
        $user = factory(User::class)->create();
        Passport::actingAs($user);

        $faker = Faker\Factory::create();

        $this->postJson('/api/reciters/', $data = [
            'name' => $faker->name,
            'description' => $faker->paragraph,
            'avatar' => $faker->imageUrl(640, 480, 'people'),
        ])->assertStatus(200)->assertJsonStructure([
            'data' => [
                'id', 'name', 'slug', 'description', 'avatar',
                'created_by', 'created_at', 'updated_at',
            ]
        ]);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testUpdateReciter()
    {
        $user = factory(User::class)->create();
        Passport::actingAs($user);

        /** @var Reciter $reciter */
        $reciter = factory(Reciter::class)->create(['created_by' => $user->id]);
        $faker = Faker\Factory::create();

        $this->putJson('/api/reciters/' . $reciter->id, $data = [
            'name' => $faker->name,
            'description' => $faker->paragraph,
            'avatar' => $faker->imageUrl(640, 480, 'people'),
        ])->assertStatus(200)->assertJsonStructure([
            'data' => [
                'id', 'name', 'slug', 'description', 'avatar',
                'created_by', 'created_at', 'updated_at',
            ]
        ]);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testDeleteReciter()
    {
        $user = factory(User::class)->create();
        Passport::actingAs($user);

        /** @var Reciter $reciter */
        $reciter = factory(Reciter::class)->create(['created_by' => $user->id]);

        $this->delete('/api/reciters/' . $reciter->id)
            ->assertStatus(204);
    }
}
