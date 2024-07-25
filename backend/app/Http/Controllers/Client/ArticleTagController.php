<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Interfaces\Services\ArticleTagServiceInterface;
use Illuminate\Http\Request;

class ArticleTagController extends Controller
{
    /**
     * Instantiate a new ArticleTagController instance.
     */
    public function __construct(public ArticleTagServiceInterface $articleTagService)
    {
        // body
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return $this->responseJson($this->articleTagService->datatable($request));
    }
}
