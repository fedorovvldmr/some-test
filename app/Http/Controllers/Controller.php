<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    public const STATUS_OK    = 1;
    public const STATUS_ERROR = 0;
    //
    /** @var User */
    protected $user;
    
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            
            $this->user = Auth::user();
            
            return $next($request);
        });
    }
    
    public function view($view = null, $data = [], $mergeData = [])
    {
        $data = array_merge($data, ['user' => $this->user]);
        
        return view($view, $data, $mergeData);
    }
    
}
