<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewPhotoFormRequest;
use App\Photo;
use Illuminate\Http\Request;

class PhotoController extends Controller
{
    
    public function index()
    {
        $photos = [];
        /** @var Photo $photo */
        foreach (Photo::all() as $photo) {
            $photos[$photo->id] = $photo;
        }
        
        return $this->view('photos.photos', ['title' => 'Фото', 'photoList' => $photos]);
    }
    
    /**
     * @param  NewPhotoFormRequest  $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function create(NewPhotoFormRequest $request)
    {
        if (!empty($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
            $tmpName        = $_FILES['photo']['tmp_name'];
            $fileName       = $_FILES['photo']['name'];
            $fielNameChunks = explode(".", $fileName);
            $fileExtension  = strtolower(end($fielNameChunks));
            $newFileName    = md5(time() . $fileName) . '.' . $fileExtension;
            
            $uploadDir         = '/uploads';
            $uploadDirFullPath = $_SERVER['DOCUMENT_ROOT'] . $uploadDir;
            $src               = $uploadDir . '/' . $newFileName;
            if (!file_exists($uploadDirFullPath)) {
                mkdir($uploadDirFullPath, 0775, true);
            }
            
            if (move_uploaded_file($tmpName, $uploadDirFullPath . '/' . $newFileName)) {
                $photo        = new Photo();
                $photo->title = $request->post('title');
                $photo->login = $this->user->name;
                $photo->src   = $src;
                $photo->save();
            } else {
                throw new \Exception('photo didn\'t save');
            }
        } else {
            throw new \UnexpectedValueException('incorrect photo data');
        }
        
        return redirect(route('photos'));
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }
    
    /**
     * Display the specified resource.
     *
     * @param  \App\Photo  $photo
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Photo $photo)
    {
        //
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Photo  $photo
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Photo $photo)
    {
        //
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Photo                $photo
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Photo $photo)
    {
        //
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Photo  $photo
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Photo $photo)
    {
        //
    }
    
}
