<?php

namespace Tests;

use App\Exceptions\Handler;
use App\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function signIn($user = null)
    {
        $user = $user ?: create(User::class);

        $this->actingAs($user);

        return $this;
    }

    protected function disableExceptionHandling()
    {
        app()->instance(Handler::class, new class extends Handler {
            public function __construct()
            {
            }
            public function report(\Exception $e)
            {
// no-op
            }
            public function render($request, \Exception $e)
            {
                throw $e;
            }
        });
    }
}
