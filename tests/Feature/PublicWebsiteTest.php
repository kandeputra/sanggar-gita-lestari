<?php

namespace Tests\Feature;

use App\Models\Artist;
use App\Models\Artwork;
use App\Models\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicWebsiteTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_pages_are_accessible(): void
    {
        foreach (['home', 'profile', 'artists.index', 'artworks.index', 'events.index', 'gallery'] as $route) {
            $this->get(route($route))->assertOk();
        }
    }

    public function test_only_published_artworks_are_listed(): void
    {
        Artwork::factory()->create(['title' => 'Tari Terbit']);
        Artwork::factory()->draft()->create(['title' => 'Tari Draf']);

        $this->get(route('artworks.index'))
            ->assertOk()
            ->assertSee('Tari Terbit')
            ->assertDontSee('Tari Draf');
    }

    public function test_draft_content_detail_returns_404(): void
    {
        $artwork = Artwork::factory()->draft()->create();
        $artist = Artist::factory()->draft()->create();
        $event = Event::factory()->draft()->create();

        $this->get(route('artworks.show', $artwork))->assertNotFound();
        $this->get(route('artists.show', $artist))->assertNotFound();
        $this->get(route('events.show', $event))->assertNotFound();
    }

    public function test_published_detail_pages_use_slug(): void
    {
        $artist = Artist::factory()->create(['name' => 'I Made Contoh']);
        $artwork = Artwork::factory()->for($artist)->create(['title' => 'Tari Kebyar Duduk']);

        $this->assertSame('tari-kebyar-duduk', $artwork->slug);

        $this->get('/karya/tari-kebyar-duduk')->assertOk()->assertSee('I Made Contoh');
        $this->get('/seniman/i-made-contoh')->assertOk()->assertSee('Tari Kebyar Duduk');
    }

    public function test_events_can_be_filtered_by_period(): void
    {
        Event::factory()->create(['title' => 'Pentas Mendatang']);
        Event::factory()->past()->create(['title' => 'Pentas Lampau']);

        $this->get(route('events.index'))->assertSee('Pentas Mendatang')->assertDontSee('Pentas Lampau');
        $this->get(route('events.index', ['waktu' => 'selesai']))->assertSee('Pentas Lampau')->assertDontSee('Pentas Mendatang');
    }

    public function test_invalid_filter_is_rejected(): void
    {
        $this->get(route('artworks.index', ['kategori' => 'tidak-ada']))->assertRedirect();
    }
}
