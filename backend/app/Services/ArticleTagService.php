<?php

namespace App\Services;

use App\Interfaces\Repositories\ArticleTagRepositoryInterface;
use App\Interfaces\Services\ArticleTagServiceInterface;
use App\Models\ArticleTag;
use App\Services\Base\BaseService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class ArticleTagService extends BaseService implements ArticleTagServiceInterface
{
    /**
     * The constructor function for ArticleTagService.
     */
    public function __construct(private ArticleTagRepositoryInterface $repository)
    {
        //
    }

    /**
     * Get data ArticleTag for datatable.
     */
    public function datatable(Request $request): LengthAwarePaginator
    {
        return $this
            ->repository
            ->datatable($request);
    }

    /**
     * Create a new data ArticleTag
     */
    public function create(FormRequest $request): void
    {
        $this->repository->create($request->validated());
    }

    /**
     * Find a single data ArticleTag from id.
     */
    public function show(string $id): ArticleTag
    {
        return $this->repository->show($id);
    }

    /**
     * Update a data ArticleTag.
     */
    public function update(FormRequest $request, ArticleTag $ArticleTag): void
    {
        $this->repository->update($request->validated(), $ArticleTag->id);
    }

    /**
     * Delete a data ArticleTag.
     */
    public function delete(ArticleTag $ArticleTag): void
    {
        $this->repository->delete($ArticleTag->id);
    }
}
