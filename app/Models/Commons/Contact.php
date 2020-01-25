<?php

namespace App\Models\Commons;

use App\Helpers\DataHelper;
use App\Models\Clients\Client;
use App\Models\Suppliers\Supplier;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use SoftDeletes;
    public $timestamps = true;
    protected $fillable = [
        'phone',
        'cellphone',
    ];

    public function setPhoneAttribute($value)
    {
        return $this->attributes['phone'] = DataHelper::getOnlyNumbers($value);
    }

    public function setCellphoneAttribute($value)
    {
        return $this->attributes['cellphone'] = DataHelper::getOnlyNumbers($value);
    }

    public function getFormatedPhone()
    {
        return DataHelper::mask($this->attributes['phone'], '(##)####-####');
    }

    public function getFormatedCellphone()
    {
        return DataHelper::mask($this->attributes['cellphone'], '(##)#####-####');
    }

    public function getCreatedAtAttribute($value)
    {
        return DataHelper::getPrettyDateTime($value);
    }

    // ******************** RELASHIONSHIP ******************************
    public function client()
    {
        return $this->belongsTo(Client::class, 'contact_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'contact_id');
    }

}
