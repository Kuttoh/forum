<?php

namespace Tests\Feature;

use App\Thread;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReadThreadsTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();

        $this->thread = create(Thread::class);
    }

    public function testThreadHasReplies()
    {

        $this->assertInstanceOf(Collection::class, $this->thread->replies);
    }

    public function testThreadHasOwner()
    {
        $this->assertInstanceOf(User::class, $this->thread->creator);
    }
}


