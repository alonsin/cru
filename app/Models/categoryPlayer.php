<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class categoryPlayer extends Model
{
    use SoftDeletes;

	protected $table = 'categoryplayer';
	protected $primaryKey = 'id';
	protected $fillable = [
		'name',
	];
}
