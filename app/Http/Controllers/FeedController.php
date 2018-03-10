<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Feed;
use App\User;
use App\Http\Requests\FeedForm;

class FeedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = auth()->user()->friends->pluck('id'); //amigos
        $users->push(auth()->user()->id); //propias
      	return Feed::with('user.profile')->whereIn('user_id', $users)->orderBy('created_at','DESC')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FeedForm $request)
    {
    	$feed = auth()->user()->feeds()->create($request->all());
    	return $feed;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      return Feed::with('user.profile')->findOrFail($id);
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
    	Feed::destroy($id);
    	return response('success');
    }

    public function showUserFeeds(User $user)
    {
        return $user->feeds()->with('user.profile')->get();
    }
}
