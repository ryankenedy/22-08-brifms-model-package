<?php

namespace App\Models\MM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreDenomMapping extends Model
{
    use HasFactory;
    protected $connection = 'mysql';
    protected $table = "denom_store_mapping_denom";
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'merchant_code',
        'store_code',
        'acq_code',
        'feature_code',
        'denom_group_name',
        'denom_code'
    ];

    public function getActionAttribute($value)
    {
        return [
            'delete' => [
                'isCan' => request()->user()->hasPermission('profile-store-denom.delete'),
                'link' => route('store-denom.destroy',[
                    'store'  => $this->store,
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
            'merchant_name'  => null
        ]);
    }

    public function denom()
    {
        return $this->hasOne(DenomMaster::class, 'denom_code', 'denom_code')->withDefault([
            'denom_code' => null,
            'denom_name'  => null
        ]);
    }

    public function store()
    {
        return $this->hasOne(StoreMaster::class, 'store_code', 'store_code')->withDefault([
            'store_code' => null,
            'store_name'  => null
        ]);
    }
}
