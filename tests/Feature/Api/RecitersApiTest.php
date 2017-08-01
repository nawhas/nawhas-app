<?php

namespace Tests\Feature\Api;

use App\Reciter;
use Faker;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
            'id', 'name', 'slug', 'description', 'hits',
            'image_path', 'status', 'moderated_at', 'moderated_by',
            'created_by', 'created_at', 'updated_at',
        ])->assertJson($reciter->toArray());
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
            'id', 'name', 'slug', 'description', 'hits',
            'image_path', 'status', 'moderated_at', 'moderated_by',
            'created_by', 'created_at', 'updated_at',
        ])->assertJson($reciter->toArray());
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCreateReciter()
    {
        $faker = Faker\Factory::create();

        $this->postJson('/api/reciters/', $data = [
            'name' => $faker->name,
            'description' => $faker->paragraph,
            'image_path' => $faker->imageUrl(640, 480, 'people'),
        ])->assertStatus(200)->assertJsonStructure([
            'id', 'name', 'slug', 'description', 'hits',
            'image_path', 'status', 'moderated_at', 'moderated_by',
            'created_by', 'created_at', 'updated_at',
        ])->assertJsonFragment([
            'name' => $data['name'],
            'description' => $data['description'],
            'image_path' => $data['image_path'],
        ]);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testUpdateReciter()
    {
        /** @var Reciter $reciter */
        $reciter = factory(Reciter::class)->create();
        $faker = Faker\Factory::create();

        $this->putJson('/api/reciters/' . $reciter->id, $data = [
            'name' => $faker->name,
            'description' => $faker->paragraph,
            'image_path' => $faker->imageUrl(640, 480, 'people'),
        ])->assertStatus(200)->assertJsonStructure([
            'id', 'name', 'slug', 'description', 'hits',
            'image_path', 'status', 'moderated_at', 'moderated_by',
            'created_by', 'created_at', 'updated_at',
        ])->assertJsonFragment([
            'id' => $reciter->id,
            'name' => $data['name'],
            'description' => $data['description'],
            'image_path' => $data['image_path'],
        ]);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testDeleteReciter()
    {
        /** @var Reciter $reciter */
        $reciter = factory(Reciter::class)->create();
        $faker = Faker\Factory::create();

        $this->delete('/api/reciters/' . $reciter->id)
            ->assertStatus(204);
    }
}
