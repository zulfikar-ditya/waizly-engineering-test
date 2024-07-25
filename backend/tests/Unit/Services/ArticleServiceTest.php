<?php

use App\Http\Requests\Tests\Article\StoreArticleRequest;
use App\Interfaces\Services\ArticleServiceInterface;
use App\Models\Article;
use App\Models\ArticleTag;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Validator;

it('can get datatable', function () {
    $request = new Request();

    $service = app(ArticleServiceInterface::class);

    $result = $service->datatable($request);

    expect($result)->toBeInstanceOf(LengthAwarePaginator::class);
});

it('can get datatable with search', function () {
    Article::factory()->count(10)->create();
    Article::factory()->create([
        'title' => 'search term',
    ]);

    $request = new Request([
        'search' => 'search term'
    ]);

    $service = app(ArticleServiceInterface::class);

    $result = $service->datatable($request);

    expect($result)->toBeInstanceOf(LengthAwarePaginator::class);
    expect($result->count())->toEqual(1);
});

it('can get datatable with filter', function () {

    $articleTags = ArticleTag::factory()->count(3)->create()->pluck('id')->toArray();
    Article::factory()->count(10)->create();
    Article::factory()->count(5)->afterCreating(function ($article) use ($articleTags) {
        $article->articleTags()->attach($articleTags);
    })->create();

    $request = new Request([
        'filter' => [
            'articleTags.id' => $articleTags[0]
        ],
    ]);

    $service = app(ArticleServiceInterface::class);

    $result = $service->datatable($request);

    expect($result)->toBeInstanceOf(LengthAwarePaginator::class);
    expect($result->count())->toEqual(5);
});

it('can get datatable with per page parameter', function () {
    Article::factory()->count(10)->create();

    $request = new Request([
        'per_page' => 5
    ]);

    $service = app(ArticleServiceInterface::class);

    $result = $service->datatable($request);

    expect($result)->toBeInstanceOf(LengthAwarePaginator::class);
    expect($result->count())->toEqual(5);
});

it('can create a Article', function () {

    $fake = Article::factory()->make()->toArray();
    $fake['image'] = UploadedFile::fake()->image('avatar.jpg');
    $fake['article_tags'] = ArticleTag::factory()->count(3)->create()->pluck('id')->toArray();

    $request = new FormRequest();
    $request->headers->set('Content-Type', 'multipart/form-data');
    $request->merge($fake);
    $request = $request->setValidator(Validator::make(
        $request->all(),
        (new StoreArticleRequest())->rules()
    ));

    $service = app(ArticleServiceInterface::class);

    $result = $service->create($request);

    $this->assertDatabaseHas('articles', [
        'title' => $fake['title'],
    ]);
});

it('can get a Article', function () {
    $fake = Article::factory()->create();

    $service = app(ArticleServiceInterface::class);
    $result = $service->show($fake->id);

    expect($result->id)->toEqual($fake->id);
});

it('can update a Article', function () {
    $Article = Article::factory()->create();

    $fake = Article::factory()->make()->toArray();
    $fake['image'] = UploadedFile::fake()->image('avatar.jpg');
    $fake['article_tags'] = ArticleTag::factory()->count(3)->create()->pluck('id')->toArray();

    $request = new FormRequest();
    $request->headers->set('Content-Type', 'multipart/form-data');
    $request->merge($fake);
    $request = $request->setValidator(Validator::make(
        $request->all(),
        (new StoreArticleRequest())->rules()
    ));

    $service = app(ArticleServiceInterface::class);

    $result = $service->update($request, $Article);

    $this->assertDatabaseHas('articles', [
        'title' => $fake['title'],
    ]);
});

it('can delete a Article', function () {
    $Article = Article::factory()->create();

    $service = app(ArticleServiceInterface::class);
    $result = $service->delete($Article);

    expect(Article::find($Article->id))->toBeNull();

    $this->assertDatabaseMissing('articles', [
        'title' => $Article->title,
    ]);
});
