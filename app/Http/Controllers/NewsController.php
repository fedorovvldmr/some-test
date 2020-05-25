<?php

namespace App\Http\Controllers;

use App\Like;
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
            $newsList[$news->id] = $news->toArray();
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
        /** @var News $news */
        $news  = News::findOrFail($id);
        $likes = $news->likes->toArray();
        
        return $this->view('news.show', [
            'title' => $news->title,
            'news'  => [
                'id'            => $news->id,
                'login'         => $news->login,
                'title'         => $news->title,
                'text'          => $news->text,
                'rating'        => $news->rating,
                'likes_from'    => array_column($news->likes->toArray(), 'login'),
                'dislikes_from' => array_column($news->dislikes->toArray(), 'login'),
            ],
        ]);
    }
    
}
