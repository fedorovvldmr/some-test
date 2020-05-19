<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Photo;

class PhotoController extends Controller
{
    
    public function delete(int $id)
    {
        try {
            $photo = Photo::findOrFail($id);
            $src   = $photo->src;
            $photo->delete();
            unlink($_SERVER['DOCUMENT_ROOT'] . $src);
            
            return response()->json(['status' => self::STATUS_OK]);
        } catch (\Throwable $e) {
            error_log($e->getMessage() . "\n" . $e->getTraceAsString());
            
            return response()->json(['status' => self::STATUS_ERROR]);
        }
    }
    
}