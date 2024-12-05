<?php

namespace App\Http\Controllers;

use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FileController extends Controller
{
    public function uploadImage(Request $request,ImageService $imageService)
    {

        $skinFile = $request->file('skin');
        $cloakFile = $request->file('cloak');
        $imageService->saveImage($skinFile, $cloakFile);
        dd($imageService->getUserSkinCloak());

    }

    public function uploadImageView() : View
    {
        return view('upload-image');
    }
    public function downloadImage()
    {

    }
}
