<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $user = DB::table('users')->insert([
        //     'name' => 'Superadmin',
        //     'email' => 'superadmin@gmail.com',
        //     'password' => bcrypt('123456789'),
        // ]);

        // $user->attachRole('superadministrator');

        factory(App\User::class, 1)->create()->each(function ($user) {
            $user->attachRole('superadministrator');
        });
    }
}
