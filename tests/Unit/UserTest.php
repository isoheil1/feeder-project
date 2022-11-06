<?php

namespace Tests\Unit;

use Str;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * User register test.
     *
     * @return void
     */
    public function test_register_user()
    {
        $response = $this->post(route('register'), [
            'email' => Str::random(10) . '@gmail.com',
            'password' => 'password',
            'name' => 'Admin 2'
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => ['name', 'email', 'token'],
            'success'
        ]);
    }

    /**
     * User register with wrong parameters.
     *
     * @return void
     */
    public function test_register_user_wrong_params()
    {
        $response = $this->post(route('register'), [
            'email' => Str::random(10) . '@gmail.com',
        ]);

        $response->assertStatus(422);
    }

    /**
     * User login test.
     *
     * @return void
     */
    public function test_login_user()
    {
        $response = $this->post(route('login'), [
            'email' => 'example@gmail.com',
            'password' => 'Password#123'
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => ['token'], 'success'
        ]);
        $response->assertJson([
            'success' => true
        ]);
    }

    /**
     * User login test with wrong credentials.
     *
     * @return void
     */
    public function test_login_user_wrong_cred()
    {
        $response = $this->post(route('login'), [
            'email' => 'example111@gmail.com',
            'password' => 'Password#123'
        ]);
        $response->assertStatus(401);
    }
}
