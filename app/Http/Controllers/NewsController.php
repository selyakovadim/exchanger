<?php

namespace App\Http\Controllers;

use App\Models\News;

class NewsController extends Controller
{
    public function index()
    {
        return view('news.index', [

            'news' => News::reverse()
                ->paginate(3),

        ]);
    }

    public function show(News $item)
    {
        return view('news.show', compact('item'));
    }
}
