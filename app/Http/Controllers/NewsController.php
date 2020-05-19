<?php

namespace App\Http\Controllers;

use App\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $newsList = [];
        /** @var News $news */
        foreach (News::all() as $news) {
            $newsList[$news->id] = $news;
        }
        
        return $this->view('news.news', ['title' => 'Новости', 'newsList' => $newsList]);
    }
    
    /**
     * @param  int  $id
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(int $id)
    {
        $news = News::findOrFail($id);
        
        return $this->view('news.show', ['title' => $news->title, 'news' => $news]);
    }
    
}
