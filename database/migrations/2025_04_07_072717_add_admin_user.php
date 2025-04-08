<?php

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;

class AddAdminUser extends Migration
{
    public function up()
    {
        $adminRole = Role::firstOrCreate([
            'role_name' => 'admin',
            'description' => 'Administrator role with full permissions.',
        ]);

        // Insert the 'user' role into the roles table (optional, if not already inserted)
        $userRole = Role::firstOrCreate([
            'role_name' => 'user',
            'description' => 'Regular user role with limited permissions.',
        ]);
        User::create([
            'full_name' => 'Admin',
            'email' => 'admin@gmail.com',
            'nominated_password' => Hash::make('admin123'),
            'confirmed_password' => Hash::make('admin123'),
            'role_id' => $adminRole->id,
        ]);
    }

    public function down()
    {
        User::where('email', 'admin@gmail.com')->delete();
    }
}
