<?php

namespace App\Filament\Resources\Users\Tables;

use App\Enums\UserRole;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Nama')->searchable()->sortable(),
                TextColumn::make('email')->label('Email')->searchable(),
                TextColumn::make('role')->label('Role')->badge()->sortable(),
                IconColumn::make('is_active')->label('Aktif')->boolean(),
                TextColumn::make('created_at')->label('Dibuat')->date('d M Y')->sortable(),
            ])
            ->defaultSort('name')
            ->filters([
                SelectFilter::make('role')->options(UserRole::class),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(), // tersembunyi otomatis untuk akun sendiri (UserPolicy::delete)
            ]);
    }
}
