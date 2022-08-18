<?php

namespace App\Models\MM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreDiscountMaster extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $table = "new_discount_store";
    protected $primaryKey = 'id';
    public $timestamps = false;

    CONST TYPE_ARRAY = [
        'flat_percentage'   => 'flat_percentage',
        'flat'              => 'flat',
        'percentage'        => 'percentage',
        // 'percentage_max'    => 'percentage_max',
        // 'percentage_min'    => 'percentage_min',
        // 'max_discount'      => 'max_discount',
        // 'min_payment'       => 'min_payment',
    ]; 

    protected $fillable = [
        'id_discount',
        'discount_name',
        'merchant_code',
        'acquiring_code',
        'store_code',
        'discount_value', //as persen discount
        'discount_limit', //as max discount
        'minimum_payment', //as min discount
        'type', 
        'version',
        'is_active',
        'expired_date',
        'created_date'
    ];

    protected $appends = ['active'];

    public function getActionAttribute($value)
    {
        return [
            'edit' => [
                'isCan' => request()->user()->hasPermission('profile-store-discount.edit'),
                'link' => route('store-discount.edit',[
                    'store'  => $this->store,
                    'discount' => $this
                ])
            ],
            'delete' => [
                'isCan' => request()->user()->hasPermission('profile-store-discount.delete'),
                'link' => route('store-discount.destroy',[
                    'store'  => $this->store,
                    'discount' => $this
                ])
            ]
        ];
    }

    public function acquiring()
    {
        return $this->hasOne(AcquiringMaster::class, 'acquiring_code', 'acquiring_code')->withDefault([
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

    public function store()
    {
        return $this->hasOne(StoreMaster::class, 'store_code', 'store_code')->withDefault([
            'store_code' => null,
            'store_name' => null
        ]);
    }

    public function getActiveAttribute()
    {
        return $this->expired_date >= date('Y-m-d') && $this->is_active;
    }
}
