<?php

namespace App\Models\Commons;

use App\Traits\Configurations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CepCities extends Model
{
    use SoftDeletes;
    public $timestamps = true;
    protected $fillable = [
        'idstate',
        'name',
        'short_name',
    ];

    static public function getAlltoSelectList(array $fields = ['id', 'description'])
    {
        return self::get()->map(function ($s) use ($fields) {
            return [
                'id' => $s->{$fields[0]},
                'description' => $s->{$fields[1]}
            ];
        })->pluck('description', 'id');
    }

    public function state()
    {
        return $this->belongsTo(CepStates::class, 'idstate');
    }
}
