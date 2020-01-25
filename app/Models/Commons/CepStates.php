<?php

namespace App\Models\Commons;

use App\Traits\Configurations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CepStates extends Model
{
    use SoftDeletes;
    public $timestamps = true;
    protected $fillable = [
        'name',
        'short_name',
    ];

    static public function getAlltoSelectList(array $fields = ['id', 'description'])
    {
        return self::get()->map(function ($s) use ($fields) {
            return [
                'id' => $s->{$fields[0]},
                'description' => $s->name . " (" . $s->short_name . ")"
            ];
        })->pluck('description', 'id');
    }

	public function cities()
	{
		return $this->hasMany(CepCities::class, 'idstate');
	}
}
