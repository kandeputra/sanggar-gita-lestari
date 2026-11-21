<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Enums\UserRole;
use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Validation\Rules\Password;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Akun Pengguna')
                    ->columns(2)
                    ->columnSpanFull()
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                        TextInput::make('password')
                            ->label('Password')
                            ->password()
                            ->revealable()
                            ->rule(Password::min(8)->letters()->numbers())
                            ->required(fn (string $operation): bool => $operation === 'create')
                            ->dehydrated(fn (?string $state): bool => filled($state))
                            ->helperText(fn (string $operation): ?string => $operation === 'edit'
                                ? 'Kosongkan bila tidak ingin mengganti password.'
                                : 'Minimal 8 karakter, kombinasi huruf dan angka.'),
                        Select::make('role')
                            ->label('Role')
                            ->options(UserRole::class)
                            ->default(UserRole::Admin)
                            ->required()
                            ->native(false)
                            // Super Admin tidak bisa menurunkan role dirinya sendiri.
                            ->disabled(fn (?User $record): bool => $record?->is(auth()->user()) ?? false),
                        Toggle::make('is_active')
                            ->label('Akun Aktif')
                            ->helperText('Akun nonaktif tidak bisa login ke dashboard.')
                            ->default(true)
                            ->disabled(fn (?User $record): bool => $record?->is(auth()->user()) ?? false),
                    ]),
            ]);
    }
}
