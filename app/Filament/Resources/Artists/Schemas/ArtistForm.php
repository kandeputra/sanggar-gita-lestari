<?php

namespace App\Filament\Resources\Artists\Schemas;

use App\Filament\Support\FormFields;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ArtistForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                Section::make('Data Seniman')
                    ->columnSpan(2)
                    ->columns(2)
                    ->schema([
                        FormFields::titleWithSlug('name', 'Nama Seniman'),
                        FormFields::slug(),
                        TextInput::make('specialty')
                            ->label('Keahlian / Peran')
                            ->placeholder('Contoh: Penari, Penabuh Kendang, Pelatih Tari')
                            ->maxLength(255),
                        TextInput::make('sort_order')
                            ->label('Urutan Tampil')
                            ->numeric()
                            ->minValue(0)
                            ->default(0),
                        Textarea::make('bio')
                            ->label('Biografi Singkat')
                            ->rows(6)
                            ->maxLength(3000)
                            ->columnSpanFull(),
                    ]),
                Section::make('Publikasi')
                    ->columnSpan(1)
                    ->schema([
                        FormFields::status(),
                        FormFields::image('photo', 'artists', 'Foto')
                            ->imageAspectRatio('3:4')
                            ->automaticallyCropImagesToAspectRatio(),
                    ]),
            ]);
    }
}
