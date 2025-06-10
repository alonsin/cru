<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class typeTournament extends Model
{
	use SoftDeletes;

	protected $table = 'type_tournament';
	protected $primaryKey = 'id';
	protected $fillable = [
		'name',
	];

	
	const ABIERTO_MENSUAL_PROMEDIOS = 1;
	const REGIONAL = 9;
	

	public function tournaments()
	{
		return $this->hasMany(Tournament::class, 'id_type');
	}
}
