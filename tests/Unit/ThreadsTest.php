<?php

namespace Tests\Unit;

use App\Reply;
use App\Thread;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ThreadsTest extends TestCase
{
    use DatabaseMigrations;

//    protected $thread;

    protected $thread;

    public function setUp(): void
    {
        parent::setUp();

        $this->thread = factory(Thread::class)->create();
    }

    public function testAUserCanViewAllThreads()
    {
        $response = $this->get('/threads');

        $response->assertSee($this->thread->title);
    }

    public function testAUserCanViewASingleThread()
    {
        $response = $this->get($this->thread->path());

        $response->assertSee($this->thread->title);
    }

    public function testAUserCanReadRepliesAssociatedToAThread()
    {
        $reply = factory(Reply::class)->create(['thread_id' => $this->thread->id]);

        $response = $this->get($this->thread->path());

        $response->assertSee($reply->body);
    }

    public function testAThreadCanAddAReply()
    {
        $this->thread->addReply([
            'body' => 'FooBar',
            'user_id' => 1
        ]);

        $this->assertCount(1, $this->thread->replies);

        return back();
    }
}
