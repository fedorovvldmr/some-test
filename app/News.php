<?php

namespace App;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use App\Like;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class News
 * @package App
 * @property integer    $id
 * @property string     $login
 * @property string     $title
 * @property string     $text
 * @property integer    $rating
 * @property array      $likes
 * @property Collection $dislikes
 */
class News extends Model
{
    
    protected $table = 'news';
    
    protected function likesRelation(): HasMany
    {
        return $this->hasMany(Like::class, 'record_id');
    }
    
    public function likes()
    {
        return $this->likesRelation()->where([
            'type'      => Like::TYPE_NEWS,
            'direction' => Like::UP,
        ]);
    }
    
    public function dislikes()
    {
        return $this->likesRelation()->where([
            'type'      => Like::TYPE_NEWS,
            'direction' => Like::DOWN,
        ]);
    }
    
}
