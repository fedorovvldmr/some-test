<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Http\Requests\NewsCreateFromRequest;
use App\News;
use Illuminate\Http\JsonResponse;

class NewsController extends Controller
{
    
    /**
     * @param  int  $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(int $id)
    {
        try {
            $news = News::findOrFail($id);
            $news->delete();
            
            return response()->json(['status' => self::STATUS_OK]);
        } catch (\Throwable $e) {
            error_log($e->getMessage() . "\n" . $e->getTraceAsString());
            
            return response()->json(['status' => self::STATUS_ERROR]);
        }
    }
    
    /**
     * @param  NewsCreateFromRequest  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function createOrEdit(NewsCreateFromRequest $request): JsonResponse
    {
        try {
            //TODO добавить санитизацию для title и text
            $id    = $request->post('id', -1);
            $title = $request->post('title');
            $text  = $request->post('text');
            
            /** @var News $news */
            $news        = News::findOrNew($id);
            $news->login = $this->user->name;
            $news->title = $title;
            $news->text  = $text;
            $news->save();
            
            return response()->json(['status' => self::STATUS_OK, 'news' => $news]);
        } catch (\Throwable $e) {
            error_log($e->getMessage() . "\n" . $e->getTraceAsString());
            
            return response()->json(['status' => self::STATUS_ERROR]);
        }
    }
    
}