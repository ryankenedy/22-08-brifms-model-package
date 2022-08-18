<?php

namespace App\Models\MM;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KcpMaster extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $table = "coverage_kcp";
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'code',
        'name',
        'is_active',
        'created_at',
        'kcp_pic',
        'kcp_pic_phone',
        'company_code',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    public function getGenerateCodeAttribute($value)
    {
        $code = IdGenerator::generate(['table' => $this->table, 'field' => 'code', 'length' => 5, 'prefix' => "P"]);
        return $code;
    }

    public function getActionAttribute($value)
    {
        return [
            'edit' => [
                'isCan' => Auth::user()->hasPermission('master-kcp.update'),
                'link' => route('kcp.edit',[
                    'kcp' => $this
                ]),
            ],
            'delete' => [
                'isCan' => Auth::user()->hasPermission('master-kcp.delete'),
                'link' => route('kcp.destroy',[
                    'kcp' => $this
                ])
            ]
        ];
    }
}
