<?php

namespace App\Models\MM;

use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MerchantCicilanPlan extends Model
{
    use HasFactory, ModelTrait;

    protected $connection = 'mysql';
    protected $table = "cicilan_merchant_mapping_plan";
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'merchant_code',
        'acq_code',
        'plan_code',
    ];

    public function acquiring()
    {
        return $this->hasOne(AcquiringMaster::class, 'acquiring_code', 'acq_code')->withDefault([
            'acquiring_code' => null,
            'acquiring_name' => null
        ]);
    }

    public function plan()
    {
        return $this->hasOne(InstallmentPlanMaster::class, 'plan_code', 'plan_code')->withDefault([
            'plan_code' => null,
            'plan_name' => null
        ]);
    }

    public function getActionAttribute($value)
    {
        return [
            'delete' => [
                'isCan' => request()->user()->hasPermission('profile-merchant-installment-plan.delete'),
                'link' => route('merchant-installment.destroy-plan',[
                    'merchant'  => $this->merchant,
                    'installment_plan' => $this
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
