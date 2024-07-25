<?php

namespace App\Interfaces\Repositories;

use App\Interfaces\Base\BaseRepositoryInterface;
use App\Models\ArticleTag;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

interface ArticleTagRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Datatable query for ArticleTag.
     */
    public function datatable(Request $request): LengthAwarePaginator;

    /**
     * Create a new ArticleTag.
     */
    public function create(array $data): ArticleTag;

    /**
     * Find a ArticleTag by id.
     */
    public function show(string $id): ArticleTag;

    /**
     * Update a ArticleTag
     */
    public function update(array $data, string $id): ArticleTag;

    /**
     * Delete a ArticleTag
     */
    public function delete(string $id): void;
}
