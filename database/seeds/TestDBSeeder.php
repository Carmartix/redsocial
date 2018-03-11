<?php

use Illuminate\Database\Seeder;

class TestDBSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      
    	factory(App\User::class, 50)->create()->each(function ($u) {
    			
	        $u->profile()->create(['image'=>'../images/user.png']);
	        //bug NI IDEA PORQUE SALTA LOS 8 PRIMEROS USUARIOS

	        for ($i=0; $i < rand(5,25); $i++) { 
		    	$u->feeds()->save(factory(App\Feed::class)->make());
		    }

	        if ( ($u->id % 4 == 0)  ) {
	        	App\Imbox::create([
					'text'		=> 	$u->name . ' quiere ser tu amigo.', 
					'user_id'	=>	1, 
					'user2_id'=> 	$u->id , 
					'status' 	=> 	0
				]);
	        }
            $users = App\User::where('id','!=',$u->id)->inRandomOrder()->take(rand(0,min($u->id -1 , 10)))->get();
            #amigos Directos
            $u->friends()->attach($users->pluck('id'));
            $users->each(function ($us) use ($u) {
                //Amigos Inverso
                $us->friends()->attach($u->id);
            });
	    });

    	//CHECAR BUG FIX PROFILES
    	foreach (App\User::with('profile')->get() as $u) {
    		if (is_null($u->profile)) {
    			$u->delete();
    		}
    	}
    }
}
