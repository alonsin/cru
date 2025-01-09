<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Player extends Model
{
    use SoftDeletes;
    protected $table = 'players';
    protected $fillable = [
        'name_player', 
        'id_state', 
        'id_category_player', 
        'id_club_player', 
        'edad'
    ];

    public function state()
    {
        return $this->belongsTo(estado::class, 'id_state');
    }

    public function category()
    {
        return $this->belongsTo(categoryPlayer::class, 'id_category_player');
    }

    public function club()
    {
        return $this->belongsTo(clubPlayer::class, 'id_club_player');
    }
}
