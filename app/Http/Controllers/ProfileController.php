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
  	if (is_null($id)) {
  		if ($request->wantsJson()) {
  			# no hay usuario y es peticion JSON
				return auth()->user()->load('profile');
  		} else {
  			# no hay usuario y no es JSON //NO EXISTE
  			abort(404);
  		}
  	} else {
  		$user = User::findOrFail($id);
  		# *** Perfil de USUARIO ***
			if ($request->wantsJson()) {
  			# USUARIO y es peticion JSON
				return $user->load('profile');
  		} else if ($user) {
  			# no hay usuario y no es JSON //NO EXISTE
  			return view('user')->with('id', $user->id);
  		}
  	}
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
