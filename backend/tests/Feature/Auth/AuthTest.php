<?php

use App\Models\User;

test('test user can login', function () {

    $user = User::factory()->create();

    $response = $this
        ->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password',
            'remember_mode' => true,
        ]);

    $this->assertAuthenticated();
    $response->assertStatus(200);
});

test('test user cannot login with wrong password', function () {

    $user = User::factory()->create();

    $response = $this
        ->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
            'remember_mode' => true,
        ]);

    $response->assertStatus(401);
});

test('test user cannot login with wrong email', function () {
    $response = $this
        ->postJson('/api/login', [
            'email' => 'wrong-email',
            'password' => 'password',
        ]);

    $response->assertJsonStructure([
        'message',
        'errors' => [
            'email',
        ],
    ]);
    $response->assertStatus(422);
});
