<?php

namespace App\Services;

use App\Models\User;
use Carbon\Carbon;
use http\Env;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ImageService
{
    public function saveImage($skin, $cloak): void
    {
        $user = Auth::user();
        $userDirectory = "public/uploads/{$user->email}";


        if (Storage::exists("{$userDirectory}/skins/skin.png")) {
            $timestamp = Carbon::now()->format('Ymd_His');
            Storage::move("{$userDirectory}/skins/skin.png", "{$userDirectory}/skins/skin_{$timestamp}.png");
        }

        Storage::putFileAs("{$userDirectory}/skins", $skin, 'skin.png');

        if (Storage::exists("{$userDirectory}/cloaks/cloaks.png")) {
            $timestamp = Carbon::now()->format('Ymd_His');
            Storage::move("{$userDirectory}/cloaks/cloaks.png", "{$userDirectory}/cloaks/cloaks_{$timestamp}.png");
        }

        Storage::putFileAs("{$userDirectory}/cloaks", $cloak, 'cloak.png');

    }

    public function getUserSkinCloak(User $user = null): array
    {

        if(!$user){
            $user = Auth::user();
        }

        $userDirectory = "public/uploads/{$user->email}";

        $imageUrls = [
            'skin' => null,
            'cloak' => null,
        ];

        if (Storage::exists("{$userDirectory}/skins/skin.png")) {
            $imageUrls['skin'] = url(Storage::url("{$userDirectory}/skins/skin.png"));
        }

        if (Storage::exists("{$userDirectory}/cloaks/cloak.png")) {
            $imageUrls['cloak'] = url(Storage::url("{$userDirectory}/cloaks/cloak.png"));
        }

        return $imageUrls;
    }
}
