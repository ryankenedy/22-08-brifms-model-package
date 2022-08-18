<?php

namespace App\Models\MM;

use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FunctionPasswordMaster extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $table = "master_function_password_v2";
    protected $primaryKey = 'code';
    protected $keyType = 'string';

    protected $fillable = [
        'code',
        'number',
        'password',
        'name',
    ];

    public function getGenerateCodeAttribute($value)
    {
        $code = IdGenerator::generate(['table' => $this->table, 'field' => 'code', 'length' => 5, 'prefix' => "FN"]);
        return $code;
    }

    public function getActionAttribute($value)
    {
        return [
            'edit' => [
                'isCan' => request()->user()->hasPermission('master-function-password.update'),
                'link' => route('function-password.edit',[
                    'function_password' => $this
                ]),
            ],
            'delete' => [
                'isCan' => request()->user()->hasPermission('master-function-password.delete'),
                'link' => route('function-password.destroy',[
                    'function_password' => $this
                ])
            ]
        ];
    }
}
