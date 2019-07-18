<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ThreadsTest extends TestCase
{
    use DatabaseMigrations;

    public function testAUserCanBrowseThreads()
    {
        $response = $this->get('/threads');

        $response->assertStatus(200);
    }
}
