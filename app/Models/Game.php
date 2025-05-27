<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Game extends Model
{
	use SoftDeletes;

	protected $table = 'games';
	protected $primaryKey = 'id';
	protected $fillable = [
		'id_tournament',
		'mesa',
		'CP1',
		'p1',
		'wp1',
		'p2',
		'wp2',
		'CP2',
		'ronda',
		'estatus',
	];
}
