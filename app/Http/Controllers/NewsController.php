<?php

namespace App\Http\Controllers;

use App\Services\NewsService;
use Illuminate\Http\Request;
use App\Models\News;

class NewsController extends Controller
{
    protected $newsService;

    public function __construct(NewsService $newsService)
    {
        $this->newsService = $newsService;
    }

    public function show(Request $request, $slug)
    {
        $post = News::where('slug', $slug)
            ->first();

        return view('news.show', compact('post'));
    }

    public function reloadNews(Request $request)
    {
        $this->newsService->reset();
        $news = $this->newsService->retrieve(15, true, true);

        return redirect('/');
    }
}
