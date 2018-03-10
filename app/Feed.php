<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Feed extends Model
{
	use SoftDeletes;
	//
	protected $fillable = [
		//'user_id',
		'content',
		'status',
		'likes',
		'image'
	];

  /**
   * The attributes that should be mutated to dates.
   *
   * @var array
   */
  protected $dates = ['deleted_at'];

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
