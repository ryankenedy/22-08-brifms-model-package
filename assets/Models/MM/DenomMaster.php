<?php

namespace App\Models\MM;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DenomMaster extends Model
{
    use HasFactory;
    
    protected $connection = 'mysql';
    protected $table = "denom_value";
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'denom_code',
        'denom_name',
        'denom_value'
    ];

    public function getGenerateCodeAttribute($value)
    {
        $code = IdGenerator::generate(['table' => $this->table, 'field' => 'denom_code', 'length' => 10, 'prefix' => "DN", 'reset_on_prefix_change' => true]);
        return $code;
    }

    public function getActionAttribute($value)
    {
        return [
            'edit' => [
                'isCan' => request()->user()->hasPermission('master-denom.update'),
                'link' => route('denom.edit',['denom' => $this]),
            ],
            'delete' => [
                'isCan' => request()->user()->hasPermission('master-denom.delete'),
                'link' => route('denom.destroy',['denom' => $this])
            ]
        ];
    }

}
