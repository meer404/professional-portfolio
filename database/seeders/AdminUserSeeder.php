<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $email = 'mirmohammedrashid@gmail.com';

        if (User::where('email', $email)->exists()) {
            $this->command?->info("Admin user {$email} already exists — leaving password unchanged.");

            return;
        }

        $password = Str::password(16, symbols: false);

        User::create([
            'name' => 'Mir Mohammed',
            'email' => $email,
            'password' => Hash::make($password),
            'email_verified_at' => now(),
        ]);

        $line = str_repeat('=', 54);
        $this->command?->warn($line);
        $this->command?->warn('  ADMIN LOGIN  —  save this now, it is not shown again');
        $this->command?->warn("  URL:      /admin");
        $this->command?->warn("  Email:    {$email}");
        $this->command?->warn("  Password: {$password}");
        $this->command?->warn($line);
    }
}
