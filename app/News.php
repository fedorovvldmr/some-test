<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class News
 * @package App
 * @property integer $id
 * @property string  $login
 * @property string  $title
 * @property string  $text
 * @property integer $rating
 */
class News extends Model
{
    
    protected $table = 'news';
    
}
