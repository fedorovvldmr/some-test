<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Photo
 * @package App
 * @property integer $id
 * @property string  $title
 * @property string  $src
 * @property string  $login
 */
class Photo extends Model
{
    
    protected $table = 'photos';
    
}
