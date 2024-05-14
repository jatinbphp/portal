<?php

namespace App\Http\Controllers\admin;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ImageController extends Controller
{
    public function upload_image(Request $request)
    {
        if($request->hasFile('image')){
            //$filename = Str::random(20).'_'.$request->file('image')->getClientOriginalName();
            $filename = $request->file('image')->getClientOriginalName();
            $image_path = base_path() . '/public/assets/website/images/';
            $request->file('image')->move(
                $image_path, $filename
            );
            echo url('public/assets/website/images/'.$filename);
        }
        else{
            echo 'Oh No! Uploading your image has failed.';
        }
    }
}


