<?php

namespace App\Providers;

use App\Models\User;
use App\Services\SanggarProfileService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(SanggarProfileService::class);
    }

    public function boot(): void
    {
        // Cegah lazy loading (N+1) saat development agar eager loading selalu dipakai.
        Model::preventLazyLoading(! $this->app->isProduction());

        $this->registerGates();

        // Bagikan profil sanggar ke seluruh layout website publik.
        View::composer(['components.layouts.site', 'site.*'], function ($view): void {
            $view->with('profile', app(SanggarProfileService::class)->get());
        });
    }

    private function registerGates(): void
    {
        Gate::define('manage-content', fn (User $user): bool => $user->canManageContent());
        Gate::define('manage-users', fn (User $user): bool => $user->isSuperAdmin());
        Gate::define('manage-settings', fn (User $user): bool => $user->isSuperAdmin());
    }
}
