<?php

namespace App\Models\Commons;

use App\Helpers\DataHelper;
use App\Models\Clients\Client;
use App\Models\Clients\Unit;
use App\Models\Suppliers\Supplier;
use App\Models\Users\Collaborator;
use App\Traits\AddressTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    use SoftDeletes;
    use AddressTrait;
    public $timestamps = true;
    protected $fillable = [
        'state_id',
        'city_id',
        'zip',
        'state',
        'city',
        'district',
        'street',
        'number',
        'complement'
    ];

    // ******************** RELASHIONSHIP ******************************

    public function state()
    {
        return $this->belongsTo(CepStates::class, 'state_id');
    }

    public function city()
    {
        return $this->belongsTo(CepCities::class, 'city_id', 'id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'address_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'address_id');
    }

    public function collaborator()
    {
        return $this->belongsTo(Collaborator::class, 'address_id');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'address_id');
    }
}
