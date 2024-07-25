<?php

use App\Models\Article;
use App\Models\ArticleTag;
use App\Repositories\ArticleRepository;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

it('can get datatable', function () {
    $repository = new ArticleRepository();
    $request = new Request();

    $result = $repository->datatable($request);

    expect($result)->toBeInstanceOf(LengthAwarePaginator::class);
});

it('can get datatable with search', function () {

    Article::factory()->count(10)->create();
    Article::factory()->create([
        'title' => 'search term',
    ]);

    $repository = new ArticleRepository();
    $request = new Request([
        'search' => 'search term',
    ]);

    $result = $repository->datatable($request);

    expect($result)->toBeInstanceOf(LengthAwarePaginator::class);
    expect($result->count())->toEqual(1);
});

it('can get datatable with filter', function () {

    $articleTags = ArticleTag::factory()->count(1)->create();

    Article::factory()->count(10)->create();
    Article::factory()->count(5)->afterCreating(function ($article) use ($articleTags) {
        $article->articleTags()->attach($articleTags);
    })->create();

    $repository = new ArticleRepository();
    $request = new Request([
        'filter' => [
            'articleTags.id' => $articleTags->first()->id,
        ],
    ]);

    $result = $repository->datatable($request);

    expect($result)->toBeInstanceOf(LengthAwarePaginator::class);
    expect($result->count())->toEqual(5);
});

it('can get datatable with per page parameter', function () {

    Article::factory()->count(10)->create();

    $repository = new ArticleRepository();
    $request = new Request([
        'per_page' => 5
    ]);

    $result = $repository->datatable($request);

    expect($result)->toBeInstanceOf(LengthAwarePaginator::class);
    expect($result->count())->toEqual(5);
});

it('can get datatable with sort', function () {

    Article::factory()->count(10)->create();

    $repository = new ArticleRepository();
    $request = new Request([
        'order' => '-title'
    ]);

    $result = $repository->datatable($request);

    expect($result)->toBeInstanceOf(LengthAwarePaginator::class);
    expect($result->count())->toEqual(10);
});

it('can create a Article', function () {
    $repository = new ArticleRepository();
    $data = Article::factory()->make()->toArray();

    $result = $repository->create($data);

    expect($result)->toBeInstanceOf(Article::class);
    expect($result->title)->toEqual($data['title']);

    $this->assertDatabaseHas('articles', [
        'title' => $data['title'],
    ]);
});

it('can get a Article', function () {
    $repository = new ArticleRepository();
    $Article = Article::factory()->create();

    $result = $repository->show($Article->id);

    expect($result)->toBeInstanceOf(Article::class);
    expect($result->title)->toEqual($Article->title);
});

it('can find a Article by slug', function () {
    $repository = new ArticleRepository();
    $article = Article::factory()->create();
    $slug = $article->slug;

    $result = $repository->findBySlug($slug);

    expect($result)->toBeInstanceOf(Article::class);
    expect($result->slug)->toEqual($slug);
});

it('can update a Article', function () {
    $repository = new ArticleRepository();
    $Article = Article::factory()->create();

    $data = [
        'title' => 'Jane Smith',
    ];

    $result = $repository->update($data, $Article->id);

    expect($result)->toBeInstanceOf(Article::class);
    expect($result->title)->toEqual('Jane Smith');

    $this->assertDatabaseHas('articles', [
        'title' => 'Jane Smith',
    ]);
});

it('can delete a Article', function () {
    $repository = new ArticleRepository();
    $Article = Article::factory()->create();

    $repository->delete($Article->id);

    expect(Article::find($Article->id))->toBeNull();

    $this->assertDatabaseMissing('articles', [
        'title' => $Article->title,
    ]);
});
