<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use App\Enums\UserRolesEnum;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);



        $roles = UserRolesEnum::cases();

        collect($roles)->map(function ($role){
            Role::create([
                'name' => $role
            ]);
        });



        $adminRole = Role::where('name', UserRolesEnum::ADMIN->value)->first();

        $studentRole = Role::where('name', UserRolesEnum::STUDENT->value)->first();

        $admin = User::create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin123')
        ]);

        $admin->assignRole($adminRole);


        $student =  User::create([
            'name' => 'student',
            'email' => 'student@student.com',
            'password' => Hash::make('ariel123')
        ]);


        $student->assignRole($studentRole);

    }
}
