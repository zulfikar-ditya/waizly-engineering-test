<?php


use App\Models\ArticleTag;
use App\Models\User;

test('logged in user can access ArticleTag index', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->getJson(route('admin.article-tag.index'));

    $response->assertOk();
    $response->assertJsonStructure([
        'data'
    ]);
});

test('user can search for ArticleTag', function () {
    $user = User::factory()->create();

    ArticleTag::factory()->count(10)->create();
    ArticleTag::factory()->count(1)->create([
        'name' => 'search term'
    ]);

    $response = $this
        ->actingAs($user)
        ->getJson(route('admin.article-tag.index', [
            'search' => 'search term'
        ]));

    $response->assertOk();
    $response->assertJsonStructure([
        'data'
    ]);

    expect(count($response->json('data')))->toEqual(1);
});

test('user can set per page for ArticleTag index', function () {
    $user = User::factory()->create();

    ArticleTag::factory()->count(10)->create();

    $response = $this
        ->actingAs($user)
        ->getJson(route('admin.article-tag.index', [
            'per_page' => 5
        ]));

    $response->assertOk();
    $response->assertJsonStructure([
        'data'
    ]);

    expect(count($response->json('data')))->toEqual(5);
});

test('logged in user can access ArticleTag store', function () {
    $user = User::factory()->create();

    $data = ArticleTag::factory()->make()->toArray();

    $response = $this
        ->actingAs($user)
        ->postJson(route('admin.article-tag.store'), $data);

    $response->assertCreated();
    $response->assertJsonStructure([
        'message'
    ]);

    $this->assertDatabaseHas('article_tags', [
        'name' => $data['name'],
    ]);
});

// validation test
test('user ArticleTag store validation', function () {
    $user = User::factory()->create();

    $data = ArticleTag::factory()->make()->toArray();

    $response = $this
        ->actingAs($user)
        ->postJson(route('admin.article-tag.store'));

    $response->assertStatus(422);
    $response->assertJsonStructure([
        'message',
        'errors' => []
    ]);
});

test('logged in user can access ArticleTag update', function () {
    $user = User::factory()->create();

    $ArticleTag = ArticleTag::factory()->create();
    $data = ArticleTag::factory()->make()->toArray();

    $response = $this
        ->actingAs($user)
        ->putJson(route('admin.article-tag.update', $ArticleTag->id), $data);

    $response->assertOk();
    $response->assertJsonStructure([
        'message'
    ]);

    $this->assertDatabaseHas('article_tags', [
        'name' => $data['name'],
    ]);
});

test('user ArticleTag update validation', function () {
    $user = User::factory()->create();

    $ArticleTag = ArticleTag::factory()->create();
    $data = ArticleTag::factory()->make()->toArray();

    $response = $this
        ->actingAs($user)
        ->putJson(route('admin.article-tag.update', $ArticleTag->id), []);

    $response->assertStatus(422);
    $response->assertJsonStructure([
        'message',
        'errors' => []
    ]);
});

test('logged in user can access ArticleTag delete', function () {
    $user = User::factory()->create();

    $ArticleTag = ArticleTag::factory()->create();

    $response = $this
        ->actingAs($user)
        ->deleteJson(route('admin.article-tag.destroy', $ArticleTag->id));

    $response->assertOk();
    $response->assertJsonStructure([
        'message'
    ]);

    $this->assertDatabaseMissing('article_tags', [
        'id' => $ArticleTag->id,
    ]);
});
