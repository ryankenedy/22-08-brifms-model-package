<?php

namespace App\Models\MM;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InstallmentPlanMaster extends Model
{
    use HasFactory;
    
    protected $connection = 'mysql';
    protected $table = "cicilan_plan";
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'plan_code',
        'plan_name',
        'plan_description',
        'version',
        'created_date',
    ];

    public function getActionAttribute($value)
    {
        return [
            'edit' => [
                'isCan' => request()->user()->hasPermission('master-installment.update'),
                'link' => route('installment-plan.edit',['installment_plan' => $this]),
            ],
            'delete' => [
                'isCan' => request()->user()->hasPermission('master-installment.delete'),
                'link' => route('installment-plan.destroy',['installment_plan' => $this])
            ]
        ];
    }

}

