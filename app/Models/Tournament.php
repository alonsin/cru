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
		'status',
	];


	public function type()
	{
		return $this->belongsTo(TypeTournament::class, 'id_type');
	}

	public function sede()
	{
		return $this->belongsTo(SedeTournament::class, 'id_sede');
	}
}
