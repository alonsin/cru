<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class sedeTournament extends Model
{
	use SoftDeletes;

	protected $table = 'sede_tournament';
	protected $primaryKey = 'id';
	protected $fillable = [
		'name',
	];
}
