<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Interfaces\Services\ArticleServiceInterface;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Instantiate a new ArticleController instance.
     */
    public function __construct(public ArticleServiceInterface $articleService)
    {
        // 
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return $this->responseJson($this->articleService->datatable($request));
    }

    /**
     * Show a specific resource from storage.
     */
    public function show(string $slug)
    {
        return $this->responseJson($this->articleService->findBySlug($slug));
    }
}
