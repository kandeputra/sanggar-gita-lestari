<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Artist;
use App\Models\Artwork;
use App\Models\Event;
use App\Models\GalleryItem;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        return view('site.home', [
            'upcomingEvents' => Event::query()->published()->upcoming()->limit(3)->get(),
            'featuredArtworks' => Artwork::query()
                ->published()
                ->with('artist:id,name,slug')
                ->orderByDesc('is_featured')
                ->latest()
                ->limit(6)
                ->get(),
            'artists' => Artist::query()->published()->orderBy('sort_order')->limit(4)->get(),
            'galleryItems' => GalleryItem::query()->published()->orderBy('sort_order')->latest()->limit(8)->get(),
        ]);
    }
}
