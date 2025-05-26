<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TournamentPlayer extends Model
{
	use SoftDeletes;

	protected $table = 'tournament_player';
	protected $primaryKey = 'id';
	protected $fillable = [
		'id_tournament',
		'id_player',
		'horario',
		'P1_TCAR',
		'P1_TENT',
		'P2_TCAR',
		'P2_TENT',
		'R_8',
		'NUM_4',
	];

	public function tournament()
	{
		return $this->belongsTo(Tournament::class, 'id_tournament');
	}

	public function player()
	{
		return $this->belongsTo(Player::class, 'id_player');
	}
}
