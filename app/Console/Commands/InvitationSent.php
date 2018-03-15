<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class InvitationSent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'invitation:sent 
                                {user_id} : id to send
                                {recived=1} : id to recived';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test for InvitationSent Event from {user_id} to user=1;';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Fire off an event, just randomly grabbing the first user for now
        $u = \App\User::findOrFail($this->argument('user_id'));
        $id =  $this->argument('recived');

        if (!\App\Imbox::where('user_id', $id)->where('user2_id',$u->id)->get()->isEmpty()) {
            $this->error('error invitation sent before');
        } else { 
            $imbox = \App\Imbox::create([
                'text'      =>  $u->name . ' quiere ser tu amigo.', 
                'user_id'   =>  $id, 
                'user2_id'=>    $u->id , 
                'status'    =>  0
            ]);
            broadcast(new \App\Events\InvitationSentEvent(\App\User::find($id), $imbox))->toOthers();
            $this->info('Invitation Send');
        }
    }
}
