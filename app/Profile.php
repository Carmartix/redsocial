<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    //
	protected $fillable = [
		'image',
		'phone',
		'address',
		'bio',
		'country',
		'city',
		'user_id',
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
