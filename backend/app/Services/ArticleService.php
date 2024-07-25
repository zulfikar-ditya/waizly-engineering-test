<?php

namespace App\Services;

use App\Interfaces\Repositories\ArticleRepositoryInterface;
use App\Interfaces\Services\ArticleServiceInterface;
use App\Models\Article;
use App\Services\Base\BaseService;
use App\Traits\UploadFile;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class ArticleService extends BaseService implements ArticleServiceInterface
{
    use UploadFile;

    /**
     * The constructor function for ArticleService.
     */
    public function __construct(private ArticleRepositoryInterface $repository)
    {
        //
    }

    /**
     * Get data Article for datatable.
     */
    public function datatable(Request $request): LengthAwarePaginator
    {
        return $this
            ->repository
            ->datatable($request);
    }

    /**
     * Create a new data Article
     */
    public function create(FormRequest $request): void
    {
        $article = $this->repository->create([
            ...$request->safe()->except('article_tags'),
            'image' => $request->hasFile('image') ? $this->uploadFile($request->file('image'), 'article') : null
        ]);

        $article->articleTags()->sync($request->input('article_tags'));
    }

    /**
     * Find a single data Article from id.
     */
    public function show(string $id): Article
    {
        return $this->repository->show($id);
    }

    /**
     * Update a data Article.
     */
    public function update(FormRequest $request, Article $Article): void
    {
        $oldFile = $Article->image;

        // * check if has file
        // * upload new file
        $image = null;
        if ($request->hasFile('image')) {
            $image = $this->uploadFile($request->file('image'), 'article');
        }

        $this->repository->update([
            ...$request->safe()->except('article_tags'),
            'image' => $image ?? $Article->image
        ], $Article->id);

        $Article->articleTags()->sync($request->article_tags);

        // * delete old file
        if (!is_null($image)) {
            $this->deleteFile($oldFile);
        }
    }

    /**
     * Delete a data Article.
     */
    public function delete(Article $Article): void
    {
        $this->repository->delete($Article->id);
    }
}
