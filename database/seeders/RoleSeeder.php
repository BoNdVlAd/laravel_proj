<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = new Role();
        $admin->name = 'Manager';
        $admin->slug = 'manager';
        $admin->save();

        $customer = new Role();
        $customer->name = 'Waiter';
        $customer->slug = 'waiter';
        $customer->save();

        $guest = new Role();
        $guest->name = 'Chef';
        $guest->slug = 'chef';
        $guest->save();

        $guest = new Role();
        $guest->name = 'Customer';
        $guest->slug = 'customer';
        $guest->save();
    }
}
