<?php

namespace App\Repositories;

use App\Interfaces\Repositories\ArticleTagRepositoryInterface;
use App\Models\ArticleTag;
use App\Repositories\Base\BaseRepository;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class ArticleTagRepository extends BaseRepository implements ArticleTagRepositoryInterface
{
    /**
     * Instantiate a new ArticleTagRepository instance.
     */
    public function __construct()
    {
        $this->setAllowableSearch([
            'name'
        ]);

        $this->setAllowableSort([
            'name'
        ]);

        $this->setAllowableFilter([
            //
        ]);

        $this->setAllowableInclude([
            // 
        ]);
    }

    /**
     * Datatable query for ArticleTag.
     */
    public function datatable(Request $request): LengthAwarePaginator
    {
        return ArticleTag::query()
            ->when($request->search, function ($query, $search) {
                $this->getAllowableSearchQuery($query, $search);
            })
            ->when($request->filter && is_array($request->filter), function ($query) use ($request) {
                $this->getAllowableFilterQuery($query, $request->filter);
            })
            ->orderBy($this->getSortColumn(), $this->getSortDirection())
            ->paginate($request->per_page ?? config('app.default_paginator'));
    }

    /**
     * Create a new ArticleTag.
     */
    public function create(array $data): ArticleTag
    {
        $data =  ArticleTag::create($data);

        return $data;
    }

    /**
     * Find a ArticleTag by id.
     */
    public function show(string $id): ArticleTag
    {
        $data =  ArticleTag::with($this->getAllowableInclude())->findOrFail($id);

        return $data;
    }

    /**
     * Update a ArticleTag,
     */
    public function update(array $data, string $id): ArticleTag
    {
        $model = ArticleTag::findOrFail($id);
        $model->update($data);

        return $model;
    }

    /**
     * Delete a ArticleTag,
     */
    public function delete(string $id): void
    {
        $data = ArticleTag::findOrFail($id);
        $data->delete();
    }
}
