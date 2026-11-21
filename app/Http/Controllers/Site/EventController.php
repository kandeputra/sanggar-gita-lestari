<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Requests\EventFilterRequest;
use App\Models\Event;
use Illuminate\View\View;

class EventController extends Controller
{
    public function index(EventFilterRequest $request): View
    {
        $period = $request->period();

        $events = Event::query()
            ->published()
            ->when($period === 'selesai', fn ($query) => $query->past(), fn ($query) => $query->upcoming())
            ->paginate(9)
            ->withQueryString();

        return view('site.events.index', compact('events', 'period'));
    }

    public function show(Event $event): View
    {
        abort_unless($event->isPublished(), 404);

        return view('site.events.show', [
            'event' => $event,
            'photos' => $event->galleryItems()->published()->orderBy('sort_order')->get(),
        ]);
    }
}
