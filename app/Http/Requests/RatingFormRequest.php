<?php

namespace App\Http\Requests;

use App\News;
use App\Photo;
use Illuminate\Foundation\Http\FormRequest;

class RatingFormRequest extends FormRequest
{
    
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
    
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'type' => ['string', 'required'],
            'id'   => [
                'numeric',
                'required',
                function ($attribute, $id, $fail) {
                    $type   = request('type');
                    $result = null;
                    
                    switch ($type) {
                        case 'news':
                            $result = News::find($id);
                            break;
                        
                        case 'photo':
                            $result = Photo::find($id);
                            break;
                    }
                    if (!$result) {
                        $fail('id not found');
                    }
                },
            ],
        ];
    }
    
}
