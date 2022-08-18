<?php

namespace App\Models\MM;

use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MerchantCicilanPeriode extends Model
{
    use HasFactory, ModelTrait;

    protected $connection = 'mysql';
    protected $table = "cicilan_merchant_mapping_periode";
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'merchant_code',
        'acq_code',
        'periode_code',
    ];

    public function acquiring()
    {
        return $this->hasOne(AcquiringMaster::class, 'acquiring_code', 'acq_code')->withDefault([
            'acquiring_code' => null,
            'acquiring_name' => null
        ]);
    }

    public function periode()
    {
        return $this->hasOne(InstallmentPeriodeMaster::class, 'periode_code', 'periode_code')->withDefault([
            'name' => null,
            'periode_code' => null
        ]);
    }

    public function getActionAttribute($value)
    {
        return [
            'delete' => [
                'isCan' => request()->user()->hasPermission('profile-merchant-installment-periode.delete'),
                'link' => route('merchant-installment.destroy-periode',[
                    'merchant'  => $this->merchant,
                    'installment_periode' => $this
                ])
            ]
        ];
    }

    public function merchant()
    {
        return $this->hasOne(MerchantMaster::class, 'merchant_code', 'merchant_code')->withDefault([
            'merchant_code' => null,
            'merchant_name' => null
        ]);
    }
}
