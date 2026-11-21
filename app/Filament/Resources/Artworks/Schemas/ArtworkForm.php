<?php

namespace App\Filament\Resources\Artworks\Schemas;

use App\Filament\Support\FormFields;
use App\Models\Artwork;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ArtworkForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                Section::make('Detail Karya')
                    ->columnSpan(2)
                    ->columns(2)
                    ->schema([
                        FormFields::titleWithSlug('title', 'Judul Karya'),
                        FormFields::slug(),
                        Select::make('category')
                            ->label('Kategori')
                            ->options(Artwork::CATEGORIES)
                            ->required()
                            ->native(false),
                        Select::make('artist_id')
                            ->label('Seniman / Pencipta')
                            ->relationship('artist', 'name')
                            ->searchable()
                            ->preload(),
                        TextInput::make('year')
                            ->label('Tahun Cipta')
                            ->numeric()
                            ->minValue(1901)
                            ->maxValue((int) date('Y') + 1),
                        TextInput::make('video_url')
                            ->label('Tautan Video (YouTube)')
                            ->url()
                            ->maxLength(255),
                        Textarea::make('excerpt')
                            ->label('Ringkasan')
                            ->rows(3)
                            ->maxLength(500)
                            ->columnSpanFull(),
                        RichEditor::make('description')
                            ->label('Deskripsi Lengkap')
                            ->columnSpanFull(),
                    ]),
                Section::make('Publikasi')
                    ->columnSpan(1)
                    ->schema([
                        FormFields::status(),
                        Toggle::make('is_featured')
                            ->label('Tampilkan di Beranda'),
                        FormFields::image('image', 'artworks'),
                    ]),
            ]);
    }
}
