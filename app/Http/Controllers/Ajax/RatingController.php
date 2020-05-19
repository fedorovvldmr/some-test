<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Http\Requests\RatingFormRequest;
use App\News;
use App\Photo;
use Illuminate\Http\JsonResponse;

class RatingController extends Controller
{
    
    /**
     * @param  RatingFormRequest  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function inc(RatingFormRequest $request): JsonResponse
    {
        try {
            $this->process($request, 'increment');
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
    public function dec(RatingFormRequest $request): JsonResponse
    {
        try {
            $this->process($request, 'decrement');
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
            $model->save();
        }
    }
    
}