<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tournament extends Model
{
	use SoftDeletes;

	protected $table = 'tournament';
	protected $primaryKey = 'id';
	protected $fillable = [
		'name_tournament',
		'id_sede',
		'id_type',
		'id_format',
		'fecha_torneo',
	];
}
