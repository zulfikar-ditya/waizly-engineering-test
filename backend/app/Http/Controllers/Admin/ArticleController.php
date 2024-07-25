<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Http\Requests\Admin\Article\StoreArticleRequest;
use App\Http\Requests\Admin\Article\UpdateArticleRequest;
use \App\Interfaces\Services\ArticleServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ArticleController extends Controller
{
    /**
     * Instantiate a new Controllers instance.
     */
    public function __construct()
    {
        // 
    }

    /**
     * Display a listing of the resource.
     */
    public function index(ArticleServiceInterface $service, Request $request)
    {
        return $this->responseJson($service->datatable($request));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreArticleRequest $request, ArticleServiceInterface $service)
    {
        DB::beginTransaction();

        try {
            $service->create($request);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th->getMessage());

            return $this->responseJsonMessageCrud(false, 'create', null, $th->getMessage(), 500);
        }

        DB::commit();

        return $this->responseJsonMessageCrud(true, 'create');
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article, ArticleServiceInterface $service)
    {
        $article = $service->show($article->id);

        return $this->responseJsonData($article);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateArticleRequest $request, Article $article, ArticleServiceInterface $service)
    {
        DB::beginTransaction();

        try {
            $service->update($request, $article);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th->getMessage());

            return $this->responseJsonMessageCrud(false, 'update', null, $th->getMessage(), 500);
        }

        DB::commit();

        return $this->responseJsonMessageCrud(true, 'update');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article, ArticleServiceInterface $service)
    {
        DB::beginTransaction();

        try {
            $service->delete($article);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th->getMessage());

            return $this->responseJsonMessageCrud(false, 'delete', null, $th->getMessage(), 500);
        }

        DB::commit();

        return $this->responseJsonMessageCrud(true, 'delete');
    }
}
