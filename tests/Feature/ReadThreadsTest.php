<?php

namespace Tests\Feature;

use App\Channel;
use App\Thread;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ReadThreadsTest extends TestCase
{
    use DatabaseTransactions;

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

    public function testAUserCanFilterThreadsByAnyUsername()
    {
        $this->signIn(create(User::class, ['name' => 'Isaac']));

        $threadByIsaac = create(Thread::class, ['user_id' => auth()->id()]);

        $threadNotByIsaac = create(Thread::class);

        $this->get('threads?by=Isaac')
            ->assertSee($threadByIsaac->title)
            ->assertDontSee($threadNotByIsaac->title);

    }
}


