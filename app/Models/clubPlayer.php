<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class clubPlayer extends Model
{
    use SoftDeletes;
    
    protected $table = 'clubplayer';
	protected $primaryKey = 'id';
	protected $fillable = [
		'name',
	];
}
