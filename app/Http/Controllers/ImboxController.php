<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imbox;

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
	   	return ($imbox) ? $imbox->load('user2.profile') : [] ;
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
    	auth()->user()->friends()->attach($request->user2_id);
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
    	$feed = Feed::findOrFail($id)->fill($request->all());
        $feed->save();
    	return $feed;
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

    public function showUserFeeds(User $user)
    {
        return $user->feeds()->with('user.profile')->get();
    }
}
