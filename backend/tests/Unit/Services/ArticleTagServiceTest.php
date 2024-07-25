<?php

use App\Http\Requests\Tests\ArticleTag\StoreArticleTagRequest;
use App\Http\Requests\Tests\ArticleTag\UpdateArticleTagRequest;
use App\Interfaces\Services\ArticleTagServiceInterface;
use App\Models\ArticleTag;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

it('can get datatable', function () {
    $request = new Request();

    $service = app(ArticleTagServiceInterface::class);

    $result = $service->datatable($request);

    expect($result)->toBeInstanceOf(LengthAwarePaginator::class);
});

it('can get datatable with search', function () {
    ArticleTag::factory()->count(10)->create();
    ArticleTag::factory()->create([
        'name' => 'search term',
    ]);

    $request = new Request([
        'search' => 'search term'
    ]);

    $service = app(ArticleTagServiceInterface::class);

    $result = $service->datatable($request);

    expect($result)->toBeInstanceOf(LengthAwarePaginator::class);
    expect($result->count())->toEqual(1);
});

// it('can get datatable with filter', function () {
//     ArticleTag::factory()->count(10)->create();
//     ArticleTag::factory()->count(5)->create([
//         'name' => 'search term'
//     ]);

//     $request = new Request([
//         'filter' => [
//             'name' => 'search term',
//         ],
//     ]);

//     $service = app(ArticleTagServiceInterface::class);

//     $result = $service->datatable($request);

//     expect($result)->toBeInstanceOf(LengthAwarePaginator::class);
//     expect($result->count())->toEqual(5);
// });

it('can get datatable with per page parameter', function () {
    ArticleTag::factory()->count(10)->create();

    $request = new Request([
        'per_page' => 5
    ]);

    $service = app(ArticleTagServiceInterface::class);

    $result = $service->datatable($request);

    expect($result)->toBeInstanceOf(LengthAwarePaginator::class);
    expect($result->count())->toEqual(5);
});

it('can create a ArticleTag', function () {

    $fake = ArticleTag::factory()->make()->toArray();

    $request = new FormRequest();
    $request = $request->setValidator(Validator::make(
        $fake,
        (new StoreArticleTagRequest())->rules()
    ));

    $service = app(ArticleTagServiceInterface::class);

    $result = $service->create($request);

    $this->assertDatabaseHas('article_tags', [
        'name' => $fake['name'],
    ]);
});

it('can get a ArticleTag', function () {
    $fake = ArticleTag::factory()->create();

    $service = app(ArticleTagServiceInterface::class);
    $result = $service->show($fake->id);

    expect($result->id)->toEqual($fake->id);
});

it('can update a ArticleTag', function () {
    $ArticleTag = ArticleTag::factory()->create();

    $fake = ArticleTag::factory()->make()->toArray();

    $request = new FormRequest();
    $request = $request->setValidator(Validator::make(
        $fake,
        (new UpdateArticleTagRequest())->rules()
    ));

    $service = app(ArticleTagServiceInterface::class);

    $result = $service->update($request, $ArticleTag);

    $this->assertDatabaseHas('article_tags', [
        'name' => $fake['name'],
    ]);
});

it('can delete a ArticleTag', function () {
    $ArticleTag = ArticleTag::factory()->create();

    $service = app(ArticleTagServiceInterface::class);

    $result = $service->delete($ArticleTag);

    expect(ArticleTag::find($ArticleTag->id))->toBeNull();

    $this->assertDatabaseMissing('article_tags', [
        'name' => $ArticleTag->name,
    ]);
});
