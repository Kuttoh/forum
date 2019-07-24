<?php

namespace Tests\Feature;

use App\Channel;
use App\Thread;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ChannelTest extends TestCase
{
    
    use DatabaseTransactions;

    public function testAChannelConsistsOfThreads()
    {
        $channel = create(Channel::class);

        $thread = create(Thread::class, ['channel_id' => $channel->id]);

        $this->assertTrue($channel->threads->contains($thread));
        
    }
}

