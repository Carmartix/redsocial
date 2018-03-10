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
	    for ($i=0; $i < rand(4,9); $i++) { 
	    	$user->feeds()->save(factory(App\Feed::class)->make());
	    }

    	factory(App\User::class, 50)->create()->each(function ($u) use ($user) {
	        $u->profile()->create(['image'=>'../images/user.png']);
	        for ($i=0; $i < rand(4,9); $i++) { 
			    	$u->feeds()->save(factory(App\Feed::class)->make());
			    }
	        if ($u->id % 4 == 0) {
	        	App\Imbox::create([
							'text'		=> 	$u->name . ' quiere ser tu amigo.', 
							'user_id'	=>	$user->id, 
							'user2_id'=> 	$u->id , 
							'status' 	=> 	0
						]);
	        }
	    });
			
    }
}
