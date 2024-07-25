<?php

namespace App\Interfaces\Services;

use App\Interfaces\Base\BaseServiceInterface;
use App\Models\ArticleTag;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

interface ArticleTagServiceInterface extends BaseServiceInterface
{
    /**
     * Get data ArticleTag for datatable.
     */
    public function datatable(Request $request): LengthAwarePaginator;

    /**
     * Create a new data ArticleTag.
     */
    public function create(FormRequest $request): void;
    
    /**
     * Find a single data ArticleTag from id.
     */
    public function show(string $id): ArticleTag;

    /**
     * Update a data ArticleTag.
     */
    public function update(FormRequest $request, ArticleTag $ArticleTag): void;

    /**
     * Delete a data ArticleTag.
     */
    public function delete(ArticleTag $ArticleTag): void;
}