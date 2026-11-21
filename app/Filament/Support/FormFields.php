<?php

namespace App\Filament\Support;

use App\Enums\ContentStatus;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Components\Utilities\Set;
use Illuminate\Support\Str;

/**
 * Komponen form yang dipakai berulang di beberapa Resource.
 */
class FormFields
{
    /**
     * Field judul yang otomatis mengisi slug saat membuat data baru.
     */
    public static function titleWithSlug(string $name = 'title', string $label = 'Judul'): TextInput
    {
        return TextInput::make($name)
            ->label($label)
            ->required()
            ->maxLength(255)
            ->live(onBlur: true)
            ->afterStateUpdated(function (string $operation, ?string $state, Set $set): void {
                if ($operation === 'create') {
                    $set('slug', Str::slug((string) $state));
                }
            });
    }

    public static function slug(): TextInput
    {
        return TextInput::make('slug')
            ->label('Slug URL')
            ->helperText('Otomatis dari judul. Hanya huruf kecil, angka, dan tanda hubung.')
            ->required()
            ->maxLength(255)
            ->alphaDash()
            ->unique(ignoreRecord: true);
    }

    public static function image(string $name, string $directory, string $label = 'Gambar'): FileUpload
    {
        return FileUpload::make($name)
            ->label($label)
            ->image()
            ->imageEditor()
            ->disk('public')
            ->directory($directory)
            ->visibility('public')
            ->maxSize(2048)
            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
            ->helperText('Format JPG/PNG/WebP, maksimal 2 MB.');
    }

    public static function status(): ToggleButtons
    {
        return ToggleButtons::make('status')
            ->label('Status')
            ->options(ContentStatus::class)
            ->default(ContentStatus::Draft)
            ->inline()
            ->required();
    }
}
