<?php

namespace App\Models\MM;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AreaMaster extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $table = "coverage_area";
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'code',
        'name',
        'is_active',
        'created_at',
        'company_code',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    public function getGenerateCodeAttribute($value)
    {
        $code = IdGenerator::generate(['table' => $this->table, 'field' => 'code', 'length' => 5, 'prefix' => "A"]);
        return $code;
    }

    public function getActionAttribute($value)
    {
        return [
            'edit' => [
                'isCan' => Auth::user()->hasPermission('master-area.update'),
                'link' => route('area.edit',[
                    'area' => $this
                ]),
            ],
            'delete' => [
                'isCan' => Auth::user()->hasPermission('master-area.delete'),
                'link' => route('area.destroy',[
                    'area' => $this
                ])
            ]
        ];
    }
}
