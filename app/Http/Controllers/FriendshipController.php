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
		return auth()->user()->friends()->with('profile')->orderBy('created_at','DESC')->paginate(10);
	}

	public function addFriend($id)
	{
		$u =auth()->user();
		if (!Imbox::where('user_id',$id)->where('user2_id',$u->id)->get()->isEmpty()) {
			return response('error invitation sent',403);
		}
		Imbox::create([
			'text'		=> 	$u->name . ' quiere ser tu amigo.', 
			'user_id'	=>	$id , 
			'user2_id'=> 	$u->id , 
			'status' 	=> 	0
		]);
		return response('success');
	}

	  //
	public function destroy(Request $request, $id)
	{
		# eliminar amigo directo 
		auth()->user()->friends()->detach($id);

		//eliminar amigo inverso
		User::find($id)->friends()->detach(auth()->user()->id);
		return response('success');
	}

}
