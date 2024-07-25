<?php

use App\Models\Article;
use App\Models\ArticleTag;

test('can get list of articles', function () {
    $response = $this
        ->getJson(route('client.article.index'));

    $response->assertStatus(200);
});

test('can get a article by slug', function () {
    $article = Article::factory()->create();

    $response = $this
        ->getJson(route('client.article.show', $article->slug));

    $response->assertStatus(200);
});

test('can search for articles', function () {
    Article::factory()->count(10)->create();
    Article::factory()->create([
        'title' => 'search term'
    ]);

    $response = $this
        ->getJson(route('client.article.index', [
            'search' => 'search term'
        ]));

    $response->assertStatus(200);
    expect(count($response->json('data')))->toEqual(1);
});

test("can filter articles", function () {
    $articleTags = ArticleTag::factory()->count(3)->create()->pluck('id')->toArray();
    Article::factory()->count(10)->create();
    Article::factory()->count(5)->afterCreating(function ($article) use ($articleTags) {
        $article->articleTags()->attach($articleTags);
    })->create();

    $response = $this
        ->getJson(route('client.article.index', [
            'filter' => [
                'articleTags.id' => $articleTags[0]
            ]
        ]));

    $response->assertStatus(200);
    expect(count($response->json('data')))->toEqual(5);
});
