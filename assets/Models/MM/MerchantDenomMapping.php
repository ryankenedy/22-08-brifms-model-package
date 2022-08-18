<?php

namespace App\Models\MM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MerchantDenomMapping extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $table = "denom_merchant_mapping_denom";
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'merchant_code',
        'acq_code',
        'feature_code',
        'denom_group_name',
        'denom_code'
    ];

    public function getActionAttribute($value)
    {
        return [
            'delete' => [
                'isCan' => request()->user()->hasPermission('profile-merchant-denom.delete'),
                'link' => route('merchant-denom.destroy',[
                    'merchant'  => $this->merchant,
                    'denom' => $this
                ])
            ]
        ];
    }

    public function acquiring()
    {
        return $this->hasOne(AcquiringMaster::class, 'acquiring_code', 'acq_code')->withDefault([
            'acquiring_code' => null,
            'acquiring_name' => null
        ]);
    }

    public function merchant()
    {
        return $this->hasOne(MerchantMaster::class, 'merchant_code', 'merchant_code')->withDefault([
            'merchant_code' => null,
            'merchant_name' => null
        ]);
    }

    public function denom()
    {
        return $this->hasOne(DenomMaster::class, 'denom_code', 'denom_code')->withDefault([
            'denom_code'  => null,
            'denom_value' => null
        ]);
    }
}
