<?php

namespace App\Filament\Resources\Artworks\Tables;

use App\Enums\ContentStatus;
use App\Models\Artwork;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class ArtworksTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')->label('Gambar')->disk('public'),
                TextColumn::make('title')->label('Judul')->searchable()->sortable()->limit(40),
                TextColumn::make('category')
                    ->label('Kategori')
                    ->formatStateUsing(fn (?string $state): string => Artwork::CATEGORIES[$state] ?? (string) $state)
                    ->sortable(),
                TextColumn::make('artist.name')->label('Seniman')->searchable()->toggleable(),
                TextColumn::make('year')->label('Tahun')->sortable()->toggleable(),
                IconColumn::make('is_featured')->label('Unggulan')->boolean(),
                TextColumn::make('status')->badge()->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('status')->options(ContentStatus::class),
                SelectFilter::make('category')->label('Kategori')->options(Artwork::CATEGORIES),
                SelectFilter::make('artist')->label('Seniman')->relationship('artist', 'name')->searchable()->preload(),
                TernaryFilter::make('is_featured')->label('Unggulan'),
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
