<?php

namespace App\Filament\Resources\Events\Tables;

use App\Enums\ContentStatus;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class EventsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')->label('Poster')->disk('public'),
                TextColumn::make('title')->label('Kegiatan')->searchable()->sortable()->limit(40),
                TextColumn::make('starts_at')->label('Tanggal')->dateTime('d M Y, H:i')->sortable(),
                TextColumn::make('location')->label('Lokasi')->searchable()->limit(30)->toggleable(),
                TextColumn::make('gallery_items_count')->label('Foto')->counts('galleryItems'),
                TextColumn::make('status')->badge()->sortable(),
            ])
            ->defaultSort('starts_at', 'desc')
            ->filters([
                SelectFilter::make('status')->options(ContentStatus::class),
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
