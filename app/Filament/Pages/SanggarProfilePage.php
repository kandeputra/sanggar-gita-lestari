<?php

namespace App\Filament\Pages;

use App\Services\SanggarProfileService;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Schema;

/**
 * Basis halaman "singular record" untuk tabel sanggar_profiles.
 * Turunan cukup menentukan komponen form & kolom yang boleh disimpan.
 *
 * @property-read Schema $form
 */
abstract class SanggarProfilePage extends Page
{
    protected string $view = 'filament.pages.sanggar-profile';

    /**
     * @var array<string, mixed>|null
     */
    public ?array $data = [];

    /**
     * @return array<int, \Filament\Schemas\Components\Component|\Filament\Forms\Components\Field>
     */
    abstract protected function formComponents(): array;

    /**
     * @return list<string>
     */
    abstract protected function allowedFields(): array;

    public function mount(SanggarProfileService $profiles): void
    {
        $this->form->fill($profiles->record()->only($this->allowedFields()));
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Form::make($this->formComponents())
                    ->livewireSubmitHandler('save')
                    ->footer([
                        Actions::make([
                            Action::make('save')
                                ->label('Simpan Perubahan')
                                ->submit('save')
                                ->keyBindings(['mod+s']),
                        ]),
                    ]),
            ])
            ->record(app(SanggarProfileService::class)->record())
            ->statePath('data');
    }

    public function save(): void
    {
        abort_unless(static::canAccess(), 403);

        app(SanggarProfileService::class)->update($this->form->getState(), $this->allowedFields());

        Notification::make()
            ->success()
            ->title('Perubahan berhasil disimpan')
            ->send();
    }
}
