<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        $email = config('sanggar.admin.email');

        if (User::query()->where('email', $email)->exists()) {
            $this->command?->info("Super Admin {$email} sudah ada, dilewati.");

            return;
        }

        $password = config('sanggar.admin.password') ?: Str::password(14, symbols: false);

        User::query()->create([
            'name' => config('sanggar.admin.name'),
            'email' => $email,
            'password' => $password,
            'role' => UserRole::SuperAdmin,
            'is_active' => true,
        ]);

        $this->command?->warn("Super Admin dibuat: {$email}");

        if (! config('sanggar.admin.password')) {
            $this->command?->warn("Password sementara: {$password}  (segera ganti setelah login)");
        }
    }
}
