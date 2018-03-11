<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
    	$user = App\User::create(['name' => 'Admin', 'ci' => 12345678, 'email' => 'admin@admin.org', 'password' => bcrypt('secret')]);
	    $user->profile()->create(['image'=>'../images/user.png']);
	    for ($i=0; $i < rand(4,20); $i++) { 
	    	$user->feeds()->save(factory(App\Feed::class)->make());
	    }

	    $this->call(TestDBSeeder::class);
    }
}
