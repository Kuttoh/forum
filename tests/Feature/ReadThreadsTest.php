<?php

namespace Tests\Feature;

use App\Channel;
use App\Reply;
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
        $this->signIn(create(User::class, ['name' => 'Summer']));

        $threadByIsaac = create(Thread::class, ['user_id' => auth()->id()]);

        $threadNotByIsaac = create(Thread::class);

        $this->get('threads?by=Summer')
            ->assertSee($threadByIsaac->title)
            ->assertDontSee($threadNotByIsaac->title);

    }

    public function testAUSerCanFilterThreadsByPopularity()
    {
        $threadWithTwoReplies = create(Thread::class);
        create(Reply::class, ['thread_id' => $threadWithTwoReplies->id ], 2);

        $threadWithThreeReplies = create(Thread::class);
        create(Reply::class, ['thread_id' => $threadWithThreeReplies->id], 3);

        $threadWithNoReplies = $this->thread;

        $response = $this->getJson('threads?popular=1')->json();

        $this->assertEquals([3,2,0], array_column($response, 'replies_count'));
    }
}


