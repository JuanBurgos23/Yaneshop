<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear roles si no existen
        Role::firstOrCreate(['name' => 'admin']);
        Role::firstOrCreate(['name' => 'cliente']);

        // Crear usuario admin si no existe
        $admin = User::where('email', 'admin@gmail.com')->first();

        if (!$admin) {
            $admin = User::create([
                'name' => 'Administrador',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('admin1234'), // ⚠️ cámbialo después
            ]);
        }

        // Asignar rol admin
        if (!$admin->hasRole('admin')) {
            $admin->assignRole('admin');
        }
    
    }
}
