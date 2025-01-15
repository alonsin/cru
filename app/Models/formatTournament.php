<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class formatTournament extends Model
{
	use SoftDeletes;

	protected $table = 'format_tournament';
	protected $primaryKey = 'id';
	protected $fillable = [
		'name',
	];
}
