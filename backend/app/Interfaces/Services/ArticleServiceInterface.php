<?php

namespace App\Interfaces\Services;

use App\Interfaces\Base\BaseServiceInterface;
use App\Models\Article;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

interface ArticleServiceInterface extends BaseServiceInterface
{
    /**
     * Get data Article for datatable.
     */
    public function datatable(Request $request): LengthAwarePaginator;

    /**
     * Create a new data Article.
     */
    public function create(FormRequest $request): void;
    
    /**
     * Find a single data Article from id.
     */
    public function show(string $id): Article;

    /**
     * Update a data Article.
     */
    public function update(FormRequest $request, Article $Article): void;

    /**
     * Delete a data Article.
     */
    public function delete(Article $Article): void;
}