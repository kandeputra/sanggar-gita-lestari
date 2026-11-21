<?php

namespace App\Filament\Resources\GalleryItems\Schemas;

use App\Filament\Support\FormFields;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class GalleryItemForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                Section::make('Foto')
                    ->columnSpan(2)
                    ->columns(2)
                    ->schema([
                        FormFields::image('image', 'gallery', 'Foto')
                            ->required()
                            ->columnSpanFull(),
                        TextInput::make('title')
                            ->label('Judul Foto')
                            ->required()
                            ->maxLength(255),
                        Select::make('event_id')
                            ->label('Terkait Kegiatan')
                            ->relationship('event', 'title')
                            ->searchable()
                            ->preload(),
                        TextInput::make('caption')
                            ->label('Keterangan')
                            ->maxLength(255)
                            ->columnSpanFull(),
                    ]),
                Section::make('Publikasi')
                    ->columnSpan(1)
                    ->schema([
                        FormFields::status(),
                        TextInput::make('sort_order')
                            ->label('Urutan Tampil')
                            ->numeric()
                            ->minValue(0)
                            ->default(0),
                    ]),
            ]);
    }
}
