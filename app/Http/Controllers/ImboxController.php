<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imbox;
use App\User;

class ImboxController extends Controller
{
  /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
	   	$imbox = auth()->user()->imbox;
	   	return ($imbox) ? auth()->user()->imbox()->with('user2.profile')->orderBy('created_at','DESC')->paginate(10) : [] ;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    	# accept Friend
    	$user = auth()->user();
    	$user->friends()->attach($request->user2_id);

    	#amistad inversa
    	User::find($request->user2_id)->friends()->attach($user->id);

    	#eliminar notificacion de Imbox
    	Imbox::destroy($request->id);
    	return response('success');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      return Imbox::with('user2.profile')->findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(FeedForm $request, $id)
    {
    	return response(null);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    	Imbox::destroy($id);
    	return response('success');
    }

}
