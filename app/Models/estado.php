<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class estado extends Model
{
    use SoftDeletes;
    protected $table = 'estado';
	protected $primaryKey = 'id';
	protected $fillable = [
		'name',
	];
}
