<?php

namespace App\Models\MM;

use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreCicilanPeriode extends Model
{
    use HasFactory, ModelTrait;

    protected $connection = 'mysql';
    protected $table = "cicilan_maping_periode";
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'store_code',
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
            'periode_code' => null,
            'name'  => null
        ]);
    }

    public function getActionAttribute($value)
    {
        return [
            'delete' => [
                'isCan' => request()->user()->hasPermission('profile-store-installment-periode.delete'),
                'link' => route('store-installment.destroy-periode',[
                    'store'  => $this->store,
                    'installment_periode' => $this
                ])
            ]
        ];
    }

    public function store()
    {
        return $this->hasOne(StoreMaster::class, 'store_code', 'store_code')->withDefault([
            'store_code' => null,
            'store_name' => null
        ]);
    }
}
