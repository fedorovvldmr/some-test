<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Like;

/**
 * Class Photo
 * @package App
 * @property integer $id
 * @property string  $title
 * @property string  $src
 * @property string  $login
 * @property integer $rating
 * @property array   $likes
 * @property array   $dislikes
 */
class Photo extends Model
{
    
    protected $table = 'photos';
    
    protected function likesRelation(): HasMany
    {
        return $this->hasMany(Like::class, 'record_id');
    }
    
    public function likes()
    {
        return $this->likesRelation()->where([
            'type'      => Like::TYPE_PHOTO,
            'direction' => Like::UP,
        ]);
    }
    
    public function dislikes()
    {
        return $this->likesRelation()->where([
            'type'      => Like::TYPE_PHOTO,
            'direction' => Like::DOWN,
        ]);
    }
    
}
