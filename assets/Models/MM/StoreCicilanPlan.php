<?php

namespace App\Models\MM;

use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreCicilanPlan extends Model
{
    use HasFactory, ModelTrait;

    protected $connection = 'mysql';
    protected $table = "cicilan_maping_plan";
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'store_code',
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
            'plan_name'  => null
        ]);
    }

    public function getActionAttribute($value)
    {
        return [
            'delete' => [
                'isCan' => request()->user()->hasPermission('profile-store-installment-plan.delete'),
                'link' => route('store-installment.destroy-plan',[
                    'store'  => $this->store,
                    'installment_plan' => $this
                ])
            ]
        ];
    }

    public function store()
    {
        return $this->hasOne(StoreMaster::class, 'store_code', 'store_code')->withDefault([
            'store_code' => null,
            'store_name'  => null
        ]);
    }
}
