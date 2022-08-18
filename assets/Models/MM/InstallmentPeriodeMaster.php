<?php

namespace App\Models\MM;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InstallmentPeriodeMaster extends Model
{
    use HasFactory;
    
    protected $connection = 'mysql';
    protected $table = "cicilan_periode";
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'periode_code',
        'name',
        'version',
        'created_date'
    ];

    public function getActionAttribute($value)
    {
        return [
            'edit' => [
                'isCan' => request()->user()->hasPermission('master-installment.update'),
                'link' => route('installment-periode.edit',['installment_periode' => $this]),
            ],
            'delete' => [
                'isCan' => request()->user()->hasPermission('master-installment.delete'),
                'link' => route('installment-periode.destroy',['installment_periode' => $this])
            ]
        ];
    }

}
