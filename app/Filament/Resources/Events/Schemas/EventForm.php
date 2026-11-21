<?php

namespace App\Filament\Resources\Events\Schemas;

use App\Filament\Support\FormFields;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class EventForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                Section::make('Detail Kegiatan')
                    ->columnSpan(2)
                    ->columns(2)
                    ->schema([
                        FormFields::titleWithSlug('title', 'Nama Kegiatan'),
                        FormFields::slug(),
                        DateTimePicker::make('starts_at')
                            ->label('Mulai')
                            ->seconds(false)
                            ->required(),
                        DateTimePicker::make('ends_at')
                            ->label('Selesai')
                            ->seconds(false)
                            ->afterOrEqual('starts_at'),
                        TextInput::make('location')
                            ->label('Lokasi')
                            ->maxLength(255)
                            ->columnSpanFull(),
                        Textarea::make('excerpt')
                            ->label('Ringkasan')
                            ->rows(3)
                            ->maxLength(500)
                            ->columnSpanFull(),
                        RichEditor::make('body')
                            ->label('Deskripsi Lengkap')
                            ->columnSpanFull(),
                    ]),
                Section::make('Publikasi')
                    ->columnSpan(1)
                    ->schema([
                        FormFields::status(),
                        FormFields::image('image', 'events', 'Poster / Foto Utama'),
                    ]),
            ]);
    }
}
