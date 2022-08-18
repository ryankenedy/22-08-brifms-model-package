<?php

namespace App\Models\MM;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KanwilMaster extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $table = "coverage_kanwil";
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
        $code = IdGenerator::generate(['table' => $this->table, 'field' => 'code', 'length' => 5, 'prefix' => "K"]);
        return $code;
    }

    public function getActionAttribute($value)
    {
        return [
            'edit' => [
                'isCan' => Auth::user()->hasPermission('master-kanwil.update'),
                'link' => route('kanwil.edit',[
                    'kanwil' => $this
                ]),
            ],
            'delete' => [
                'isCan' => Auth::user()->hasPermission('master-kanwil.delete'),
                'link' => route('kanwil.destroy',[
                    'kanwil' => $this
                ])
            ]
        ];
    }
}
