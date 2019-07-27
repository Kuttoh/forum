<?php

namespace Tests\Feature;

use App\Favorite;
use App\Reply;
use Tests\TestCase;

use Illuminate\Foundation\Testing\DatabaseTransactions;

class FavoritesTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutExceptionHandling();
    }

    use DatabaseTransactions;

    public function testGuestsCannotFavoriteAnything()
    {
        $this->withExceptionHandling()
            ->post('replies/1/favorites')
            ->assertRedirect('/login');
    }

    public function testAnAuthenticatedUserCanFavoriteAnyReply()
    {
        $this->signIn();

        $reply = create(Reply::class);

        $this->post('replies/' . $reply->id . '/favorites');

        $this->assertCount(1, $reply->favorites);
    }

    public function testAnAuthenticatedUserMayOnlyFavoriteAReplyOnce()
    {
        $this->signIn();

        $reply = create(Reply::class);

        $this->post('replies/' . $reply->id . '/favorites');
        $this->post('replies/' . $reply->id . '/favorites');

        $this->assertCount(1, $reply->favorites);
    }
}
