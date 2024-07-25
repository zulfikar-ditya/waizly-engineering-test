<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ArticleTag;
use App\Http\Requests\Admin\ArticleTag\StoreArticleTagRequest;
use App\Http\Requests\Admin\ArticleTag\UpdateArticleTagRequest;
use App\Interfaces\Services\ArticleTagServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ArticleTagController extends Controller
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
    public function index(ArticleTagServiceInterface $service, Request $request)
    {
        return $this->responseJson($service->datatable($request));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreArticleTagRequest $request, ArticleTagServiceInterface $service)
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
    public function show(ArticleTag $articleTag, ArticleTagServiceInterface $service)
    {
        $articleTag = $service->show($articleTag->id);

        return $this->responseJsonData($articleTag);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateArticleTagRequest $request, ArticleTag $articleTag, ArticleTagServiceInterface $service)
    {
        DB::beginTransaction();

        try {
            $service->update($request, $articleTag);
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
    public function destroy(ArticleTag $articleTag, ArticleTagServiceInterface $service)
    {
        DB::beginTransaction();

        try {
            $service->delete($articleTag);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th->getMessage());

            return $this->responseJsonMessageCrud(false, 'delete', null, $th->getMessage(), 500);
        }

        DB::commit();

        return $this->responseJsonMessageCrud(true, 'delete');
    }
}
