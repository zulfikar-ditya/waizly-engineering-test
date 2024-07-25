<?php

namespace App\Repositories;

use App\Interfaces\Repositories\ArticleRepositoryInterface;
use App\Models\Article;
use App\Repositories\Base\BaseRepository;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class ArticleRepository extends BaseRepository implements ArticleRepositoryInterface
{
    /**
     * Instantiate a new ArticleRepository instance.
     */
    public function __construct()
    {
        $this->setAllowableSearch([
            'title',
        ]);

        $this->setAllowableSort([
            'title',
        ]);

        $this->setAllowableFilter([
            'articleTags.id'
        ]);

        $this->setAllowableInclude([
            'articleTags' => function ($q) {
                $q->select(['id', 'name']);
            },
        ]);
    }

    /**
     * Datatable query for Article.
     */
    public function datatable(Request $request): LengthAwarePaginator
    {
        return Article::query()
            ->when($request->search, function ($query, $search) {
                $this->getAllowableSearchQuery($query, $search);
            })
            ->when($request->filter && is_array($request->filter), function ($query) use ($request) {
                $this->getAllowableFilterQuery($query, $request->filter);
            })
            ->orderBy($this->getSortColumn(), $this->getSortDirection())
            ->with($this->getAllowableInclude())
            ->paginate($request->per_page ?? config('app.default_paginator'));
    }

    /**
     * Create a new Article.
     */
    public function create(array $data): Article
    {
        $data =  Article::create($data);

        return $data;
    }

    /**
     * Find a Article by id.
     */
    public function show(string $id): Article
    {
        $data =  Article::with($this->getAllowableInclude())->findOrFail($id);

        return $data;
    }

    /**
     * Update a Article,
     */
    public function update(array $data, string $id): Article
    {
        $model = Article::findOrFail($id);
        $model->update($data);

        return $model;
    }

    /**
     * Delete a Article,
     */
    public function delete(string $id): void
    {
        $data = Article::findOrFail($id);
        $data->delete();
    }

    /**
     * Find a unique slug for an article.
     */
    public function findUniqueSlug(string $slug): string
    {
        $count = Article::where('slug', 'like', $slug . '%')->count();

        return $count > 0 ? $slug . '-' . $count : $slug;
    }
}
