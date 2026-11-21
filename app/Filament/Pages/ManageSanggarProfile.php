<?php

namespace App\Filament\Pages;

use App\Filament\Support\FormFields;
use App\Models\SanggarProfile;
use BackedEnum;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Gate;
use UnitEnum;

class ManageSanggarProfile extends SanggarProfilePage
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingLibrary;

    protected static string|UnitEnum|null $navigationGroup = 'Konten';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationLabel = 'Profil Sanggar';

    protected static ?string $title = 'Profil Sanggar';

    protected static ?string $slug = 'profil-sanggar';

    public static function canAccess(): bool
    {
        return Gate::allows('manage-content');
    }

    protected function allowedFields(): array
    {
        return SanggarProfile::PROFILE_FIELDS;
    }

    protected function formComponents(): array
    {
        return [
            Section::make('Identitas')
                ->columns(2)
                ->schema([
                    TextInput::make('name')->label('Nama Sanggar')->required()->maxLength(255),
                    TextInput::make('tagline')->label('Tagline')->maxLength(255),
                    TextInput::make('founded_year')
                        ->label('Tahun Berdiri')
                        ->numeric()
                        ->minValue(1901)
                        ->maxValue((int) date('Y')),
                    Textarea::make('short_description')
                        ->label('Deskripsi Singkat (tampil di beranda)')
                        ->rows(3)
                        ->maxLength(600)
                        ->columnSpanFull(),
                ]),
            Section::make('Sejarah, Visi & Misi')
                ->schema([
                    RichEditor::make('history')->label('Sejarah Sanggar'),
                    Textarea::make('vision')->label('Visi')->rows(3),
                    Textarea::make('mission')
                        ->label('Misi')
                        ->rows(5)
                        ->helperText('Tulis satu misi per baris.'),
                ]),
            Section::make('Pimpinan / Pendiri')
                ->columns(2)
                ->schema([
                    TextInput::make('leader_name')->label('Nama')->maxLength(255),
                    TextInput::make('leader_title')->label('Jabatan')->placeholder('Contoh: Pendiri & Ketua Sanggar')->maxLength(255),
                    FormFields::image('leader_photo', 'profile', 'Foto'),
                    Textarea::make('leader_message')->label('Sambutan')->rows(6),
                ]),
            Section::make('Identitas Visual')
                ->columns(3)
                ->schema([
                    FormFields::image('logo', 'profile', 'Logo'),
                    FormFields::image('script_image', 'profile', 'Nama dalam Aksara Bali')
                        ->acceptedFileTypes(['image/png', 'image/webp'])
                        ->helperText('PNG/WebP latar transparan, maksimal 2 MB.'),
                    FormFields::image('hero_image', 'profile', 'Gambar Latar Beranda'),
                ]),
        ];
    }
}
