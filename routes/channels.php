<?php

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('notifications.{imboxId}', function ($user, $imboxId) {
    return $user->id === Imbox::findOrFail($imboxId)->user_id;
});

Broadcast::channel('invitations.{invitationId}', function ($user, $invitationId)
{
	#if ($user->id === Imbox::findOrFail($invitationId)->user_id) {
		# code...
		return Auth::user();
	#}
	
});