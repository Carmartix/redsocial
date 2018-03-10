<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Imbox extends Model
{
    //
	protected $fillable = [
		'status',
		'text',
		'user_id', //receptor
		'user2_id', //solicitante
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function user2()
	{
		return $this->belongsTo(User::class, 'user2_id');
	}
}
