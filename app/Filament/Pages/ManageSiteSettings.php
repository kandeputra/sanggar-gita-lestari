<?php

namespace App\Filament\Pages;

use App\Models\SanggarProfile;
use BackedEnum;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Gate;
use UnitEnum;

class ManageSiteSettings extends SanggarProfilePage
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static string|UnitEnum|null $navigationGroup = 'Sistem';

    protected static ?int $navigationSort = 20;

    protected static ?string $navigationLabel = 'Pengaturan Situs';

    protected static ?string $title = 'Pengaturan Situs';

    protected static ?string $slug = 'pengaturan';

    /**
     * Pengaturan situs hanya untuk Super Admin.
     */
    public static function canAccess(): bool
    {
        return Gate::allows('manage-settings');
    }

    protected function allowedFields(): array
    {
        return SanggarProfile::SETTING_FIELDS;
    }

    protected function formComponents(): array
    {
        return [
            Section::make('Kontak')
                ->columns(2)
                ->schema([
                    TextInput::make('phone')->label('Telepon')->tel()->maxLength(30),
                    TextInput::make('whatsapp')->label('WhatsApp')->tel()->placeholder('08xxxxxxxxxx')->maxLength(30),
                    TextInput::make('email')->label('Email')->email()->maxLength(255),
                    TextInput::make('address')->label('Alamat')->maxLength(255),
                    Textarea::make('maps_embed_url')
                        ->label('URL Embed Google Maps')
                        ->helperText('Google Maps → Bagikan → Sematkan peta → salin hanya nilai src="..." (diawali https://www.google.com/maps/embed).')
                        ->rows(2)
                        ->startsWith(['https://www.google.com/maps/embed'])
                        ->columnSpanFull(),
                ]),
            Section::make('Media Sosial')
                ->columns(2)
                ->schema([
                    TextInput::make('instagram_url')->label('Instagram')->url()->maxLength(255),
                    TextInput::make('facebook_url')->label('Facebook')->url()->maxLength(255),
                    TextInput::make('youtube_url')->label('YouTube')->url()->maxLength(255),
                    TextInput::make('tiktok_url')->label('TikTok')->url()->maxLength(255),
                ]),
            Section::make('SEO')
                ->schema([
                    Textarea::make('meta_description')
                        ->label('Meta Description')
                        ->helperText('Deskripsi singkat untuk hasil pencarian Google (maks. 300 karakter).')
                        ->rows(3)
                        ->maxLength(300),
                ]),
        ];
    }
}
