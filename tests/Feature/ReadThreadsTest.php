<?php

namespace Tests\Feature;

use App\Channel;
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

        $this->withoutExceptionHandling();
    }

    public function testThreadHasReplies()
    {

        $this->assertInstanceOf(Collection::class, $this->thread->replies);
    }

    public function testThreadHasOwner()
    {
        $this->assertInstanceOf(User::class, $this->thread->creator);
    }

    public function testAUserCanFilterThreadsAccordingToAChannel()
    {
        $channel = create(Channel::class);

        $threadInChannel = create(Thread::class, ['channel_id' => $channel->id]);

        $threadNotInChannel = create(Thread::class);

        $this->get('threads/' . $channel->slug)
            ->assertSee($threadInChannel->title)
            ->assertDontSee($threadNotInChannel->title);
    }
}


