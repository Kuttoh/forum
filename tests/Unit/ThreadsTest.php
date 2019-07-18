<?php

namespace Tests\Unit;

use App\Thread;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ThreadsTest extends TestCase
{
    use DatabaseMigrations;

    public function testAUserCanViewAllThreads()
    {
        $thread = factory(Thread::class)->create();

        $response = $this->get('/threads');

        $response->assertSee($thread->title);
    }

    public function testAUserCanViewASingleThread()
    {
        $thread = factory(Thread::class)->create();

        $response = $this->get('/threads/' .$thread->id);

        $response->assertSee($thread->title);
    }
}
