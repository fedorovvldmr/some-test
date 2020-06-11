<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Http\Requests\RatingFormRequest;
use App\News;
use App\Photo;
use Illuminate\Http\JsonResponse;
use App\Like;

class RatingController extends Controller
{
    
    public const DIRECTION_INCREMENT = 'increment';
    public const DIRECTION_DECREMENT = 'decrement';
    
    /**
     * @param  RatingFormRequest  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function like(RatingFormRequest $request): JsonResponse
    {
        try {
            $this->process($request, self::DIRECTION_INCREMENT);
        } catch (\Throwable $e) {
            error_log($e->getMessage() . "\n" . $e->getTraceAsString());
            
            return response()->json(['status' => self::STATUS_ERROR]);
        }
        
        return response()->json(['status' => self::STATUS_OK]);
    }
    
    /**
     * @param  RatingFormRequest  $request
     *
     * @return JsonResponse
     */
    public function dislike(RatingFormRequest $request): JsonResponse
    {
        try {
            $this->process($request, self::DIRECTION_DECREMENT);
        } catch (\Throwable $e) {
            error_log($e->getMessage() . "\n" . $e->getTraceAsString());
            
            return response()->json(['status' => self::STATUS_ERROR]);
        }
        
        return response()->json(['status' => self::STATUS_OK]);
    }
    
    /**
     * @param  RatingFormRequest  $request
     * @param  string             $direction
     */
    private function process(RatingFormRequest $request, string $direction): void
    {
        $type = $request->post('type');
        $id   = $request->post('id');
        
        /** @var Like $like */
        $like = Like::firstOrNew(['record_id' => $id, 'type' => $type]);
        $condition = !empty($like->id);
        $condition = $condition && $like->direction === ($direction === self::DIRECTION_INCREMENT ? Like::UP : Like::DOWN);
        if ($condition) {
            throw new \Exception('you voted earlier');
        }
        
        /** @var null|News|Photo $model */
        $model = null;
        switch ($type) {
            case 'news':
                $model = News::find($id);
                break;
            
            case 'photo':
                $model = Photo::find($id);
        }
        if ($model !== null) {
            $model->$direction('rating');
            
            $like->login     = $this->user->name;
            $like->direction = $direction === self::DIRECTION_INCREMENT ? Like::UP : Like::DOWN;
            
            $model->save();
            $like->save();
        }
    }
    
}