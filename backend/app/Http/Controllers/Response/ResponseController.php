<?php

namespace App\Http\Controllers\Response;

use App\Http\Controllers\Controller;

class ResponseController extends Controller
{
    /**
     * Handle response file.
     */
    public function handleFile($filePath)
    {
        return $this->responseFile(\App\Support\Str::replace('$', '/', $filePath));
    }

    /**
     * Handle response downloaded file.
     */
    public function handleDownloadedFile($filePath)
    {
        return $this->responseDownloadStorage(\App\Support\Str::replace('$', '/', $filePath));
    }
}
