<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Likes
 * @package App
 * @property integer $id
 * @property integer $record_id ID новости\фото
 * @property string  $login Логин поставившего лайк\дизлайк
 * @property string  $type Тип записи: новость, фото
 * @property string  $direction Лайк\дизлайк
 */
class Like extends Model
{
    
    public const UP   = 'up';
    public const DOWN = 'down';
    //
    public const TYPE_NEWS  = 'news';
    public const TYPE_PHOTO = 'photo';
    //
    protected $table = 'likes';
    //
    protected $fillable = [
        'record_id',
        'login',
        'type',
        'direction',
    ];
    
}
