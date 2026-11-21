<?php

namespace App\Filament\Widgets;

use App\Models\Artist;
use App\Models\Artwork;
use App\Models\Event;
use App\Models\GalleryItem;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ContentStatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Seniman', Artist::query()->count())
                ->description(Artist::query()->published()->count().' dipublikasikan')
                ->icon(Heroicon::OutlinedUserGroup),
            Stat::make('Karya Seni', Artwork::query()->count())
                ->description(Artwork::query()->published()->count().' dipublikasikan')
                ->icon(Heroicon::OutlinedMusicalNote),
            Stat::make('Kegiatan Mendatang', Event::query()->published()->upcoming()->count())
                ->description(Event::query()->count().' total kegiatan')
                ->icon(Heroicon::OutlinedCalendarDays),
            Stat::make('Foto Galeri', GalleryItem::query()->count())
                ->description(GalleryItem::query()->published()->count().' dipublikasikan')
                ->icon(Heroicon::OutlinedPhoto),
        ];
    }
}
