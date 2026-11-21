<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Requests\ArtworkFilterRequest;
use App\Models\Artwork;
use Illuminate\View\View;

class ArtworkController extends Controller
{
    public function index(ArtworkFilterRequest $request): View
    {
        $filters = $request->validated();

        $artworks = Artwork::query()
            ->published()
            ->with('artist:id,name,slug')
            ->when($filters['kategori'] ?? null, fn ($query, string $category) => $query->where('category', $category))
            ->when($filters['q'] ?? null, fn ($query, string $search) => $query->where('title', 'like', "%{$search}%"))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('site.artworks.index', [
            'artworks' => $artworks,
            'categories' => Artwork::CATEGORIES,
            'activeCategory' => $filters['kategori'] ?? null,
            'search' => $filters['q'] ?? null,
        ]);
    }

    public function show(Artwork $artwork): View
    {
        abort_unless($artwork->isPublished(), 404);

        $artwork->load('artist');

        return view('site.artworks.show', [
            'artwork' => $artwork,
            'related' => Artwork::query()
                ->published()
                ->where('category', $artwork->category)
                ->whereKeyNot($artwork->getKey())
                ->latest()
                ->limit(3)
                ->get(),
        ]);
    }
}
