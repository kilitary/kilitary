<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\News;
use App\Services\NewsService;
use Illuminate\Http\Request;

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
        $news = $this->newsService->retrieve(15, true, true);

        return redirect('/');
    }
}
