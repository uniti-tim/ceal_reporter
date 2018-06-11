<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      User::truncate();
      //make admin
      User::create([
        'name' => 'Reporter',
        'email' => 'ceal_reporter@uniti.com',
        'password' => bcrypt('hello'),
      ]);

    }
}
