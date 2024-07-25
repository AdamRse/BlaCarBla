<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateCustomFilamentUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-custom-filament-user';
 
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $fname = $this->ask('firstname');
        $lname = $this->ask('lastname');
        $email = $this->ask('Email');
        $password = $this->secret('Password');

        $user = User::create([
            'firstname' => $fname,
            'lastname' => $lname,
            'email' => $email,
            'password' => Hash::make($password),
            'role_id' => 1,
            // Ajoutez ici les autres champs
        ]);

        $user->assignRole(1); // Assurez-vous d'utiliser le bon rôle

        $this->info('Admin user created successfully.');
    }
}
