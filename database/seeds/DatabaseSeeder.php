<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
	    	$this->call('UserTableSeeder');
        $this->command->info('User table seeded!');

        // $this->call(UsersTableSeeder::class);
    }
}

class UserTableSeeder extends Seeder {

    public function run()
    {
        DB::table('users')->delete();

	    	App\User::create([
						'name' => "Ahmed Haseeb",
			      'email' => "me@ahmedhaseeb.com",
			      'password' => Hash::make("12345678"),
			      'role' => "admin"
	    	]);
        App\User::create([
						'name' => "Ahmed Haseeb",
			      'email' => "hi@ahmedhaseeb.com",
			      'password' => Hash::make("12345678"),
			      'role' => "student"
	    	]);
    }

}