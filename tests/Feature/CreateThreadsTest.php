<?php

namespace Tests\Feature;

use App\Thread;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateThreadsTest extends TestCase
{

    use DatabaseMigrations;

    public function testGuestsMayNotCreateThreads()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');

        $thread = make(Thread::class);

        $this->post('/threads', $thread->toArray());
    }

    public function testAnAuthenticatedUserCanCreateNewForumThreads()
    {
        $this->signIn();

        $thread = make(Thread::class);

        $this->post('/threads', $thread->toArray());

        $this->get($thread->path())
            ->assertSee($thread->title)
            ->assertSee($thread->boby);
    }
}
