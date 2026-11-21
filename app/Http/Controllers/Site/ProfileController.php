<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Artist;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function __invoke(): View
    {
        return view('site.profile', [
            'artists' => Artist::query()->published()->orderBy('sort_order')->limit(8)->get(),
        ]);
    }
}
