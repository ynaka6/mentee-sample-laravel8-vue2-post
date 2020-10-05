<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\CrawlerSiteService;

class ExternalController extends Controller
{
    private $service;

    public function __construct(CrawlerSiteService $service)
    {
        $this->service = $service;
    }

    /**
     * 外部サイトの情報を取得します
     *
     * @param Request $request
     * @return void
     */
    public function crawler(Request $request)
    {
        $data = $this->service->crawler($request->url);
        return response()->json($data);
    }

}
