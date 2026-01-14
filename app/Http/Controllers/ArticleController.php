<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager; 
use Intervention\Image\Drivers\Gd\Driver as GdDriver; // Import the GD driver

class ArticleController extends Controller
{
    public function uploadImageSummernote(Request $request)
    {
        $post = $request->all();
        $type = 'summernote'; // Hardcode type for now

        // encode image
        $size = $request->file->getSize();
        if ($size > 5000000) {
            return response()->json(['status' => false, 'messages' => ['Image Size Exceeded 5MB']], 422);
        }

        if (!Storage::disk('public')->exists('image/' . $type)) {
            Storage::disk('public')->makeDirectory('image/' . $type);
        }

        // upload image
        $ext = $request->file->getClientOriginalExtension();
        $filename = 'summernote_image_' . time() . '.' . $ext;
        
        // Use the ImageManager to make the image with GdDriver
        $manager = new ImageManager(new GdDriver());
        $img = $manager->read($request->file->getRealPath());
        
        $doc_name = 'image/' . $type . '/' . $filename;
        $resource = $img->encodeByExtension($ext); // Corrected for Intervention Image v3
        
        $save = Storage::disk('public')->put($doc_name, $resource);

        if ($save) {
            return response()->json([
                "status" => "success",
                "path" => 'image/' . $type,
                "image" => $filename,
                "image_url" => Storage::url('image/' . $type . '/'.$filename)
            ]);
        } else {
            return response()->json(["status" => "fail"], 500);
        }
    }

    public function deleteImageSummernote(Request $request)
    {
        $arrayUrl = array_filter(explode('/', $request->target));
        $fileName = end($arrayUrl);
        $type = 'summernote'; // Hardcode type for now

        $deleteStorage = Storage::disk('public')->delete('image/' . $type . '/' . $fileName);
        
        if ($deleteStorage) {
            return response()->json(["status" => "success", "message" => "Image deleted."]);
        } else {
            return response()->json(["status" => "fail", "message" => "Image not found or could not be deleted."], 404);
        }
    }
}
