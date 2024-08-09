<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $developer = Role::where('slug','manager')->first();
        $manager = Role::where('slug', 'customer')->first();
        $createTasks = Permission::where('slug','create-tasks')->first();
        $manageUsers = Permission::where('slug','manage-users')->first();

        $user1 = new User();
        $user1->name = 'Jhon Deo';
        $user1->email = 'jhon@deo.com';
        $user1->password = bcrypt('secret');
        $user1->save();
        $user1->roles()->attach($developer);
        $user1->permissions()->attach($createTasks);

        $user2 = new User();
        $user2->name = 'Mike Thomas';
        $user2->email = 'mike@thomas.com';
        $user2->password = bcrypt('secret');
        $user2->save();
        $user2->roles()->attach($manager);
        $user2->permissions()->attach($manageUsers);

        $user = User::find(1);
        $gallery = $user->gallery()->create();
        $gallery->media()->create([
            'filename' => 'photo.jpg',
            'mime_type' => 'image/jpeg',
            'size' => 200,
            'url' => 'http://example.com/photo.jpg',
        ]);

        $gallery->media()->create([
            'filename' => 'photo123.jpg',
            'mime_type' => 'image123/jpeg',
            'size' => 300,
            'url' => 'http://example.com/photo123.jpg',
        ]);


    }
}
