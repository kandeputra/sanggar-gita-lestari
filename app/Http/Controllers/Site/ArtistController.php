<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Artist;
use Illuminate\View\View;

class ArtistController extends Controller
{
    public function index(): View
    {
        return view('site.artists.index', [
            'artists' => Artist::query()
                ->published()
                ->orderBy('sort_order')
                ->orderBy('name')
                ->paginate(12),
        ]);
    }

    public function show(Artist $artist): View
    {
        abort_unless($artist->isPublished(), 404);

        return view('site.artists.show', [
            'artist' => $artist,
            'artworks' => $artist->artworks()->published()->latest()->get(),
        ]);
    }
}
