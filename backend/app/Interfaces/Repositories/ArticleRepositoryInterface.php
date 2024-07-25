<?php

namespace App\Interfaces\Repositories;

use App\Interfaces\Base\BaseRepositoryInterface;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

interface ArticleRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Datatable query for Article.
     */
    public function datatable(Request $request): LengthAwarePaginator;

    /**
     * Create a new Article.
     */
    public function create(array $data): Article;

    /**
     * Find a Article by id.
     */
    public function show(string $id): Article;

    /**
     * Find a Article by slug.
     */
    public function findBySlug(string $slug): Article;

    /**
     * Update a Article
     */
    public function update(array $data, string $id): Article;

    /**
     * Delete a Article
     */
    public function delete(string $id): void;

    /**
     * Find a unique slug for an article.
     */
    public function findUniqueSlug(string $slug): string;
}
