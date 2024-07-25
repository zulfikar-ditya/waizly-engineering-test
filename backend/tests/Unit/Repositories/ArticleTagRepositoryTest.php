<?php

use App\Models\ArticleTag;
use App\Repositories\ArticleTagRepository;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

it('can get datatable', function () {
    $repository = new ArticleTagRepository();
    $request = new Request();

    $result = $repository->datatable($request);

    expect($result)->toBeInstanceOf(LengthAwarePaginator::class);
});

it('can get datatable with search', function () {

    ArticleTag::factory()->count(10)->create();
    ArticleTag::factory()->create([
        'name' => 'search term',
    ]);

    $repository = new ArticleTagRepository();
    $request = new Request([
        'search' => 'search term',
    ]);

    $result = $repository->datatable($request);

    expect($result)->toBeInstanceOf(LengthAwarePaginator::class);
    expect($result->count())->toEqual(1);
});

// tag no need filter
// it('can get datatable with filter', function () {

//     ArticleTag::factory()->count(10)->create();
//     ArticleTag::factory()->count(5)->create([
//         'name' => 'search term',
//     ]);

//     $repository = new ArticleTagRepository();
//     $request = new Request([
//         'filter' => [
//             'name' => 'search term',
//         ],
//     ]);

//     $result = $repository->datatable($request);

//     expect($result)->toBeInstanceOf(LengthAwarePaginator::class);
//     expect($result->count())->toEqual(5);
// });

it('can get datatable with per page parameter', function () {

    ArticleTag::factory()->count(10)->create();

    $repository = new ArticleTagRepository();
    $request = new Request([
        'per_page' => 5
    ]);

    $result = $repository->datatable($request);

    expect($result)->toBeInstanceOf(LengthAwarePaginator::class);
    expect($result->count())->toEqual(5);
});

it('can get datatable with sort', function () {
    ArticleTag::factory()->count(10)->create();

    $repository = new ArticleTagRepository();
    $request = new Request([
        'sort' => '-name',
    ]);

    $result = $repository->datatable($request);

    expect($result)->toBeInstanceOf(LengthAwarePaginator::class);
    expect($result->count())->toEqual(10);
});

it('can create a ArticleTag', function () {
    $repository = new ArticleTagRepository();
    $data = ArticleTag::factory()->make()->toArray();

    $result = $repository->create($data);

    expect($result)->toBeInstanceOf(ArticleTag::class);
    expect($result->name)->toEqual($data['name']);

    $this->assertDatabaseHas('article_tags', [
        'name' => $data['name'],
    ]);
});

it('can get a ArticleTag', function () {
    $repository = new ArticleTagRepository();
    $ArticleTag = ArticleTag::factory()->create();

    $result = $repository->show($ArticleTag->id);

    expect($result)->toBeInstanceOf(ArticleTag::class);
    expect($result->name)->toEqual($ArticleTag->name);
});

it('can update a ArticleTag', function () {
    $repository = new ArticleTagRepository();
    $ArticleTag = ArticleTag::factory()->create();

    $data = [
        'name' => 'Jane Smith',
    ];

    $result = $repository->update($data, $ArticleTag->id);

    expect($result)->toBeInstanceOf(ArticleTag::class);
    expect($result->name)->toEqual('Jane Smith');

    $this->assertDatabaseHas('article_tags', [
        'name' => 'Jane Smith',
    ]);
});

it('can delete a ArticleTag', function () {
    $repository = new ArticleTagRepository();
    $ArticleTag = ArticleTag::factory()->create();

    $repository->delete($ArticleTag->id);

    expect(ArticleTag::find($ArticleTag->id))->toBeNull();

    $this->assertDatabaseMissing('article_tags', [
        'name' => $ArticleTag->name,
    ]);
});
