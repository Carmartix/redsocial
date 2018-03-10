<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Image;
use Carbon\Carbon;

class ProfileController extends Controller
{
   
  public function show(Request $request, $id = null)
  {
  	if (is_null($id) && $request->wantsJson()) {
  		# Perfil Personal
			return auth()->user()->load('profile');
  	} else if ($request->wantsJson()) {
  		# Perfil de Otro
			return User::with('profile')->findOrFail($id);
  	}
  	return view('user')->with('id',$id);
	}

	public function update(Request $request)
	{
		# solo se puede actualizar el perfil del user logeado
		$user = auth()->user();
		$user->name = $request->name;
		$user->save();
		$user->profile->country = $request->profile['country'];
		$user->profile->city = $request->profile['city'];
		$user->profile->bio = $request->profile['bio'];
		$user->profile->phone = $request->profile['phone'];
		$user->profile->address = $request->profile['address'];

		if ($request->get('image') != $user->profile->image ) {
			$imageData = $request->get('image');
      $fileName = Carbon::now()->timestamp . '_' . uniqid() . '.' . explode('/', explode(':', substr($imageData, 0, strpos($imageData, ';')))[1])[1];
      Image::make($request->get('image'))->save(public_path('images/users/').$fileName);
      $user->profile->image = '../images/users/' . $fileName;
    }
		$user->profile->save();
		return $user;
	}
}
