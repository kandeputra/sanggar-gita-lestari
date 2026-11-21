<?php

namespace App\Filament\Resources\GalleryItems\Tables;

use App\Enums\ContentStatus;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class GalleryItemsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')->label('Foto')->disk('public')->imageHeight(64),
                TextColumn::make('title')->label('Judul')->searchable()->sortable(),
                TextColumn::make('event.title')->label('Kegiatan')->limit(30)->toggleable(),
                TextColumn::make('sort_order')->label('Urutan')->sortable(),
                TextColumn::make('status')->badge()->sortable(),
            ])
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->filters([
                SelectFilter::make('status')->options(ContentStatus::class),
                SelectFilter::make('event')->label('Kegiatan')->relationship('event', 'title')->searchable()->preload(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
