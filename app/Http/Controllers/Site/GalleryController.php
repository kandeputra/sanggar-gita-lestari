<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\GalleryItem;
use Illuminate\View\View;

class GalleryController extends Controller
{
    public function __invoke(): View
    {
        return view('site.gallery', [
            'items' => GalleryItem::query()
                ->published()
                ->orderBy('sort_order')
                ->latest()
                ->paginate(24),
        ]);
    }
}
