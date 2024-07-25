<?php


use App\Models\Article;
use App\Models\ArticleTag;
use App\Models\User;
use Illuminate\Http\UploadedFile;

test('logged in user can access Article index', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->getJson(route('admin.article.index'));

    $response->assertOk();
    $response->assertJsonStructure([
        'data'
    ]);
});

test('user can search for Article', function () {
    $user = User::factory()->create();

    Article::factory()->count(10)->create();
    Article::factory()->count(1)->create([
        'title' => 'search term'
    ]);

    $response = $this
        ->actingAs($user)
        ->getJson(route('admin.article.index', [
            'search' => 'search term'
        ]));

    $response->assertOk();
    $response->assertJsonStructure([
        'data'
    ]);

    expect(count($response->json('data')))->toEqual(1);
});

test('user can filter Article', function () {
    $user = User::factory()->create();

    $articleTags = ArticleTag::factory()->count(2)->create();
    Article::factory()->count(10)->create();
    Article::factory()->count(1)->afterCreating(function (Article $article) use ($articleTags) {
        $article->articleTags()->attach($articleTags);
    })->create();

    $response = $this
        ->actingAs($user)
        ->getJson(route('admin.article.index', [
            'filter' => [
                'articleTags.id' => $articleTags->first()->id
            ]
        ]));

    $response->assertOk();
    $response->assertJsonStructure([
        'data'
    ]);

    expect(count($response->json('data')))->toEqual(1);
});

test('user can set per page for Article index', function () {
    $user = User::factory()->create();

    Article::factory()->count(10)->create();

    $response = $this
        ->actingAs($user)
        ->getJson(route('admin.article.index', [
            'per_page' => 5
        ]));

    $response->assertOk();
    $response->assertJsonStructure([
        'data'
    ]);

    expect(count($response->json('data')))->toEqual(5);
});

test('logged in user can access Article store', function () {
    $user = User::factory()->create();

    $data = Article::factory()->make()->toArray();
    $data['image'] = UploadedFile::fake()->image('image.jpg');
    $data['article_tags'] = ArticleTag::factory()->count(2)->create()->pluck('id')->toArray();

    $response = $this
        ->actingAs($user)
        ->postJson(route('admin.article.store'), $data);

    $response->assertCreated();
    $response->assertJsonStructure([
        'message'
    ]);

    $this->assertDatabaseHas('articles', [
        'title' => $data['title'],
    ]);

    $this->assertDatabaseHas('article_has_tag', [
        'article_tag_id' => $data['article_tags'][0],
    ]);
    $this->assertDatabaseHas('article_has_tag', [
        'article_tag_id' => $data['article_tags'][1],
    ]);
});

// validation test
test('user Article store validation', function () {
    $user = User::factory()->create();

    $data = Article::factory()->make()->toArray();

    $response = $this
        ->actingAs($user)
        ->postJson(route('admin.article.store'));

    $response->assertStatus(422);
    $response->assertJsonStructure([
        'message',
        'errors' => []
    ]);
});

test('logged in user can access Article update', function () {
    $user = User::factory()->create();

    $Article = Article::factory()->create();
    $data = Article::factory()->make()->toArray();
    $data['image'] = UploadedFile::fake()->image('image.jpg');
    $data['article_tags'] = ArticleTag::factory()->count(2)->create()->pluck('id')->toArray();

    $response = $this
        ->actingAs($user)
        ->putJson(route('admin.article.update', $Article->id), $data);

    $response->assertOk();
    $response->assertJsonStructure([
        'message'
    ]);

    $this->assertDatabaseHas('articles', [
        'title' => $data['title'],
    ]);

    $this->assertDatabaseHas('article_has_tag', [
        'article_tag_id' => $data['article_tags'][0],
    ]);
    $this->assertDatabaseHas('article_has_tag', [
        'article_tag_id' => $data['article_tags'][1],
    ]);
});

test('user Article update validation', function () {
    $user = User::factory()->create();

    $Article = Article::factory()->create();
    $data = Article::factory()->make()->toArray();

    $response = $this
        ->actingAs($user)
        ->putJson(route('admin.article.update', $Article->id), []);

    $response->assertStatus(422);
    $response->assertJsonStructure([
        'message',
        'errors' => []
    ]);
});

test('logged in user can access Article delete', function () {
    $user = User::factory()->create();

    $Article = Article::factory()->create();

    $response = $this
        ->actingAs($user)
        ->deleteJson(route('admin.article.destroy', $Article->id));

    $response->assertOk();
    $response->assertJsonStructure([
        'message'
    ]);

    $this->assertDatabaseMissing('articles', [
        'id' => $Article->id,
    ]);
});
