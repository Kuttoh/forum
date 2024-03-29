<?php

namespace Tests\Feature;

use App\Reply;
use App\Thread;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;


class ParticipateInForumTest extends TestCase
{
    use DatabaseTransactions;

    public function setUp(): void
    {
        parent::setUp();

        $this->withoutExceptionHandling();
    }

    public function testUnauthorisedUsersMayNotAddReplies()
    {
        $this->withExceptionHandling()
            ->post('/threads/channel/1/replies', [])
            ->assertRedirect('/login');
    }

    public function testAnAuthenticatedUserCanParticipateInForumThreads()
    {
        $this->signIn();

        $thread = create(Thread::class);

        $reply = make(Reply::class);

        $this->post($thread->path() . '/replies', $reply->toArray());

        $response = $this->get($thread->path());

        $response->assertSee($reply->body);
    }

    public function testAReplyRequiresBody()
    {
        $this->signIn()->withExceptionHandling();

        $thread = create(Thread::class);

        $reply = make(Reply::class, ['body' => null]);

        $this->post($thread->path() . '/replies', $reply->toArray())
            ->assertSessionHasErrors('body');


    }
}
