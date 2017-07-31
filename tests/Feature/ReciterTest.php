<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReciterTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testRecitersIndex()
    {
        $response = $this->json('GET', '/reciters');
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'slug',
                    'description',
                    'hits',
                    'image_path',
                    'status',
                    'moderated_at',
                    'moderated_by',
                    'created_by',
                    'created_at',
                    'updated_at'
                ]
            ]);
    }
}
