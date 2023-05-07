<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    const HTTP_BAD_REQUEST = 400;
    const HTTP_OK = 200;
    const HTTP_CREATED = 201;
    const HTTP_NO_CONTENT = 204;
    const HTTP_UNAUTHORIZED = 401;
    const HTTP_INTERNAL_ERROR = 500;
    const HTTP_UNPROCESSABLE_CONTENT = 422;

    public function setUp(): void
    {
        parent::setUp();
        $user = User::where('email','admin@code-challenge.com')->first();
        $this->actingAs($user)->assertAuthenticatedAs($user,'web');
    }
}
