<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ArticleController extends Controller
{
    public function uploadImageSummernote(Request $request, $type)
    {
        $post = $request->all();
        $post['type'] = 'summernote';
        
        // encode image
        $size   = $request->file->getSize();
        if ($size < 5000000) {
            $encoded = base64_encode(fread(fopen($request->file, "r"), filesize($request->file)));
        } else {
            return ['status' => false, 'messages' => ['Image Size Exceeded 5MB']];
        }    
        if (!Storage::exists('public/image/' . $post['type'])) {

            Storage::makeDirectory('public/image/' . $post['type']);
        }

        // upload image
        $ext = $request->file->getClientOriginalExtension();
        $filename = 'summernote_image_' . time() . '.' . $ext;
        $img = Image::make($request->file);
        $doc_name = 'image/' . $post['type'] . '/' . $filename;
        $resource = $img->stream()->detach();
        $save = Storage::put('public/' . $doc_name, $resource);
        if ($save) {
            return [
                "status" => "success",
                "path" => 'image/' . $post['type'],
                "image" => $filename,
                "image_url" => Storage::url('image/' . $post['type'] . '/'.$filename)
            ];
        } else {
            return [
                "status" => "fail"
            ];
        }
    }

    public function deleteImageSummernote(Request $request, $type)
    {
        $arrayUrl = array_filter(explode('/', $request->target));
        $fileName = end($arrayUrl);
        $deleteStorage = Storage::disk('public')->delete('image/summernote/' . $fileName);
        return "success delete";
    }

}