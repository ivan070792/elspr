<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateUser extends Command
{
    protected $signature = 'user:create';
    protected $description = 'Create a new user';

    public function handle()
    {
        $name = $this->ask('Enter the user\'s name');
        $email = $this->ask('Enter the user\'s email address');
        $password = $this->secret('Enter the user\'s password');

        // Проверка уникальности email
        if (User::where('email', $email)->exists()) {
            $this->error('A user with this email already exists.');
            return;
        }

        // Создание пользователя
        User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        $this->info('User created successfully!');
    }
}
