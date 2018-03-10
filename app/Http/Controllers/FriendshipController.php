<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Imbox;

class FriendshipController extends Controller
{
    //
	public function showFriends(Request $request)
	{
		return auth()->user()->friends->load('profile');
	}

	public function addFriend($id)
	{
		$u =auth()->user();
		Imbox::create([
			'text'		=> 	$u->name . ' quiere ser tu amigo.', 
			'user_id'	=>	$id , 
			'user2_id'=> 	$u->id , 
			'status' 	=> 	0
		]);
		return response('sucess');
	}
}
