<?php

namespace App\Http\Controllers;

use App\Services\NewsService;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    protected $newsService;

    public function __construct(NewsService $newsService)
    {
        $this->newsService = $newsService;
    }

    public function reloadNews(Request $request)
    {
        $news = $this->newsService->get(15, true, true);

        return response()->redirectTo('/');
    }
}
